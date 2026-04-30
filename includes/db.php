<?php
// Simple PDO Database Connection
$host = 'localhost';
$db = 'pet_shop';
$user = 'root';
$pass = 'pass';

try {
    // Try with 'pass' first
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
} catch (PDOException $e) {
    try {
        // Try with empty password (XAMPP default)
        $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, "");
    } catch (PDOException $e2) {
        die("Database connection failed. Please make sure MySQL is running and the database 'pet_shop' exists.<br>Error: " . $e2->getMessage());
    }
}

if (isset($pdo)) {
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    // Ensure cart table exists
    $pdo->exec("CREATE TABLE IF NOT EXISTS cart (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        item_id INT NOT NULL,
        item_type VARCHAR(20) DEFAULT 'product',
        quantity INT NOT NULL DEFAULT 1,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        UNIQUE KEY user_cart_item (user_id, item_id, item_type)
    )");
}
?>
