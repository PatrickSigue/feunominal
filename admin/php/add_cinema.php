<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'tix');
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

$user_id = $_SESSION['user_id'] ?? 1;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cinema_name = trim($_POST['cinema_name']);
    $venue_id = intval($_POST['venue_id']);
    $seat_rows = intval($_POST['seat_rows']);
    $seat_columns = intval($_POST['seat_columns']);
    $seat_capacity = $seat_rows * $seat_columns;

    if ($cinema_name && $venue_id && $seat_rows && $seat_columns) {
    // Check if cinema name already exists in the same venue
    $check = $conn->prepare("SELECT COUNT(*) FROM cinemas WHERE name = ? AND venue_id = ?");
    $check->bind_param("si", $cinema_name, $venue_id); // Correct binding
    $check->execute();
    $check->bind_result($count);
    $check->fetch();
    $check->close();

    if ($count > 0) {
        // Redirect back with error
        header("Location: ../manage_venues.php?error=duplicate_cinema");
        exit();
    }

    // Insert cinema if name is unique within the same venue
    $stmt = $conn->prepare("INSERT INTO cinemas (name, venue_id, seat_rows, seat_columns, seat_capacity, user_id) 
                            VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("siiiii", $cinema_name, $venue_id, $seat_rows, $seat_columns, $seat_capacity, $user_id);
    $stmt->execute();
    $stmt->close();
}

}

header("Location: ../manage_venues.php?status=cinema_added");
exit();
?>
