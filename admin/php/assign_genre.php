<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'tix');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['movie_id']) && isset($_POST['genres'])) {
    $movie_id = intval($_POST['movie_id']);
    $genre_ids = $_POST['genres']; // Array of selected genre IDs
    $error_message = ""; // To store error message

    // Check if any selected genre is already assigned to the movie
    foreach ($genre_ids as $genre_id) {
        $check = $conn->prepare("SELECT COUNT(*) FROM movie_genres WHERE movie_id = ? AND genre_id = ?");
        $check->bind_param("ii", $movie_id, $genre_id);
        $check->execute();
        $check->bind_result($count);
        $check->fetch();
        $check->close();

        if ($count > 0) {
            // Set error message if duplicate genre is found
            $error_message = "One or more selected genres are already assigned to this movie.";
            break;
        }
    }

    if ($error_message) {
        // Redirect back with error
        header("Location: ../manage_genres.php?error=" . urlencode($error_message));
        exit();
    } else {
        // Assign selected genres to the movie
        foreach ($genre_ids as $genre_id) {
            $stmt = $conn->prepare("INSERT INTO movie_genres (movie_id, genre_id) VALUES (?, ?)");
            $stmt->bind_param("ii", $movie_id, $genre_id);
            $stmt->execute();
            $stmt->close();
        }
        
        // Redirect after success
        header("Location: ../manage_genres.php?status=genres_assigned");
        exit();
    }
}
?>
