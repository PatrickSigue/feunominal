<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'tix');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['genre_id'])) {
    $genre_id = intval($_GET['genre_id']);
    
    // Check if the genre is associated with any movies
    $stmt = $conn->prepare("SELECT COUNT(*) FROM movie_genres WHERE genre_id = ?");
    $stmt->bind_param("i", $genre_id);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();

    if ($count == 0) {
        // Delete the genre if it's not associated with any movies
        $stmt = $conn->prepare("DELETE FROM genres WHERE genre_id = ?");
        $stmt->bind_param("i", $genre_id);
        $stmt->execute();
        $stmt->close();
    } else {
        header("Location: ../manage_genres.php?error=genre_associated_with_movies");
        exit();
    }
}

header("Location: ../manage_genres.php?status=genre_deleted");
exit();
?>
