<?php
include 'config.php';

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data)) {
    $date = $data['date'];
    $month = $data['month'];
    $year = $data['year'];
    $room = $data['room'];
    $items = $data['items'];

    // Mendapatkan ID ruangan berdasarkan nama ruangan
    $roomId = $conn->query("SELECT room_id FROM rooms WHERE room_name = '$room'")->fetch_assoc()['room_id'];

    foreach ($items as $item) {
        $item_id = $item['item_id'];
        $actual_quantity = $item['actual_quantity'];
        $missing_quantity = $item['missing_quantity'];

        // Cek apakah sudah ada catatan untuk item ini pada bulan dan tahun yang diberikan
        $existingRecord = $conn->query("SELECT record_id FROM checklist_records WHERE period_id = '$date-$month-$year' AND room_id = '$roomId' AND item_id = '$item_id'")->fetch_assoc();

        if ($existingRecord) {
            // Jika ada, lakukan update pada catatan tersebut
            $record_id = $existingRecord['record_id'];
            $updateSql = "UPDATE checklist_records SET actual_quantity = ?, missing_quantity = ? WHERE record_id = ?";
            $updateStmt = $conn->prepare($updateSql);

            if ($updateStmt) {
                $updateStmt->bind_param("iii", $actual_quantity, $missing_quantity, $record_id);
                $updateStmt->execute();
            } else {
                http_response_code(500);
                echo json_encode(array("error" => "Failed to prepare update SQL statement"));
                exit();
            }
        } else {
            // Jika tidak ada, lakukan insert untuk item ini
            $insertSql = "INSERT INTO checklist_records (record_id, period_id, room_id, item_id, actual_quantity, missing_quantity)
                VALUES (NULL, '$date-$month-$year', '$roomId', ?, ?, ?)";
            $insertStmt = $conn->prepare($insertSql);

            if ($insertStmt) {
                $insertStmt->bind_param("iii", $item_id, $actual_quantity, $missing_quantity);
                $insertStmt->execute();
            } else {
                http_response_code(500);
                echo json_encode(array("error" => "Failed to prepare insert SQL statement"));
                exit();
            }
        }
    }
    echo json_encode(array("message" => "Data saved successfully"));
} else {
    http_response_code(400);
    echo json_encode(array("error" => "No data received"));
}
