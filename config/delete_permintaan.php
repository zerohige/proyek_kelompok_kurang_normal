<?php
include 'database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);

    $query = "DELETE FROM permintaan_barang WHERE id=$id";
    if ($conn->query($query)) {
        echo "Berhasil";
    } else {
        http_response_code(500);
        echo "Error: " . $conn->error;
    }
}
?>
