<?php
session_start();
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $nim = mysqli_real_escape_string($koneksi, $_POST['nim']);

    // Cek apakah NIM sudah terdaftar
    $sql_cek = "SELECT nim FROM tb_mahasiswa WHERE nim = '$nim'";
    $hasil_cek = mysqli_query($koneksi, $sql_cek);

    if (mysqli_num_rows($hasil_cek) > 0) {
        $_SESSION['error'] = "NIM sudah terdaftar. Silakan gunakan NIM lain atau login.";
        header("Location: daftar.php");
        exit();
    }

    // Insert data mahasiswa baru
    $sql = "INSERT INTO tb_mahasiswa (nama, nim) VALUES ('$nama', '$nim')";

    // --- BAGIAN PENTING ADA DI SINI ---
    if (mysqli_query($koneksi, $sql)) {
        // 1. Membuat notifikasi sukses di dalam session
        $_SESSION['pesan'] = "Pendaftaran berhasil! Silakan login.";

        // 2. Mengarahkan pengguna kembali ke halaman login
        header("Location: login.php");
        exit();
    } else {
        $_SESSION['error'] = "Terjadi kesalahan. Silakan coba lagi.";
        header("Location: daftar.php");
        exit();
    }
}
?>