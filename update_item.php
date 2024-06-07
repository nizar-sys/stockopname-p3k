<?php

require './config.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $item_id = $_POST['item_id'];
    $item_name = $_POST['item_name'];
    $standard_quantity = $_POST['standard_quantity'];

    // Memeriksa apakah input tidak kosong
    if (!empty($item_name) && !empty($standard_quantity)) {
        // Menyiapkan dan menjalankan query SQL dengan parameterized query untuk mencegah SQL Injection
        $stmt = $conn->prepare("INSERT INTO items (item_id, item_name, standard_quantity) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE item_name = VALUES(item_name), standard_quantity = VALUES(standard_quantity)");
        $stmt->bind_param("isi", $item_id, $item_name, $standard_quantity);

        if ($stmt->execute()) {
            $response = ['success' => true, 'message' => 'Item berhasil diperbarui!'];
        } else {
            $response = ['success' => false, 'message' => 'Error: ' . $stmt->error];
        }

        $stmt->close();
    } else {
        $response = ['success' => false, 'message' => 'Semua field harus diisi!'];
    }

    $conn->close();
} else {
    $response = ['success' => false, 'message' => 'Invalid request method'];
}

echo json_encode($response);
