<?php
require_once 'includes/db.php';

// Fetch top feedbacks for testimonials
$stmt = $pdo->query("SELECT f.*, u.first_name, u.last_name FROM feedbacks f JOIN users u ON f.user_id = u.id WHERE f.rating >= 4 ORDER BY f.created_at DESC LIMIT 4");
$testimonials = $stmt->fetchAll();

include 'includes/header.php';
?>

<!-- Hero Section -->
<section class="hero-section overflow-hidden">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 text-center text-lg-start mb-5 mb-lg-0">
                <h1 class="brand-font mb-4" style="font-size: clamp(2.8rem, 7vw, 4.2rem); line-height: 1.1;">
                    Your Pet's <br> <span>Perfect Journey</span> <br> Starts Here
                </h1>
                <p class="text-muted fs-5 mb-5 pe-lg-5">
                    Premium supplies, lovable companions, and world-class care — all tailored for your furry family members.
                </p>
                <div class="d-flex flex-column flex-sm-row gap-3 justify-content-center justify-content-lg-start">
                    <a href="#categories" class="btn btn-primary-custom">Explore Categories</a>
                    <a href="pets.php" class="btn btn-secondary-custom">Adopt a Pet</a>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="hero-img-container text-center">
                    <!-- Image -->
                    <img src="https://images.unsplash.com/photo-1583511655857-d19b40a7a54e?auto=format&fit=crop&w=800&q=80" class="img-fluid float-anim" alt="Hero Pet">
                    
                    <!-- Neater Floating Badges -->
                    <div class="glass-badge d-none d-md-flex" style="top: 10%; left: -5%;">
                        <div class="bg-danger p-2 rounded-circle text-white d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                            <i class="fa-solid fa-heart"></i>
                        </div>
                        <div>
                            <div class="fw-800 text-dark mb-0">10k+</div>
                            <div class="text-muted small fw-bold text-uppercase" style="font-size: 0.6rem;">Pet Lovers</div>
                        </div>
                    </div>
                    
                    <div class="glass-badge d-none d-md-flex" style="bottom: 15%; right: -5%;">
                        <div class="bg-warning p-2 rounded-circle text-white d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                            <i class="fa-solid fa-star"></i>
                        </div>
                        <div>
                            <div class="fw-800 text-dark mb-0">4.9 / 5</div>
                            <div class="text-muted small fw-bold text-uppercase" style="font-size: 0.6rem;">Customer Rating</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Bar Overlay -->
        <div class="stats-container mt-5">
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
</section>

<!-- Rest of the sections remain same but inherit neater styles from CSS -->
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
