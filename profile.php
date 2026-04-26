<?php
require_once 'includes/db.php';
if(session_status() === PHP_SESSION_NONE) { session_start(); }

$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) {
    header('Location: login.php');
    exit;
}

$success_msg = '';
$error_msg = '';

// Handle Profile Update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_profile'])) {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    
    $stmt = $pdo->prepare("UPDATE users SET first_name=?, last_name=?, phone=?, address=? WHERE id=?");
    if ($stmt->execute([$first_name, $last_name, $phone, $address, $user_id])) {
        $success_msg = "Profile updated successfully!";
    } else {
        $error_msg = "Failed to update profile.";
    }
}

// Fetch User Data
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();

// Fetch Orders
$stmt = $pdo->prepare("SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC");
$stmt->execute([$user_id]);
$orders = $stmt->fetchAll();

// Fetch Wishlist
$stmt = $pdo->prepare("
    SELECT w.*, p.name, p.price, p.image 
    FROM wishlist w 
    JOIN products p ON w.item_id = p.id 
    WHERE w.user_id = ? AND w.item_type = 'product'
    UNION
    SELECT w.*, pet.name, pet.price, pet.image 
    FROM wishlist w 
    JOIN pets pet ON w.item_id = pet.id 
    WHERE w.user_id = ? AND w.item_type = 'pet'
");
$stmt->execute([$user_id, $user_id]);
$wishlist_items = $stmt->fetchAll();

include 'includes/header.php';
?>

<div class="container my-5" style="min-height: 60vh;">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-lg-3 mb-4">
            <div class="card shadow-sm border-0 rounded-4 text-center p-4 mb-4">
                <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($user['first_name'] . ' ' . $user['last_name']); ?>&background=f2a65a&color=fff&size=100" alt="User Avatar" class="rounded-circle mb-3 mx-auto" style="width: 100px; height: 100px;">
                <h5 class="fw-bold mb-1"><?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?></h5>
                <p class="text-muted small">Member since <?php echo date('M Y', strtotime($user['created_at'])); ?></p>
            </div>
            
            <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
                <div class="list-group list-group-flush border-0">
                    <a href="#profile" class="list-group-item list-group-item-action active p-3 fw-bold border-0" data-bs-toggle="list">
                        <i class="fa-regular fa-user me-2"></i> My Profile
                    </a>
                    <a href="#orders" class="list-group-item list-group-item-action p-3 fw-bold border-bottom" data-bs-toggle="list">
                        <i class="fa-solid fa-box-open me-2"></i> Order History
                    </a>
                    <a href="#wishlist" class="list-group-item list-group-item-action p-3 fw-bold border-bottom" data-bs-toggle="list">
                        <i class="fa-regular fa-heart me-2"></i> Wishlist
                    </a>
                    <a href="logout.php" class="list-group-item list-group-item-action text-danger p-3 fw-bold border-0">
                        <i class="fa-solid fa-arrow-right-from-bracket me-2"></i> Logout
                    </a>
                </div>
            </div>
        </div>

        <!-- Main Content (Tabs) -->
        <div class="col-lg-9">
            <?php if($success_msg): ?> <div class="alert alert-success"><?php echo $success_msg; ?></div> <?php endif; ?>
            <div class="tab-content" id="nav-tabContent">
                
                <!-- Profile Tab -->
                <div class="tab-pane fade show active" id="profile">
                    <div class="card shadow-sm border-0 rounded-4 p-4">
                        <h4 class="brand-font mb-4 pb-3 border-bottom"><i class="fa-solid fa-id-card text-primary me-2"></i> Account Information</h4>
                        <form method="POST">
                            <div class="row mb-3">
                                <div class="col-md-6 mb-3 mb-md-0">
                                    <label class="form-label text-muted small fw-bold">First Name</label>
                                    <input type="text" name="first_name" class="form-control" value="<?php echo htmlspecialchars($user['first_name']); ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label text-muted small fw-bold">Last Name</label>
                                    <input type="text" name="last_name" class="form-control" value="<?php echo htmlspecialchars($user['last_name']); ?>" required>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-md-6 mb-3 mb-md-0">
                                    <label class="form-label text-muted small fw-bold">Email</label>
                                    <input type="email" class="form-control" value="<?php echo htmlspecialchars($user['email']); ?>" disabled>
                                    <small class="text-muted">Email cannot be changed.</small>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label text-muted small fw-bold">Phone</label>
                                    <input type="text" name="phone" class="form-control" value="<?php echo htmlspecialchars($user['phone']); ?>" required>
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="form-label text-muted small fw-bold">Address</label>
                                <textarea name="address" class="form-control" rows="3"><?php echo htmlspecialchars($user['address'] ?? ''); ?></textarea>
                            </div>
                            <button type="submit" name="update_profile" class="btn btn-primary-custom px-4 shadow">Update Details</button>
                        </form>
                    </div>
                </div>

                <!-- Orders Tab -->
                <div class="tab-pane fade" id="orders">
                    <div class="card shadow-sm border-0 rounded-4 p-4">
                        <h4 class="brand-font mb-4 pb-3 border-bottom"><i class="fa-solid fa-clock-rotate-left text-primary me-2"></i> Recent Orders</h4>
                        <div class="table-responsive">
                            <table class="table align-middle">
                                <thead class="table-light text-muted small">
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if(empty($orders)): ?>
                                        <tr><td colspan="4" class="text-center py-4">You haven't placed any orders yet.</td></tr>
                                    <?php else: ?>
                                        <?php foreach($orders as $order): ?>
                                        <tr>
                                            <td class="fw-bold">#ORD-<?php echo $order['id']; ?></td>
                                            <td><?php echo date('M d, Y', strtotime($order['created_at'])); ?></td>
                                            <td>
                                                <span class="badge bg-<?php echo ($order['status'] === 'delivered' ? 'success' : 'warning text-dark'); ?> rounded-pill px-2">
                                                    <?php echo ucfirst($order['status']); ?>
                                                </span>
                                            </td>
                                            <td class="fw-bold">$<?php echo number_format($order['total_amount'], 2); ?></td>
                                        </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Wishlist Tab -->
                <div class="tab-pane fade" id="wishlist">
                    <div class="card shadow-sm border-0 rounded-4 p-4">
                        <h4 class="brand-font mb-4 pb-3 border-bottom"><i class="fa-solid fa-heart text-danger me-2"></i> My Wishlist</h4>
                        <?php if(empty($wishlist_items)): ?>
                            <p class="text-center py-5 text-muted">Your wishlist is empty.</p>
                        <?php else: ?>
                            <p class="text-muted">You have <?php echo count($wishlist_items); ?> item(s) in your wishlist.</p>
                            <div class="row">
                                <?php foreach($wishlist_items as $item): ?>
                                <div class="col-md-6 col-lg-5 mb-4">
                                    <div class="product-card border bg-light shadow-none">
                                        <div class="product-img-wrapper" style="height: 180px;">
                                            <img src="<?php echo htmlspecialchars($item['image']); ?>" alt="Item">
                                        </div>
                                        <div class="product-card-body p-3">
                                            <h6 class="product-title m-0 pb-2"><?php echo htmlspecialchars($item['name']); ?></h6>
                                            <div class="d-flex justify-content-between align-items-center mt-2">
                                                <span class="fw-bold text-primary fs-5">$<?php echo number_format($item['price'], 2); ?></span>
                                                <a href="toggle_wishlist.php?remove=<?php echo $item['id']; ?>&type=<?php echo $item['item_type']; ?>" class="btn btn-sm btn-outline-danger"><i class="fa-solid fa-trash"></i></a>
                                            </div>
                                            <button class="btn btn-primary-custom btn-sm w-100 mt-3 shadow-sm add-to-cart-btn"
                                                    data-id="<?php echo $item['item_id']; ?>"
                                                    data-name="<?php echo htmlspecialchars($item['name']); ?>"
                                                    data-price="<?php echo $item['price']; ?>"
                                                    data-image="<?php echo $item['image']; ?>"
                                                    data-type="<?php echo $item['item_type']; ?>">
                                                <i class="fa-solid fa-cart-plus"></i> Add to Cart
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>

