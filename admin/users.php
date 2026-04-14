<?php include 'layout/header.php'; ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="brand-font">Manage Users</h3>
</div>
<div class="card card-stat border-0 shadow-sm">
    <div class="card-body p-4">
        <table class="table align-middle table-hover">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Joined</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="fw-bold text-muted">1</td>
                    <td><img src="https://ui-avatars.com/api/?name=John+Doe&background=f2a65a&color=fff" class="rounded-circle me-3 shadow-sm" width="40"> <strong class="fs-6">John Doe</strong></td>
                    <td>john@email.com</td>
                    <td>+1 234 567 890</td>
                    <td>April 2026</td>
                    <td>
                        <button class="btn btn-sm btn-outline-info rounded-pill px-3 me-1"><i class="fa-solid fa-pen"></i></button>
                        <button class="btn btn-sm btn-outline-danger rounded-pill px-3"><i class="fa-solid fa-user-slash"></i></button>
                    </td>
                </tr>
                <tr>
                    <td class="fw-bold text-muted">2</td>
                    <td><img src="https://ui-avatars.com/api/?name=Jane+Smith&background=2e8b57&color=fff" class="rounded-circle me-3 shadow-sm" width="40"> <strong class="fs-6">Jane Smith</strong></td>
                    <td>jane@example.com</td>
                    <td>+1 987 654 321</td>
                    <td>March 2026</td>
                    <td>
                        <button class="btn btn-sm btn-outline-info rounded-pill px-3 me-1"><i class="fa-solid fa-pen"></i></button>
                        <button class="btn btn-sm btn-outline-danger rounded-pill px-3"><i class="fa-solid fa-user-slash"></i></button>
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
