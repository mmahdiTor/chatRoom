<?php
include 'db.php';

if (!isset($_SESSION['loggedin'])) {
    http_response_code(403);
    exit("Access Denied");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['message'])) {
    $user = $_SESSION['username'];
    $msg = trim($_POST['message']);

    $stmt = $pdo->prepare("INSERT INTO messages (username, message) VALUES (?, ?)");
    $stmt->execute([$user, $msg]);

    echo json_encode(['status' => 'ok']);
}
?>
