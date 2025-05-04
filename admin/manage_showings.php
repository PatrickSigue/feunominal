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

// Query to get all showings for dropdowns and tables
$showings_sql = "SELECT s.showing_id, s.archived, m.movie_title, v.venue_name, c.name AS cinema_name, s.show_date, s.show_time 
                 FROM showings s 
                 JOIN movies m ON s.movie_id = m.movie_id 
                 JOIN cinemas c ON s.cinema_id = c.cinema_id 
                 JOIN venues v ON c.venue_id = v.venue_id 
                 WHERE s.show_date >= CURDATE() AND m.archived = 0 
                 ORDER BY s.show_date ASC";
$showings_result = $conn->query($showings_sql);

// Query to get all available movies for adding a new showing
$movies_sql = "SELECT movie_id, movie_title FROM movies WHERE archived = 0 ORDER BY movie_title";
$movies_result = $conn->query($movies_sql);

// Query to get all venues and cinemas for the new showing
$venues_sql = "SELECT v.venue_id, v.venue_name, c.cinema_id, c.name AS cinema_name 
               FROM venues v 
               JOIN cinemas c ON v.venue_id = c.venue_id 
               WHERE c.archived = 0 ORDER BY v.venue_name, c.name";
$venues_result = $conn->query($venues_sql);

if (isset($_SESSION['error'])) {
    $message = addslashes($_SESSION['error']);
    echo "<script>alert('$message');</script>";
    unset($_SESSION['error']);
}

// Prepare data for JavaScript
$venues = [];
if ($showings_result->num_rows > 0) {
    while ($showing = $showings_result->fetch_assoc()) {
        $venue_name = $showing['venue_name'];
        $cinema_name = $showing['cinema_name'];
        $movie_title = $showing['movie_title'];
        $show_date = date('F j, Y', strtotime($showing['show_date']));
        $show_time = date('h:i A', strtotime($showing['show_time']));
        
        $venues[$venue_name][$cinema_name][$movie_title][$show_date][] = [
            'showing_id' => $showing['showing_id'],
            'time' => $show_time,
            'archived' => $showing['archived']
        ];
    }
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <title>Manage Showings</title>
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
            max-width: 580px;
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

        .form-container select,
        .form-container input[type="date"],
        .form-container input[type="time"],
        .form-container input[type="number"] {
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
        #remove-date-btn, #remove-time-btn {
        background-color: #dc3545;
        }
        #remove-date-btn:hover, #remove-time-btn:hover {
            background-color: #c82333;
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

<h1>Manage Showings</h1>

<div class="section-row">
    <div class="section-column">
        <div class="card">
            <h2>Upcoming Showings</h2>
            <form method="POST" action="manage_showings.php">
                <label for="venue">Select Venue:</label>
                <select name="venue" id="venue" onchange="updateCinemaOptions()" required>
                    <option value="">Select Venue</option>
                    <?php foreach ($venues as $venue_name => $cinemas): ?>
                        <option value="<?php echo htmlspecialchars($venue_name); ?>"><?php echo htmlspecialchars($venue_name); ?></option>
                    <?php endforeach; ?>
                </select>

                <label for="cinema">Select Cinema:</label>
                <select name="cinema" id="cinema" onchange="updateMovieOptions()" required>
                    <option value="">Select Cinema</option>
                </select>

                <label for="movie">Select Movie:</label>
                <select name="movie" id="movie" onchange="updateDateOptions()" required>
                    <option value="">Select Movie</option>
                </select>

                <label for="date">Select Date:</label>
                <select name="date" id="date" onchange="updateTimeTables()" required>
                    <option value="">Select Date</option>
                </select>
            </form>

            <div id="showtimes">
                <h3>Active Showtimes</h3>
                <div class="table-container">
                    <table id="active-table">
                        <thead>
                            <tr>
                                <th>Showtime</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="2">Select options above to view showtimes</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <h3>Archived Showtimes</h3>
                <div class="table-container">
                    <table id="archived-table">
                        <thead>
                            <tr>
                                <th>Showtime</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="2">Select options above to view showtimes</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="section-column">
        <div class="card">
            <h2>Add New Showing</h2>
            <form action="php/add_showing.php" method="POST" class="form-container">
                <label for="movie_id">Select Movie:</label>
                <select name="movie_id" id="movie_id" required>
                    <option value="">Select Movie</option>
                    <?php while ($movie = $movies_result->fetch_assoc()) { ?>
                        <option value="<?= $movie['movie_id'] ?>"><?= htmlspecialchars($movie['movie_title']) ?></option>
                    <?php } ?>
                </select>
            
                <label for="venue_id">Select Venue & Cinema:</label>
                <select name="venue_id" id="venue_id" required>
                    <option value="">Select Venue</option>
                    <?php while ($venue = $venues_result->fetch_assoc()) { ?>
                        <option value="<?= $venue['cinema_id'] ?>"><?= htmlspecialchars($venue['venue_name']) ?> - <?= htmlspecialchars($venue['cinema_name']) ?></option>
                    <?php } ?>
                </select>
            
                <div class="date-section">
                    <div class="date-controls">
                        <label for="date-container">Show Dates:</label>
                        <button type="button" onclick="addDateField()">Add Another Date</button>
                        <button type="button" onclick="removeDateField()" id="remove-date-btn" style="display: none;">Remove Date</button>
                    </div>
                    <div id="date-container">
                        <input type="date" name="show_dates[]" required>
                    </div>
                </div>
            
                <div class="time-section">
                    <div class="time-controls">
                        <label for="show_time">Show Time:</label>
                        <button type="button" onclick="addTimeField()">Add Another Time</button>
                        <button type="button" onclick="removeTimeField()" id="remove-time-btn" style="display: none;">Remove Time</button>
                    </div>
                    <div id="time-container">
                        <input type="time" name="show_times[]" required>
                    </div>
                    
                </div>
            
                <label for="price">Price:</label>
                <input type="number" name="price" min="1" required>
            
                <button type="submit">Add Showing</button>
            </form>
        </div>
    </div>
</div>

<script src="../script/nav.js"></script>
<script>
    const venuesData = <?php echo json_encode($venues); ?>;

    function updateCinemaOptions() {
        const venueSelect = document.getElementById('venue');
        const cinemaSelect = document.getElementById('cinema');
        const movieSelect = document.getElementById('movie');
        const dateSelect = document.getElementById('date');
        const showtimesDiv = document.getElementById('showtimes');

        cinemaSelect.innerHTML = "<option value=''>Select Cinema</option>";
        movieSelect.innerHTML = "<option value=''>Select Movie</option>";
        dateSelect.innerHTML = "<option value=''>Select Date</option>";
        showtimesDiv.innerHTML = `
            <h3>Active Showtimes</h3>
            <div class="table-container">
                <table id="active-table">
                    <thead>
                        <tr>
                            <th>Showtime</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="2">Select options above to view showtimes</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <h3>Archived Showtimes</h3>
            <div class="table-container">
                <table id="archived-table">
                    <thead>
                        <tr>
                            <th>Showtime</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="2">Select options above to view showtimes</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        `;

        if (venueSelect.value) {
            const cinemas = venuesData[venueSelect.value];
            for (const cinema in cinemas) {
                const option = document.createElement('option');
                option.value = cinema;
                option.textContent = cinema;
                cinemaSelect.appendChild(option);
            }
        }
    }

    function updateMovieOptions() {
        const venueSelect = document.getElementById('venue');
        const cinemaSelect = document.getElementById('cinema');
        const movieSelect = document.getElementById('movie');
        const dateSelect = document.getElementById('date');
        const showtimesDiv = document.getElementById('showtimes');

        movieSelect.innerHTML = "<option value=''>Select Movie</option>";
        dateSelect.innerHTML = "<option value=''>Select Date</option>";
        showtimesDiv.innerHTML = `
            <h3>Active Showtimes</h3>
            <div class="table-container">
                <table id="active-table">
                    <thead>
                        <tr>
                            <th>Showtime</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="2">Select options above to view showtimes</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <h3>Archived Showtimes</h3>
            <div class="table-container">
                <table id="archived-table">
                    <thead>
                        <tr>
                            <th>Showtime</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="2">Select options above to view showtimes</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        `;

        if (cinemaSelect.value) {
            const movies = venuesData[venueSelect.value][cinemaSelect.value];
            for (const movie in movies) {
                const option = document.createElement('option');
                option.value = movie;
                option.textContent = movie;
                movieSelect.appendChild(option);
            }
        }
    }

    function updateDateOptions() {
        const venueSelect = document.getElementById('venue');
        const cinemaSelect = document.getElementById('cinema');
        const movieSelect = document.getElementById('movie');
        const dateSelect = document.getElementById('date');
        const showtimesDiv = document.getElementById('showtimes');

        dateSelect.innerHTML = "<option value=''>Select Date</option>";
        showtimesDiv.innerHTML = `
            <h3>Active Showtimes</h3>
            <div class="table-container">
                <table id="active-table">
                    <thead>
                        <tr>
                            <th>Showtime</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="2">Select options above to view showtimes</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <h3>Archived Showtimes</h3>
            <div class="table-container">
                <table id="archived-table">
                    <thead>
                        <tr>
                            <th>Showtime</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="2">Select options above to view showtimes</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        `;

        if (movieSelect.value) {
            const dates = venuesData[venueSelect.value][cinemaSelect.value][movieSelect.value];
            for (const date in dates) {
                const option = document.createElement('option');
                option.value = date;
                option.textContent = date;
                dateSelect.appendChild(option);
            }
        }
    }

    function updateTimeTables() {
        const venueSelect = document.getElementById('venue');
        const cinemaSelect = document.getElementById('cinema');
        const movieSelect = document.getElementById('movie');
        const dateSelect = document.getElementById('date');
        const activeTableBody = document.querySelector('#active-table tbody');
        const archivedTableBody = document.querySelector('#archived-table tbody');

        activeTableBody.innerHTML = '';
        archivedTableBody.innerHTML = '';

        if (dateSelect.value) {
            const showtimes = venuesData[venueSelect.value][cinemaSelect.value][movieSelect.value][dateSelect.value];
            if (showtimes && showtimes.length > 0) {
                showtimes.forEach(showtime => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${showtime.time}</td>
                        <td>
                            <button class="${parseInt(showtime.archived) === 1 ? 'unarchive-btn' : 'archive-btn'}" 
                                onclick="${parseInt(showtime.archived) === 1 ? 'unarchiveShowing' : 'archiveShowing'}(${showtime.showing_id})">
                                    ${parseInt(showtime.archived) === 1 ? 'Unarchive' : 'Archive'}
                            </button>
                        </td>
                    `;
                    if (parseInt(showtime.archived) === 1) {
                        archivedTableBody.appendChild(row);
                    } 
                    else {
                        activeTableBody.appendChild(row);
                    }
                });

                if (activeTableBody.children.length === 0) {
                    activeTableBody.innerHTML = '<tr><td colspan="2">No active showtimes available for this date.</td></tr>';
                }
                if (archivedTableBody.children.length === 0) {
                    archivedTableBody.innerHTML = '<tr><td colspan="2">No archived showtimes available for this date.</td></tr>';
                }
            } else {
                activeTableBody.innerHTML = '<tr><td colspan="2">No active showtimes available for this date.</td></tr>';
                archivedTableBody.innerHTML = '<tr><td colspan="2">No archived showtimes available for this date.</td></tr>';
            }
        } else {
            activeTableBody.innerHTML = '<tr><td colspan="2">Select options above to view showtimes</td></tr>';
            archivedTableBody.innerHTML = '<tr><td colspan="2">Select options above to view showtimes</td></tr>';
        }
    }

    function archiveShowing(showingId) {
        if (confirm('Are you sure you want to archive this showing?')) {
            fetch('php/archive_showing.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'showing_id=' + showingId + '&archive=1'
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Error archiving showing: ' + data.error);
                }
            })
            .catch(error => {
                alert('Error: ' + error);
            });
        }
    }

    function unarchiveShowing(showingId) {
        if (confirm('Are you sure you want to unarchive this showing?')) {
            fetch('php/unarchive_showing.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'showing_id=' + showingId + '&archive=0'
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Error unarchiving showing: ' + data.error);
                }
            })
            .catch(error => {
                alert('Error: ' + error);
            });
        }
    }
</script>
<script>
    function addDateField() {
        const container = document.getElementById('date-container');
        const newInput = document.createElement('input');
        newInput.type = 'date';
        newInput.name = 'show_dates[]';
        newInput.required = true;
        container.appendChild(newInput);
        updateRemoveButtonVisibility('date');
    }

    function removeDateField() {
        const container = document.getElementById('date-container');
        if (container.children.length > 1) {
            container.removeChild(container.lastChild);
        }
        updateRemoveButtonVisibility('date');
    }

    function addTimeField() {
        const container = document.getElementById('time-container');
        const newInput = document.createElement('input');
        newInput.type = 'time';
        newInput.name = 'show_times[]';
        newInput.required = true;
        container.appendChild(newInput);
        updateRemoveButtonVisibility('time');
    }

    function removeTimeField() {
        const container = document.getElementById('time-container');
        if (container.children.length > 1) {
            container.removeChild(container.lastChild);
        }
        updateRemoveButtonVisibility('time');
    }

    function updateRemoveButtonVisibility(type) {
        const container = document.getElementById(type + '-container');
        const removeButton = document.getElementById('remove-' + type + '-btn');
        removeButton.style.display = container.children.length > 1 ? 'inline-block' : 'none';
    }
</script>
</body>
</html>