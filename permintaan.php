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

    // Ambil data barang yang diminta
    $query = "SELECT barang, jumlah FROM permintaan_barang WHERE id = $update_id";
    $result = $conn->query($query);
    if ($result && $row = $result->fetch_assoc()) {
        $barang = $row['barang'];
        $jumlah = $row['jumlah'];
        
        // Cek apakah status permintaan menjadi Disetujui
        if ($status === 'Disetujui') {
            // Ambil stok barang yang tersedia
            $stok_query = "SELECT stok FROM barang WHERE nama_barang = '$barang'";
            $stok_result = $conn->query($stok_query);
            if ($stok_result && $stok_row = $stok_result->fetch_assoc()) {
                $stok_tersedia = $stok_row['stok'];

                // Pastikan stok cukup
                if ($stok_tersedia >= $jumlah) {
                    // Update stok barang
                    $new_stok = $stok_tersedia - $jumlah;
                    $update_stok_query = "UPDATE barang SET stok = $new_stok WHERE nama_barang = '$barang'";
                    if ($conn->query($update_stok_query)) {
                        // Update status permintaan dan catatan admin
                        $update_query = "UPDATE permintaan_barang SET status = '$status', catatan_admin = '$catatan_admin' WHERE id = $update_id";
                        if ($conn->query($update_query)) {
                            echo "<script>alert('Permintaan berhasil diperbarui dan stok berhasil diperbarui!'); window.location.href = 'permintaan.php';</script>";
                        } else {
                            echo "<script>alert('Gagal memperbarui permintaan: " . $conn->error . "'); window.history.back();</script>";
                        }
                    } else {
                        echo "<script>alert('Gagal memperbarui stok barang: " . $conn->error . "'); window.history.back();</script>";
                    }
                } else {
                    echo "<script>alert('Stok barang tidak mencukupi untuk memenuhi permintaan.'); window.history.back();</script>";
                }
            } else {
                echo "<script>alert('Barang tidak ditemukan.'); window.history.back();</script>";
            }
        } else {
            // Jika status bukan Disetujui, hanya update status dan catatan admin
            $update_query = "UPDATE permintaan_barang SET status = '$status', catatan_admin = '$catatan_admin' WHERE id = $update_id";
            if ($conn->query($update_query)) {
                echo "<script>alert('Permintaan berhasil diperbarui!'); window.location.href = 'permintaan.php';</script>";
            } else {
                echo "<script>alert('Gagal memperbarui permintaan: " . $conn->error . "'); window.history.back();</script>";
            }
        }
    } else {
        echo "<script>alert('Data permintaan tidak ditemukan.'); window.history.back();</script>";
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
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Permintaan Barang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Fungsi untuk konfirmasi penghapusan
        function confirmDelete() {
            return confirm('Apakah Anda yakin ingin menghapus permintaan ini? Permintaan ini tidak dapat dipulihkan.');
        }
    </script>
    <style>
        /* Gaya untuk header */
        .header-container {
            background-color: #00274d;
            color: white;
            padding: 20px;
        }

        .header-container img {
            max-width: 150px;
            height: auto;
        }

        .header-container .campus-name {
            font-size: 1.5rem;
            font-weight: bold;
            margin-top: 10px;
        }

        /* Gaya untuk tabel dan tombol */
        .table th, .table td {
            text-align: center;
        }

        .table-hover tbody tr:hover {
            background-color: #f1f1f1;
        }

        .btn-danger, .btn-primary {
            transition: background-color 0.3s ease;
        }

        .btn-danger:hover {
            background-color: #dc3545;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .table-responsive {
            margin-top: 30px;
        }

        /* Animasi pada tombol dan form */
        .btn, .form-control, .form-select {
            transition: all 0.3s ease;
        }

        .btn:hover, .form-control:hover, .form-select:hover {
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }

        /* Responsif untuk tampilan mobile */
        @media (max-width: 768px) {
            .container {
                padding: 0 15px;
            }
            h1 {
                font-size: 1.8rem;
            }
            .table th, .table td {
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>
    <div class="header-container">
    <div class="d-flex justify-content-start align-items-center">
            <img src="assets/gambar/fttk1.png" alt="Logo Kampus">
            <div class="campus-name">Fakultas Teknik dan Teknologi Kemaritiman</div>
        </div>
    </div>

        <div class="container mt-5">
        <h1 class="text-center mb-4">Permintaan Barang</h1>

        <nav class="mb-4">
            <ul class="nav nav-pills justify-content-center">
                <li class="nav-item">
                    <a class="nav-link" href="dashboard.php">Manajemen Barang</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="#">Permintaan Barang</a>
                </li>
            </ul>
        </nav>
        </div>

        <!-- Tombol Unduh PDF -->
        <form action="config/permintaanpdf.php" method="POST" class="mb-4 text-center">
            <button type="submit" class="btn btn-primary">Unduh Semua Permintaan sebagai PDF</button>
        </form>

        <!-- Tabel Permintaan Barang -->
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Nama</th>
                        <th>ID</th>
                        <th>Departemen</th>
                        <th>Barang</th>
                        <th>Jumlah</th>
                        <th>Satuan</th>
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
                            <td><?= htmlspecialchars($row['jumlah']) ?></td>
                            <td><?= htmlspecialchars($row['satuan']) ?></td>
                            <td><?= date('Y-m-d', strtotime($row['tanggal'])) ?></td>
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
                                <form action="" method="POST" onsubmit="return confirmDelete();">
                                    <input type="hidden" name="delete_id" value="<?= htmlspecialchars($row['id']) ?>">
                                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
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
