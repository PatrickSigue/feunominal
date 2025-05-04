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
    $message = addslashes($_SESSION['error']);
    echo "<script>alert('$message');</script>";
    unset($_SESSION['error']);
}
// Query to get the tickets sold today
$today_tickets_sql = "SELECT COUNT(movie_tix_id) AS total_tickets FROM movie_tickets WHERE DATE(booking_time) = CURDATE()";
$today_tickets_result = $conn->query($today_tickets_sql);
$today_tickets_row = $today_tickets_result->fetch_assoc();
$today_tickets = $today_tickets_row['total_tickets'];

// Query to get the total tickets sold
$total_tickets_sql = "SELECT COUNT(movie_tix_id) AS total_tickets FROM movie_tickets";
$total_tickets_result = $conn->query($total_tickets_sql);
$total_tickets_row = $total_tickets_result->fetch_assoc();
$total_tickets = $total_tickets_row['total_tickets'];

// Query to get the upcoming showings (showings beyond today's date)
$upcoming_showings_sql = "SELECT COUNT(*) AS upcoming_showings FROM showings WHERE show_date > CURDATE()";
$upcoming_showings_result = $conn->query($upcoming_showings_sql);
$upcoming_showings_row = $upcoming_showings_result->fetch_assoc();
$upcoming_showings = $upcoming_showings_row['upcoming_showings'];

// Query to get the active movies (showings today)
$active_movies_sql = "SELECT COUNT(DISTINCT movie_id) AS active_movies FROM showings WHERE show_date = CURDATE()";
$active_movies_result = $conn->query($active_movies_sql);
$active_movies_row = $active_movies_result->fetch_assoc();
$active_movies = $active_movies_row['active_movies'];

// Query for Overall Overview
$total_movies_sql = "SELECT COUNT(movie_id) AS total_movies FROM movies WHERE archived = 0";
$total_movies_result = $conn->query($total_movies_sql);
$total_movies_row = $total_movies_result->fetch_assoc();
$total_movies = $total_movies_row['total_movies'];

$total_venues_sql = "SELECT COUNT(venue_id) AS total_venues FROM venues WHERE archived = 0";
$total_venues_result = $conn->query($total_venues_sql);
$total_venues_row = $total_venues_result->fetch_assoc();
$total_venues = $total_venues_row['total_venues'];

$total_cinemas_sql = "SELECT COUNT(cinema_id) AS total_cinemas FROM cinemas WHERE archived = 0";
$total_cinemas_result = $conn->query($total_cinemas_sql);
$total_cinemas_row = $total_cinemas_result->fetch_assoc();
$total_cinemas = $total_cinemas_row['total_cinemas'];

$total_users_sql = "SELECT COUNT(user_id) AS total_users FROM users";
$total_users_result = $conn->query($total_users_sql);
$total_users_row = $total_users_result->fetch_assoc();
$total_users = $total_users_row['total_users'];

// Query for Venue Stats
$venue_stats_sql = "
    SELECT 
        v.venue_id,
        v.venue_name,
        COUNT(DISTINCT c.cinema_id) AS num_cinemas,
        COUNT(DISTINCT s.movie_id) AS total_movies,
        COUNT(DISTINCT CASE WHEN s.show_date > CURDATE() THEN s.movie_id END) AS active_movies,
        COUNT(s.showing_id) AS total_showings,
        COUNT(CASE WHEN s.show_date > CURDATE() THEN s.showing_id END) AS active_showings,
        COUNT(mt.movie_tix_id) AS num_tickets,
        COALESCE(SUM(CASE WHEN mt.movie_tix_id IS NOT NULL THEN s.price ELSE 0 END), 0) AS total_earnings
    FROM venues v
    LEFT JOIN cinemas c ON v.venue_id = c.venue_id AND c.archived = 0
    LEFT JOIN showings s ON c.cinema_id = s.cinema_id
    LEFT JOIN movie_tickets mt ON s.showing_id = mt.showing_id
    WHERE v.archived = 0
    GROUP BY v.venue_id, v.venue_name
    ORDER BY v.venue_name";

$venue_stats_result = $conn->query($venue_stats_sql);
$venue_stats = [];
while ($row = $venue_stats_result->fetch_assoc()) {
    $venue_stats[] = $row;
}

// Query for User Stats
$user_stats_sql = "
    SELECT 
        u.user_id,
        u.f_name,
        u.user_type,
        COUNT(DISTINCT v.venue_id) AS num_venues,
        COUNT(DISTINCT c.cinema_id) AS num_cinemas,
        COUNT(DISTINCT s.movie_id) AS total_movies,
        COUNT(DISTINCT CASE WHEN s.show_date > CURDATE() THEN s.movie_id END) AS active_movies,
        COUNT(s.showing_id) AS total_showings,
        COUNT(CASE WHEN s.show_date > CURDATE() THEN s.showing_id END) AS active_showings,
        COUNT(mt.movie_tix_id) AS num_tickets,
        COALESCE(SUM(CASE WHEN mt.movie_tix_id IS NOT NULL THEN s.price ELSE 0 END)) AS total_earnings
    FROM users u
    LEFT JOIN venues v ON u.user_id = v.user_id AND v.archived = 0
    LEFT JOIN cinemas c ON v.venue_id = c.venue_id AND c.archived = 0
    LEFT JOIN showings s ON c.cinema_id = s.cinema_id AND s.user_id = u.user_id
    LEFT JOIN movie_tickets mt ON s.showing_id = mt.showing_id
    WHERE u.user_type IN ('admin', 'organizer')
    GROUP BY u.user_id, u.f_name, u.user_type
    ORDER BY u.f_name";
$user_stats_result = $conn->query($user_stats_sql);
$user_stats = [];
while ($row = $user_stats_result->fetch_assoc()) {
    $user_stats[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="UTF-8">
  <title>FEUNOMINAL EVENTS - Admin Dashboard</title>
  <link rel="stylesheet" href="../css/nav.css">
  <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
  <link rel="icon" type="image/x-icon" href="assets/tam.svg">
  <style>
    /* General container styling */
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f4f9;
      color: #333;
      padding: 20px;
      margin: 0;
      margin-top: 70px; /* Respect the fixed navbar */
      display: flex;
      flex-direction: column;
      align-items: center; /* Center content horizontally */
    }

    /* Headings */
    h1, h2, h3 {
      color: #1e3504;
      margin-bottom: 15px;
      text-align: center;
      width: 100%;
    }

    h1 {
      font-size: 2rem;
    }

    h2 {
      font-size: 1.5rem;
      border-bottom: 2px solid #EFBF04;
      padding-bottom: 5px;
    }

    h3 {
      font-size: 1.2rem;
      margin-top: 20px;
      border-bottom: 2px solid #EFBF04;
      padding-bottom: 5px;
    }

    /* Section row for side-by-side layout */
    .section-row {
      display: flex;
      flex-wrap: wrap;
      gap: 20px;
      width: 100%;
      max-width: 1800px; /* Accommodate three columns */
      margin-bottom: 30px;
      justify-content: center;
    }

    /* Section column for individual cards */
    .section-column {
      flex: 1;
      min-width: 300px; /* Prevent squishing */
      max-width: 580px; /* Match genres.css */
      background-color: #fafafa;
      border-radius: 8px;
      padding: 15px;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    /* Card styling */
    .card {
      padding: 15px; /* Adjusted to match image spacing */
      width: 100%;
      text-align: center;
      align-content: center;
    }

    .card p {
      margin: 8px 0; /* Adjusted to match image spacing */
      font-size: 1rem;
      color: #444;
    }

    .card p strong {
      color: #1e3504;
      font-weight: 600;
    }

    .card ul {
      list-style: none;
      padding: 0;
      margin: 8px 0; /* Adjusted to match image spacing */
    }

    .card ul li {
      margin-bottom: 8px;
    }

    .card ul li a {
      text-decoration: none;
      color: #1e3504;
      font-weight: 600;
      transition: color 0.2s ease;
      display: flex;
      align-items: center;
    }

    .card ul li a:hover {
      color: #34491d;
      text-decoration: underline;
    }

    .card ul li a::before {
      content: attr(data-icon);
      margin-right: 10px;
      font-size: 1.2rem;
    }

    /* Venue Stats Table */
    .venue-stats-table,
    .user-stats-table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 10px;
    }

    .venue-stats-table th,
    .venue-stats-table td,
    .user-stats-table th,
    .user-stats-table td {
      padding: 10px;
      text-align: left;
      border-bottom: 1px solid #ddd;
    }

    .venue-stats-table th,
    .user-stats-table th {
      background-color: #1e3504;
      color: #fff;
      font-weight: 600;
    }

    .venue-stats-table td,
    .user-stats-table td {
      color: #444;
    }

    .venue-stats-table tr:hover,
    .user-stats-table tr:hover {
      background-color: #f0f0f0;
    }

    /* Responsive design */
    @media (max-width: 1200px) {
      .section-row {
        flex-direction: column;
        align-items: center;
      }
      .section-column {
        max-width: 600px;
      }
    }

    @media (max-width: 600px) {
      .card {
        max-width: 100%;
      }
      h1 {
        font-size: 1.8rem;
      }
      h2 {
        font-size: 1.3rem;
      }
      .card p, .card ul li a {
        font-size: 0.95rem;
      }
      .venue-stats-table th,
      .venue-stats-table td,
      .user-stats-table th,
      .user-stats-table td {
        font-size: 0.9rem;
        padding: 8px;
      }
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

<!-- Admin Dashboard Content -->
<h1>Admin Dashboard</h1>
<div class="section-row">
  <!-- Today's Overview Card -->
  <div class="section-column">
    <div class="card">
      <h2>Today's Overview</h2>
      <p>Tickets Sold Today: <strong><?= $today_tickets; ?></strong></p>
      <p>Upcoming Showings: <strong><?= $upcoming_showings; ?></strong></p>
      <p>Active Movies Today: <strong><?= $active_movies; ?></strong></p>
    </div>
  </div>

  <!-- Overall Overview Card -->
  <div class="section-column">
    <div class="card">
      <h2>Overall Overview</h2>
      <p>Total Tickets Sold: <strong><?= $total_tickets; ?></strong></p>
      <p>Total Movies: <strong><?= $total_movies; ?></strong></p>
      <p>Total Venues: <strong><?= $total_venues; ?></strong></p>
      <p>Total Cinemas: <strong><?= $total_cinemas; ?></strong></p>
      <p>Total Users: <strong><?= $total_users; ?></strong></p>
    </div>
  </div>

  <!-- Management Pages Card -->
  <div class="section-column">
    <div class="card">
      <h2>Management Pages</h2>
      <ul>
        <li><a href="manage_movies.php" data-icon="🎥">Manage Movies</a></li>
        <li><a href="manage_showings.php" data-icon="📅">Manage Showings</a></li>
        <li><a href="manage_venues.php" data-icon="🏛">Manage Venues & Cinemas</a></li>
        <li><a href="manage_users.php" data-icon="👥">Manage Users</a></li>
        <li><a href="manage_tickets.php" data-icon="🎟">Manage Tickets</a></li>
        <li><a href="manage_genres.php" data-icon="🏷">Manage Genres</a></li>
      </ul>
    </div>
  </div>
</div>

<!-- Venue Stats Card -->
<div class="section-row">
  <div class="section-column" style="flex: 1; max-width: 100%;">
    <div class="card">
      <h2>Venue Statistics</h2>
      <?php if (empty($venue_stats)): ?>
        <p>No venue statistics available.</p>
      <?php else: ?>
        <table class="venue-stats-table">
          <thead>
            <tr>
              <th>Venue Name</th>
              <th>Cinemas</th>
              <th>Total Movies</th>
              <th>Active Movies</th>
              <th>Total Showings</th>
              <th>Active Showings</th>
              <th>Tickets Sold</th>
              <th>Total Earnings</th>
            </tr>
          </thead>
          <tbody>
            <?php 
              $grand_total_earnings = 0;
              foreach ($venue_stats as $venue): 
                $grand_total_earnings += $venue['total_earnings'];
            ?>
              <tr>
                <td><?= htmlspecialchars($venue['venue_name']); ?></td>
                <td><?= $venue['num_cinemas']; ?></td>
                <td><?= $venue['total_movies']; ?></td>
                <td><?= $venue['active_movies']; ?></td>
                <td><?= $venue['total_showings']; ?></td>
                <td><?= $venue['active_showings']; ?></td>
                <td><?= $venue['num_tickets']; ?></td>
                <td>₱ <?= number_format($venue['total_earnings'], 2); ?></td>
              </tr>
            <?php endforeach; ?>
            <tr style="font-weight: bold;">
              <td colspan="7" style="text-align: right;">Grand Total Earnings:</td>
              <td>₱ <?= number_format($grand_total_earnings, 2); ?></td>
            </tr>
          </tbody>
        </table>
      <?php endif; ?>
    </div>
  </div>
</div>

<!-- User Stats Card -->
<div class="section-row">
  <div class="section-column" style="flex: 1; max-width: 100%;">
    <div class="card">
      <h2>User Statistics (Admins & Organizers)</h2>
      <?php if (empty($user_stats)): ?>
        <p>No user statistics available.</p>
      <?php else: ?>
        <table class="user-stats-table">
          <thead>
            <tr>
              <th>User Name</th>
              <th>User Type</th>
              <th>Venues</th>
              <th>Cinemas</th>
              <th>Total Movies</th>
              <th>Active Movies</th>
              <th>Total Showings</th>
              <th>Active Showings</th>
              <th>Tickets Sold</th>
              <th>Total Earnings</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($user_stats as $user): ?>
              <tr>
                <td><?= htmlspecialchars($user['f_name']); ?></td>
                <td><?= htmlspecialchars($user['user_type']); ?></td>
                <td><?= $user['num_venues']; ?></td>
                <td><?= $user['num_cinemas']; ?></td>
                <td><?= $user['total_movies']; ?></td>
                <td><?= $user['active_movies']; ?></td>
                <td><?= $user['total_showings']; ?></td>
                <td><?= $user['active_showings']; ?></td>
                <td><?= $user['num_tickets']; ?></td>
                <td>₱ <?= number_format($user['total_earnings'], 2); ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      <?php endif; ?>
    </div>
  </div>
</div>

<script src="../script/nav.js"></script>
</body>
</html>