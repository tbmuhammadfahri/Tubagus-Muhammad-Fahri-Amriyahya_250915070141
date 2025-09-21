<?php
include "koneksi.php";
if (isset($_POST['simpan'])) {
    $nama   = $_POST['nama_customer'];
    $alamat = $_POST['alamat'];
    $telp   = $_POST['telp'];
    $fax    = $_POST['fax'];
    $email  = $_POST['email'];

    mysqli_query($koneksi, "INSERT INTO customer (nama_customer, alamat, telp, fax, email) 
                VALUES ('$nama','$alamat','$telp','$fax','$email')");
    header("Location: customer_index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Customer</title>
    <style>
        body { font-family: Arial, sans-serif; background:#f4f4f4; margin:0; }
        .main { margin-left:220px; padding:20px; }
        .content-box {
            background:white; padding:20px;
            border-radius:5px; box-shadow:0 4px 10px rgba(0,0,0,0.1);
            max-width:600px; margin:auto;
        }
        h2 { margin-top:0; text-align:center; color:#333; }
        form { display:flex; flex-direction:column; }
        input, textarea {
            margin-bottom:10px; padding:8px;
            border:1px solid #ccc; border-radius:3px;
            font-size:14px;
        }
        button {
            background:#28a745; color:white;
            padding:10px; border:none; border-radius:3px;
            cursor:pointer; font-size:14px;
        }
        button:hover { background:#218838; }
        a.back-link {
            display:inline-block; margin-top:10px;
            text-decoration:none; color:#007bff;
            font-size:14px;
        }
    </style>
</head>
<body>
    <?php include "sidebar.php"; ?>
    <div class="main">
        <div class="content-box">
            <h2>Tambah Customer</h2>
            <form method="POST">
                <input type="text" name="nama_customer" placeholder="Nama Customer" required>
                <input type="text" name="alamat" placeholder="Alamat">
                <input type="text" name="telp" placeholder="Telp">
                <input type="text" name="fax" placeholder="Fax">
                <input type="email" name="email" placeholder="Email">
                <button type="submit" name="simpan">Simpan</button>
            </form>
            <a href="customer_index.php" class="back-link">← Kembali</a>
        </div>
    </div>
</body>
</html>
