<?php
include 'database.php';

// Ambil data dari form
$nama = $_POST['nama'];
$departemen = $_POST['departemen'];
$telepon = $_POST['telepon'];
$tanggal = $_POST['tanggal'];
$barang = $_POST['barang'];
$satuan = $_POST['satuan'];
$jumlah = $_POST['jumlah'];
$catatan_pemohon = $_POST['catatan_pemohon']; // Tambahkan catatan pemohon
$signature = $_POST['signature'];

// Masukkan data permintaan ke dalam database
$query = "INSERT INTO permintaan_barang (nama, departemen, telepon, tanggal, barang, jumlah, satuan, catatan_pemohon, signature) 
          VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

if ($stmt = $conn->prepare($query)) {
    $stmt->bind_param("sssssssss", $nama, $departemen, $telepon, $tanggal, $barang, $jumlah, $satuan, $catatan_pemohon, $signature);
    if ($stmt->execute()) {
        // Ambil ID permintaan yang baru saja dimasukkan
        $id_permintaan = $conn->insert_id;
        // Redirect ke halaman status.php
        header("Location: ../status.php?id=" . $id_permintaan);
        exit;
    } else {
        // Jika gagal, beri tahu pengguna
        echo "Error: " . $stmt->error;
    }
} else {
    // Menangani jika query gagal
    die("Query preparation failed: " . $conn->error);
}
?>
