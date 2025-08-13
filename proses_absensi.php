<?php
session_start();
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $nim = mysqli_real_escape_string($koneksi, $_POST['nim']);
    $nama_kampus = mysqli_real_escape_string($koneksi, $_POST['nama_kampus']);
    $aksi = $_POST['aksi'];
    $tanggal_sekarang = date('Y-m-d');

    // Kita tidak lagi perlu variabel $waktu_sekarang dari PHP
    // $waktu_sekarang = date('Y-m-d H:i:s'); <-- Baris ini bisa dihapus

    // Proses Upload Foto
    $foto_nama = $_FILES['foto']['name'];
    $foto_tmp = $_FILES['foto']['tmp_name'];
    $upload_dir = "uploads/";
    $foto_path = $upload_dir . time() . '_' . $foto_nama;

    if (move_uploaded_file($foto_tmp, $foto_path)) {
        if ($aksi == 'masuk') {
            $sql_cek = "SELECT id FROM tb_absensi WHERE nim = '$nim' AND DATE(waktu_masuk) = '$tanggal_sekarang'";
            $hasil_cek = mysqli_query($koneksi, $sql_cek);

            if (mysqli_num_rows($hasil_cek) > 0) {
                $_SESSION['error'] = "Anda sudah melakukan absen masuk hari ini.";
            } else {
                // DIUBAH: Gunakan NOW() dari SQL untuk mengisi waktu_masuk
                $sql = "INSERT INTO tb_absensi (nama, nim, nama_kampus, foto_masuk, waktu_masuk) VALUES ('$nama', '$nim', '$nama_kampus', '$foto_path', NOW())";
                if (mysqli_query($koneksi, $sql)) {
                    $_SESSION['pesan'] = "Absen masuk berhasil direkam!";
                } else {
                    $_SESSION['error'] = "Error: " . $sql . "<br>" . mysqli_error($koneksi);
                }
            }
        } elseif ($aksi == 'pulang') {
            $sql_cek = "SELECT id FROM tb_absensi WHERE nim = '$nim' AND DATE(waktu_masuk) = '$tanggal_sekarang' AND waktu_pulang IS NULL";
            $hasil_cek = mysqli_query($koneksi, $sql_cek);

            if (mysqli_num_rows($hasil_cek) > 0) {
                $data = mysqli_fetch_assoc($hasil_cek);
                $id_absensi = $data['id'];

                // DIUBAH: Gunakan NOW() dari SQL untuk mengisi waktu_pulang
                $sql = "UPDATE tb_absensi SET foto_pulang = '$foto_path', waktu_pulang = NOW() WHERE id = '$id_absensi'";
                 if (mysqli_query($koneksi, $sql)) {
                    $_SESSION['pesan'] = "Absen pulang berhasil direkam!";
                } else {
                    $_SESSION['error'] = "Error: " . $sql . "<br>" . mysqli_error($koneksi);
                }
            } else {
                $_SESSION['error'] = "Anda belum melakukan absen masuk hari ini atau sudah absen pulang.";
            }
        }
    } else {
        $_SESSION['error'] = "Gagal mengupload foto.";
    }

    header("Location: index.php");
    exit();
}
?>