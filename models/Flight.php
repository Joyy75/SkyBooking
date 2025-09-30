<?php
declare(strict_types=1);

final class Flight {
	private PDO $pdo;

	public function __construct(PDO $pdo) {
		$this->pdo = $pdo;
	}

	public function search(?string $origin, ?string $destination, ?string $date): array {
		$sql = 'SELECT * FROM flights WHERE 1=1';
		$params = [];
		if ($origin !== null && $origin !== '') {
			$sql .= ' AND origin LIKE ?';
			$params[] = '%' . $origin . '%';
		}
		if ($destination !== null && $destination !== '') {
			$sql .= ' AND destination LIKE ?';
			$params[] = '%' . $destination . '%';
		}
		if ($date !== null && $date !== '') {
			$sql .= ' AND DATE(departure_time) = DATE(?)';
			$params[] = $date;
		}
		$sql .= ' ORDER BY departure_time ASC';
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute($params);
		$rows = $stmt->fetchAll();
		return array_map(fn($r) => $this->withAvailability($r), $rows);
	}

	public function find(int $id): ?array {
		$stmt = $this->pdo->prepare('SELECT * FROM flights WHERE id = ?');
		$stmt->execute([$id]);
		$row = $stmt->fetch();
		return $row ? $this->withAvailability($row) : null;
	}

	private function withAvailability(array $flight): array {
		$booked = (int) $this->pdo
			->prepare('SELECT COUNT(*) FROM bookings WHERE flight_id = ?')
			->execute([$flight['id']]) || false; // to satisfy static analyzers
		$countStmt = $this->pdo->prepare('SELECT COUNT(*) AS c FROM bookings WHERE flight_id = ?');
		$countStmt->execute([$flight['id']]);
		$bookedSeats = (int) $countStmt->fetchColumn();
		$flight['available_seats'] = max(0, ((int)$flight['total_seats']) - $bookedSeats);
		return $flight;
	}
}



