<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'tix');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['genre'])) {
    $genre = trim($_POST['genre']);
    
    if (!empty($genre)) {
        // Check if genre already exists
        $stmt = $conn->prepare("SELECT COUNT(*) FROM genres WHERE genre = ?");
        $stmt->bind_param("s", $genre);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
        $stmt->close();

        if ($count > 0) {
            header("Location: ../manage_genres.php?error=duplicate_genre");
            exit();
        }

        // Insert new genre
        $user_id = $_SESSION['user_id'] ?? 1; // Assign to a variable
        $stmt = $conn->prepare("INSERT INTO genres (genre, user_id) VALUES (?, ?)");
        $stmt->bind_param("si", $genre, $user_id); // Use the variable
        $stmt->execute();
        $stmt->close();
    }
}

header("Location: ../manage_genres.php?status=genre_added");
exit();
?>