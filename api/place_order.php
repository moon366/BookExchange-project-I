<?php
require '../includes/auth_check.php';
header('Content-Type: application/json');
require '../config/db.php';

$data = json_decode(file_get_contents('php://input'), true);
$book_id = $data['book_id'] ?? 0;
$delivery_location = trim($data['delivery_location'] ?? '');

if (!$delivery_location) {
    http_response_code(400);
    echo json_encode(['error' => 'Delivery location is required']);
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM books WHERE id = ? AND status = 'available'");
$stmt->execute([$book_id]);
$book = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$book) {
    http_response_code(404);
    echo json_encode(['error' => 'Book not available']);
    exit;
}

if ($book['seller_id'] == $_SESSION['user_id']) {
    http_response_code(400);
    echo json_encode(['error' => 'Cannot buy your own book']);
    exit;
}

$pdo->beginTransaction();
try {
    $stmt = $pdo->prepare("INSERT INTO orders (book_id, buyer_id, seller_id, price, delivery_location, status)
                            VALUES (?, ?, ?, ?, ?, 'pending')");
    $stmt->execute([$book_id, $_SESSION['user_id'], $book['seller_id'], $book['price'], $delivery_location]);
    $order_id = $pdo->lastInsertId();

    $stmt = $pdo->prepare("UPDATE books SET status = 'pending' WHERE id = ?");
    $stmt->execute([$book_id]);

    $pdo->commit();
    echo json_encode(['success' => true, 'order_id' => $order_id]);
} catch (Exception $e) {
    $pdo->rollBack();
    http_response_code(500);
    echo json_encode(['error' => 'Order failed']);
}
