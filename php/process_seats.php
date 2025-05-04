<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Not logged in']);
    exit;
}

$cinema_id = isset($_POST['cinema_id']) ? intval($_POST['cinema_id']) : 0;
$showing_id = isset($_POST['showing_id']) ? intval($_POST['showing_id']) : 0;
$user_id = isset($_POST['user_id']) ? intval($_POST['user_id']) : 0;
$seats = isset($_POST['seats']) ? explode(',', $_POST['seats']) : [];
$total_price = isset($_POST['total_price']) ? floatval($_POST['total_price']) : 0;

if (empty($seats) || !$cinema_id || !$showing_id || !$user_id) {
    echo json_encode(['success' => false, 'message' => 'Invalid input data']);
    exit;
}

$host = 'localhost';
$db = 'tix';
$user = 'root';
$pass = '';
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed']);
    exit;
}

$conn->begin_transaction();
try {
    $seat_stmt = $conn->prepare("INSERT INTO seats (cinema_id, showing_id, user_id, seat_row, seat_number) VALUES (?, ?, ?, ?, ?)");
    $ticket_stmt = $conn->prepare("INSERT INTO movie_tickets (showing_id, seat_id, user_id, booking_time) VALUES (?, ?, ?, NOW())");

    foreach ($seats as $seat) {
        $seat_row = substr($seat, 0, 1);
        $seat_number = substr($seat, 1);

        $seat_stmt->bind_param('iiiss', $cinema_id, $showing_id, $user_id, $seat_row, $seat_number);
        $seat_stmt->execute();
        $seat_id = $seat_stmt->insert_id;

        $ticket_stmt->bind_param('iii', $showing_id, $seat_id, $user_id);
        $ticket_stmt->execute();
    }

    $conn->commit();
    echo json_encode(['success' => true]);
} catch (Exception $e) {
    $conn->rollback();
    echo json_encode(['success' => false, 'message' => 'Booking failed: ' . $e->getMessage()]);
}
$conn->close();
?>
