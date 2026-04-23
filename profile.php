<?php
require_once 'includes/db.php';
include 'includes/header.php';
?>

<div class="container my-5" style="min-height: 60vh;">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-lg-3 mb-4">
            <div class="card shadow-sm border-0 rounded-4 text-center p-4 mb-4">
                <img src="https://ui-avatars.com/api/?name=John+Doe&background=f2a65a&color=fff&size=100" alt="User Avatar" class="rounded-circle mb-3 mx-auto" style="width: 100px; height: 100px;">
                <h5 class="fw-bold mb-1">John Doe</h5>
                <p class="text-muted small">Member since April 2026</p>
            </div>
            
            <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
                <div class="list-group list-group-flush border-0">
                    <a href="#profile" class="list-group-item list-group-item-action active p-3 fw-bold border-0" data-bs-toggle="list">
                        <i class="fa-regular fa-user me-2"></i> My Profile
                    </a>
                    <a href="#orders" class="list-group-item list-group-item-action p-3 fw-bold border-bottom" data-bs-toggle="list">
                        <i class="fa-solid fa-box-open me-2"></i> Order History
                    </a>
                    <a href="#wishlist" class="list-group-item list-group-item-action p-3 fw-bold border-bottom" data-bs-toggle="list">
                        <i class="fa-regular fa-heart me-2"></i> Wishlist
                    </a>
                    <a href="logout.php" class="list-group-item list-group-item-action text-danger p-3 fw-bold border-0">
                        <i class="fa-solid fa-arrow-right-from-bracket me-2"></i> Logout
                    </a>
                </div>
            </div>
        </div>

        <!-- Main Content (Tabs) -->
        <div class="col-lg-9">
            <div class="tab-content" id="nav-tabContent">
                
                <!-- Profile Tab -->
                <div class="tab-pane fade show active" id="profile">
                    <div class="card shadow-sm border-0 rounded-4 p-4">
                        <h4 class="brand-font mb-4 pb-3 border-bottom"><i class="fa-solid fa-id-card text-primary me-2"></i> Account Information</h4>
                        <form>
                            <div class="row mb-3">
                                <div class="col-md-6 mb-3 mb-md-0">
                                    <label class="form-label text-muted small fw-bold">First Name</label>
                                    <input type="text" class="form-control" value="John">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label text-muted small fw-bold">Last Name</label>
                                    <input type="text" class="form-control" value="Doe">
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-md-6 mb-3 mb-md-0">
                                    <label class="form-label text-muted small fw-bold">Email</label>
                                    <input type="email" class="form-control" value="john@email.com">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label text-muted small fw-bold">Phone</label>
                                    <input type="text" class="form-control" value="+1 234 567 890">
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="form-label text-muted small fw-bold">Address</label>
                                <textarea class="form-control" rows="3">1234 Pet Street, Animal City, NY 10001</textarea>
                            </div>
                            <button type="submit" class="btn btn-primary-custom px-4 shadow">Update Details</button>
                        </form>
                    </div>
                </div>

                <!-- Orders Tab -->
                <div class="tab-pane fade" id="orders">
                    <div class="card shadow-sm border-0 rounded-4 p-4">
                        <h4 class="brand-font mb-4 pb-3 border-bottom"><i class="fa-solid fa-clock-rotate-left text-primary me-2"></i> Recent Orders</h4>
                        <div class="table-responsive">
                            <table class="table align-middle">
                                <thead class="table-light text-muted small">
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th>Total</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="fw-bold">#ORD-2026414</td>
                                        <td>April 14, 2026</td>
                                        <td><span class="badge bg-success rounded-pill px-2">Delivered</span></td>
                                        <td class="fw-bold">$45.66</td>
                                        <td><button class="btn btn-sm btn-outline-primary rounded-pill px-3">View Invoice</button></td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">#ORD-2026322</td>
                                        <td>March 22, 2026</td>
                                        <td><span class="badge bg-warning text-dark rounded-pill px-2">Shipped</span></td>
                                        <td class="fw-bold">$112.50</td>
                                        <td><button class="btn btn-sm btn-outline-primary rounded-pill px-3">Track</button></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Wishlist Tab -->
                <div class="tab-pane fade" id="wishlist">
                    <div class="card shadow-sm border-0 rounded-4 p-4">
                        <h4 class="brand-font mb-4 pb-3 border-bottom"><i class="fa-solid fa-heart text-danger me-2"></i> My Wishlist</h4>
                        <p class="text-muted">You have 1 item in your wishlist.</p>
                        <div class="row">
                            <div class="col-md-6 col-lg-5">
                                <div class="product-card border bg-light shadow-none">
                                    <div class="product-img-wrapper" style="height: 180px;">
                                        <img src="https://images.unsplash.com/photo-1516734212186-a967f81ad0d7?auto=format&fit=crop&w=300&q=80" alt="Product">
                                    </div>
                                    <div class="product-card-body p-3">
                                        <h6 class="product-title m-0 pb-2">Organic Oatmeal Shampoo</h6>
                                        <div class="d-flex justify-content-between align-items-center mt-2">
                                            <span class="fw-bold text-primary fs-5">$12.99</span>
                                            <button class="btn btn-sm btn-outline-danger"><i class="fa-solid fa-trash"></i></button>
                                        </div>
                                        <button class="btn btn-primary-custom btn-sm w-100 mt-3 shadow-sm"><i class="fa-solid fa-cart-plus"></i> Add to Cart</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
