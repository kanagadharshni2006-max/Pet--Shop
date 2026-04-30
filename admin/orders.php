<?php 
require_once '../includes/db.php';
include 'layout/header.php'; 

$success_msg = '';
$error_msg = '';

// Handle Status Update
if (isset($_POST['update_status'])) {
    $order_id = intval($_POST['order_id']);
    $status = $_POST['status'];
    $stmt = $pdo->prepare("UPDATE orders SET status = ? WHERE id = ?");
    if ($stmt->execute([$status, $order_id])) {
        $success_msg = "Order status updated!";
    } else {
        $error_msg = "Failed to update status.";
    }
}

// Fetch Orders
$stmt = $pdo->query("SELECT o.*, u.first_name, u.last_name FROM orders o JOIN users u ON o.user_id = u.id ORDER BY o.created_at DESC");
$orders = $stmt->fetchAll();

// Handle AJAX for Order Details
if (isset($_GET['details'])) {
    $order_id = intval($_GET['details']);
    $stmt = $pdo->prepare("SELECT * FROM order_items WHERE order_id = ?");
    $stmt->execute([$order_id]);
    $items = $stmt->fetchAll();
    echo json_encode($items);
    exit;
}
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="brand-font">Manage Orders</h3>
</div>

<?php if ($success_msg): ?>
    <div class="alert alert-success"><?php echo $success_msg; ?></div>
<?php endif; ?>
<?php if ($error_msg): ?>
    <div class="alert alert-danger"><?php echo $error_msg; ?></div>
<?php endif; ?>

<div class="card card-stat border-0 shadow-sm">
    <div class="card-body p-4">
        <div class="table-responsive">
            <table class="table align-middle table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Order ID</th>
                        <th>Customer Name</th>
                        <th>Date</th>
                        <th>Total Amount</th>
                        <th>Payment</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($orders)): ?>
                        <tr><td colspan="7" class="text-center py-4">No orders found.</td></tr>
                    <?php else: ?>
                        <?php foreach($orders as $order): ?>
                        <tr>
                            <td class="fw-bold text-primary">#ORD-<?php echo $order['id']; ?></td>
                            <td><?php echo htmlspecialchars($order['first_name'] . ' ' . $order['last_name']); ?></td>
                            <td><?php echo date('M d, Y', strtotime($order['created_at'])); ?></td>
                            <td class="fw-bold">₹<?php echo number_format($order['total_amount'], 2); ?></td>
                            <td><?php echo strtoupper($order['payment_method']); ?></td>
                            <td>
                                <form method="POST" class="d-flex align-items-center">
                                    <input type="hidden" name="order_id" value="<?php echo $order['id']; ?>">
                                    <select name="status" class="form-select form-select-sm" style="width: 120px;" onchange="this.form.submit()">
                                        <option value="pending" <?php echo $order['status'] === 'pending' ? 'selected' : ''; ?>>Pending</option>
                                        <option value="shipped" <?php echo $order['status'] === 'shipped' ? 'selected' : ''; ?>>Shipped</option>
                                        <option value="delivered" <?php echo $order['status'] === 'delivered' ? 'selected' : ''; ?>>Delivered</option>
                                        <option value="cancelled" <?php echo $order['status'] === 'cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                                    </select>
                                    <input type="hidden" name="update_status" value="1">
                                </form>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-outline-primary rounded-pill px-3 view-details-btn" data-id="<?php echo $order['id']; ?>" data-bs-toggle="modal" data-bs-target="#orderDetailsModal">
                                    <i class="fa-solid fa-eye me-1"></i> View
                                </button>
                                <?php if(!empty($order['id_proof_path'])): ?>
                                <a href="../<?php echo htmlspecialchars($order['id_proof_path']); ?>" target="_blank" class="btn btn-sm btn-outline-danger rounded-pill px-3 mt-1 d-block w-100">
                                    <i class="fa-solid fa-id-card"></i> ID Proof
                                </a>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Order Details Modal -->
<div class="modal fade" id="orderDetailsModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-0 bg-light">
                <h5 class="modal-title brand-font">Order Details #<span id="displayOrderId"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <div id="itemsContainer">Loading...</div>
            </div>
        </div>
    </div>
</div>

<script>
document.querySelectorAll('.view-details-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        const id = this.getAttribute('data-id');
        document.getElementById('displayOrderId').innerText = id;
        document.getElementById('itemsContainer').innerHTML = 'Loading...';
        
        fetch('orders.php?details=' + id)
            .then(res => res.json())
            .then(data => {
                let html = '<ul class="list-group list-group-flush">';
                data.forEach(item => {
                    html += `<li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-0">${item.item_name}</h6>
                                    <small class="text-muted">${item.item_type} | ₹${item.price} x ${item.quantity}</small>
                                </div>
                                <span class="fw-bold">₹${(item.price * item.quantity).toFixed(2)}</span>
                             </li>`;
                });
                html += '</ul>';
                document.getElementById('itemsContainer').innerHTML = html;
            });
    });
});
</script>

        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

