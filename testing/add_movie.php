<?php
session_start();
require 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $image = $_FILES['image']['name'];
    move_uploaded_file($_FILES['image']['tmp_name'], "images/" . $image);
    $stmt = $pdo->prepare("INSERT INTO movies (title, image_path) VALUES (?, ?)");
    $stmt->execute([$title, $image]);
    header("Location: movies.php");
}
?>

<form method="POST" enctype="multipart/form-data">
    <h2>Add Movie</h2>
    Title: <input type="text" name="title" required><br>
    Poster: <input type="file" name="image" required><br>
    <input type="submit" value="Add Movie">
</form>
