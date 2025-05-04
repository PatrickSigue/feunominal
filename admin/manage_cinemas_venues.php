<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'tix');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle new venue submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_venue'])) {
        $venue_name = $_POST['venue_name'];
        $address = $_POST['address'];
        $user_id = 1; // You can change this to use $_SESSION['user_id'] if available

        $stmt = $conn->prepare("INSERT INTO venues (venue_name, address, user_id) VALUES (?, ?, ?)");
        $stmt->bind_param("ssi", $venue_name, $address, $user_id);
        $stmt->execute();
    }

    if (isset($_POST['add_cinema'])) {
        $name = $_POST['cinema_name'];
        $venue_id = $_POST['venue_id'];
        $rows = $_POST['seat_rows'];
        $cols = $_POST['seat_columns'];
        $seat_capacity = $rows * $cols;
        $user_id = 1;

        $stmt = $conn->prepare("INSERT INTO cinemas (name, venue_id, seat_rows, seat_columns, seat_capacity, user_id) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("siiiii", $name, $venue_id, $rows, $cols, $seat_capacity, $user_id);
        $stmt->execute();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Cinema & Venue Management</title>
    <link rel="stylesheet" href="../css/nav.css">
    <style>
        body { font-family: Arial; margin: 20px; margin-top: 80px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 10px; border: 1px solid #ccc; text-align: left; }
        h2 { margin-top: 50px; }
        form { background: #f7f7f7; padding: 20px; border-radius: 10px; max-width: 500px; margin-bottom: 30px; }
        input, select, textarea { width: 100%; padding: 10px; margin-top: 8px; margin-bottom: 15px; border-radius: 5px; border: 1px solid #ccc; }
        button { background-color: #007BFF; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; }
        button:hover { background-color: #0056b3; }
    </style>
</head>
<body>

<h1>Venue Management</h1>

<form method="POST">
    <h3>Add New Venue</h3>
    <label>Venue Name:</label>
    <input type="text" name="venue_name" required>

    <label>Address:</label>
    <textarea name="address" required></textarea>

    <button type="submit" name="add_venue">Add Venue</button>
</form>

<table>
    <tr><th>Venue ID</th><th>Name</th><th>Address</th><th>Added by (user_id)</th></tr>
    <?php
    $res = $conn->query("SELECT * FROM venues");
    while ($venue = $res->fetch_assoc()) {
        echo "<tr>
            <td>{$venue['venue_id']}</td>
            <td>" . htmlspecialchars($venue['venue_name']) . "</td>
            <td>" . htmlspecialchars($venue['address']) . "</td>
            <td>{$venue['user_id']}</td>
        </tr>";
    }
    ?>
</table>

<h1>Cinema Management</h1>

<form method="POST">
    <h3>Add New Cinema</h3>
    <label>Cinema Name:</label>
    <input type="text" name="cinema_name" required>

    <label>Venue:</label>
    <select name="venue_id" required>
        <option value="">Select Venue</option>
        <?php
        $venues = $conn->query("SELECT * FROM venues");
        while ($v = $venues->fetch_assoc()) {
            echo "<option value='{$v['venue_id']}'>" . htmlspecialchars($v['venue_name']) . "</option>";
        }
        ?>
    </select>

    <label>Seat Rows:</label>
    <input type="number" name="seat_rows" min="1" required>

    <label>Seat Columns:</label>
    <input type="number" name="seat_columns" min="1" required>

    <button type="submit" name="add_cinema">Add Cinema</button>
</form>

<table>
    <tr><th>Cinema ID</th><th>Name</th><th>Venue</th><th>Rows</th><th>Columns</th><th>Capacity</th><th>Added by</th></tr>
    <?php
    $res = $conn->query("SELECT c.*, v.venue_name FROM cinemas c JOIN venues v ON c.venue_id = v.venue_id");
    while ($cinema = $res->fetch_assoc()) {
        echo "<tr>
            <td>{$cinema['cinema_id']}</td>
            <td>" . htmlspecialchars($cinema['name']) . "</td>
            <td>" . htmlspecialchars($cinema['venue_name']) . "</td>
            <td>{$cinema['seat_rows']}</td>
            <td>{$cinema['seat_columns']}</td>
            <td>{$cinema['seat_capacity']}</td>
            <td>{$cinema['user_id']}</td>
        </tr>";
    }
    ?>
</table>

</body>
</html>
