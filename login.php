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

<div class="auth-wrapper">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10 col-xl-9">
                <div class="auth-card row g-0">
                    <!-- Image Side -->
                    <div class="col-md-6 d-none d-md-block auth-image" style="background-image: url('https://images.unsplash.com/photo-1548199973-03cce0bbc87b?auto=format&fit=crop&w=800&q=80');">
                        <div class="h-100 w-100 d-flex align-items-end p-5" style="background: linear-gradient(to top, rgba(0,0,0,0.6), transparent);">
                            <div class="text-white">
                                <h2 class="display-6 fw-bold mb-2">Welcome Back!</h2>
                                <p class="opacity-75">Access your account and take care of your furry friends today.</p>
                            </div>
                        </div>
                    </div>
                    <!-- Form Side -->
                    <div class="col-md-6 p-4 p-lg-5">
                        <div class="text-center mb-5">
                            <h2 class="brand-font h1 mb-2">Log In</h2>
                            <p class="text-muted">Enter your details to continue</p>
                        </div>

                        <?php if(!empty($error)): ?>
                            <div class="alert alert-danger border-0 rounded-3 small mb-4" role="alert">
                                <i class="fa-solid fa-circle-exclamation me-2"></i> <?php echo htmlspecialchars($error); ?>
                            </div>
                        <?php endif; ?>

                        <form method="POST" action="">
                            <input type="hidden" name="redirect" value="<?php echo htmlspecialchars($_REQUEST['redirect'] ?? ''); ?>">
                            
                            <div class="mb-4">
                                <label class="form-label fw-bold small text-uppercase text-muted">Email Address</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0 rounded-start-3"><i class="fa-regular fa-envelope text-muted"></i></span>
                                    <input type="email" name="email" class="form-control form-control-elegant border-start-0 rounded-end-3" placeholder="your@email.com" value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>" required>
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <div class="d-flex justify-content-between mb-1">
                                    <label class="form-label fw-bold small text-uppercase text-muted">Password</label>
                                    <a href="#" class="small text-decoration-none fw-bold">Forgot?</a>
                                </div>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0 rounded-start-3"><i class="fa-solid fa-lock text-muted"></i></span>
                                    <input type="password" name="password" class="form-control form-control-elegant border-start-0 rounded-end-3" placeholder="••••••••" required>
                                </div>
                            </div>

                            <div class="mb-4 d-flex justify-content-between align-items-center">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="remember">
                                    <label class="form-check-label small text-muted" for="remember">Remember me</label>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary-custom w-100 py-3 mb-4">
                                Sign In <i class="fa-solid fa-arrow-right-to-bracket ms-2"></i>
                            </button>
                            
                            <div class="text-center">
                                <p class="text-muted small m-0">Don't have an account? <a href="register.php" class="fw-bold text-primary-start">Register Now</a></p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
