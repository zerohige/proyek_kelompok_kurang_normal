<?php
session_start();
include 'config/database.php';

// Periksa apakah admin sudah login
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

// Bagian untuk menambahkan barang
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nama_barang'], $_POST['stok'])) {
    $nama_barang = $conn->real_escape_string(trim($_POST['nama_barang']));
    $stok = intval($_POST['stok']);

    // Periksa apakah barang sudah ada
    $check_query = "SELECT * FROM barang WHERE nama_barang = '$nama_barang'";
    $check_result = $conn->query($check_query);

    if ($check_result && $check_result->num_rows > 0) {
        echo "<script>alert('Barang sudah ada! Tidak bisa menambahkan barang yang sama.'); window.history.back();</script>";
    } else {
        // Jika barang belum ada, tambahkan
        $query = "INSERT INTO barang (nama_barang, stok) VALUES ('$nama_barang', $stok)";
        if ($conn->query($query)) {
            echo "<script>alert('Barang berhasil ditambahkan!'); window.location.href = 'dashboard.php';</script>";
        } else {
            echo "<script>alert('Gagal menambahkan barang: " . $conn->error . "'); window.history.back();</script>";
        }
    }
}

// Ambil data barang tanpa duplikasi
$query_barang = "SELECT DISTINCT * FROM barang";
$result_barang = $conn->query($query_barang);

// Ambil data permintaan barang tanpa duplikasi
$query_permintaan = "SELECT DISTINCT * FROM permintaan_barang";
$result_permintaan = $conn->query($query_permintaan);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="container">
        <h1>Dashboard Admin</h1>
        <nav>
            <ul>
                <li><a href="#manage-items">Manajemen Barang</a></li>
                <li><a href="#requests">Permintaan Barang</a></li>
            </ul>
        </nav>

        <!-- Manajemen Barang -->
        <section id="manage-items">
            <h2>Manajemen Barang</h2>
            <form action="" method="POST">
                <label for="nama_barang">Nama Barang:</label>
                <input type="text" id="nama_barang" name="nama_barang" required>
                <label for="stok">Stok:</label>
                <input type="number" id="stok" name="stok" required>
                <button type="submit">Tambah Barang</button>
            </form>
            <table border="1">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Barang</th>
                        <th>Stok</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result_barang->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['id']) ?></td>
                            <td><?= htmlspecialchars($row['nama_barang']) ?></td>
                            <td><?= htmlspecialchars($row['stok']) ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </section>

        <!-- Permintaan Barang -->
                <section id="requests">
                    <h2>Permintaan Barang</h2>
                    <!-- Tombol Unduh Data Permintaan -->
                    <form action="config/excel.php" method="POST" style="margin-bottom: 20px;">
                        <button type="submit" style="padding: 10px 20px; background-color: #4CAF50; color: white; border: none; border-radius: 5px;">
                            Unduh Semua Data dalam Excel
                        </button>
                    </form>
                    <table border="1">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>ID Pemohon</th>
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
                                    <td><?= htmlspecialchars($row['status']) ?></td>
                                    <td><?= htmlspecialchars($row['catatan_admin']) ?></td>
                                    <td>
                                        <form action="config/update.php" method="POST" style="display:inline;">
                                            <input type="hidden" name="id" value="<?= htmlspecialchars($row['id']) ?>">
                                            <select name="status">
                                                <option value="Pending" <?= $row['status'] == 'Pending' ? 'selected' : '' ?>>Pending</option>
                                                <option value="Disetujui" <?= $row['status'] == 'Disetujui' ? 'selected' : '' ?>>Disetujui</option>
                                                <option value="Ditolak" <?= $row['status'] == 'Ditolak' ? 'selected' : '' ?>>Ditolak</option>
                                            </select>
                                            <input type="text" name="catatan_admin" placeholder="Catatan Admin" value="<?= htmlspecialchars($row['catatan_admin']) ?>">
                                            <button type="submit">Perbarui</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </section>

    </div>
</body>
</html>
