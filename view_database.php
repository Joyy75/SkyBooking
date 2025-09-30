<?php

// Simple database viewer
require_once __DIR__ . '/config/database.php';

$pdo = db();

echo "<!DOCTYPE html>
<html>
<head>
    <title>Database Viewer</title>
    <style>
        body { font-family: Arial; padding: 20px; background: #f5f5f5; }
        h2 { color: #333; border-bottom: 2px solid #4CAF50; padding-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; margin: 20px 0; background: white; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        th { background: #4CAF50; color: white; padding: 12px; text-align: left; }
        td { padding: 10px; border-bottom: 1px solid #ddd; }
        tr:hover { background: #f5f5f5; }
        .count { color: #4CAF50; font-weight: bold; }
    </style>
</head>
<body>
    <h1>🗄️ SkyBooking Database Viewer</h1>";

// Users
try {
    $userCount = $pdo->query('SELECT COUNT(*) FROM users')->fetchColumn();
    echo "<h2>👥 Users (<span class='count'>" . $userCount . "</span>)</h2>";
    echo "<table><tr><th>ID</th><th>Email</th><th>Name</th><th>Country</th><th>Created</th></tr>";
    $users = $pdo->query('SELECT * FROM users ORDER BY id DESC')->fetchAll();
    foreach ($users as $u) {
        echo "<tr>
            <td>{$u['id']}</td>
            <td>{$u['email']}</td>
            <td>{$u['first_name']} {$u['last_name']}</td>
            <td>" . ($u['country'] ?: '-') . "</td>
            <td>{$u['created_at']}</td>
        </tr>";
    }
    echo "</table>";
} catch (Exception $e) {
    echo "<p style='color:red;'>Users table not found.</p>";
}

// Flights
try {
    $flightCount = $pdo->query('SELECT COUNT(*) FROM flights')->fetchColumn();
    echo "<h2>✈️ Flights (<span class='count'>" . $flightCount . "</span>)</h2>";
    echo "<table><tr><th>ID</th><th>Flight #</th><th>Route</th><th>Departure</th><th>Price</th><th>Seats</th></tr>";
    $flights = $pdo->query('SELECT * FROM flights ORDER BY id')->fetchAll();
    foreach ($flights as $f) {
        echo "<tr>
            <td>{$f['id']}</td>
            <td><strong>{$f['flight_number']}</strong></td>
            <td>{$f['origin']} → {$f['destination']}</td>
            <td>{$f['departure_time']}</td>
            <td>$" . number_format($f['price_cents'] / 100, 2) . "</td>
            <td>{$f['total_seats']}</td>
        </tr>";
    }
    echo "</table>";
} catch (Exception $e) {
    echo "<p style='color:red;'>Flights table not found.</p>";
}

// Bookings
try {
    $bookingCount = $pdo->query('SELECT COUNT(*) FROM bookings')->fetchColumn();
    echo "<h2>🎫 Bookings (<span class='count'>" . $bookingCount . "</span>)</h2>";
    echo "<table><tr><th>ID</th><th>Flight</th><th>Passenger</th><th>Seat</th><th>Status</th><th>Booked At</th></tr>";
    $bookings = $pdo->query('
        SELECT b.*, f.flight_number 
        FROM bookings b 
        LEFT JOIN flights f ON b.flight_id = f.id 
        ORDER BY b.id DESC
    ')->fetchAll();
    foreach ($bookings as $b) {
        $status = $b['confirmed'] ? '<span style="color:green">✓ Confirmed</span>' : '<span style="color:orange">⏳ Pending</span>';
        echo "<tr>
            <td>{$b['id']}</td>
            <td>{$b['flight_number']}</td>
            <td>{$b['passenger_name']}</td>
            <td>#{$b['seat_number']}</td>
            <td>{$status}</td>
            <td>{$b['booked_at']}</td>
        </tr>";
    }
    echo "</table>";
} catch (Exception $e) {
    echo "<p style='color:red;'>Bookings table not found.</p>";
}

// Notifications
try {
    $notifCount = $pdo->query('SELECT COUNT(*) FROM notifications')->fetchColumn();
    echo "<h2>🔔 Notifications (<span class='count'>" . $notifCount . "</span>)</h2>";
    echo "<table><tr><th>ID</th><th>User ID</th><th>Message</th><th>Read</th><th>Created</th></tr>";
    $notifs = $pdo->query('SELECT * FROM notifications ORDER BY id DESC LIMIT 20')->fetchAll();
    foreach ($notifs as $n) {
        $read = $n['is_read'] ? '✓' : '✗';
        echo "<tr>
            <td>{$n['id']}</td>
            <td>{$n['user_id']}</td>
            <td>{$n['message']}</td>
            <td>{$read}</td>
            <td>{$n['created_at']}</td>
        </tr>";
    }
    echo "</table>";
} catch (Exception $e) {
    echo "<p style='color:red;'>Notifications table not found.</p>";
}

echo "</body></html>";