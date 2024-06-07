<?php
session_start();
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (filter_var($username, FILTER_VALIDATE_EMAIL)) {
        $whereCondition = 'email';
    } else {
        $whereCondition = 'username';
    }
    
    $stmt = $conn->prepare("SELECT user_id, full_name, email_verified_at, password FROM users WHERE $whereCondition = ?");
    
    if ($stmt) {
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();

            if(!$row['email_verified_at']) {
                $_SESSION['error'] = 'Akun belum diverifikasi. Silakan cek email Anda.';
                header('Location: halaman-login.php');
                exit();
            }

            if (password_verify($password, $row['password'])) {
                $_SESSION['user_id'] = $row['user_id'];
                $_SESSION['full_name'] = $row['full_name'];
                $_SESSION['authCheck'] = true;
                $_SESSION['login_time'] = time();
                header('Location: select-month.php');
                exit();
            } else {
                $_SESSION['error'] = 'Username atau Password salah';
                header('Location: halaman-login.php');
                exit();
            }
        } else {
            $_SESSION['error'] = 'Username atau Password salah';
            header('Location: halaman-login.php');
            exit();
        }
    } else {
        $_SESSION['error'] = 'Kesalahan koneksi database.';
        header('Location: halaman-login.php');
        exit();
    }
}
