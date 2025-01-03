<?php
session_start();
include 'config/database.php';

// Periksa apakah admin sudah login
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

// Bagian untuk menambahkan atau memperbarui barang
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nama_barang'], $_POST['stok'], $_POST['satuan'])) {
    $nama_barang = $conn->real_escape_string(trim($_POST['nama_barang']));
    $stok = intval($_POST['stok']);
    $satuan = $conn->real_escape_string($_POST['satuan']);

    // Periksa apakah barang sudah ada
    $check_query = "SELECT * FROM barang WHERE nama_barang = '$nama_barang'";
    $check_result = $conn->query($check_query);

    if ($check_result && $check_result->num_rows > 0) {
        // Jika barang sudah ada, lakukan update pada stok dan satuan barang
        $row = $check_result->fetch_assoc();
        $update_query = "UPDATE barang SET stok = $stok, satuan = '$satuan' WHERE id = " . $row['id'];

        if ($conn->query($update_query)) {
            echo "<script>alert('Stok barang dan satuan berhasil diperbarui!'); window.location.href = 'dashboard.php';</script>";
        } else {
            echo "<script>alert('Gagal memperbarui stok barang dan satuan: " . $conn->error . "'); window.history.back();</script>";
        }
    } else {
        // Jika barang belum ada, tambahkan barang baru
        $insert_query = "INSERT INTO barang (nama_barang, stok, satuan) VALUES ('$nama_barang', $stok, '$satuan')";
        if ($conn->query($insert_query)) {
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
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <!-- Tambahkan Font Awesome CDN di bagian head -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            background-color: #f4f6f9;
            font-family: 'Arial', sans-serif;
        }

        .header-container {
            background-color: #00274d;
            padding: 20px 0;
            color: white;
            display: flex;
            justify-content: flex-start; /* Pindahkan ke kiri */
            align-items: center;
        }

        .header-container img {
            max-width: 200px;
            height: auto;
        }

        .header-container .campus-name {
            font-size: 1.5rem;
            margin-left: 20px;
            font-weight: bold;
        }

        .container {
            margin-top: 50px;
        }

        .profile-container {
            display: flex;
            align-items: center;
            margin-left: 680px;
        }

        .profile-icon {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            margin-right: 10px;
            object-fit: cover;
        }

        .profile-link {
            color: white;
            font-size: 3rem;
            text-decoration: none;
            display: flex;
            align-items: center;
        }

        .profile-link i {
            margin-right: 5px;
        }

        .profile-link:hover {
            text-decoration: underline;
        }

        h1 {
            color: #333;
            font-size: 2.5rem;
            margin-bottom: 30px;
        }

        .nav-link {
            font-weight: bold;
        }

        .nav-pills .nav-link.active {
            background-color: #007bff;
        }

        .form-label {
            font-weight: bold;
            color: #333;
        }

        .table th, .table td {
            text-align: center;
        }

        .table-hover tbody tr:hover {
            background-color: #f1f1f1;
        }

        .table-responsive {
            margin-top: 30px;
        }

        .btn-danger {
            transition: background-color 0.3s ease;
        }

        .btn-danger:hover {
            background-color: #d9534f;
        }

        .btn-sm {
            padding: 6px 12px;
            font-size: 0.9rem;
        }

        /* Animasi pada form tambah barang */
        .form-container {
        }

        /* Responsif untuk tampilan mobile */
        @media (max-width: 768px) {
            .container {
                padding: 0 15px;
            }

            h1 {
                font-size: 2rem;
            }

            .table th, .table td {
                font-size: 0.85rem;
            }

            .nav-pills .nav-link {
                font-size: 0.9rem;
            }
        }
    </style>
</head >
<body>
<div class="header-container">
    <!-- Logo di sebelah kiri -->
    <img src="assets/gambar/fttk1.png" alt="Logo Kampus" class="logo">
    
    <!-- Nama Kampus di sebelah kiri -->
    <div class="campus-name">Fakultas Teknik dan Teknologi Kemaritiman</div>
    
    <!-- Profil dan tombol Kelola Profil di sebelah kanan -->
    <div class="profile-container">
        <!-- Ikon untuk kelola profil -->
        <a href="profil.php" class="profile-link">
            <i class="fas fa-user-cog"> </i>
        </a>
    </div>
</div>

<div class="container">
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
    <section id="manage-items" class="form-container">
        <h5 class="text-center mb-4">Tambah Barang & Stok</h5>
        <form action="" method="POST" class="row g-3">
            <div class="col-md-6">
                <label for="nama_barang" class="form-label">Nama Barang:</label>
                <input type="text" id="nama_barang" name="nama_barang" class="form-control" required>
            </div>
            <div class="col-md-4">
                <label for="stok" class="form-label">Stok:</label>
                <input type="number" id="stok" name="stok" class="form-control" required>
            </div>
            <div class="col-md-2">
                <label for="satuan" class="form-label">Satuan:</label>
                <select id="satuan" name="satuan" class="form-select" required>
                    <option value="pcs">Pcs</option>
                    <option value="pack">Pack</option>
                </select>
            </div>
            <div class="col-12 text-center">
                <button type="submit" class="btn btn-primary">Tambah Barang</button>
            </div>
        </form>

        <div class="table-responsive mt-4">
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nama Barang</th>
                        <th>Stok</th>
                        <th>Satuan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result_barang->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['id']) ?></td>
                            <td><?= htmlspecialchars($row['nama_barang']) ?></td>
                            <td><?= htmlspecialchars($row['stok']) ?></td>
                            <td><?= htmlspecialchars($row['satuan']) ?></td>
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
