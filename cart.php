<?php
require_once 'includes/db.php';
include 'includes/header.php';
?>

<div class="container my-5" style="min-height: 60vh;">
    <h2 class="brand-font mb-4">Your Shopping Cart</h2>
    
    <div class="row">
        <!-- Cart Items -->
        <div class="col-lg-8 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Mock Cart Item 1 -->
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="https://images.unsplash.com/photo-1589924691995-400dc9ce53ce?auto=format&fit=crop&w=100&q=80" alt="Product" class="rounded" style="width: 60px; height: 60px; object-fit: cover;">
                                            <div class="ms-3">
                                                <h6 class="mb-0">Premium Dog Food (5kg)</h6>
                                                <small class="text-muted">Category: Food</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>$24.99</td>
                                    <td>
                                        <div class="input-group" style="width: 120px;">
                                            <button class="btn btn-outline-secondary btn-sm" type="button">-</button>
                                            <input type="text" class="form-control form-control-sm text-center" value="1">
                                            <button class="btn btn-outline-secondary btn-sm" type="button">+</button>
                                        </div>
                                    </td>
                                    <td class="fw-bold">$24.99</td>
                                    <td>
                                        <button class="btn btn-sm btn-danger"><i class="fa-solid fa-trash"></i></button>
                                    </td>
                                </tr>
                                <!-- Mock Cart Item 2 -->
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="https://images.unsplash.com/photo-1523626752472-b55a628f1acc?auto=format&fit=crop&w=100&q=80" alt="Product" class="rounded" style="width: 60px; height: 60px; object-fit: cover;">
                                            <div class="ms-3">
                                                <h6 class="mb-0">Cat Scratching Post</h6>
                                                <small class="text-muted">Category: Accessories</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>$18.50</td>
                                    <td>
                                        <div class="input-group" style="width: 120px;">
                                            <button class="btn btn-outline-secondary btn-sm" type="button">-</button>
                                            <input type="text" class="form-control form-control-sm text-center" value="1">
                                            <button class="btn btn-outline-secondary btn-sm" type="button">+</button>
                                        </div>
                                    </td>
                                    <td class="fw-bold">$18.50</td>
                                    <td>
                                        <button class="btn btn-sm btn-danger"><i class="fa-solid fa-trash"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-between mt-3">
                        <a href="products.php" class="btn btn-outline-primary"><i class="fa-solid fa-arrow-left"></i> Continue Shopping</a>
                        <button class="btn btn-outline-secondary">Update Cart</button>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Cart Summary -->
        <div class="col-lg-4">
            <div class="card shadow-sm border-0 bg-light">
                <div class="card-body p-4">
                    <h5 class="brand-font mb-4">Cart Summary</h5>
                    <div class="d-flex justify-content-between mb-3">
                        <span>Subtotal</span>
                        <span class="fw-bold">$43.49</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span>Tax (5%)</span>
                        <span class="fw-bold">$2.17</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span>Shipping</span>
                        <span class="fw-bold text-success">Free</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between mb-4">
                        <span class="fs-5 fw-bold">Total</span>
                        <span class="fs-5 fw-bold text-primary">$45.66</span>
                    </div>
                    <a href="checkout.php" class="btn btn-primary-custom w-100 btn-lg">Proceed to Checkout</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
