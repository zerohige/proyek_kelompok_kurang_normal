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

// Bagian untuk menghapus barang
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $delete_id = intval($_POST['delete_id']);
    $delete_query = "DELETE FROM barang WHERE id = $delete_id";
    if ($conn->query($delete_query)) {
        echo "<script>alert('Barang berhasil dihapus!'); window.location.href = 'dashboard.php';</script>";
    } else {
        echo "<script>alert('Gagal menghapus barang: " . $conn->error . "'); window.history.back();</script>";
    }
}

// Ambil data barang
$query_barang = "SELECT * FROM barang";
$result_barang = $conn->query($query_barang);

if (!$result_barang) {
    die("Error dalam query barang: " . $conn->error);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Dashboard Admin</h1>
        <nav class="mb-4">
            <ul class="nav nav-pills justify-content-center">
                <li class="nav-item">
                    <a class="nav-link active" href="#manage-items">Manajemen Barang</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="permintaan.php">Permintaan Barang</a>
                </li>
            </ul>
        </nav>

        <!-- Manajemen Barang -->
        <section id="manage-items" class="mb-5">
            <h2 class="text-center mb-4">Manajemen Barang</h2>
            <form action="" method="POST" class="row g-3">
                <div class="col-md-6">
                    <label for="nama_barang" class="form-label">Nama Barang:</label>
                    <input type="text" id="nama_barang" name="nama_barang" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label for="stok" class="form-label">Stok:</label>
                    <input type="number" id="stok" name="stok" class="form-control" required>
                </div>
                <div class="col-12 text-center">
                    <button type="submit" class="btn btn-success">Tambah Barang</button>
                </div>
            </form>
            <div class="table-responsive mt-4">
                <table class="table table-bordered table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Nama Barang</th>
                            <th>Stok</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result_barang->fetch_assoc()): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['id']) ?></td>
                                <td><?= htmlspecialchars($row['nama_barang']) ?></td>
                                <td><?= htmlspecialchars($row['stok']) ?></td>
                                <td>
                                    <form action="" method="POST" style="display: inline;">
                                        <input type="hidden" name="delete_id" value="<?= htmlspecialchars($row['id']) ?>">
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus barang ini?')">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</body>
</html>