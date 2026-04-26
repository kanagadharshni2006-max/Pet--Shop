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
            $redirect = $_REQUEST['redirect'] ?? 'profile.php';
            header("Location: $redirect");
            exit();
        } else {
            $error = 'Invalid email or password.';
        }
    }
}
include 'includes/header.php';
?>

<div class="container py-5 fade-in">
    <div class="row justify-content-center align-items-center" style="min-height: 80vh;">
        <div class="col-md-5">
            <div class="card border-0 shadow-float rounded-4 overflow-hidden">
                <div class="card-body p-5">
                    <div class="text-center mb-5">
                        <div class="display-5 mb-3"><i class="fa-solid fa-shield-cat text-primary"></i></div>
                        <h2 class="brand-font h1 mb-1">Welcome Back</h2>
                        <p class="text-muted">Enter your credentials to access your pet sanctuary.</p>
                    </div>

                    <?php if(!empty($error)): ?>
                        <div class="alert alert-danger border-0 rounded-3 small mb-4" role="alert">
                            <i class="fa-solid fa-circle-exclamation me-2"></i> <?php echo htmlspecialchars($error); ?>
                        </div>
                    <?php endif; ?>

                    <form method="POST" action="">
                        <input type="hidden" name="redirect" value="<?php echo htmlspecialchars($_REQUEST['redirect'] ?? ''); ?>">
                        
                        <div class="mb-4">
                            <label class="form-label fw-bold small text-uppercase tracking-wider text-muted">Email Address</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0"><i class="fa-regular fa-envelope text-muted"></i></span>
                                <input type="email" name="email" class="form-control" placeholder="your@email.com" value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>" required>
                            </div>
                        </div>
                        <div class="mb-4">
                            <div class="d-flex justify-content-between mb-2">
                                <label class="form-label fw-bold small text-uppercase tracking-wider text-muted m-0">Password</label>
                                <a href="#" class="small text-decoration-none fw-bold">Forgot?</a>
                            </div>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0"><i class="fa-solid fa-lock text-muted"></i></span>
                                <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                            </div>
                        </div>

                        <div class="mb-4 form-check">
                            <input type="checkbox" class="form-check-input" id="remember">
                            <label class="form-check-label small text-muted" for="remember">Keep me logged in for 30 days</label>
                        </div>

                        <button type="submit" class="btn btn-primary-custom w-100 py-3 mb-4 fs-5">
                            Log In <i class="fa-solid fa-arrow-right-to-bracket ms-2"></i>
                        </button>
                        
                        <div class="text-center">
                            <p class="text-muted small m-0">New here? <a href="register.php" class="fw-bold text-primary">Create an account</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>

