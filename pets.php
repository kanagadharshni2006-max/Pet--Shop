<?php
require_once 'includes/db.php';
include 'includes/header.php';
?>

<div class="container my-5" style="min-height: 70vh;">
    <div class="text-center mb-5">
        <h1 class="brand-font display-5">Find Your New Best Friend</h1>
        <p class="text-muted">Browse our lovely pets available for adoption and sale.</p>
    </div>

    <!-- Toggle Buttons -->
    <div class="d-flex justify-content-center mb-5">
        <div class="btn-group border shadow-sm bg-white rounded-pill p-1">
            <button type="button" class="btn btn-primary-custom rounded-pill px-4">All Pets</button>
            <button type="button" class="btn bg-white rounded-pill px-4 text-dark border-0">For Adoption</button>
            <button type="button" class="btn bg-white rounded-pill px-4 text-dark border-0">For Sale</button>
        </div>
    </div>

    <div class="row">
        <!-- Mock Pet 1 (Adoption) -->
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="product-card h-100 d-flex flex-column">
                <span class="badge-category bg-info">For Adoption</span>
                <div class="product-img-wrapper" style="height: 250px;">
                    <img src="https://images.unsplash.com/photo-1552053831-71594a27632d?auto=format&fit=crop&w=400&q=80" alt="Pet">
                </div>
                <div class="product-card-body flex-grow-1 pb-0">
                    <h4 class="product-title fs-4">Max</h4>
                    <p class="text-muted mb-2"><i class="fa-solid fa-dog"></i> Golden Retriever &bull; 2 Years Old</p>
                    <p class="small text-muted border-top pt-2 mt-2">Max is a very friendly and energetic dog who loves to play fetch. Fully vaccinated.</p>
                </div>
                <div class="p-3 bg-light border-top d-flex justify-content-between align-items-center mt-auto">
                    <span class="fw-bold text-success">Adoption Fee: $50</span>
                    <button class="btn btn-secondary-custom"><i class="fa-solid fa-heart"></i> Adopt</button>
                </div>
            </div>
        </div>

        <!-- Mock Pet 2 (Sale) -->
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="product-card h-100 d-flex flex-column">
                <span class="badge-category bg-warning text-dark">For Sale</span>
                <div class="product-img-wrapper" style="height: 250px;">
                    <img src="https://images.unsplash.com/photo-1573865526739-10659fec78a5?auto=format&fit=crop&w=400&q=80" alt="Pet">
                </div>
                <div class="product-card-body flex-grow-1 pb-0">
                    <h4 class="product-title fs-4">Luna</h4>
                    <p class="text-muted mb-2"><i class="fa-solid fa-cat"></i> Persian Cat &bull; 3 Months Old</p>
                    <p class="small text-muted border-top pt-2 mt-2">Purebred Persian kitten with beautiful white fur. Very gentle and litter-trained.</p>
                </div>
                <div class="p-3 bg-light border-top d-flex justify-content-between align-items-center mt-auto">
                    <span class="product-price fs-5 text-primary">$450</span>
                    <button class="btn btn-primary-custom"><i class="fa-solid fa-bag-shopping"></i> Buy Now</button>
                </div>
            </div>
        </div>

        <!-- Mock Pet 3 (Adoption) -->
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="product-card h-100 d-flex flex-column">
                <span class="badge-category bg-info">For Adoption</span>
                <div class="product-img-wrapper" style="height: 250px;">
                    <img src="https://images.unsplash.com/photo-1552728089-571ebf4ebaca?auto=format&fit=crop&w=400&q=80" alt="Pet">
                </div>
                <div class="product-card-body flex-grow-1 pb-0">
                    <h4 class="product-title fs-4">Charlie</h4>
                    <p class="text-muted mb-2"><i class="fa-solid fa-kiwi-bird"></i> Macaw Parrot &bull; 1 Year Old</p>
                    <p class="small text-muted border-top pt-2 mt-2">Charlie is a talkative and colorful bird looking for an experienced owner.</p>
                </div>
                <div class="p-3 bg-light border-top d-flex justify-content-between align-items-center mt-auto">
                    <span class="fw-bold text-success">Adoption Fee: $20</span>
                    <button class="btn btn-secondary-custom"><i class="fa-solid fa-heart"></i> Adopt</button>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
