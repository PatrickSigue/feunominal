<?php
session_start();
$host = 'localhost';
$db = 'tix';
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

$showing_id = isset($_GET['showing_id']) ? intval($_GET['showing_id']) : 0;
if (!$showing_id) die("Invalid showing ID.");

$isLoggedIn = isset($_SESSION['user_id']);

if (!$isLoggedIn) {
    echo "<script>
        window.addEventListener('DOMContentLoaded', () => {
            const modal = document.getElementById('loginModal');
            if (modal) modal.style.display = 'flex';
        });
    </script>";
}

// Get cinema, movie, and seat details
$sql = "SELECT m.movie_title, v.venue_name AS venue_name, c.cinema_id, c.name AS cinema_name, 
               c.seat_rows, c.seat_columns, s.price, s.show_date, s.show_time
        FROM showings s 
        JOIN cinemas c ON s.cinema_id = c.cinema_id
        JOIN movies m ON s.movie_id = m.movie_id
        JOIN venues v ON c.venue_id = v.venue_id
        WHERE s.showing_id = $showing_id";

$result = $conn->query($sql);
if ($row = $result->fetch_assoc()) {
    $movie_title = $row['movie_title'];
    $venue_name = $row['venue_name'];
    $cinema_id = $row['cinema_id'];
    $cinema_name = $row['cinema_name'];
    $rows = intval($row['seat_rows']);
    $cols = intval($row['seat_columns']);
    $price = $row['price'];
    $show_date = $row['show_date'];
    $show_time = $row['show_time'];

} else {
    die("Invalid showing ID or data.");
}

$booked = [];
// Fetch booked seats for this showing
$bookedResult = $conn->query("SELECT seat_row, seat_number FROM seats WHERE cinema_id = $cinema_id AND showing_id = $showing_id");
while ($b = $bookedResult->fetch_assoc()) {
    $booked[] = $b['seat_row'] . $b['seat_number'];
}

// Generate seat row labels (e.g., A, B, C, ...)
$rowLabels = range('A', chr(ord('A') + $rows - 1));

?>
<?php if ($isLoggedIn): ?>
<!-- Seat Selection Form -->
<h3 style="margin-bottom: 10px; text-align:center;">Select Seats for <?= htmlspecialchars($cinema_name) . ' - ₱' . htmlspecialchars($price) ?></h3>
<form action="php/confirm_booking.php" method="POST">
    <div style="margin-bottom: 10px; text-align:center; font-weight: bold;">
        Screen This Way ↑
    </div>

    <!-- Seat Grid -->
    <div class="seat-grid">
        <?php foreach ($rowLabels as $r): ?>
            <div class="seat-row">
                <div class="row-label"><?= $r ?></div>
                <?php for ($c = 1; $c <= $cols; $c++): 
                    $seatVal = $r . $c;
                    $isBooked = in_array($seatVal, $booked);
                ?>
                    <label>
                        <input type="checkbox" name="seats[]" value="<?= $seatVal ?>" <?= $isBooked ? 'disabled' : '' ?> style="display:none;">
                        <div class="seat <?= $isBooked ? 'booked' : '' ?>"><?= $c ?></div>
                    </label>
                <?php endfor; ?>
            </div>
        <?php endforeach; ?>
    </div>

    <br>
    <input type="hidden" name="cinema_id" value="<?= $cinema_id ?>">
    <input type="hidden" name="showing_id" value="<?= $showing_id ?>">
    <input type="hidden" name="user_id" value="<?= $_SESSION['user_id'] ?>">
    <input type="hidden" name="movie_title" value="<?= htmlspecialchars($movie_title) ?>">
    <input type="hidden" name="venue_name" value="<?= htmlspecialchars($venue_name) ?>">
    <input type="hidden" name="cinema_name" value="<?= htmlspecialchars($cinema_name) ?>">
    <input type="hidden" name="show_time" value="<?= htmlspecialchars($show_time) ?>">
    <input type="hidden" name="show_date" value="<?= htmlspecialchars($show_date) ?>">
    <input type="hidden" name="price" value="<?= $price ?>">

   <div style="text-align: center;">
    <button type="submit">Confirm Selection</button>
</div>

</form>
<?php else: ?>
    <!-- Just say "Please log in to continue" -->
    <h3 style="text-align: center; margin-top: 50px;">Please log in to continue</h3>
<?php endif; ?>
<style>
    .seat-grid {
        display: flex;
        flex-direction: column;
        gap: 10px;
        align-items: center;
    }

    .seat-row {
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .row-label {
        width: 30px;
        text-align: right;
        margin-right: 10px;
        font-weight: bold;
    }

    .seat {
        width: 40px;
        height: 40px;
        background-color: #ccc;
        border-radius: 5px;
        line-height: 40px;
        text-align: center;
        cursor: pointer;
        transition: 0.2s;
    }

    input[type="checkbox"]:checked + .seat {
        background-color: #4CAF50;
        color: white;
    }

    .seat:hover {
        background-color: #999;
    }

    .booked {
        background-color: #e74c3c;
        cursor: not-allowed;
    }

    label {
        display: inline-block;
    }
</style>
