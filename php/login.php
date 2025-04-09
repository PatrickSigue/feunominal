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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = ($_POST['email']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT user_id, email, password, f_name FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $db_email, $db_password, $fname);
        $stmt->fetch();

        if ($password == $db_password) {
            // Store session variables
            $_SESSION['user_id'] = $id;
            $_SESSION['email'] = $db_email;
            $_SESSION['f_name'] = $fname;

            header("Location: " . $_SERVER['HTTP_REFERER']);
                exit();

        } else {
            $_SESSION['error'] = "Incorrect password.";
            header("Location: " . $_SERVER['HTTP_REFERER']);
                exit();
        }
    } 

    else {
        $_SESSION['error'] = "No user found with that email.";
        header("Location: " . $_SERVER['HTTP_REFERER']);
                exit();
    }

    $stmt->close();
}

$conn->close();
header("Location: " . $_SERVER['HTTP_REFERER']);
exit();
?>