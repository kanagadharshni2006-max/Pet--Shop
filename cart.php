<?php
require_once 'includes/db.php';
if(session_status() === PHP_SESSION_NONE) { session_start(); }

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php?redirect=cart.php');
    exit;
}

$user_id = $_SESSION['user_id'];

// Fetch cart items from database
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

include 'includes/header.php';
?>

<div class="container my-5" style="min-height: 60vh;">
    <h2 class="brand-font mb-4">Your Shopping Cart</h2>
    
    <?php if(empty($cart_items)): ?>
        <div class="text-center py-5 card shadow-sm border-0 rounded-4">
            <i class="fa-solid fa-cart-shopping fs-1 text-muted mb-3"></i>
            <h3>Your cart is empty</h3>
            <p class="text-muted">Looks like you haven't added anything to your cart yet.</p>
            <a href="products.php" class="btn btn-primary-custom mt-3">Start Shopping</a>
        </div>
    <?php else: ?>
    <form method="POST" action="cart_actions.php">
        <input type="hidden" name="action" value="update">
        <div class="row">
            <!-- Cart Items -->
            <div class="col-lg-8 mb-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Product</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th>Total</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $subtotal = 0;
                                    foreach($cart_items as $item): 
                                        $item_total = $item['price'] * $item['quantity'];
                                        $subtotal += $item_total;
                                    ?>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="<?php echo $item['image']; ?>" alt="Product" class="rounded" style="width: 60px; height: 60px; object-fit: cover;">
                                                <div class="ms-3">
                                                    <h6 class="mb-0"><?php echo htmlspecialchars($item['name']); ?></h6>
                                                    <small class="text-muted"><?php echo ucfirst($item['item_type']); ?> | <?php echo ucfirst($item['category']); ?></small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>₹<?php echo number_format($item['price'], 2); ?></td>
                                        <td>
                                            <?php if($item['item_type'] === 'pet'): ?>
                                                <input type="text" class="form-control form-control-sm text-center" value="1" readonly style="width: 60px;">
                                            <?php else: ?>
                                                <input type="number" name="quantities[<?php echo $item['cart_id']; ?>]" class="form-control form-control-sm text-center" value="<?php echo $item['quantity']; ?>" min="1" style="width: 80px;">
                                            <?php endif; ?>
                                        </td>
                                        <td class="fw-bold">₹<?php echo number_format($item_total, 2); ?></td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-danger" onclick="removeCartItem(<?php echo $item['cart_id']; ?>)"><i class="fa-solid fa-trash"></i></button>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-between mt-3">
                            <a href="products.php" class="btn btn-outline-primary"><i class="fa-solid fa-arrow-left"></i> Continue</a>
                            <button type="submit" class="btn btn-outline-secondary">Update Cart</button>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Cart Summary -->
            <div class="col-lg-4">
                <div class="card shadow-sm border-0 bg-light">
                    <div class="card-body p-4">
                        <h5 class="brand-font mb-4">Cart Summary</h5>
                        <div class="d-flex justify-content-between mb-3">
                            <span>Subtotal</span>
                            <span class="fw-bold">₹<?php echo number_format($subtotal, 2); ?></span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span>Shipping</span>
                            <span class="fw-bold text-success">Free</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mb-4">
                            <span class="fs-5 fw-bold">Total</span>
                            <span class="fs-5 fw-bold text-primary">₹<?php echo number_format($subtotal, 2); ?></span>
                        </div>
                        <a href="checkout.php" class="btn btn-primary-custom w-100 btn-lg">Proceed to Checkout</a>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <form id="removeForm" method="POST" action="cart_actions.php">
        <input type="hidden" name="action" value="remove">
        <input type="hidden" name="item_key" id="removeItemKey">
    </form>

    <script>
    function removeCartItem(key) {
        if(confirm('Remove this item?')) {
            document.getElementById('removeItemKey').value = key;
            document.getElementById('removeForm').submit();
        }
    }
    </script>

    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>

