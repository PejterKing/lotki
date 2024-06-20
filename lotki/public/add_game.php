<?php
include '../config/config.php';
include '../includes/header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $date_played = $_POST['date_played'];
    $usernames = $_POST['usernames'];
    $places = $_POST['places'];

    // Insert game
    $stmt = $conn->prepare("INSERT INTO games (date_played) VALUES (?)");
    $stmt->execute([$date_played]);
    $game_id = $conn->lastInsertId();

    foreach ($usernames as $index => $username) {
        $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $user_id = $user['id'];
        } else {
            $stmt = $conn->prepare("INSERT INTO users (username) VALUES (?)");
            $stmt->execute([$username]);
            $user_id = $conn->lastInsertId();
        }

        $place = $places[$index];
        $points = 0;
        if ($place == 1) $points = 5;
        elseif ($place == 2) $points = 4;
        elseif ($place == 3) $points = 3;
        elseif ($place == 4) $points = 1;

        $stmt = $conn->prepare("INSERT INTO results (game_id, user_id, place, points) VALUES (?, ?, ?, ?)");
        $stmt->execute([$game_id, $user_id, $place, $points]);
    }

    echo "<p>Game added successfully!</p>";
}

?>

<h2>Add Game</h2>
<form method="post">
    <label for="date_played">Date Played:</label>
    <input type="date" name="date_played" required>
    <h3>Results:</h3>
    <div id="results">
        <div class="result">
            <label for="usernames[]">Username:</label>
            <input type="text" name="usernames[]" required>
            <label for="places[]">Place:</label>
            <input type="number" name="places[]" min="1" required>
        </div>
    </div>
    <button type="button" onclick="addResult()">Add Another Result</button>
    <button type="submit">Add Game</button>
</form>

<script>
function addResult() {
    var resultsDiv = document.getElementById('results');
    var newResultDiv = document.createElement('div');
    newResultDiv.classList.add('result');
    newResultDiv.innerHTML = `
        <label for="usernames[]">Username:</label>
        <input type="text" name="usernames[]" required>
        <label for="places[]">Place:</label>
        <input type="number" name="places[]" min="1" required>
    `;
    resultsDiv.appendChild(newResultDiv);
}
</script>

<?php include '../includes/footer.php'; ?>
