<?php
require_once 'includes/db.php';
if(session_status() === PHP_SESSION_NONE) { session_start(); }

$order_id = $_GET['id'] ?? null;
if (!$order_id) {
    header('Location: index.php');
    exit;
}

include 'includes/header.php';
?>

<div class="container my-5 py-5 text-center fade-in" style="min-height: 60vh;">
    <div class="mb-4">
        <i class="fa-solid fa-circle-check text-success" style="font-size: 5rem;"></i>
    </div>
    <h1 class="brand-font mb-3">Order Placed Successfully!</h1>
    <p class="text-muted fs-5 mb-4">Thank you for your purchase. Your order ID is <strong class="text-primary">#ORD-<?php echo htmlspecialchars($order_id); ?></strong>.</p>
    <div class="d-flex justify-content-center gap-3 mt-4">
        <a href="profile.php#orders" class="btn btn-outline-primary px-4 py-2 rounded-pill shadow-sm">View My Orders</a>
        <a href="products.php" class="btn btn-primary-custom px-4 py-2 rounded-pill shadow-sm">Continue Shopping</a>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
