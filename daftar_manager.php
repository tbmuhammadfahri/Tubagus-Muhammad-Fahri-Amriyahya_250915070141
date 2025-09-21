<?php
include "koneksi.php";

if (isset($_POST['register'])) {
    $nama     = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = mysqli_real_escape_string($koneksi, $_POST['password']);
    $id_level = mysqli_real_escape_string($koneksi, $_POST['id_level']);

    // Cek apakah username sudah ada
    $cek = mysqli_query($koneksi, "SELECT * FROM manager WHERE username='$username'");
    if (mysqli_num_rows($cek) > 0) {
        $error = "❌ Username sudah dipakai!";
    } else {
        $query = "INSERT INTO manager (nama_manager, username, password, id_level) 
                  VALUES ('$nama', '$username', '$password', '$id_level')";
        if (mysqli_query($koneksi, $query)) {
            $success = "✅ Pendaftaran berhasil! Silakan login.";
        } else {
            $error = "❌ Gagal daftar: " . mysqli_error($koneksi);
        }
    }
}

// Ambil data level untuk dropdown
$level_result = mysqli_query($koneksi, "SELECT * FROM level ORDER BY level ASC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Manager</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; }
        .box { width: 350px; margin: 60px auto; padding: 20px; background: white; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
        h2 { text-align: center; margin-bottom: 15px; }
        input, select { width: 94%; padding: 10px; margin: 8px 0; border-radius: 5px; border: 1px solid #ccc; }
        button { width: 100%; padding: 10px; margin-top: 10px; border: none; border-radius: 5px; cursor: pointer; font-size: 16px; }
        .btn-register { background: #28a745; color: white; }
        .btn-back { background: #6c757d; color: white; text-decoration: none; display: block; text-align: center; margin-top: 10px; padding: 10px; border-radius: 5px; }
        .msg { text-align: center; margin: 10px 0; }
        .error { color: red; }
        .success { color: green; }
    </style>
</head>
<body>
    <div class="box">
        <h2>Daftar Manager</h2>
        <?php 
        if (isset($error)) echo "<p class='msg error'>$error</p>"; 
        if (isset($success)) echo "<p class='msg success'>$success</p>"; 
        ?>
        <form method="POST">
            <input type="text" name="nama" placeholder="Nama Lengkap" required>
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <select name="id_level" required>
                <option value="">-- Pilih Level --</option>
                <?php while ($lvl = mysqli_fetch_assoc($level_result)) { ?>
                    <option value="<?php echo $lvl['id_level']; ?>">
                        <?php echo $lvl['level']; ?>
                    </option>
                <?php } ?>
            </select>
            <button type="submit" name="register" class="btn-register">Daftar</button>
        </form>
        <a href="login_manager.php" class="btn-back">← Kembali ke Login</a>
    </div>
</body>
</html>
