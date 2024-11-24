<?php
// Sertakan koneksi database
include 'database.php';

// Periksa apakah request menggunakan metode POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari formulir dengan validasi
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0; // Pastikan ID adalah integer
    $status = isset($_POST['status']) ? $conn->real_escape_string(trim($_POST['status'])) : '';
    $catatan_admin = isset($_POST['catatan_admin']) ? $conn->real_escape_string(trim($_POST['catatan_admin'])) : '';

    // Validasi input
    if ($id > 0 && in_array($status, ['Pending', 'Disetujui', 'Ditolak']) && !empty($catatan_admin)) {
        // Query untuk memperbarui status dan catatan
        $query = "UPDATE permintaan_barang SET status = '$status', catatan_admin = '$catatan_admin' WHERE id = $id";

        if ($conn->query($query) === TRUE) {
            echo "<script>alert('Permintaan berhasil diperbarui!'); window.location.href = '../dashboard.php';</script>";
        } else {
            echo "<script>alert('Gagal memperbarui permintaan: " . $conn->error . "'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('Data tidak valid. Pastikan semua data diisi dengan benar.'); window.history.back();</script>";
    }
} else {
    echo "<script>alert('Akses tidak valid.'); window.location.href = '../dashboard.php';</script>";
}
?>
