<?php
session_start();

// Initialize cart if not exists
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Get POST data
$input = json_decode(file_get_contents('php://input'), true);

if (isset($input['product_id'])) {
    $item_id = intval($input['product_id']);
    $name = $input['name'];
    $price = floatval($input['price']);
    $image = $input['image'];
    $category = $input['category'];
    $item_type = $input['type'] ?? 'product'; // 'product' or 'pet'

    // Check if item already in cart
    $found = false;
    foreach ($_SESSION['cart'] as &$item) {
        if ($item['id'] == $item_id && $item['type'] == $item_type) {
            // For pets, we normally only allow 1, but for products we increment
            if ($item_type === 'product') {
                $item['quantity']++;
            }
            $found = true;
            break;
        }
    }

    if (!$found) {
        $_SESSION['cart'][] = [
            'id' => $item_id,
            'name' => $name,
            'price' => $price,
            'image' => $image,
            'category' => $category,
            'type' => $item_type,
            'quantity' => 1
        ];
    }

    // Calculate total cart items for badge
    $total_items = 0;
    foreach ($_SESSION['cart'] as $item) {
        $total_items += $item['quantity'];
    }

    echo json_encode([
        'status' => 'success',
        'cart_count' => $total_items
    ]);
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Invalid product data'
    ]);
}
?>

