<?php
session_start();
require 'config.php';

$venues = $pdo->query("SELECT * FROM venues")->fetchAll();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $venue_id = $_POST['venue_id'];
    $cinema_name = $_POST['cinema_name'];
    $stmt = $pdo->prepare("INSERT INTO cinemas (venue_id, name) VALUES (?, ?)");
    $stmt->execute([$venue_id, $cinema_name]);
    header("Location: cinemas.php");
}
?>

<form method="POST">
    <h2>Add Cinema</h2>
    Cinema Name: <input type="text" name="cinema_name" required><br>
    Venue:
    <select name="venue_id">
        <?php foreach ($venues as $venue): ?>
            <option value="<?= $venue['venue_id'] ?>"><?= $venue['name'] ?></option>
        <?php endforeach; ?>
    </select><br>
    <input type="submit" value="Add Cinema">
</form>
