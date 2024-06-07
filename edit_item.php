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

require './config.php';

// ambil detail item berdasarkan item_id
if (!isset($_GET['item_id'])) {
    header('Location: select-month.php');
}

$item_id = $_GET['item_id'];

$stmt = $conn->prepare("SELECT * FROM items WHERE item_id = ?");

$stmt->bind_param("i", $item_id);
$stmt->execute();

$result = $stmt->get_result();
$item = $result->fetch_assoc();

$stmt->close();

if (!$item) {
    echo 'Item tidak ditemukan!';
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Ubah Isi Kotak P3K</title>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
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
        <h1>Ubah Isi Kotak P3K</h1>
        <div id="message" style="color: white; margin-bottom: 1rem"></div>
        <form id="itemForm">
            <input type="hidden" name="item_id" value="<?= $item['item_id'] ?>" />
            <input type="text" name="item_name" placeholder="misal: Kassa Steril" required value="<?= $item['item_name'] ?>" />
            <input type="number" name="standard_quantity" placeholder="Jumlah Standar" required value="<?= $item['standard_quantity'] ?>" />
            <button type="submit">Simpan</button>
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

        $(document).ready(function() {
            $('#itemForm').submit(function(e) {
                e.preventDefault();

                $.ajax({
                    url: './update_item.php',
                    method: 'POST',
                    data: $(this).serialize(),
                    dataType: 'json',
                    success: function(response) {
                        $('#message').text(response.message).css('color', response.success ? 'green' : 'red');
                    },
                    error: function() {
                        $('#message').text('An error occurred while processing your request.').css('color', 'red');
                    }
                });
            });
        });
    </script>
</body>

</html>