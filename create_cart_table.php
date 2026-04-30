<?php
require_once 'includes/db.php';

try {
    $sql = "CREATE TABLE IF NOT EXISTS cart (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        item_id INT NOT NULL,
        item_type VARCHAR(20) DEFAULT 'product',
        quantity INT NOT NULL DEFAULT 1,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
        UNIQUE KEY user_cart_item (user_id, item_id, item_type)
    )";
    
    $pdo->exec($sql);
    echo "Cart table created successfully.<br>";
} catch (PDOException $e) {
    die("Error creating cart table: " . $e->getMessage());
}
?>
