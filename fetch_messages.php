<?php
include 'db.php';

// اگه لاگین نبود
if (!isset($_SESSION['loggedin'])) {
    http_response_code(403);
    echo json_encode([]);
    exit;
}

// فقط فیلدهای لازم + 100 پیام آخر
$stmt = $pdo->query("
    SELECT id, username, message, created_at
    FROM messages
    ORDER BY id ASC
    LIMIT 100
");

$messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

// هدر صحیح JSON
header('Content-Type: application/json; charset=utf-8');

// خروجی
echo json_encode($messages, JSON_UNESCAPED_UNICODE);
