<?php
session_start();
require 'config.php';

$movies = $pdo->query("SELECT * FROM movies")->fetchAll();
$cinemas = $pdo->query("SELECT * FROM cinemas")->fetchAll();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $movie_id = $_POST['movie_id'];
    $cinema_id = $_POST['cinema_id'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $stmt = $pdo->prepare("INSERT INTO showings (movie_id, cinema_id, show_date, show_time) VALUES (?, ?, ?, ?)");
    $stmt->execute([$movie_id, $cinema_id, $date, $time]);
    header("Location: showings.php");
}
?>

<form method="POST">
    <h2>Add Showing</h2>
    Movie:
    <select name="movie_id">
        <?php foreach ($movies as $movie): ?>
            <option value="<?= $movie['movie_id'] ?>"><?= $movie['title'] ?></option>
        <?php endforeach; ?>
    </select><br>

    Cinema:
    <select name="cinema_id">
        <?php foreach ($cinemas as $cinema): ?>
            <option value="<?= $cinema['cinema_id'] ?>"><?= $cinema['name'] ?></option>
        <?php endforeach; ?>
    </select><br>

    Date: <input type="date" name="date" required><br>
    Time: <input type="time" name="time" required><br>
    <input type="submit" value="Add Showing">
</form>
