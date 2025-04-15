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

// Get cinema info for the showing
$sql = "SELECT c.cinema_id, c.name AS cinema_name, c.seat_rows, c.seat_columns 
        FROM showings s 
        JOIN cinemas c ON s.cinema_id = c.cinema_id 
        WHERE s.showing_id = $showing_id";
$result = $conn->query($sql);
$cinema = $result->fetch_assoc();
if (!$cinema) die("Cinema not found.");

$rows = $cinema['seat_rows'];
$cols = $cinema['seat_columns'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?= htmlspecialchars($cinema['cinema_name']) ?> - Select Seats</title>
  <style>
    body { font-family: Arial, sans-serif; padding: 20px; background: #f4f4f4; }
    h2 { margin-bottom: 10px; }
    .seat-grid {
      display: flex;
      flex-direction: column;
      align-items: flex-start;
      gap: 10px;
      padding: 20px;
      background: #f4f4f4;
      border-radius: 10px;
    }
    
    .screen {
      align-self: center;
      text-align: center;
      font-weight: bold;
      background: #ccc;
      color: #222;
      padding: 10px 20px;
      border-radius: 15px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
      margin-bottom: 10px;
    }
    
    .seat-row {
      display: flex;
      align-items: center;
      gap: 6px;
    }
    .row-label {
      width: 30px;
      font-weight: bold;
      text-align: center;
    }
    .seat {
      width: 35px;
      height: 35px;
      background: #ccc;
      border-radius: 4px;
      text-align: center;
      line-height: 35px;
      cursor: pointer;
    }
    .seat.selected { background: #28a745; color: white; }
    .seat.taken { background: #999; cursor: not-allowed; }
    .select-seat-modal {
  display: none;
  position: fixed;
  z-index: 1000;
  left: 0; top: 0;
  width: 100%; height: 100%;
  background-color: rgba(0, 0, 0, 0.6);
  overflow: auto;
}

.select-seat-content {
  background-color: #fff;
  margin: 5% auto;
  padding: 20px;
  border-radius: 12px;
  width: 80%;
  max-width: 700px;
  box-shadow: 0 8px 20px rgba(0,0,0,0.3);
  position: relative;
}

.close-btn {
  color: #aaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
  cursor: pointer;
  position: absolute;
  right: 20px;
  top: 10px;
}

.close-btn:hover {
  color: #000;
}

  </style>
</head>
<button onclick="openSeatModal()">Select Seat</button>
<div id="select-seat-modal" class="select-seat-modal">
  <div class="select-seat-content">
    <span class="close-btn" onclick="closeSeatModal()">&times;</span>
    <h2>Select Your Seat</h2>

    <div class="seat-grid" id="seatGrid">
      <div class="screen">SCREEN</div>

      <?php for ($r = 0; $r < $rows; $r++): ?>
        <div class="seat-row">
          <div class="row-label"><?= chr(65 + $r) ?></div>
          <?php for ($c = 0; $c < $cols; $c++): 
            $seatLabel = chr(65 + $r) . ($c + 1);
          ?>
            <div class="seat" data-seat="<?= $seatLabel ?>"><?= $c + 1 ?></div>
          <?php endfor; ?>
        </div>
      <?php endfor; ?>
    </div>
  </div>
</div>


<body>

  <h2>Select Seats - <?= htmlspecialchars($cinema['cinema_name']) ?></h2>
  

  <div class="seat-grid" id="seatGrid">
    <div class="screen">SCREEN</div>
  <?php for ($r = 0; $r < $rows; $r++): ?>
    <div class="seat-row">
      <div class="row-label"><?= chr(65 + $r) ?></div>
      <?php for ($c = 0; $c < $cols; $c++): 
        $seatLabel = chr(65 + $r) . ($c + 1);
      ?>
        <div class="seat" data-seat="<?= $seatLabel ?>"><?= $c + 1 ?></div>
      <?php endfor; ?>
    </div>
  <?php endfor; ?>
</div>


  <p>Selected Seats: <span id="selectedSeats"></span></p>

  <script>
    const seats = document.querySelectorAll('.seat');
    const selectedDisplay = document.getElementById('selectedSeats');
    const selected = new Set();

    seats.forEach(seat => {
      seat.addEventListener('click', () => {
        if (seat.classList.contains('taken')) return;
        seat.classList.toggle('selected');
        const label = seat.dataset.seat;

        if (seat.classList.contains('selected')) {
          selected.add(label);
        } else {
          selected.delete(label);
        }

        selectedDisplay.textContent = Array.from(selected).join(', ');
      });
    });

    function openSeatModal() {
  document.getElementById("select-seat-modal").style.display = "block";
}

function closeSeatModal() {
  document.getElementById("select-seat-modal").style.display = "none";
}

window.onclick = function(e) {
  const modal = document.getElementById("select-seat-modal");
  if (e.target == modal) modal.style.display = "none";
}
  </script>

</body>
</html>
