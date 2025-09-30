<?php
// File: setup_database.php
if (isset($_POST['setup'])) {
    // Database configuration
    $host = 'localhost';
    $user = 'joyy';
    $pass = 'joyy7520#';
    $dbname = 'skybooking';

    try {
        // Connect to MySQL (without database)
        $pdo = new PDO("mysql:host=$host", $user, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Create database if not exists
        $pdo->exec("CREATE DATABASE IF NOT EXISTS `$dbname` 
                   CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
        $output[] = "✅ Database created successfully";
        
        // Connect to the database
        $pdo->exec("USE `$dbname`");
        
        // Create tables
        $tables = [
            'users' => "CREATE TABLE IF NOT EXISTS users (
                id INT AUTO_INCREMENT PRIMARY KEY,
                email VARCHAR(255) UNIQUE NOT NULL,
                password_hash VARCHAR(255) NOT NULL,
                first_name VARCHAR(100) NOT NULL,
                last_name VARCHAR(100) NOT NULL,
                country VARCHAR(100),
                avatar_url VARCHAR(500),
                created_at DATETIME NOT NULL,
                INDEX idx_email (email)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",
            
            'flights' => "CREATE TABLE IF NOT EXISTS flights (
                id INT AUTO_INCREMENT PRIMARY KEY,
                flight_number VARCHAR(50) NOT NULL,
                origin VARCHAR(100) NOT NULL,
                destination VARCHAR(100) NOT NULL,
                departure_time DATETIME NOT NULL,
                arrival_time DATETIME NOT NULL,
                price_cents INT NOT NULL,
                total_seats INT NOT NULL,
                INDEX idx_route (origin, destination),
                INDEX idx_departure (departure_time)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",
            
            'bookings' => "CREATE TABLE IF NOT EXISTS bookings (
                id INT AUTO_INCREMENT PRIMARY KEY,
                flight_id INT NOT NULL,
                passenger_name VARCHAR(200) NOT NULL,
                seat_number INT NOT NULL,
                booked_at DATETIME NOT NULL,
                confirmed TINYINT NOT NULL DEFAULT 0,
                user_id INT,
                UNIQUE KEY unique_seat (flight_id, seat_number),
                FOREIGN KEY (flight_id) REFERENCES flights(id) ON DELETE CASCADE,
                FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
                INDEX idx_user (user_id)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",
            
            'notifications' => "CREATE TABLE IF NOT EXISTS notifications (
                id INT AUTO_INCREMENT PRIMARY KEY,
                user_id INT NOT NULL,
                message TEXT NOT NULL,
                is_read TINYINT NOT NULL DEFAULT 0,
                created_at DATETIME NOT NULL,
                FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
                INDEX idx_user_read (user_id, is_read)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci"
        ];

        // Execute table creation
        foreach ($tables as $name => $sql) {
            $pdo->exec($sql);
            $output[] = "✅ Created table: $name";
        }

        // Insert sample flights
        $sampleFlights = [
            ['AT100', 'New York', 'London', '2025-10-01 09:00:00', '2025-10-01 21:00:00', 79900, 120],
            ['AT200', 'London', 'Paris', '2025-10-02 10:30:00', '2025-10-02 12:00:00', 19900, 80],
            ['AT300', 'Paris', 'Rome', '2025-10-03 14:00:00', '2025-10-03 16:00:00', 15900, 100],
            ['AT400', 'Tokyo', 'Singapore', '2025-10-04 08:00:00', '2025-10-04 14:30:00', 59900, 150],
            ['AT500', 'Sydney', 'Auckland', '2025-10-05 11:00:00', '2025-10-05 16:00:00', 29900, 90]
        ];

        $stmt = $pdo->prepare("INSERT INTO flights 
            (flight_number, origin, destination, departure_time, arrival_time, price_cents, total_seats) 
            VALUES (?, ?, ?, ?, ?, ?, ?)");
        
        $pdo->beginTransaction();
        foreach ($sampleFlights as $flight) {
            $stmt->execute($flight);
        }
        $pdo->commit();
        
        $output[] = "✅ Added sample flights";
        $success = true;
        
    } catch(PDOException $e) {
        $error = "Database Error: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Database Setup</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 800px; margin: 0 auto; padding: 20px; }
        .btn { 
            background: #4CAF50; 
            color: white; 
            padding: 10px 20px; 
            border: none; 
            border-radius: 4px; 
            cursor: pointer; 
            font-size: 16px;
            margin: 20px 0;
        }
        .btn:hover { background: #45a049; }
        .output { 
            background: #f5f5f5; 
            padding: 15px; 
            border-radius: 4px; 
            margin-top: 20px;
            white-space: pre-wrap;
            font-family: monospace;
        }
        .success { color: #4CAF50; }
        .error { color: #f44336; }
    </style>
</head>
<body>
    <h1>Database Setup</h1>
    <p>Click the button below to set up your database.</p>
    
    <form method="post">
        <button type="submit" name="setup" class="btn">Setup Database</button>
    </form>

    <?php if (isset($success) && $success): ?>
        <div class="output success">
            <h3>✅ Database Setup Completed Successfully!</h3>
            <?php foreach ($output as $line): ?>
                <div><?php echo $line; ?></div>
            <?php endforeach; ?>
        </div>
    <?php elseif (isset($error)): ?>
        <div class="output error">
            <h3>❌ Error</h3>
            <div><?php echo $error; ?></div>
        </div>
    <?php endif; ?>
</body>
</html>