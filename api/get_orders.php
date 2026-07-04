<?php
require '../includes/auth_check.php';
header('Content-Type: application/json');
require '../config/db.php';

$role = $_GET['role'] ?? 'buyer';

if ($role === 'seller') {
    $stmt = $pdo->prepare("SELECT o.*, b.title AS book_title, u.name AS buyer_name
                            FROM orders o
                            JOIN books b ON o.book_id = b.id
                            JOIN users u ON o.buyer_id = u.id
                            WHERE o.seller_id = ?
                            ORDER BY o.created_at DESC");
} else {
    $stmt = $pdo->prepare("SELECT o.*, b.title AS book_title, u.name AS seller_name,
                            EXISTS(SELECT 1 FROM reviews r WHERE r.order_id = o.id AND r.reviewer_id = o.buyer_id) AS has_review
                            FROM orders o
                            JOIN books b ON o.book_id = b.id
                            JOIN users u ON o.seller_id = u.id
                            WHERE o.buyer_id = ? AND o.location_finalized = 1
                            ORDER BY o.created_at DESC");
}
$stmt->execute([$_SESSION['user_id']]);
echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));