<?php
declare(strict_types=1);

// Global configuration

define('DB_PATH', __DIR__ . '/../storage/airticket.sqlite');
define('ADMIN_PASSWORD', getenv('ADMIN_PASSWORD') ?: 'admin123');

// Ensure storage directory exists
$storageDir = dirname(DB_PATH);
if (!is_dir($storageDir)) {
	mkdir($storageDir, 0777, true);
}


