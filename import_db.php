<?php
try {
    $pdo = new PDO('mysql:host=localhost;dbname=pet_shop', 'root', 'pass');
    $pdo->exec("SET FOREIGN_KEY_CHECKS=0;");
    $sql = file_get_contents('pet_shop.sql');
    $pdo->exec($sql);
    $pdo->exec("SET FOREIGN_KEY_CHECKS=1;");
    echo "Imported pet_shop.sql successfully.\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
