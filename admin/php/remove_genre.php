<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'tix');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['movie_id']) && isset($_POST['genres'])) {
    $movie_id = intval($_POST['movie_id']);
    $genre_ids = $_POST['genres']; // Array of selected genre IDs

    // Remove selected genres from the movie
    foreach ($genre_ids as $genre_id) {
        $stmt = $conn->prepare("DELETE FROM movie_genres WHERE movie_id = ? AND genre_id = ?");
        $stmt->bind_param("ii", $movie_id, $genre_id);
        $stmt->execute();
        $stmt->close();
    }
}

header("Location: ../manage_genres.php?status=genres_removed");
exit();
?>
