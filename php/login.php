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
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT user_id, email, password, f_name, user_type, archived FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $db_email, $db_password, $fname, $user_type, $archived);
        $stmt->fetch();

        if ($archived == 1) {
            // If the user is archived, deny login
            $_SESSION['error'] = "Your account has been archived. Please contact support.";
        } elseif ($password == $db_password) {
            $_SESSION['user_id'] = $id;
            $_SESSION['email'] = $db_email;
            $_SESSION['f_name'] = $fname;
            $_SESSION['user_type'] = $user_type;

            if ($user_type === 'admin') {
                header("Location: ../admin/admin.php");
            } elseif ($user_type === 'organizer') {
                header("Location: ../organizer.php");
            } else {
                header("Location: " . $_SERVER['HTTP_REFERER']);
            }
            exit();

        } else {
            $_SESSION['error'] = "Incorrect password.";
        }
    } else {
        $_SESSION['error'] = "No user found with that email.";
    }

    $stmt->close();
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit();
}

$conn->close();
header("Location: " . $_SERVER['HTTP_REFERER']);
exit();
?>
