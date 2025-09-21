<?php
include "koneksi.php";
$id = $_GET['id'];
$q = mysqli_query($koneksi, "SELECT * FROM sales WHERE id_sales=$id");
$data = mysqli_fetch_assoc($q);

if (isset($_POST['update'])) {
    $tgl_sales = $_POST['tgl_sales'];
    $id_customer = $_POST['id_customer'];
    $do_number = $_POST['do_number'];
    $status = $_POST['status'];

    mysqli_query($koneksi, "UPDATE sales SET 
        tgl_sales='$tgl_sales',
        id_customer='$id_customer',
        do_number='$do_number',
        status='$status'
        WHERE id_sales=$id");
    header("Location: sales_index.php");
}

$customers = mysqli_query($koneksi,"SELECT * FROM customer");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Sales</title>
    <style>
        body { font-family: Arial, sans-serif; background:#f4f4f4; margin:0; }
        .main { margin-left:220px; padding:20px; }
        .content-box { background:white; padding:20px; border-radius:5px; box-shadow:0 4px 10px rgba(0,0,0,0.1); width:500px; }
        label { display:block; margin-top:10px; }
        input, select { width:100%; padding:7px; margin-top:5px; }
        button { margin-top:15px; padding:8px 15px; background:#ffc107; color:black; border:none; border-radius:3px; cursor:pointer; }
    </style>
</head>
<body>
<?php include "sidebar.php"; ?>
<div class="main">
    <div class="content-box">
        <h2>Edit Transaksi</h2>
        <form method="post">
            <label>Tanggal</label>
            <input type="date" name="tgl_sales" value="<?= $data['tgl_sales']; ?>" required>

            <label>Customer</label>
            <select name="id_customer" required>
                <?php while($c=mysqli_fetch_assoc($customers)) { ?>
                    <option value="<?= $c['id_customer']; ?>" <?= $c['id_customer']==$data['id_customer']?'selected':''; ?>>
                        <?= $c['nama_customer']; ?>
                    </option>
                <?php } ?>
            </select>

            <label>DO Number</label>
            <input type="text" name="do_number" value="<?= $data['do_number']; ?>" required>

            <label>Status</label>
            <select name="status">
                <option value="Belum Lunas" <?= $data['status']=='Belum Lunas'?'selected':''; ?>>Belum Lunas</option>
                <option value="Lunas" <?= $data['status']=='Lunas'?'selected':''; ?>>Lunas</option>
            </select>

            <button type="submit" name="update">Update</button>
            <a href="sales_index.php" class="back-link">Kembali</a>
        </form>
    </div>
</div>
</body>
</html>
