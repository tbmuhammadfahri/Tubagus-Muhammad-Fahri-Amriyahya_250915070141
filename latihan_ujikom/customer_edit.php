<?php
include "koneksi.php";
$id = $_GET['id'];
$q = mysqli_query($koneksi, "SELECT * FROM customer WHERE id_customer='$id'");
$row = mysqli_fetch_assoc($q);

if (isset($_POST['update'])) {
    $nama   = $_POST['nama_customer'];
    $alamat = $_POST['alamat'];
    $telp   = $_POST['telp'];
    $fax    = $_POST['fax'];
    $email  = $_POST['email'];

    mysqli_query($koneksi, "UPDATE customer 
                SET nama_customer='$nama', alamat='$alamat', telp='$telp', fax='$fax', email='$email'
                WHERE id_customer='$id'");
    header("Location: customer_index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Customer</title>
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
            background:#ffc107; color:black;
            padding:10px; border:none; border-radius:3px;
            cursor:pointer; font-size:14px;
        }
        button:hover { background:#e0a800; }
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
            <h2>Edit Customer</h2>
            <form method="POST">
                <input type="text" name="nama_customer" value="<?php echo $row['nama_customer']; ?>" required>
                <input type="text" name="alamat" value="<?php echo $row['alamat']; ?>">
                <input type="text" name="telp" value="<?php echo $row['telp']; ?>">
                <input type="text" name="fax" value="<?php echo $row['fax']; ?>">
                <input type="email" name="email" value="<?php echo $row['email']; ?>">
                <button type="submit" name="update">Update</button>
            </form>
            <a href="customer_index.php" class="back-link">← Kembali</a>
        </div>
    </div>
</body>
</html>
