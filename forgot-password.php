<?php
session_start();
require './config.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require './vendor/autoload.php';

// Fungsi untuk mengirim email reset password
function send_reset_email($email, $token, $user_id)
{
    $mail = new PHPMailer(true);
    $appUrl = APP_URL;

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
        $mail->Subject = 'Reset Password Anda';

        // Gunakan htmlspecialchars untuk menghindari XSS
        $encoded_token = urlencode($token);

        $mail->Body = "Klik <a href='$appUrl/reset-password.php?token=$encoded_token&user_id=$user_id'>tautan ini</a> untuk mereset password Anda.";
        $mail->AltBody = "Klik tautan ini untuk mereset password Anda: $appUrl/reset-password.php?token=$encoded_token&user_id=$user_id";

        $mail->send();
    } catch (Exception $e) {
        error_log("Email tidak dapat dikirim. Mailer Error: {$mail->ErrorInfo}");
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Cek apakah email terdaftar
        $stmt = $conn->prepare('SELECT user_id FROM users WHERE email = ?');
        if ($stmt) {
            $stmt->bind_param('s', $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows == 1) {
                $user = $result->fetch_assoc();
                $user_id = $user['user_id'];

                // Buat token reset password
                $token = bin2hex(random_bytes(32));

                // Mengirim email reset password
                send_reset_email($email, $token, $user_id);

                $_SESSION['success'] = 'Silakan cek email Anda untuk instruksi reset password.';
            } else {
                $error_message = 'Email tidak terdaftar.';
            }
        } else {
            $error_message = 'Kesalahan koneksi database.';
            error_log($error_message . ' ' . $conn->error);
        }

        if (isset($error_message)) {
            $_SESSION['error'] = $error_message;
        }
        header('Location: forgot-password.php');
        exit();
    } else {
        $_SESSION['error'] = 'Email yang dimasukkan tidak valid.';
        header('Location: forgot-password.php');
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Lupa Password</title>
    <link rel="stylesheet" href="./Login2.css">
    <style>
        .box form button {
            border: none;
            outline: none;
            padding: 9px 25px;
            background: #fff;
            cursor: pointer;
            font-size: 0.9em;
            border-radius: 4px;
            font-weight: 600;
            margin-top: 3rem;
        }

        .box form button:active {
            opacity: 0.8;
        }
    </style>
</head>

<body>

    <div class="box">

        <span class="borderLine"></span>
        <form action="" method="post">
            <h2>Sistem Informasi Pengecekan Kotak P3K </h2>
            <br>
            <h3>PT. ABC</h3>
            <?php if (isset($_SESSION['success'])) : ?>
                <div class="inputBox">
                    <p style="color: green;"> <?php echo $_SESSION['success']; ?> </p>
                    <?php unset($_SESSION['success']); ?>
                </div>
            <?php endif; ?>
            <?php if (isset($_SESSION['error'])) : ?>
                <div class="inputBox">
                    <p style="color: red;"> <?php echo $_SESSION['error']; ?> </p>
                    <?php unset($_SESSION['error']); ?>
                </div>
            <?php endif; ?>
            <div class="inputBox">
                <input type="email" name="email" required="required">
                <span>Email</span>
                <i></i>
            </div>
            <button>Reset Password</button>
        </form>
    </div>
</body>

</html>