<?php
$host = 'localhost';
$user = 'root';
$password = ''; // Ubah jika MySQL Anda memiliki password
$db_name = 'pengelolaan_barang';

$conn = new mysqli($host, $user, $password, $db_name);

if ($conn->connect_error) {
    die("Koneksi database gagal: " . $conn->connect_error);
}
?>
