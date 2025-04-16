<?php
session_start();
$conn = new mysqli("localhost", "root", "", "tix");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch form data
$cinema_id = intval($_POST['cinema_id']);
$user_id = intval($_POST['user_id']);
$showing_id = intval($_POST['showing_id']);
$seats = isset($_POST['seats']) ? explode(',', $_POST['seats']) : [];  // Convert the comma-separated string to an array
$price = isset($_POST['total_price']) ? floatval($_POST['total_price']) : 0;

if (empty($seats)) {
    die("No seats selected.");
}

// Begin transaction
$conn->begin_transaction();

try {
    foreach ($seats as $seat) {
        $seat_row = preg_replace('/[0-9]/', '', $seat);       // Extract row letter (e.g., "A" from "A1")
        $seat_number = preg_replace('/[^0-9]/', '', $seat);   // Extract seat number (e.g., "1" from "A1")

        // Check if the seat is already booked
        $checkStmt = $conn->prepare("SELECT COUNT(*) FROM seats WHERE cinema_id = ? AND showing_id = ? AND seat_row = ? AND seat_number = ?");
        $checkStmt->bind_param("iiis", $cinema_id, $showing_id, $seat_row, $seat_number);
        $checkStmt->execute();
        $checkStmt->bind_result($count);
        $checkStmt->fetch();
        $checkStmt->close();

        if ($count > 0) {
            // Seat is already booked, skip this seat
            continue;
        }

        // Insert into seats table
        $stmt = $conn->prepare("INSERT INTO seats (cinema_id, user_id, showing_id, seat_row, seat_number) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("iiisi", $cinema_id, $user_id, $showing_id, $seat_row, $seat_number);
        $stmt->execute();
        $stmt->close();

        // Get the last inserted seat_id
        $seat_id = $conn->insert_id;

        // Insert into movie_tickets table
        $ticket_stmt = $conn->prepare("INSERT INTO movie_tickets (showing_id, seat_id, user_id) VALUES (?, ?, ?)");
        $ticket_stmt->bind_param("iii", $showing_id, $seat_id, $user_id);
        $ticket_stmt->execute();
        $ticket_stmt->close();
    }

    // Commit the transaction
    $conn->commit();
    echo "Seats booked successfully!";
} catch (Exception $e) {
    // Rollback in case of error
    $conn->rollback();
    echo "Error: " . $e->getMessage();
} finally {
    // Close connection
    $conn->close();
}
?>
