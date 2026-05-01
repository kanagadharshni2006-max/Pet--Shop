<?php
require_once 'includes/db.php';

// Fetch top feedbacks for testimonials
$stmt = $pdo->query("SELECT f.*, u.first_name, u.last_name FROM feedbacks f JOIN users u ON f.user_id = u.id WHERE f.rating >= 4 ORDER BY f.created_at DESC LIMIT 4");
$testimonials = $stmt->fetchAll();

// Fetch 4 featured products for the "Real Website" feel
$stmtProd = $pdo->query("SELECT * FROM products LIMIT 4");
$featuredProducts = $stmtProd->fetchAll();

include 'includes/header.php';
?>

<!-- REAL WEBSITE HERO -->
<section class="hero-creative">
    <div class="hero-mesh-gradient"></div>
    <div class="container position-relative z-3">
        <div class="row min-vh-100 align-items-center">
            <div class="col-lg-7" data-aos="fade-right">
                <div class="hero-badge mb-4"><span>✨ Elite</span> The World's Finest Pet Boutique</div>
                <h1 class="hero-title-creative mb-4">
                    Exceptional Care <br>
                    <span class="text-gradient">For Your Best Friends</span>
                </h1>
                <p class="hero-subtitle mb-5">
                    Experience a real standard in pet care. From luxury adoption to premium nutrition, we provide everything your companion deserves.
                </p>
                <div class="d-flex flex-wrap gap-4">
                    <a href="#featured-products" class="btn-creative">
                        Shop Collection <i class="fa-solid fa-cart-shopping ms-2"></i>
                    </a>
                    <a href="pets.php" class="btn-glass">Meet New Friends</a>
                </div>
                
                <!-- Trusted By Bar (Real Website Indicator) -->
                <div class="mt-5 pt-4 border-top border-white border-opacity-10">
                    <p class="small text-uppercase tracking-wider opacity-50 mb-3">Trusted by leading pet brands</p>
                    <div class="d-flex gap-4 opacity-25">
                        <i class="fa-solid fa-shield-cat fs-3"></i>
                        <i class="fa-solid fa-dog fs-3"></i>
                        <i class="fa-solid fa-bone fs-3"></i>
                        <i class="fa-solid fa-fish-fins fs-3"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 d-none d-lg-block" data-aos="zoom-in" data-aos-delay="200">
                <div class="hero-floating-card">
                    <img src="https://images.unsplash.com/photo-1517849845537-4d257902454a?auto=format&fit=crop&w=600&q=80" alt="Dog">
                    <div class="stats-float">
                        <div class="stat-bubble">
                            <i class="fa-solid fa-medal text-warning"></i>
                            <span>#1 Pet Boutique 2024</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- BENTO GRID CATEGORIES -->
<section id="bento-categories" class="py-5 bg-darker">
    <div class="container py-5">
        <div class="row mb-5 text-center" data-aos="fade-up">
            <div class="col-12">
                <span class="text-gradient fw-bold text-uppercase tracking-wider">Premium Collections</span>
                <h2 class="display-5 text-white brand-font mt-2">Browse by Category</h2>
            </div>
        </div>

        <div class="bento-grid">
            <div class="bento-item bento-lg" data-aos="fade-up">
                <a href="pets.php?type=Dog" class="bento-link">
                    <img src="https://images.unsplash.com/photo-1516734212186-a967f81ad0d7?auto=format&fit=crop&w=800&q=80" alt="Golden Retriever">
                    <div class="bento-content">
                        <h3>Loyal Companions</h3>
                        <p>Experience the pure joy of a dog's friendship.</p>
                        <span class="bento-btn">Find a Dog <i class="fa-solid fa-bone ms-1"></i></span>
                    </div>
                </a>
            </div>
            <div class="bento-item bento-tall" data-aos="fade-left" data-aos-delay="100">
                <a href="pets.php?type=Cat" class="bento-link">
                    <img src="https://images.unsplash.com/photo-1574158622682-e40e69881006?auto=format&fit=crop&w=600&q=80" alt="Luxury Cat">
                    <div class="bento-content">
                        <h3>Feline Grace</h3>
                        <p>Elegant partners for a quiet, cozy home.</p>
                    </div>
                </a>
            </div>
            <div class="bento-item bento-sm" data-aos="fade-right" data-aos-delay="200">
                <a href="pets.php?type=Bird" class="bento-link">
                    <img src="https://images.unsplash.com/photo-1444464666168-49d633b867ad?auto=format&fit=crop&w=400&q=80" alt="Vibrant Bird">
                    <div class="bento-content"><h3>Colorful Wings</h3></div>
                </a>
            </div>
            <div class="bento-item bento-sm" data-aos="fade-up" data-aos-delay="300">
                <a href="pets.php?type=Small" class="bento-link">
                    <img src="https://images.unsplash.com/photo-1540263062025-a764a51e600e?auto=format&fit=crop&w=400&q=80" alt="Hamster">
                    <div class="bento-content"><h3>Small Paws</h3></div>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- ANIMAL LIFESTYLE GALLERY -->
<section class="py-5">
    <div class="container py-5">
        <div class="row align-items-center mb-5" data-aos="fade-up">
            <div class="col-lg-6">
                <h2 class="display-5 brand-font">Life is Better <br> with <span class="text-gradient">Animals</span></h2>
            </div>
            <div class="col-lg-6 text-lg-end">
                <p class="text-muted">Explore our community of happy pets and their loving families.</p>
            </div>
        </div>
        <div class="row g-4">
            <div class="col-md-4" data-aos="zoom-in">
                <div class="gallery-card">
                    <img src="https://images.unsplash.com/photo-1518020382113-a7e8fc38eac9?auto=format&fit=crop&w=500&q=80" class="img-fluid rounded-4" alt="Cute Pet">
                </div>
            </div>
            <div class="col-md-4" data-aos="zoom-in" data-aos-delay="100">
                <div class="gallery-card">
                    <img src="https://images.unsplash.com/photo-1537151608828-ea2b11777ee8?auto=format&fit=crop&w=500&q=80" class="img-fluid rounded-4" alt="Cute Pet">
                </div>
            </div>
            <div class="col-md-4" data-aos="zoom-in" data-aos-delay="200">
                <div class="gallery-card">
                    <img src="https://images.unsplash.com/photo-1501824136268-f15510b89570?auto=format&fit=crop&w=500&q=80" class="img-fluid rounded-4" alt="Cute Pet">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FEATURED PRODUCTS (REAL WEBSITE FEEL) -->
<section id="featured-products" class="py-5 position-relative">
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-end mb-5" data-aos="fade-up">
            <div>
                <span class="text-primary-start fw-bold text-uppercase tracking-wider">Top Rated</span>
                <h2 class="display-6 brand-font mt-2">Boutique Essentials</h2>
            </div>
            <a href="products.php" class="text-decoration-none text-primary-end fw-bold">View All Store <i class="fa-solid fa-arrow-right ms-1"></i></a>
        </div>

        <div class="row g-4">
            <?php 
            // Mocking beautiful images for the "Real Website" feel since database might have empty uploads
            $mockImages = [
                'https://images.unsplash.com/photo-1583337130417-3346a1be7dee?auto=format&fit=crop&w=500&q=80', // Dog Food
                'https://images.unsplash.com/photo-1548550023-2bdb3c5beed7?auto=format&fit=crop&w=500&q=80', // Scratching Post
                'https://images.unsplash.com/photo-1535268647677-300dbf3d78d1?auto=format&fit=crop&w=500&q=80', // Shampoo
                'https://images.unsplash.com/photo-1516734212186-a967f81ad0d7?auto=format&fit=crop&w=500&q=80'  // Medicine
            ];
            foreach($featuredProducts as $idx => $p): 
                $img = $mockImages[$idx % 4];
            ?>
            <div class="col-6 col-md-4 col-lg-3" data-aos="fade-up" data-aos-delay="<?php echo $idx * 100; ?>">
                <div class="product-card-real">
                    <div class="product-img-box">
                        <img src="<?php echo $img; ?>" alt="<?php echo $p['name']; ?>">
                        <div class="product-badge">Top Seller</div>
                        <button class="wish-btn"><i class="fa-solid fa-paw"></i></button>
                    </div>
                    <div class="product-info-real mt-3">
                        <div class="category-pill mb-1"><?php echo $p['category']; ?></div>
                        <h6 class="product-name-real mb-2"><?php echo $p['name']; ?></h6>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="price-real">₹<?php echo number_format($p['price'], 2); ?></span>
                            <button class="add-cart-mini"><i class="fa-solid fa-cart-plus"></i></button>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- TESTIMONIALS (REAL VOICES) -->
<section class="py-5 bg-white position-relative">
    <div class="container py-5">
        <div class="row align-items-center">
            <div class="col-lg-5" data-aos="fade-right">
                <span class="text-primary-start fw-bold text-uppercase tracking-wider">Testimonials</span>
                <h2 class="display-5 brand-font mb-4 text-dark">The Real Voices <br> of Our Community</h2>
                <p class="text-muted mb-5 pe-lg-5">We don't just sell products; we build lasting relationships between humans and their companions.</p>
                <div class="d-flex gap-3">
                    <div class="review-stat bg-light border">
                        <div class="h3 fw-bold mb-0 text-dark">4.9/5</div>
                        <div class="small text-muted">App Rating</div>
                    </div>
                    <div class="review-stat bg-light border">
                        <div class="h3 fw-bold mb-0 text-dark">12k+</div>
                        <div class="small text-muted">Pet Parents</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-7 mt-5 mt-lg-0">
                <div class="row g-4">
                    <?php if(empty($testimonials)): ?>
                        <div class="col-12 text-center py-5 opacity-50">
                            <i class="fa-solid fa-comment-slash fs-1 mb-3"></i>
                            <p>No feedback available yet. Be the first to share your experience!</p>
                        </div>
                    <?php else: ?>
                        <?php foreach(array_slice($testimonials, 0, 2) as $idx => $t): ?>
                        <div class="col-md-6" data-aos="fade-up" data-aos-delay="<?php echo $idx * 150; ?>">
                            <div class="testimonial-creative bg-white border shadow-sm">
                                <div class="quote-icon opacity-10"><i class="fa-solid fa-quote-left"></i></div>
                                <p class="mb-4 text-secondary italic">"<?php echo htmlspecialchars($t['comment']); ?>"</p>
                                <div class="d-flex align-items-center mt-auto">
                                    <div class="avatar-circle me-3"><?php echo substr($t['first_name'], 0, 1); ?></div>
                                    <div>
                                        <h6 class="mb-0 fw-bold text-dark"><?php echo htmlspecialchars($t['first_name']); ?></h6>
                                        <div class="stars small text-warning">
                                            <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
