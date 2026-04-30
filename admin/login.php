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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&family=Outfit:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-start: #6366F1;
            --primary-end: #EC4899;
            --secondary: #1E293B;
            --bg-main: #F8FAFC;
        }
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background: linear-gradient(135deg, #F1F5F9 0%, #E2E8F0 100%); 
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .brand-font { font-family: 'Outfit', sans-serif; }
        .login-card { 
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.5);
            border-radius: 24px; 
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1); 
            overflow: hidden;
        }
        .btn-3d {
            background: linear-gradient(135deg, var(--primary-start), var(--primary-end));
            color: white;
            border: none;
            padding: 0.8rem;
            border-radius: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.2s ease;
            box-shadow: 0 4px 0 0 #C026D3;
        }
        .btn-3d:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 0 0 #C026D3;
            color: white;
        }
        .btn-3d:active {
            transform: translateY(2px);
            box-shadow: 0 2px 0 0 #C026D3;
        }
        .form-control {
            border-radius: 12px;
            padding: 0.8rem 1rem;
            border: 1px solid #E2E8F0;
            background: #F8FAFC;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5 col-lg-4">
                <div class="text-center mb-4">
                    <h1 class="brand-font fw-800 mb-0" style="background: linear-gradient(to right, var(--primary-start), var(--primary-end)); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Paws & Claws</h1>
                    <p class="text-muted fw-bold small text-uppercase tracking-wider">Admin Control Panel</p>
                </div>
                <div class="card login-card">
                    <div class="card-body p-4 p-md-5">
                        <div class="text-center mb-4">
                            <i class="fa-solid fa-lock-open fs-1 mb-3" style="color: var(--primary-start);"></i>
                            <h4 class="brand-font fw-bold">System Secure Login</h4>
                        </div>
                        
                        <?php if ($error): ?>
                            <div class="alert alert-danger border-0 small rounded-3 mb-4"><?php echo $error; ?></div>
                        <?php endif; ?>

                        <form method="POST">
                            <div class="mb-3">
                                <label class="form-label fw-bold small text-muted text-uppercase">Username</label>
                                <input type="text" name="username" class="form-control" placeholder="Admin username" required>
                            </div>
                            <div class="mb-4">
                                <label class="form-label fw-bold small text-muted text-uppercase">Password</label>
                                <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                            </div>
                            <button type="submit" class="btn btn-3d w-100">Unlock Dashboard <i class="fa-solid fa-key ms-2"></i></button>
                            <div class="mt-4 text-center">
                                <a href="../index.php" class="text-decoration-none small fw-bold text-muted"><i class="fa-solid fa-arrow-left me-1"></i> Back to Main Site</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
