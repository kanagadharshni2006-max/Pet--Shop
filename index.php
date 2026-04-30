<?php
require_once 'includes/db.php';

// Fetch top feedbacks for testimonials
$stmt = $pdo->query("SELECT f.*, u.first_name, u.last_name FROM feedbacks f JOIN users u ON f.user_id = u.id WHERE f.rating >= 4 ORDER BY f.created_at DESC LIMIT 4");
$testimonials = $stmt->fetchAll();

include 'includes/header.php';
?>

<!-- Full-Width Hero Section with Background Image -->
<section class="hero-section-alt">
    <!-- Overlay for Fade Effect -->
    <div class="hero-overlay"></div>
    
    <div class="container position-relative z-3 py-5">
        <div class="row min-vh-75 align-items-center justify-content-center text-center">
            <div class="col-lg-8">
                <div class="glass-container p-5 rounded-5 fade-in">
                    <h1 class="brand-font mb-4 text-white" style="font-size: clamp(2.5rem, 8vw, 4.5rem); line-height: 1.1;">
                        Your Pet's <br> <span>Perfect Journey</span> <br> Starts Here
                    </h1>
                    <p class="text-white opacity-75 fs-5 mb-5 px-lg-5">
                        Discover premium supplies, lovable companions, and world-class care — all in one place.
                    </p>
                    <div class="d-flex flex-column flex-sm-row gap-3 justify-content-center">
                        <a href="#categories" class="btn btn-primary-custom px-5 py-3">Explore Categories</a>
                        <a href="pets.php" class="btn btn-outline-light px-5 py-3 rounded-4 fw-bold">Adopt a Pet</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Stats Bar (Moved below the hero) -->
<div class="container position-relative" style="margin-top: -60px; z-index: 10;">
    <div class="stats-container">
        <div class="row g-4 text-center">
            <div class="col-6 col-md-3 stat-item">
                <h2>2.5k+</h2>
                <p>Adopted</p>
            </div>
            <div class="col-6 col-md-3 stat-item">
                <h2>500+</h2>
                <p>Breeds</p>
            </div>
            <div class="col-6 col-md-3 stat-item">
                <h2>12k+</h2>
                <p>Supplies</p>
            </div>
            <div class="col-6 col-md-3 stat-item">
                <h2>100%</h2>
                <p>Verified</p>
            </div>
        </div>
    </div>
</div>

<!-- Main Categories Section -->
<section id="categories" class="container py-5 mt-5">
    <div class="row text-center mb-5">
        <div class="col-12">
            <h2 class="brand-font display-6">Shop by Animal</h2>
            <div class="mx-auto" style="width: 60px; height: 4px; background: linear-gradient(to right, var(--primary-start), var(--primary-end)); border-radius: 5px; margin-bottom: 20px;"></div>
        </div>
    </div>
    <div class="row justify-content-center g-4">
        <?php 
        $cats = [
            ['name' => 'Dogs', 'type' => 'Dog', 'img' => 'https://images.unsplash.com/photo-1543466835-00a7907e9de1?auto=format&fit=crop&w=300&q=80'],
            ['name' => 'Cats', 'type' => 'Cat', 'img' => 'https://images.unsplash.com/photo-1514888286974-6c03e2ca1dba?auto=format&fit=crop&w=300&q=80'],
            ['name' => 'Birds', 'type' => 'Bird', 'img' => 'https://images.unsplash.com/photo-1452857297128-d9c29adba80b?auto=format&fit=crop&w=300&q=80'],
            ['name' => 'Small Pets', 'type' => 'Small', 'img' => 'https://images.unsplash.com/photo-1533616688419-b7a585564566?auto=format&fit=crop&w=300&q=80']
        ];
        foreach($cats as $c):
        ?>
        <div class="col-6 col-md-4 col-lg-3">
            <a href="pets.php?type=<?php echo $c['type']; ?>" class="text-decoration-none">
                <div class="card-elegant text-center h-100">
                    <img src="<?php echo $c['img']; ?>" class="rounded-circle mb-3 border border-5 border-white shadow-sm" style="width: 120px; height: 120px; object-fit: cover;">
                    <h5 class="text-dark fw-bold mb-1"><?php echo $c['name']; ?></h5>
                    <span class="text-muted small fw-bold text-uppercase" style="font-size: 0.6rem; letter-spacing: 1px;">View All</span>
                </div>
            </a>
        </div>
        <?php endforeach; ?>
    </div>
</section>

<!-- Testimonials Section -->
<?php if(!empty($testimonials)): ?>
<section class="py-5 bg-light mt-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="brand-font display-6">Happy Pet Parents</h2>
            <div class="mx-auto" style="width: 60px; height: 4px; background: linear-gradient(to right, var(--primary-start), var(--primary-end)); border-radius: 5px;"></div>
        </div>
        <div class="row g-4 justify-content-center">
            <?php foreach($testimonials as $testimony): ?>
            <div class="col-md-6 col-lg-3">
                <div class="card-elegant h-100 text-center">
                    <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($testimony['first_name'] . ' ' . $testimony['last_name']); ?>&background=random&color=fff&size=60" class="rounded-circle mx-auto mb-3 shadow-sm" style="width: 60px; height: 60px;" alt="Avatar">
                    <h6 class="fw-bold mb-1"><?php echo htmlspecialchars($testimony['first_name']); ?></h6>
                    <div class="mb-3" style="font-size: 0.7rem;">
                        <?php for($i=1; $i<=5; $i++): ?>
                            <i class="fa-solid fa-star <?php echo $i <= $testimony['rating'] ? 'text-warning' : 'text-secondary opacity-25'; ?>"></i>
                        <?php endfor; ?>
                    </div>
                    <p class="text-muted small fst-italic mb-0">"<?php echo htmlspecialchars($testimony['comment']); ?>"</p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<?php include 'includes/footer.php'; ?>
