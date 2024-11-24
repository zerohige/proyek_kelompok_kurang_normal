<?php
$servername = "localhost"; // Server database (biasanya localhost)
$username = "root"; // Username database
$password = ""; // Password database
$dbname = "pengelolaan_barang"; // Ganti dengan nama database Anda

// Membuat koneksi ke database
$conn = new mysqli($servername, $username, $password, $dbname);

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi ke database gagal: " . $conn->connect_error);
}
?>
