<?php 
require_once '../includes/db.php';
include 'layout/header.php'; 

$success_msg = '';
$error_msg = '';

// Handle Delete
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
    if ($stmt->execute([$id])) {
        $success_msg = "Product deleted successfully!";
    } else {
        $error_msg = "Failed to delete product.";
    }
}

// Handle Add/Edit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $category = $_POST['category'] ?? '';
    $price = $_POST['price'] ?? 0;
    $old_price = $_POST['old_price'] ?? NULL;
    $stock = $_POST['stock'] ?? 0;
    $image = $_POST['image'] ?? '';
    $description = $_POST['description'] ?? '';
    $id = $_POST['id'] ?? '';

    if (empty($id)) {
        // Add
        $stmt = $pdo->prepare("INSERT INTO products (name, category, price, old_price, stock, image, description) VALUES (?, ?, ?, ?, ?, ?, ?)");
        if ($stmt->execute([$name, $category, $price, $old_price, $stock, $image, $description])) {
            $success_msg = "Product added successfully!";
        } else {
            $error_msg = "Failed to add product.";
        }
    } else {
        // Edit
        $stmt = $pdo->prepare("UPDATE products SET name=?, category=?, price=?, old_price=?, stock=?, image=?, description=? WHERE id=?");
        if ($stmt->execute([$name, $category, $price, $old_price, $stock, $image, $description, $id])) {
            $success_msg = "Product updated successfully!";
        } else {
            $error_msg = "Failed to update product.";
        }
    }
}

// Fetch all products
$products = $pdo->query("SELECT * FROM products ORDER BY created_at DESC")->fetchAll();
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="brand-font">Manage Products</h3>
    <button class="btn btn-primary shadow-sm" style="background-color: var(--primary-color); border:none;" data-bs-toggle="modal" data-bs-target="#productModal"><i class="fa-solid fa-plus me-1"></i> Add New Product</button>
</div>

<?php if ($success_msg): ?>
    <div class="alert alert-success"><?php echo $success_msg; ?></div>
<?php endif; ?>
<?php if ($error_msg): ?>
    <div class="alert alert-danger"><?php echo $error_msg; ?></div>
<?php endif; ?>

<div class="card card-stat border-0 shadow-sm">
    <div class="card-body p-4">
        <div class="table-responsive">
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
                    <?php if (empty($products)): ?>
                        <tr><td colspan="6" class="text-center py-4">No products found.</td></tr>
                    <?php else: ?>
                        <?php foreach($products as $prod): ?>
                        <tr>
                            <td><img src="<?php echo htmlspecialchars($prod['image']); ?>" class="rounded shadow-sm" width="50" height="50" style="object-fit: cover;" alt="prod"></td>
                            <td class="fw-bold"><?php echo htmlspecialchars($prod['name']); ?></td>
                            <td><?php echo ucfirst(htmlspecialchars($prod['category'])); ?></td>
                            <td class="text-success fw-bold">₹<?php echo number_format($prod['price'], 2); ?></td>
                            <td>
                                <?php if($prod['stock'] > 10): ?>
                                    <span class="badge bg-success rounded-pill px-2">In Stock (<?php echo $prod['stock']; ?>)</span>
                                <?php elseif($prod['stock'] > 0): ?>
                                    <span class="badge bg-warning text-dark rounded-pill px-2">Low Stock (<?php echo $prod['stock']; ?>)</span>
                                <?php else: ?>
                                    <span class="badge bg-danger rounded-pill px-2">Out of Stock</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-outline-info rounded-pill px-3 me-1 edit-btn" 
                                        data-product='<?php echo json_encode($prod); ?>' 
                                        data-bs-toggle="modal" data-bs-target="#productModal">
                                    <i class="fa-solid fa-pen"></i>
                                </button>
                                <a href="?delete=<?php echo $prod['id']; ?>" class="btn btn-sm btn-outline-danger rounded-pill px-3" onclick="return confirm('Are you sure?')">
                                    <i class="fa-solid fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Product Modal -->
<div class="modal fade" id="productModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 shadow">
            <form method="POST">
                <div class="modal-header border-0 bg-light">
                    <h5 class="modal-title brand-font" id="modalTitle">Add New Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <input type="hidden" name="id" id="prodId">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Product Name</label>
                            <input type="text" name="name" id="prodName" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Category</label>
                            <select name="category" id="prodCategory" class="form-select" required>
                                <option value="food">Food</option>
                                <option value="accessories">Accessories</option>
                                <option value="grooming">Grooming</option>
                                <option value="medicine">Medicine</option>
                                <option value="toys">Toys</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold">Price ($)</label>
                            <input type="number" step="0.01" name="price" id="prodPrice" class="form-control" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold">Old Price (Optional)</label>
                            <input type="number" step="0.01" name="old_price" id="prodOldPrice" class="form-control">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold">Stock Quantity</label>
                            <input type="number" name="stock" id="prodStock" class="form-control" required>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label fw-bold">Image URL</label>
                            <input type="text" name="image" id="prodImage" class="form-control" required>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label fw-bold">Description</label>
                            <textarea name="description" id="prodDescription" class="form-control" rows="3"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary px-4" style="background-color: var(--primary-color); border:none;">Save Product</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.querySelectorAll('.edit-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        const prod = JSON.parse(this.getAttribute('data-product'));
        document.getElementById('modalTitle').innerText = 'Edit Product';
        document.getElementById('prodId').value = prod.id;
        document.getElementById('prodName').value = prod.name;
        document.getElementById('prodCategory').value = prod.category;
        document.getElementById('prodPrice').value = prod.price;
        document.getElementById('prodOldPrice').value = prod.old_price;
        document.getElementById('prodStock').value = prod.stock;
        document.getElementById('prodImage').value = prod.image;
        document.getElementById('prodDescription').value = prod.description;
    });
});

document.getElementById('productModal').addEventListener('hidden.bs.modal', function () {
    document.getElementById('modalTitle').innerText = 'Add New Product';
    document.querySelector('#productModal form').reset();
    document.getElementById('prodId').value = '';
});
</script>

        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

