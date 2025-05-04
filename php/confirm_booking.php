<?php
session_start();

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    die("You must be logged in to book tickets.");
}

// Get form data
$seats = isset($_POST['seats']) ? $_POST['seats'] : [];
$discountedSeats = isset($_POST['discounted_seats']) ? (array)$_POST['discounted_seats'] : [];
$cinema_name = $_POST['cinema_name'] ?? '';
$movie_title = $_POST['movie_title'] ?? '';
$venue_name = $_POST['venue_name'] ?? '';
$price = isset($_POST['price']) ? floatval($_POST['price']) : 0;
$show_date = $_POST['show_date'] ?? '';
$show_time = $_POST['show_time'] ?? '';

// Price calculations
$discountRate = 0.20;
$discountedCount = count($discountedSeats);
$fullPriceCount = count($seats) - $discountedCount;

$total_price = ($fullPriceCount * $price) + ($discountedCount * $price * (1 - $discountRate));

if (empty($seats)) {
    die("No seats selected.");
}
?>

<div class="confirmation-container">
    <h3 class="confirmation-title">Confirm Your Booking</h3>
    <div class="confirmation-details">
        <p class="confirmation-item"><span class="label">Movie:</span> <span class="value"><?= htmlspecialchars($movie_title) ?></span></p>
        <p class="confirmation-item"><span class="label">Venue:</span> <span class="value"><?= htmlspecialchars($venue_name) ?></span></p>
        <p class="confirmation-item"><span class="label">Cinema:</span> <span class="value"><?= htmlspecialchars($cinema_name) ?></span></p>
        <p class="confirmation-item"><span class="label">Date:</span> <span class="value"><?= htmlspecialchars($show_date) ?></span></p>
        <p class="confirmation-item"><span class="label">Time:</span> <span class="value"><?= htmlspecialchars($show_time) ?></span></p>
        <p class="confirmation-item"><span class="label">Selected Seats:</span> <span class="value seats"><?= implode(", ", array_map('htmlspecialchars', $seats)) ?></span></p>

        <?php if ($discountedCount > 0): ?>
            <p class="confirmation-item"><span class="label">Discounted Seats (20% off):</span> <span class="value seats"><?= implode(", ", array_map('htmlspecialchars', $discountedSeats)) ?></span></p>
            <p class="confirmation-item"><span class="label">Original Total:</span> <span class="value">₱ <?= number_format(count($seats) * $price, 2) ?></span></p>
            <p class="confirmation-item total-price"><span class="label">Discounted Total:</span> <span class="value">₱ <?= number_format($total_price, 2) ?></span></p>
        <?php else: ?>
            <p class="confirmation-item total-price"><span class="label">Total Price:</span> <span class="value">₱ <?= number_format($total_price, 2) ?></span></p>
        <?php endif; ?>
    </div>

    <form id="confirmBookingForm" action="php/process_seats.php" method="POST" class="confirmation-form">
        <input type="hidden" name="cinema_id" value="<?= htmlspecialchars($_POST['cinema_id']) ?>">
        <input type="hidden" name="showing_id" value="<?= htmlspecialchars($_POST['showing_id']) ?>">
        <input type="hidden" name="user_id" value="<?= htmlspecialchars($_SESSION['user_id']) ?>">
        <input type="hidden" name="seats" value="<?= implode(",", array_map('htmlspecialchars', $seats)) ?>">
        <input type="hidden" name="discounted_seats" value="<?= implode(",", array_map('htmlspecialchars', $discountedSeats)) ?>">
        <input type="hidden" name="cinema_name" value="<?= htmlspecialchars($cinema_name) ?>">
        <input type="hidden" name="movie_title" value="<?= htmlspecialchars($movie_title) ?>">
        <input type="hidden" name="venue_name" value="<?= htmlspecialchars($venue_name) ?>">
        <input type="hidden" name="price" value="<?= $price ?>">
        <input type="hidden" name="total_price" value="<?= $total_price ?>">
        <input type="hidden" name="show_date" value="<?= htmlspecialchars($show_date) ?>">
        <input type="hidden" name="show_time" value="<?= htmlspecialchars($show_time) ?>">
        <button type="submit" class="confirm-button">Confirm Booking</button>
    </form>
</div>
