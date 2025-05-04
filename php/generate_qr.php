<?php
require_once '../assets/phpqrcode/qrlib.php';

if (isset($_GET['data'])) {
    $data = $_GET['data'];

    // Set appropriate headers
    header('Content-Type: image/png');

    // Generate and output the QR code
    QRcode::png($data, null, QR_ECLEVEL_L, 4);
}
