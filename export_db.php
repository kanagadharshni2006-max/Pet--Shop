<?php
require_once 'includes/db.php';

$tables = [];
$result = $pdo->query("SHOW TABLES");
while ($row = $result->fetch(PDO::FETCH_NUM)) {
    $tables[] = $row[0];
}

$sql = "CREATE DATABASE IF NOT EXISTS `pet_shop`;\n";
$sql .= "USE `pet_shop`;\n\n";
$sql .= "SET SQL_MODE = 'NO_AUTO_VALUE_ON_ZERO';\n";
$sql .= "SET time_zone = '+00:00';\n\n";

foreach ($tables as $table) {
    $result = $pdo->query("SHOW CREATE TABLE `$table`");
    $row = $result->fetch(PDO::FETCH_NUM);
    
    $sql .= "\n-- Table structure for table `$table`\n\n";
    $sql .= "DROP TABLE IF EXISTS `$table`;\n";
    $sql .= $row[1] . ";\n\n";
    
    $result = $pdo->query("SELECT * FROM `$table`");
    $rowCount = $result->rowCount();
    
    if ($rowCount > 0) {
        $sql .= "-- Dumping data for table `$table`\n\n";
        $sql .= "INSERT INTO `$table` VALUES \n";
        
        $i = 0;
        while ($row = $result->fetch(PDO::FETCH_NUM)) {
            $sql .= "(";
            $rowValues = [];
            foreach ($row as $value) {
                if ($value === null) {
                    $rowValues[] = "NULL";
                } else {
                    $value = addslashes($value);
                    $value = str_replace("\n", "\\n", $value);
                    $rowValues[] = "'" . $value . "'";
                }
            }
            $sql .= implode(", ", $rowValues);
            $sql .= ")";
            
            $i++;
            if ($i < $rowCount) {
                $sql .= ",\n";
            } else {
                $sql .= ";\n";
            }
        }
    }
    $sql .= "\n";
}

file_put_contents('pet_shop.sql', $sql);
echo "Database successfully exported to pet_shop.sql";
?>
