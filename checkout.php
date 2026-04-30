<?php
require_once 'includes/db.php';
if(session_status() === PHP_SESSION_NONE) { session_start(); }

$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) {
    header('Location: login.php?redirect=checkout.php');
    exit;
}

// Fetch cart from database
$stmt = $pdo->prepare("
    SELECT c.id as cart_id, c.item_id, c.item_type, c.quantity, p.name, p.price, p.image, p.category 
    FROM cart c 
    JOIN products p ON c.item_id = p.id 
    WHERE c.user_id = ? AND c.item_type = 'product'
    UNION
    SELECT c.id as cart_id, c.item_id, c.item_type, c.quantity, pet.name, pet.price, pet.image, pet.type as category 
    FROM cart c 
    JOIN pets pet ON c.item_id = pet.id 
    WHERE c.user_id = ? AND c.item_type = 'pet'
");
$stmt->execute([$user_id, $user_id]);
$cart_items = $stmt->fetchAll();

// Redirect if cart is empty
if (empty($cart_items)) {
    header('Location: products.php');
    exit;
}

// Fetch user data for pre-filling
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['place_order'])) {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $country = $_POST['country'];
    $state = $_POST['state'] ?? '';
    $zip = $_POST['zip_code'] ?? '';
    $payment_method = $_POST['paymentMethod'];
    
    $full_address = "$address, $state, $country - $zip";
    $total_amount = 0;
    foreach ($cart_items as $item) {
        $total_amount += $item['price'] * $item['quantity'];
    }
    
    try {
        $pdo->beginTransaction();
        
        // Insert into orders
        $stmt = $pdo->prepare("INSERT INTO orders (user_id, total_amount, payment_method, shipping_address) VALUES (?, ?, ?, ?)");
        $stmt->execute([$user_id, $total_amount, $payment_method, $full_address]);
        $order_id = $pdo->lastInsertId();
        
        // Insert into order_items
        $stmt = $pdo->prepare("INSERT INTO order_items (order_id, item_id, item_type, item_name, price, quantity) VALUES (?, ?, ?, ?, ?, ?)");
        foreach ($cart_items as $item) {
            $stmt->execute([$order_id, $item['item_id'], $item['item_type'], $item['name'], $item['price'], $item['quantity']]);
            
            // If it's a pet, mark as sold
            if ($item['item_type'] === 'pet') {
                $pdo->prepare("UPDATE pets SET status = 'sold' WHERE id = ?")->execute([$item['item_id']]);
            } else {
                // If product, reduce stock
                $pdo->prepare("UPDATE products SET stock = stock - ? WHERE id = ?")->execute([$item['quantity'], $item['item_id']]);
            }
        }
        
        // Clear database cart
        $pdo->prepare("DELETE FROM cart WHERE user_id = ?")->execute([$user_id]);
        
        $pdo->commit();
        header("Location: order_success.php?id=" . $order_id);
        exit;
    } catch (Exception $e) {
        $pdo->rollBack();
        $error = "Order failed: " . $e->getMessage();
    }
}

include 'includes/header.php';
?>

<div class="container my-5">
    <div class="text-center mb-5">
        <h2 class="brand-font">Checkout</h2>
        <p class="text-muted">Securely complete your purchase</p>
    </div>

    <?php if($error): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>

    <form method="POST">
    <div class="row">
        <div class="col-lg-8 mb-4">
            <div class="card shadow-sm border-0 p-4 mb-4">
                <h4 class="mb-4 text-primary"><i class="fa-solid fa-map-location-dot"></i> Shipping Details</h4>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">First Name</label>
                        <input type="text" name="first_name" class="form-control" value="<?php echo htmlspecialchars($user['first_name'] ?? ''); ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Last Name</label>
                        <input type="text" name="last_name" class="form-control" value="<?php echo htmlspecialchars($user['last_name'] ?? ''); ?>" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Phone Number</label>
                    <input type="tel" name="phone" class="form-control" value="<?php echo htmlspecialchars($user['phone'] ?? ''); ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Address</label>
                    <input type="text" name="address" class="form-control" placeholder="1234 Main St" value="<?php echo htmlspecialchars($user['address'] ?? ''); ?>" required>
                </div>
                <div class="row">
                    <div class="col-md-5 mb-3">
                        <label class="form-label fw-bold">Country</label>
                        <select name="country" class="form-select">
                            <option>United States</option>
                            <option selected>India</option>
                            <option>Canada</option>
                            <option>United Kingdom</option>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">State</label>
                        <input type="text" name="state" class="form-control" required>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label fw-bold">Zip Code</label>
                        <input type="text" name="zip_code" class="form-control" required>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm border-0 p-4">
                <h4 class="mb-4 text-primary"><i class="fa-solid fa-credit-card"></i> Payment Method</h4>
                
                <div class="form-check mb-3 p-3 border rounded border-primary bg-light payment-option">
                    <input class="form-check-input ms-1" type="radio" name="paymentMethod" id="cod" value="cod" checked onchange="toggleQR()">
                    <label class="form-check-label fw-bold ms-2 mt-1" for="cod">
                        Cash on Delivery (COD)
                    </label>
                    <p class="text-muted small ms-4 mt-1 mb-0">Pay with cash upon delivery.</p>
                </div>
                
                <div class="form-check mb-3 p-3 border rounded payment-option">
                    <input class="form-check-input ms-1" type="radio" name="paymentMethod" id="online" value="online" onchange="toggleQR()">
                    <label class="form-check-label fw-bold ms-2 mt-1" for="online">
                        Credit / Debit Card
                    </label>
                </div>

                <div class="form-check mb-3 p-3 border rounded payment-option">
                    <input class="form-check-input ms-1" type="radio" name="paymentMethod" id="upi" value="upi" onchange="toggleQR()">
                    <label class="form-check-label fw-bold ms-2 mt-1" for="upi">
                        UPI (PhonePe, GPay, etc.)
                    </label>
                </div>

                <!-- QR Code Container (Hidden by default) -->
                <div id="qrCodeContainer" class="text-center mt-4 d-none fade-in">
                    <p class="fw-bold text-success mb-2"><i class="fa-solid fa-qrcode"></i> Scan to Pay Total Amount</p>
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=upi://pay?pa=petshop@ybl&pn=PawsAndClaws" alt="QR Code" class="img-fluid rounded border p-2 shadow-sm bg-white" style="max-width: 200px;">
                    <p class="text-muted small mt-2"><i class="fa-solid fa-circle-check text-success"></i> Secure Payment Gateway</p>
                    <p class="text-muted small mt-1">Please scan the QR code using your UPI app or Camera. Once paid, click 'Place Order'.</p>
                </div>
            </div>

            <script>
            function toggleQR() {
                const qrContainer = document.getElementById('qrCodeContainer');
                const isOnline = document.getElementById('online').checked;
                const isUPI = document.getElementById('upi').checked;
                const paymentOptions = document.querySelectorAll('.payment-option');
                
                // Reset styling
                paymentOptions.forEach(opt => {
                    opt.classList.remove('border-primary', 'bg-light');
                });
                
                // Add styling to selected
                if(document.getElementById('cod').checked) {
                    document.getElementById('cod').parentElement.classList.add('border-primary', 'bg-light');
                } else if(isOnline) {
                    document.getElementById('online').parentElement.classList.add('border-primary', 'bg-light');
                } else if(isUPI) {
                    document.getElementById('upi').parentElement.classList.add('border-primary', 'bg-light');
                }

                if (isOnline || isUPI) {
                    qrContainer.classList.remove('d-none');
                } else {
                    qrContainer.classList.add('d-none');
                }
            }
            </script>
        </div>

        <div class="col-lg-4">
            <div class="card shadow-sm border-0 bg-light sticky-top" style="top: 100px;">
                <div class="card-body p-4">
                    <h5 class="brand-font mb-4">Order Summary</h5>
                    <?php 
                    $subtotal = 0;
                    foreach($cart_items as $item): 
                        $subtotal += $item['price'] * $item['quantity'];
                    ?>
                    <div class="d-flex justify-content-between align-items-center mb-3 border-bottom pb-3">
                        <div>
                            <h6 class="mb-0 small"><?php echo htmlspecialchars($item['name']); ?></h6>
                            <span class="text-muted small">Qty: <?php echo $item['quantity']; ?></span>
                        </div>
                        <span class="fw-bold small">₹<?php echo number_format($item['price'] * $item['quantity'], 2); ?></span>
                    </div>
                    <?php endforeach; ?>
                    
                    <div class="d-flex justify-content-between mb-2 small mt-4">
                        <span class="text-muted">Subtotal</span>
                        <span>₹<?php echo number_format($subtotal, 2); ?></span>
                    </div>
                    <div class="d-flex justify-content-between mb-3 small">
                        <span class="text-muted">Shipping</span>
                        <span class="text-success fw-bold">Free</span>
                    </div>
                    <div class="d-flex justify-content-between mb-4 border-top pt-3">
                        <span class="fw-bold fs-5">Total</span>
                        <span class="fw-bold fs-5 text-primary">₹<?php echo number_format($subtotal, 2); ?></span>
                    </div>
                    
                    <button type="submit" name="place_order" class="btn btn-primary-custom w-100 btn-lg shadow-sm">Place Order</button>
                </div>
            </div>
        </div>
    </div>
    </form>
</div>

<?php include 'includes/footer.php'; ?>

