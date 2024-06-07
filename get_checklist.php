<?php
require 'config.php';

$period = $_GET['period'] ?? null;
$room = $_GET['room'] ?? null;

if (!$period || !$room) {
    echo json_encode(["error" => "Missing period or room parameter"]);
    exit;
}

// Query untuk mengambil id ruangan dengan parameterized query
$query = "SELECT room_id FROM rooms WHERE room_name=?";
$stmt = $conn->prepare($query);
if (!$stmt) {
    echo json_encode(["error" => "Error preparing statement: " . $conn->error]);
    exit;
}

$stmt->bind_param("s", $room);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo json_encode(["error" => "Room not found"]);
    exit;
}

$room_id = $result->fetch_assoc()['room_id'];

// Query untuk mengambil checklist
$query_checklist = "SELECT * FROM checklist_records WHERE period_id=? AND room_id=?";
$stmt_checklist = $conn->prepare($query_checklist);
if (!$stmt_checklist) {
    echo json_encode(["error" => "Error preparing statement: " . $conn->error]);
    exit;
}

$stmt_checklist->bind_param("si", $period, $room_id);
$stmt_checklist->execute();
$result_checklist = $stmt_checklist->get_result();

if (!$result_checklist) {
    echo json_encode(["error" => "Error executing query: " . $conn->error]);
    exit;
}

$checklist = $result_checklist->fetch_all(MYSQLI_ASSOC);
echo json_encode($checklist);
