<?php
require('fpdf.php');
include 'database.php';

// Query untuk mendapatkan semua permintaan barang
$query = "SELECT * FROM permintaan_barang";
$result = $conn->query($query);

if (!$result) {
    die("Error dalam query: " . $conn->error);
}

// Inisialisasi PDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetMargins(10, 10, 10);

// Header PDF
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(0, 10, 'Laporan Permintaan Barang', 0, 1, 'C');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(0, 5, 'Tanggal: ' . date('d-m-Y H:i:s'), 0, 1, 'C');
$pdf->Ln(10);

// Header Tabel
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(10, 10, 'No', 1, 0, 'C');
$pdf->Cell(30, 10, 'Nama', 1, 0, 'C');
$pdf->Cell(30, 10, 'Departemen', 1, 0, 'C');
$pdf->Cell(30, 10, 'Barang', 1, 0, 'C');
$pdf->Cell(30, 10, 'Status', 1, 0, 'C');
$pdf->Cell(40, 10, 'Catatan', 1, 0, 'C');
$pdf->Cell(40, 10, 'Tanda Tangan', 1, 1, 'C');

// Isi Tabel
$pdf->SetFont('Arial', '', 10);
$no = 1;
while ($row = $result->fetch_assoc()) {
    $pdf->Cell(10, 20, $no++, 1, 0, 'C');
    $pdf->Cell(30, 20, htmlspecialchars($row['nama']), 1, 0, 'L');
    $pdf->Cell(30, 20, htmlspecialchars($row['departemen']), 1, 0, 'L');
    $pdf->Cell(30, 20, htmlspecialchars($row['barang']), 1, 0, 'L');
    $pdf->Cell(30, 20, htmlspecialchars($row['status']), 1, 0, 'C');
    $pdf->MultiCell(40, 10, htmlspecialchars($row['catatan_admin']), 1, 'L');

    // Validasi dan Tambahkan Tanda Tangan
    if (!empty($row['signature']) && preg_match('/^data:image\/png;base64,/', $row['signature'])) {
        $signature_data = str_replace('data:image/png;base64,', '', $row['signature']);
        $signature_data = str_replace(' ', '+', $signature_data);
        $decoded_signature = base64_decode($signature_data);

        // Validasi decoding dan file PNG
        if ($decoded_signature !== false) {
            $temp_image = 'temp_signature.png';
            file_put_contents($temp_image, $decoded_signature);

            $file_info = getimagesize($temp_image);
            if ($file_info && $file_info['mime'] === 'image/png') {
                $pdf->Image($temp_image, $pdf->GetX() - 40, $pdf->GetY() - 10, 30, 20);
                unlink($temp_image); // Hapus file sementara
            } else {
                unlink($temp_image); // Hapus file yang tidak valid
                $pdf->Cell(40, 20, 'Invalid PNG', 1, 1, 'C');
            }
        } else {
            $pdf->Cell(40, 20, 'Decoding Error', 1, 1, 'C');
        }
    } else {
        $pdf->Cell(40, 20, 'Tidak Ada', 1, 1, 'C');
    }
}

// Output PDF
$pdf->Output('D', 'Laporan_Permintaan_Barang.pdf');
?>
