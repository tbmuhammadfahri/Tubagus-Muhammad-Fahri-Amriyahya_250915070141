<?php
include "koneksi.php";

if (isset($_POST['simpan'])) {
    $nama     = $_POST['nama'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role     = $_POST['role'];

    if ($role == "Petugas") {
        mysqli_query($koneksi, "INSERT INTO petugas (nama_user, username, password) 
                                VALUES ('$nama','$username','$password')");
    } else {
        mysqli_query($koneksi, "INSERT INTO manager (nama_manager, username, password) 
                                VALUES ('$nama','$username','$password')");
    }
    header("Location: user_index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah User</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            margin: 0;
        }
        .main {
            margin-left: 220px; /* sesuaikan dengan lebar sidebar */
            padding: 20px;
        }
        .content-box {
            background: #fff;
            padding: 25px 30px;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            max-width: 450px;
        }
        h2 {
            margin-top: 0;
            margin-bottom: 20px;
            text-align: center;
            color: #333;
        }
        input, select {
            width: 100%;
            padding: 10px;
            margin: 8px 0 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
        }
        button {
            width: 100%;
            padding: 10px;
            background: #28a745;
            border: none;
            border-radius: 5px;
            color: white;
            font-size: 15px;
            cursor: pointer;
            transition: 0.3s;
        }
        button:hover {
            background: #218838;
        }
        .back-link {
            display: block;
            text-align: center;
            margin-top: 15px;
            text-decoration: none;
            color: #007bff;
            font-size: 14px;
        }
        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <?php include "sidebar.php"; ?>
    <div class="main">
        <div class="content-box">
            <h2>Tambah User</h2>
            <form method="POST">
                <input type="text" name="nama" placeholder="Nama User" required>
                <input type="text" name="username" placeholder="Username" required>
                <input type="password" name="password" placeholder="Password" required>
                <select name="role" required>
                    <option value="">-- Pilih Role --</option>
                    <option value="Petugas">Petugas</option>
                    <option value="Manager">Manager</option>
                </select>
                <button type="submit" name="simpan">Simpan</button>
            </form>
            <a href="user_index.php" class="back-link">Kembali</a>
        </div>
    </div>
</body>
</html>
