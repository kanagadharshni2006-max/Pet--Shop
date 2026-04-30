<?php
require_once 'includes/db.php';

try {
    $sql = "CREATE TABLE IF NOT EXISTS feedbacks (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        item_name VARCHAR(100) NOT NULL,
        rating INT NOT NULL CHECK (rating >= 1 AND rating <= 5),
        comment TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
    )";
    
    $pdo->exec($sql);
    echo "Feedbacks table created successfully.<br>";
    
    // Seed some dummy feedback
    $pdo->exec("INSERT IGNORE INTO feedbacks (user_id, item_name, rating, comment) VALUES 
        (1, 'Golden Retriever', 5, 'Absolutely love my new puppy! Very active and healthy.'),
        (1, 'Premium Dog Food (5kg)', 4, 'Good quality, but shipping took a while.'),
        (1, 'British Shorthair', 5, 'The sweetest cat ever. Thank you Paws & Claws!')");
        
    echo "Dummy feedbacks inserted.";
    
} catch (PDOException $e) {
    die("Error creating feedback table: " . $e->getMessage());
}
?>
