<?php

session_start();
require './config.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require './vendor/autoload.php';

// Fungsi untuk mengirim email verifikasi
function send_verification_email($email, $username)
{
    $mail = new PHPMailer(true);

    try {
        // Konfigurasi server SMTP
        $mail->isSMTP();
        $mail->Host = SMTP_HOST;
        $mail->SMTPAuth = true;
        $mail->Username = SMTP_USERNAME;
        $mail->Password = SMTP_PASSWORD;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = SMTP_PORT;

        // Penerima
        $mail->setFrom(SMTP_FROM_EMAIL, SMTP_FROM_NAME);
        $mail->addAddress($email);

        // Konten email
        $mail->isHTML(true);
        $mail->Subject = 'Verifikasi Akun Anda';
        $mail->Body    = "Halo $username,<br><br>Silakan klik tautan berikut untuk memverifikasi akun Anda:<br><a href='https://web_test.test/verify.php?email=" . urlencode($email) . "'>Verifikasi Akun</a><br><br>Terima kasih!";
        $mail->AltBody = "Halo $username,\n\nSilakan klik tautan berikut untuk memverifikasi akun Anda:\nhttps://web_test.test/verify.php?email=" . urlencode($email) . "\n\nTerima kasih!";

        $mail->send();
    } catch (Exception $e) {
        error_log("Email tidak dapat dikirim. Mailer Error: {$mail->ErrorInfo}");
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $full_name = htmlspecialchars($_POST['full_name']);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $username = htmlspecialchars($_POST['username']);
    $password = $_POST['password'];

    if (filter_var($email, FILTER_VALIDATE_EMAIL) && !empty($full_name) && !empty($username) && !empty($password)) {
        // Cek apakah username atau email sudah digunakan
        $stmt = $conn->prepare('SELECT user_id FROM users WHERE username = ? OR email = ?');
        if ($stmt) {
            $stmt->bind_param('ss', $username, $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows == 0) {
                // Menambahkan pengguna baru dengan email_verified_at sebagai NULL secara default
                $stmt = $conn->prepare('INSERT INTO users (full_name, username, password, email, email_verified_at) VALUES (?, ?, ?, ?, NULL)');
                if ($stmt) {
                    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                    $stmt->bind_param('ssss', $full_name, $username, $hashed_password, $email);
                    $stmt->execute();

                    // Mengirim email verifikasi
                    send_verification_email($email, $username);

                    $_SESSION['success'] = 'Pendaftaran berhasil. Silakan cek email Anda untuk verifikasi akun.';
                    header('Location: halaman-daftar.php');
                    exit();
                } else {
                    $error_message = 'Kesalahan koneksi database.';
                    error_log($error_message . ' ' . $conn->error);
                }
            } else {
                $error_message = 'Username atau email sudah digunakan.';
            }
        } else {
            $error_message = 'Kesalahan koneksi database.';
            error_log($error_message . ' ' . $conn->error);
        }

        if (isset($error_message)) {
            $_SESSION['error'] = $error_message;
            header('Location: halaman-daftar.php');
            exit();
        }
    } else {
        $_SESSION['error'] = 'Data yang dimasukkan tidak valid.';
        header('Location: halaman-daftar.php');
        exit();
    }
}
