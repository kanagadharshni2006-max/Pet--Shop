<?php
// setup.php - Run this once to create the database and tables
$host = 'localhost';
$user = 'root';
$pass = 'pass';

try {
    // Connect without database selected to create it first
    $pdo = new PDO("mysql:host=$host;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Create the database if it doesn't exist
    $pdo->exec("CREATE DATABASE IF NOT EXISTS pet_shop");
    echo "Database created successfully.<br>";
    
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
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    $pdo->exec($sql);
    echo "Table 'users' created successfully.<br>";
    echo "You can now safely delete this setup.php file.";
    
} catch (PDOException $e) {
    die("Setup failed: " . $e->getMessage());
}
?>
