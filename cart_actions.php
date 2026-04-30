<?php
require_once 'includes/db.php';
if(session_status() === PHP_SESSION_NONE) { session_start(); }

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $cart_id = $_POST['item_key'] ?? null;

    if ($action === 'remove' && $cart_id !== null) {
        $stmt = $pdo->prepare("DELETE FROM cart WHERE id = ? AND user_id = ?");
        $stmt->execute([$cart_id, $user_id]);
    }

    if ($action === 'update' && isset($_POST['quantities'])) {
        $stmt = $pdo->prepare("UPDATE cart SET quantity = ? WHERE id = ? AND user_id = ? AND item_type = 'product'");
        foreach ($_POST['quantities'] as $id => $qty) {
            $qty = max(1, intval($qty));
            $stmt->execute([$qty, $id, $user_id]);
        }
    }
}

header('Location: cart.php');
exit;
?>
