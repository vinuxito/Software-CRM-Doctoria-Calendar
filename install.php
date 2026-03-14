<?php
// Load Config
require_once 'config/config.php';

// Connect to MySQL server without selecting DB
try {
    $pdo = new PDO("mysql:host=" . DB_HOST, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Create Database if not exists
    $pdo->exec("CREATE DATABASE IF NOT EXISTS " . DB_NAME);
    echo "Database " . DB_NAME . " created or already exists.<br>";

    // Select Database
    $pdo->exec("USE " . DB_NAME);

    // Read SQL file
    $sql = file_get_contents(__DIR__ . '/setup.sql');

    // Split SQL by semicolon
    // Note: This is a simple split and might break on stored procedures or triggers with semicolons
    // But for simple CREATE TABLE statements it works
    $statements = array_filter(array_map('trim', explode(';', $sql)));

    foreach ($statements as $stmt) {
        if (!empty($stmt)) {
            $pdo->exec($stmt);
            echo "Executed SQL statement.<br>";
        }
    }

    echo "Installation complete. <a href='" . URLROOT . "'>Go to CRM</a>";

} catch (PDOException $e) {
    die("DB ERROR: " . $e->getMessage());
}
