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
    SELECT c.id as cart_id, c.item_id, c.item_type, c.quantity, p.name, p.price, p.image, p.category, 0 as requires_proof 
    FROM cart c 
    JOIN products p ON c.item_id = p.id 
    WHERE c.user_id = ? AND c.item_type = 'product'
    UNION
    SELECT c.id as cart_id, c.item_id, c.item_type, c.quantity, pet.name, pet.price, pet.image, pet.type as category, pet.requires_proof 
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
        $id_proof_path = null;
        if (isset($_FILES['id_proof']) && $_FILES['id_proof']['error'] === 0) {
            $ext = pathinfo($_FILES['id_proof']['name'], PATHINFO_EXTENSION);
            $filename = uniqid('proof_') . '.' . $ext;
            $target_dir = "uploads/proofs/";
            if (!is_dir($target_dir)) mkdir($target_dir, 0777, true);
            if (move_uploaded_file($_FILES['id_proof']['tmp_name'], $target_dir . $filename)) {
                $id_proof_path = $target_dir . $filename;
            }
        }

        $pdo->beginTransaction();
        
        // Insert into orders
        $stmt = $pdo->prepare("INSERT INTO orders (user_id, total_amount, payment_method, shipping_address, id_proof_path) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$user_id, $total_amount, $payment_method, $full_address, $id_proof_path]);
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

    <form method="POST" enctype="multipart/form-data">
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
                    <input class="form-check-input ms-1" type="radio" name="paymentMethod" id="cod" value="cod" checked onchange="togglePayment()">
                    <label class="form-check-label fw-bold ms-2 mt-1" for="cod">
                        Cash on Delivery (COD)
                    </label>
                    <p class="text-muted small ms-4 mt-1 mb-0">Pay with cash upon delivery.</p>
                </div>
                
                <div class="form-check mb-3 p-3 border rounded payment-option">
                    <input class="form-check-input ms-1" type="radio" name="paymentMethod" id="online" value="online" onchange="togglePayment()">
                    <label class="form-check-label fw-bold ms-2 mt-1" for="online">
                        Credit / Debit Card
                    </label>
                </div>

                <div class="form-check mb-3 p-3 border rounded payment-option">
                    <input class="form-check-input ms-1" type="radio" name="paymentMethod" id="upi" value="upi" onchange="togglePayment()">
                    <label class="form-check-label fw-bold ms-2 mt-1" for="upi">
                        UPI (PhonePe, GPay, etc.)
                    </label>
                </div>

                <!-- Credit Card Form Container (Hidden by default) -->
                <div id="cardDetailsContainer" class="mt-4 d-none fade-in">
                    <div class="p-4 rounded-4" style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%); color: white; position: relative; overflow: hidden; box-shadow: 0 10px 20px rgba(0,0,0,0.15);">
                        <!-- Decorative background circle -->
                        <div style="position: absolute; top: -50px; right: -50px; width: 150px; height: 150px; background: rgba(255,255,255,0.1); border-radius: 50%;"></div>
                        
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <i class="fa-brands fa-cc-visa fs-1 opacity-75" id="cardIcon"></i>
                            <i class="fa-solid fa-wifi" style="transform: rotate(90deg); opacity: 0.7;"></i>
                        </div>
                        
                        <div class="mb-4">
                            <label class="form-label small text-light opacity-75 mb-1" style="font-size: 0.75rem; letter-spacing: 1px;">CARD NUMBER</label>
                            <input type="text" id="ccNumber" class="form-control form-control-lg bg-transparent text-white border-0 p-0 fw-bold shadow-none" placeholder="0000 0000 0000 0000" maxlength="19" style="font-size: 1.5rem; letter-spacing: 2px;" oninput="formatCardNumber(this)">
                        </div>
                        
                        <div class="row">
                            <div class="col-8">
                                <label class="form-label small text-light opacity-75 mb-1" style="font-size: 0.75rem; letter-spacing: 1px;">CARD HOLDER</label>
                                <input type="text" class="form-control bg-transparent text-white border-0 p-0 shadow-none text-uppercase" placeholder="YOUR NAME">
                            </div>
                            <div class="col-4">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <label class="form-label small text-light opacity-75 mb-1" style="font-size: 0.75rem; letter-spacing: 1px;">EXPIRES</label>
                                        <input type="text" id="ccExpiry" class="form-control bg-transparent text-white border-0 p-0 shadow-none" placeholder="MM/YY" maxlength="5" oninput="formatExpiry(this)">
                                    </div>
                                    <div class="ms-3">
                                        <label class="form-label small text-light opacity-75 mb-1" style="font-size: 0.75rem; letter-spacing: 1px;">CVV</label>
                                        <input type="password" id="ccCvv" class="form-control bg-transparent text-white border-0 p-0 shadow-none" placeholder="•••" maxlength="3" oninput="formatCVV(this)">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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
            function togglePayment() {
                const qrContainer = document.getElementById('qrCodeContainer');
                const cardContainer = document.getElementById('cardDetailsContainer');
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

                // Show/Hide Containers
                if (isUPI) {
                    qrContainer.classList.remove('d-none');
                    cardContainer.classList.add('d-none');
                } else if (isOnline) {
                    cardContainer.classList.remove('d-none');
                    qrContainer.classList.add('d-none');
                } else {
                    qrContainer.classList.add('d-none');
                    cardContainer.classList.add('d-none');
                }
            }
            
            // Format Card Number (adds space every 4 digits)
            function formatCardNumber(input) {
                let value = input.value.replace(/\D/g, ''); // Remove non-digits
                let formatted = value.match(/.{1,4}/g);
                input.value = formatted ? formatted.join(' ') : value;
                
                // Change icon based on card type
                const icon = document.getElementById('cardIcon');
                if (value.startsWith('4')) {
                    icon.className = 'fa-brands fa-cc-visa fs-1 opacity-75';
                } else if (value.startsWith('5')) {
                    icon.className = 'fa-brands fa-cc-mastercard fs-1 opacity-75';
                } else if (value.startsWith('3')) {
                    icon.className = 'fa-brands fa-cc-amex fs-1 opacity-75';
                } else {
                    icon.className = 'fa-regular fa-credit-card fs-1 opacity-75';
                }
            }

            // Format Expiry Date (MM/YY)
            function formatExpiry(input) {
                let value = input.value.replace(/\D/g, '');
                if (value.length >= 2) {
                    value = value.substring(0, 2) + '/' + value.substring(2, 4);
                }
                input.value = value;
            }

            // Format CVV (Numbers only)
            function formatCVV(input) {
                input.value = input.value.replace(/\D/g, '');
            }
            </script>
        </div>

        <div class="col-lg-4">
            <div class="card shadow-sm border-0 bg-light sticky-top" style="top: 100px;">
                <div class="card-body p-4">
                    <h5 class="brand-font mb-4">Order Summary</h5>
                    <?php 
                    $subtotal = 0;
                    $requires_proof = false;
                    foreach($cart_items as $item): 
                        $subtotal += $item['price'] * $item['quantity'];
                        if($item['item_type'] === 'pet') {
                            $requires_proof = true;
                        }
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

                    <?php 
                    $has_pet = false;
                    foreach($cart_items as $item) {
                        if($item['item_type'] === 'pet') {
                            $has_pet = true;
                            break;
                        }
                    }
                    if($has_pet):
                    ?>
                    <div class="form-check mb-4 bg-white p-3 rounded border border-warning shadow-sm">
                        <input class="form-check-input ms-1 border-secondary" type="checkbox" id="legalDeclaration" name="legal_declaration" required>
                        <label class="form-check-label small fw-bold ms-2 text-dark" for="legalDeclaration">
                            <i class="fa-solid fa-scale-balanced text-warning me-1"></i> Legal Declaration
                        </label>
                        <p class="text-muted mt-2 mb-0" style="font-size: 0.7rem; line-height: 1.4;">I confirm that I am legally permitted to own this pet in my jurisdiction. I understand it is not an illegal or banned exotic species in my state, and I agree to provide proper care as per animal welfare laws.</p>
                        
                        <?php if($requires_proof): ?>
                        <div class="mt-3 p-3 bg-light rounded border border-danger">
                            <label class="form-label fw-bold text-danger small"><i class="fa-solid fa-id-card"></i> Govt. ID Proof Required</label>
                            <input type="file" name="id_proof" class="form-control form-control-sm" accept="image/*,.pdf" required>
                            <div class="form-text" style="font-size: 0.65rem;">Please upload your Aadhar Card, PAN, or Driver's License. Required for adopting this specific pet.</div>
                        </div>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>
                    
                    <button type="submit" name="place_order" class="btn btn-primary-custom w-100 btn-lg shadow-sm">Place Order</button>
                </div>
            </div>
        </div>
    </div>
    </form>
</div>

<?php include 'includes/footer.php'; ?>

