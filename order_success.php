<?php
require_once 'includes/db.php';
if(session_status() === PHP_SESSION_NONE) { session_start(); }

$order_id = $_GET['id'] ?? null;
if (!$order_id) {
    header('Location: index.php');
    exit;
}

// Fetch Order Details
$stmt = $pdo->prepare("SELECT * FROM orders WHERE id = ?");
$stmt->execute([$order_id]);
$order = $stmt->fetch();

if (!$order) {
    header('Location: index.php');
    exit;
}

// Fetch Order Items
$stmt = $pdo->prepare("SELECT * FROM order_items WHERE order_id = ?");
$stmt->execute([$order_id]);
$items = $stmt->fetchAll();

// Fetch User Details for Address
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$order['user_id']]);
$user = $stmt->fetch();

include 'includes/header.php';
?>

<style>
@media print {
    body * { visibility: hidden; }
    .print-container, .print-container * { visibility: visible; }
    .print-container { position: absolute; left: 0; top: 0; width: 100%; margin: 0; padding: 20px; box-shadow: none; border: none; }
    .no-print { display: none !important; }
    nav, footer { display: none !important; }
}
.invoice-card {
    border-top: 5px solid var(--primary-color);
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
}
.invoice-logo {
    color: var(--primary-color);
    font-size: 2rem;
}
.dashed-border {
    border-bottom: 2px dashed #ddd;
}
</style>

<div class="container my-5 py-3 fade-in">
    <div class="text-center mb-4 no-print">
        <i class="fa-solid fa-circle-check text-success" style="font-size: 4rem;"></i>
        <h2 class="brand-font mt-3">Order Placed Successfully!</h2>
        <p class="text-muted">Thank you for your purchase. Here is your e-receipt.</p>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card invoice-card border-0 print-container bg-white p-4 p-md-5 rounded-4">
                
                <!-- Invoice Header -->
                <div class="d-flex justify-content-between align-items-center dashed-border pb-4 mb-4">
                    <div>
                        <h2 class="brand-font invoice-logo mb-0"><i class="fa-solid fa-paw"></i> Paws&Claws</h2>
                        <small class="text-muted">Premium Pet Shop</small>
                    </div>
                    <div class="text-end">
                        <h4 class="fw-bold mb-1 text-uppercase text-secondary">Receipt</h4>
                        <p class="mb-0 fw-bold">#ORD-<?php echo str_pad($order['id'], 6, '0', STR_PAD_LEFT); ?></p>
                        <small class="text-muted">Date: <?php echo date('d M Y, h:i A', strtotime($order['created_at'])); ?></small>
                    </div>
                </div>

                <!-- Customer & Shipping Details -->
                <div class="row mb-5">
                    <div class="col-sm-6">
                        <h6 class="fw-bold text-muted text-uppercase mb-2" style="letter-spacing: 1px;">Billed To:</h6>
                        <h5 class="fw-bold mb-1"><?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?></h5>
                        <p class="mb-1 text-muted"><i class="fa-solid fa-envelope me-2"></i> <?php echo htmlspecialchars($user['email']); ?></p>
                        <p class="mb-0 text-muted"><i class="fa-solid fa-phone me-2"></i> <?php echo htmlspecialchars($user['phone'] ?? 'N/A'); ?></p>
                    </div>
                    <div class="col-sm-6 text-sm-end mt-4 mt-sm-0">
                        <h6 class="fw-bold text-muted text-uppercase mb-2" style="letter-spacing: 1px;">Shipping Address:</h6>
                        <p class="mb-0 text-muted" style="max-width: 250px; margin-left: auto;"><?php echo nl2br(htmlspecialchars($order['shipping_address'])); ?></p>
                    </div>
                </div>

                <!-- Order Items Table -->
                <div class="table-responsive mb-4">
                    <table class="table table-borderless align-middle">
                        <thead class="table-light">
                            <tr>
                                <th class="py-3 text-uppercase small fw-bold text-muted" style="border-radius: 8px 0 0 8px;">Description</th>
                                <th class="py-3 text-uppercase small fw-bold text-muted text-center">Qty</th>
                                <th class="py-3 text-uppercase small fw-bold text-muted text-end">Price</th>
                                <th class="py-3 text-uppercase small fw-bold text-muted text-end" style="border-radius: 0 8px 8px 0;">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($items as $item): ?>
                            <tr>
                                <td class="py-3">
                                    <h6 class="mb-0 fw-bold"><?php echo htmlspecialchars($item['item_name']); ?></h6>
                                    <small class="text-muted text-uppercase" style="font-size: 0.7rem;"><?php echo htmlspecialchars($item['item_type']); ?></small>
                                </td>
                                <td class="py-3 text-center fw-bold text-muted"><?php echo $item['quantity']; ?></td>
                                <td class="py-3 text-end text-muted">₹<?php echo number_format($item['price'], 2); ?></td>
                                <td class="py-3 text-end fw-bold">₹<?php echo number_format($item['price'] * $item['quantity'], 2); ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Totals -->
                <div class="row justify-content-end">
                    <div class="col-sm-6 col-md-5">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted fw-bold">Subtotal:</span>
                            <span class="fw-bold">₹<?php echo number_format($order['total_amount'], 2); ?></span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted fw-bold">Shipping:</span>
                            <span class="text-success fw-bold">Free</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mt-3 pt-3 border-top">
                            <h5 class="fw-bold mb-0">Total:</h5>
                            <h4 class="fw-bold text-primary mb-0">₹<?php echo number_format($order['total_amount'], 2); ?></h4>
                        </div>
                    </div>
                </div>
                
                <div class="text-center mt-5 pt-4 dashed-border" style="border-top: 2px dashed #ddd; border-bottom: none;">
                    <p class="text-muted small fw-bold mb-1">Payment Method: <span class="text-primary text-uppercase"><?php echo htmlspecialchars($order['payment_method']); ?></span></p>
                    <p class="text-muted small">Thank you for shopping at Paws & Claws! We hope your pet loves it!</p>
                </div>
                
            </div>
            
            <!-- Action Buttons (Hidden on Print) -->
            <div class="d-flex justify-content-center gap-3 mt-4 no-print">
                <button onclick="window.print()" class="btn btn-outline-secondary px-4 py-2 rounded-pill shadow-sm"><i class="fa-solid fa-print me-2"></i>Print Receipt</button>
                <a href="products.php" class="btn btn-primary-custom px-4 py-2 rounded-pill shadow-sm"><i class="fa-solid fa-bag-shopping me-2"></i>Continue Shopping</a>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
