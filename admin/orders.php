<?php include 'layout/header.php'; ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="brand-font">Manage Orders</h3>
</div>
<div class="card card-stat border-0 shadow-sm">
    <div class="card-body p-4">
        <table class="table align-middle table-hover">
            <thead class="table-light">
                <tr>
                    <th>Order ID</th>
                    <th>Customer Name</th>
                    <th>Date</th>
                    <th>Total Amount</th>
                    <th>Payment</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="fw-bold text-primary">#ORD-2026414</td>
                    <td>John Doe</td>
                    <td>April 14, 2026</td>
                    <td class="fw-bold">$45.66</td>
                    <td>COD</td>
                    <td>
                        <select class="form-select form-select-sm border border-success text-success fw-bold bg-light" style="width: 120px;">
                            <option selected>Delivered</option>
                            <option>Shipped</option>
                            <option>Pending</option>
                        </select>
                    </td>
                    <td>
                        <button class="btn btn-sm btn-outline-primary rounded-pill px-3"><i class="fa-solid fa-eye me-1"></i> View</button>
                    </td>
                </tr>
                <tr>
                    <td class="fw-bold text-primary">#ORD-2026415</td>
                    <td>Jane Smith</td>
                    <td>April 13, 2026</td>
                    <td class="fw-bold">$120.00</td>
                    <td>Online</td>
                    <td>
                        <select class="form-select form-select-sm border border-warning text-warning fw-bold bg-light" style="width: 120px;">
                            <option>Delivered</option>
                            <option>Shipped</option>
                            <option selected>Pending</option>
                        </select>
                    </td>
                    <td>
                        <button class="btn btn-sm btn-outline-primary rounded-pill px-3"><i class="fa-solid fa-eye me-1"></i> View</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
