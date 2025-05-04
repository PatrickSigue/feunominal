<?php
session_start();

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: main.php");
    exit();
}

$host = 'localhost';
$db = 'tix';
$user = 'root';
$pass = '';
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

// Get user info
$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT * FROM users WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user_data = $result->fetch_assoc();
$stmt->close();

// Ticket display logic
$tickets = [];

$ticket_stmt = $conn->prepare("
    SELECT 
            m.movie_title,
            m.movie_id,
            v.venue_name,
            v.venue_id,
            c.name,
            c.cinema_id,
            s.show_date,
            s.show_time,
            s.showing_id,
            t.user_id,
            t.movie_tix_id,
            se.seat_row,
            se.seat_number
        FROM movie_tickets t
        JOIN showings s ON t.showing_id = s.showing_id
        JOIN movies m ON s.movie_id = m.movie_id
        JOIN cinemas c ON s.cinema_id = c.cinema_id
        JOIN venues v ON c.venue_id = v.venue_id
        JOIN seats se ON t.seat_id = se.seats_id
        WHERE t.user_id = ?
");

$ticket_stmt->bind_param("i", $user_id);
$ticket_stmt->execute();
$result = $ticket_stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $tickets[] = $row;
}

$ticket_stmt->close();

?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>Your Profile</title>
    <link rel="stylesheet" href="css/nav.css">
    <link rel="stylesheet" href="css/loginpopup.css">
    <link rel="stylesheet" href="css/profile.css">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="assets/tam.svg">
    <link href="https://fonts.googleapis.com/css2?family=Libre+Barcode+39&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <style>
      .qr-code img {
    width: 200px;
    height: 200px;
    margin-top: 10px;
}

    </style>
  </head>
  <body>
    <nav>
      <div class="navbar">
        <a href="movie.php"><img src="assets/feunominal_nav.png" height="50"></a>
        <div class="nav-links">
          <ul class="links">
            <li><a href="movie.php">MOVIES</a></li>
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
                  <li><a href="php/logout.php?redirect=../movie.php">Log Out</a></li>
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

    <h2 style="margin-top: 100px;">Welcome, <?= htmlspecialchars($user_data['f_name']) ?></h2>

    <h3>Your Tickets</h3>
    
    <?php if (count($tickets) > 0): ?>
        <div style="display: flex; flex-wrap: wrap; gap: 20px; justify-content: center;">
            <?php foreach ($tickets as $ticket): 
                $date = date("F j, Y", strtotime($ticket['show_date']));
                $time = date("g:i A", strtotime($ticket['show_time']));
                $seat = $ticket['seat_row'] . $ticket['seat_number'];
                $barcode = "M{$ticket['movie_id']}V{$ticket['venue_id']}C{$ticket['cinema_id']}Sh{$ticket['showing_id']}Se{$seat}U{$ticket['user_id']}";
            ?>
                <div class="ticket-card" id="ticketCard">
                    <div class="ticket-header">
                        <h2><?= htmlspecialchars($ticket['movie_title']) ?></h2>
                    </div>
                    <div class="ticket-info">
                        <p><strong>Venue:</strong> <?= htmlspecialchars($ticket['venue_name']) ?></p>
                        <p><strong>Cinema:</strong> <?= htmlspecialchars($ticket['name']) ?></p>
                        <p><strong>Date:</strong> <?= $date ?></p>
                        <p><strong>Time:</strong> <?= $time ?></p>
                        <p><strong>Seat:</strong> <?= htmlspecialchars($seat) ?></p>
                        <div class="qr-code">
                          <img src="php/generate_qr.php?data=<?= urlencode($barcode) ?>" alt="QR Code">
                        </div>

                        <button onclick="downloadTicket()">Download Ticket as Image</button>
    
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p>You have no tickets yet.</p>
    <?php endif; ?>





    <script src="script/nav.js"></script>
    <script>
      function downloadTicket() {
          const button = document.querySelector("button");
          button.style.display = "none";  // Hide button
      
          html2canvas(document.getElementById("ticketCard")).then(canvas => {
              const link = document.createElement("a");
              link.download = "ticket.png";
              link.href = canvas.toDataURL();
              link.click();
              button.style.display = "inline";
          });
      }
    </script>


  </body>
</html>
