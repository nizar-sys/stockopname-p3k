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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih Bulan dan Tahun Pengecekan Kotak P3K</title>
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
        <h1>Pilih Bulan dan Tahun Pengecekan Kotak P3K</h1>
        <input list="dateOptions" id="dateSelect" placeholder="Enter or select date">
        <datalist id="dateOptions">
            <!-- Years dynamically generated -->
        </datalist>
        <select id="monthSelect">
            <option value="January">January</option>
            <option value="February">February</option>
            <option value="March">March</option>
            <option value="April">April</option>
            <option value="May">May</option>
            <option value="June">June</option>
            <option value="July">July</option>
            <option value="August">August</option>
            <option value="September">September</option>
            <option value="October">October</option>
            <option value="November">November</option>
            <option value="December">December</option>
        </select>
        <input list="yearOptions" id="yearInput" placeholder="Enter or select a year">
        <datalist id="yearOptions">
            <!-- Years dynamically generated -->
        </datalist>
        <button onclick="goToRoomSelection()">Lanjut ke Pemilihan Lokasi/Ruangan</button>
        <button onclick="goBack()">Back</button>


    </div>
    <script>
        function goBack() {
            window.location.href = 'halaman-login.php';
        }

        function generateYears() {
            const yearOptions = document.getElementById('yearOptions');
            const currentYear = new Date().getFullYear() + 500;
            const startYear = 1900;

            for (let year = currentYear; year >= startYear; year--) {
                const option = document.createElement('option');
                option.value = year;
                yearOptions.appendChild(option);
            }
        }

        function generateDate() {
            const dateSelect = document.getElementById('dateOptions');

            for (let day = 1; day <= 31; day++) {
                const option = document.createElement('option');
                option.value = day;
                option.textContent = day;
                dateSelect.appendChild(option);
            }
        }

        function goToRoomSelection() {
            const selectedDate = document.getElementById('dateSelect').value;
            const selectedMonth = document.getElementById('monthSelect').value;
            const selectedYear = document.getElementById('yearInput').value;

            // Memeriksa apakah bulan dan tahun telah dipilih
            if (!selectedMonth || !selectedYear || !selectedDate) {
                alert('Silakan pilih tanggal, bulan dan tahun terlebih dahulu');
                return; // Menghentikan fungsi jika tidak ada bulan/tahun yang dipilih
            }
            
            window.location.href = `select-room.php?date=${selectedDate}&month=${selectedMonth}&year=${selectedYear}`;
        }

        document.getElementById('yearInput').addEventListener('input', function() {
            if (this.value.length > 4) {
                this.value = this.value.slice(0, 4);
            }
        });

        document.getElementById('dateSelect').addEventListener('input', function() {
            if (this.value.length > 2) {
                this.value = this.value.slice(0, 2);
            }

            if (this.value > 31) {
                this.value = 31;
            }
        });


        window.onload = function() {
            generateDate();
            generateYears();
        };
    </script>
</body>

</html>