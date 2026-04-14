<?php
$currentPage = basename($_SERVER['PHP_SELF']);
?>
<div class="sidebar p-3" style="width: 250px;">
    <a href="index.php" class="d-flex align-items-center mb-4 text-decoration-none text-dark p-2">
        <i class="fa-solid fa-paw fs-3 text-primary me-2"></i>
        <span class="fs-4 fw-bold brand-font" style="color:var(--primary-color);">Paws&Claws</span>
    </a>
    <hr class="text-muted">
    <div class="mt-3">
        <a href="index.php" class="sidebar-link <?php echo $currentPage == 'index.php' ? 'active' : ''; ?>">
            <i class="fa-solid fa-house"></i> Dashboard
        </a>
        <a href="products.php" class="sidebar-link <?php echo $currentPage == 'products.php' ? 'active' : ''; ?>">
            <i class="fa-solid fa-box"></i> Products
        </a>
        <a href="pets.php" class="sidebar-link <?php echo $currentPage == 'pets.php' ? 'active' : ''; ?>">
            <i class="fa-solid fa-dog"></i> Pets
        </a>
        <a href="orders.php" class="sidebar-link <?php echo $currentPage == 'orders.php' ? 'active' : ''; ?>">
            <i class="fa-solid fa-cart-arrow-down"></i> Orders
        </a>
        <a href="users.php" class="sidebar-link <?php echo $currentPage == 'users.php' ? 'active' : ''; ?>">
            <i class="fa-solid fa-users"></i> Users
        </a>
        <hr class="text-muted">
        <a href="../index.php" class="sidebar-link mt-auto bg-light text-dark">
            <i class="fa-solid fa-globe"></i> View Website
        </a>
    </div>
</div>
