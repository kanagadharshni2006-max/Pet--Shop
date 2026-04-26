<?php
require_once 'includes/db.php';

try {
    // Drop the table and recreate it with the correct schema
    $pdo->exec("DROP TABLE IF EXISTS wishlist");
    $sql = "CREATE TABLE wishlist (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        item_id INT NOT NULL,
        item_type VARCHAR(20) DEFAULT 'product',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
        UNIQUE KEY user_fav (user_id, item_id, item_type)
    )";
    $pdo->exec($sql);
    echo "Wishlist table recreated successfully.";
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>
