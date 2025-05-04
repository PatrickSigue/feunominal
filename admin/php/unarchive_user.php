<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['user_id'])) {
    $conn = new mysqli('localhost', 'root', '', 'tix');

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $user_id = intval($_POST['user_id']);
    $sql = "UPDATE users SET archived = 0 WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();

    $stmt->close();
    $conn->close();
}

header("Location: ../manage_users.php");
exit();
