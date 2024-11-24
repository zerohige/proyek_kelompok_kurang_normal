<?php
require '../vendor/autoload.php';
include 'database.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

// Ambil data dari tabel `permintaan_barang`
$query = "SELECT * FROM permintaan_barang";
$result = $conn->query($query);

if (!$result) {
    die("Error dalam query: " . $conn->error);
}

// Membuat objek Spreadsheet baru
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Header kolom
$headers = ['Nama', 'ID', 'Departemen', 'Barang', 'Tanggal', 'Status', 'Catatan Admin', 'Tanda Tangan'];
$sheet->fromArray($headers, NULL, 'A1');

// Tambahkan data ke file Excel
$rowIndex = 2; // Mulai dari baris ke-2
while ($row = $result->fetch_assoc()) {
    // Tambahkan data ke kolom selain tanda tangan
    $sheet->setCellValue("A{$rowIndex}", $row['nama']);
    $sheet->setCellValue("B{$rowIndex}", $row['id_pemohon']);
    $sheet->setCellValue("C{$rowIndex}", $row['departemen']);
    $sheet->setCellValue("D{$rowIndex}", $row['barang']);
    $sheet->setCellValue("E{$rowIndex}", $row['tanggal']);
    $sheet->setCellValue("F{$rowIndex}", $row['status']);
    $sheet->setCellValue("G{$rowIndex}", $row['catatan_admin']);

    // Menambahkan tanda tangan jika ada
    if (!empty($row['tanda_tangan'])) {
        $drawing = new Drawing();
        $drawing->setName('Tanda Tangan');
        $drawing->setDescription('Tanda Tangan');
        // Konversi base64 menjadi file gambar sementara
        $imageData = base64_decode(str_replace('data:image/png;base64,', '', $row['tanda_tangan']));
        $tempImage = tempnam(sys_get_temp_dir(), 'signature');
        file_put_contents($tempImage, $imageData);

        // Tambahkan gambar ke spreadsheet
        $drawing->setPath($tempImage);
        $drawing->setHeight(50); // Ukuran gambar
        $drawing->setCoordinates("H{$rowIndex}");
        $drawing->setWorksheet($sheet);
    }

    $rowIndex++;
}

// Set nama file dan header untuk download
$filename = 'permintaan_barang.xlsx';
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header("Content-Disposition: attachment; filename={$filename}");
header('Cache-Control: max-age=0');

// Tulis file Excel dan kirim ke browser
$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit();
?>
