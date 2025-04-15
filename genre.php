<?php

session_start();
$host = 'localhost';
  $db = 'tix';
  $user = 'root';
  $pass = '';
  
  $conn = new mysqli($host, $user, $pass, $db);
  
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }

  if (isset($_SESSION['error'])) {
      echo "<script>alert('" . $_SESSION['error'] . " ');</script>";
      unset($_SESSION['error']);
  }

if (!isset($_GET['name'])) {
    echo "Genre not specified.";
    exit;
}

$genreName = $_GET['name'];

// Get genre_id from genre name
$genreStmt = $conn->prepare("SELECT genre_id FROM genres WHERE genre = ?");
$genreStmt->bind_param("s", $genreName);
$genreStmt->execute();
$genreResult = $genreStmt->get_result();

if ($genreResult->num_rows === 0) {
    echo "Genre not found.";
    exit;
}

$genreRow = $genreResult->fetch_assoc();
$genreId = $genreRow['genre_id'];

// Get movies associated with this genre
$movieStmt = $conn->prepare("
    SELECT m.movie_id, m.movie_title, m.description, m.poster
    FROM movies m
    JOIN movie_genres mg ON m.movie_id = mg.movie_id
    WHERE mg.genre_id = ?
");
$movieStmt->bind_param("i", $genreId);
$movieStmt->execute();
$movies = $movieStmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title><?php echo htmlspecialchars($genreName); ?> Movies</title>
    <link rel="stylesheet" href="your-style.css">
    <style>
        .movie-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
    gap: 20px;
    padding: 20px;
}

.movie-card {
    border: 1px solid #ccc;
    padding: 15px;
    border-radius: 8px;
    text-align: center;
    background: #fff;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}
    </style>
</head>
<body>

    <h1><?php echo htmlspecialchars($genreName); ?> Movies</h1>

    <?php if ($movies->num_rows > 0): ?>
        <div class="movie-grid">
            <?php while ($movie = $movies->fetch_assoc()): ?>
                <div class="movie-card">
                    <img src="<?php echo htmlspecialchars($movie['poster']); ?>" alt="Poster" height="200">
                    <h3><?php echo htmlspecialchars($movie['movie_title']); ?></h3>
                    <p><?php echo htmlspecialchars($movie['description']); ?></p>
                </div>
            <?php endwhile; ?>
        </div>
    <?php else: ?>
        <p>No movies found in this genre.</p>
    <?php endif; ?>

</body>
</html>
