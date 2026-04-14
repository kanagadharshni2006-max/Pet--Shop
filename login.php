<?php
require_once 'includes/db.php';
include 'includes/header.php';
?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card shadow-md border-0 rounded-4">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <i class="fa-solid fa-paw fs-1 text-primary mb-3"></i>
                        <h3 class="brand-font fw-bold">Welcome Back</h3>
                        <p class="text-muted">Log in to manage your pets and orders.</p>
                    </div>
                    
                    <form>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Email Address</label>
                            <input type="email" class="form-control form-control-lg" placeholder="name@example.com" required>
                        </div>
                        <div class="mb-4">
                            <div class="d-flex justify-content-between">
                                <label class="form-label fw-bold">Password</label>
                                <a href="#" class="small text-decoration-none">Forgot Password?</a>
                            </div>
                            <input type="password" class="form-control form-control-lg" placeholder="Enter your password" required>
                        </div>
                        <div class="mb-4 form-check">
                            <input type="checkbox" class="form-check-input" id="rememberMe">
                            <label class="form-check-label text-muted small" for="rememberMe">Remember me for 30 days</label>
                        </div>
                        <button type="button" class="btn btn-primary-custom btn-lg w-100 mb-3" onclick="alert('Login simulation check')">Log In</button>
                        
                        <div class="text-center">
                            <p class="text-muted small">Don't have an account? <a href="register.php" class="fw-bold">Sign up</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
