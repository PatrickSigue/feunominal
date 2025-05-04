<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'tix');
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

$user_id = $_SESSION['user_id'] ?? 1;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $venue_name = trim($_POST['venue_name']);
    $address = trim($_POST['address']);

    if ($venue_name && $address) {
        // Check if venue name already exists
        $check = $conn->prepare("SELECT COUNT(*) FROM venues WHERE venue_name = ?");
        $check->bind_param("s", $venue_name);
        $check->execute();
        $check->bind_result($count);
        $check->fetch();
        $check->close();

        if ($count > 0) {
            // Redirect back with error
            header("Location: ../manage_venues.php?error=duplicate");
            exit();
        }

        // Insert if venue name is unique
        $stmt = $conn->prepare("INSERT INTO venues (venue_name, address, user_id) VALUES (?, ?, ?)");
        $stmt->bind_param("ssi", $venue_name, $address, $user_id);
        $stmt->execute();
        $stmt->close();
    }
}

header("Location: ../manage_venues.php?status=venue_added");
exit();
?>
