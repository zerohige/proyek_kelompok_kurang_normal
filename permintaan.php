<?php
session_start();
include 'config/database.php';
include 'config/update_permintaan.php';
include 'config/delete_permintaan.php';

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

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
    <script src="https://cdn.jsdelivr.net/npm/jquery/dist/jquery.min.js"></script>
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
            justify-content: flex-start;
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

        .table-responsive {
            margin-top: 30px;
        }
    </style>
</head>
<body>
<div class="header-container">
    <img src="assets/gambar/fttk1.png" alt="Logo Kampus">
    <div class="campus-name">Fakultas Teknik dan Teknologi Kemaritiman</div>
</div>
    <div class="container">
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

        <!-- Tombol Unduh PDF -->
        <form action="config/permintaanpdf.php" method="POST" class="mb-4 text-center">
            <button type="submit" class="btn btn-primary">Unduh Rekap ke PDF</button>
        </form>

        <!-- Tabel Permintaan Barang -->
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Nama</th>
                        <th>Departemen</th>
                        <th>Telepon</th>
                        <th>Barang</th>
                        <th>Jumlah</th>
                        <th>Satuan</th>
                        <th>Catatan Pemohon</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Catatan Admin</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="permintaan-table-body">
                    <?php while ($row = $result_permintaan->fetch_assoc()): ?>
                        <tr id="row-<?= htmlspecialchars($row['id']) ?>">
                            <td><?= htmlspecialchars($row['nama']) ?></td>
                            <td><?= htmlspecialchars($row['departemen']) ?></td>
                            <td><?= htmlspecialchars($row['telepon']) ?></td>
                            <td><?= htmlspecialchars($row['barang']) ?></td>
                            <td><?= htmlspecialchars($row['jumlah']) ?></td>
                            <td><?= htmlspecialchars($row['satuan']) ?></td>
                            <td><?= htmlspecialchars($row['catatan_pemohon'] ?? 'Tidak ada catatan') ?></td>
                            <td><?= date('Y-m-d', strtotime($row['tanggal'])) ?></td>
                            <td>
                                <span class="badge bg-<?= strtolower($row['status']) === 'disetujui' ? 'success' : (strtolower($row['status']) === 'ditolak' ? 'danger' : 'warning') ?>">
                                    <?= htmlspecialchars($row['status']) ?>
                                </span>
                            </td>
                            <td><?= htmlspecialchars($row['catatan_admin']) ?></td>
                            <td>
                                <button class="btn btn-primary btn-sm edit-button" data-id="<?= $row['id'] ?>" data-bs-toggle="modal" data-bs-target="#editModal">Edit</button>
                                <button class="btn btn-danger btn-sm delete-button" data-id="<?= $row['id'] ?>">Hapus</button>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Edit -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Permintaan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editForm">
                        <input type="hidden" id="edit-id">
                        <div class="mb-3">
                            <label for="edit-status" class="form-label">Status</label>
                            <select id="edit-status" class="form-select">
                                <option value="Pending">Pending</option>
                                <option value="Disetujui">Disetujui</option>
                                <option value="Ditolak">Ditolak</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="edit-catatan" class="form-label">Catatan Admin</label>
                            <textarea id="edit-catatan" class="form-control"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Edit Button Click
        $('.edit-button').on('click', function () {
            const id = $(this).data('id');
            const row = $('#row-' + id);
            const status = row.find('span').text().trim();
            const catatan = row.find('td:nth-child(10)').text().trim();

            $('#edit-id').val(id);
            $('#edit-status').val(status);
            $('#edit-catatan').val(catatan);
        });

        // Save Edit Form
        $('#editForm').on('submit', function (e) {
            e.preventDefault();
            const id = $('#edit-id').val();
            const status = $('#edit-status').val();
            const catatan = $('#edit-catatan').val();

            $.ajax({
                url: 'config/update_permintaan.php',
                method: 'POST',
                data: { id, status, catatan },
                success: function (response) {
                    location.reload();
                },
                error: function () {
                    alert('Gagal memperbarui data.');
                }
            });
        });

        // Delete Button Click
        $('.delete-button').on('click', function () {
            if (confirm('Apakah Anda yakin ingin menghapus permintaan ini?')) {
                const id = $(this).data('id');
                $.ajax({
                    url: 'config/delete_permintaan.php',
                    method: 'POST',
                    data: { id },
                    success: function () {
                        location.reload();
                    },
                    error: function () {
                        alert('Gagal menghapus data.');
                    }
                });
            }
        });
    </script>
</body>
</html>
