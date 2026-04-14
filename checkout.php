<?php
require_once 'includes/db.php';
include 'includes/header.php';
?>

<div class="container my-5">
    <div class="text-center mb-5">
        <h2 class="brand-font">Checkout</h2>
        <p class="text-muted">Securely complete your purchase</p>
    </div>

    <div class="row">
        <div class="col-lg-8 mb-4">
            <div class="card shadow-sm border-0 p-4 mb-4">
                <h4 class="mb-4 text-primary"><i class="fa-solid fa-map-location-dot"></i> Shipping Details</h4>
                <form>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">First Name</label>
                            <input type="text" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Last Name</label>
                            <input type="text" class="form-control" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Phone Number</label>
                        <input type="tel" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Address</label>
                        <input type="text" class="form-control" placeholder="1234 Main St" required>
                    </div>
                    <div class="row">
                        <div class="col-md-5 mb-3">
                            <label class="form-label fw-bold">Country</label>
                            <select class="form-select">
                                <option>United States</option>
                                <option>India</option>
                                <option>Canada</option>
                                <option>United Kingdom</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold">State</label>
                            <input type="text" class="form-control" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label fw-bold">Zip Code</label>
                            <input type="text" class="form-control" required>
                        </div>
                    </div>
                </form>
            </div>

            <div class="card shadow-sm border-0 p-4">
                <h4 class="mb-4 text-primary"><i class="fa-solid fa-credit-card"></i> Payment Method</h4>
                <div class="form-check mb-3 p-3 border rounded border-primary bg-light">
                    <input class="form-check-input ms-1" type="radio" name="paymentMethod" id="cod" value="cod" checked>
                    <label class="form-check-label fw-bold ms-2 mt-1" for="cod">
                        Cash on Delivery (COD)
                    </label>
                    <p class="text-muted small ms-4 mt-1 mb-0">Pay with cash upon delivery.</p>
                </div>
                
                <div class="form-check mb-3 p-3 border rounded">
                    <input class="form-check-input ms-1" type="radio" name="paymentMethod" id="online" value="online">
                    <label class="form-check-label fw-bold ms-2 mt-1" for="online">
                        Online Payment (Credit/Debit Card)
                    </label>
                </div>

                <!-- Simulated Credit Card Form -->
                <div id="creditCardForm" style="display: none;" class="bg-light p-3 rounded border">
                    <div class="mb-3">
                        <label class="form-label fw-bold small">Name on Card</label>
                        <input type="text" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small">Card Number</label>
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="xxxx-xxxx-xxxx-xxxx">
                            <span class="input-group-text bg-white"><i class="fa-brands fa-cc-visa text-primary fa-lg"></i></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6 mb-3">
                            <label class="form-label fw-bold small">Expiry</label>
                            <input type="text" class="form-control" placeholder="MM/YY">
                        </div>
                        <div class="col-6 mb-3">
                            <label class="form-label fw-bold small">CVV</label>
                            <input type="password" class="form-control" placeholder="123">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow-sm border-0 bg-light sticky-top" style="top: 100px;">
                <div class="card-body p-4">
                    <h5 class="brand-font mb-4">Order Summary</h5>
                    <div class="d-flex justify-content-between align-items-center mb-3 border-bottom pb-3">
                        <div>
                            <h6 class="mb-0 small">Premium Dog Food (5kg)</h6>
                            <span class="text-muted small">Qty: 1</span>
                        </div>
                        <span class="fw-bold small">$24.99</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <h6 class="mb-0 small">Cat Scratching Post</h6>
                            <span class="text-muted small">Qty: 1</span>
                        </div>
                        <span class="fw-bold small">$18.50</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between mb-2 small">
                        <span class="text-muted">Subtotal</span>
                        <span>$43.49</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2 small">
                        <span class="text-muted">Tax</span>
                        <span>$2.17</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3 small">
                        <span class="text-muted">Shipping</span>
                        <span class="text-success fw-bold">Free</span>
                    </div>
                    <div class="d-flex justify-content-between mb-4 border-top pt-3">
                        <span class="fw-bold fs-5">Total</span>
                        <span class="fw-bold fs-5 text-primary">$45.66</span>
                    </div>
                    <!-- Using type='button' for mock, normally submit -->
                    <button type="button" class="btn btn-primary-custom w-100 btn-lg shadow-sm" onclick="alert('Order placed successfully! This is a UI simulation. Invoice will be sent via Email.')">Place Order</button>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
