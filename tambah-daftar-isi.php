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
  exit();
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Tambah Daftar Isi Kotak P3K</title>
    <script
      src="https://code.jquery.com/jquery-3.7.1.min.js"
      integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
      crossorigin="anonymous"
    ></script>
    <style>
      * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: sans-serif;
      }

      body {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        background: #23242a;
      }

      .box {
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
      input,
      button {
        width: 100%;
        padding: 10px;
        margin-bottom: 10px;
        background: #333;
        /* Updated background for better visibility */
        border: 2px solid #000000;
        border-radius: 4px;
        color: #ffffff;
        /* Updated text color for better visibility */
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
      }

      h1 {
        color: #fff;
        margin-bottom: 20px;
        text-align: center;
      }
    </style>
  </head>

  <body>
    <div class="box">
      <h1>Tambah Daftar Isi Kotak P3K</h1>
      <div id="message" style="color: white; margin-bottom: 1rem"></div>
      <form id="itemForm">
        <input
          type="text"
          name="item_name"
          placeholder="misal: Kassa Steril"
          required
        />
        <input
          type="number"
          name="standard_quantity"
          placeholder="Jumlah Standar"
          required
        />
        <button type="submit">Tambah</button>
      </form>
      <button onclick="goBack()">Kembali</button>
    </div>
    <script>
      function goBack() {
        if (window.history.length > 1) {
          window.history.back();
        } else {
          window.location.href = "./select-month.php";
        }
      }
      
      $(document).ready(function () {
        $("#itemForm").on("submit", function (e) {
          e.preventDefault(); // Mencegah pengiriman formulir secara default

          $.ajax({
            type: "POST",
            url: "./tambah-daftar.php",
            data: $(this).serialize(),
            success: function (response) {
              $("#message").html(response.message);
              if (response.success) {
                $("#itemForm")[0].reset();
              }
            },
            error: function () {
              $("#message").css("color", "red");
              $("#message").html("Error: Tidak dapat menambahkan item.");
            },
          });
        });
      });
    </script>
  </body>
</html>
