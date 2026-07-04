<?php
require '../includes/auth_check.php';
header('Content-Type: application/json');
require '../config/db.php';

$data = json_decode(file_get_contents('php://input'), true);
$id = $data['id'] ?? 0;

$check = $pdo->prepare("SELECT * FROM books WHERE id = ? AND seller_id = ?");
$check->execute([$id, $_SESSION['user_id']]);
$book = $check->fetch(PDO::FETCH_ASSOC);

if (!$book) {
    http_response_code(403);
    echo json_encode(['error' => 'Not your listing']);
    exit;
}

$orderCheck = $pdo->prepare("SELECT COUNT(*) FROM orders WHERE book_id = ?");
$orderCheck->execute([$id]);
if ($orderCheck->fetchColumn() > 0) {
    http_response_code(400);
    echo json_encode(['error' => 'Cannot delete: book has active orders']);
    exit;
}

$stmt = $pdo->prepare("DELETE FROM books WHERE id = ? AND seller_id = ?");
$stmt->execute([$id, $_SESSION['user_id']]);

if ($book['image_url']) {
    $file = __DIR__ . '/..' . $book['image_url'];
    if (file_exists($file)) {
        unlink($file);
    }
}

echo json_encode(['success' => true]);
