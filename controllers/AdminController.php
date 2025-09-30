<?php
declare(strict_types=1);

final class AdminController {
	private PDO $pdo;

	public function __construct(PDO $pdo) {
		$this->pdo = $pdo;
	}

	private function requireAuth(): void {
		if (empty($_SESSION['admin'])) {
			header('Location: index.php?r=admin/login');
			exit;
		}
	}

	public function login(): void {
		view('admin/login');
	}

	public function authenticate(): void {
		if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
			header('Location: index.php?r=admin/login');
			return;
		}
		$pwd = (string)($_POST['password'] ?? '');
		if ($pwd === ADMIN_PASSWORD) {
			$_SESSION['admin'] = true;
			header('Location: index.php?r=admin');
			return;
		}
		$_SESSION['flash'] = 'Invalid password';
		header('Location: index.php?r=admin/login');
	}

	public function logout(): void {
		unset($_SESSION['admin']);
		header('Location: index.php?r=admin/login');
	}

	public function dashboard(): void {
		$this->requireAuth();
		$stats = [
			'flights' => (int)$this->pdo->query('SELECT COUNT(*) FROM flights')->fetchColumn(),
			'bookings' => (int)$this->pdo->query('SELECT COUNT(*) FROM bookings')->fetchColumn(),
		];
		view('admin/dashboard', compact('stats'));
	}

	public function flightsIndex(): void {
		$this->requireAuth();
		$rows = $this->pdo->query('SELECT * FROM flights ORDER BY departure_time DESC')->fetchAll();
		view('admin/flights_index', ['flights' => $rows]);
	}

	public function flightsNew(): void {
		$this->requireAuth();
		view('admin/flights_form', ['flight' => null]);
	}

	public function flightsCreate(): void {
		$this->requireAuth();
		if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') { header('Location: index.php?r=admin/flights'); return; }
		$sql = 'INSERT INTO flights (flight_number, origin, destination, departure_time, arrival_time, price_cents, total_seats) VALUES (?, ?, ?, ?, ?, ?, ?)';
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute([
			trim((string)$_POST['flight_number'] ?? ''),
			trim((string)$_POST['origin'] ?? ''),
			trim((string)$_POST['destination'] ?? ''),
			trim((string)$_POST['departure_time'] ?? ''),
			trim((string)$_POST['arrival_time'] ?? ''),
			(int)($_POST['price_cents'] ?? 0),
			(int)($_POST['total_seats'] ?? 0),
		]);
		$_SESSION['flash'] = 'Flight created';
		header('Location: index.php?r=admin/flights');
	}

	public function flightsEdit(): void {
		$this->requireAuth();
		$id = (int)($_GET['id'] ?? 0);
		$stmt = $this->pdo->prepare('SELECT * FROM flights WHERE id = ?');
		$stmt->execute([$id]);
		$flight = $stmt->fetch();
		if (!$flight) { http_response_code(404); echo 'Not found'; return; }
		view('admin/flights_form', compact('flight'));
	}

	public function flightsUpdate(): void {
		$this->requireAuth();
		if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') { header('Location: index.php?r=admin/flights'); return; }
		$id = (int)($_POST['id'] ?? 0);
		$sql = 'UPDATE flights SET flight_number=?, origin=?, destination=?, departure_time=?, arrival_time=?, price_cents=?, total_seats=? WHERE id=?';
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute([
			trim((string)$_POST['flight_number'] ?? ''),
			trim((string)$_POST['origin'] ?? ''),
			trim((string)$_POST['destination'] ?? ''),
			trim((string)$_POST['departure_time'] ?? ''),
			trim((string)$_POST['arrival_time'] ?? ''),
			(int)($_POST['price_cents'] ?? 0),
			(int)($_POST['total_seats'] ?? 0),
			$id,
		]);
		$_SESSION['flash'] = 'Flight updated';
		header('Location: index.php?r=admin/flights');
	}

	public function flightsDelete(): void {
		$this->requireAuth();
		$id = (int)($_GET['id'] ?? 0);
		$stmt = $this->pdo->prepare('DELETE FROM flights WHERE id = ?');
		$stmt->execute([$id]);
		$_SESSION['flash'] = 'Flight deleted';
		header('Location: index.php?r=admin/flights');
	}

	public function bookingsIndex(): void {
		$this->requireAuth();
		$sql = 'SELECT b.id, b.passenger_name, b.seat_number, b.booked_at, b.confirmed, f.flight_number, f.origin, f.destination FROM bookings b JOIN flights f ON f.id = b.flight_id ORDER BY b.booked_at DESC';
		$rows = $this->pdo->query($sql)->fetchAll();
		view('admin/bookings_index', ['bookings' => $rows]);
	}

	public function bookingsConfirm(): void {
		$this->requireAuth();
		$id = (int)($_GET['id'] ?? 0);
		$bookingModel = new Booking($this->pdo);
		$booking = $bookingModel->find($id);
		$bookingModel->confirm($id);
		// Notify user if booking is associated with a user
		if ($booking && !empty($booking['user_id'])) {
			$userId = (int)$booking['user_id'];
			$flightNum = '';
			try {
				$stmt = $this->pdo->prepare('SELECT flight_number FROM flights WHERE id = ?');
				$stmt->execute([(int)$booking['flight_id']]);
				$row = $stmt->fetch();
				$flightNum = $row ? (string)$row['flight_number'] : '';
			} catch (Throwable $e) { /* ignore */ }
			$msg = 'Your booking #' . $id . ($flightNum ? (' for flight ' . $flightNum) : '') . ' has been confirmed.';
			(new Notification($this->pdo))->create($userId, $msg);
		}
		$_SESSION['flash'] = 'Booking confirmed';
		header('Location: index.php?r=admin/bookings');
	}

	public function bookingsNew(): void {
		$this->requireAuth();
		$flights = $this->pdo->query('SELECT id, flight_number FROM flights ORDER BY departure_time DESC')->fetchAll();
		view('admin/bookings_form', ['booking' => null, 'flights' => $flights]);
	}

	public function bookingsCreate(): void {
		$this->requireAuth();
		if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') { header('Location: index.php?r=admin/bookings'); return; }
		$flightId = (int)($_POST['flight_id'] ?? 0);
		$passenger = trim((string)($_POST['passenger_name'] ?? ''));
		$seat = $_POST['seat_number'] !== '' ? (int)$_POST['seat_number'] : null;
		try {
			$booking = new Booking($this->pdo);
			$booking->create($flightId, $passenger, $seat);
			$_SESSION['flash'] = 'Booking created';
		} catch (Throwable $e) {
			$_SESSION['flash'] = 'Error: ' . $e->getMessage();
		}
		header('Location: index.php?r=admin/bookings');
	}

	public function bookingsEdit(): void {
		$this->requireAuth();
		$id = (int)($_GET['id'] ?? 0);
		$booking = (new Booking($this->pdo))->find($id);
		if (!$booking) { http_response_code(404); echo 'Not found'; return; }
		$flights = $this->pdo->query('SELECT id, flight_number FROM flights ORDER BY departure_time DESC')->fetchAll();
		view('admin/bookings_form', compact('booking', 'flights'));
	}

	public function bookingsUpdate(): void {
		$this->requireAuth();
		if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') { header('Location: index.php?r=admin/bookings'); return; }
		$id = (int)($_POST['id'] ?? 0);
		$flightId = (int)($_POST['flight_id'] ?? 0);
		$passenger = trim((string)($_POST['passenger_name'] ?? ''));
		$seat = $_POST['seat_number'] !== '' ? (int)$_POST['seat_number'] : null;
		try {
			(new Booking($this->pdo))->update($id, $flightId, $passenger, $seat);
			$_SESSION['flash'] = 'Booking updated';
		} catch (Throwable $e) {
			$_SESSION['flash'] = 'Error: ' . $e->getMessage();
		}
		header('Location: index.php?r=admin/bookings');
	}

	public function bookingsDelete(): void {
		$this->requireAuth();
		$id = (int)($_GET['id'] ?? 0);
		(new Booking($this->pdo))->delete($id);
		$_SESSION['flash'] = 'Booking deleted';
		header('Location: index.php?r=admin/bookings');
	}

	public function usersIndex(): void {
		$this->requireAuth();
		$stmt = $this->pdo->query('SELECT id, email, first_name, last_name, country, avatar_url, created_at FROM users ORDER BY created_at DESC');
		$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
		view('admin/users_index', compact('users'));
	}

	public function usersDelete(): void {
		$this->requireAuth();
		$id = (int)($_GET['id'] ?? 0);
		if ($id > 0) {
			$stmt = $this->pdo->prepare('DELETE FROM users WHERE id = ?');
			$stmt->execute([$id]);
			$_SESSION['flash'] = 'User deleted successfully';
		}
		header('Location: index.php?r=admin/users');
	}
}


