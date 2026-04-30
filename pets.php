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
            <?php foreach($pets as $pet): ?>
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card-elegant h-100 d-flex flex-column">
                    <span class="badge-elegant bg-white shadow-sm position-absolute top-0 start-0 m-3 z-3" style="color: var(--primary-start);">
                        <?php echo ($pet['price'] > 50 ? 'Premium Sale' : 'Adopt Me'); ?>
                    </span>
                    <div class="product-img-wrapper" style="height: 250px;">
                        <img src="<?php echo htmlspecialchars($pet['image']); ?>" alt="<?php echo htmlspecialchars($pet['name']); ?>">
                    </div>
                    <div class="p-4 flex-grow-1">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h4 class="brand-font h3 mb-0"><?php echo htmlspecialchars($pet['name']); ?></h4>
                            <a href="#" class="wishlist-btn text-decoration-none fs-4" data-id="<?php echo $pet['id']; ?>" data-type="pet">
                                <i class="fa-regular fa-heart"></i>
                            </a>
                        </div>
                        <p class="text-muted small mb-3">
                            <span class="badge bg-light text-dark rounded-pill px-3 py-2 me-2"><?php echo htmlspecialchars($pet['breed']); ?></span>
                            <span class="badge bg-light text-dark rounded-pill px-3 py-2"><?php echo htmlspecialchars($pet['age']); ?></span>
                        </p>
                        <p class="text-muted small"><?php echo htmlspecialchars($pet['description']); ?></p>
                    </div>
                    <div class="p-4 bg-light border-top d-flex justify-content-between align-items-center mt-auto">
                        <span class="fw-800 fs-4 text-primary-start">
                            <?php echo $pet['price'] > 50 ? '₹' . number_format($pet['price'], 2) : 'FREE'; ?>
                        </span>
                        <button class="btn btn-primary-custom add-to-cart-btn" 
                                data-id="<?php echo $pet['id']; ?>"
                                data-name="<?php echo htmlspecialchars($pet['name']); ?>"
                                data-price="<?php echo $pet['price']; ?>"
                                data-image="<?php echo $pet['image']; ?>"
                                data-category="Pet"
                                data-type="pet">
                            <i class="fa-solid fa-cart-plus"></i> <?php echo $pet['price'] > 50 ? 'Buy' : 'Adopt'; ?>
                        </button>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>

