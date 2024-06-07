<?php
session_start();

// Validasi email
if (!isset($_GET['email']) || !filter_var($_GET['email'], FILTER_VALIDATE_EMAIL)) {
    $_SESSION['error'] = 'Email tidak valid';
    header('Location: halaman-login.php');
    exit();
}

require './config.php';

$email = $_GET['email'];

$stmt = $conn->prepare('SELECT user_id, email, email_verified_at FROM users WHERE email = ?');

if ($stmt) {
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();

        if ($row['email_verified_at'] == NULL) {
            // Gunakan fungsi NOW() dari MySQL untuk mendapatkan waktu saat ini langsung dari server basis data
            $stmt = $conn->prepare('UPDATE users SET email_verified_at = NOW() WHERE email = ?');
            if ($stmt) {
                $stmt->bind_param('s', $email);
                $stmt->execute();
                $_SESSION['success'] = 'Email berhasil diverifikasi. Silakan login.';
            } else {
                handleDatabaseError();
            }
        } else {
            $_SESSION['error'] = 'Email sudah diverifikasi.';
        }
    } else {
        $_SESSION['error'] = 'Email tidak valid';
    }
} else {
    handleDatabaseError();
}

header('Location: halaman-login.php');
exit();

// Fungsi untuk menangani kesalahan koneksi database
function handleDatabaseError()
{
    $_SESSION['error'] = 'Kesalahan koneksi database.';
    header('Location: halaman-login.php');
    exit();
}
