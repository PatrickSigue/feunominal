<?php
$conn = new mysqli('localhost', 'root', '', 'tix');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $movie_id = intval($_POST['movie_id']);
    
    // Unarchive the movie (set archived = 0)
    $conn->query("UPDATE movies SET archived = 0 WHERE movie_id = $movie_id");
    
    // Unarchive all related showings (set archived = 0)
    $conn->query("UPDATE showings SET archived = 0 WHERE movie_id = $movie_id");
    
    // Unarchive all related tickets (set archived = 0)
    $conn->query("UPDATE movie_tickets SET archived = 0 WHERE showing_id IN (SELECT showing_id FROM showings WHERE movie_id = $movie_id)");
}

header("Location: ../manage_movies.php");
exit();
