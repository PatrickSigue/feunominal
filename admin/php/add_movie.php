<?php
session_start(); // Ensure session is started if you're using session for user_id

$conn = new mysqli('localhost', 'root', '', 'tix');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['movie_title'];
    $desc = $_POST['description'];
    $poster = $_POST['poster'];
    $banner = $_POST['banner'];

    // Assume user_id is stored in session
    $user_id = $_SESSION['user_id'] ?? null;

    if ($user_id === null) {
        // Handle error: user not logged in
        die("User not authenticated.");
    }

    $stmt = $conn->prepare("INSERT INTO movies (movie_title, description, poster, banner, user_id) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssi", $title, $desc, $poster, $banner, $user_id);
    $stmt->execute();
    $stmt->close();
}

header("Location: ../manage_movies.php");
exit;
