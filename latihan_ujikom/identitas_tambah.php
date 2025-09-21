<?php
include "koneksi.php";
if (isset($_POST['simpan'])) {
    $nama     = $_POST['nama_identitas'];
    $badan    = $_POST['badan_hukum'];
    $npwp     = $_POST['npwp'];
    $email    = $_POST['email'];
    $url      = $_POST['url'];
    $alamat   = $_POST['alamat'];
    $telp     = $_POST['telp'];
    $fax      = $_POST['fax'];
    $rekening = $_POST['rekening'];

    // upload foto
    $foto = "";
if ($_FILES['foto']['name']) {
    $filename = basename($_FILES['foto']['name']);
    $target = "uploads/" . $filename;
    move_uploaded_file($_FILES['foto']['tmp_name'], $target);
    $foto = $filename; // hanya simpan nama file
}


    mysqli_query($koneksi, "INSERT INTO identitas 
        (nama_identitas, badan_hukum, npwp, email, url, alamat, telp, fax, rekening, foto) 
        VALUES 
        ('$nama','$badan','$npwp','$email','$url','$alamat','$telp','$fax','$rekening','$foto')");
    header("Location: identitas_index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Identitas</title>
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
            width:100%; padding:10px; background:#28a745;
            border:none; border-radius:5px; color:white; font-size:15px;
            cursor:pointer; transition:0.3s;
        }
        button:hover { background:#218838; }
        .back-link {
            display:block; text-align:center; margin-top:15px;
            text-decoration:none; color:#007bff; font-size:14px;
        }
        .back-link:hover { text-decoration:underline; }
    </style>
</head>
<body>
    <?php include "sidebar.php"; ?>
    <div class="main">
        <div class="form-box">
            <h2>Tambah Identitas</h2>
            <form method="POST" enctype="multipart/form-data">
                <input type="text" name="nama_identitas" placeholder="Nama Identitas" required>
                <input type="text" name="badan_hukum" placeholder="Badan Hukum">
                <input type="text" name="npwp" placeholder="NPWP">
                <input type="email" name="email" placeholder="Email">
                <input type="text" name="url" placeholder="Website">
                <textarea name="alamat" placeholder="Alamat"></textarea>
                <input type="text" name="telp" placeholder="Telp">
                <input type="text" name="fax" placeholder="Fax">
                <input type="text" name="rekening" placeholder="Rekening">
                <input type="file" name="foto">
                <button type="submit" name="simpan">Simpan</button>
            </form>
            <a href="identitas_index.php" class="back-link">← Kembali</a>
        </div>
    </div>
</body>
</html>
        