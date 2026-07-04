<?php
require '../includes/auth_check.php';
header('Content-Type: application/json');
require '../config/db.php';

$stmt = $pdo->prepare("SELECT o.id as order_id, o.price as purchase_price, o.created_at as purchase_date,
                        b.id as book_id, b.title, b.author, b.image_url, b.original_price, b.location,
                        u.name as seller_name
                        FROM orders o
                        JOIN books b ON o.book_id = b.id
                        JOIN users u ON o.seller_id = u.id
                        WHERE o.buyer_id = ? AND o.status = 'completed' AND o.location_finalized = 1
                        ORDER BY o.created_at DESC");
$stmt->execute([$_SESSION['user_id']]);
echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
