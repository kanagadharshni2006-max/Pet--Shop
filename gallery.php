<?php
require_once 'includes/db.php';
include 'includes/header.php';

// Fetch categories from the gallery
$categories = $pdo->query("SELECT DISTINCT category FROM gallery")->fetchAll(PDO::FETCH_COLUMN);
?>

<div class="container my-5">
    <div class="text-center mb-5">
        <h1 class="brand-font display-4">Our Pet Gallery</h1>
        <div class="mx-auto" style="width: 100px; height: 5px; background: var(--primary-color); border-radius: 5px; margin-bottom: 20px;"></div>
        <p class="text-muted fs-5">Candid moments and portraits of our adorable friends.</p>
    </div>

    <?php foreach($categories as $cat): ?>
    <div class="mb-5">
        <h3 class="brand-font mb-4 pb-2 border-bottom"><i class="fa-solid fa-camera text-primary me-2"></i> <?php echo htmlspecialchars($cat); ?> Gallery</h3>
        <div class="row g-4">
            <?php
            $stmt = $pdo->prepare("SELECT * FROM gallery WHERE category = ?");
            $stmt->execute([$cat]);
            while ($img = $stmt->fetch()):
            ?>
            <div class="col-sm-6 col-md-4 col-lg-3">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden h-100 product-card">
                    <div class="gallery-img-wrapper" style="overflow: hidden;">
                        <img src="<?php echo $img['image_url']; ?>" class="card-img-top transition-all" alt="<?php echo $img['caption']; ?>" style="height: 250px; object-fit: cover;">
                    </div>
                    <div class="card-body p-3 text-center">
                        <h6 class="brand-font m-0 text-muted small"><?php echo htmlspecialchars($img['caption']); ?></h6>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<style>
.gallery-img-wrapper:hover img {
    transform: scale(1.1);
}
</style>

<?php include 'includes/footer.php'; ?>

