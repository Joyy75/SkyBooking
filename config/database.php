<?php
declare(strict_types=1);

require_once __DIR__ . '/config.php';

function db(): PDO {
	static $pdo = null;
	if ($pdo instanceof PDO) {
		return $pdo;
	}
	$dsn = 'sqlite:' . DB_PATH;
	$pdo = new PDO($dsn);
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

	// Initialize schema if empty
	initialize_schema($pdo);
	return $pdo;
}

function initialize_schema(PDO $pdo): void {
	$pdo->exec('CREATE TABLE IF NOT EXISTS flights (
		id INTEGER PRIMARY KEY AUTOINCREMENT,
		flight_number TEXT NOT NULL,
		origin TEXT NOT NULL,
		destination TEXT NOT NULL,
		departure_time TEXT NOT NULL,
		arrival_time TEXT NOT NULL,
		price_cents INTEGER NOT NULL,
		total_seats INTEGER NOT NULL
	)');

	$pdo->exec('CREATE TABLE IF NOT EXISTS bookings (
		id INTEGER PRIMARY KEY AUTOINCREMENT,
		flight_id INTEGER NOT NULL,
		passenger_name TEXT NOT NULL,
		seat_number INTEGER NOT NULL,
		booked_at TEXT NOT NULL,
		confirmed INTEGER NOT NULL DEFAULT 0,
		user_id INTEGER,
		UNIQUE(flight_id, seat_number),
		FOREIGN KEY(flight_id) REFERENCES flights(id) ON DELETE CASCADE,
		FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE SET NULL
	)');

	$pdo->exec('CREATE TABLE IF NOT EXISTS users (
		id INTEGER PRIMARY KEY AUTOINCREMENT,
		email TEXT UNIQUE NOT NULL,
		password_hash TEXT NOT NULL,
		first_name TEXT NOT NULL,
		last_name TEXT NOT NULL,
		country TEXT,
		avatar_url TEXT,
		created_at TEXT NOT NULL
	)');

	// Notifications table for user alerts (e.g., booking confirmation)
	$pdo->exec('CREATE TABLE IF NOT EXISTS notifications (
		id INTEGER PRIMARY KEY AUTOINCREMENT,
		user_id INTEGER NOT NULL,
		message TEXT NOT NULL,
		is_read INTEGER NOT NULL DEFAULT 0,
		created_at TEXT NOT NULL,
		FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE CASCADE
	)');

	// Safe migration: ensure confirmed column exists
	$cols = $pdo->query("PRAGMA table_info(bookings)")->fetchAll();
	$hasConfirmed = false;
	foreach ($cols as $col) {
		if (isset($col['name']) && $col['name'] === 'confirmed') { $hasConfirmed = true; break; }
	}
	if (!$hasConfirmed) {
		$pdo->exec('ALTER TABLE bookings ADD COLUMN confirmed INTEGER NOT NULL DEFAULT 0');
	}

	// Safe migration: ensure user_id column exists in bookings
	$cols = $pdo->query("PRAGMA table_info(bookings)")->fetchAll();
	$hasUserId = false;
	foreach ($cols as $col) {
		if (isset($col['name']) && $col['name'] === 'user_id') { $hasUserId = true; break; }
	}
	if (!$hasUserId) {
		$pdo->exec('ALTER TABLE bookings ADD COLUMN user_id INTEGER REFERENCES users(id) ON DELETE SET NULL');
	}

	// Seed minimal data if empty
	$count = (int) $pdo->query('SELECT COUNT(*) AS c FROM flights')->fetchColumn();
	if ($count === 0) {
		$seed = $pdo->prepare('INSERT INTO flights (flight_number, origin, destination, departure_time, arrival_time, price_cents, total_seats) VALUES (?, ?, ?, ?, ?, ?, ?)');
		$flights = [
			['AT100', 'New York', 'London', '2025-10-01 09:00', '2025-10-01 21:00', 79900, 120],
			['AT200', 'London', 'Paris', '2025-10-02 10:30', '2025-10-02 12:00', 19900, 80],
			['AT300', 'Paris', 'Rome', '2025-10-03 14:00', '2025-10-03 16:00', 15900, 100],
			['AT400', 'Tokyo', 'San Francisco', '2025-10-05 08:00', '2025-10-05 20:00', 99900, 150],
			['BA606', 'London ', 'New York', '2025-10-20 14:00:00', '2025-10-20 17:30:00', 75000, 250],
			['BA606', 'London (LHR)', 'New York (JFK)', '2025-10-20 14:00:00', '2025-10-20 17:30:00', 75000, 250],
['AF707', 'Paris (CDG)', 'Tokyo (NRT)', '2025-10-21 11:00:00', '2025-10-22 06:30:00', 95000, 300],
['EK808', 'Dubai (DXB)', 'Singapore (SIN)', '2025-10-22 03:00:00', '2025-10-22 14:30:00', 68000, 380],
['LH909', 'Frankfurt (FRA)', 'Sydney (SYD)', '2025-10-23 22:00:00', '2025-10-25 06:00:00', 125000, 340],
['QF010', 'Sydney (SYD)', 'Los Angeles (LAX)', '2025-10-24 10:00:00', '2025-10-24 06:30:00', 98000, 320],



		];
		foreach ($flights as $f) {
			$seed->execute($f);
		}
	}
}


