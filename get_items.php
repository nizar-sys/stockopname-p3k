<?php
include 'config.php';

// Set header dulu
header('Content-Type: application/json');

// Sanitasi input
$room = isset($_GET['room']) ? $_GET['room'] : null;

// Pastikan room tidak kosong
if (empty($room)) {
    echo json_encode(['error' => 'No room specified']);
    exit;
}

// Menyiapkan query SQL
$sql = "SELECT item_id, item_name, standard_quantity FROM items";
$result = $conn->query($sql);

if (!$result) {
    echo json_encode(['error' => 'Database query error']);
    exit;
}

// Ambil hasil query
$data = $result->fetch_all(MYSQLI_ASSOC);

// Kirim data sebagai JSON
echo json_encode($data);
