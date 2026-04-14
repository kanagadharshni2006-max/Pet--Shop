<?php include 'layout/header.php'; ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="brand-font">Manage Products</h3>
    <button class="btn btn-primary shadow-sm" style="background-color: var(--primary-color); border:none;"><i class="fa-solid fa-plus me-1"></i> Add New Product</button>
</div>
<div class="card card-stat border-0 shadow-sm">
    <div class="card-body p-4">
        <table class="table align-middle table-hover">
            <thead class="table-light">
                <tr>
                    <th>Image</th>
                    <th>Product Name</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><img src="https://images.unsplash.com/photo-1589924691995-400dc9ce53ce?auto=format&fit=crop&w=50&q=80" class="rounded shadow-sm" width="50" alt="prod"></td>
                    <td class="fw-bold">Premium Dog Food (5kg)</td>
                    <td>Food</td>
                    <td class="text-success fw-bold">$24.99</td>
                    <td><span class="badge bg-success rounded-pill px-2">In Stock</span></td>
                    <td>
                        <button class="btn btn-sm btn-outline-info rounded-pill px-3 me-1"><i class="fa-solid fa-pen"></i></button>
                        <button class="btn btn-sm btn-outline-danger rounded-pill px-3"><i class="fa-solid fa-trash"></i></button>
                    </td>
                </tr>
                <tr>
                    <td><img src="https://images.unsplash.com/photo-1516734212186-a967f81ad0d7?auto=format&fit=crop&w=50&q=80" class="rounded shadow-sm" width="50" alt="prod"></td>
                    <td class="fw-bold">Organic Oatmeal Shampoo</td>
                    <td>Grooming</td>
                    <td class="text-success fw-bold">$12.99</td>
                    <td><span class="badge bg-warning text-dark rounded-pill px-2">Low Stock</span></td>
                    <td>
                        <button class="btn btn-sm btn-outline-info rounded-pill px-3 me-1"><i class="fa-solid fa-pen"></i></button>
                        <button class="btn btn-sm btn-outline-danger rounded-pill px-3"><i class="fa-solid fa-trash"></i></button>
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
