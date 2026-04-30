<?php
try {
    $pdo = new PDO('mysql:host=localhost', 'root', 'pass');
    $pdo->exec("CREATE DATABASE IF NOT EXISTS pet_shop CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    echo "Database created successfully.\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
