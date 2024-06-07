<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Login</title>
    <link rel="stylesheet" href="./Login2.css">
</head>

<body>
    <?php session_start(); ?>



    <div class="box">

        <span class="borderLine"></span>
        <form action="login.php" method="post">
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
                <input type="text" name="username" required="required">
                <span>Username / Email</span>
                <i></i>
            </div>

            <div class="inputBox">
                <input type="password" name="password" required="required">
                <span>Password</span>
                <i></i>
            </div>


            <div class="links">
                <a href="./forgot-password.php">Forgot Password</a>
                <a href="./halaman-daftar.php">Sign Up</a>
            </div>
            <input type="submit" value="Login">
        </form>
    </div>
</body>

</html>