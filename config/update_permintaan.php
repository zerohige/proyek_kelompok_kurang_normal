<?php
include 'database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $status = $conn->real_escape_string($_POST['status']);
    $catatan = $conn->real_escape_string(trim($_POST['catatan']));

    // Update status dan catatan di tabel permintaan_barang
    $query_update = "UPDATE permintaan_barang SET status='$status', catatan_admin='$catatan' WHERE id=$id";
    if ($conn->query($query_update)) {
        if (strtolower($status) === 'disetujui') {
            // Ambil data permintaan barang berdasarkan ID
            $query_get_permintaan = "SELECT barang, jumlah FROM permintaan_barang WHERE id=$id";
            $result_get = $conn->query($query_get_permintaan);

            if ($result_get && $result_get->num_rows > 0) {
                $permintaan = $result_get->fetch_assoc();
                $barang = $conn->real_escape_string($permintaan['barang']);
                $jumlah = intval($permintaan['jumlah']);

                // Cek stok barang
                $query_check_stok = "SELECT stok FROM barang WHERE nama_barang='$barang'";
                $result_stok = $conn->query($query_check_stok);

                if ($result_stok && $result_stok->num_rows > 0) {
                    $stok = $result_stok->fetch_assoc()['stok'];

                    if ($stok >= $jumlah) {
                        // Kurangi stok barang
                        $query_update_stok = "UPDATE barang SET stok=stok-$jumlah WHERE nama_barang='$barang'";
                        if ($conn->query($query_update_stok)) {
                            echo "Berhasil memperbarui data dan stok barang.";
                        } else {
                            http_response_code(500);
                            echo "Gagal memperbarui stok barang: " . $conn->error;
                        }
                    } else {
                        http_response_code(400);
                        echo "Stok barang tidak mencukupi.";
                    }
                } else {
                    http_response_code(404);
                    echo "Barang tidak ditemukan.";
                }
            } else {
                http_response_code(404);
                echo "Data permintaan tidak ditemukan.";
            }
        } else {
            echo "Status permintaan berhasil diperbarui.";
        }
    } else {
        http_response_code(500);
        echo "Gagal memperbarui permintaan: " . $conn->error;
    }
}
?>
