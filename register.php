<?php
require_once 'includes/db.php';
include 'includes/header.php';
?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-7">
            <div class="card shadow-md border-0 rounded-4">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <i class="fa-solid fa-user-plus fs-1 text-primary mb-3"></i>
                        <h3 class="brand-font fw-bold">Create an Account</h3>
                        <p class="text-muted">Join our community of pet lovers.</p>
                    </div>
                    
                    <form>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">First Name</label>
                                <input type="text" class="form-control form-control-lg" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Last Name</label>
                                <input type="text" class="form-control form-control-lg" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Email Address</label>
                            <input type="email" class="form-control form-control-lg" placeholder="name@example.com" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Phone Number</label>
                            <input type="tel" class="form-control form-control-lg" placeholder="+1 234 567 890" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Password</label>
                                <input type="password" class="form-control form-control-lg" required>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-bold">Confirm Password</label>
                                <input type="password" class="form-control form-control-lg" required>
                            </div>
                        </div>
                        
                        <div class="mb-4 form-check">
                            <input type="checkbox" class="form-check-input" id="terms" required>
                            <label class="form-check-label text-muted small" for="terms">I agree to the <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a>.</label>
                        </div>
                        
                        <button type="button" class="btn btn-primary-custom w-100 btn-lg mb-4 shadow" onclick="alert('Registration simulation successful!')">Sign Up</button>
                        
                        <div class="text-center">
                            <p class="text-muted small">Already have an account? <a href="login.php" class="fw-bold">Log In</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
