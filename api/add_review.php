<?php
require '../includes/auth_check.php';
header('Content-Type: application/json');
require '../config/db.php';

$data = json_decode(file_get_contents('php://input'), true);
$order_id = $data['order_id'] ?? 0;
$rating = (int)($data['rating'] ?? 0);
$comment = trim($data['comment'] ?? '');

if ($rating < 1 || $rating > 5) {
    http_response_code(400);
    echo json_encode(['error' => 'Rating must be between 1 and 5']);
    exit;
}

// Confirm this order belongs to the logged-in buyer and is completed
$check = $pdo->prepare("SELECT * FROM orders WHERE id = ? AND buyer_id = ? AND status = 'completed'");
$check->execute([$order_id, $_SESSION['user_id']]);
$order = $check->fetch(PDO::FETCH_ASSOC);

if (!$order) {
    http_response_code(403);
    echo json_encode(['error' => 'Order not found or not completed yet']);
    exit;
}

// Prevent duplicate reviews on the same order
$dupe = $pdo->prepare("SELECT id FROM reviews WHERE order_id = ? AND reviewer_id = ?");
$dupe->execute([$order_id, $_SESSION['user_id']]);
if ($dupe->fetch()) {
    http_response_code(409);
    echo json_encode(['error' => 'You already reviewed this order']);
    exit;
}

$stmt = $pdo->prepare("INSERT INTO reviews (order_id, reviewer_id, rating, comment) VALUES (?, ?, ?, ?)");
$stmt->execute([$order_id, $_SESSION['user_id'], $rating, $comment]);

echo json_encode(['success' => true, 'review_id' => $pdo->lastInsertId()]);