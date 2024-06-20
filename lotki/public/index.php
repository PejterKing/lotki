<?php
include '../config/config.php';
include '../includes/header.php';

// Fetch games
$stmt = $conn->query("SELECT * FROM games ORDER BY date_played DESC");
$games = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo "<h2>Games</h2>";
echo "<table>";
echo "<tr><th>Date</th><th>Actions</th></tr>";

foreach ($games as $game) {
    echo "<tr>";
    echo "<td>" . $game['date_played'] . "</td>";
    echo "<td><a href='delete_game.php?id=" . $game['id'] . "'>Delete</a></td>";
    echo "</tr>";
}

echo "</table>";

include '../includes/footer.php';
?>