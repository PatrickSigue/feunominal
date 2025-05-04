<?php
session_start();
$host = 'localhost';
$db = 'tix';
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die(json_encode(['success' => false, 'error' => 'Connection failed: ' . $conn->connect_error]));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $showing_id = isset($_POST['showing_id']) ? intval($_POST['showing_id']) : 0;

    if ($showing_id > 0) {
        // Begin transaction
        $conn->begin_transaction();

        try {
            // Archive the showing
            $sql_showing = "UPDATE showings SET archived = 1 WHERE showing_id = ?";
            $stmt_showing = $conn->prepare($sql_showing);
            $stmt_showing->bind_param("i", $showing_id);
            $stmt_showing->execute();
            $stmt_showing->close();

            // Archive associated movie tickets
            $sql_tickets = "UPDATE movie_tickets SET archived = 1 WHERE showing_id = ?";
            $stmt_tickets = $conn->prepare($sql_tickets);
            $stmt_tickets->bind_param("i", $showing_id);
            $stmt_tickets->execute();
            $stmt_tickets->close();

            // Commit transaction
            $conn->commit();
            echo json_encode(['success' => true]);
        } catch (Exception $e) {
            // Rollback on error
            $conn->rollback();
            echo json_encode(['success' => false, 'error' => 'Failed to archive: ' . $e->getMessage()]);
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'Invalid showing ID']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request method']);
}

$conn->close();
?>