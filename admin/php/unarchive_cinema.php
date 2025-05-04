<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'tix');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission for unarchiving a cinema
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['cinema_id'])) {
        $cinema_id = $_POST['cinema_id'];
        
        // Start transaction
        $conn->begin_transaction();

        try {
            // Unarchive the cinema
            $stmt1 = $conn->prepare("UPDATE cinemas SET archived = 0 WHERE cinema_id = ?");
            $stmt1->bind_param("i", $cinema_id);
            if (!$stmt1->execute()) {
                throw new Exception("Error unarchiving cinema.");
            }

            // Archive all showings related to the cinema
            $stmt2 = $conn->prepare("UPDATE showings SET archived = 1 WHERE cinema_id = ?");
            $stmt2->bind_param("i", $cinema_id);
            if (!$stmt2->execute()) {
                throw new Exception("Error archiving showings.");
            }

            // Archive all movie tickets related to the showings
            $stmt3 = $conn->prepare("UPDATE movie_tickets SET archived = 1 WHERE showing_id IN (SELECT showing_id FROM showings WHERE cinema_id = ?)");
            $stmt3->bind_param("i", $cinema_id);
            if (!$stmt3->execute()) {
                throw new Exception("Error archiving movie tickets.");
            }

            // Commit transaction
            $conn->commit();

            // Redirect to manage_cinemas.php with a success message
            header("Location: ../manage_venues.php?status=unarchived");
        } catch (Exception $e) {
            // Rollback transaction in case of error
            $conn->rollback();
            echo "Error: " . $e->getMessage();
        }
    }
}
?>
