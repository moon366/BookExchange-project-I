<?php
require '../includes/auth_check.php';
header('Content-Type: application/json');
require '../config/db.php';

$id = $_POST['id'] ?? 0;

$check = $pdo->prepare("SELECT * FROM books WHERE id = ? AND seller_id = ?");
$check->execute([$id, $_SESSION['user_id']]);
if (!$check->fetch()) {
    http_response_code(403);
    echo json_encode(['error' => 'Not your listing']);
    exit;
}

$title = trim($_POST['title'] ?? '');
$author = trim($_POST['author'] ?? '');
$description = trim($_POST['description'] ?? '');
$condition_type = $_POST['condition_type'] ?? '';
$condition_notes = trim($_POST['condition_notes'] ?? '');
$price = $_POST['price'] ?? '';
$original_price = $_POST['original_price'] ?? null;
$district = trim($_POST['district'] ?? '');
$location = trim($_POST['location'] ?? '');
$category_id = $_POST['category_id'] ?? null;

if (!$title || !$price || !$condition_type) {
    http_response_code(400);
    echo json_encode(['error' => 'Title, price and condition are required']);
    exit;
}

$image_url = null;

if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $allowed = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime = finfo_file($finfo, $_FILES['image']['tmp_name']);
    finfo_close($finfo);

    if (!in_array($mime, $allowed)) {
        http_response_code(400);
        echo json_encode(['error' => 'Only JPG, PNG, GIF, WebP images allowed']);
        exit;
    }

    if ($_FILES['image']['size'] > 5 * 1024 * 1024) {
        http_response_code(400);
        echo json_encode(['error' => 'Image must be under 5MB']);
        exit;
    }

    $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
    $filename = uniqid('book_') . '.' . $ext;
    $dest = __DIR__ . '/../uploads/' . $filename;

    if (move_uploaded_file($_FILES['image']['tmp_name'], $dest)) {
        $image_url = '/book-exchange/uploads/' . $filename;
    }
}

if ($image_url) {
    $stmt = $pdo->prepare("UPDATE books SET title=?, author=?, description=?, condition_type=?, condition_notes=?, price=?, original_price=?, location=?, district=?, category_id=?, image_url=? WHERE id=? AND seller_id=?");
    $stmt->execute([$title, $author, $description, $condition_type, $condition_notes, $price, $original_price, $location, $district, $category_id, $image_url, $id, $_SESSION['user_id']]);
} else {
    $stmt = $pdo->prepare("UPDATE books SET title=?, author=?, description=?, condition_type=?, condition_notes=?, price=?, original_price=?, location=?, district=?, category_id=? WHERE id=? AND seller_id=?");
    $stmt->execute([$title, $author, $description, $condition_type, $condition_notes, $price, $original_price, $location, $district, $category_id, $id, $_SESSION['user_id']]);
}

echo json_encode(['success' => true]);
