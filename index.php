<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Login</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            height: 100vh;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #002741;
            color: #fff;
            overflow: hidden;
        }

        .container {
            text-align: center;
            padding: 30px;
            background-color: #fff;
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.15);
            border-radius: 12px;
            width: 90%;
            max-width: 500px;
            transform: translateY(-50px);
            opacity: 0;
            animation: fadeIn 1s ease-in-out forwards, slideUp 0.6s ease-out forwards;
        }

        @keyframes fadeIn {
            to {
                opacity: 1;
            }
        }

        @keyframes slideUp {
            to {
                transform: translateY(0);
            }
        }

        h1 {
            font-size: 2.5rem;
            margin-bottom: 20px;
            color: #333;
            font-weight: bold;
        }

        h2 {
            font-size: 1.2rem;
            margin-bottom: 10px;
            color: #555;
        }

        p {
            margin-top: 10px;
            font-size: 1.1rem;
        }

        button {
            padding: 12px 25px;
            font-size: 16px;
            cursor: pointer;
            margin: 15px 10px;
            border: none;
            border-radius: 6px;
            transition: all 0.3s ease;
            width: 150px;
        }

        .admin-btn {
            background-color: #007bff;
            color: white;
            transform: scale(1);
        }

        .admin-btn:hover {
            background-color: #0056b3;
            transform: scale(1.05);
        }

        .user-btn {
            background-color: #28a745;
            color: white;
            transform: scale(1);
        }

        .user-btn:hover {
            background-color: #218838;
            transform: scale(1.05);
        }

        .container a {
            text-decoration: none;
        }

        /* Animasi untuk tombol */
        button:focus {
            outline: none;
        }

        /* Mobile responsiveness */
        @media (max-width: 600px) {
            h1 {
                font-size: 2rem;
            }

            button {
                width: 100%;
                padding: 15px;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Selamat Datang Di Formulir</h2>
    <h2>Permintaan Barang Habis Pakai(ATK)</h2>
    <h1>Fakultas Teknik dan Teknologi Kemaritiman</h1>
    <p>Kamu disini sebagai :</p>
    <a href="login.php">
        <button class="admin-btn">Admin</button>
    </a>
    <a href="formulir.php">
        <button class="user-btn">Pengguna</button>
    </a>
</div>

</body>
</html>
