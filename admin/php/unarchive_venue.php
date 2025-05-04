<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'tix');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission for unarchiving a venue
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['venue_id'])) {
        $venue_id = $_POST['venue_id'];
        
        // Start transaction
        $conn->begin_transaction();

        try {
            // Unarchive the venue
            $stmt1 = $conn->prepare("UPDATE venues SET archived = 0 WHERE venue_id = ?");
            $stmt1->bind_param("i", $venue_id);
            if (!$stmt1->execute()) {
                throw new Exception("Error unarchiving venue.");
            }

            // Unarchive all cinemas in the venue
            $stmt2 = $conn->prepare("UPDATE cinemas SET archived = 0 WHERE venue_id = ?");
            $stmt2->bind_param("i", $venue_id);
            if (!$stmt2->execute()) {
                throw new Exception("Error unarchiving cinemas.");
            }

            // Unarchive all showings for the cinemas in the venue
            $stmt3 = $conn->prepare("UPDATE showings SET archived = 0 WHERE cinema_id IN (SELECT cinema_id FROM cinemas WHERE venue_id = ?)");
            $stmt3->bind_param("i", $venue_id);
            if (!$stmt3->execute()) {
                throw new Exception("Error unarchiving showings.");
            }

            // Unarchive all tickets for the showings in the venue
            $stmt4 = $conn->prepare("UPDATE movie_tickets SET archived = 0 WHERE showing_id IN (SELECT showing_id FROM showings WHERE cinema_id IN (SELECT cinema_id FROM cinemas WHERE venue_id = ?))");
            $stmt4->bind_param("i", $venue_id);
            if (!$stmt4->execute()) {
                throw new Exception("Error unarchiving tickets.");
            }

            // Commit transaction
            $conn->commit();

            // Redirect to manage_venues.php with a success message
            header("Location: ../manage_venues.php?status=unarchived");
        } catch (Exception $e) {
            // Rollback transaction in case of error
            $conn->rollback();
            echo "Error: " . $e->getMessage();
        }
    }
}
?>
