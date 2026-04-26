<?php
require_once 'includes/db.php';

try {
    // Check if item_type column exists
    $stmt = $pdo->query("SHOW COLUMNS FROM wishlist LIKE 'item_type'");
    if (!$stmt->fetch()) {
        $pdo->exec("ALTER TABLE wishlist ADD COLUMN item_type VARCHAR(20) DEFAULT 'product' AFTER item_id");
        echo "Column 'item_type' added to wishlist table.<br>";
    } else {
        echo "Column 'item_type' already exists.<br>";
    }
} catch (PDOException $e) {
    die("Update failed: " . $e->getMessage());
}
?>
