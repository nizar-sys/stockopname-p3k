<?php
include 'config.php';  

$username = "admin";       
$password = "";  
$full_name = "test";     

// Hash password
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// SQL untuk memasukkan user
$sql = "INSERT INTO users (username, password, full_name) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $username, $hashed_password, $full_name);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo "User berhasil ditambahkan!";
} else {
    echo "Error: " . $conn->error;
}

$stmt->close();
$conn->close();

