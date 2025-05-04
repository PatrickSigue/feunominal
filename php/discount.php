<?php
session_start();

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    die("You must be logged in to book tickets.");
}

// Get form data
$seats = isset($_POST['seats']) ? (array)$_POST['seats'] : [];
$cinema_name = isset($_POST['cinema_name']) ? $_POST['cinema_name'] : '';
$movie_title = isset($_POST['movie_title']) ? $_POST['movie_title'] : '';
$venue_name = isset($_POST['venue_name']) ? $_POST['venue_name'] : '';
$price = isset($_POST['price']) ? floatval($_POST['price']) : 0;
$show_date = isset($_POST['show_date']) ? $_POST['show_date'] : '';
$show_time = isset($_POST['show_time']) ? $_POST['show_time'] : '';

// Assuming this array contains selected seats for the showing
$selectedSeats = isset($_POST['seats']) ? $_POST['seats'] : [];
?>

<div class="confirmation-container">
    <h3 class="confirmation-title">Confirm Your Discounted Booking</h3>

    <form id="confirmBookingForm" action="confirm_booking.php" method="POST" class="confirmation-form" enctype="multipart/form-data">
        <div class="confirmation-details">
            <p class="confirmation-item"><span class="label">Movie:</span> <span class="value"><?= htmlspecialchars($movie_title) ?></span></p>
            <p class="confirmation-item"><span class="label">Venue:</span> <span class="value"><?= htmlspecialchars($venue_name) ?></span></p>
            <p class="confirmation-item"><span class="label">Cinema:</span> <span class="value"><?= htmlspecialchars($cinema_name) ?></span></p>
            <p class="confirmation-item"><span class="label">Date:</span> <span class="value"><?= htmlspecialchars($show_date) ?></span></p>
            <p class="confirmation-item"><span class="label">Time:</span> <span class="value"><?= htmlspecialchars($show_time) ?></span></p>

            <table class="seats-table">
                <tr>
                    <th>Seat</th>
                    <th>Apply 20% Discount</th>
                </tr>
                <?php foreach ($selectedSeats as $index => $seat): ?>
                <tr>
                    <td class="seat"><?= htmlspecialchars($seat) ?></td>
                    <td>
                        <input type="hidden" name="seats[<?= $index ?>][seat]" value="<?= htmlspecialchars($seat) ?>">
                        <input type="checkbox" name="seats[<?= $index ?>][discount]" value="1" class="discount-checkbox" data-index="<?= $index ?>">
                        <div class="file-upload-container" id="file-upload-container-<?= $index ?>" style="display:none;">
                            <input type="file" name="seats[<?= $index ?>][id_image]" accept="image/*" required>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>

        <input type="hidden" name="cinema_id" value="<?= htmlspecialchars($_POST['cinema_id']) ?>">
        <input type="hidden" name="showing_id" value="<?= htmlspecialchars($_POST['showing_id']) ?>">
        <input type="hidden" name="user_id" value="<?= htmlspecialchars($_SESSION['user_id']) ?>">
        <input type="hidden" name="cinema_name" value="<?= htmlspecialchars($cinema_name) ?>">
        <input type="hidden" name="movie_title" value="<?= htmlspecialchars($movie_title) ?>">
        <input type="hidden" name="venue_name" value="<?= htmlspecialchars($venue_name) ?>">
        <input type="hidden" name="price" value="<?= htmlspecialchars($price) ?>">
        <input type="hidden" name="show_date" value="<?= htmlspecialchars($show_date) ?>">
        <input type="hidden" name="show_time" value="<?= htmlspecialchars($show_time) ?>">
        <button type="submit" class="confirm-button">Confirm Booking</button>
    </form>
</div>



<style>
.confirmation-container {
    text-align: center;
    font-family: 'Arial', sans-serif;
}

.confirmation-title {
    margin: 0 0 20px;
    font-size: 24px;
    color: #333;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.confirmation-details {
    margin-bottom: 25px;
    background-color: #f9f9f9;
    padding: 15px;
    border-radius: 8px;
    box-shadow: inset 0 0 5px rgba(0, 0, 0, 0.05);
}

.confirmation-item {
    margin: 10px 0;
    font-size: 16px;
    color: #555;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 5px 0;
    border-bottom: 1px solid #eee;
}

.confirmation-item:last-child {
    border-bottom: none;
}

.label {
    font-weight: 600;
    color: #333;
    flex: 0 0 40%;
    text-align: left;
}

.value {
    flex: 0 0 60%;
    text-align: right;
    color: #444;
}

.value.seats {
    color: #EFBF04; /* Seat color */
    font-weight: 600;
}

.total-price .value {
    font-size: 18px;
    font-weight: 700;
    color: #1e3504; /* Total price color */
}

.confirmation-form {
    margin-top: 20px;
}

.confirmation-form .confirm-button {
    background-color: #1e3504 !important; /* Updated button color with higher specificity */
    color: white !important;
    padding: 12px 30px;
    border: none;
    border-radius: 25px;
    cursor: pointer;
    font-size: 16px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1px;
    transition: background-color 0.3s ease, transform 0.1s ease;
    box-shadow: 0 2px 10px rgba(30, 53, 4, 0.3);
}

.confirmation-form .confirm-button:hover {
    background-color: #34491d !important; /* Updated hover color */
    transform: translateY(-2px);
}

.confirmation-form .confirm-button:active {
    transform: translateY(0);
}

/* Responsive adjustments */
@media (max-width: 480px) {
    .confirm-modal-content {
        width: 95%;
        padding: 15px;
    }

    .confirmation-title {
        font-size: 20px;
    }

    .confirmation-item {
        font-size: 14px;
        flex-direction: column;
        align-items: flex-start;
    }

    .label, .value {
        flex: 1 1 100%;
        text-align: left;
    }

    .value {
        margin-top: 5px;
    }

    .confirmation-form .confirm-button {
        padding: 10px 20px;
        font-size: 14px;
    }
}

/* Seat selection table styles */
.seats-table {
    width: 100%;
    margin: 20px 0;
    border-collapse: collapse;
    background-color: #f9f9f9;
    border-radius: 8px;
    box-shadow: inset 0 0 5px rgba(0, 0, 0, 0.05);
}

.seats-table th,
.seats-table td {
    padding: 12px 15px;
    text-align: center;
    font-size: 16px;
    color: #555;
    border-bottom: 1px solid #ddd;
}

.seats-table th {
    background-color: #f4f4f4;
    font-weight: 600;
    color: #333;
    text-transform: uppercase;
}

.seats-table td {
    justify-content: space-between; /* Space between seat label and checkbox */
}

.seats-table td .seat {
    font-weight: 600;
    color: #EFBF04; /* Seat color */
    flex: 1; /* Allow the seat label to take up space */
    padding-right: 10px;
}

.seats-table td input[type="checkbox"] {
    margin-left: 5px; /* Space between seat and checkbox */
    cursor: pointer;
}
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
    // Select all discount checkboxes
    const discountCheckboxes = document.querySelectorAll('.discount-checkbox');

    // Add event listener to each checkbox
    discountCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const index = this.getAttribute('data-index');
            const fileUploadContainer = document.getElementById('file-upload-container-' + index);
            const fileInput = fileUploadContainer.querySelector('input[type="file"]');
            
            // Toggle the visibility of the file input and adjust the 'required' attribute
            if (this.checked) {
                fileUploadContainer.style.display = 'block';
                fileInput.setAttribute('required', 'required');  // Set required
            } else {
                fileUploadContainer.style.display = 'none';
                fileInput.removeAttribute('required');  // Remove required
            }
        });
    });
});

</script>
