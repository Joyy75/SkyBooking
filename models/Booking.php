<?php
declare(strict_types=1);

final class Booking {
	private PDO $pdo;

	public function __construct(PDO $pdo) {
		$this->pdo = $pdo;
	}

	public function seatsTaken(int $flightId): array {
		$stmt = $this->pdo->prepare('SELECT seat_number FROM bookings WHERE flight_id = ? ORDER BY seat_number');
		$stmt->execute([$flightId]);
		return array_map(fn($r) => (int)$r['seat_number'], $stmt->fetchAll());
	}

	public function seatStatuses(int $flightId): array {
		$stmt = $this->pdo->prepare('SELECT seat_number, confirmed FROM bookings WHERE flight_id = ?');
		$stmt->execute([$flightId]);
		$map = [];
		foreach ($stmt->fetchAll() as $row) {
			$map[(int)$row['seat_number']] = (int)$row['confirmed'] === 1 ? 'confirmed' : 'pending';
		}
		return $map;
	}

	public function create(int $flightId, string $passengerName, ?int $seatNumber, ?int $userId = null): int {
		$flightStmt = $this->pdo->prepare('SELECT id, total_seats FROM flights WHERE id = ?');
		$flightStmt->execute([$flightId]);
		$flight = $flightStmt->fetch();
		if (!$flight) {
			throw new RuntimeException('Flight not found');
		}

		$totalSeats = (int)$flight['total_seats'];
		$taken = $this->seatsTaken($flightId);

		if ($seatNumber !== null) {
			if ($seatNumber < 1 || $seatNumber > $totalSeats) {
				throw new InvalidArgumentException('Invalid seat number');
			}
			if (in_array($seatNumber, $taken, true)) {
				throw new RuntimeException('Seat already taken');
			}
			$selectedSeat = $seatNumber;
		} else {
			$selectedSeat = $this->firstAvailableSeat($totalSeats, $taken);
			if ($selectedSeat === null) {
				throw new RuntimeException('No seats available');
			}
		}

		$stmt = $this->pdo->prepare('INSERT INTO bookings (flight_id, passenger_name, seat_number, booked_at, confirmed, user_id) VALUES (?, ?, ?, ?, 0, ?)');
		$stmt->execute([$flightId, $passengerName, $selectedSeat, date('Y-m-d H:i:s'), $userId]);
		return (int)$this->pdo->lastInsertId();
	}

	public function find(int $id): ?array {
		$stmt = $this->pdo->prepare('SELECT * FROM bookings WHERE id = ?');
		$stmt->execute([$id]);
		$row = $stmt->fetch();
		return $row ?: null;
	}

	public function update(int $id, int $flightId, string $passengerName, ?int $seatNumber): void {
		$flightStmt = $this->pdo->prepare('SELECT id, total_seats FROM flights WHERE id = ?');
		$flightStmt->execute([$flightId]);
		$flight = $flightStmt->fetch();
		if (!$flight) {
			throw new RuntimeException('Flight not found');
		}
		$totalSeats = (int)$flight['total_seats'];
		$taken = $this->seatsTaken($flightId);
		// If updating existing, remove its current seat from taken set
		$current = $this->find($id);
		if (!$current) { throw new RuntimeException('Booking not found'); }
		$taken = array_values(array_filter($taken, fn($s) => (int)$s !== (int)$current['seat_number']));

		if ($seatNumber !== null) {
			if ($seatNumber < 1 || $seatNumber > $totalSeats) {
				throw new InvalidArgumentException('Invalid seat number');
			}
			if (in_array($seatNumber, $taken, true)) {
				throw new RuntimeException('Seat already taken');
			}
			$selectedSeat = $seatNumber;
		} else {
			$selectedSeat = $this->firstAvailableSeat($totalSeats, $taken);
			if ($selectedSeat === null) {
				throw new RuntimeException('No seats available');
			}
		}

		$stmt = $this->pdo->prepare('UPDATE bookings SET flight_id = ?, passenger_name = ?, seat_number = ? WHERE id = ?');
		$stmt->execute([$flightId, $passengerName, $selectedSeat, $id]);
	}

	public function delete(int $id): void {
		$stmt = $this->pdo->prepare('DELETE FROM bookings WHERE id = ?');
		$stmt->execute([$id]);
	}

	public function confirm(int $id): void {
		$stmt = $this->pdo->prepare('UPDATE bookings SET confirmed = 1 WHERE id = ?');
		$stmt->execute([$id]);
	}


	private function firstAvailableSeat(int $totalSeats, array $taken): ?int {
		$takenSet = array_fill_keys($taken, true);
		for ($i = 1; $i <= $totalSeats; $i++) {
			if (!isset($takenSet[$i])) {
				return $i;
			}
		}
		return null;
	}
}


