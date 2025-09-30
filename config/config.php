<?php
declare(strict_types=1);

// Global configuration

// Use persistent storage path for Wasmer/production or local path
define('DB_PATH', getenv('WASMER_STORAGE_PATH') 
    ? getenv('WASMER_STORAGE_PATH') . '/airticket.sqlite' 
    : __DIR__ . '/../storage/airticket.sqlite');
define('ADMIN_PASSWORD', getenv('ADMIN_PASSWORD') ?: 'admin123');

// Ensure storage directory exists
$storageDir = dirname(DB_PATH);
if (!is_dir($storageDir)) {
	mkdir($storageDir, 0777, true);
}


