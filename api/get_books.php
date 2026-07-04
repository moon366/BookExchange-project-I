<?php
header('Content-Type: application/json');
require '../config/db.php';

$search = $_GET['search'] ?? '';
$condition = $_GET['condition'] ?? '';
$district = $_GET['district'] ?? '';
$seller_id = $_GET['seller_id'] ?? '';

$sql = "SELECT b.*, u.name AS seller_name FROM books b
        JOIN users u ON b.seller_id = u.id
        WHERE 1=1";
$params = [];

if (!$seller_id) {
    $sql .= " AND b.status = 'available'";
}
if ($seller_id) {
    $sql .= " AND b.seller_id = ?";
    $params[] = $seller_id;
}
if ($search) {
    $sql .= " AND (b.title LIKE ? OR b.author LIKE ?)";
    $params[] = "%$search%";
    $params[] = "%$search%";
}
if ($condition === 'new' || $condition === 'used') {
    $sql .= " AND b.condition_type = ?";
    $params[] = $condition;
}
if ($district) {
    $sql .= " AND b.district = ?";
    $params[] = $district;
}

$sql .= " ORDER BY b.created_at DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
