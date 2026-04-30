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
    <title>Admin Portal - Paws & Claws</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700&family=Outfit:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-start: #6366F1;
            --primary-end: #EC4899;
            --secondary: #0F172A;
            --radius-2xl: 32px;
        }
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background: url('https://images.unsplash.com/photo-1541781774459-bb2af2f05b55?auto=format&fit=crop&w=1920&q=80') center/cover fixed;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }
        body::before {
            content: '';
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(15, 23, 42, 0.85); /* Deep Fade */
            z-index: 1;
        }
        .brand-font { font-family: 'Outfit', sans-serif; }
        .login-card { 
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(25px);
            -webkit-backdrop-filter: blur(25px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: var(--radius-2xl);
            box-shadow: 0 40px 100px rgba(0,0,0,0.5); 
            overflow: hidden;
            position: relative;
            z-index: 2;
            color: white;
        }
        .btn-3d {
            background: linear-gradient(135deg, var(--primary-start), var(--primary-end));
            color: white !important;
            border: none;
            padding: 1rem;
            border-radius: 14px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s ease;
            box-shadow: 0 10px 20px -10px var(--primary-start);
        }
        .btn-3d:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 30px -10px var(--primary-start);
        }
        .form-control {
            background: rgba(255, 255, 255, 0.05) !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
            color: white !important;
            border-radius: 14px;
            padding: 0.8rem 1.2rem;
        }
        .form-control:focus {
            border-color: var(--primary-start) !important;
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.2);
        }
        .text-muted { color: rgba(255, 255, 255, 0.5) !important; }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5 col-lg-4">
                <div class="login-card p-4 p-md-5">
                    <div class="text-center mb-5">
                        <h1 class="brand-font fw-800 mb-0" style="background: linear-gradient(to right, var(--primary-start), var(--primary-end)); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Admin Portal</h1>
                        <p class="text-muted fw-bold small text-uppercase mt-2">Secure Access Gateway</p>
                    </div>
                    
                    <?php if ($error): ?>
                        <div class="alert alert-danger border-0 small rounded-4 mb-4" style="background: rgba(220, 38, 38, 0.2); color: #fca5a5;"><?php echo $error; ?></div>
                    <?php endif; ?>

                    <form method="POST">
                        <div class="mb-4">
                            <label class="form-label fw-bold small text-muted text-uppercase">Username</label>
                            <input type="text" name="username" class="form-control" placeholder="Admin username" required>
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-bold small text-muted text-uppercase">Password</label>
                            <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                        </div>
                        <button type="submit" class="btn btn-3d w-100 mt-2">Open Dashboard <i class="fa-solid fa-shield-halved ms-2"></i></button>
                        <div class="mt-4 text-center">
                            <a href="../index.php" class="text-decoration-none small fw-bold text-muted"><i class="fa-solid fa-arrow-left me-1"></i> Back to Main Site</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
