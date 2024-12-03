<?php
include 'config/database.php';

// Ambil ID permintaan dari URL
$id_permintaan = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Periksa apakah ID permintaan valid
if ($id_permintaan > 0) {
    // Query untuk mengambil data permintaan berdasarkan ID
    $query = "SELECT * FROM permintaan_barang WHERE id = $id_permintaan";
    $result = $conn->query($query);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        // Jika data tidak ditemukan, tampilkan pesan error
        die("<script>alert('Permintaan tidak ditemukan.'); window.location.href = 'formulir.php';</script>");
    }
} else {
    // Jika ID tidak valid, kembalikan ke halaman index
    die("<script>alert('ID permintaan tidak valid.'); window.location.href = 'formulir.php';</script>");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Permintaan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            background-color: #f8f9fa;
        }
        .letter-container {
            background: white;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            margin: 50px auto;
            max-width: 800px;
        }
        .letter-header {
            text-align: center;
            margin-bottom: 30px;
        }
        .letter-footer {
            text-align: center;
            margin-top: 30px;
        }
        .btn-custom {
            padding: 10px 20px;
            border-radius: 5px;
            font-weight: bold;
            transition: all 0.3s ease;
        }
        .btn-custom:hover {
            opacity: 0.9;
        }
    </style>
</head>
<body>
<link rel="stylesheet" href="assets/css/style.css">
<div class="header-container">
        <div class="d-flex align-items-center">
            <!-- Logo Kampus -->
            <img src="assets/gambar/fttk1.png" alt="Logo Kampus" style="max-width: 200px; height: auto;">
            <!-- Nama Kampus -->
            <div class="campus-name">
        </div>
    </div>
    <div class="container">
        <div class="letter-container">
            <div class="letter-header">
                <h1>Status Permintaan Barang</h1>
                <p class="text-muted">Nomor Permintaan: <strong>#<?= htmlspecialchars($id_permintaan) ?></strong></p>
            </div>
            <div class="letter-body">
                <p><strong>Nama Pemohon:</strong> <?= htmlspecialchars($row['nama']) ?></p>
                <p><strong>ID Pemohon:</strong> <?= htmlspecialchars($row['id_pemohon']) ?></p>
                <p><strong>Departemen:</strong> <?= htmlspecialchars($row['departemen']) ?></p>
                <p><strong>Barang Diminta:</strong> <?= htmlspecialchars($row['barang']) ?></p>
                <p><strong>Jumlah:</strong> <?= htmlspecialchars($row['jumlah']) ?></p>
                <p><strong>satuan:</strong> <?= htmlspecialchars($row['satuan']) ?></p>
                <p><strong>Tanggal Permintaan:</strong> <?= date('Y-m-d', strtotime($row['tanggal'])) ?></p>
                <p><strong>Status:</strong> 
                    <span class="badge bg-<?= strtolower($row['status']) === 'disetujui' ? 'success' : (strtolower($row['status']) === 'ditolak' ? 'danger' : 'warning') ?>">
                        <?= htmlspecialchars($row['status']) ?>
                    </span>
                </p>
                <p><strong>Catatan Admin:</strong> <?= htmlspecialchars($row['catatan_admin'] ?? 'Belum ada catatan') ?></p>
            </div>
            <div class="letter-footer">
                <a href="formulir.php" class="btn btn-success btn-custom">Kembali ke Home</a>
                <form action="config/pdf.php" method="POST" class="d-inline">
                    <input type="hidden" name="id" value="<?= $id_permintaan ?>">
                    <button type="submit" class="btn btn-primary btn-custom">Unduh Status PDF</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
