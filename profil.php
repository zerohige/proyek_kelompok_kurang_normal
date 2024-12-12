<?php
session_start();
include 'config/database.php';

// Periksa apakah admin sudah login
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

// Ambil data admin yang sedang login
$username = $_SESSION['admin'];
$query_admin = "SELECT id, username FROM admin WHERE username = '$username'";
$result_admin = $conn->query($query_admin);
$admin_data = $result_admin->fetch_assoc();

if (!$admin_data) {
    echo "Admin tidak ditemukan!";
    exit();
}

// Fungsi logout
if (isset($_POST['logout'])) {
    // Update status is_logged_in menjadi 0
    $logout_query = "UPDATE admin SET is_logged_in = 0 WHERE username = '$username'";
    $conn->query($logout_query);

    // Hapus sesi dan redirect ke halaman login
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit();
}

// Tambahkan akun admin baru
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['new_username'], $_POST['new_password'], $_POST['new_email'])) {
    $new_username = $_POST['new_username'];
    $new_password = password_hash($_POST['new_password'], PASSWORD_DEFAULT); // Hash password
    $new_email = $_POST['new_email'];

    $insert_query = "INSERT INTO admin (username, email, password) VALUES ('$new_username', '$new_email', '$new_password')";
    if ($conn->query($insert_query)) {
        echo "<script>alert('Akun admin baru berhasil ditambahkan!'); window.location.href = 'profil.php';</script>";
    } else {
        echo "<script>alert('Gagal menambahkan akun admin baru!'); window.history.back();</script>";
    }
}

// Ubah password admin
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['change_password'], $_POST['new_password_id'])) {
    $new_password_id = $_POST['new_password_id'];
    $new_password = password_hash($_POST['new_password'], PASSWORD_DEFAULT); // Hash password

    $update_query = "UPDATE admin SET password = '$new_password' WHERE id = $new_password_id";
    if ($conn->query($update_query)) {
        echo "<script>alert('Password berhasil diubah!'); window.location.href = 'profil.php';</script>";
    } else {
        echo "<script>alert('Gagal mengubah password!'); window.history.back();</script>";
    }
}

// Hapus akun admin berdasarkan ID
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_admin_id'])) {
    $delete_admin_id = $_POST['delete_admin_id'];

    // Pastikan admin yang sedang login tidak menghapus dirinya sendiri
    if ($delete_admin_id == $admin_data['id']) {
        echo "<script>alert('Anda tidak dapat menghapus akun Anda sendiri!'); window.location.href = 'profil.php';</script>";
        exit();
    }

    // Query untuk menghapus akun admin berdasarkan ID
    $delete_query = "DELETE FROM admin WHERE id = $delete_admin_id";
    if ($conn->query($delete_query)) {
        echo "<script>alert('Akun admin berhasil dihapus!'); window.location.href = 'profil.php';</script>";
    } else {
        echo "<script>alert('Gagal menghapus akun admin!'); window.history.back();</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f6f9;
            font-family: 'Arial', sans-serif;
        }

        .container {
            margin-top: 50px;
        }

        h1 {
            color: #333;
            font-size: 2.5rem;
            margin-bottom: 30px;
        }

        .form-label {
            font-weight: bold;
            color: #333;
        }

        .table th, .table td {
            text-align: center;
        }

        .btn-danger {
            transition: background-color 0.3s ease;
        }

        .btn-danger:hover {
            background-color: #d9534f;
        }

        .btn-logout {
            transition: background-color 0.3s ease;
        }

        .btn-logout:hover {
            background-color: #dc3545;
        }

        .card-custom {
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        /* Responsif untuk tampilan mobile */
        @media (max-width: 768px) {
            .container {
                padding: 0 15px;
            }

            h1 {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <div class="d-flex justify-content-between align-items-center">
        <h1>Profil Admin</h1>
        <form action="profil.php" method="POST">
            <button type="submit" name="logout" class="btn btn-logout">Logout <i class="fa fa-sign-out"></i></button>
        </form>
    </div>

    <div class="card card-custom mb-4">
        <div class="card-body">
            <h5>Username: <?= htmlspecialchars($admin_data['username']) ?></h5>
            <h5>ID: <?= htmlspecialchars($admin_data['id']) ?></h5>
        </div>
    </div>

    <!-- Form Menambahkan Admin Baru -->
    <div class="card card-custom mb-4">
        <div class="card-body">
            <h3>Tambah Akun Admin Baru</h3>
            <form action="profil.php" method="POST">
                <div class="mb-3">
                    <label for="new_username" class="form-label">Username:</label>
                    <input type="text" id="new_username" name="new_username" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="new_email" class="form-label">Email:</label>
                    <input type="email" id="new_email" name="new_email" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="new_password" class="form-label">Password:</label>
                    <input type="password" id="new_password" name="new_password" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">Tambah Admin Baru</button>
            </form>
        </div>
    </div>

    <!-- Form Mengubah Password -->
    <div class="card card-custom mb-4">
        <div class="card-body">
            <h3>Ubah Password</h3>
            <form action="profil.php" method="POST">
                <div class="mb-3">
                    <label for="new_password_id" class="form-label">ID Admin yang ingin diubah password-nya:</label>
                    <input type="number" id="new_password_id" name="new_password_id" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="new_password" class="form-label">Password Baru:</label>
                    <input type="password" id="new_password" name="new_password" class="form-control" required>
                </div>
                <button type="submit" name="change_password" class="btn btn-warning">Ubah Password</button>
            </form>
        </div>
    </div>

    <!-- Form Menghapus Admin -->
    <div class="card card-custom mb-4">
        <div class="card-body">
            <h3>Hapus Akun Admin</h3>
            <form action="profil.php" method="POST">
                <div class="mb-3">
                    <label for="delete_admin_id" class="form-label">ID Admin yang ingin dihapus:</label>
                    <input type="number" id="delete_admin_id" name="delete_admin_id" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-danger">Hapus Admin</button>
            </form>
        </div>
    </div>
</div>

</body>
</html>
