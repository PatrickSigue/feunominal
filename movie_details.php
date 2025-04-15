<?php
session_start();

$host = 'localhost';
$db = 'tix';
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

$movie_id = isset($_GET['movie_id']) ? intval($_GET['movie_id']) : 0;
if (!$movie_id) die("Invalid request.");

// Movie info
$movie = $conn->query("SELECT movie_title, description, poster, banner FROM movies WHERE movie_id = $movie_id")->fetch_assoc();

// Showings (group by venue > date > cinema > time)
$sql = "SELECT s.showing_id, s.show_date, s.show_time, v.venue_name, c.cinema_id, c.name AS cinema_name, vc.show_count FROM showings s JOIN cinemas c ON s.cinema_id = c.cinema_id JOIN venues v ON c.venue_id = v.venue_id JOIN (SELECT v.venue_id, COUNT(*) AS show_count FROM showings s JOIN cinemas c ON s.cinema_id = c.cinema_id JOIN venues v ON c.venue_id = v.venue_id WHERE s.movie_id = $movie_id AND s.show_date >= CURDATE() GROUP BY v.venue_id) vc ON v.venue_id = vc.venue_id WHERE s.movie_id = $movie_id AND s.show_date >= CURDATE() ORDER BY vc.show_count DESC, v.venue_name, s.show_date, c.name, s.show_time";

$res = $conn->query($sql);

// Group by venue > date > cinema > time
$grouped = [];
while ($row = $res->fetch_assoc()) {
    $venue = $row['venue_name'];
    $date = $row['show_date'];
    $cinema = $row['cinema_name'];

    $grouped[$venue][$date][$cinema][] = [
        'showing_id' => $row['showing_id'],
        'time' => $row['show_time']
    ];
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($movie['movie_title']) ?> - Showtimes</title>
    <link rel="stylesheet" href="css/nav.css">
    <link rel="stylesheet" href="css/loginpopup.css">
    <link rel="stylesheet" href="css/movie_details.css">
  </head>
  <body>
    <nav>
      <div class="navbar">
        <a href="main.php"><img src="assets/feunominal_nav.png" height="50"></a>
        <div class="nav-links">
          <ul class="links">
            <li><a href="main.php">HOME</a></li>
            <li>
              <a href="#">CATEGORIES</a>
              <i class='bx bxs-chevron-down htmlcss-arrow arrow  '></i>
              <ul class="htmlCss-sub-menu sub-menu">
                <li><a href="movie.php">MOVIES</a></li>
                <li><a href="#">CONCERTS</a></li>
                <li><a href="#">FESTIVALS</a></li>
                <li><a href="#">PLAYS</a></li>  
              </ul>
            </li>
            <li><a href="about.php">ABOUT US</a></li>
            <li><a href="#">CONTACT US</a></li>
          </ul>
        </div>
        <div class="search-box">
          <i class='bx bx-search'></i>
          <div class="input-box">
            <input type="text" placeholder="Search...">
          </div>
        </div>
        <?php if (isset($_SESSION['f_name'])): ?>
          <div class="nav-links">
            <div class="links">
              <li>
                <img src="assets/chic.png" height="50">&nbsp;<a href="#"><?php echo htmlspecialchars($_SESSION['f_name']);?></a>
                <i class='bx bxs-chevron-down htmlcss-arrow arrow'></i>
                <ul class="htmlCss-sub-menu sub-menu">
                  <li><a href="#">Profile</a></li>
                  <li><a href="php/logout.php">Log Out</a></li> 
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
  
    <div class="movie-showtimes-page">
      <img class="banner-image" src="<?= htmlspecialchars($movie['banner']) ?>" alt="Banner" class="banner">
      <hr>
      <div class="content-container">
        <div class="poster-container">
          <img src="<?= htmlspecialchars($movie['poster']) ?>" alt="Movie Poster" class="movie-poster">
        </div>
        
        <div class="info-container">
          <h1><?= htmlspecialchars($movie['movie_title']) ?></h1>
          <p class="description"><?= htmlspecialchars($movie['description']) ?></p>
          
          <?php foreach ($grouped as $venue_name => $dates): ?>
            <div class="venue">
              <h2><?= htmlspecialchars($venue_name) ?></h2>
              <div class="date-cards">
                <?php foreach ($dates as $date => $cinemas): ?>
                  <div class="date-card">
                    <h3><?= date("F j, Y", strtotime($date)) ?></h3>
                    <?php foreach ($cinemas as $cinema_name => $times): ?>
                      <div class="cinema-card">
                        <h4><?= htmlspecialchars($cinema_name) ?></h4>
                        <ul>
                          <?php foreach ($times as $t): ?>
                            <li>
                              <a href="booking.php?showing_id=<?= $t['showing_id'] ?>">
                                <?= date("g:i A", strtotime($t['time'])) ?>
                              </a>
                            </li>
                          <?php endforeach; ?>
                        </ul>
                      </div>
                    <?php endforeach; ?>
                  </div>
                <?php endforeach; ?>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
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
