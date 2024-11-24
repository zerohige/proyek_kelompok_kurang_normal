<?php
// Sertakan koneksi database
include 'config/database.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulir Permintaan Barang</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
</head>
<body>
    <div class="container">
        <h1>Formulir Permintaan Barang</h1>
        <a href="login.php" class="login-button">Login sebagai Admin</a>
        <form action="config/request.php" method="POST">
            <!-- Informasi Pemohon -->
            <div class="form-group">
                <label for="nama">Nama:</label>
                <input type="text" id="nama" name="nama" required>
            </div>
            <div class="form-group">
                <label for="id">ID:</label>
                <input type="text" id="id" name="id" required>
            </div>
            <div class="form-group">
                <label for="departemen">Departemen:</label>
                <input type="text" id="departemen" name="departemen" required>
            </div>
            <div class="form-group">
                <label for="telepon">Nomor Telepon:</label>
                <input type="text" id="telepon" name="telepon" required>
            </div>
            <div class="form-group">
                <label for="tanggal">Tanggal:</label>
                <input type="text" id="tanggal" name="tanggal" value="<?= date('Y-m-d H:i:s') ?>" readonly>
            </div>
            <!-- Barang dan Stok -->
            <div class="form-group">
                <label for="barang">Barang yang Diminta:</label>
                <select id="barang" name="barang" required>
                    <option value="">-- Pilih Barang --</option>
                    <?php
                    // Query untuk mengambil data barang dari database
                    $query = "SELECT * FROM barang";
                    $result = $conn->query($query);
                    if ($result) {
                        while ($row = $result->fetch_assoc()) {
                            $stok = $row['stok'] > 0 ? "Stok: {$row['stok']}" : "Stok Habis";
                            echo "<option value='{$row['nama_barang']}'>{$row['nama_barang']} ($stok)</option>";
                        }
                    } else {
                        echo "<option value=''>Barang tidak tersedia</option>";
                    }
                    ?>
                </select>
            </div>
            <!-- Tanda Tangan Digital -->
            <div class="form-group">
                <label for="signature">Tanda Tangan:</label>
                <div id="signature-pad">
                    <canvas id="signature-canvas" width="500" height="200" style="border: 1px solid #ccc;"></canvas>
                </div>
                <button type="button" id="clear-signature">Hapus Tanda Tangan</button>
                <input type="hidden" id="signature-data" name="signature">
            </div>
            <!-- Submit -->
            <div class="form-group">
                <button type="submit">Kirim Permintaan</button>
            </div>
        </form>
    </div>
    <script src="assets/js/script.js"></script>
</body>
</html>
