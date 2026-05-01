<?php
require_once 'includes/db.php';
include 'includes/header.php';

$type_filter = $_GET['type'] ?? 'all';
$price_filter = $_GET['price'] ?? null;
$min_price_filter = $_GET['min_price'] ?? null;

$query = "SELECT * FROM pets WHERE status = 'available'";
$params = [];

if ($type_filter !== 'all') {
    $query .= " AND type = :type";
    $params['type'] = $type_filter;
}

if ($price_filter !== null) {
    if ($price_filter == '0') {
        $query .= " AND price <= 50"; // Adoption usually has low/no fee
    } else {
        $query .= " AND price = :price";
        $params['price'] = $price_filter;
    }
}

if ($min_price_filter !== null) {
    $query .= " AND price >= :min_price";
    $params['min_price'] = $min_price_filter;
}

$stmt = $pdo->prepare($query);
$stmt->execute($params);
$pets = $stmt->fetchAll();
?>


<div class="container my-5" style="min-height: 70vh;">
    <div class="text-center mb-5">
        <h1 class="brand-font display-5">Find Your New Best Friend</h1>
        <p class="text-muted">Browse our lovely pets available for adoption and sale.</p>
    </div>

    <!-- Filter Tab Buttons -->
    <div class="d-flex justify-content-center mb-5">
        <div class="btn-group border shadow-sm bg-white rounded-pill p-1">
            <a href="pets.php?type=all" class="btn <?php echo $type_filter === 'all' ? 'btn-primary-custom' : 'bg-white text-dark border-0'; ?> rounded-pill px-4">All Pets</a>
            <a href="pets.php?type=Dog" class="btn <?php echo $type_filter === 'Dog' ? 'btn-primary-custom' : 'bg-white text-dark border-0'; ?> rounded-pill px-4">Dogs</a>
            <a href="pets.php?type=Cat" class="btn <?php echo $type_filter === 'Cat' ? 'btn-primary-custom' : 'bg-white text-dark border-0'; ?> rounded-pill px-4">Cats</a>
            <a href="pets.php?type=Bird" class="btn <?php echo $type_filter === 'Bird' ? 'btn-primary-custom' : 'bg-white text-dark border-0'; ?> rounded-pill px-4">Birds</a>
        </div>
    </div>

    <div class="row">
        <?php if (empty($pets)): ?>
            <div class="col-12 text-center py-5">
                <i class="fa-solid fa-paw fs-1 text-muted mb-3"></i>
                <h3 class="text-muted">No pets found in this category.</h3>
            </div>
        <?php else: ?>
            <?php 
            // Mocking aesthetic pet images for a professional look
            $petMocks = [
                'https://images.unsplash.com/photo-1543466835-00a7907e9de1?auto=format&fit=crop&w=600&q=80', // Buddy (Dog)
                'https://images.unsplash.com/photo-1514888286974-6c03e2ca1dba?auto=format&fit=crop&w=600&q=80', // Charlie (Cat)
                'https://images.unsplash.com/photo-1552053831-71594a27632d?auto=format&fit=crop&w=600&q=80', // Oliver (Dog)
                'https://images.unsplash.com/photo-1444464666168-49d633b867ad?auto=format&fit=crop&w=600&q=80', // Bird
                'https://images.unsplash.com/photo-1540263062025-a764a51e600e?auto=format&fit=crop&w=600&q=80', // Small
                'https://images.unsplash.com/photo-1592194996308-7b43878e84a6?auto=format&fit=crop&w=600&q=80'  // Cat
            ];
            $idx = 0;
            foreach($pets as $pet): 
                $img = $petMocks[$idx % 6];
                $idx++;
            ?>
            <div class="col-md-6 col-lg-4" data-aos="fade-up">
                <div class="product-card-real">
                    <div class="product-img-box">
                        <img src="<?php echo $img; ?>" alt="<?php echo $pet['name']; ?>">
                        <div class="product-badge" style="background: var(--primary-start); color: white;"><?php echo $pet['status'] == 'Available' ? 'Ready to Adopt' : $pet['status']; ?></div>
                        <button class="wish-btn addToWishlist" data-id="<?php echo $pet['id']; ?>" data-type="pet">
                            <i class="fa-solid fa-paw"></i>
                        </button>
                    </div>
                    <div class="product-info-real mt-3">
                        <div class="category-pill mb-1"><?php echo $pet['type']; ?> Breed</div>
                        <h6 class="product-name-real mb-2"><?php echo htmlspecialchars($pet['name']); ?></h6>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="price-real">₹<?php echo number_format($pet['price'], 2); ?></span>
                            <button class="add-cart-mini addToCart" data-id="<?php echo $pet['id']; ?>" data-type="pet">
                                <i class="fa-solid fa-heart"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>

