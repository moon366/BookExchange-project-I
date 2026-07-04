<?php
require '../includes/auth_check.php';
header('Content-Type: application/json');
require '../config/db.php';

$data = json_decode(file_get_contents('php://input'), true);
$order_id = $data['order_id'] ?? 0;

$check = $pdo->prepare("SELECT * FROM orders WHERE id = ? AND seller_id = ? AND location_finalized = 0");
$check->execute([$order_id, $_SESSION['user_id']]);
$order = $check->fetch(PDO::FETCH_ASSOC);

if (!$order) {
    http_response_code(403);
    echo json_encode(['error' => 'Order not found or already finalized']);
    exit;
}

$stmt = $pdo->prepare("UPDATE orders SET location_finalized = 1, status = 'confirmed' WHERE id = ?");
$stmt->execute([$order_id]);

echo json_encode(['success' => true]);
