<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
            background-color: #002741;
        }

        .container {
            text-align: center;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        h1 {
            margin-bottom: 20px;
        }

        button {
            padding: 15px 30px;
            font-size: 16px;
            cursor: pointer;
            margin: 10px;
            border: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .admin-btn {
            background-color: #007bff;
            color: white;
        }

        .admin-btn:hover {
            background-color: #0056b3;
        }

        .user-btn {
            background-color: #28a745;
            color: white;
        }

        .user-btn:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Selamat Datang</h1>
    <p>Pilih untuk login sebagai:</p>
    <a href="login.php">
        <button class="admin-btn">Saya Adalah Admin</button>
    </a>
    <a href="formulir.php">
        <button class="user-btn">Saya Adalah Pengguna</button>
    </a>
</div>

</body>
</html>
