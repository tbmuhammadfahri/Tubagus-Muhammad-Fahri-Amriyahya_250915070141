<?php
include "koneksi.php";

if (isset($_POST['simpan'])) {
    $tgl_sales = date("Y-m-d"); // tanggal otomatis
    $id_customer = $_POST['id_customer'];
    $do_number = $_POST['do_number'];
    $status = $_POST['status'];

    mysqli_query($koneksi, "INSERT INTO sales (tgl_sales,id_customer,do_number,`status`) 
                            VALUES ('$tgl_sales','$id_customer','$do_number','$status')");
    $id_sales = mysqli_insert_id($koneksi); // ambil id terakhir

    header("Location: sales_detail.php?id=$id_sales");
    exit;
}

$customers = mysqli_query($koneksi,"SELECT * FROM customer");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Sales</title>
    <style>
        body { font-family: Arial, sans-serif; background:#f4f4f4; margin:0; }
        .main { margin-left:220px; padding:20px; }
        .content-box { background:white; padding:20px; border-radius:5px; box-shadow:0 4px 10px rgba(0,0,0,0.1); }
        h2 { margin-top:0; }
        label { display:block; margin-top:10px; font-weight:bold; }
        select, input[type="text"], button {
            padding:8px; margin-top:5px; width:100%; max-width:400px; 
            border:1px solid #ccc; border-radius:4px;
        }
        button {
            background:#28a745; color:white; border:none; cursor:pointer; margin-top:15px;
        }
        button:hover { background:#218838; }
    </style>
</head>
<body>
<?php include "sidebar.php"; ?>
<div class="main">
    <div class="content-box">
        <h2>Tambah Transaksi</h2>
        <form method="post">
            <label>Customer</label>
            <select name="id_customer" required>
                <option value="">- Pilih -</option>
                <?php while($c=mysqli_fetch_assoc($customers)) { ?>
                    <option value="<?= $c['id_customer']; ?>"><?= $c['nama_customer']; ?></option>
                <?php } ?>
            </select>

            <label>DO Number</label>
            <input type="text" name="do_number" required>

            

            <button type="submit" name="simpan">➕ Lanjut ke Detail</button>
        </form>
    </div>
</div>
</body>
</html>
