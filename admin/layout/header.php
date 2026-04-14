<?php
if(session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Paws & Claws</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&family=Outfit:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #F2A65A;
            --secondary-color: #2E8B57;
            --bg-color: #f4f6f9;
        }
        body {
            font-family: 'Nunito', sans-serif;
            background-color: var(--bg-color);
        }
        h1, h2, h3, h4, .brand-font { font-family: 'Outfit', sans-serif; }
        .sidebar {
            min-height: 100vh;
            background: #fff;
            box-shadow: 2px 0 10px rgba(0,0,0,0.05);
        }
        .sidebar-link {
            color: #666;
            text-decoration: none;
            padding: 12px 20px;
            display: block;
            border-radius: 8px;
            margin-bottom: 5px;
            font-weight: 600;
            transition: all 0.3s;
        }
        .sidebar-link:hover, .sidebar-link.active {
            background-color: var(--primary-color);
            color: #fff;
        }
        .sidebar-link i { width: 25px; }
        .topbar { background: #fff; box-shadow: 0 2px 10px rgba(0,0,0,0.05); }
        .card-stat { border:none; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
    </style>
</head>
<body>
<div class="d-flex">
    <!-- Sidebar -->
    <?php include 'sidebar.php'; ?>
    
    <!-- Main Content -->
    <div class="flex-grow-1">
        <!-- Topbar -->
        <nav class="navbar topbar px-4 py-3 mb-4 d-flex justify-content-between align-items-center">
            <h4 class="mb-0 brand-font text-dark d-none d-md-block">Admin Dashboard</h4>
            <div class="d-flex align-items-center">
                <div class="dropdown">
                    <a class="text-decoration-none text-dark fw-bold dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        <img src="https://ui-avatars.com/api/?name=Admin&background=2E8B57&color=fff" alt="Admin" class="rounded-circle me-2" style="width: 35px;">
                        Admin User
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                        <li><a class="dropdown-item" href="../index.php">View Site</a></li>
                        <li><a class="dropdown-item text-danger" href="#">Logout</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="px-4">
