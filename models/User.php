<?php
declare(strict_types=1);

final class User {
	private PDO $pdo;

	public function __construct(PDO $pdo) {
		$this->pdo = $pdo;
	}

	public function create(string $email, string $password, string $firstName, string $lastName, ?string $country = null): int {
		$hash = password_hash($password, PASSWORD_DEFAULT);
		$stmt = $this->pdo->prepare('INSERT INTO users (email, password_hash, first_name, last_name, country, created_at) VALUES (?, ?, ?, ?, ?, ?)');
		$stmt->execute([$email, $hash, $firstName, $lastName, $country, date('Y-m-d H:i:s')]);
		return (int)$this->pdo->lastInsertId();
	}

	public function findByEmail(string $email): ?array {
		$stmt = $this->pdo->prepare('SELECT * FROM users WHERE email = ?');
		$stmt->execute([$email]);
		return $stmt->fetch() ?: null;
	}

	public function find(int $id): ?array {
		$stmt = $this->pdo->prepare('SELECT * FROM users WHERE id = ?');
		$stmt->execute([$id]);
		return $stmt->fetch() ?: null;
	}

	public function verifyPassword(string $email, string $password): ?array {
		$user = $this->findByEmail($email);
		if (!$user || !password_verify($password, $user['password_hash'])) {
			return null;
		}
		return $user;
	}

	public function update(int $id, array $data): void {
		$allowed = ['first_name', 'last_name', 'country', 'avatar_url'];
		$fields = [];
		$values = [];
		foreach ($data as $key => $value) {
			if (in_array($key, $allowed, true)) {
				$fields[] = "$key = ?";
				$values[] = $value;
			}
		}
		if (empty($fields)) return;
		$values[] = $id;
		$sql = 'UPDATE users SET ' . implode(', ', $fields) . ' WHERE id = ?';
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute($values);
	}

	public function getBookings(int $userId): array {
		$stmt = $this->pdo->prepare('
			SELECT b.*, f.flight_number, f.origin, f.destination, f.departure_time, f.arrival_time, f.price_cents
			FROM bookings b 
			JOIN flights f ON f.id = b.flight_id 
			WHERE b.user_id = ? 
			ORDER BY b.booked_at DESC
		');
		$stmt->execute([$userId]);
		return $stmt->fetchAll();
	}
}
