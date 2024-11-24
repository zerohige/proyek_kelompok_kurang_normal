<?php
include 'database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari formulir dengan validasi sederhana
    $nama = isset($_POST['nama']) ? $conn->real_escape_string(trim($_POST['nama'])) : '';
    $id = isset($_POST['id']) ? $conn->real_escape_string(trim($_POST['id'])) : '';
    $departemen = isset($_POST['departemen']) ? $conn->real_escape_string(trim($_POST['departemen'])) : '';
    $telepon = isset($_POST['telepon']) ? $conn->real_escape_string(trim($_POST['telepon'])) : '';
    $tanggal = isset($_POST['tanggal']) ? $conn->real_escape_string(trim($_POST['tanggal'])) : '';
    $barang = isset($_POST['barang']) ? $conn->real_escape_string(trim($_POST['barang'])) : '';
    $signature = isset($_POST['signature']) ? $conn->real_escape_string(trim($_POST['signature'])) : '';

    // Validasi apakah semua data tersedia
    if (!empty($nama) && !empty($id) && !empty($departemen) && !empty($telepon) && !empty($tanggal) && !empty($barang) && !empty($signature)) {
        // Validasi tambahan: Cek apakah permintaan dengan data yang sama sudah ada di tabel
        $check_query = "SELECT * FROM permintaan_barang WHERE id_pemohon = '$id' AND barang = '$barang' AND status = 'Pending'";
        $check_result = $conn->query($check_query);

        if ($check_result && $check_result->num_rows > 0) {
            // Jika sudah ada permintaan serupa yang belum diproses
            echo "<script>alert('Permintaan untuk barang ini sudah diajukan dan masih dalam status Pending.'); window.history.back();</script>";
        } else {
            // Jika belum ada, simpan data baru
            $query = "INSERT INTO permintaan_barang (nama, id_pemohon, departemen, telepon, tanggal, barang, signature, status) 
                      VALUES ('$nama', '$id', '$departemen', '$telepon', '$tanggal', '$barang', '$signature', 'Pending')";

            if ($conn->query($query) === TRUE) {
                $id_permintaan = $conn->insert_id; // Ambil ID permintaan yang baru disimpan
                header("Location: ../status.php?id=$id_permintaan"); // Arahkan ke halaman status
                exit();
            } else {
                // Tampilkan pesan error jika query gagal
                echo "<script>alert('Gagal mengirim permintaan: " . $conn->error . "'); window.history.back();</script>";
            }
        }
    } else {
        // Tampilkan pesan error jika ada data yang kosong
        echo "<script>alert('Harap lengkapi semua data pada formulir.'); window.history.back();</script>";
    }
} else {
    // Jika bukan metode POST, kembalikan ke halaman index
    header("Location: ../index.php");
    exit();
}
?>
