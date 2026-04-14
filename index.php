<?php
require_once 'includes/db.php';
include 'includes/header.php';
?>

<!-- Hero Section -->
<section class="hero-section text-center">
    <div class="container">
        <h1 class="hero-title mb-3">Welcome to <span>Paws & Claws</span></h1>
        <p class="hero-subtitle">Your pet's happiness, health, and style start here.</p>
        <div class="mt-4">
            <a href="products.php" class="btn btn-primary-custom btn-lg me-3 mb-2">Shop Essentials</a>
            <a href="pets.php" class="btn btn-secondary-custom btn-lg mb-2">Adopt a Pet</a>
        </div>
    </div>
</section>

<!-- Categories Section -->
<section class="container mb-5">
    <div class="row text-center mb-4">
        <div class="col-12">
            <h2>Shop by Category</h2>
            <p class="text-muted">Find exactly what your furry friend needs.</p>
        </div>
    </div>
    <div class="row">
        <!-- Mock Categories -->
        <div class="col-6 col-md-3">
            <a href="products.php?category=food">
                <div class="category-card">
                    <i class="fa-solid fa-bone category-icon"></i>
                    <h5>Pet Food</h5>
                </div>
            </a>
        </div>
        <div class="col-6 col-md-3">
            <a href="products.php?category=accessories">
                <div class="category-card">
                    <i class="fa-solid fa-dog category-icon"></i>
                    <h5>Accessories</h5>
                </div>
            </a>
        </div>
        <div class="col-6 col-md-3">
            <a href="products.php?category=grooming">
                <div class="category-card">
                    <i class="fa-solid fa-bath category-icon"></i>
                    <h5>Grooming</h5>
                </div>
            </a>
        </div>
        <div class="col-6 col-md-3">
            <a href="products.php?category=medicine">
                <div class="category-card">
                    <i class="fa-solid fa-notes-medical category-icon"></i>
                    <h5>Medicines</h5>
                </div>
            </a>
        </div>
    </div>
</section>

<!-- Featured Products Section -->
<section class="container mb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Featured Products</h2>
        <a href="products.php" class="btn btn-outline-dark rounded-pill px-4 fw-bold">View All</a>
    </div>
    <div class="row">
        <!-- Mock Product 1 -->
        <div class="col-sm-6 col-md-4 col-lg-3">
            <div class="product-card">
                <span class="badge-category">Food</span>
                <a href="#" class="wishlist-btn"><i class="fa-regular fa-heart"></i></a>
                <div class="product-img-wrapper">
                    <!-- Placeholder image (using generic colored box for mock) -->
                    <img src="https://images.unsplash.com/photo-1589924691995-400dc9ce53ce?auto=format&fit=crop&w=300&q=80" alt="Product">
                </div>
                <div class="product-card-body">
                    <div class="rating">
                        <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star-half-stroke"></i>
                        <span class="text-muted ms-1">(120)</span>
                    </div>
                    <h5 class="product-title">Premium Dog Food - Chicken & Rice (5kg)</h5>
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div>
                            <span class="product-price">$24.99</span>
                            <span class="old-price">$30.00</span>
                        </div>
                    </div>
                    <button class="btn btn-primary-custom w-100 mt-3 add-to-cart-btn"><i class="fa-solid fa-cart-plus"></i> Add to Cart</button>
                </div>
            </div>
        </div>
        <!-- Mock Product 2 -->
        <div class="col-sm-6 col-md-4 col-lg-3">
            <div class="product-card">
                <span class="badge-category">Accessories</span>
                <a href="#" class="wishlist-btn"><i class="fa-regular fa-heart"></i></a>
                <div class="product-img-wrapper">
                    <img src="https://images.unsplash.com/photo-1523626752472-b55a628f1acc?auto=format&fit=crop&w=300&q=80" alt="Product">
                </div>
                <div class="product-card-body">
                    <div class="rating">
                        <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-regular fa-star"></i>
                        <span class="text-muted ms-1">(45)</span>
                    </div>
                    <h5 class="product-title">Interactive Cat Scratching Post with Toy</h5>
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div>
                            <span class="product-price">$18.50</span>
                        </div>
                    </div>
                    <button class="btn btn-primary-custom w-100 mt-3 add-to-cart-btn"><i class="fa-solid fa-cart-plus"></i> Add to Cart</button>
                </div>
            </div>
        </div>
        <!-- Mock Product 3 -->
        <div class="col-sm-6 col-md-4 col-lg-3">
            <div class="product-card">
                <span class="badge-category">Grooming</span>
                <a href="#" class="wishlist-btn"><i class="fa-regular fa-heart"></i></a>
                <div class="product-img-wrapper">
                    <img src="https://images.unsplash.com/photo-1516734212186-a967f81ad0d7?auto=format&fit=crop&w=300&q=80" alt="Product">
                </div>
                <div class="product-card-body">
                    <div class="rating">
                        <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                        <span class="text-muted ms-1">(89)</span>
                    </div>
                    <h5 class="product-title">Organic Oatmeal Pet Shampoo (500ml)</h5>
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div>
                            <span class="product-price">$12.99</span>
                        </div>
                    </div>
                    <button class="btn btn-primary-custom w-100 mt-3 add-to-cart-btn"><i class="fa-solid fa-cart-plus"></i> Add to Cart</button>
                </div>
            </div>
        </div>
        <!-- Mock Product 4 -->
        <div class="col-sm-6 col-md-4 col-lg-3">
            <div class="product-card">
                <span class="badge-category">Medicine</span>
                <a href="#" class="wishlist-btn"><i class="fa-regular fa-heart"></i></a>
                <div class="product-img-wrapper">
                    <img src="https://images.unsplash.com/photo-1583337130417-3346a1be7dee?auto=format&fit=crop&w=300&q=80" alt="Product">
                </div>
                <div class="product-card-body">
                    <div class="rating">
                        <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star-half-stroke"></i>
                        <span class="text-muted ms-1">(210)</span>
                    </div>
                    <h5 class="product-title">Advanced Flea & Tick Drops for Dogs</h5>
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div>
                            <span class="product-price">$35.00</span>
                            <span class="old-price">$45.00</span>
                        </div>
                    </div>
                    <button class="btn btn-primary-custom w-100 mt-3 add-to-cart-btn"><i class="fa-solid fa-cart-plus"></i> Add to Cart</button>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
