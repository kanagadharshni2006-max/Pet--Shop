<?php
require_once 'includes/db.php';
include 'includes/header.php';
?>

<!-- SHOP HERO BANNER -->
<section class="py-5 bg-darker position-relative overflow-hidden mb-5">
    <div class="hero-mesh-gradient" style="opacity: 0.1;"></div>
    <div class="container py-4 position-relative z-3">
        <div class="row align-items-center">
            <div class="col-lg-6 text-white" data-aos="fade-right">
                <span class="text-primary-start fw-bold text-uppercase tracking-wider">Premium Store</span>
                <h1 class="display-4 brand-font mt-2">Boutique Essentials</h1>
                <p class="opacity-75">Curated nutrition, grooming, and luxury accessories for your companions.</p>
            </div>
            <div class="col-lg-6 d-none d-lg-block" data-aos="zoom-in">
                <img src="https://images.unsplash.com/photo-1583511655857-d19b40a7a54e?auto=format&fit=crop&w=800&q=80" class="img-fluid rounded-5 shadow-lg" alt="Happy Pet">
            </div>
        </div>
    </div>
</section>

<div class="container mb-5">
    <div class="row">
        <!-- SIDEBAR - NEAT & ELEGANT -->
        <div class="col-lg-3 mb-5">
            <div class="card-luxury p-4 shadow-sm" data-aos="fade-up">
                <h4 class="mb-4 brand-font text-dark">Filters</h4>
                
                <div class="mb-4">
                    <label class="category-pill mb-2">Search Catalog</label>
                    <div class="input-group">
                        <input type="text" class="form-control border-0 bg-light" placeholder="Search items...">
                        <button class="btn btn-dark" type="button"><i class="fa-solid fa-magnifying-glass"></i></button>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="category-pill mb-2">Categories</label>
                    <div class="d-flex flex-column gap-2">
                        <label class="d-flex align-items-center gap-2 cursor-pointer">
                            <input type="checkbox" checked> <span class="small fw-600">All Products</span>
                        </label>
                        <label class="d-flex align-items-center gap-2 cursor-pointer">
                            <input type="checkbox"> <span class="small fw-600">Premium Food</span>
                        </label>
                        <label class="d-flex align-items-center gap-2 cursor-pointer">
                            <input type="checkbox"> <span class="small fw-600">Accessories</span>
                        </label>
                        <label class="d-flex align-items-center gap-2 cursor-pointer">
                            <input type="checkbox"> <span class="small fw-600">Grooming</span>
                        </label>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="category-pill mb-2">Price Range</label>
                    <input type="range" class="form-range" min="0" max="5000">
                    <div class="d-flex justify-content-between text-muted x-small fw-bold">
                        <span>₹0</span>
                        <span>₹5000+</span>
                    </div>
                </div>
                
                <button class="btn-creative w-100 py-3 mt-3" style="font-size: 0.9rem;">Update Store</button>
            </div>
        </div>

        <!-- MAIN PRODUCTS GRID -->
        <div class="col-lg-9">
            <div class="row g-4">
                <?php 
                $stmt = $pdo->query("SELECT * FROM products");
                $productMocks = [
                    'https://images.unsplash.com/photo-1583337130417-3346a1be7dee?auto=format&fit=crop&w=500&q=80',
                    'https://images.unsplash.com/photo-1548550023-2bdb3c5beed7?auto=format&fit=crop&w=500&q=80',
                    'https://images.unsplash.com/photo-1535268647677-300dbf3d78d1?auto=format&fit=crop&w=500&q=80',
                    'https://images.unsplash.com/photo-1516734212186-a967f81ad0d7?auto=format&fit=crop&w=500&q=80'
                ];
                $idx = 0;
                while ($product = $stmt->fetch()):
                    $img = $productMocks[$idx % 4];
                    $idx++;
                ?>
                <div class="col-md-6 col-lg-4" data-aos="fade-up">
                    <div class="product-card-real">
                        <div class="product-img-box">
                            <img src="<?php echo $img; ?>" alt="<?php echo $product['name']; ?>">
                            <?php if($product['price'] < 500): ?>
                                <div class="product-badge" style="background: #22c55e; color: white;">Value Pick</div>
                            <?php endif; ?>
                            <button class="wish-btn addToWishlist" data-id="<?php echo $product['id']; ?>" data-type="product">
                                <i class="fa-solid fa-paw"></i>
                            </button>
                        </div>
                        <div class="product-info-real mt-3">
                            <div class="category-pill mb-1"><?php echo $product['category']; ?></div>
                            <h6 class="product-name-real mb-2"><?php echo htmlspecialchars($product['name']); ?></h6>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="price-real">₹<?php echo number_format($product['price'], 2); ?></span>
                                <button class="add-cart-mini addToCart" data-id="<?php echo $product['id']; ?>" data-type="product">
                                    <i class="fa-solid fa-cart-plus"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>
            
            <!-- Pagination - Real Website Look -->
            <div class="mt-5 pt-5 d-flex justify-content-center">
                <nav>
                    <ul class="pagination gap-2 border-0">
                        <li class="page-item active"><a class="page-link rounded-3 border-0" href="#">1</a></li>
                        <li class="page-item"><a class="page-link rounded-3 border-0 text-dark" href="#">2</a></li>
                        <li class="page-item"><a class="page-link rounded-3 border-0 text-dark" href="#">3</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>
<?php include 'includes/footer.php'; ?>
