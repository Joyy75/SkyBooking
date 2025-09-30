<?php
declare(strict_types=1);

final class BookingController {
	private PDO $pdo;

	public function __construct(PDO $pdo) {
		$this->pdo = $pdo;
	}

	public function create(): void {
		if (empty($_SESSION['user_id'])) {
			header('Location: index.php?r=auth/login');
			return;
		}
		$flightId = isset($_GET['flight_id']) ? (int)$_GET['flight_id'] : 0;
		$flightModel = new Flight($this->pdo);
		$bookingModel = new Booking($this->pdo);
		$flight = $flightModel->find($flightId);
		if (!$flight) {
			http_response_code(404);
			echo 'Flight not found';
			return;
		}
		$takenSeats = $bookingModel->seatsTaken($flightId);
		view('bookings/create', compact('flight', 'takenSeats'));
	}

	public function store(): void {
		if (empty($_SESSION['user_id'])) {
			header('Location: index.php?r=auth/login');
			return;
		}
		if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
			http_response_code(405);
			echo 'Method not allowed';
			return;
		}
		$flightId = (int)($_POST['flight_id'] ?? 0);
		$passenger = trim((string)($_POST['passenger_name'] ?? ''));
		$seat = $_POST['seat_number'] !== '' ? (int)$_POST['seat_number'] : null;
		try {
			$booking = new Booking($this->pdo);
			$bookingId = $booking->create($flightId, $passenger, $seat, (int)$_SESSION['user_id']);
			$_SESSION['flash'] = 'Booking confirmed. Reference #' . $bookingId;
			header('Location: index.php?r=flights/details&id=' . $flightId);
			return;
		} catch (Throwable $e) {
			$_SESSION['flash'] = 'Error: ' . $e->getMessage();
			header('Location: index.php?r=bookings/create&flight_id=' . $flightId);
			return;
		}
	}
}



