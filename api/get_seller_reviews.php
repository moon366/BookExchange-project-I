<?php
header('Content-Type: application/json');
require '../config/db.php';

$seller_id = $_GET['seller_id'] ?? 0;

$stmt = $pdo->prepare("
    SELECT r.rating, r.comment, r.created_at, u.name AS reviewer_name, b.title AS book_title
    FROM reviews r
    JOIN orders o ON r.order_id = o.id
    JOIN users u ON r.reviewer_id = u.id
    JOIN books b ON o.book_id = b.id
    WHERE o.seller_id = ?
    ORDER BY r.created_at DESC
");
$stmt->execute([$seller_id]);
$reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);

$avgStmt = $pdo->prepare("
    SELECT AVG(r.rating) AS avg_rating, COUNT(*) AS total
    FROM reviews r
    JOIN orders o ON r.order_id = o.id
    WHERE o.seller_id = ?
");
$avgStmt->execute([$seller_id]);
$summary = $avgStmt->fetch(PDO::FETCH_ASSOC);

echo json_encode([
    'average' => $summary['total'] > 0 ? round((float)$summary['avg_rating'], 1) : null,
    'total' => (int)$summary['total'],
    'reviews' => $reviews
]);