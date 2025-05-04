<?php
header('Content-Type: application/json');

$conn = new mysqli('localhost', 'root', '', 'tix');
if ($conn->connect_error) {
    die(json_encode(['error' => 'Connection failed: ' . $conn->connect_error]));
}

if (isset($_GET['movie_id'])) {
    $movie_id = intval($_GET['movie_id']); // Sanitize input
    $query = "SELECT g.genre_id, g.genre FROM genres g
              JOIN movie_genres mg ON g.genre_id = mg.genre_id
              WHERE mg.movie_id = ?";
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $movie_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $genres = [];
    while ($row = $result->fetch_assoc()) {
        $genres[] = [
            'genre_id' => $row['genre_id'],
            'genre' => htmlspecialchars($row['genre'])
        ];
    }

    echo json_encode($genres);
    $stmt->close();
} else {
    echo json_encode([]);
}

$conn->close();
?>