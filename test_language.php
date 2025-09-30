<?php
// Quick language test
session_start();
require_once __DIR__ . '/config/languages.php';

// Set language if provided
if (isset($_GET['lang'])) {
    setLanguage($_GET['lang']);
}

$currentLang = getCurrentLanguage();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Language Test</title>
    <style>
        body { font-family: Arial; padding: 40px; }
        .test { background: #f0f0f0; padding: 20px; margin: 10px 0; border-radius: 8px; }
        a { display: inline-block; margin: 5px; padding: 10px 20px; background: #6366f1; color: white; text-decoration: none; border-radius: 5px; }
    </style>
</head>
<body>
    <h1>🌍 Language System Test</h1>
    
    <div class="test">
        <h2>Current Language: <?= $currentLang ?></h2>
    </div>
    
    <div class="test">
        <h3>Switch Language:</h3>
        <a href="?lang=en">🇺🇸 English</a>
        <a href="?lang=es">🇪🇸 Español</a>
        <a href="?lang=fr">🇫🇷 Français</a>
    </div>
    
    <div class="test">
        <h3>Translation Tests:</h3>
        <p><strong>Site Name:</strong> <?= t('site_name') ?></p>
        <p><strong>Find Flight:</strong> <?= t('find_flight') ?></p>
        <p><strong>Search Flights:</strong> <?= t('search_flights') ?></p>
        <p><strong>From:</strong> <?= t('from') ?></p>
        <p><strong>To:</strong> <?= t('to') ?></p>
        <p><strong>Book Flight:</strong> <?= t('book_flight') ?></p>
        <p><strong>My Tickets:</strong> <?= t('my_tickets') ?></p>
    </div>
    
    <div class="test">
        <h3>✅ If you see different text when clicking languages above, it's working!</h3>
        <p>Go back to your main site: <a href="index.php">Home Page</a></p>
    </div>
</body>
</html>
