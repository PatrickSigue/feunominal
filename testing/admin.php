<?php
session_start();
require 'config.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}
?>

<h2>Admin Dashboard</h2>

<ul>
    <li><a href="add_organizer.php">Add Organizer</a></li>
    <li><a href="add_movie.php">Add Movie</a></li>
    <li><a href="add_venue.php">Add Venue</a></li>
    <li><a href="add_cinema.php">Add Cinema</a></li>
    <li><a href="show_date_and_time.php">Add Showing</a></li>
    <li><a href="manage_users.php">Manage Users</a></li>
</ul>
