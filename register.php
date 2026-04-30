<?php
ob_start();
if(session_status() === PHP_SESSION_NONE) { session_start(); }
require_once 'includes/db.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = trim($_POST['first_name'] ?? '');
    $last_name = trim($_POST['last_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    
    if (empty($first_name) || empty($last_name) || empty($email) || empty($password)) {
        $error = 'Please fill out all required fields.';
    } elseif ($password !== $confirm_password) {
        $error = 'Passwords do not match.';
    } elseif (strlen($password) < 6) {
        $error = 'Password must be at least 6 characters.';
    } else {
        // Check if email exists
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            $error = 'Email is already registered. Please log in.';
        } else {
            // Insert
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO users (first_name, last_name, email, phone, password) VALUES (?, ?, ?, ?, ?)");
            if ($stmt->execute([$first_name, $last_name, $email, $phone, $hashed])) {
                $success = 'Registration successful! You can now log in.';
            } else {
                $error = 'Something went wrong. Please try again.';
            }
        }
    }
}
include 'includes/header.php';
?>

<!-- Elegant Luxury Register -->
<div class="auth-wrapper" style="background-image: url('https://images.unsplash.com/photo-1592194996308-7b43878e84a6?auto=format&fit=crop&w=1920&q=80');">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-xl-7">
                <div class="auth-card p-4 p-md-5">
                    <div class="text-center mb-5">
                        <i class="fa-solid fa-heart-pulse fs-1 mb-3" style="color: var(--primary-end);"></i>
                        <h2 class="brand-font display-6 text-white mb-2" style="font-weight: 300;">Create <span style="font-weight: 800;">Account</span></h2>
                        <p class="text-muted">Join our community and find your perfect pet companion</p>
                    </div>

                    <?php if(!empty($error)): ?>
                        <div class="alert alert-danger border-0 rounded-4 small mb-4" style="background: rgba(220, 38, 38, 0.2); color: #fca5a5;">
                            <i class="fa-solid fa-circle-exclamation me-2"></i> <?php echo htmlspecialchars($error); ?>
                        </div>
                    <?php endif; ?>
                    <?php if(!empty($success)): ?>
                        <div class="alert alert-success border-0 rounded-4 small mb-4" style="background: rgba(16, 185, 129, 0.2); color: #a7f3d0;">
                            <i class="fa-solid fa-circle-check me-2"></i> <?php echo htmlspecialchars($success); ?> 
                            <a href="login.php" class="alert-link fw-bold ms-1 text-white">Log in now</a>.
                        </div>
                    <?php endif; ?>

                    <form method="POST">
                        <div class="row g-3">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold small text-uppercase text-muted opacity-75">First Name</label>
                                <input type="text" name="first_name" class="form-control form-control-elegant" value="<?php echo htmlspecialchars($_POST['first_name'] ?? ''); ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold small text-uppercase text-muted opacity-75">Last Name</label>
                                <input type="text" name="last_name" class="form-control form-control-elegant" value="<?php echo htmlspecialchars($_POST['last_name'] ?? ''); ?>" required>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold small text-uppercase text-muted opacity-75">Email Address</label>
                            <input type="email" name="email" class="form-control form-control-elegant" placeholder="name@example.com" value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>" required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold small text-uppercase text-muted opacity-75">Phone Number</label>
                            <input type="tel" name="phone" class="form-control form-control-elegant" placeholder="+1 234 567 890" value="<?php echo htmlspecialchars($_POST['phone'] ?? ''); ?>" required>
                        </div>
                        
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-uppercase text-muted opacity-75">Password</label>
                                <input type="password" name="password" class="form-control form-control-elegant" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-uppercase text-muted opacity-75">Confirm</label>
                                <input type="password" name="confirm_password" class="form-control form-control-elegant" required>
                            </div>
                        </div>
                        
                        <button type="submit" class="btn btn-primary-custom w-100 py-3 mb-4">
                            Join Now <i class="fa-solid fa-user-check ms-2"></i>
                        </button>
                        
                        <div class="text-center">
                            <p class="text-muted small m-0">Already have an account? <a href="login.php" class="fw-bold text-white text-decoration-none">Sign In</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
