<?php
require_once 'includes/db.php';
$stmt = $pdo->query("DESCRIBE wishlist");
print_r($stmt->fetchAll());
?>
