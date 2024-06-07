<?php
session_start();

require './config.php';

// jika tidak ada token
if (!isset($_GET['token']) || !isset($_GET['user_id'])) {
    $_SESSION['error'] = 'Token tidak valid.';
    header('Location: forgot-password.php');
    exit();
}

// reset password
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $password = $_POST['password'];
    $password2 = $_POST['password2'];

    if ($password != $password2) {
        $_SESSION['error'] = 'Password tidak sama.';
        echo '<script>alert("Password tidak sama.")</script>';
    } else {
        $user_id = $_GET['user_id'];

        $stmt = $conn->prepare('UPDATE users SET password = ? WHERE user_id = ?');
        if ($stmt) {
            $password = password_hash($password, PASSWORD_DEFAULT);
            $stmt->bind_param('si', $password, $user_id);
            $stmt->execute();

            echo '<script>alert("Password berhasil direset.")</script>';
            
            header('refresh:1;url=halaman-login.php');
        } else {
            $_SESSION['error'] = 'Kesalahan koneksi database.';
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Reset Password</title>
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
            <div class="inputBox">
                <input type="password" name="password" required="required">
                <span>New Password</span>
                <i></i>
            </div>

            <div class="inputBox">
                <input type="password" name="password2" required="required">
                <span>Confirm Password</span>
                <i></i>
            </div>
            <button>Reset Password</button>
        </form>
    </div>
</body>

</html>