<?php
include '../config/config.php';

$stmt = $conn->query("SHOW TABLES");
$tables = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo "<h1>Tables in database:</h1>";
echo "<ul>";
foreach ($tables as $table) {
    echo "<li>" . $table['Tables_in_game_app'] . "</li>";
}
echo "</ul>";
?>