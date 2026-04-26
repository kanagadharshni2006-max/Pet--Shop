<?php
session_start();
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header('Location: index.php');
    exit;
}

require_once '../includes/db.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($password)) {
        $error = 'Both fields are required.';
    } else {
        $stmt = $pdo->prepare("SELECT * FROM admins WHERE username = ?");
        $stmt->execute([$username]);
        $admin = $stmt->fetch();

        if ($admin && password_verify($password, $admin['password'])) {
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_username'] = $admin['username'];
            header('Location: index.php');
            exit;
        } else {
            $error = 'Invalid username or password.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Paws & Claws</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&family=Outfit:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Nunito', sans-serif; background-color: #f4f6f9; }
        .brand-font { font-family: 'Outfit', sans-serif; }
        .login-card { border: none; border-radius: 15px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); }
    </style>
</head>
<body class="d-flex align-items-center justify-content-center vh-100">
    <div class="col-md-4">
        <div class="text-center mb-4">
            <h2 class="brand-font fw-bold" style="color: #F2A65A;">Paws & Claws</h2>
            <p class="text-muted">Admin Control Panel</p>
        </div>
        <div class="card login-card">
            <div class="card-body p-5">
                <h4 class="card-title text-center mb-4 brand-font">Login</h4>
                <?php if ($error): ?>
                    <div class="alert alert-danger small"><?php echo $error; ?></div>
                <?php endif; ?>
                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Username</label>
                        <input type="text" name="username" class="form-control" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-bold">Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <button type="submit" class="btn w-100 fw-bold" style="background-color: #F2A65A; color:white;">Sign In</button>
                    <div class="mt-3 text-center">
                        <small><a href="../index.php" class="text-decoration-none">Back to Website</a></small>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
