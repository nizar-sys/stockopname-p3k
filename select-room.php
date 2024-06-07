<?php
session_start();

if (!isset($_SESSION['authCheck'])) {
  header('Location: halaman-login.php');
  exit;
}

if (isset($_SESSION['login_time']) && (time() - $_SESSION['login_time'] > 900)) {
  // 900 seconds = 15 minutes
  // Expire the session
  session_unset();
  session_destroy();
  header('Location: halaman-login.php');
  exit;
}

require './config.php';

// Membuat query untuk mendapatkan data ruangan
$sql = "SELECT * FROM rooms";
$result = $conn->query($sql);

// Memeriksa apakah query berhasil
if (!$result) {
  die('Error: ' . $conn->error);
}

// Mengambil semua baris hasil query ke dalam array asosiatif
$rooms = $result->fetch_all(MYSQLI_ASSOC);

// Menutup koneksi database karena sudah tidak digunakan lagi
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Pilih Ruangan untuk Pengecekan Kotak P3K</title>
  <style>
    body {
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      background: #23242a;
      font-family: sans-serif;
      padding: 0;
      margin: 0;
    }

    .input-wrapper {
      position: relative;
      width: 380px;
      height: 420px;
      background: #1c1c1c;
      border-radius: 8px;
      overflow: hidden;
      padding: 50px 40px;
      box-sizing: border-box;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
    }

    select,
    button {
      width: 100%;
      padding: 10px;
      margin-bottom: 10px;
      background: #333;
      /* Consistent background */
      border: 2px solid #000;
      border-radius: 4px;
      color: #ffffff;
      /* Text color for visibility */
      outline: none;
    }

    select option {
      background: #333;
      /* Ensure dropdown options are also visible */
      color: #ffffff;
    }

    button {
      background: #572d64;
      border: none;
      cursor: pointer;
      color: white;
      padding: 10px;
      border-radius: 4px;
    }

    h1 {
      color: #fff;
      margin-bottom: 20px;
      text-align: center;
    }
  </style>
</head>

<body>
  <div class="input-wrapper">
    <h1>Pilih Ruangan untuk Pengecekan Kotak P3K</h1>
    <select id="roomSelect">
      <?php foreach ($rooms as $room) : ?>
        <option value="<?php echo htmlspecialchars($room['room_name']); ?>">
          <?php echo htmlspecialchars($room['room_name']); ?>
        </option>
      <?php endforeach; ?>
    </select>
    <button onclick="goToForm()">Go to Form</button>
    <button onclick="goBack()">Back</button>
  </div>
  <script>
    function goToForm() {
      var selectedDate = new URLSearchParams(window.location.search).get(
        "date"
      );
      
      var selectedMonth = new URLSearchParams(window.location.search).get(
        "month"
      );
      var selectedYear = new URLSearchParams(window.location.search).get(
        "year"
      );
      var selectedRoom = document.getElementById("roomSelect").value;
      
      window.location.href = `halaman-isi.php?date=${selectedDate}&month=${selectedMonth}&year=${selectedYear}&room=${selectedRoom}`;
    }

    function goBack() {
      window.location.href = "select-month.php";
    }
  </script>
</body>

</html>