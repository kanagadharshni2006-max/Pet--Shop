<?php 
require_once '../includes/db.php';
include 'layout/header.php'; 

$success_msg = '';
$error_msg = '';

// Handle Delete
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
    if ($stmt->execute([$id])) {
        $success_msg = "User deleted successfully!";
    } else {
        $error_msg = "Failed to delete user.";
    }
}

// Fetch users
$users = $pdo->query("SELECT * FROM users ORDER BY created_at DESC")->fetchAll();
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="brand-font">Manage Users</h3>
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
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Joined</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($users)): ?>
                        <tr><td colspan="6" class="text-center py-4">No users found.</td></tr>
                    <?php else: ?>
                        <?php foreach($users as $user): ?>
                        <tr>
                            <td class="fw-bold text-muted"><?php echo $user['id']; ?></td>
                            <td>
                                <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($user['first_name'] . ' ' . $user['last_name']); ?>&background=f2a65a&color=fff" class="rounded-circle me-3 shadow-sm" width="40">
                                <strong class="fs-6"><?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?></strong>
                            </td>
                            <td><?php echo htmlspecialchars($user['email']); ?></td>
                            <td><?php echo htmlspecialchars($user['phone']); ?></td>
                            <td><?php echo date('M Y', strtotime($user['created_at'])); ?></td>
                            <td>
                                <a href="?delete=<?php echo $user['id']; ?>" class="btn btn-sm btn-outline-danger rounded-pill px-3" onclick="return confirm('Are you sure you want to delete this user?')">
                                    <i class="fa-solid fa-user-slash"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

