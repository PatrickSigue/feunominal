<?php
$conn = new mysqli('localhost', 'root', '', 'tix');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $movie_id = intval($_POST['movie_id']);
    
    // Archive the movie itself
    $conn->query("UPDATE movies SET archived = 1 WHERE movie_id = $movie_id");
    
    // Archive all related showings
    $conn->query("UPDATE showings SET archived = 1 WHERE movie_id = $movie_id");
    
    // Archive all related tickets
    $conn->query("UPDATE movie_tickets SET archived = 1 WHERE showing_id IN (SELECT showing_id FROM showings WHERE movie_id = $movie_id)");
}

header("Location: ../manage_movies.php");
exit();
