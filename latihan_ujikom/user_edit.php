<?php
include "koneksi.php";
$id   = $_GET['id'];
$role = $_GET['role'];

// Ambil data user sesuai role
if ($role == "Petugas") {
    $q = mysqli_query($koneksi, "SELECT * FROM petugas WHERE id_user='$id'");
    $row = mysqli_fetch_assoc($q);
    $nama = $row['nama_user'];
} else {
    $q = mysqli_query($koneksi, "SELECT * FROM manager WHERE id_manager='$id'");
    $row = mysqli_fetch_assoc($q);
    $nama = $row['nama_manager'];
}

// Update data user
if (isset($_POST['update'])) {
    $nama     = $_POST['nama'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($role == "Petugas") {
        mysqli_query($koneksi, "UPDATE petugas 
                                SET nama_user='$nama', username='$username', password='$password' 
                                WHERE id_user='$id'");
    } else {
        mysqli_query($koneksi, "UPDATE manager 
                                SET nama_manager='$nama', username='$username', password='$password' 
                                WHERE id_manager='$id'");
    }
    header("Location: user_index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit User</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            margin: 0;
        }
        .main {
            margin-left: 220px; /* biar tidak ketimpa sidebar */
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
        input {
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
            background: #ffc107;
            border: none;
            border-radius: 5px;
            color: black;
            font-size: 15px;
            cursor: pointer;
            transition: 0.3s;
        }
        button:hover {
            background: #e0a800;
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
            <h2>Edit User (<?php echo $role; ?>)</h2>
            <form method="POST">
                <input type="text" name="nama" value="<?php echo $nama; ?>" required>
                <input type="text" name="username" value="<?php echo $row['username']; ?>" required>
                <input type="password" name="password" value="<?php echo $row['password']; ?>" required>
                <button type="submit" name="update">Update</button>
            </form>
            <a href="user_index.php" class="back-link">Kembali</a>
        </div>
    </div>
</body>
</html>
