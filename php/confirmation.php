<?php
session_start();

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    die("You must be logged in to book tickets.");
}

// Get form data
$seats = isset($_POST['seats']) ? $_POST['seats'] : [];
$cinema_name = isset($_POST['cinema_name']) ? $_POST['cinema_name'] : '';
$movie_title = isset($_POST['movie_title']) ? $_POST['movie_title'] : '';
$venue_name = isset($_POST['venue_name']) ? $_POST['venue_name'] : '';
$price = isset($_POST['price']) ? $_POST['price'] : 0;
$total_price = count($seats) * $price;

if (empty($seats)) {
    die("No seats selected.");
}
?>

<h3>Confirmation</h3>
<p><strong>Movie:</strong> <?= htmlspecialchars($movie_title) ?></p>
<p><strong>Venue:</strong> <?= htmlspecialchars($venue_name) ?> - <strong>Cinema:</strong> <?= htmlspecialchars($cinema_name) ?></p>
<p><strong>Selected Seats:</strong> <?= implode(", ", $seats) ?></p>
<p><strong>Total Price:</strong> <?= number_format($total_price, 2) ?> USD</p>

<form action="process_seats.php" method="POST">
    <input type="hidden" name="cinema_id" value="<?= $_POST['cinema_id'] ?>">
    <input type="hidden" name="showing_id" value="<?= $_POST['showing_id'] ?>">
    <input type="hidden" name="user_id" value="<?= $_SESSION['user_id'] ?>">
    <input type="hidden" name="seats" value="<?= implode(",", $seats) ?>">
    <input type="hidden" name="cinema_name" value="<?= htmlspecialchars($cinema_name) ?>">
    <input type="hidden" name="movie_title" value="<?= htmlspecialchars($movie_title) ?>">
    <input type="hidden" name="venue_name" value="<?= htmlspecialchars($venue_name) ?>">
    <input type="hidden" name="total_price" value="<?= $total_price ?>">

    <button type="submit">Confirm Booking</button>
</form>
