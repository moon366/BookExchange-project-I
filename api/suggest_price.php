<?php
header('Content-Type: application/json');
require '../config/db.php';

$condition = $_GET['condition'] ?? '';

if (!in_array($condition, ['new', 'used'])) {
    echo json_encode(['suggested' => null]);
    exit;
}

$stmt = $pdo->prepare("SELECT AVG(price) as avg_price, COUNT(*) as count
                        FROM books
                        WHERE condition_type = ? AND status != 'sold'");
$stmt->execute([$condition]);
$result = $stmt->fetch(PDO::FETCH_ASSOC);

if ($result && $result['count'] > 0) {
    $avg = round((float)$result['avg_price'], 2);
    $range_min = round($avg * 0.8, 2);
    $range_max = round($avg * 1.2, 2);
    echo json_encode([
        'suggested' => $avg,
        'range_min' => $range_min,
        'range_max' => $range_max,
        'count' => (int)$result['count']
    ]);
} else {
    $defaults = ['new' => 29.99, 'used' => 14.99];
    echo json_encode([
        'suggested' => $defaults[$condition],
        'range_min' => round($defaults[$condition] * 0.8, 2),
        'range_max' => round($defaults[$condition] * 1.2, 2),
        'count' => 0
    ]);
}
