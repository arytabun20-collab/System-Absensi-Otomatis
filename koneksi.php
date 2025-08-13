<?php
// Konfigurasi koneksi ke database
$host = "localhost";    // Nama host database
$user = "root";         // Username database (default XAMPP adalah "root")
$pass = "";             // Password database (default XAMPP kosong)
$db   = "db_absensi";   // Nama database

// Membuat koneksi
$koneksi = mysqli_connect($host, $user, $pass, $db);

// Cek koneksi
if (!$koneksi) {
    die("Koneksi Gagal: " . mysqli_connect_error());
}
?>