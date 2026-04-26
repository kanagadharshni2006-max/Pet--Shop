<?php 
require_once '../includes/db.php';
include 'layout/header.php'; 

$success_msg = '';
$error_msg = '';

// Handle Delete
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $stmt = $pdo->prepare("DELETE FROM pets WHERE id = ?");
    if ($stmt->execute([$id])) {
        $success_msg = "Pet deleted successfully!";
    } else {
        $error_msg = "Failed to delete pet.";
    }
}

// Handle Add/Edit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $breed = $_POST['breed'] ?? '';
    $age = $_POST['age'] ?? '';
    $type = $_POST['type'] ?? '';
    $price = $_POST['price'] ?? 0;
    $status = $_POST['status'] ?? 'available';
    $image = $_POST['image'] ?? '';
    $description = $_POST['description'] ?? '';
    $id = $_POST['id'] ?? '';

    if (empty($id)) {
        // Add
        $stmt = $pdo->prepare("INSERT INTO pets (name, breed, age, type, price, status, image, description) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        if ($stmt->execute([$name, $breed, $age, $type, $price, $status, $image, $description])) {
            $success_msg = "Pet added successfully!";
        } else {
            $error_msg = "Failed to add pet.";
        }
    } else {
        // Edit
        $stmt = $pdo->prepare("UPDATE pets SET name=?, breed=?, age=?, type=?, price=?, status=?, image=?, description=? WHERE id=?");
        if ($stmt->execute([$name, $breed, $age, $type, $price, $status, $image, $description, $id])) {
            $success_msg = "Pet updated successfully!";
        } else {
            $error_msg = "Failed to update pet.";
        }
    }
}

// Fetch all pets
$pets = $pdo->query("SELECT * FROM pets ORDER BY created_at DESC")->fetchAll();
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="brand-font">Manage Pets</h3>
    <button class="btn btn-primary shadow-sm" style="background-color: var(--primary-color); border:none;" data-bs-toggle="modal" data-bs-target="#petModal"><i class="fa-solid fa-plus me-1"></i> Add New Pet</button>
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
                        <th>Name / Breed</th>
                        <th>Age</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th>Price/Fee</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($pets)): ?>
                        <tr><td colspan="7" class="text-center py-4">No pets found.</td></tr>
                    <?php else: ?>
                        <?php foreach($pets as $pet): ?>
                        <tr>
                            <td><img src="<?php echo htmlspecialchars($pet['image']); ?>" class="rounded shadow-sm" width="60" height="60" style="object-fit: cover;" alt="pet"></td>
                            <td><strong class="fs-6"><?php echo htmlspecialchars($pet['name']); ?></strong><br><small class="text-muted"><?php echo htmlspecialchars($pet['breed']); ?></small></td>
                            <td><?php echo htmlspecialchars($pet['age']); ?></td>
                            <td><span class="badge bg-info rounded-pill px-2 text-dark"><?php echo htmlspecialchars($pet['type']); ?></span></td>
                            <td>
                                <span class="badge bg-<?php echo ($pet['status'] === 'available' ? 'success' : 'secondary'); ?> rounded-pill px-2">
                                    <?php echo ucfirst($pet['status']); ?>
                                </span>
                            </td>
                            <td class="text-success fw-bold">$<?php echo number_format($pet['price'], 2); ?></td>
                            <td>
                                <button class="btn btn-sm btn-outline-info rounded-pill px-3 me-1 edit-btn" 
                                        data-pet='<?php echo json_encode($pet); ?>' 
                                        data-bs-toggle="modal" data-bs-target="#petModal">
                                    <i class="fa-solid fa-pen"></i>
                                </button>
                                <a href="?delete=<?php echo $pet['id']; ?>" class="btn btn-sm btn-outline-danger rounded-pill px-3" onclick="return confirm('Are you sure?')">
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

<!-- Pet Modal -->
<div class="modal fade" id="petModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 shadow">
            <form method="POST">
                <div class="modal-header border-0 bg-light">
                    <h5 class="modal-title brand-font" id="modalTitle">Add New Pet</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <input type="hidden" name="id" id="petId">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Name</label>
                            <input type="text" name="name" id="petName" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Breed / Variety</label>
                            <input type="text" name="breed" id="petBreed" class="form-control" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold">Age</label>
                            <input type="text" name="age" id="petAge" class="form-control" placeholder="e.g. 2 Months" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold">Type</label>
                            <select name="type" id="petType" class="form-select" required>
                                <option value="Dog">Dog</option>
                                <option value="Cat">Cat</option>
                                <option value="Bird">Bird</option>
                                <option value="Fish">Fish</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold">Status</label>
                            <select name="status" id="petStatus" class="form-select" required>
                                <option value="available">Available</option>
                                <option value="sold">Sold</option>
                                <option value="pending">Pending</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Price / Fee ($)</label>
                            <input type="number" step="0.01" name="price" id="petPrice" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Image URL</label>
                            <input type="text" name="image" id="petImage" class="form-control" required>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label fw-bold">Description</label>
                            <textarea name="description" id="petDescription" class="form-control" rows="3"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary px-4" style="background-color: var(--primary-color); border:none;">Save Pet</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.querySelectorAll('.edit-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        const pet = JSON.parse(this.getAttribute('data-pet'));
        document.getElementById('modalTitle').innerText = 'Edit Pet';
        document.getElementById('petId').value = pet.id;
        document.getElementById('petName').value = pet.name;
        document.getElementById('petBreed').value = pet.breed;
        document.getElementById('petAge').value = pet.age;
        document.getElementById('petType').value = pet.type;
        document.getElementById('petStatus').value = pet.status;
        document.getElementById('petPrice').value = pet.price;
        document.getElementById('petImage').value = pet.image;
        document.getElementById('petDescription').value = pet.description;
    });
});

document.getElementById('petModal').addEventListener('hidden.bs.modal', function () {
    document.getElementById('modalTitle').innerText = 'Add New Pet';
    document.querySelector('#petModal form').reset();
    document.getElementById('petId').value = '';
});
</script>

        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

