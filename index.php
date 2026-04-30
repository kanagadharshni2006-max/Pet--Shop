<?php
require_once 'includes/db.php';

// Fetch top feedbacks for testimonials
$stmt = $pdo->query("SELECT f.*, u.first_name, u.last_name FROM feedbacks f JOIN users u ON f.user_id = u.id WHERE f.rating >= 4 ORDER BY f.created_at DESC LIMIT 4");
$testimonials = $stmt->fetchAll();

include 'includes/header.php';
?>

<!-- Hero Section -->
<section class="hero-section text-center py-5" style="background: linear-gradient(135deg, #fff5e6 0%, #ffffff 100%);">
    <div class="container py-5">
        <h1 class="hero-title mb-3" style="font-size: 3.5rem;">Find Your Perfect <span>Furry Friend</span></h1>
        <p class="hero-subtitle fs-5 text-muted mb-4">Your pet's happiness, health, and style start here.</p>
        <div class="mt-4">
            <a href="#categories" class="btn btn-primary-custom btn-lg me-3 px-5 rounded-pill shadow">Explore Categories</a>
            <?php if(!isset($_SESSION['user_id'])): ?>
                <a href="login.php" class="btn btn-outline-dark btn-lg px-5 rounded-pill">Getting Started</a>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Main Categories Section -->
<section id="categories" class="container py-5">
    <div class="row text-center mb-5">
        <div class="col-12">
            <h2 class="brand-font display-6">Shop by Animal</h2>
            <div class="mx-auto" style="width: 100px; height: 5px; background: var(--primary); border-radius: 5px; margin-bottom: 20px;"></div>
        </div>
    </div>
    <div class="row justify-content-center g-4">
        <div class="col-6 col-md-4 col-lg-3">
            <a href="pets.php?type=Dog" class="text-decoration-none">
                <div class="category-card p-4 text-center border-0 shadow-sm rounded-4 transition-all">
                    <img src="https://images.unsplash.com/photo-1543466835-00a7907e9de1?auto=format&fit=crop&w=150&q=80" class="rounded-circle mb-3 border border-4 border-white shadow-sm" style="width: 120px; height: 120px; object-fit: cover;">
                    <h4 class="text-dark">Dogs</h4>
                    <span class="text-muted small">View All Dogs</span>
                </div>
            </a>
        </div>
        <div class="col-6 col-md-4 col-lg-3">
            <a href="pets.php?type=Cat" class="text-decoration-none">
                <div class="category-card p-4 text-center border-0 shadow-sm rounded-4 transition-all">
                    <img src="https://images.unsplash.com/photo-1514888286974-6c03e2ca1dba?auto=format&fit=crop&w=150&q=80" class="rounded-circle mb-3 border border-4 border-white shadow-sm" style="width: 120px; height: 120px; object-fit: cover;">
                    <h4 class="text-dark">Cats</h4>
                    <span class="text-muted small">View All Cats</span>
                </div>
            </a>
        </div>
        <div class="col-6 col-md-4 col-lg-3">
            <a href="pets.php?type=Bird" class="text-decoration-none">
                <div class="category-card p-4 text-center border-0 shadow-sm rounded-4 transition-all">
                    <img src="https://images.unsplash.com/photo-1452857297128-d9c29adba80b?auto=format&fit=crop&w=150&q=80" class="rounded-circle mb-3 border border-4 border-white shadow-sm" style="width: 120px; height: 120px; object-fit: cover;">
                    <h4 class="text-dark">Birds</h4>
                    <span class="text-muted small">View All Birds</span>
                </div>
            </a>
        </div>
    </div>
</section>

<!-- Adoption vs Sale Section -->
<section class="bg-light py-5">
    <div class="container">
        <div class="row g-4 text-center">
            <div class="col-md-6">
                <div class="p-5 bg-white shadow-sm rounded-4 h-100">
                    <i class="fa-solid fa-heart text-danger display-4 mb-3"></i>
                    <h3 class="brand-font">Adopt a Pet</h3>
                    <p class="text-muted mb-4">Give a forever home to a rescue pet. These pets are looking for love and a safe haven.</p>
                    <a href="pets.php?status=available&price=0" class="btn btn-secondary-custom px-4 rounded-pill">View Adoption List</a>
                </div>
            </div>
            <div class="col-md-6">
                <div class="p-5 bg-white shadow-sm rounded-4 h-100">
                    <i class="fa-solid fa-tag text-primary display-4 mb-3"></i>
                    <h3 class="brand-font">Pets for Sale</h3>
                    <p class="text-muted mb-4">Find premium breeds and healthy companions from verified pet caregivers.</p>
                    <a href="pets.php?status=available&min_price=1" class="btn btn-primary-custom px-4 rounded-pill">View Pets for Sale</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Quick Products Access -->
<section class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="brand-font">Featured Supplies</h2>
        <a href="gallery.php" class="btn btn-link text-primary text-decoration-none fw-bold">Visit Gallery <i class="fa-solid fa-arrow-right"></i></a>
    </div>
    <div class="row g-4 text-center">
        <div class="col-md-3">
             <a href="products.php?category=food" class="btn btn-outline-dark w-100 py-3 border-2 rounded-4">Pet Food</a>
        </div>
        <div class="col-md-3">
             <a href="products.php?category=accessories" class="btn btn-outline-dark w-100 py-3 border-2 rounded-4">Accessories</a>
        </div>
        <div class="col-md-3">
             <a href="products.php?category=grooming" class="btn btn-outline-dark w-100 py-3 border-2 rounded-4">Grooming</a>
        </div>
        <div class="col-md-3">
             <a href="products.php?category=medicine" class="btn btn-outline-dark w-100 py-3 border-2 rounded-4">Medicine</a>
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<?php if(!empty($testimonials)): ?>
<section class="bg-light py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="brand-font display-6">Happy Pet Parents</h2>
            <div class="mx-auto" style="width: 100px; height: 5px; background: var(--primary); border-radius: 5px;"></div>
        </div>
        <div class="row g-4 justify-content-center">
            <?php foreach($testimonials as $testimony): ?>
            <div class="col-md-6 col-lg-3">
                <div class="card border-0 shadow-sm rounded-4 h-100 p-4 text-center transition-all category-card">
                    <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($testimony['first_name'] . ' ' . $testimony['last_name']); ?>&background=random&color=fff&size=80" class="rounded-circle mx-auto mb-3 shadow-sm" style="width: 80px; height: 80px;" alt="Avatar">
                    <h5 class="fw-bold mb-1"><?php echo htmlspecialchars($testimony['first_name']); ?></h5>
                    <p class="small text-primary fw-bold mb-2"><?php echo htmlspecialchars($testimony['item_name']); ?></p>
                    <div class="mb-3">
                        <?php for($i=1; $i<=5; $i++): ?>
                            <i class="fa-solid fa-star <?php echo $i <= $testimony['rating'] ? 'text-warning' : 'text-secondary opacity-25'; ?>"></i>
                        <?php endfor; ?>
                    </div>
                    <p class="text-muted small fst-italic">"<?php echo htmlspecialchars($testimony['comment']); ?>"</p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<?php include 'includes/footer.php'; ?>
