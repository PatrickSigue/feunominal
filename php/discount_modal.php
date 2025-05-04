<?php
session_start();

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    die("You must be logged in to apply a discount.");
}

// Get form data
$seats = isset($_POST['seats']) ? (array)$_POST['seats'] : [];
$cinema_name = isset($_POST['cinema_name']) ? $_POST['cinema_name'] : '';
$movie_title = isset($_POST['movie_title']) ? $_POST['movie_title'] : '';
$venue_name = isset($_POST['venue_name']) ? $_POST['venue_name'] : '';
$price = isset($_POST['price']) ? floatval($_POST['price']) : 0;
$show_date = isset($_POST['show_date']) ? $_POST['show_date'] : '';
$show_time = isset($_POST['show_time']) ? $_POST['show_time'] : '';
$discount_code = isset($_POST['discountCode']) ? trim($_POST['discountCode']) : '';

// Validate discount code (dummy example, replace with actual validation logic)
$discount_percentage = 0;
if ($discount_code === 'DISCOUNT10') {
    $discount_percentage = 10; // 10% discount
} elseif ($discount_code === 'DISCOUNT20') {
    $discount_percentage = 20; // 20% discount
} elseif ($discount_code) {
    $discount_percentage = 0; // Invalid discount
}

// Calculate total price before discount
$total_price = count($seats) * $price;

// Apply discount
$discount_amount = ($total_price * $discount_percentage) / 100;
$total_price_after_discount = $total_price - $discount_amount;

if (empty($seats)) {
    die("No seats selected.");
}
?>

<div class="discount-container">
    <h3 class="discount-title">Discount Applied</h3>
    <div class="discount-details">
        <p class="discount-item"><span class="label">Movie:</span> <span class="value"><?= htmlspecialchars($movie_title) ?></span></p>
        <p class="discount-item"><span class="label">Venue:</span> <span class="value"><?= htmlspecialchars($venue_name) ?></span></p>
        <p class="discount-item"><span class="label">Cinema:</span> <span class="value"><?= htmlspecialchars($cinema_name) ?></span></p>
        <p class="discount-item"><span class="label">Date:</span> <span class="value"><?= htmlspecialchars($show_date) ?></span></p>
        <p class="discount-item"><span class="label">Time:</span> <span class="value"><?= htmlspecialchars($show_time) ?></span></p>
        <p class="discount-item"><span class="label">Selected Seats:</span> <span class="value seats"><?= implode(", ", array_map('htmlspecialchars', $seats)) ?></span></p>
        <p class="discount-item total-price-before"><span class="label">Total Price (Before Discount):</span> <span class="value">₱ <?= number_format($total_price, 2) ?></span></p>
        <p class="discount-item discount-amount"><span class="label">Discount Applied:</span> <span class="value">-₱ <?= number_format($discount_amount, 2) ?></span></p>
        <p class="discount-item total-price-after"><span class="label">Total Price (After Discount):</span> <span class="value">₱ <?= number_format($total_price_after_discount, 2) ?></span></p>
    </div>

    <form id="confirmBookingForm" action="php/process_seats.php" method="POST" class="discount-form">
        <input type="hidden" name="cinema_id" value="<?= htmlspecialchars($_POST['cinema_id']) ?>">
        <input type="hidden" name="showing_id" value="<?= htmlspecialchars($_POST['showing_id']) ?>">
        <input type="hidden" name="user_id" value="<?= htmlspecialchars($_SESSION['user_id']) ?>">
        <input type="hidden" name="seats" value="<?= implode(",", array_map('htmlspecialchars', $seats)) ?>">
        <input type="hidden" name="cinema_name" value="<?= htmlspecialchars($cinema_name) ?>">
        <input type="hidden" name="movie_title" value="<?= htmlspecialchars($movie_title) ?>">
        <input type="hidden" name="venue_name" value="<?= htmlspecialchars($venue_name) ?>">
        <input type="hidden" name="total_price" value="<?= $total_price_after_discount ?>">
        <input type="hidden" name="show_date" value="<?= htmlspecialchars($show_date) ?>">
        <input type="hidden" name="show_time" value="<?= htmlspecialchars($show_time) ?>">
        <button type="submit" class="confirm-button">Confirm Booking</button>
    </form>
</div>
