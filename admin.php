<?php
session_start();
// Cek apakah pengguna sudah login dan rolenya adalah admin
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    // Jika tidak, redirect ke halaman login
    header("Location: login.php");
    exit();
}

include 'koneksi.php';

// Logika untuk update status
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_status'])) {
    $id_absensi = $_POST['id_absensi'];
    $keterangan = $_POST['keterangan'];

    $sql_update = "UPDATE tb_absensi SET keterangan = '$keterangan' WHERE id = '$id_absensi'";
    mysqli_query($koneksi, $sql_update);
    header("Location: admin.php");
    exit();
}

// Ambil semua data absensi
$sql = "SELECT * FROM tb_absensi ORDER BY waktu_masuk DESC";
$hasil = mysqli_query($koneksi, $sql);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Rekap Absensi</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container" style="max-width: 1200px;">
        <div class="header-nav">
            <span>Selamat Datang, Admin <strong><?php echo htmlspecialchars($_SESSION['username']); ?></strong>!</span>
            <a href="logout.php" class="btn-logout">Logout</a>
        </div>
        
        <h2>Rekap Absensi Mahasiswa</h2>
        
        <table class="admin-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>NIM</th>
                    <th>Foto Masuk</th>
                    <th>Waktu Masuk</th>
                    <th>Foto Pulang</th>
                    <th>Waktu Pulang</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($hasil) > 0): ?>
                    <?php $no = 1; ?>
                    <?php while($data = mysqli_fetch_assoc($hasil)): ?>
                    <tr>
                        <td><?php echo $no++; ?></td>
                        <td><?php echo htmlspecialchars($data['nama']); ?></td>
                        <td><?php echo htmlspecialchars($data['nim']); ?></td>
                        <td>
                            <?php if ($data['foto_masuk']): ?>
                                <a href="<?php echo $data['foto_masuk']; ?>" target="_blank">
                                    <img src="<?php echo $data['foto_masuk']; ?>" alt="Foto Masuk" style="width: 80px; height: auto;">
                                </a>
                            <?php endif; ?>
                        </td>
                        <td><?php echo date('d-m-Y H:i:s', strtotime($data['waktu_masuk'])); ?></td>
                        <td>
                            <?php if ($data['foto_pulang']): ?>
                                 <a href="<?php echo $data['foto_pulang']; ?>" target="_blank">
                                    <img src="<?php echo $data['foto_pulang']; ?>" alt="Foto Pulang" style="width: 80px; height: auto;">
                                </a>
                            <?php else: ?>
                                -
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ($data['waktu_pulang']): ?>
                                <?php echo date('d-m-Y H:i:s', strtotime($data['waktu_pulang'])); ?>
                            <?php else: ?>
                                -
                            <?php endif; ?>
                        </td>
                        <td>
                            <form action="admin.php" method="POST" style="display: flex; gap: 5px;">
                                <input type="hidden" name="id_absensi" value="<?php echo $data['id']; ?>">
                                <select name="keterangan" style="padding: 5px;">
                                    <option value="Hadir" <?php echo ($data['keterangan'] == 'Hadir') ? 'selected' : ''; ?>>Hadir</option>
                                    <option value="Sakit" <?php echo ($data['keterangan'] == 'Sakit') ? 'selected' : ''; ?>>Sakit</option>
                                    <option value="Izin" <?php echo ($data['keterangan'] == 'Izin') ? 'selected' : ''; ?>>Izin</option>
                                    <option value="Alpa" <?php echo ($data['keterangan'] == 'Alpa') ? 'selected' : ''; ?>>Alpa</option>
                                </select>
                                
                            </form>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8" style="text-align: center;">Belum ada data absensi.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        </div>
</body>
</html>