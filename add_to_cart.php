<?php
require_once 'includes/db.php';
if(session_status() === PHP_SESSION_NONE) { session_start(); }

header('Content-Type: application/json');

// Get POST data
$input = json_decode(file_get_contents('php://input'), true);

if (!isset($_SESSION['user_id'])) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Please login to add items to your cart.',
        'redirect' => 'login.php'
    ]);
    exit;
}

$user_id = $_SESSION['user_id'];

if (isset($input['product_id'])) {
    $item_id = intval($input['product_id']);
    $item_type = $input['type'] ?? 'product'; // 'product' or 'pet'

    try {
        // Check if item already exists in the cart for this user
        $stmt = $pdo->prepare("SELECT id, quantity FROM cart WHERE user_id = ? AND item_id = ? AND item_type = ?");
        $stmt->execute([$user_id, $item_id, $item_type]);
        $existing = $stmt->fetch();

        if ($existing) {
            if ($item_type === 'product') {
                // Update quantity for products
                $update = $pdo->prepare("UPDATE cart SET quantity = quantity + 1 WHERE id = ?");
                $update->execute([$existing['id']]);
            }
        } else {
            // Insert new item
            $insert = $pdo->prepare("INSERT INTO cart (user_id, item_id, item_type, quantity) VALUES (?, ?, ?, 1)");
            $insert->execute([$user_id, $item_id, $item_type]);
        }

        // Get total cart count
        $countStmt = $pdo->prepare("SELECT SUM(quantity) as total FROM cart WHERE user_id = ?");
        $countStmt->execute([$user_id]);
        $total_items = (int) $countStmt->fetchColumn();

        echo json_encode([
            'status' => 'success',
            'cart_count' => $total_items
        ]);

    } catch(PDOException $e) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Database error: ' . $e->getMessage()
        ]);
    }

} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Invalid product data'
    ]);
}
?>

