<?php
session_start();

// Get redirect path from GET param, default to homepage if not set
$redirect = isset($_GET['redirect']) ? $_GET['redirect'] : '/';

// Set logout success message
$_SESSION['error'] = 'Successfully logged out!';

// Destroy session
session_unset();
session_destroy();

// Start a new session to carry the message
session_start();
$_SESSION['error'] = 'Successfully logged out!';

// Redirect to the chosen page (e.g. movie.php)
header("Location: $redirect");
exit();
?>
