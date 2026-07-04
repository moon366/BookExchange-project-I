<?php
require '../includes/auth_check.php';
header('Content-Type: application/json');
require '../config/db.php';

$data = json_decode(file_get_contents('php://input'), true);
$id = $data['id'] ?? 0;

$check = $pdo->prepare("SELECT * FROM books WHERE id = ? AND seller_id = ?");
$check->execute([$id, $_SESSION['user_id']]);
if (!$check->fetch()) {
    http_response_code(403);
    echo json_encode(['error' => 'Not your listing']);
    exit;
}

$stmt = $pdo->prepare("UPDATE books SET status = 'sold' WHERE id = ? AND seller_id = ?");
$stmt->execute([$id, $_SESSION['user_id']]);

echo json_encode(['success' => true]);
