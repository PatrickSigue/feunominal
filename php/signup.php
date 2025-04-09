<?php

$servername = "localhost"; 
$username = "root";
$password = "";
$dbname = "tix";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fname = $conn->real_escape_string($_POST['fname']);
    $lname = $conn->real_escape_string($_POST['lname']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = $conn->real_escape_string($_POST['pword']);
    $cpassword = $conn->real_escape_string($_POST['cpword']);

    $checkemail = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($checkemail);

    if ($result->num_rows > 0) {
        $_SESSION['error'] = 'Email is already in use.';
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    }
    else{
    	if ($password == $cpassword) {
    		$sql = "INSERT INTO users (f_name,s_name, email, password, user_type, created_at) VALUES ('$fname', '$lname', '$email', '$password', 'customer', now())";

	    	if ($conn->query($sql) === TRUE) {
	    		 $_SESSION['error'] = 'New record created successfully';
	    	     header("Location: " . $_SERVER['HTTP_REFERER']);
	    	     exit();
	    	} else {
	    		$_SESSION['error'] = 'Error: ' . $conn->	error;
	    	    header("Location: " . $_SERVER['HTTP_REFERER']);
	    	    exit();
	    	}
    	}

    	else{
    		$_SESSION['error'] = 'Passwords do not match.';
    		header("Location: " . $_SERVER['HTTP_REFERER']);
    		exit();
    	}    
	}
}

$conn->close();
?> 