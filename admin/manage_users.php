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

// Update user type logic
if (isset($_POST['change_user_type'])) {
    $user_id = intval($_POST['user_id']);
    $new_type = $_POST['user_type'];
    $valid_types = ['admin', 'customer', 'organizer'];
    if (in_array($new_type, $valid_types)) {
        $stmt = $conn->prepare("UPDATE users SET user_type = ? WHERE user_id = ?");
        $stmt->bind_param("si", $new_type, $user_id);
        $stmt->execute();
        $stmt->close();
    }
    header("Location: manage_users.php");
    exit();
}

// Archive user logic
if (isset($_POST['archive_user'])) {
    $user_id = intval($_POST['user_id']);
    $stmt = $conn->prepare("UPDATE users SET archived = 1 WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->close();
    header("Location: manage_users.php");
    exit();
}

// Unarchive user logic
if (isset($_POST['unarchive_user'])) {
    $user_id = intval($_POST['user_id']);
    $stmt = $conn->prepare("UPDATE users SET archived = 0 WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->close();
    header("Location: manage_users.php");
    exit();
}

// Query to get all users for dropdown
$users_sql = "SELECT user_id, email, f_name, s_name, user_type, created_at, archived FROM users WHERE archived = 0 ORDER BY email ASC";
$users_result = $conn->query($users_sql);

// Query to get archived users
$archived_users_sql = "SELECT user_id, email, f_name, s_name, user_type, created_at FROM users WHERE archived = 1 ORDER BY email ASC";
$archived_result = $conn->query($archived_users_sql);
$archived_users = [];
if ($archived_result->num_rows > 0) {
    while ($user = $archived_result->fetch_assoc()) {
        $archived_users[] = $user;
    }
}

// Prepare data for JavaScript
$users = [];
if ($users_result->num_rows > 0) {
    while ($user = $users_result->fetch_assoc()) {
        $email = $user['email'];
        $users[$email] = [
            'user_id' => $user['user_id'],
            'f_name' => $user['f_name'],
            's_name' => $user['s_name'],
            'user_type' => $user['user_type'],
            'created_at' => $user['created_at'],
            'archived' => $user['archived'],
            'tickets' => []
        ];

        // Fetch tickets for this user
        $ticket_sql = "
            SELECT 
                mt.movie_tix_id,
                m.movie_title,
                s.seat_row,
                s.seat_number,
                c.name AS cinema_name,
                v.venue_name,
                mt.senior,
                mt.booking_time
            FROM movie_tickets mt
            JOIN showings sh ON mt.showing_id = sh.showing_id
            JOIN movies m ON sh.movie_id = m.movie_id
            JOIN seats s ON mt.seat_id = s.seats_id
            JOIN cinemas c ON s.cinema_id = c.cinema_id
            JOIN venues v ON c.venue_id = v.venue_id
            WHERE mt.user_id = ?
            ORDER BY mt.booking_time DESC
        ";
        $stmt = $conn->prepare($ticket_sql);
        $stmt->bind_param("i", $user['user_id']);
        $stmt->execute();
        $tickets = $stmt->get_result();
        while ($ticket = $tickets->fetch_assoc()) {
            $users[$email]['tickets'][] = $ticket;
        }
        $stmt->close();
    }
}

if (isset($_SESSION['error'])) {
    $message = addslashes($_SESSION['error']);
    echo "<script>alert('$message');</script>";
    unset($_SESSION['error']);
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <title>Manage Users</title>
    <link rel="stylesheet" href="../css/nav.css">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <link rel="icon" type="image/x-icon" href="assets/tam.svg">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            color: #333;
            padding: 20px;
            margin: 0;
            margin-top: 70px;
            display: flex;
            flex-direction: column;
            align-items: center;
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

        .section-row {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            width: 100%;
            max-width: 1800px;
            margin-bottom: 30px;
            justify-content: center;
        }

        .section-column {
            flex: 1;
            min-width: 300px;
            max-width: 45%;
            background-color: #fafafa;
            border-radius: 8px;
            padding: 15px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .card {
            padding: 15px;
            width: 100%;
            text-align: center;
        }

        .card select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .table-container {
            width: 100%;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #1e3504;
            color: white;
        }

        tr:hover {
            background-color: #f5f5f5;
        }

        .archive-btn, .unarchive-btn {
            padding: 8px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
        }

        .archive-btn {
            background-color: #dc3545;
            color: white;
        }

        .archive-btn:hover {
            background-color: #c82333;
        }

        .unarchive-btn {
            background-color: #28a745;
            color: white;
        }

        .unarchive-btn:hover {
            background-color: #218838;
        }

        .form-container {
            width: 100%;
            max-width: 580px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fafafa;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .form-container label {
            font-weight: bold;
        }

        .form-container select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .form-container button {
            padding: 10px 20px;
            background-color: #1e3504;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .form-container button:hover {
            background-color: #34491d;
        }

        .form-container h2 {
            text-align: center;
            margin-bottom: 20px;
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
            <li><a href="manage_seats.php">Seat Plans</a></li>
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

<h1>Manage Users</h1>

<div class="section-row">
    <div class="section-column">
        <div class="card">
            <h2>User List</h2>
            <form method="POST" action="manage_users.php">
                <label for="email">Select User by Email:</label>
                <select name="email" id="email" onchange="updateUserDetails()" required>
                    <option value="">Select User</option>
                    <?php foreach ($users as $email => $user): ?>
                        <option value="<?php echo htmlspecialchars($email); ?>"><?php echo htmlspecialchars($email); ?></option>
                    <?php endforeach; ?>
                </select>
            </form>

            <div id="user-details">
                <h3>User Information</h3>
                <div class="table-container">
                    <table id="user-info-table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>User Type</th>
                                <th>Created At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="4">Select a user to view details</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <h3>Tickets</h3>
                <div class="table-container">
                    <table id="tickets-table">
                        <thead>
                            <tr>
                                <th>Movie</th>
                                <th>Seat</th>
                                <th>Cinema</th>
                                <th>Venue</th>
                                <th>Senior</th>
                                <th>Booked At</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="6">Select a user to view tickets</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="section-column">
        <div class="card">
            <h3>Archived Users</h3>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Email</th>
                            <th>Name</th>
                            <th>User Type</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($archived_users)): ?>
                            <tr><td colspan="5">No archived users found.</td></tr>
                        <?php else: ?>
                            <?php foreach ($archived_users as $archived): ?>
                                <tr>
                                    <td><?= htmlspecialchars($archived['email']) ?></td>
                                    <td><?= htmlspecialchars($archived['f_name'] . ' ' . $archived['s_name']) ?></td>
                                    <td><?= htmlspecialchars($archived['user_type']) ?></td>
                                    <td><?= htmlspecialchars($archived['created_at']) ?></td>
                                    <td>
                                        <form method="POST" action="manage_users.php" onsubmit="return confirm('Unarchive this user?');">
                                            <input type="hidden" name="user_id" value="<?= $archived['user_id'] ?>">
                                            <button type="submit" name="unarchive_user" class="unarchive-btn">Unarchive</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="../script/nav.js"></script>
<script>
    const usersData = <?php echo json_encode($users); ?>;

    function updateUserDetails() {
        const emailSelect = document.getElementById('email');
        const userInfoTableBody = document.querySelector('#user-info-table tbody');
        const ticketsTableBody = document.querySelector('#tickets-table tbody');

        userInfoTableBody.innerHTML = '';
        ticketsTableBody.innerHTML = '';

        if (emailSelect.value) {
            const user = usersData[emailSelect.value];
            if (user) {
                // Update user info table
                const userRow = document.createElement('tr');
                userRow.innerHTML = `
                    <td>${user.f_name} ${user.s_name}</td>
                    <td>
                        <form method="POST" action="">
                            <input type="hidden" name="user_id" value="${user.user_id}">
                            <select name="user_type" onchange="this.form.submit()">
                                <option value="customer" ${user.user_type === 'customer' ? 'selected' : ''}>Customer</option>
                                <option value="admin" ${user.user_type === 'admin' ? 'selected' : ''}>Admin</option>
                                <option value="organizer" ${user.user_type === 'organizer' ? 'selected' : ''}>Organizer</option>
                            </select>
                            <input type="hidden" name="change_user_type" value="1">
                        </form>
                    </td>
                    <td>${user.created_at}</td>
                    <td>
                        <form method="POST" action="">
                            <input type="hidden" name="user_id" value="${user.user_id}">
                            <button type="submit" name="archive_user" class="archive-btn">Archive</button>
                        </form>
                    </td>
                `;
                userInfoTableBody.appendChild(userRow);

                // Update tickets table
                if (user.tickets.length > 0) {
                    user.tickets.forEach(ticket => {
                        const ticketRow = document.createElement('tr');
                        ticketRow.innerHTML = `
                            <td>${ticket.movie_title}</td>
                            <td>${ticket.seat_row}${ticket.seat_number}</td>
                            <td>${ticket.cinema_name}</td>
                            <td>${ticket.venue_name}</td>
                            <td>${ticket.senior ? 'Yes' : 'No'}</td>
                            <td>${ticket.booking_time}</td>
                        `;
                        ticketsTableBody.appendChild(ticketRow);
                    });
                } else {
                    ticketsTableBody.innerHTML = '<tr><td colspan="6">No tickets available for this user.</td></tr>';
                }
            } else {
                userInfoTableBody.innerHTML = '<tr><td colspan="4">Select a user to view details</td></tr>';
                ticketsTableBody.innerHTML = '<tr><td colspan="6">Select a user to view tickets</td></tr>';
            }
        } else {
            userInfoTableBody.innerHTML = '<tr><td colspan="4">Select a user to view details</td></tr>';
            ticketsTableBody.innerHTML = '<tr><td colspan="6">Select a user to view tickets</td></tr>';
        }
    }
</script>
</body>
</html>