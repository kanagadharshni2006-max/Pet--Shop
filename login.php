<?php
ob_start();
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if(session_status() === PHP_SESSION_NONE) { session_start(); }
require_once 'includes/db.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    
    if (empty($email) || empty($password)) {
        $error = 'Please enter both email and password.';
    } else {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();
        
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['first_name'] = $user['first_name'];
            $redirect = !empty($_REQUEST['redirect']) ? $_REQUEST['redirect'] : 'profile.php';
            header("Location: $redirect");
            exit();
        } else {
            $error = 'Invalid email or password.';
        }
    }
}
include 'includes/header.php';
?>

<!-- Elegant Luxury Login -->
<div class="auth-wrapper" style="background-image: url('https://images.unsplash.com/photo-1450778869180-41d0601e046e?auto=format&fit=crop&w=1920&q=80');">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-7 col-lg-5">
                <div class="auth-card p-4 p-md-5">
                    <div class="text-center mb-5">
                        <i class="fa-solid fa-paw fs-1 mb-3" style="color: var(--primary-start);"></i>
                        <h2 class="brand-font display-6 text-white mb-2" style="font-weight: 300;">Welcome <span style="font-weight: 800;">Back</span></h2>
                        <p class="text-muted">Enter your credentials to access your account</p>
                    </div>

                    <?php if(!empty($error)): ?>
                        <div class="alert alert-danger border-0 rounded-4 small mb-4" style="background: rgba(220, 38, 38, 0.2); color: #fca5a5;">
                            <i class="fa-solid fa-circle-exclamation me-2"></i> <?php echo htmlspecialchars($error); ?>
                        </div>
                    <?php endif; ?>

                    <form method="POST">
                        <input type="hidden" name="redirect" value="<?php echo htmlspecialchars($_REQUEST['redirect'] ?? ''); ?>">
                        
                        <div class="mb-4">
                            <label class="form-label fw-bold small text-uppercase text-muted opacity-75">Email Address</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fa-regular fa-envelope"></i></span>
                                <input type="email" name="email" class="form-control form-control-elegant" placeholder="your@email.com" value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>" required>
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <div class="d-flex justify-content-between mb-1">
                                <label class="form-label fw-bold small text-uppercase text-muted opacity-75">Password</label>
                                <a href="#" class="small text-decoration-none fw-bold" style="color: var(--primary-start);">Forgot?</a>
                            </div>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
                                <input type="password" name="password" class="form-control form-control-elegant" placeholder="••••••••" required>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary-custom w-100 py-3 mb-4 mt-2">
                            Sign In <i class="fa-solid fa-arrow-right-to-bracket ms-2"></i>
                        </button>
                        
                        <div class="text-center">
                            <p class="text-muted small m-0">Don't have an account? <a href="register.php" class="fw-bold text-white text-decoration-none">Register Now</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
