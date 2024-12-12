<?php
include 'config/database.php';

session_start();

// Jika tidak ada sesi admin, arahkan ke login
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_SESSION['admin'];
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Verifikasi password lama
    $query = "SELECT * FROM admin WHERE username = '$username' AND password = MD5('$old_password')";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        // Cek apakah password baru dan konfirmasi password cocok
        if ($new_password === $confirm_password) {
            // Update password
            $query = "UPDATE admin SET password = MD5('$new_password') WHERE username = '$username'";
            if ($conn->query($query)) {
                echo "<script>alert('Password berhasil diubah!'); window.location.href = 'login.php';</script>";
            } else {
                echo "<script>alert('Gagal mengubah password!');</script>";
            }
        } else {
            echo "<script>alert('Password baru dan konfirmasi password tidak cocok.');</script>";
        }
    } else {
        echo "<script>alert('Password lama salah!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubah Password</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #00274d;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-size: cover;
            background-position: center;
        }

        .container {
            width: 100%;
            background-color: #ffff;
            max-width: 400px;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            text-align: center;
            animation: fadeInUp 1s ease-out;
        }

        @keyframes fadeInUp {
            0% {
                opacity: 0;
                transform: translateY(50px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        h1 {
            margin-bottom: 20px;
            color: #333;
            font-size: 2rem;
        }

        .form-group {
            margin-bottom: 15px;
            text-align: left;
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #333;
            font-weight: bold;
        }

        input {
            width: 100%;
            padding: 12px;
            margin: 8px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 1rem;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            color: white;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
            font-size: 1.1rem;
        }

        button:hover {
            background-color: #0056b3;
            transform: translateY(-3px); /* Efek tombol melayang */
        }

        button:active {
            transform: translateY(1px); /* Efek saat tombol ditekan */
        }

        /* Mobile responsive */
        @media (max-width: 480px) {
            .container {
                padding: 20px;
            }

            h1 {
                font-size: 1.5rem;
            }

            button {
                font-size: 1rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Ubah Password</h1>
        <form action="akun.php" method="POST">
            <div class="form-group">
                <label for="old_password">Password Lama:</label>
                <input type="password" id="old_password" name="old_password" required>
            </div>
            <div class="form-group">
                <label for="new_password">Password Baru:</label>
                <input type="password" id="new_password" name="new_password" required>
            </div>
            <div class="form-group">
                <label for="confirm_password">Konfirmasi Password Baru:</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
            </div>
            <button type="submit">Ubah Password</button>
        </form>
    </div>
</body>
</html>
