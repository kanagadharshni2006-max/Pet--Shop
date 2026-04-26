<?php
require_once 'includes/db.php';
if(session_status() === PHP_SESSION_NONE) { session_start(); }

$user_id = $_SESSION['user_id'] ?? null;

if (!$user_id) {
    echo json_encode(['status' => 'error', 'message' => 'Please login to use wishlist']);
    exit;
}

// Handle removal from profile page
if (isset($_GET['remove'])) {
    $id = intval($_GET['remove']);
    $stmt = $pdo->prepare("DELETE FROM wishlist WHERE id = ? AND user_id = ?");
    $stmt->execute([$id, $user_id]);
    header('Location: profile.php#wishlist');
    exit;
}

// Handle AJAX toggle
$input = json_decode(file_get_contents('php://input'), true);
if (isset($input['item_id'])) {
    $item_id = intval($input['item_id']);
    $item_type = $input['item_type']; // 'product' or 'pet'

    // Check if already in wishlist
    $stmt = $pdo->prepare("SELECT id FROM wishlist WHERE user_id = ? AND item_id = ? AND item_type = ?");
    $stmt->execute([$user_id, $item_id, $item_type]);
    $existing = $stmt->fetch();

    if ($existing) {
        // Remove
        $stmt = $pdo->prepare("DELETE FROM wishlist WHERE id = ?");
        $stmt->execute([$existing['id']]);
        echo json_encode(['status' => 'removed']);
    } else {
        // Add
        $stmt = $pdo->prepare("INSERT INTO wishlist (user_id, item_id, item_type) VALUES (?, ?, ?)");
        $stmt->execute([$user_id, $item_id, $item_type]);
        echo json_encode(['status' => 'added']);
    }
}
?>
