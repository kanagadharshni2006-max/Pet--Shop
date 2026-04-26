<?php
// setup.php - Run this once to create the database and tables
$host = 'localhost';
$user = 'root';
$pass = 'pass';

try {
    // Try with 'pass' first
    try {
        $pdo = new PDO("mysql:host=$host;charset=utf8", $user, $pass);
    } catch (PDOException $e) {
        // Try with empty password (XAMPP default)
        $pdo = new PDO("mysql:host=$host;charset=utf8", $user, "");
    }
    
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Create the database if it doesn't exist
    $pdo->exec("CREATE DATABASE IF NOT EXISTS pet_shop");
    echo "Database 'pet_shop' created successfully.<br>";
    
    // Switch to the created database
    $pdo->exec("USE pet_shop");
    
    // Create the users table
    $sql = "CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        first_name VARCHAR(50) NOT NULL,
        last_name VARCHAR(50) NOT NULL,
        email VARCHAR(100) NOT NULL UNIQUE,
        phone VARCHAR(20) NOT NULL,
        password VARCHAR(255) NOT NULL,
        address TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    $pdo->exec($sql);
    echo "Table 'users' created successfully.<br>";

    // Create the admins table
    $sql = "CREATE TABLE IF NOT EXISTS admins (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        full_name VARCHAR(100),
        role VARCHAR(20) DEFAULT 'admin',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    $pdo->exec($sql);
    
    // Insert default admin if not exists (password: admin123)
    $hashed_admin = password_hash('admin123', PASSWORD_DEFAULT);
    $pdo->prepare("INSERT IGNORE INTO admins (username, password, full_name) VALUES (?, ?, ?)")
        ->execute(['admin', $hashed_admin, 'Main Admin']);
    echo "Table 'admins' created successfully.<br>";

    // Create the products table (Accessories, Food, etc.)
    $sql = "CREATE TABLE IF NOT EXISTS products (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        category VARCHAR(50) NOT NULL,
        price DECIMAL(10, 2) NOT NULL,
        old_price DECIMAL(10, 2),
        image VARCHAR(255),
        description TEXT,
        rating DECIMAL(3, 1) DEFAULT 0.0,
        stock INT DEFAULT 0,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    $pdo->exec($sql);
    echo "Table 'products' created successfully.<br>";

    // Create the pets table (Live animals)
    $sql = "CREATE TABLE IF NOT EXISTS pets (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        breed VARCHAR(100),
        age VARCHAR(50),
        type VARCHAR(50), -- Dog, Cat, etc.
        price DECIMAL(10, 2) NOT NULL,
        status VARCHAR(20) DEFAULT 'available', -- available, sold, pending
        image VARCHAR(255),
        description TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    $pdo->exec($sql);
    echo "Table 'pets' created successfully.<br>";

    // Create the orders table
    $sql = "CREATE TABLE IF NOT EXISTS orders (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        total_amount DECIMAL(10, 2) NOT NULL,
        status VARCHAR(20) DEFAULT 'pending',
        payment_method VARCHAR(50),
        shipping_address TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
    )";
    $pdo->exec($sql);
    echo "Table 'orders' created successfully.<br>";

    // Create the order_items table
    $sql = "CREATE TABLE IF NOT EXISTS order_items (
        id INT AUTO_INCREMENT PRIMARY KEY,
        order_id INT NOT NULL,
        item_id INT NOT NULL,
        item_type VARCHAR(20) NOT NULL, -- 'product' or 'pet'
        item_name VARCHAR(100),
        price DECIMAL(10, 2) NOT NULL,
        quantity INT NOT NULL,
        FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE
    )";
    $pdo->exec($sql);
    echo "Table 'order_items' created successfully.<br>";

    // Create the wishlist table
    $sql = "CREATE TABLE IF NOT EXISTS wishlist (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        item_id INT NOT NULL,
        item_type VARCHAR(20) DEFAULT 'product',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
        UNIQUE KEY user_fav (user_id, item_id, item_type)
    )";
    $pdo->exec($sql);
    echo "Table 'wishlist' created successfully.<br>";

    // Create the gallery table
    $sql = "CREATE TABLE IF NOT EXISTS gallery (
        id INT AUTO_INCREMENT PRIMARY KEY,
        image_url VARCHAR(255) NOT NULL,
        caption VARCHAR(100),
        category VARCHAR(50)
    )";
    $pdo->exec($sql);
    echo "Table 'gallery' created successfully.<br>";

    // Seeding dynamic data
    // Products
    $pdo->exec("INSERT IGNORE INTO products (id, name, category, price, old_price, image, description, rating, stock) VALUES
        (1, 'Premium Dog Food (5kg)', 'food', 24.99, 30.00, 'https://images.unsplash.com/photo-1589924691995-400dc9ce53ce?auto=format&fit=crop&w=300&q=80', 'Complete nutrition for active dogs.', 4.5, 100),
        (2, 'Cat Scratching Post', 'accessories', 18.50, NULL, 'https://images.unsplash.com/photo-1523626752472-b55a628f1acc?auto=format&fit=crop&w=300&q=80', 'Durable and fun scratching post.', 4.0, 50),
        (3, 'Organic Pet Shampoo', 'grooming', 12.99, NULL, 'https://images.unsplash.com/photo-1516734212186-a967f81ad0d7?auto=format&fit=crop&w=300&q=80', 'Gentle shampoo for all pets.', 5.0, 75)");

    // Pets
    $pdo->exec("INSERT IGNORE INTO pets (id, name, breed, age, type, price, image, description) VALUES
        (1, 'Max', 'Golden Retriever', '2 Years', 'Dog', 500.00, 'https://images.unsplash.com/photo-1552053831-71594a27632d?auto=format&fit=crop&w=600&q=80', 'A friendly and energetic retriever.'),
        (2, 'Luna', 'Persian Cat', '3 Months', 'Cat', 450.00, 'https://images.unsplash.com/photo-1573865526739-10659fec78a5?auto=format&fit=crop&w=600&q=80', 'A calm and beautiful kitten.'),
        (3, 'Oliver', 'Beagle', '1 Year', 'Dog', 400.00, 'https://images.unsplash.com/photo-1537151608828-ea2b11777ee8?auto=format&fit=crop&w=600&q=80', 'Loves to play and sniff around.')");

    // Gallery
    $pdo->exec("INSERT IGNORE INTO gallery (image_url, caption, category) VALUES
        ('https://images.unsplash.com/photo-1543466835-00a7907e9de1?auto=format&fit=crop&w=600&q=80', 'Loyal Dog', 'Dogs'),
        ('https://images.unsplash.com/photo-1514888286974-6c03e2ca1dba?auto=format&fit=crop&w=600&q=80', 'Sleepy Cat', 'Cats'),
        ('https://images.unsplash.com/photo-1452857297128-d9c29adba80b?auto=format&fit=crop&w=600&q=80', 'Beautiful Bird', 'Birds')");

    echo "Sample data inserted successfully.<br>";
    echo "<strong>Setup Complete!</strong> You can now use the website.";
    
} catch (PDOException $e) {
    die("Setup failed: " . $e->getMessage());
}
?>

