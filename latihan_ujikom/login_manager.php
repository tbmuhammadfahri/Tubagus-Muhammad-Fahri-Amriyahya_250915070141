<?php
session_start();
include "koneksi.php";

// cek koneksi database
if (!$koneksi) {
    die("❌ Koneksi database gagal: " . mysqli_connect_error());
}

// Handle Login Manager
if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = mysqli_real_escape_string($koneksi, $_POST['password']);

    $query = "SELECT m.*, l.level 
              FROM manager m 
              LEFT JOIN level l ON m.id_level = l.id_level 
              WHERE username='$username' LIMIT 1";

    $result = mysqli_query($koneksi, $query) or die("❌ Query error: " . mysqli_error($koneksi));

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        // debug: cek password dari DB
       //

        if ($password == $row['password']) {
            echo "✅ Login sukses! Sedang redirect...";

            $_SESSION['id_manager'] = $row['id_manager'];
            $_SESSION['nama_manager']  = $row['nama_manager'];
            $_SESSION['id_level']      = $row['id_level'];
            $_SESSION['role']          = "Manager";

            header("refresh:2; url=dashboard_manager.php");
            exit;
        } else {
            $error = "❌ Password salah!";
        }
    } else {
        $error = "❌ Username tidak ditemukan!";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login Manager</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; }
        .box { width: 350px; margin: 80px auto; padding: 20px; background: white; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); text-align: center; }
        h2 { margin-bottom: 20px; }
        input { width: 94%; padding: 10px; margin: 8px 0; border-radius: 5px; border: 1px solid #ccc; }
        button, a.btn-link {
            display: block; width: 94%; padding: 10px; margin-top: 10px;
            border: none; border-radius: 5px; cursor: pointer; font-size: 16px; text-decoration: none; text-align: center;
        }
        .btn-login { background: #28a745; color: white; }
        .btn-daftar { background: #007bff; color: white; }
        .btn-back { background: #6c757d; color: white; }
        .error { color: red; margin: 10px 0; }
    </style>
</head>
<body>
    <div class="box">
        <h2>Login Manager</h2>
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
        
        <form method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" name="login" class="btn-login">Login</button>
        </form>

        <!-- Tombol ke halaman daftar manager -->
        <a href="daftar_manager.php" class="btn-link btn-daftar">Daftar Manager</a>

        <!-- Tombol kembali ke index -->
        <a href="index.html" class="btn-link btn-back">← Kembali ke Index</a>
    </div>
</body>
</html>
