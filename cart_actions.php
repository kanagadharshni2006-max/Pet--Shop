<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $item_key = $_POST['item_key'] ?? null;

    if ($action === 'remove' && $item_key !== null) {
        unset($_SESSION['cart'][$item_key]);
        $_SESSION['cart'] = array_values($_SESSION['cart']); // Re-index
    }

    if ($action === 'update' && isset($_POST['quantities'])) {
        foreach ($_POST['quantities'] as $key => $qty) {
            $qty = max(1, intval($qty));
            if (isset($_SESSION['cart'][$key]) && $_SESSION['cart'][$key]['type'] === 'product') {
                $_SESSION['cart'][$key]['quantity'] = $qty;
            }
        }
    }
}

header('Location: cart.php');
exit;
?>
