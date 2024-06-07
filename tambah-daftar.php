<?php
require './config.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $item_name = $_POST['item_name'];
    $standard_quantity = $_POST['standard_quantity'];

    $response = [];

    // Memeriksa apakah input tidak kosong
    if (!empty($item_name) && !empty($standard_quantity)) {
        // Menyiapkan dan menjalankan query SQL dengan parameterized query untuk mencegah SQL Injection
        $stmt = $conn->prepare("INSERT INTO items (item_name, standard_quantity) VALUES (?, ?)");
        $stmt->bind_param("si", $item_name, $standard_quantity);

        if ($stmt->execute()) {
            $response['success'] = true;
            $response['message'] = 'Item berhasil ditambahkan!';
        } else {
            $response['success'] = false;
            $response['message'] = 'Error: ' . $stmt->error;
        }

        $stmt->close();
    } else {
        $response['success'] = false;
        $response['message'] = 'Semua field harus diisi!';
    }

    $conn->close();
    echo json_encode($response);
} else {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
