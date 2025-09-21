<?php
include "koneksi.php";
$id = $_GET['id'];
$q = mysqli_query($koneksi, "SELECT * FROM item WHERE id_item='$id'");
$row = mysqli_fetch_assoc($q);

if (isset($_POST['update'])) {
    $nama  = $_POST['nama_item'];
    $uom   = $_POST['uom'];
    $beli  = $_POST['harga_beli'];
    $jual  = $_POST['harga_jual'];

    mysqli_query($koneksi, "UPDATE item 
                SET nama_item='$nama', uom='$uom', harga_beli='$beli', harga_jual='$jual'
                WHERE id_item='$id'");
    header("Location: item_index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Item</title>
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
        input {
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
            <h2>Edit Item</h2>
            <form method="POST">
                <input type="text" name="nama_item" value="<?php echo $row['nama_item']; ?>" required>
                <input type="text" name="uom" value="<?php echo $row['uom']; ?>">
                <input type="number" name="harga_beli" value="<?php echo $row['harga_beli']; ?>" required>
                <input type="number" name="harga_jual" value="<?php echo $row['harga_jual']; ?>" required>
                <button type="submit" name="update">Update</button>
            </form>
            <a href="item_index.php" class="back-link">← Kembali</a>
        </div>
    </div>
</body>
</html>
