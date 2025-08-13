<?php session_start(); ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Daftar</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="login-box">
        <div class="logo-container">
            <img src="uploads/logo.png" alt="Logo" class="logo">
        </div>

        <div class="login-header">
            <p>Halaman Pendaftaran Mahasiswa</p>
        </div>
        
        <?php
        if (isset($_SESSION['error'])) {
            echo "<p class='pesan-error'>" . $_SESSION['error'] . "</p>";
            unset($_SESSION['error']);
        }
        ?>

        <form action="proses_daftar.php" method="post">
            <div class="input-group">
                <input type="text" name="nama" placeholder="Nama Lengkap" required>
                <i class="fas fa-user input-icon"></i>
            </div>
            <div class="input-group">
                <input type="text" name="nim" placeholder="NIM " required>
                <i class="fas fa-id-card input-icon"></i>
            </div>
            <button type="submit" class="btn-login">Daftar</button>
        </form>

        <div class="login-footer">
            <p class="auth-link">Sudah punya akun? <a href="login.php">Login disini</a></p>
        </div>
    </div>
</body>
</html>