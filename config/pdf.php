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
        $pdf->SetMargins(15, 20, 15);

        // Header
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(0, 10, 'Surat Permintaan Barang', 0, 1, 'C');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(0, 10, 'Fakultas Teknik dan Teknologi Kemaritiman', 0, 1, 'C');
        $pdf->Cell(0, 10, 'Universitas Maritim Raja Ali Haji', 0, 1, 'C');
        $pdf->Ln(10);
        $pdf->SetFont('Arial', 'I', 10);
        $pdf->Cell(0, 5, 'Tanggal: ' . date('d-m-Y H:i:s'), 0, 1, 'R');
        $pdf->Ln(10);

        // Konten Surat
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(0, 10, 'Kepada Yth.', 0, 1);
        $pdf->Cell(0, 10, htmlspecialchars($row['nama']), 0, 1);
        $pdf->Cell(0, 10, 'Di Tempat', 0, 1);
        $pdf->Ln(10);

        $pdf->SetFont('Arial', '', 12);
        $pdf->MultiCell(0, 10, "Dengan ini kami sampaikan status dari permintaan barang yang telah diajukan sebagai berikut:");

        // Detail Permintaan
        $pdf->Ln(5);
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(50, 10, 'Nama Pemohon:', 0, 0);
        $pdf->Cell(0, 10, htmlspecialchars($row['nama']), 0, 1);

        $pdf->Cell(50, 10, 'ID Pemohon:', 0, 0);
        $pdf->Cell(0, 10, htmlspecialchars($row['id_pemohon']), 0, 1);

        $pdf->Cell(50, 10, 'Departemen:', 0, 0);
        $pdf->Cell(0, 10, htmlspecialchars($row['departemen']), 0, 1);

        $pdf->Cell(50, 10, 'Barang Diminta:', 0, 0);
        $pdf->Cell(0, 10, htmlspecialchars($row['barang']), 0, 1);

        $pdf->Cell(50, 10, 'Status:', 0, 0);
        $status_color = strtolower($row['status']) === 'disetujui' ? 'Hijau' : (strtolower($row['status']) === 'ditolak' ? 'Merah' : 'Kuning');
        $pdf->Cell(0, 10, htmlspecialchars($row['status']) . " (Indikator: $status_color)", 0, 1);

        $pdf->Cell(50, 10, 'Catatan Admin:', 0, 0);
        $pdf->MultiCell(0, 10, htmlspecialchars($row['catatan_admin'] ?? 'Belum ada catatan'));

        // Penutup Surat
        $pdf->Ln(10);
        $pdf->SetFont('Arial', '', 12);
        $pdf->MultiCell(0, 10, "Demikian informasi ini kami sampaikan. Jika terdapat pertanyaan lebih lanjut, "
            . "silakan hubungi departemen terkait. Terima kasih atas perhatian Anda.");

        $pdf->Ln(20);
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(0, 10, 'Hormat kami,', 0, 1);
        $pdf->Ln(10);
         $pdf->Cell(0, 10, htmlspecialchars($row['nama']), 0, 1);

        // Output PDF
        $pdf->Output('D', 'Status_Permintaan_Barang.pdf'); // Unduh PDF
    } else {
        echo "<script>alert('Data permintaan tidak ditemukan.'); window.history.back();</script>";
    }
} else {
    echo "<script>alert('ID tidak valid.'); window.history.back();</script>";
}
?>
