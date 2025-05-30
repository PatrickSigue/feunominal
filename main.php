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

  $sql = "SELECT event_name, poster FROM events";
  $result = $conn->query($sql);

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
    <style>
      .poster-container {
          text-align: center; /* Center align the text */
          margin: 20px;      /* Add some margin */
      }
      .poster-image {
          width: 200px;      /* Set a fixed width for images */
          height: auto;      /* Maintain aspect ratio */
      }
      .poster-name {
          font-size: 18px;   /* Set font size for the event name */
          margin-top: 10px;  /* Add space above the name */
      }
    </style>
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
                <img src="assets/chic.png" height="50">&nbsp;<a style = "font-family: 'Kawit';"href="#"><?php echo htmlspecialchars($_SESSION['f_name']);?></a>
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
              <a href="#" id = "openModal"><img src="assets/tam.png" height="50"></a>
            </div>
          <?php endif; ?> 
      </div>
    </nav>
  
    <div class = "rowone">
      <h2>Testing main</h2>
    </div>
    <div class="row">
      <?php
      if ($result->num_rows > 0) {
          // Output data of each row
          while($row = $result->fetch_assoc()) {
              echo "<div class='poster-container'>";
              echo "<img class='poster-image' src='" . htmlspecialchars($row["poster"]) . "' alt='" . htmlspecialchars($row["event_name"]) . "'>"; // Poster image
              echo "<h2 class='poster-name'>" . htmlspecialchars($row["event_name"]) . "</h2>"; // Event name below the poster
              echo "</div>";
          }
      } else {
          echo "No posters available.";
      }
      ?>
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
    </div>

    <script src="script/nav.js"></script>
    <script src="script/loginpopup.js"></script>

  </body>
</html>