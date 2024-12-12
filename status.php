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
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Permintaan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            background-color: #00274d;
            font-family: 'Arial', sans-serif;
        }

        .header-container {
            display: flex;
            justify-content: flex-start;
            align-items: center;
            margin-top: 20px;
        }

        .header-container img {
            max-width: 150px;
            height: auto;
        }

        .letter-container {
            background: #ffffff;
            border-radius: 15px;
            padding: 40px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            margin: 30px auto;
            max-width: 900px;
            transition: all 0.3s ease;
        }

        .letter-container:hover {
            transform: translateY(-5px);
        }

        .letter-header h1 {
            font-size: 2rem;
            font-weight: bold;
            color: #333;
        }

        .letter-header p {
            font-size: 1rem;
            color: #888;
        }

        .letter-body p {
            font-size: 1.1rem;
            margin-bottom: 10px;
        }

        .letter-footer {
            text-align: center;
            margin-top: 20px;
        }

        .btn-custom {
            padding: 12px 25px;
            border-radius: 25px;
            font-weight: bold;
            transition: all 0.3s ease;
        }

        .btn-custom:hover {
            opacity: 0.85;
            transform: scale(1.05);
        }

        .badge {
            font-size: 1.1rem;
            font-weight: bold;
            padding: 8px 15px;
            border-radius: 25px;
        }

        .badge.bg-success {
            background-color: #28a745;
        }

        .badge.bg-danger {
            background-color: #dc3545;
        }

        .badge.bg-warning {
            background-color: #ffc107;
        }

        @media (max-width: 768px) {
            .letter-container {
                padding: 20px;
                margin: 10px;
            }

            .letter-header h1 {
                font-size: 1.5rem;
            }

            .letter-body p {
                font-size: 1rem;
            }

            .btn-custom {
                padding: 10px 20px;
            }
        }
    </style>
</head>
<body>
    <div class="header-container">
        <div class="d-flex align-items-center">
            <!-- Logo Kampus -->
            <img src="assets/gambar/fttk1.png" alt="Logo Kampus" style="max-width: 150px; height: auto;">
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
                <p><strong>Departemen:</strong> <?= htmlspecialchars($row['departemen']) ?></p>
                <p><strong>Barang Diminta:</strong> <?= htmlspecialchars($row['barang']) ?></p>
                <p><strong>Jumlah:</strong> <?= htmlspecialchars($row['jumlah']) ?></p>
                <p><strong>Satuan:</strong> <?= htmlspecialchars($row['satuan']) ?></p>
                <p><strong>Catatan Pemohon:</strong> <?= htmlspecialchars($row['catatan_pemohon'] ?? 'Tidak ada catatan') ?></p>
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
