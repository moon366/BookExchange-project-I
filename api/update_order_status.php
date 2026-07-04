<?php
require '../includes/auth_check.php';
header('Content-Type: application/json');
require '../config/db.php';

$data = json_decode(file_get_contents('php://input'), true);
$order_id = $data['order_id'] ?? 0;
$status = $data['status'] ?? '';

$allowed = ['confirmed', 'shipped', 'completed', 'cancelled'];
if (!in_array($status, $allowed)) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid status']);
    exit;
}

$check = $pdo->prepare("SELECT * FROM orders WHERE id = ? AND seller_id = ?");
$check->execute([$order_id, $_SESSION['user_id']]);
$order = $check->fetch(PDO::FETCH_ASSOC);

if (!$order) {
    http_response_code(403);
    echo json_encode(['error' => 'Not your order']);
    exit;
}

$pdo->beginTransaction();
try {
    $stmt = $pdo->prepare("UPDATE orders SET status = ? WHERE id = ?");
    $stmt->execute([$status, $order_id]);

    if ($status === 'cancelled') {
        $stmt = $pdo->prepare("UPDATE books SET status = 'available' WHERE id = ?");
        $stmt->execute([$order['book_id']]);
    } elseif ($status === 'completed') {
        $stmt = $pdo->prepare("UPDATE books SET status = 'sold' WHERE id = ?");
        $stmt->execute([$order['book_id']]);
    }

    $pdo->commit();
    echo json_encode(['success' => true]);
} catch (Exception $e) {
    $pdo->rollBack();
    http_response_code(500);
    echo json_encode(['error' => 'Update failed']);
}
