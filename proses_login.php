<?php
session_start();
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = mysqli_real_escape_string($koneksi, $_POST['password']);

    // --- Coba Login sebagai Admin DULU ---
    $sql_admin = "SELECT * FROM tb_admin WHERE username = '$username'";
    $hasil_admin = mysqli_query($koneksi, $sql_admin);

    if ($hasil_admin && mysqli_num_rows($hasil_admin) > 0) {
        $data_admin = mysqli_fetch_assoc($hasil_admin);
        
        // Verifikasi password admin sebagai teks biasa (tanpa hash)
        if ($password == $data_admin['password']) {
            // Jika berhasil, buat session admin dan arahkan ke admin.php
            $_SESSION['id'] = $data_admin['id'];
            $_SESSION['username'] = $data_admin['username'];
            $_SESSION['role'] = 'admin';
            header("Location: admin.php");
            exit(); 
        }
    }

    // --- Jika BUKAN Admin, Coba Login sebagai Mahasiswa ---
    $sql_mahasiswa = "SELECT * FROM tb_mahasiswa WHERE nama = '$username' AND nim = '$password'";
    $hasil_mahasiswa = mysqli_query($koneksi, $sql_mahasiswa);

    if ($hasil_mahasiswa && mysqli_num_rows($hasil_mahasiswa) > 0) {
        $data_mahasiswa = mysqli_fetch_assoc($hasil_mahasiswa);
        $_SESSION['id'] = $data_mahasiswa['id'];
        $_SESSION['nama'] = $data_mahasiswa['nama'];
        $_SESSION['nim'] = $data_mahasiswa['nim'];
        $_SESSION['role'] = 'mahasiswa';
        header("Location: index.php");
        exit();
    }

    // --- Jika Keduanya Gagal ---
    // DIUBAH: Pesan error dibuat lebih deskriptif
    $_SESSION['error'] = "Login gagal. Username atau Password Anda belum terdaftar.";
    header("Location: login.php");
    exit();
}
?>