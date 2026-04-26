<?php
require_once 'includes/db.php';

try {
    // Check if created_at column exists in products table
    $stmt = $pdo->query("SHOW COLUMNS FROM products LIKE 'created_at'");
    if (!$stmt->fetch()) {
        $pdo->exec("ALTER TABLE products ADD COLUMN created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP");
        echo "Column 'created_at' added to products table.<br>";
    } else {
        echo "Column 'created_at' already exists.<br>";
    }
} catch (PDOException $e) {
    die("Update failed: " . $e->getMessage());
}
?>
