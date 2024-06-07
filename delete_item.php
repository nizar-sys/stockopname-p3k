<?php
require './config.php';

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $item_id = $data['item_id'];
    $response = [];

    // Memeriksa apakah item_id tidak kosong
    if (!empty($item_id)) {
        // Menyiapkan dan menjalankan query SQL dengan parameterized query untuk mencegah SQL Injection
        $stmt = $conn->prepare("DELETE FROM items WHERE item_id = ?");
        $stmt->bind_param("i", $item_id);

        if ($stmt->execute()) {
            $response['success'] = true;
            $response['message'] = 'Item berhasil dihapus!';
        } else {
            $response['success'] = false;
            $response['message'] = 'Error: ' . $stmt->error;
        }

        $stmt->close();
    } else {
        $response['success'] = false;
        $response['message'] = 'Item ID harus diisi!';
    }

    $conn->close();
    echo json_encode($response);
} else {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
