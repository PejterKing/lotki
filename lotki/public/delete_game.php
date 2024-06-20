<?php
include '../config/config.php';

if (isset($_GET['id'])) {
    $game_id = $_GET['id'];

    // Delete results associated with the game
    $stmt = $conn->prepare("DELETE FROM results WHERE game_id = ?");
    $stmt->execute([$game_id]);

    // Delete the game
    $stmt = $conn->prepare("DELETE FROM games WHERE id = ?");
    $stmt->execute([$game_id]);

    echo "<p>Game deleted successfully!</p>";
}

echo "<a href='index.php'>Back to Home</a>";
?>