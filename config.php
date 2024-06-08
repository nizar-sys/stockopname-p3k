<?php
$servername = "localhost";
$username = "root";  // Nama user
$password = "";  // Password
$database = "web_test";

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $database);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

define('SMTP_HOST', 'smtp.gmail.com');
define('SMTP_USERNAME', 'nizarid04@gmail.com');
define('SMTP_PASSWORD', 'eanfhxvdcjpgmapk');
define('SMTP_PORT', 587);
define('SMTP_FROM_EMAIL', 'no-reply@example.com');
define('SMTP_FROM_NAME', 'Admin web P3K');
define('APP_URL', 'http://localhost/web_test');

error_reporting(E_ALL);
ini_set("display_errors", 1);
