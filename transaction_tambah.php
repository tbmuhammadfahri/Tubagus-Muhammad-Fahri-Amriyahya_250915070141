<?php
include "koneksi.php";
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (isset($_POST['simpan'])) {
    $id_sales = $_POST['id_sales'];
    $id_item = $_POST['id_item'];
    $qty = $_POST['quantity'];

    // ambil harga item dari tabel item
    $item = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT harga_jual FROM item WHERE id_item='$id_item'"));
    $price = $item['harga_jual'];
    $amount = $qty * $price;

    mysqli_query($koneksi, "INSERT INTO transaction (id_sales,id_item,quantity,price,amount) 
                            VALUES ('$id_sales','$id_item','$qty','$price','$amount')");
    header("Location: transaction_index.php");
    exit;
}

$sales = mysqli_query($koneksi,"SELECT * FROM sales ORDER BY id_sales DESC");
$items = mysqli_query($koneksi,"SELECT * FROM item");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Transaksi</title>
    <style>
        body { font-family: Arial, sans-serif; background:#f4f4f4; margin:0; }
        .main { margin-left:220px; padding:20px; }
        .content-box { background:white; padding:20px; border-radius:5px; box-shadow:0 4px 10px rgba(0,0,0,0.1); }
        h2 { margin-top:0; }
        label { display:block; margin-top:10px; }
        input, select { padding:8px; width:100%; max-width:300px; margin-top:5px; }
        button { margin-top:15px; padding:8px 15px; border:none; border-radius:4px; background:#28a745; color:white; cursor:pointer; }
        button:hover { background:#218838; }
    </style>
</head>
<body>
<?php include "sidebar.php"; ?>
<div class="main">
    <div class="content-box">
        <h2>Tambah Transaksi</h2>
        <form method="post">
            <label>Sales</label>
            <select name="id_sales" required>
                <option value="">- Pilih Sales -</option>
                <?php while($s=mysqli_fetch_assoc($sales)) { ?>
                    <option value="<?= $s['id_sales']; ?>">INV<?= str_pad($s['id_sales'], 4, "0", STR_PAD_LEFT); ?></option>
                <?php } ?>
            </select>

            <label>Item</label>
            <select name="id_item" required>
                <option value="">- Pilih Item -</option>
                <?php while($i=mysqli_fetch_assoc($items)) { ?>
                    <option value="<?= $i['id_item']; ?>"><?= $i['nama_item']; ?></option>
                <?php } ?>
            </select>

            <label>Quantity</label>
            <input type="number" name="quantity" min="1" required>

            <button type="submit" name="simpan">Simpan</button>
        </form>
    </div>
</div>
</body>
</html>
