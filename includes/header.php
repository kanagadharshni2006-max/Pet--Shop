<?php
// includes/header.php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if(session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paws & Claws - Modern Pet Shop</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
    <!-- Toastify CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <!-- AOS Animation CSS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
</head>
<body>

<!-- Navbar -->
<!-- Real Commercial Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark sticky-top py-3" style="background: rgba(2, 6, 23, 0.95); border-bottom: 1px solid rgba(255,255,255,0.05);">
    <div class="container">
        <a class="navbar-brand brand-font d-flex align-items-center" href="index.php">
            <div class="logo-box me-2">
                <i class="fa-solid fa-paw"></i>
            </div>
            <span>Paws<span class="text-gradient">&</span>Claws</span>
        </a>

        <!-- Search Bar - Real Website Feel -->
        <div class="d-none d-lg-flex mx-auto" style="width: 40%;">
            <form action="products.php" method="GET" class="w-100 position-relative">
                <input type="text" name="search" class="form-control bg-white bg-opacity-5 border-0 rounded-pill px-4 py-2 text-white" placeholder="Search for treats, toys, or pets..." style="font-size: 0.9rem;">
                <button class="btn position-absolute top-50 end-0 translate-middle-y border-0 text-muted pe-3">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
            </form>
        </div>

        <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
            <i class="fa-solid fa-bars-staggered text-white"></i>
        </button>
        
        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item"><a class="nav-link px-3 fw-600" href="index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link px-3 fw-600" href="products.php">Shop</a></li>
                <li class="nav-item"><a class="nav-link px-3 fw-600" href="pets.php">Adopt</a></li>
                <?php if(isset($_SESSION['user_id'])): ?>
                    <li class="nav-item">
                        <a class="nav-link btn-profile-nav ms-lg-3" href="profile.php">
                            <i class="fa-solid fa-circle-user me-2"></i>Profile
                        </a>
                    </li>
                <?php else: ?>
                    <li class="nav-item"><a class="nav-link px-3 fw-600" href="login.php">Login</a></li>
                <?php endif; ?>
                <li class="nav-item position-relative ms-lg-3">
                    <a class="nav-link" href="cart.php">
                        <div class="cart-icon-wrapper">
                            <i class="fa-solid fa-shopping-bag fs-5"></i>
                            <span class="cart-badge badge rounded-pill bg-primary-start position-absolute">
                                <?php 
                                $total_cart = 0;
                                if (isset($_SESSION['user_id'])) {
                                    $stmtCart = $pdo->prepare("SELECT SUM(quantity) FROM cart WHERE user_id = ?");
                                    $stmtCart->execute([$_SESSION['user_id']]);
                                    $total_cart = (int) $stmtCart->fetchColumn();
                                }
                                echo $total_cart; 
                                ?>
                            </span>
                        </div>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- PHP Session Toasts -->
<script>
window.addEventListener('DOMContentLoaded', (event) => {
    <?php if(isset($_SESSION['success'])): ?>
        showToast("<?php echo $_SESSION['success']; unset($_SESSION['success']); ?>", "success");
    <?php endif; ?>
    <?php if(isset($_SESSION['error'])): ?>
        showToast("<?php echo $_SESSION['error']; unset($_SESSION['error']); ?>", "error");
    <?php endif; ?>
});
</script>
