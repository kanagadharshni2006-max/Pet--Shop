<?php include 'layout/header.php'; ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="brand-font">Manage Pets</h3>
    <button class="btn btn-primary shadow-sm" style="background-color: var(--primary-color); border:none;"><i class="fa-solid fa-plus me-1"></i> Add New Pet</button>
</div>
<div class="card card-stat border-0 shadow-sm">
    <div class="card-body p-4">
        <table class="table align-middle table-hover">
            <thead class="table-light">
                <tr>
                    <th>Image</th>
                    <th>Name / Breed</th>
                    <th>Age</th>
                    <th>Type</th>
                    <th>Status</th>
                    <th>Price/Fee</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><img src="https://images.unsplash.com/photo-1552053831-71594a27632d?auto=format&fit=crop&w=50&q=80" class="rounded shadow-sm" width="60" alt="pet"></td>
                    <td><strong class="fs-6">Max</strong><br><small class="text-muted">Golden Retriever</small></td>
                    <td>2 Years</td>
                    <td><span class="badge bg-info rounded-pill px-2">Adoption</span></td>
                    <td><span class="badge bg-success rounded-pill px-2">Available</span></td>
                    <td class="text-success fw-bold">$50</td>
                    <td>
                        <button class="btn btn-sm btn-outline-info rounded-pill px-3 me-1"><i class="fa-solid fa-pen"></i></button>
                        <button class="btn btn-sm btn-outline-danger rounded-pill px-3"><i class="fa-solid fa-trash"></i></button>
                    </td>
                </tr>
                <tr>
                    <td><img src="https://images.unsplash.com/photo-1573865526739-10659fec78a5?auto=format&fit=crop&w=50&q=80" class="rounded shadow-sm" width="60" alt="pet"></td>
                    <td><strong class="fs-6">Luna</strong><br><small class="text-muted">Persian Cat</small></td>
                    <td>3 Months</td>
                    <td><span class="badge bg-warning text-dark rounded-pill px-2">Sale</span></td>
                    <td><span class="badge bg-success rounded-pill px-2">Available</span></td>
                    <td class="text-success fw-bold">$450</td>
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
