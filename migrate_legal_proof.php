<?php
require_once 'includes/db.php';

try {
    // Add requires_proof to pets
    $pdo->exec("ALTER TABLE pets ADD COLUMN requires_proof TINYINT(1) DEFAULT 0");
    echo "Added requires_proof to pets.\n";
} catch (PDOException $e) {
    if (strpos($e->getMessage(), 'Duplicate column name') !== false) {
        echo "Column requires_proof already exists.\n";
    } else {
        echo "Error altering pets: " . $e->getMessage() . "\n";
    }
}

try {
    // Add id_proof_path to orders
    $pdo->exec("ALTER TABLE orders ADD COLUMN id_proof_path VARCHAR(255) DEFAULT NULL");
    echo "Added id_proof_path to orders.\n";
} catch (PDOException $e) {
    if (strpos($e->getMessage(), 'Duplicate column name') !== false) {
        echo "Column id_proof_path already exists.\n";
    } else {
        echo "Error altering orders: " . $e->getMessage() . "\n";
    }
}
?>
