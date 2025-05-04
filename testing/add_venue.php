<?php
session_start();
require 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $stmt = $pdo->prepare("INSERT INTO venues (name) VALUES (?)");
    $stmt->execute([$name]);
    header("Location: venues.php");
}
?>

<form method="POST">
    <h2>Add Venue</h2>
    Name: <input type="text" name="name" required><br>
    <input type="submit" value="Add Venue">
</form>
