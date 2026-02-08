<?php
session_start();
date_default_timezone_set('Asia/Tehran');
$db_file = 'chat_database.db';


try {
    $pdo = new PDO("sqlite:" . __DIR__ . "/" . $db_file);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $pdo->exec("CREATE TABLE IF NOT EXISTS messages (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        username TEXT NOT NULL,
        message TEXT NOT NULL,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )");
} catch (PDOException $e) {
    die("Error connecting to database: " . $e->getMessage());
}
?>
