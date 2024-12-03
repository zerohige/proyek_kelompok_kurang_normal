<?php
require('fpdf.php');
include 'database.php';

// Fungsi untuk mengonversi base64 menjadi file sementara
function base64ToTempFile($base64_data, $prefix = 'temp_signature_') {
    $decoded_data = base64_decode($base64_data);
    if ($decoded_data === false) return false;

    $temp_file = $prefix . uniqid() . '.png';
    file_put_contents($temp_file, $decoded_data);
    return $temp_file;
}

// Query untuk mendapatkan semua permintaan barang
$query = "SELECT * FROM permintaan_barang";
$result = $conn->query($query);

if (!$result) {
    die("Error dalam query: " . $conn->error);
}

// Inisialisasi PDF
$pdf = new FPDF();
$pdf->AddPage('L'); // Landscape
$pdf->SetMargins(10, 10, 10);

// Header PDF
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 8, 'Laporan Permintaan Barang', 0, 1, 'C');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(0, 5, 'Tanggal: ' . date('d-m-Y'), 0, 1, 'C');
$pdf->Ln(8);

// Header Tabel
$pdf->SetFont('Arial', 'B', 8);
$columns = [
    ['width' => 8, 'label' => 'No', 'align' => 'C'],
    ['width' => 30, 'label' => 'Nama', 'align' => 'L'],
    ['width' => 25, 'label' => 'ID Pemohon', 'align' => 'L'],
    ['width' => 30, 'label' => 'Departemen', 'align' => 'L'],
    ['width' => 30, 'label' => 'Barang', 'align' => 'L'],
    ['width' => 15, 'label' => 'Jumlah', 'align' => 'C'],
    ['width' => 15, 'label' => 'Satuan', 'align' => 'C'],
    ['width' => 25, 'label' => 'Tanggal', 'align' => 'C'],
    ['width' => 20, 'label' => 'Status', 'align' => 'C'],
    ['width' => 40, 'label' => 'Catatan Admin', 'align' => 'L'],
    ['width' => 35, 'label' => 'Tanda Tangan', 'align' => 'C'],
];

// Header Row
foreach ($columns as $col) {
    $pdf->Cell($col['width'], 8, $col['label'], 1, 0, $col['align']);
}
$pdf->Ln();

// Isi Tabel
$pdf->SetFont('Arial', '', 8);
$no = 1;
while ($row = $result->fetch_assoc()) {
    $row_height = 10; // Tinggi standar baris
    $y_start = $pdf->GetY(); // Awal koordinat Y

    $pdf->Cell(8, $row_height, $no++, 1, 0, 'C');
    $pdf->Cell(30, $row_height, htmlspecialchars($row['nama']), 1, 0, 'L');
    $pdf->Cell(25, $row_height, htmlspecialchars($row['id_pemohon']), 1, 0, 'L');
    $pdf->Cell(30, $row_height, htmlspecialchars($row['departemen']), 1, 0, 'L');
    $pdf->Cell(30, $row_height, htmlspecialchars($row['barang']), 1, 0, 'L');
    $pdf->Cell(15, $row_height, htmlspecialchars($row['jumlah']), 1, 0, 'C');
    $pdf->Cell(15, $row_height, htmlspecialchars($row['satuan']), 1, 0, 'C');
    $pdf->Cell(25, $row_height, date('Y-m-d', strtotime($row['tanggal'])), 1, 0, 'C');
    $pdf->Cell(20, $row_height, htmlspecialchars($row['status']), 1, 0, 'C');
    $pdf->Cell(40, $row_height, htmlspecialchars($row['catatan_admin']), 1, 0, 'L');

    // Kolom Gambar Tanda Tangan
    if (!empty($row['signature']) && preg_match('/^data:image\/png;base64,/', $row['signature'])) {
        $base64_data = str_replace('data:image/png;base64,', '', $row['signature']);
        $base64_data = str_replace(' ', '+', $base64_data);

        $temp_file = base64ToTempFile($base64_data);

        if ($temp_file && file_exists($temp_file)) {
            $pdf->Cell(35, $row_height, '', 1, 0, 'C'); // Placeholder kolom
            $x_image = $pdf->GetX() - 35 + 2.5; // Mengatur margin ke tengah kolom
            $y_image = $y_start + 2; // Margin atas dalam sel
            $pdf->Image($temp_file, $x_image, $y_image, 30, 8); // Gambar tanda tangan
            unlink($temp_file); // Hapus file sementara
        } else {
            $pdf->Cell(35, $row_height, 'Error', 1, 0, 'C');
        }
    } else {
        $pdf->Cell(35, $row_height, 'Tidak Ada', 1, 0, 'C');
    }

    $pdf->Ln($row_height);
}

// Output PDF
$pdf->Output('D', 'Laporan_Permintaan_Barang.pdf');
?>
