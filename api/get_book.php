<?php
header('Content-Type: application/json');
require '../config/db.php';

$id = $_GET['id'] ?? 0;

$stmt = $pdo->prepare("SELECT b.*, u.name AS seller_name, u.phone, u.email
                        FROM books b
                        JOIN users u ON b.seller_id = u.id
                        WHERE b.id = ?");
$stmt->execute([$id]);
$book = $stmt->fetch(PDO::FETCH_ASSOC);

if ($book) {
    echo json_encode($book);
} else {
    http_response_code(404);
    echo json_encode(['error' => 'Book not found']);
}
