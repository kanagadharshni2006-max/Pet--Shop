<?php
try {
    $pdo = new PDO('mysql:host=localhost', 'root', 'pass');
    $dbs = $pdo->query('SHOW DATABASES')->fetchAll(PDO::FETCH_COLUMN);
    print_r($dbs);
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
