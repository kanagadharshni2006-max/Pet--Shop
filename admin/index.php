<?php include 'layout/header.php'; ?>

<div class="row mb-4">
    <div class="col-md-3 mb-3 mb-md-0">
        <div class="card card-stat bg-white p-3 border-start border-4 border-primary">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-muted mb-1">Total Sales</h6>
                    <h3 class="fw-bold mb-0 text-dark">$12,450</h3>
                </div>
                <div class="bg-light p-3 rounded-circle text-primary">
                    <i class="fa-solid fa-dollar-sign fs-4"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3 mb-md-0">
        <div class="card card-stat bg-white p-3 border-start border-4 border-success">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-muted mb-1">Total Orders</h6>
                    <h3 class="fw-bold mb-0 text-dark">150</h3>
                </div>
                <div class="bg-light p-3 rounded-circle text-success">
                    <i class="fa-solid fa-cart-shopping fs-4"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3 mb-md-0">
        <div class="card card-stat bg-white p-3 border-start border-4 border-info">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-muted mb-1">Pets Adopted</h6>
                    <h3 class="fw-bold mb-0 text-dark">45</h3>
                </div>
                <div class="bg-light p-3 rounded-circle text-info">
                    <i class="fa-solid fa-heart fs-4"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-stat bg-white p-3 border-start border-4 border-warning">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-muted mb-1">Registered Users</h6>
                    <h3 class="fw-bold mb-0 text-dark">320</h3>
                </div>
                <div class="bg-light p-3 rounded-circle text-warning">
                    <i class="fa-solid fa-users fs-4"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card card-stat mb-5">
    <div class="card-body p-4">
        <h5 class="card-title brand-font mb-4">Recent Orders</h5>
        <div class="table-responsive">
            <table class="table align-middle table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Order ID</th>
                        <th>Customer</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Total</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="fw-bold text-primary">#ORD-2026414</td>
                        <td>John Doe</td>
                        <td>April 14, 2026</td>
                        <td><span class="badge bg-success rounded-pill px-3">Delivered</span></td>
                        <td class="fw-bold">$45.66</td>
                        <td><button class="btn btn-sm btn-outline-primary rounded-pill px-3">Details</button></td>
                    </tr>
                    <tr>
                        <td class="fw-bold text-primary">#ORD-2026415</td>
                        <td>Jane Smith</td>
                        <td>April 13, 2026</td>
                        <td><span class="badge bg-warning text-dark rounded-pill px-3">Pending</span></td>
                        <td class="fw-bold">$120.00</td>
                        <td><button class="btn btn-sm btn-outline-primary rounded-pill px-3">Details</button></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

        </div> <!-- close px-4 -->
    </div> <!-- close flex-grow-1 -->
</div> <!-- close d-flex -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
