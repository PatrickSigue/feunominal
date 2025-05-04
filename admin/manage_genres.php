<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'tix');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch genres and movies for dropdown and checkboxes
$genres_res = $conn->query("SELECT * FROM genres ORDER BY genre ASC");
$movies_res = $conn->query("SELECT movie_id, movie_title FROM movies ORDER BY movie_title ASC");

if (isset($_GET['error']) && $_GET['error'] === 'genre_associated_with_movies') {
    echo "<script>alert('Cannot delete genre because it is assigned to one or more movies.');</script>";
}
if (isset($_GET['status']) && $_GET['status'] === 'genre_deleted') {
    echo "<script>alert('Genre deleted successfully.');</script>";
}
if (isset($_GET['status']) && $_GET['status'] === 'genre_added') {
    echo "<script>alert('Genre added successfully.');</script>";
}
if (isset($_GET['error']) && $_GET['error'] === 'duplicate_genre') {
    echo "<script>alert('Genre already exists.');</script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Genre Management</title>
    <link rel="stylesheet" href="../css/nav.css">
    <link rel="stylesheet" href="css/genres.css">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <link rel="icon" type="image/x-icon" href="assets/tam.svg">
    <style type="text/css">
        body {
            margin-top: 70px;
        }
    </style>
</head>
<body>
<nav>
  <div class="navbar">
    <a href="admin.php"><img src="../assets/feunominal_nav.png" height="50"></a>
    <div class="nav-links">
      <ul class="links">
        <li><a href="admin.php">DASHBOARD</a></li>
        <li>
          <a href="#">MANAGE</a>
          <i class='bx bxs-chevron-down htmlcss-arrow arrow'></i>
          <ul class='htmlCss-sub-menu sub-menu'>            
            <li><a href="manage_movies.php">Movies</a></li>
            <li><a href="manage_showings.php">Showings</a></li>
            <li><a href="manage_venues.php">Venues & Cinemas</a></li>
            <li><a href="manage_users.php">Users</a></li>
            <li><a href="manage_tickets.php">Tickets</a></li>
            <li><a href="manage_genres.php">Genres</a></li>
          </ul>
        </li>
      </ul>
    </div>
    <?php if (isset($_SESSION['f_name'])): ?>
      <div class="nav-links">
        <div class="links">
          <li>
            <img src="../assets/chic.png" height="50"> <a href="#"><?php echo htmlspecialchars($_SESSION['f_name']);?></a>
            <i class='bx bxs-chevron-down htmlcss-arrow arrow'></i>
            <ul class="htmlCss-sub-menu sub-menu">
              <li><a href="../php/logout.php?redirect=../movie.php">Log Out</a></li>
            </ul>
          </li>
        </div>
      </div>
    <?php else: ?>
      <div class="links">
        <a href="#" id="openModal"><img src="assets/tam.png" height="50"></a>
      </div>
    <?php endif; ?>
  </div>
</nav>

<h1>Genre Management</h1>

<!-- Row for Add Genre and Genres -->
<div class="section-row">
    <!-- Add Genre Form -->
    <div class="section-column">
        <h2>Add Genre</h2>
        <form method="POST" action="php/add_genre.php">
            <label for="genre">Genre Name:</label>
            <input type="text" id="genre" name="genre" required>
            <button type="submit">Add Genre</button>
        </form>
    </div>

    <!-- View Genres -->
    <div class="section-column">
        <h2>Genres</h2>
        <div class="genre-list">
            <?php
            $genres_res->data_seek(0); // Reset the result pointer
            while ($genre = $genres_res->fetch_assoc()) { ?>
                <div class="genre-item">
                    <span><?= htmlspecialchars($genre['genre']) ?></span>
                    <a href="php/delete_genre.php?genre_id=<?= $genre['genre_id'] ?>" onclick="return confirm('Are you sure you want to delete this genre?')">Delete</a>
                </div>
            <?php } ?>
        </div>
    </div>
</div>

<!-- Row for Assign Genre and Remove Genre -->
<div class="section-row">
    <!-- Assign Genre to Movie -->
    <div class="section-column">
        <h2>Assign Genre to Movie</h2>
        <form method="POST" action="php/assign_genre.php">
            <label for="movie_id">Select Movie:</label>
            <select name="movie_id" id="movie_id" required>
                <option value="">Select Movie</option>
                <?php
                $movies_res->data_seek(0); // Reset the result pointer
                while ($movie = $movies_res->fetch_assoc()) { ?>
                    <option value="<?= $movie['movie_id'] ?>"><?= htmlspecialchars($movie['movie_title']) ?></option>
                <?php } ?>
            </select>
            
            <h3>Select Genres:</h3>
            <div class="genre-checkboxes">
                <?php
                $genres_res->data_seek(0); // Reset the result pointer
                while ($genre = $genres_res->fetch_assoc()) {
                    echo "<label><input type='checkbox' name='genres[]' value='{$genre['genre_id']}'> " . htmlspecialchars($genre['genre']) . "</label>";
                }
                ?>
            </div>
            <button type="submit">Assign Genres</button>
        </form>
    </div>

    <!-- Remove Genre from Movie -->
    <div class="section-column">
        <h2>Remove Genre from Movie</h2>
        <form method="POST" action="php/remove_genre.php">
            <label for="movie_id_remove">Select Movie:</label>
            <select name="movie_id" id="movie_id_remove" required onchange="loadAssociatedGenres(this.value)">
                <option value="">Select Movie</option>
                <?php
                $movies_res->data_seek(0); // Reset the result pointer
                while ($movie = $movies_res->fetch_assoc()) { ?>
                    <option value="<?= $movie['movie_id'] ?>"><?= htmlspecialchars($movie['movie_title']) ?></option>
                <?php } ?>
            </select>
            
            <h3>Genres Associated with this Movie:</h3>
            <div id="associated_genres">
                <!-- Associated genres will be loaded here via AJAX -->
            </div>
            <button type="submit" id="remove_button" disabled>Remove Selected Genres</button>
        </form>
    </div>
</div>

<script>
function loadAssociatedGenres(movieId) {
    if (!movieId) {
        document.getElementById('associated_genres').innerHTML = '';
        document.getElementById('remove_button').disabled = true;
        return;
    }

    fetch('php/get_associated_genres.php?movie_id=' + movieId)
        .then(response => response.json())
        .then(data => {
            const genresContainer = document.getElementById('associated_genres');
            genresContainer.innerHTML = '';

            if (data.length === 0) {
                genresContainer.innerHTML = '<p>No genres associated with this movie.</p>';
                document.getElementById('remove_button').disabled = true;
            } else {
                data.forEach(genre => {
                    const label = document.createElement('label');
                    label.innerHTML = `<input type="checkbox" name="genres[]" value="${genre.genre_id}"> ${genre.genre}<br>`;
                    genresContainer.appendChild(label);
                });
                document.getElementById('remove_button').disabled = false;
            }
        })
        .catch(error => {
            console.error('Error fetching genres:', error);
            document.getElementById('associated_genres').innerHTML = '<p>Error loading genres.</p>';
            document.getElementById('remove_button').disabled = true;
        });
}
</script>
</body>
</html>