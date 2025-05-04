<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    die("You must be logged in to proceed.");
}

$discounted_seats = isset($_POST['discounted_seats']) ? $_POST['discounted_seats'] : [];

$all_seats = isset($_POST['seats']) ? explode(',', $_POST['seats']) : [];

if (empty($discounted_seats)) {
    die("No discounted seats selected.");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Upload ID for Discounted Seats</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }
        .seat-upload {
            margin-bottom: 20px;
            background: #f2f2f2;
            padding: 15px;
            border-radius: 10px;
        }
        .seat-label {
            font-weight: bold;
        }
        .submit-button {
            background-color: #1e3504;
            color: white;
            padding: 10px 25px;
            border: none;
            border-radius: 20px;
            font-size: 16px;
            cursor: pointer;
            text-transform: uppercase;
        }
    </style>
</head>
<body>

<h2>Upload Valid ID for Each Discounted Seat</h2>

<form action="finalize_booking.php" method="POST" enctype="multipart/form-data">
    <?php foreach ($discounted_seats as $seat): ?>
        <div class="seat-upload">
            <label class="seat-label">Seat <?= htmlspecialchars($seat) ?>:</label><br>
            <input type="file" name="id_<?= htmlspecialchars($seat) ?>" accept="image/*" required>
        </div>
    <?php endforeach; ?>

    <!-- Pass along necessary data -->
    <input type="hidden" name="seats" value="<?= htmlspecialchars(implode(',', $all_seats)) ?>">
    <input type="hidden" name="discounted_seats" value="<?= htmlspecialchars(implode(',', $discounted_seats)) ?>">
    <input type="hidden" name="cinema_id" value="<?= htmlspecialchars($_POST['cinema_id']) ?>">
    <input type="hidden" name="showing_id" value="<?= htmlspecialchars($_POST['showing_id']) ?>">
    <input type="hidden" name="user_id" value="<?= htmlspecialchars($_POST['user_id']) ?>">
    <input type="hidden" name="movie_title" value="<?= htmlspecialchars($_POST['movie_title']) ?>">
    <input type="hidden" name="venue_name" value="<?= htmlspecialchars($_POST['venue_name']) ?>">
    <input type="hidden" name="cinema_name" value="<?= htmlspecialchars($_POST['cinema_name']) ?>">
    <input type="hidden" name="show_date" value="<?= htmlspecialchars($_POST['show_date']) ?>">
    <input type="hidden" name="show_time" value="<?= htmlspecialchars($_POST['show_time']) ?>">
    <input type="hidden" name="price" value="<?= htmlspecialchars($_POST['price']) ?>">

    <button type="submit" class="submit-button">Continue toConfirmation</button>
</form>

</body>
</html>
