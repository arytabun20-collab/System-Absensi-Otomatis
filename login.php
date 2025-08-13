<?php session_start(); ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="login-box">
        <div class="logo-container">
            <img src="uploads/logo.png" alt="Logo" class="logo">
        </div>

        <div class="login-header">
            <p>Halaman Login</p>
        </div>
        
        <?php
        if (isset($_SESSION['error'])) {
            echo "<p class='pesan-error'>" . $_SESSION['error'] . "</p>";
            unset($_SESSION['error']);
        }
        ?>

        <form action="proses_login.php" method="post">
            <div class="input-group">
                <input type="text" name="username" placeholder="Nama Lengkap" required>
                <i class="fas fa-user input-icon"></i>
            </div>
            <div class="input-group">
                <input type="password" name="password" placeholder="NIM" id="kataSandi" required>
                <i class="fas fa-lock input-icon"></i>
            </div>
            <div class="options-row">
                <label class="checkbox-container">
                    <input type="checkbox" id="tampilkanSandi">
                    Tampilkan kata sandi
                </label>
            </div>
            <button type="submit" class="btn-login">Masuk</button>
        </form>

        <div class="login-footer">
            <p class="auth-link">Belum punya akun? <a href="daftar.php">Daftar disini</a></p>
        </div>
    </div>

    <script>
        // Ambil elemen checkbox dan input password berdasarkan ID-nya
        const tampilkanSandiCheckbox = document.getElementById('tampilkanSandi');
        const kataSandiInput = document.getElementById('kataSandi');

        // Tambahkan event listener saat checkbox diubah (dicentang/tidak)
        tampilkanSandiCheckbox.addEventListener('change', function() {
            // Jika checkbox dicentang, ubah tipe input menjadi 'text'
            if (this.checked) {
                kataSandiInput.type = 'text';
            } else {
                // Jika tidak, kembalikan menjadi 'password'
                kataSandiInput.type = 'password';
            }
        });
    </script>
    </body>
</html>