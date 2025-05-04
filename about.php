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

  // Fetch all genres
  $genres = [];
  $genre_sql = "SELECT genre FROM genres";
  $genre_result = $conn->query($genre_sql);
  if ($genre_result && $genre_result->num_rows > 0) {
      while ($row = $genre_result->fetch_assoc()) {
          $genres[] = $row['genre'];
      }
  }

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <title>About Us</title>
    <link rel="stylesheet" href="css/nav.css">
    <link rel="stylesheet" href="css/loginpopup.css">
    <link rel="stylesheet" href="css/about.css">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="assets/tam.svg">
  </head>
  <body>
    <nav>
      <div class="navbar">
        <a href="movie.php"><img src="assets/feunominal_nav.png" height="50"></a>
        <div class="nav-links">
          <ul class="links">
            <li><a href="movie.php">HOME</a></li>
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
                <i class='bx bxs-chevron-down htmlcss-arrow arrow  '></i>
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

    <section class="about-section">
      <div class="content">
        <div class="usekawit" style="margin-left: 50%; margin-top:40px;">ABOUT US</div>
          <p style="font-family: Poppins, sans-serif;font-size: 25px; margin-left: 50%; margin-top: 40px; color: white; margin-right: 50px; text-align: right ;">
        This project, Feunominal Events, is an online ticketing service designed to streamline the movie booking experience. The four of us started this project to show our love for cinema and the arts.    Users can browse available movies, view movie seating arrangements, and securely purchase tickets—all from a user-friendly web interface. We hope to be able to provide customers a sophisticated   website which offers a centralized platform for movie organizers and attendees, provides customizable or default seat plans for each venue, displays venue addresses stored separately for     flexibility, and ensures smooth ticket purchasing and seat selection. We hope to share the beauty of films and cinema to everyone interested.</p>
      </div>
    </section>
    
    <div class="usekawit" style="margin-top: 20px;">
    THE FEUNTASTIC FOUR
    </div>

    <div class="grid-container">
      <div class="profile-card">
        <div class="profile-card-header">
          <div class="profile-image img-1"></div>
    
          <div class="profile-info">
            <h3 class="profile-name">Julian Quijano</h3>
            <p class="profile-desc">Ethical Hacker/Programmer</p>
          </div>
        </div>
    
        <div class="profile-card-body">
          <ul class="status">
            <li>
              <span class="status-value">532</span>
              <span class="status-text">Posts</span>
            </li>
            <li>
              <span class="status-value">1.5m</span>
              <span class="status-text">Followers</span>
            </li>
            <li>
              <span class="status-value">423</span>
              <span class="status-text">Following</span>
            </li>
          </ul>
    
          <div class="action">
            <button class="btn btn-pink">Follow</button>
            <button class="btn btn-gray-outline">Message</button>
          </div>
        </div>
      </div>
    
      <div class="profile-card">
        <div class="profile-card-header">
          <div class="profile-image img-2"></div>
    
          <div class="profile-info">
            <h3 class="profile-name">Owen Santiago</h3>
            <p class="profile-desc">Ethical Hacker/Programmer</p>
          </div>
        </div>
    
        <div class="profile-card-body">
          <ul class="status">
            <li>
              <span class="status-value">532</span>
              <span class="status-text">Posts</span>
            </li>
            <li>
              <span class="status-value">1.5m</span>
              <span class="status-text">Followers</span>
            </li>
            <li>
              <span class="status-value">423</span>
              <span class="status-text">Following</span>
            </li>
          </ul>
    
          <div class="action">
            <button class="btn btn-pink">Follow</button>
            <button class="btn btn-gray-outline">Message</button>
          </div>
        </div>
      </div>
      <div class="profile-card">
        <div class="profile-card-header">
          <div class="profile-image img-3"></div>
    
          <div class="profile-info">
            <h3 class="profile-name">Patrick Sigue</h3>
            <p class="profile-desc">Ethical Hacker/Programmer</p>
          </div>
        </div>
    
        <div class="profile-card-body">
          <ul class="status">
            <li>
              <span class="status-value">532</span>
              <span class="status-text">Posts</span>
            </li>
            <li>
              <span class="status-value">1.5m</span>
              <span class="status-text">Followers</span>
            </li>
            <li>
              <span class="status-value">423</span>
              <span class="status-text">Following</span>
            </li>
          </ul>
    
          <div class="action">
            <button class="btn btn-pink">Follow</button>
            <button class="btn btn-gray-outline">Message</button>
          </div>
        </div>
      </div>
      <div class="profile-card">
        <div class="profile-card-header">
          <div class="profile-image img-4"></div>
    
          <div class="profile-info">
            <h3 class="profile-name">Aldrin Tupas</h3>
            <p class="profile-desc">Ethical Hacker/Programmer</p>
          </div>
        </div>
    
        <div class="profile-card-body">
          <ul class="status">
            <li>
              <span class="status-value">532</span>
              <span class="status-text">Posts</span>
            </li>
            <li>
              <span class="status-value">1.5m</span>
              <span class="status-text">Followers</span>
            </li>
            <li>
              <span class="status-value">423</span>
              <span class="status-text">Following</span>
            </li>
          </ul>
    
          <div class="action">
            <button class="btn btn-pink">Follow</button>
            <button class="btn btn-gray-outline">Message</button>
          </div>
        </div>
      </div>
    </div>

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

    <script src="script/nav.js"></script>
    <script src="script/loginpopup.js"></script>

  </body>
</html>