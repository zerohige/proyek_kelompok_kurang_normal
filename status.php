<?php
include 'config/database.php';

// Ambil ID permintaan dari URL
$id_permintaan = isset($_GET['id']) ? intval($_GET['id']) : 0; // Pastikan ID selalu integer

// Periksa apakah ID permintaan valid
if ($id_permintaan > 0) {
    // Query untuk mengambil data permintaan berdasarkan ID
    $query = "SELECT * FROM permintaan_barang WHERE id = $id_permintaan";
    $result = $conn->query($query);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        // Jika data tidak ditemukan, tampilkan pesan error
        die("<script>alert('Permintaan tidak ditemukan.'); window.location.href = 'index.php';</script>");
    }
} else {
    // Jika ID tidak valid, kembalikan ke halaman index
    die("<script>alert('ID permintaan tidak valid.'); window.location.href = 'index.php';</script>");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Permintaan</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="container">
        <h1>Status Permintaan Barang</h1>
        <p><strong>Nama:</strong> <?= htmlspecialchars($row['nama']) ?></p>
        <p><strong>ID Pemohon:</strong> <?= htmlspecialchars($row['id_pemohon']) ?></p>
        <p><strong>Departemen:</strong> <?= htmlspecialchars($row['departemen']) ?></p>
        <p><strong>Barang Diminta:</strong> <?= htmlspecialchars($row['barang']) ?></p>
        <p><strong>Status:</strong> <?= htmlspecialchars($row['status']) ?></p>
        <p><strong>Catatan Admin:</strong> <?= htmlspecialchars($row['catatan_admin'] ?? 'Belum ada catatan') ?></p>
        
        <!-- Tombol untuk kembali ke halaman home -->
        <a href="index.php" style="display: inline-block; margin-top: 20px; padding: 10px 20px; background-color: #4CAF50; color: white; text-decoration: none; border-radius: 5px;">Kembali ke Home</a>
        
        <!-- Tombol untuk mengunduh PDF -->
        <form action="config/pdf.php" method="POST" style="display: inline-block;">
            <input type="hidden" name="id" value="<?= $id_permintaan ?>">
            <button type="submit" style="margin-top: 20px; padding: 10px 20px; background-color: #2196F3; color: white; border: none; border-radius: 5px;">Unduh Status PDF</button>
        </form>
    </div>
</body>
</html>
