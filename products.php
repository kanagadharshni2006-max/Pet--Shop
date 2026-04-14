<?php
require_once 'includes/db.php';
include 'includes/header.php';
?>

<div class="container my-5" style="min-height: 70vh;">
    <div class="row">
        <!-- Sidebar Filter -->
        <div class="col-lg-3 col-md-4 mb-4">
            <div class="card border-0 shadow-sm rounded-4 p-4">
                <h4 class="mb-4 brand-font">Filters</h4>
                
                <div class="mb-4">
                    <label class="form-label fw-bold">Search</label>
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search products...">
                        <button class="btn btn-outline-secondary" type="button"><i class="fa-solid fa-search"></i></button>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold">Categories</label>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" value="food" id="catFood">
                        <label class="form-check-label" for="catFood">Pet Food (45)</label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" value="accessories" id="catAcc">
                        <label class="form-check-label" for="catAcc">Accessories (32)</label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" value="grooming" id="catGroom">
                        <label class="form-check-label" for="catGroom">Grooming (18)</label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" value="medicine" id="catMed">
                        <label class="form-check-label" for="catMed">Medicines (24)</label>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold">Price Range</label>
                    <input type="range" class="form-range" min="0" max="100" id="customRange">
                    <div class="d-flex justify-content-between text-muted small">
                        <span>$0</span>
                        <span>$100+</span>
                    </div>
                </div>
                
                <button class="btn btn-primary-custom w-100">Apply Filters</button>
            </div>
        </div>

        <!-- Product Grid -->
        <div class="col-lg-9 col-md-8">
            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
                <h2 class="h3 brand-font">All Products</h2>
                <select class="form-select w-auto shadow-sm border-0">
                    <option selected>Sort by: Featured</option>
                    <option value="1">Price: Low to High</option>
                    <option value="2">Price: High to Low</option>
                    <option value="3">Newest Arrivals</option>
                </select>
            </div>
            
            <div class="row">
                <!-- Generating 6 Mock Products -->
                <?php for($i=1; $i<=6; $i++): ?>
                <div class="col-lg-4 col-sm-6">
                    <div class="product-card">
                        <span class="badge-category">Food</span>
                        <a href="#" class="wishlist-btn"><i class="fa-regular fa-heart"></i></a>
                        <div class="product-img-wrapper">
                            <img src="https://images.unsplash.com/photo-1589924691995-400dc9ce53ce?auto=format&fit=crop&w=300&q=80" alt="Product">
                        </div>
                        <div class="product-card-body">
                            <div class="rating">
                                <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-regular fa-star"></i>
                            </div>
                            <h5 class="product-title">Sample Product Title <?php echo $i; ?></h5>
                            <div class="mt-3">
                                <span class="product-price">$<?php echo rand(10, 50); ?>.99</span>
                            </div>
                            <button class="btn btn-primary-custom w-100 mt-3 add-to-cart-btn"><i class="fa-solid fa-cart-plus"></i> Add to Cart</button>
                        </div>
                    </div>
                </div>
                <?php endfor; ?>
            </div>
            
            <!-- Pagination -->
            <nav aria-label="Page navigation" class="mt-4">
              <ul class="pagination justify-content-center">
                <li class="page-item disabled"><a class="page-link border-0 text-dark" href="#">Previous</a></li>
                <li class="page-item active"><a class="page-link border-0" href="#" style="background-color: var(--primary-color); color:white;">1</a></li>
                <li class="page-item"><a class="page-link border-0 text-dark" href="#">2</a></li>
                <li class="page-item"><a class="page-link border-0 text-dark" href="#">3</a></li>
                <li class="page-item"><a class="page-link border-0 text-dark" href="#">Next</a></li>
              </ul>
            </nav>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
