<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'tix');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cinema & Venue Management</title>
    <link rel="stylesheet" href="../css/nav.css">
    <link rel="stylesheet" href="css/manage_venues.css">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <link rel="icon" type="image/x-icon" href="assets/tam.svg">
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

<!-- Display Messages as Alerts -->
<?php
if (isset($_GET['error'])) {
    $message = '';
    switch ($_GET['error']) {
        case 'duplicate_venue':
            $message = 'Venue name already exists.';
            break;
        case 'duplicate_cinema':
            $message = 'Cinema name already exists for this venue.';
            break;
        case 'insert_failed':
            $message = 'Failed to add item. Please try again.';
            break;
        case 'invalid_request':
            $message = 'Invalid request.';
            break;
        default:
            $message = 'An unknown error occurred.';
    }
    echo "<script>alert('$message');</script>";
}
if (isset($_GET['status'])) {
    $statusMsg = '';
    switch ($_GET['status']) {
        case 'cinema_added':
            $statusMsg = 'Cinema successfully added.';
            break;
        case 'venue_added':
            $statusMsg = 'Venue successfully added.';
            break;
        case 'archived':
            $statusMsg = 'Item successfully archived.';
            break;
        case 'unarchived':
            $statusMsg = 'Item successfully unarchived.';
            break;
    }
    echo "<script>alert('$statusMsg');</script>";
}
?>

<h1>Venue Management</h1>
<div class="section-row">
    <!-- Add New Venue -->
    <div class="section-column">
        <h2>Add New Venue</h2>
        <form class="form-q" action="php/add_venue.php" method="POST">
            <label>Venue Name:</label>
            <input type="text" name="venue_name" required>
            <label>Address:</label>
            <textarea name="address" required></textarea>
            <button type="submit" name="add_venue">Add Venue</button>
        </form>
    </div>

    <!-- Active Venues -->
    <div class="section-column">
        <h2>Active Venues</h2>
        <table>
            <tr><th>Venue Name</th><th>Address</th><th>Added by</th><th>Actions</th></tr>
            <?php
            $res = $conn->query("SELECT v.venue_id, v.venue_name, v.address, CONCAT(u.f_name, ' ', u.s_name) AS user_name
                                 FROM venues v 
                                 JOIN users u ON v.user_id = u.user_id 
                                 WHERE v.archived = 0");
            while ($venue = $res->fetch_assoc()) {
                echo "<tr>
                    <td>" . htmlspecialchars($venue['venue_name']) . "</td>
                    <td>" . htmlspecialchars($venue['address']) . "</td>
                    <td>" . htmlspecialchars($venue['user_name']) . "</td>
                    <td>
                        <form method='POST' action='php/archive_venue.php' onsubmit=\"return confirm('Archive this venue?');\">
                            <input type='hidden' name='venue_id' value='" . $venue['venue_id'] . "'>
                            <input type='submit' value='Archive'>
                        </form>
                    </td>
                </tr>";
            }
            ?>
        </table>
    </div>

    <!-- Archived Venues -->
    <div class="section-column">
        <h2>Archived Venues</h2>
        <table>
            <tr><th>Venue Name</th><th>Address</th><th>Added by</th><th>Actions</th></tr>
            <?php
            $res = $conn->query("SELECT v.venue_id, v.venue_name, v.address, CONCAT(u.f_name, ' ', u.s_name) AS user_name
                                 FROM venues v 
                                 JOIN users u ON v.user_id = u.user_id 
                                 WHERE v.archived = 1");
            while ($venue = $res->fetch_assoc()) {
                echo "<tr>
                    <td>" . htmlspecialchars($venue['venue_name']) . "</td>
                    <td>" . htmlspecialchars($venue['address']) . "</td>
                    <td>" . htmlspecialchars($venue['user_name']) . "</td>
                    <td>
                        <form method='POST' action='php/unarchive_venue.php' onsubmit=\"return confirm('Unarchive this venue?');\">
                            <input type='hidden' name='venue_id' value='" . $venue['venue_id'] . "'>
                            <input type='submit' value='Unarchive'>
                        </form>
                    </td>
                </tr>";
            }
            ?>
        </table>
    </div>
</div>

<h1>Cinema Management</h1>
<div class="section-row">
    <!-- Add New Cinema -->
    <div class="section-column">
        <h2>Add New Cinema</h2>
        <form class="form-q" action="php/add_cinema.php" method="POST">
            <label>Cinema Name:</label>
            <input type="text" name="cinema_name" required>
            <label>Venue:</label>
            <select name="venue_id" required>
                <option value="">Select Venue</option>
                <?php
                $venues = $conn->query("SELECT venue_id, venue_name FROM venues");
                while ($v = $venues->fetch_assoc()) {
                    echo "<option value='{$v['venue_id']}'>" . htmlspecialchars($v['venue_name']) . "</option>";
                }
                ?>
            </select>
            <label>Seat Rows:</label>
            <input type="number" name="seat_rows" min="1" required>
            <label>Seat Columns:</label>
            <input type="number" name="seat_columns" min="1" required>
            <button type="submit" name="add_cinema">Add Cinema</button>
        </form>
    </div>

    <!-- Active Cinemas -->
    <div class="section-column">
        <h2>Active Cinemas</h2>
        <table>
            <tr><th>Cinema Name</th><th>Venue</th><th>Rows</th><th>Columns</th><th>Added by</th><th>Actions</th></tr>
            <?php
            $res = $conn->query("SELECT c.cinema_id, c.name AS cinema_name, v.venue_name, c.seat_rows, c.seat_columns, c.seat_capacity, 
                                 CONCAT(u.f_name, ' ', u.s_name) AS user_name
                                 FROM cinemas c
                                 JOIN venues v ON c.venue_id = v.venue_id
                                 JOIN users u ON c.user_id = u.user_id
                                 WHERE c.archived = 0");
            while ($cinema = $res->fetch_assoc()) {
                echo "<tr>
                    <td>" . htmlspecialchars($cinema['cinema_name']) . "</td>
                    <td>" . htmlspecialchars($cinema['venue_name']) . "</td>
                    <td>{$cinema['seat_rows']}</td>
                    <td>{$cinema['seat_columns']}</td>
                    <td>" . htmlspecialchars($cinema['user_name']) . "</td>
                    <td>
                        <form method='POST' action='php/archive_cinema.php' onsubmit=\"return confirm('Archive this cinema?');\">
                            <input type='hidden' name='cinema_id' value='" . $cinema['cinema_id'] . "'>
                            <input type='submit' value='Archive'>
                        </form>
                    </td>
                </tr>";
            }
            ?>
        </table>
    </div>

    <!-- Archived Cinemas -->
    <div class="section-column">
        <h2>Archived Cinemas</h2>
        <table>
            <tr><th>Cinema Name</th><th>Venue</th><th>Rows</th><th>Columns</th><th>Added by</th><th>Actions</th></tr>
            <?php
            $res = $conn->query("SELECT c.cinema_id, c.name AS cinema_name, v.venue_name, c.seat_rows, c.seat_columns, c.seat_capacity, 
                                 CONCAT(u.f_name, ' ', u.s_name) AS user_name
                                 FROM cinemas c
                                 JOIN venues v ON c.venue_id = v.venue_id
                                 JOIN users u ON c.user_id = u.user_id
                                 WHERE c.archived = 1");
            while ($cinema = $res->fetch_assoc()) {
                echo "<tr>
                    <td>" . htmlspecialchars($cinema['cinema_name']) . "</td>
                    <td>" . htmlspecialchars($cinema['venue_name']) . "</td>
                    <td>{$cinema['seat_rows']}</td>
                    <td>{$cinema['seat_columns']}</td>
                    <td>" . htmlspecialchars($cinema['user_name']) . "</td>
                    <td>
                        <form method='POST' action='php/unarchive_cinema.php' onsubmit=\"return confirm('Unarchive this cinema?');\">
                            <input type='hidden' name='cinema_id' value='" . $cinema['cinema_id'] . "'>
                            <input type='submit' value='Unarchive'>
                        </form>
                    </td>
                </tr>";
            }
            ?>
        </table>
    </div>
</div>
</body>
</html>