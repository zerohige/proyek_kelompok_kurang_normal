<?php
// Sertakan koneksi database
include 'config/database.php';
date_default_timezone_set('Asia/Jakarta');
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jurnal Pengambilan ATK</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
    <style>
        body {
            background-color: #00274d;
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
            max-width: 900px;
            margin-top: 30px;
        }

        .card {
            border: none;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            padding: 20px;
        }

        .card-header {
            background-color: #007bff;
            color: white;
            font-size: 1.25rem;
            font-weight: bold;
            border-radius: 10px 10px 0 0;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        .btn-secondary {
            background-color: #6c757d;
            border-color: #6c757d;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
            border-color: #5a6268;
        }

        .form-control, .form-select {
            border-radius: 5px;
            box-shadow: inset 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .form-label {
            font-weight: bold;
        }

        .invalid-feedback {
            font-size: 0.875rem;
        }

        #signature-pad canvas {
            border: 3px solid #007bff; /* Warna biru dan border lebih tebal */
            border-radius: 5px;
            background: #fff;
            margin-top: 10px;
        }

        .signature-btns {
            margin-top: 10px;
        }

        .signature-btns button {
            padding: 6px 20px;
            font-size: 1rem;
            border-radius: 5px;
        }

        @media (max-width: 768px) {
            .container {
                margin-top: 20px;
                padding: 0 15px;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header-container">
         <img src="assets/gambar/fttk1.png" alt="Logo Kampus">
         <div class="campus-name">Fakultas Teknik dan Teknologi Kemaritiman</div>
    </div>
    <!-- Formulir Permintaan Barang -->
    <div class="container">
        <div class="card">
            <div class="card-header text-center">Formulir Permintaan Barang</div>
            <form action="config/request.php" method="POST" class="needs-validation" novalidate>
                <!-- Informasi Pemohon -->
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama:</label>
                    <input type="text" id="nama" name="nama" class="form-control" required>
                    <div class="invalid-feedback">Nama wajib diisi.</div>
                </div>

                <div class="mb-3">
                    <label for="departemen" class="form-label">Departemen:</label>
                    <select id="departemen" name="departemen" class="form-select" required>
                        <option value="">-- Pilih Departemen --</option>
                        <option value="Mahasiswa">Mahasiswa TI</option>
                        <option value="Mahasiswa">Mahasiswa TE</option>
                        <option value="Mahasiswa">Mahasiswa TP</option>
                        <option value="Mahasiswa">Mahasiswa---</option>
                        <option value="Mahasiswa">Mahasiswa---</option>
                        <option value="Dosen">Dosen</option>
                        <option value="Tenaga Pengajar">Tenaga Pengajar</option>
                        <option value="Staff TU">Staff TU</option>
                    </select>
                    <div class="invalid-feedback">Pilih departemen yang sesuai.</div>
                </div>

                <div class="mb-3">
                    <label for="telepon" class="form-label">Nomor Telepon:</label>
                    <input type="text" id="telepon" name="telepon" class="form-control" required>
                    <div class="invalid-feedback">Nomor telepon wajib diisi.</div>
                </div>

                <div class="mb-3">
                    <label for="tanggal" class="form-label">Tanggal:</label>
                    <input type="text" id="tanggal" name="tanggal" class="form-control" value="<?= date('Y-m-d') ?>" readonly>
                </div>

                <!-- Barang dan Stok -->
                <div class="mb-3">
                    <label for="barang" class="form-label">Barang yang Diminta:</label>
                    <div class="d-flex align-items-center">
                        <select id="barang" name="barang" class="form-select me-2" required>
                            <option value="">-- Pilih Barang --</option>
                            <?php
                            $query = "SELECT * FROM barang";
                            $result = $conn->query($query);
                            if ($result) {
                                while ($row = $result->fetch_assoc()) {
                                    $stok = $row['stok'] > 0 ? "Stok: {$row['stok']}" : "Stok Habis";
                                    echo "<option value='{$row['nama_barang']}' data-stok='{$row['stok']}'>{$row['nama_barang']} ($stok)</option>";
                                }
                            } else {
                                echo "<option value=''>Barang tidak tersedia</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="invalid-feedback">Pilih barang yang diminta.</div>
                </div>

                <div class="mb-3">
                    <label for="jumlah" class="form-label">Jumlah Barang yang Diminta:</label>
                    <input type="number" id="jumlah" name="jumlah" class="form-control" required min="1">
                    <div class="invalid-feedback">Jumlah barang tidak mencukupi.</div>
                </div>

                <!-- Dropdown Satuan -->
                <div class="mb-3">
                    <label for="satuan" class="form-label">Satuan Barang:</label>
                    <select id="satuan" name="satuan" class="form-select" required>
                        <option value="">-- Pilih Satuan --</option>
                    </select>
                    <div class="invalid-feedback">Pilih satuan barang.</div>
                </div>
                
                <script>
                    // Script untuk mengisi dropdown satuan berdasarkan barang yang dipilih
                    document.getElementById('barang').addEventListener('change', function () {
                        const satuanDropdown = document.getElementById('satuan');

                        // Kosongkan dropdown satuan
                        satuanDropdown.innerHTML = '<option value="">-- Pilih Satuan --</option>';

                        // Tambahkan opsi tetap: pcs dan pack
                        const satuanOptions = ["pcs", "pack"];
                        satuanOptions.forEach(function (item) {
                            const option = document.createElement('option');
                            option.value = item;
                            option.textContent = item;
                            satuanDropdown.appendChild(option);
                        });
                    });
                </script>

                <!-- Catatan Pemohon -->
                <!-- Catatan Pemohon -->
                <div class="mb-3">
                    <label for="catatan_pemohon" class="form-label">Catatan Pemohon:</label>
                    <textarea id="catatan_pemohon" name="catatan_pemohon" class="form-control" rows="3" maxlength="25"></textarea>
                </div>

                <!-- Tanda Tangan Digital -->
                <div class="mb-3">
                    <label for="signature" class="form-label">Tanda Tangan:</label>
                    <div id="signature-pad">
                        <canvas id="signature-canvas" width="500" height="200"></canvas>
                    </div>
                    <div class="signature-btns">
                        <button type="button" class="btn btn-secondary" id="clear-signature">Hapus Tanda Tangan</button>
                    </div>
                    <input type="hidden" id="signature-data" name="signature">
                </div>

                <!-- Submit -->
                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Kirim Permintaan</button>
                </div>
            </form>
        </div>
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
