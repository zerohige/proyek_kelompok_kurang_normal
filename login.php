<?php
include 'config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT * FROM admin WHERE username = '$username' AND password = MD5('$password')";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        session_start();
        $_SESSION['admin'] = $username;
        header("Location: dashboard.php");
        exit(); // Tambahkan exit di sini
    } else {
        echo "<script>alert('Login gagal! Username atau password salah.'); window.location.href = 'login.php';</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="header-container">
        <div class="d-flex align-items-center">
            <!-- Logo Kampus -->
            <img src="assets/gambar/fttk1.png" alt="Logo Kampus" style="max-width: 200px; height: auto;">
            <!-- Nama Kampus -->
            <div class="campus-name">
        </div>
    </div>
    <div class="container">
        <h1>Login Admin</h1>
        <form action="login.php" method="POST">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>
