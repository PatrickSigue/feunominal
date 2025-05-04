<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'tix');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Movies</title>
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
            margin-bottom: 30px;
            justify-content: center;
        }

        /* Section column for individual sections */
        .section-column {
            flex: 1;
            min-width: 300px; /* Prevent squishing */
            max-width: 50%; /* Match genres.css */
            background-color: #fafafa;
            border-radius: 8px;
            padding: 15px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        /* Form styling */
        .form-q {
            background: #fff;
            padding: 25px;
            border-radius: 12px;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            gap: 15px;
            align-items: center;
            margin: 20px auto;
        }

        .form-q label {
            font-weight: 600;
            color: #444;
            margin-bottom: 5px;
        }

        .form-q input, .form-q textarea {
            font-size: 1rem;
            padding: 10px 12px;
            border: 1px solid #ccc;
            border-radius: 6px;
            background: #f9f9f9;
            transition: border-color 0.2s ease;
            width: 100%;
        }

        .form-q input:focus, .form-q textarea:focus {
            border-color: #EFBF04;
            outline: none;
        }

        .form-q button {
            align-self: center;
            background-color: #1e3504;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 6px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.2s ease;
        }

        .form-q button:hover {
            background-color: #34491d;
        }

        /* Table styling */
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 10px;
            border: 1px solid #EFBF04;
            text-align: left;
        }

        th {
            background-color: #1e3504;
            color: #fff;
            font-weight: bold;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        td input[type="submit"] {
            background-color: #1e3504;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 4px;
            cursor: pointer;
        }

        td input[type="submit"]:hover {
            background-color: #34491d;
        }

        /* Ensure images in tables don't overflow */
        td img {
            max-width: 100px;
            height: auto;
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
            .form-q, table {
                max-width: 100%;
            }
            h1 {
                font-size: 1.8rem;
            }
            h2 {
                font-size: 1.3rem;
            }
            .form-q button {
                width: 100%;
                padding: 12px;
            }
            .form-q input, .form-q textarea {
                max-width: 100%;
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

<!-- Placeholder for Messages as Alerts -->
<?php
if (isset($_GET['error'])) {
    $message = '';
    switch ($_GET['error']) {
        case 'duplicate_movie':
            $message = 'Movie title already exists.';
            break;
        case 'insert_failed':
            $message = 'Failed to add movie. Please try again.';
            break;
        default:
            $message = 'An unknown error occurred.';
    }
    $message = addslashes($message);
    echo "<script>alert('$message');</script>";
}
if (isset($_GET['status'])) {
    $statusMsg = '';
    switch ($_GET['status']) {
        case 'movie_added':
            $statusMsg = 'Movie successfully added.';
            break;
        case 'archived':
            $statusMsg = 'Movie successfully archived.';
            break;
        case 'unarchived':
            $statusMsg = 'Movie successfully unarchived.';
            break;
    }
    $statusMsg = addslashes($statusMsg);
    echo "<script>alert('$statusMsg');</script>";
}
?>

<h1>Movie Management</h1>

<form class="form-q" action="php/add_movie.php" method="POST" enctype="multipart/form-data">
    <h2>Add New Movie</h2>
    <label for="movie_title">Movie Title:</label>
    <input type="text" id="movie_title" name="movie_title" required>
    <label for="description">Description:</label>
    <textarea id="description" name="description" rows="4" required></textarea>
    <label for="poster">Poster Image (URL):</label>
    <input type="url" id="poster" name="poster" required>
    <label for="banner">Banner Image (URL):</label>
    <input type="url" id="banner" name="banner" required>
    <button type="submit">Add Movie</button>
</form>

<div class="section-row">
    <!-- Left Column: Active Movies Table -->
    <div class="section-column">
        <h2>Active Movies</h2>
        <table>
            <tr>
                <th>Poster</th>
                <th>Title</th>
                <th>Description</th>
                <th>Added By</th>
                <th>Actions</th>
            </tr>
            <?php
            $result = $conn->query("SELECT movies.*, users.f_name, users.s_name FROM movies LEFT JOIN users ON movies.user_id = users.user_id WHERE movies.archived = 0 ORDER BY movie_title ASC");

            while ($movie = $result->fetch_assoc()) {
                echo "<tr>
                    <td><img src='" . htmlspecialchars($movie['poster']) . "' height='100'></td>
                    <td>" . htmlspecialchars($movie['movie_title']) . "</td>
                    <td>" . nl2br(htmlspecialchars($movie['description'])) . "</td>
                    <td>" . htmlspecialchars($movie['f_name']) . ' ' . htmlspecialchars($movie['s_name']) ."</td>
                    <td>
                        <form method='POST' action='php/archive_movie.php' onsubmit=\"return confirm('Archive this movie?');\">
                            <input type='hidden' name='movie_id' value='" . $movie['movie_id'] . "'>
                            <input type='submit' value='Archive'>
                        </form>
                    </td>
                </tr>";
            }
            ?>
        </table>
    </div>

    <!-- Right Column: Archived Movies Table -->
    <div class="section-column">
        <h2>Archived Movies</h2>
        <table>
            <tr>
                <th>Poster</th>
                <th>Title</th>
                <th>Description</th>
                <th>Added By</th>
                <th>Actions</th>
            </tr>
            <?php
            $result = $conn->query("SELECT movies.*, users.f_name, users.s_name FROM movies LEFT JOIN users ON movies.user_id = users.user_id WHERE movies.archived = 1 ORDER BY movie_title ASC");

            while ($movie = $result->fetch_assoc()) {
                echo "<tr>
                    <td><img src='" . htmlspecialchars($movie['poster']) . "' height='100'></td>
                    <td>" . htmlspecialchars($movie['movie_title']) . "</td>
                    <td>" . nl2br(htmlspecialchars($movie['description'])) . "</td>
                    <td>" . htmlspecialchars($movie['f_name']) . ' ' . htmlspecialchars($movie['s_name']) ."</td>
                    <td>
                        <form method='POST' action='php/unarchive_movie.php' onsubmit=\"return confirm('Unarchive this movie?');\">
                            <input type='hidden' name='movie_id' value='" . $movie['movie_id'] . "'>
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