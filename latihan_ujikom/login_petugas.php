    <?php
    session_start();
    include "koneksi.php";

    // Handle Login
    if (isset($_POST['login'])) {
        $username = mysqli_real_escape_string($koneksi, $_POST['username']);
        $password = mysqli_real_escape_string($koneksi, $_POST['password']);

        $query = "SELECT p.*, l.level 
                FROM petugas p 
                LEFT JOIN level l ON p.id_level = l.id_level 
                WHERE username='$username' LIMIT 1";
        $result = mysqli_query($koneksi, $query);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);

            if ($password == $row['password']) {
                $_SESSION['id_user']   = $row['id_user'];
                $_SESSION['nama_user'] = $row['nama_user'];
                $_SESSION['id_level']     = $row['id_level'];
                $_SESSION['role']      = "petugas";

                header("Location: dashboard_petugas.php");
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
        <title>Login Petugas</title>
        <style>
            body { font-family: Arial, sans-serif; background: #f4f4f4; }
            .box { width: 350px; margin: 80px auto; padding: 20px; background: white; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); text-align: center; }
            h2 { margin-bottom: 20px; }
            input { width: 94%; padding: 10px; margin: 8px 0; border-radius: 5px; border: 1px solid #ccc; }
            button, a.btn-link {
                display: block; width: 95%; padding: 10px; margin-top: 10px;
                border: none; border-radius: 5px; cursor: pointer; font-size: 16px; text-decoration: none; text-align: center;
            }
            .btn-login { background: #007bff; color: white; }
            .btn-daftar { background: #28a745; color: white; }
            .btn-back { background: #6c757d; color: white; }
            .error { color: red; margin: 10px 0; }
        </style>
    </head>
    <body>
        <div class="box">
            <h2>Login Petugas</h2>
            <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
            
            <form method="POST">
                <input type="text" name="username" placeholder="Username" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit" name="login" class="btn-login">Login</button>
            </form>

            <!-- Tombol ke halaman daftar petugas -->
            <a href="daftar_petugas.php" class="btn-link btn-daftar">Daftar Petugas</a>

            <!-- Tombol kembali ke index -->
            <a href="index.html" class="btn-link btn-back">← Kembali ke Index</a>
        </div>
    </body>
    </html>
