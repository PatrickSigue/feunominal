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

  $movie = "SELECT DISTINCT m.movie_id, m.movie_title, m.poster, m.banner, m.archived FROM movies m JOIN showings s ON m.movie_id = s.movie_id WHERE s.show_date >= CURDATE() AND m.archived = 0 ORDER BY s.show_date LIMIT 10";
  $result = $conn->query($movie);
  
  $movies = [];
  
  if ($result && $result->num_rows > 0) {
      while($row = $result->fetch_assoc()) {
          $movies[] = $row;
      }
  }

  $venue = "SELECT v.venue_id,v.venue_name, m.movie_id, m.movie_title, m.poster, m.banner, m.archived, v.archived FROM venues v JOIN cinemas c ON v.venue_id = c.venue_id JOIN showings s ON c.cinema_id = s.cinema_id JOIN movies m ON s.movie_id = m.movie_id WHERE s.show_date >= CURDATE() AND m.archived = 0 AND v.archived = 0 GROUP BY v.venue_id, m.movie_id ORDER BY v.venue_name";

  $result = $conn->query($venue);
  
  $venues = [];
  
  while ($row = mysqli_fetch_assoc($result)) {
      $venueId = $row['venue_id'];
      
      if (!isset($venues[$venueId])) {
          $venues[$venueId] = [
              'venue_name' => $row['venue_name'],
              'movies' => []
          ];
      }
  
      $venues[$venueId]['movies'][] = [
          'movie_id' => $row['movie_id'],
          'movie_title' => $row['movie_title'],
          'poster' => $row['poster'],
          'banner' => $row['banner']
      ];
  }

  if (isset($_SESSION['error'])) {
        echo "<script>alert('" . $_SESSION['error'] . " ');</script>";
        unset($_SESSION['error']);
    }
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <title>FEUNOMINAL EVENTS</title>
    <link rel="stylesheet" href="css/nav.css">
    <link rel="stylesheet" href="css/loginpopup.css">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="assets/tam.svg">
    <link rel="stylesheet" href="css/movie.css">
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
  </head>
  <body>
    <nav>
      <div class="navbar">
        <a href="movie.php"><img src="assets/feunominal_nav.png" height="50"></a>
        <div class="nav-links">
          <ul class="links">
            <li>
              <a href="genres.php?genre=Action">GENRES</a>
              <i class='bx bxs-chevron-down htmlcss-arrow arrow  '></i>
              <?php
                $genre_sql = "SELECT genre FROM genres ORDER BY genre DESC LIMIT 5";
                $genre_result = $conn->query($genre_sql);
              
                if ($genre_result && $genre_result->num_rows > 0) {
                    echo "<ul class='htmlCss-sub-menu sub-menu'>";
                    while($genre = $genre_result->fetch_assoc()) {
                        echo "<li><a href='genres.php?genre=" . urlencode($genre['genre']) . "'>" . htmlspecialchars($genre['genre']) . "</a></li>";
                    }
                    echo "</ul>";

                } else {
                    echo "<ul class='htmlCss-sub-menu sub-menu'><li><a href='#'>No genres</a></li></ul>";
                }
              ?>
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
    <div class="rowone-wrapper">
      <div class="rowone">
        <?php
          if (!empty($movies)) {
            foreach($movies as $row) {
              echo "<div class='banner-container'>";
              echo "<a href='movie_details.php?movie_id=" . urlencode($row['movie_id']) . "'>";
              echo "<img class='banner-image' src='" . htmlspecialchars($row["banner"]) . "' alt='" . htmlspecialchars($row["movie_title"]) . "'>";
              echo "</a>";
              echo "</div>";
            }
          } else {
              echo "No banners available.";
          }
        ?>
      </div>
      <div class="banner-indicators">
          <?php foreach ($movies as $index => $row): ?>
            <span class="dot" data-index="<?= $index ?>"></span>
          <?php endforeach; ?>
        </div>
    </div>
    <?php
      foreach ($venues as $venueId => $venue) {
          echo "<h2 class='venue-name'>" . htmlspecialchars($venue['venue_name']) . "</h2>";
          echo "<hr>";
          echo "<div class='swiper-container'>";
          echo "<div class='swiper mySwiper'>";
          echo "<div class='swiper-wrapper'>";
      
          foreach ($venue['movies'] as $movie) {
              $movieId = $movie['movie_id'];
              $movieTitle = htmlspecialchars($movie['movie_title']);
              $poster = htmlspecialchars($movie['poster']);
              $link = "movie_details.php?movie_id={$movieId}";
      
              echo "<div class='swiper-slide'>";
              echo "<div class='poster-container'>";
              echo "<a href='{$link}'>";
              echo "<img class='poster-image' src='{$poster}' alt='{$movieTitle}'>";
              echo "</a>";
              echo "<h2 class='poster-name'>{$movieTitle}</h2>";
              echo "</div>";
              echo "</div>";
          }
      
          echo "</div>";
          echo "<div class='swiper-button-next'></div>";
          echo "<div class='swiper-button-prev'></div>";
          echo "<div class='swiper-pagination'></div>";
          echo "</div>";
          echo "</div>";
      }
    ?>
    <div id="modal" class="modal">
      <div class = "wrapper-container"></div>
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
                  <input type="email" name = 'email' id="email" placeholder="Email Address" required>
                </div>
                <div class="field">
                  <input type="password" id="password" name="password" placeholder="Password" required>
                </div>
                <div class="pass-link"><a href="#">Forgot password?</a></div>
                <input type="hidden" name="redirect_to" value="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']); ?>" />
                <div class="field btn">
                  <div class="btn-layer"></div>
                  <input type="submit" value="Login">
                </div>
                <div class="signup-link">Not a member? <a href="">Signup now</a></div>
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
                <input type="hidden" name="redirect_to" value="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']); ?>" />
                <div class="field btn">
                  <div class="btn-layer"></div>
                  <input type="submit" value="Signup">
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>

    <script src="script/nav.js"></script>
    <script src="script/loginpopup.js"></script>
    <script src="script/banner_carousel.js"></script>
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <script src="script/poster_carousel.js"></script>

  </body>
</html>