<?php
session_start();
// Cek apakah pengguna sudah login dan rolenya adalah mahasiswa
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'mahasiswa') {
    // Jika tidak, redirect ke halaman login
    header("Location: login.php");
    exit();
}
// Ambil data dari session
$nama_mahasiswa = $_SESSION['nama'];
$nim_mahasiswa = $_SESSION['nim'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Absensi Mahasiswa</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <div class="header-nav">
            <span>Selamat Datang, <strong><?php echo htmlspecialchars($nama_mahasiswa); ?></strong>!</span>
            <a href="logout.php" class="btn-logout">Logout</a>
        </div>
        
        <h1>Form Absensi Mahasiswa</h1>
        <p style="text-align: center;">
            Tanggal Hari Ini: <strong><?php echo date('d F Y'); ?></strong>
        </p>
        
      
        
        <form action="proses_absensi.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="nama">Nama Lengkap:</label>
                <input type="text" id="nama" name="nama" value="<?php echo htmlspecialchars($nama_mahasiswa); ?>" readonly>
            </div>
            <div class="form-group">
                <label for="nim">NIM:</label>
                <input type="text" id="nim" name="nim" value="<?php echo htmlspecialchars($nim_mahasiswa); ?>" readonly>
            </div>
            <div class="form-group">
                <label for="nama_kampus">Nama Kampus:</label>
                <input type="text" id="nama_kampus" name="nama_kampus" required>
            </div>
            <div class="form-group">
                <label for="foto">Upload Foto Selfie:</label>
                <input type="file" id="foto" name="foto" accept="image/*" required>
            </div>
            <div class="button-group">
                <button type="submit" name="aksi" value="masuk" class="btn btn-masuk">ABSEN MASUK</button>
                <button type="submit" name="aksi" value="pulang" class="btn btn-pulang">ABSEN PULANG</button>
            </div>
        </form>
    </div>
</body>
</html>