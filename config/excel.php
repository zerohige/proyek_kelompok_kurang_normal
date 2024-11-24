<?php
include 'database.php';

// Set header untuk mendownload file Excel
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=Data_Permintaan_Barang.xls");
header("Pragma: no-cache");
header("Expires: 0");

// Tulis header tabel
echo "Nama\tID Pemohon\tDepartemen\tBarang\tTanggal\tStatus\tCatatan Admin\tTanda Tangan\n";

// Query untuk mendapatkan data permintaan barang
$query = "SELECT * FROM permintaan_barang";
$result = $conn->query($query);

// Tulis data ke file Excel
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo htmlspecialchars($row['nama']) . "\t";
        echo htmlspecialchars($row['id_pemohon']) . "\t";
        echo htmlspecialchars($row['departemen']) . "\t";
        echo htmlspecialchars($row['barang']) . "\t";
        echo htmlspecialchars($row['tanggal']) . "\t";
        echo htmlspecialchars($row['status']) . "\t";
        echo htmlspecialchars($row['catatan_admin']) . "\t";
        echo htmlspecialchars($row['signature']) . "\n";
    }
} else {
    echo "Tidak ada data.";
}

$conn->close();
exit();
