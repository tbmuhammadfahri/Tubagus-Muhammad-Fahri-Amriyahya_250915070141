<?php
include "koneksi.php";
$id = $_GET['id'];
$q = mysqli_query($koneksi, "SELECT * FROM identitas WHERE id_identitas='$id'");
$row = mysqli_fetch_assoc($q);

if (isset($_POST['update'])) {
    $nama     = $_POST['nama_identitas'];
    $badan    = $_POST['badan_hukum'];
    $npwp     = $_POST['npwp'];
    $email    = $_POST['email'];
    $url      = $_POST['url'];
    $alamat   = $_POST['alamat'];
    $telp     = $_POST['telp'];
    $fax      = $_POST['fax'];
    $rekening = $_POST['rekening'];

    $foto = $row['foto'];
    if ($_FILES['foto']['name']) {
        $target = "uploads/" . basename($_FILES['foto']['name']);
        move_uploaded_file($_FILES['foto']['tmp_name'], $target);
        $foto = $target;
    }

    mysqli_query($koneksi, "UPDATE identitas SET 
        nama_identitas='$nama',
        badan_hukum='$badan',
        npwp='$npwp',
        email='$email',
        url='$url',
        alamat='$alamat',
        telp='$telp',
        fax='$fax',
        rekening='$rekening',
        foto='$foto'
        WHERE id_identitas='$id'");
    header("Location: identitas_index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Identitas</title>
    <style>
        body { font-family: Arial, sans-serif; background:#f4f4f4; margin:0; }
        .main { margin-left:220px; padding:20px; }
        .form-box { background:white; padding:25px 30px; border-radius:8px; box-shadow:0 4px 15px rgba(0,0,0,0.1); width:600px; margin:auto; }
        h2 { text-align:center; margin-top:0; margin-bottom:20px; color:#333; }
        input, textarea, select {
            width:100%; padding:10px; margin:8px 0 15px;
            border:1px solid #ccc; border-radius:5px; font-size:14px;
        }
        textarea { resize: vertical; min-height:70px; }
        button {
            width:100%; padding:10px; background:#ffc107;
            border:none; border-radius:5px; color:#000; font-size:15px;
            cursor:pointer; transition:0.3s;
        }
        button:hover { background:#e0a800; }
        .back-link {
            display:block; text-align:center; margin-top:15px;
            text-decoration:none; color:#007bff; font-size:14px;
        }
        .back-link:hover { text-decoration:underline; }
        img.preview { display:block; margin-top:10px; max-height:60px; }
    </style>
</head>
<body>
    <?php include "sidebar.php"; ?>
    <div class="main">
        <div class="form-box">
            <h2>Edit Identitas</h2>
            <form method="POST" enctype="multipart/form-data">
                <input type="text" name="nama_identitas" value="<?= $row['nama_identitas']; ?>" required>
                <input type="text" name="badan_hukum" value="<?= $row['badan_hukum']; ?>">
                <input type="text" name="npwp" value="<?= $row['npwp']; ?>">
                <input type="email" name="email" value="<?= $row['email']; ?>">
                <input type="text" name="url" value="<?= $row['url']; ?>">
                <textarea name="alamat"><?= $row['alamat']; ?></textarea>
                <input type="text" name="telp" value="<?= $row['telp']; ?>">
                <input type="text" name="fax" value="<?= $row['fax']; ?>">
                <input type="text" name="rekening" value="<?= $row['rekening']; ?>">
                <input type="file" name="foto">
                <?php if($row['foto']) echo "<img src='{$row['foto']}' class='preview'>"; ?>
                <button type="submit" name="update">Update</button>
            </form>
            <a href="identitas_index.php" class="back-link">← Kembali</a>
        </div>
    </div>
</body>
</html>
