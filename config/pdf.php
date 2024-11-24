<?php
require('fpdf.php');
include 'database.php';

// Ambil ID dari form
$id_permintaan = isset($_POST['id']) ? intval($_POST['id']) : 0;

if ($id_permintaan > 0) {
    // Query untuk mengambil data permintaan
    $query = "SELECT * FROM permintaan_barang WHERE id = $id_permintaan";
    $result = $conn->query($query);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Buat PDF
        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(0, 10, 'Status Permintaan Barang', 0, 1, 'C');
        $pdf->Ln(10);

        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(50, 10, 'Nama:', 0, 0);
        $pdf->Cell(0, 10, $row['nama'], 0, 1);

        $pdf->Cell(50, 10, 'ID Pemohon:', 0, 0);
        $pdf->Cell(0, 10, $row['id_pemohon'], 0, 1);

        $pdf->Cell(50, 10, 'Departemen:', 0, 0);
        $pdf->Cell(0, 10, $row['departemen'], 0, 1);

        $pdf->Cell(50, 10, 'Barang Diminta:', 0, 0);
        $pdf->Cell(0, 10, $row['barang'], 0, 1);

        $pdf->Cell(50, 10, 'Status:', 0, 0);
        $pdf->Cell(0, 10, $row['status'], 0, 1);

        $pdf->Cell(50, 10, 'Catatan Admin:', 0, 0);
        $pdf->MultiCell(0, 10, $row['catatan_admin'] ?? 'Belum ada catatan');

        // Output PDF
        $pdf->Output('D', 'Status_Permintaan_Barang.pdf'); // Unduh PDF
    } else {
        echo "<script>alert('Data permintaan tidak ditemukan.'); window.history.back();</script>";
    }
} else {
    echo "<script>alert('ID tidak valid.'); window.history.back();</script>";
}
?>
