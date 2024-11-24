<?php
// Sertakan koneksi database
include 'config/database.php';
date_default_timezone_set('Asia/Jakarta');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulir Permintaan Barang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
    <style>
        #signature-pad canvas {
            border: 1px solid #ccc;
            border-radius: 5px;
            background: #fff;
        }
        .login-button {
            display: inline-block;
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            margin-bottom: 20px;
            text-align: center;
            transition: all 0.3s ease;
        }
        .login-button:hover {
            background-color: #0056b3;
            color: white;
        }
        .container {
            max-width: 800px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Formulir Permintaan Barang</h1>
        <div class="d-flex justify-content-end">
            <a href="login.php" class="login-button">Login sebagai Admin</a>
        </div>
        <form action="config/request.php" method="POST" class="needs-validation" novalidate>
            <!-- Informasi Pemohon -->
            <div class="mb-3">
                <label for="nama" class="form-label">Nama:</label>
                <input type="text" id="nama" name="nama" class="form-control" required>
                <div class="invalid-feedback">Nama wajib diisi.</div>
            </div>
            <div class="mb-3">
                <label for="id" class="form-label">ID:</label>
                <input type="text" id="id" name="id" class="form-control" required>
                <div class="invalid-feedback">ID wajib diisi.</div>
            </div>
            <div class="mb-3">
                <label for="departemen" class="form-label">Departemen:</label>
                <input type="text" id="departemen" name="departemen" class="form-control" required>
                <div class="invalid-feedback">Departemen wajib diisi.</div>
            </div>
            <div class="mb-3">
                <label for="telepon" class="form-label">Nomor Telepon:</label>
                <input type="text" id="telepon" name="telepon" class="form-control" required>
                <div class="invalid-feedback">Nomor telepon wajib diisi.</div>
            </div>
            <div class="mb-3">
                <label for="tanggal" class="form-label">Tanggal:</label>
                <input type="text" id="tanggal" name="tanggal" class="form-control" value="<?= date('Y-m-d H:i:s') ?>" readonly>
            </div>
            <!-- Barang dan Stok -->
            <div class="mb-3">
                <label for="barang" class="form-label">Barang yang Diminta:</label>
                <select id="barang" name="barang" class="form-select" required>
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
                <div class="invalid-feedback">Pilih barang yang diminta.</div>
            </div>
            <!-- Tanda Tangan Digital -->
            <div class="mb-3">
                <label for="signature" class="form-label">Tanda Tangan:</label>
                <div id="signature-pad">
                    <canvas id="signature-canvas" width="500" height="200"></canvas>
                </div>
                <button type="button" class="btn btn-secondary mt-2" id="clear-signature">Hapus Tanda Tangan</button>
                <input type="hidden" id="signature-data" name="signature">
            </div>
            <!-- Submit -->
            <div class="text-center">
                <button type="submit" class="btn btn-primary">Kirim Permintaan</button>
            </div>
        </form>
    </div>
    <script>
        // Inisialisasi Signature Pad
        const canvas = document.getElementById('signature-canvas');
        const signaturePad = new SignaturePad(canvas);
        const clearButton = document.getElementById('clear-signature');
        const signatureData = document.getElementById('signature-data');

        // Hapus tanda tangan
        clearButton.addEventListener('click', () => {
            signaturePad.clear();
        });

        // Simpan data tanda tangan
        document.querySelector('form').addEventListener('submit', (e) => {
            if (!signaturePad.isEmpty()) {
                signatureData.value = signaturePad.toDataURL();
            } else {
                e.preventDefault();
                alert('Tanda tangan diperlukan!');
            }
        });

        // Bootstrap Validation
        (() => {
            const forms = document.querySelectorAll('.needs-validation');
            Array.from(forms).forEach(form => {
                form.addEventListener('submit', event => {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        })();
    </script>
</body>
</html>
