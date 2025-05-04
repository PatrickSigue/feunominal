<?php
session_start();
$host = 'localhost';
$db = 'tix';
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    $_SESSION['error'] = 'Connection failed: ' . $conn->connect_error;
    header('Location: ../manage_showings.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $movie_id = isset($_POST['movie_id']) ? intval($_POST['movie_id']) : 0;
    $venue_id = isset($_POST['venue_id']) ? intval($_POST['venue_id']) : 0;
    $show_dates = isset($_POST['show_dates']) ? $_POST['show_dates'] : [];
    $show_times = isset($_POST['show_times']) ? $_POST['show_times'] : [];
    $price = isset($_POST['price']) ? floatval($_POST['price']) : 0;
    $user_id = isset($_SESSION['user_id']) ? intval($_SESSION['user_id']) : 0;

    // Validate user is logged in
    if ($user_id <= 0) {
        $_SESSION['error'] = 'You must be logged in to add a showing.';
        header('Location: ../manage_showings.php');
        exit();
    }

    // Basic input validation
    if ($movie_id <= 0 || $venue_id <= 0 || empty($show_dates) || empty($show_times) || $price <= 0) {
        $_SESSION['error'] = 'All fields are required, including at least one show date, one show time, and a valid price.';
        header('Location: ../manage_showings.php');
        exit();
    }

    // Begin transaction
    $conn->begin_transaction();

    try {
        // Get cinema_id from cinemas table
        $sql_cinema = "SELECT cinema_id FROM cinemas WHERE cinema_id = ? AND archived = 0";
        $stmt_cinema = $conn->prepare($sql_cinema);
        $stmt_cinema->bind_param("i", $venue_id);
        $stmt_cinema->execute();
        $result_cinema = $stmt_cinema->get_result();

        if ($result_cinema->num_rows === 0) {
            throw new Exception('Invalid or archived cinema.');
        }

        $cinema = $result_cinema->fetch_assoc();
        $cinema_id = $cinema['cinema_id'];
        $stmt_cinema->close();

        // Check if the movie is archived
        $sql_movie = "SELECT movie_id FROM movies WHERE movie_id = ? AND archived = 0";
        $stmt_movie = $conn->prepare($sql_movie);
        $stmt_movie->bind_param("i", $movie_id);
        $stmt_movie->execute();
        $result_movie = $stmt_movie->get_result();

        if ($result_movie->num_rows === 0) {
            throw new Exception('Selected movie is archived or invalid.');
        }
        $stmt_movie->close();

        // Check for conflicts between new date/time combinations (internal conflict check)
        $combined_times = [];
        
        foreach ($show_dates as $show_date) {
            if (empty($show_date) || $show_date < date('Y-m-d')) continue;
        
            $combined_times[$show_date] = [];
            foreach ($show_times as $show_time) {
                if (empty($show_time)) continue;
                $combined_times[$show_date][] = strtotime($show_time);
            }
        }
        
        // Validate 2-hour gaps between times on the same date
        foreach ($combined_times as $date => $times) {
            sort($times);
            for ($i = 0; $i < count($times) - 1; $i++) {
                if (abs($times[$i + 1] - $times[$i]) < 7200) { // 7200 = 2 hours in seconds
                    $_SESSION['error'] = "Show times on $date must be at least 2 hours apart from       each other.";
                    header('Location: ../manage_showings.php');
                    exit();
                }
            }
        }
        
        // Process each show date and show time combination
        $errors = [];
        $successful_showings = 0;

        foreach ($show_dates as $show_date) {
            // Skip empty dates
            if (empty($show_date)) {
                continue;
            }

            // Validate show date (must be today or future)
            $today = date('Y-m-d');
            if ($show_date < $today) {
                $errors[] = "Show date $show_date must be today or in the future.";
                continue;
            }

            foreach ($show_times as $show_time) {
                // Skip empty times
                if (empty($show_time)) {
                    continue;
                }

                // Validate show time (between 11:00 AM and 9:00 PM)
                $time_obj = DateTime::createFromFormat('H:i', $show_time);
                if (!$time_obj) {
                    $errors[] = "Invalid time format for $show_time on $show_date.";
                    continue;
                }

                $hour = (int)$time_obj->format('H');
                if ($hour < 11 || $hour > 21) {
                    $errors[] = "Show time $show_time on $show_date must be between 11:00 AM and 9:00 PM.";
                    continue;
                }

                // Check for unique venue, cinema, date, and time combination
                $sql_unique = "SELECT showing_id FROM showings 
                               WHERE cinema_id = ? AND show_date = ? AND show_time = ? AND archived = 0";
                $stmt_unique = $conn->prepare($sql_unique);
                $stmt_unique->bind_param("iss", $cinema_id, $show_date, $show_time);
                $stmt_unique->execute();
                $result_unique = $stmt_unique->get_result();

                if ($result_unique->num_rows > 0) {
                    $errors[] = "A showing already exists for $show_date at $show_time.";
                    $stmt_unique->close();
                    continue;
                }
                $stmt_unique->close();

                // Check for 2-hour clearance from other showtimes
                $sql_clearance = "SELECT show_time FROM showings 
                                  WHERE cinema_id = ? AND show_date = ? AND archived = 0";
                $stmt_clearance = $conn->prepare($sql_clearance);
                $stmt_clearance->bind_param("is", $cinema_id, $show_date);
                $stmt_clearance->execute();
                $result_clearance = $stmt_clearance->get_result();

                $new_time = strtotime($show_time);
                $two_hours = 2 * 3600; // 2 hours in seconds

                $has_clearance_issue = false;
                while ($row = $result_clearance->fetch_assoc()) {
                    $existing_time = strtotime($row['show_time']);
                    $time_diff = abs($new_time - $existing_time);

                    if ($time_diff < $two_hours) {
                        $errors[] = "Show time $show_time on $show_date must be at least 2 hours apart from other showtimes.";
                        $has_clearance_issue = true;
                        break;
                    }
                }
                $stmt_clearance->close();

                if ($has_clearance_issue) {
                    continue;
                }

                // Insert new showing
                $sql_insert = "INSERT INTO showings (movie_id, cinema_id, show_date, show_time, user_id, price, archived) 
                               VALUES (?, ?, ?, ?, ?, ?, 0)";
                $stmt_insert = $conn->prepare($sql_insert);
                $stmt_insert->bind_param("iissid", $movie_id, $cinema_id, $show_date, $show_time, $user_id, $price);
                
                if ($stmt_insert->execute()) {
                    $successful_showings++;
                } else {
                    $errors[] = "Failed to add showing for $show_date at $show_time.";
                }
                $stmt_insert->close();
            }
        }

        // Check if any showings were added
        if ($successful_showings === 0 && !empty($errors)) {
            throw new Exception(implode(' ', $errors));
        } elseif (!empty($errors)) {
            $_SESSION['warning'] = "Some showings could not be added: " . implode(' ', $errors);
        }

        // Commit transaction
        $conn->commit();
        $_SESSION['success'] = "$successful_showings showing(s) added successfully.";
        header('Location: ../manage_showings.php');
        exit();
        
    } catch (Exception $e) {
        // Rollback on error
        $conn->rollback();
        $_SESSION['error'] = $e->getMessage();
        header('Location: ../manage_showings.php');
        exit();
    }
} else {
    $_SESSION['error'] = 'Invalid request method.';
    header('Location: ../manage_showings.php');
    exit();
}

$conn->close();
?>