<?php
require_once 'includes/db.php';
include 'includes/header.php';

// Functional Filter Logic
$where = [];
$params = [];

if(!empty($_GET['search'])) {
    $where[] = "name LIKE ?";
    $params[] = "%" . $_GET['search'] . "%";
}

if(!empty($_GET['category'])) {
    $where[] = "category = ?";
    $params[] = $_GET['category'];
}

if(!empty($_GET['max_price'])) {
    $where[] = "price <= ?";
    $params[] = $_GET['max_price'];
}

$sql = "SELECT * FROM products";
if(count($where) > 0) {
    $sql .= " WHERE " . implode(" AND ", $where);
}

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$products = $stmt->fetchAll();

$productMocks = [
    'https://images.unsplash.com/photo-1583337130417-3346a1be7dee?auto=format&fit=crop&w=500&q=80',
    'https://images.unsplash.com/photo-1548550023-2bdb3c5beed7?auto=format&fit=crop&w=500&q=80',
    'https://images.unsplash.com/photo-1535268647677-300dbf3d78d1?auto=format&fit=crop&w=500&q=80',
    'https://images.unsplash.com/photo-1516734212186-a967f81ad0d7?auto=format&fit=crop&w=500&q=80'
];
?>

<!-- SHOP HERO BANNER -->
<section class="py-5 bg-darker position-relative overflow-hidden mb-5" style="min-height: 400px; display: flex; align-items: center;">
    <div class="hero-mesh-gradient" style="opacity: 0.2;"></div>
    <div class="container position-relative z-3">
        <div class="row align-items-center">
            <div class="col-lg-7 text-white" data-aos="fade-right">
                <div class="hero-badge mb-3"><span>NEW</span> Winter Collection Now Live</div>
                <h1 class="display-3 brand-font mb-3">Premium <span class="text-gradient">Essentials</span></h1>
                <p class="fs-5 opacity-75 mb-0">Discover a curated world of luxury nutrition, professional grooming, and artisanal accessories crafted for your companions.</p>
            </div>
        </div>
    </div>
</section>

<div class="container mb-5 pb-5">
    <div class="row g-5">
        <!-- SIDEBAR - NEAT & ELEGANT -->
        <div class="col-lg-3">
            <div class="card-luxury p-4 sticky-top" style="top: 100px;" data-aos="fade-up">
                <h4 class="mb-4 brand-font text-dark d-flex align-items-center gap-2">
                    <i class="fa-solid fa-sliders text-primary-start fs-5"></i> Filters
                </h4>
                
                <form action="products.php" method="GET">
                    <div class="mb-5">
                        <label class="filter-group-title">Search Catalog</label>
                        <div class="input-group bg-light rounded-4 overflow-hidden border">
                            <span class="input-group-text border-0 bg-transparent ps-3"><i class="fa-solid fa-magnifying-glass opacity-50"></i></span>
                            <input type="text" name="search" class="form-control border-0 bg-transparent py-3 ps-1" placeholder="Search..." value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                        </div>
                    </div>

                    <div class="mb-5">
                        <label class="filter-group-title">Categories</label>
                        <div class="d-flex flex-column gap-1">
                            <label class="custom-radio">
                                <input type="radio" name="category" value="" <?php echo !isset($_GET['category']) || $_GET['category'] == '' ? 'checked' : ''; ?>> 
                                <span class="small fw-600">All Products</span>
                            </label>
                            <label class="custom-radio">
                                <input type="radio" name="category" value="Food" <?php echo isset($_GET['category']) && $_GET['category'] == 'Food' ? 'checked' : ''; ?>> 
                                <span class="small fw-600">Premium Food</span>
                            </label>
                            <label class="custom-radio">
                                <input type="radio" name="category" value="Accessories" <?php echo isset($_GET['category']) && $_GET['category'] == 'Accessories' ? 'checked' : ''; ?>> 
                                <span class="small fw-600">Accessories</span>
                            </label>
                            <label class="custom-radio">
                                <input type="radio" name="category" value="Grooming" <?php echo isset($_GET['category']) && $_GET['category'] == 'Grooming' ? 'checked' : ''; ?>> 
                                <span class="small fw-600">Grooming</span>
                            </label>
                            <label class="custom-radio">
                                <input type="radio" name="category" value="Medicine" <?php echo isset($_GET['category']) && $_GET['category'] == 'Medicine' ? 'checked' : ''; ?>> 
                                <span class="small fw-600">Health & Care</span>
                            </label>
                        </div>
                    </div>

                    <div class="mb-5">
                        <label class="filter-group-title">Max Price</label>
                        <div class="px-2">
                            <input type="range" name="max_price" class="form-range" min="0" max="5000" step="100" 
                                   value="<?php echo isset($_GET['max_price']) ? $_GET['max_price'] : '5000'; ?>" 
                                   oninput="this.nextElementSibling.querySelector('span').innerText = this.value">
                            <div class="text-dark fw-800 mt-2 d-flex justify-content-between">
                                <span class="opacity-50 small">₹0</span>
                                <span class="text-primary-start">₹<span><?php echo isset($_GET['max_price']) ? $_GET['max_price'] : '5000'; ?></span></span>
                            </div>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn-creative w-100 py-3 mt-2 shadow-none border-0">Apply Filters</button>
                    
                    <?php if(!empty($_GET)): ?>
                        <a href="products.php" class="btn btn-link btn-sm w-100 mt-3 text-decoration-none text-muted fw-bold">
                            <i class="fa-solid fa-rotate-left me-1"></i> Clear All
                        </a>
                    <?php endif; ?>
                </form>
            </div>
        </div>

        <!-- MAIN PRODUCTS GRID -->
        <div class="col-lg-9">
            <?php if (count($products) > 0): ?>
                <div class="row g-4">
                    <?php 
                    $idx = 0;
                    foreach ($products as $product):
                        $img = $productMocks[$idx % 4];
                        $idx++;
                    ?>
                    <div class="col-md-6 col-xl-4" data-aos="fade-up" data-aos-delay="<?php echo ($idx % 3) * 100; ?>">
                        <div class="product-card-premium">
                            <button class="wishlist-float wish-btn" data-id="<?php echo $product['id']; ?>" data-type="product">
                                <i class="fa-regular fa-heart"></i>
                            </button>
                            
                            <div class="product-img-wrapper">
                                <img src="<?php echo $img; ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                                <div class="product-overlay">
                                    <button class="overlay-btn buyNow" 
                                            data-id="<?php echo $product['id']; ?>" 
                                            data-name="<?php echo htmlspecialchars($product['name']); ?>" 
                                            data-price="<?php echo $product['price']; ?>" 
                                            data-image="<?php echo $img; ?>" 
                                            data-category="<?php echo $product['category']; ?>"
                                            title="Buy Now">
                                        <i class="fa-solid fa-bolt"></i>
                                    </button>
                                    <button class="overlay-btn addToCart" 
                                            data-id="<?php echo $product['id']; ?>" 
                                            data-name="<?php echo htmlspecialchars($product['name']); ?>" 
                                            data-price="<?php echo $product['price']; ?>" 
                                            data-image="<?php echo $img; ?>" 
                                            data-category="<?php echo $product['category']; ?>"
                                            title="Add to Cart">
                                        <i class="fa-solid fa-cart-plus"></i>
                                    </button>
                                </div>
                            </div>
                            
                            <div class="product-content-premium">
                                <span class="product-tag"><?php echo htmlspecialchars($product['category']); ?></span>
                                <h3 class="product-title-premium"><?php echo htmlspecialchars($product['name']); ?></h3>
                                <div class="product-footer-premium">
                                    <span class="product-price-premium">₹<?php echo number_format($product['price'], 2); ?></span>
                                    <div class="small text-muted"><i class="fa-solid fa-star text-warning me-1"></i> 4.8</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>

                <!-- Pagination -->
                <div class="mt-5 pt-5 d-flex justify-content-center">
                    <nav>
                        <ul class="pagination gap-3 border-0">
                            <li class="page-item active"><a class="page-link rounded-4 border-0 shadow-sm" href="#">1</a></li>
                            <li class="page-item"><a class="page-link rounded-4 border-0 shadow-sm text-dark" href="#">2</a></li>
                            <li class="page-item"><a class="page-link rounded-4 border-0 shadow-sm text-dark" href="#"><i class="fa-solid fa-chevron-right fs-xs"></i></a></li>
                        </ul>
                    </nav>
                </div>
            <?php else: ?>
                <div class="empty-state" data-aos="zoom-in">
                    <div class="empty-icon"><i class="fa-solid fa-box-open"></i></div>
                    <h2 class="brand-font mb-3">No matches found</h2>
                    <p class="text-muted mb-4">We couldn't find any products matching your current filters.</p>
                    <a href="products.php" class="btn-creative">Browse All Products</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>

<script>
// Auto-submit filters on category or price change
document.querySelectorAll('input[name="category"], input[name="max_price"]').forEach(input => {
    input.addEventListener('change', () => {
        input.closest('form').submit();
    });
});
</script>
