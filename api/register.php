<?php
header('Content-Type: application/json');
require '../config/db.php';

$data = json_decode(file_get_contents('php://input'), true);
$name = trim($data['name'] ?? '');
$email = trim($data['email'] ?? '');
$password = $data['password'] ?? '';

if (!$name || !$email || !$password) {
    http_response_code(400);
    echo json_encode(['error' => 'All fields required']);
    exit;
}

$hash = password_hash($password, PASSWORD_BCRYPT);

try {
    $stmt = $pdo->prepare("INSERT INTO users (name, email, password_hash) VALUES (?, ?, ?)");
    $stmt->execute([$name, $email, $hash]);
    echo json_encode(['success' => true, 'user_id' => $pdo->lastInsertId()]);
} catch (PDOException $e) {
    http_response_code(409);
    echo json_encode(['error' => 'Email already exists']);
}
