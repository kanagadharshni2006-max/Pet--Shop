<?php 
require_once '../includes/db.php';
include 'layout/header.php'; 

// Fetch Stats
$total_sales = $pdo->query("SELECT SUM(total_amount) FROM orders WHERE status = 'delivered'")->fetchColumn() ?? 0;
$total_orders = $pdo->query("SELECT COUNT(*) FROM orders")->fetchColumn();
$pets_adopted = $pdo->query("SELECT COUNT(*) FROM pets WHERE status = 'sold'")->fetchColumn();
$registered_users = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();

// Fetch Recent Orders
$stmt = $pdo->query("SELECT o.*, u.first_name, u.last_name FROM orders o JOIN users u ON o.user_id = u.id ORDER BY o.created_at DESC LIMIT 5");
$recent_orders = $stmt->fetchAll();
?>

<div class="row mb-4">
    <div class="col-md-3 mb-3 mb-md-0">
        <div class="card card-stat bg-white p-3 border-start border-4 border-primary">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-muted mb-1">Total Sales</h6>
                    <h3 class="fw-bold mb-0 text-dark">₹<?php echo number_format($total_sales, 2); ?></h3>
                </div>
                <div class="bg-light p-3 rounded-circle text-primary">
                    <i class="fa-solid fa-indian-rupee-sign fs-4"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3 mb-md-0">
        <div class="card card-stat bg-white p-3 border-start border-4 border-success">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-muted mb-1">Total Orders</h6>
                    <h3 class="fw-bold mb-0 text-dark"><?php echo $total_orders; ?></h3>
                </div>
                <div class="bg-light p-3 rounded-circle text-success">
                    <i class="fa-solid fa-cart-shopping fs-4"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3 mb-md-0">
        <div class="card card-stat bg-white p-3 border-start border-4 border-info">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-muted mb-1">Pets Sold/Adopted</h6>
                    <h3 class="fw-bold mb-0 text-dark"><?php echo $pets_adopted; ?></h3>
                </div>
                <div class="bg-light p-3 rounded-circle text-info">
                    <i class="fa-solid fa-heart fs-4"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-stat bg-white p-3 border-start border-4 border-warning">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-muted mb-1">Registered Users</h6>
                    <h3 class="fw-bold mb-0 text-dark"><?php echo $registered_users; ?></h3>
                </div>
                <div class="bg-light p-3 rounded-circle text-warning">
                    <i class="fa-solid fa-users fs-4"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card card-stat mb-5">
    <div class="card-body p-4">
        <h5 class="card-title brand-font mb-4">Recent Orders</h5>
        <div class="table-responsive">
            <table class="table align-middle table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Order ID</th>
                        <th>Customer</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Total</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($recent_orders)): ?>
                        <tr><td colspan="6" class="text-center py-4">No orders found yet.</td></tr>
                    <?php else: ?>
                        <?php foreach($recent_orders as $order): ?>
                        <tr>
                            <td class="fw-bold text-primary">#ORD-<?php echo $order['id']; ?></td>
                            <td><?php echo htmlspecialchars($order['first_name'] . ' ' . $order['last_name']); ?></td>
                            <td><?php echo date('M d, Y', strtotime($order['created_at'])); ?></td>
                            <td>
                                <span class="badge bg-<?php 
                                    echo ($order['status'] === 'delivered' ? 'success' : 
                                         ($order['status'] === 'pending' ? 'warning text-dark' : 'info')); 
                                ?> rounded-pill px-3">
                                    <?php echo ucfirst($order['status']); ?>
                                </span>
                            </td>
                            <td class="fw-bold">₹<?php echo number_format($order['total_amount'], 2); ?></td>
                            <td><a href="orders.php?id=<?php echo $order['id']; ?>" class="btn btn-sm btn-outline-primary rounded-pill px-3">Details</a></td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

        </div> <!-- close px-4 -->
    </div> <!-- close flex-grow-1 -->
</div> <!-- close d-flex -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

