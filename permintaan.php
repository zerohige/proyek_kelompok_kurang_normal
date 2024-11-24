<?php
session_start();
include 'config/database.php';

// Periksa apakah admin sudah login
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

// Bagian untuk memperbarui status dan catatan permintaan
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_id'])) {
    $update_id = intval($_POST['update_id']);
    $status = $conn->real_escape_string($_POST['status']);
    $catatan_admin = $conn->real_escape_string(trim($_POST['catatan_admin']));

    $update_query = "UPDATE permintaan_barang SET status = '$status', catatan_admin = '$catatan_admin' WHERE id = $update_id";
    if ($conn->query($update_query)) {
        echo "<script>alert('Permintaan berhasil diperbarui!'); window.location.href = 'permintaan.php';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui permintaan: " . $conn->error . "'); window.history.back();</script>";
    }
}

// Bagian untuk menghapus permintaan barang
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $delete_id = intval($_POST['delete_id']);
    $delete_query = "DELETE FROM permintaan_barang WHERE id = $delete_id";
    if ($conn->query($delete_query)) {
        echo "<script>alert('Permintaan berhasil dihapus!'); window.location.href = 'permintaan.php';</script>";
    } else {
        echo "<script>alert('Gagal menghapus permintaan: " . $conn->error . "'); window.history.back();</script>";
    }
}

// Ambil data permintaan barang
$query_permintaan = "SELECT * FROM permintaan_barang";
$result_permintaan = $conn->query($query_permintaan);

if (!$result_permintaan) {
    die("Error dalam query permintaan_barang: " . $conn->error);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Permintaan Barang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="header-container">
        <div class="d-flex align-items-center">
            <!-- Logo Kampus -->
            <img src="assets/gambar/fttk1.png" alt="Logo Kampus" style="max-width: 200px; height: auto;">
            <!-- Nama Kampus -->
            <div class="campus-name">
        </div>
    </div>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Permintaan Barang</h1>
        <nav class="mb-4">
            <ul class="nav nav-pills justify-content-center">
                <li class="nav-item">
                    <a class="nav-link" href="dashboard.php">Dashboard</a>
                    <link rel="stylesheet" href="assets/css/style.css">
                </li>
            </ul>
        </nav>

        <!-- Tombol Unduh PDF -->
        <form action="config/permintaanpdf.php" method="POST" class="mb-4 text-center">
            <button type="submit" class="btn btn-primary">Unduh Semua Permintaan sebagai PDF</button>
        </form>

        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Nama</th>
                        <th>ID</th>
                        <th>Departemen</th>
                        <th>Barang</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Catatan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result_permintaan->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['nama']) ?></td>
                            <td><?= htmlspecialchars($row['id_pemohon']) ?></td>
                            <td><?= htmlspecialchars($row['departemen']) ?></td>
                            <td><?= htmlspecialchars($row['barang']) ?></td>
                            <td><?= htmlspecialchars($row['tanggal']) ?></td>
                            <td>
                                <span class="badge bg-<?= strtolower($row['status']) === 'disetujui' ? 'success' : (strtolower($row['status']) === 'ditolak' ? 'danger' : 'warning') ?>">
                                    <?= htmlspecialchars($row['status']) ?>
                                </span>
                            </td>
                            <td><?= htmlspecialchars($row['catatan_admin']) ?></td>
                            <td>
                                <!-- Form untuk memperbarui status dan catatan -->
                                <form action="" method="POST" class="mb-2">
                                    <input type="hidden" name="update_id" value="<?= htmlspecialchars($row['id']) ?>">
                                    <div class="mb-2">
                                        <select name="status" class="form-select form-select-sm">
                                            <option value="Pending" <?= $row['status'] === 'Pending' ? 'selected' : '' ?>>Pending</option>
                                            <option value="Disetujui" <?= $row['status'] === 'Disetujui' ? 'selected' : '' ?>>Disetujui</option>
                                            <option value="Ditolak" <?= $row['status'] === 'Ditolak' ? 'selected' : '' ?>>Ditolak</option>
                                        </select>
                                    </div>
                                    <div class="mb-2">
                                        <input type="text" name="catatan_admin" class="form-control form-control-sm" placeholder="Catatan Admin" value="<?= htmlspecialchars($row['catatan_admin']) ?>">
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-sm">Perbarui</button>
                                </form>
                                <!-- Form untuk menghapus permintaan -->
                                <form action="" method="POST">
                                    <input type="hidden" name="delete_id" value="<?= htmlspecialchars($row['id']) ?>">
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus permintaan ini?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
