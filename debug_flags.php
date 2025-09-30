<?php
session_start();
require_once 'config/languages.php';

echo "<!DOCTYPE html><html><head><meta charset='UTF-8'><title>Flag Test</title></head><body>";
echo "<h1>Flag Emoji Test</h1>";
echo "<h2>Current Language: " . getCurrentLanguage() . "</h2>";
echo "<h2>Current Flag: " . getAvailableLanguages()[getCurrentLanguage()]['flag'] . "</h2>";
echo "<h2>All Languages:</h2><ul>";
foreach (getAvailableLanguages() as $code => $lang) {
    echo "<li>" . $lang['flag'] . " " . $lang['name'] . " (" . $code . ")</li>";
}
echo "</ul>";
echo "<p><a href='index.php'>Go to Main Site</a></p>";
echo "</body></html>";
?>
