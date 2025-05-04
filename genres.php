<?php
session_start();

$host = 'localhost';
$db = 'tix';
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

if (isset($_SESSION['error'])) {
    echo "<script>alert('" . $_SESSION['error'] . " ');</script>";
    unset($_SESSION['error']);
}

// Fetch all genres
$genres = [];
$genre_sql = "SELECT genre FROM genres";
$genre_result = $conn->query($genre_sql);
if ($genre_result && $genre_result->num_rows > 0) {
    while ($row = $genre_result->fetch_assoc()) {
        $genres[] = $row['genre'];
    }
}

// Handle selected genre
$selected_genre = isset($_GET['genre']) ? $_GET['genre'] : null;
$movies = [];
if ($selected_genre) {
    $stmt = $conn->prepare("
        SELECT m.* 
        FROM movies m
        JOIN movie_genres mg ON m.movie_id = mg.movie_id
        JOIN genres g ON g.genre_id = mg.genre_id
        WHERE g.genre = ? AND m.archived = 0
    ");
    $stmt->bind_param("s", $selected_genre);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($movie = $result->fetch_assoc()) {
        $movies[] = $movie;
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <title>FEUNOMINAL EVENTS</title>
    <link rel="stylesheet" href="css/nav.css">
    <link rel="stylesheet" href="css/loginpopup.css">
    <link rel="stylesheet" href="css/genres.css">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <link rel="icon" type="image/x-icon" href="assets/tam.svg">
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
  </head>
  <body>
    <nav>
      <div class="navbar">
        <a href="movie.php"><img src="assets/feunominal_nav.png" height="50"></a>
        <div class="nav-links">
          <ul class="links">
            <li><a href="movie.php">MOVIES</a></li>
            <li>
              <a href="#">GENRES</a>
              <i class='bx bxs-chevron-down htmlcss-arrow arrow  '></i>
              <?php if (!empty($genres)): ?>
                <ul class='htmlCss-sub-menu sub-menu'>
                  <?php foreach (array_slice(array_reverse($genres), 0, 5) as $genre): ?>
                    <li><a href="genres.php?genre=<?= urlencode($genre) ?>"><?= htmlspecialchars($genre) ?></a></li>
                  <?php endforeach; ?>
                </ul>
              <?php else: ?>
                <ul class='htmlCss-sub-menu sub-menu'><li><a href='#'>No genres</a></li></ul>
              <?php endif; ?>
            </li>
            <li><a href="about.php">ABOUT US</a></li>
            <li><a href="#">CONTACT US</a></li>
          </ul>
        </div>
        <div class="search-box">
          <form action="search_result.php" method="GET">
            <i class='bx bx-search'></i>
            <div class="input-box">
              <input type="text" name="search" placeholder="Search..." value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
            </div>
          </form>
        </div>
        <?php if (isset($_SESSION['f_name'])): ?>
          <div class="nav-links">
            <div class="links">
              <li>
                <img src="assets/chic.png" height="50">&nbsp;<a href="#"><?php echo htmlspecialchars($_SESSION['f_name']);?></a>
                <i class='bx bxs-chevron-down htmlcss-arrow arrow'></i>
                <ul class="htmlCss-sub-menu sub-menu">
                  <li><a href="profile.php">Profile</a></li>
                  <li><a href="php/logout.php?redirect=<?= urlencode($_SERVER['REQUEST_URI']) ?>">Log Out</a></li>
                </ul>
              </li>
            </div>
          </div>
          <?php else: ?>
            <div class="links">
              <a href="#" id = "openModal"><img src="assets/tam.png" height="50"></a>
            </div>
          <?php endif; ?> 
      </div>
    </nav>

    <div class="content-container">
      <div class="side">
    <div class="menu">
      <ul>
        <?php foreach ($genres as $genre): ?>
          <?php
          $encoded = urlencode($genre);
          $safe = htmlspecialchars($genre);
          $active = ($selected_genre === $genre) ? "class='active'" : "";
          ?>
          <li><a href="?genre=<?= $encoded ?>" <?= $active ?>><span><?= $safe ?></span></a></li>
        <?php endforeach; ?>
        <?php if (empty($genres)): ?>
          <li><span>No genres found</span></li>
        <?php endif; ?>
      </ul>
    </div>
      </div>
    
      <div class="genre-content">
        <?php if ($selected_genre): ?>
          <h1 style="font-family: 'Kawit';"><?= htmlspecialchars($selected_genre) ?></h1>
          <?php if (!empty($movies)): ?>
            <div class="poster-gallery">
              <?php foreach ($movies as $movie): ?>
                <div class="poster-container">
                  <a href="movie_details.php?movie_id=<?= htmlspecialchars($movie['movie_id']) ?>">
                    <img src="<?= htmlspecialchars($movie['poster']) ?>" alt="<?= htmlspecialchars($movie['movie_title']) ?>" class="poster-image">
                  </a>
                  <div class="poster-name"><?= htmlspecialchars($movie['movie_title']) ?></div>
                </div>
              <?php endforeach; ?>
            </div>
          <?php else: ?>
            <p>No movies found in this genre.</p>
        <?php endif; ?>
        <?php else: ?>
          <h2>Please select a genre</h2>
        <?php endif; ?>
      </div>
    </div>

    <div id="modal" class="modal">
      <div class="wrapper-container"></div>
      <div class="wrapper">
        <img src="assets/tam.png" height="100">
        <div class="form-container">
          <div class="slide-controls">
            <input type="radio" name="slide" id="login" checked>
            <input type="radio" name="slide" id="signup">
            <label for="login" class="slide login">Login</label>
            <label for="signup" class="slide signup">Signup</label>
            <div class="slider-tab"></div>
          </div>
          <div class="form-inner">
            <form action="php/login.php" class="login" autocomplete="off" method="POST">
              <div class="field">
                <input type="email" name="email" id="email" placeholder="Email Address" required>
              </div>
              <div class="field">
                <input type="password" id="password" name="password" placeholder="Password" required>
              </div>
              <div class="pass-link"><a href="#">Forgot password?</a></div>
              <input type="hidden" name="redirect_to" value="<?= htmlspecialchars($_SERVER['REQUEST_URI']) ?>" />
              <div class="field btn">
                <div class="btn-layer"></div>
                <input type="submit" value="Login">
              </div>
              <div class="signup-link">Not a member? <a href="#">Signup now</a></div>
            </form>
            <form action="php/signup.php" class="signup" autocomplete="off" method="POST">
              <div class="field">
                <input type="email" placeholder="Email Address" name="email" id="email" required>
              </div>
              <div class="field">
                <input type="text" placeholder="First Name" name="fname" id="fname" required>
              </div>
              <div class="field">
                <input type="text" placeholder="Last Name" name="lname" id="lname" required>
              </div>
              <div class="field">
                <input type="password" placeholder="Password" name="pword" id="pword" required>
              </div>
              <div class="field">
                <input type="password" placeholder="Confirm password" name="cpword" id="cpword" required>
              </div>
              <input type="hidden" name="redirect_to" value="<?= htmlspecialchars($_SERVER['REQUEST_URI']) ?>" />
              <div class="field btn">
                <div class="btn-layer"></div>
                <input type="submit" value="Signup">
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <script src="script/nav.js"></script>
    <script src="script/loginpopup.js"></script>
  </body>
</html>