<?php
session_start();
include "koneksi.php";

// pastikan ada session cart
if (!isset($_SESSION['cart_id'])) {
    $_SESSION['cart_id'] = uniqid();
}
$cart_id = $_SESSION['cart_id'];

// Tambah item ke temp
if (isset($_POST['tambah_item'])) {
    $id_item  = $_POST['id_item'];
    $qty      = $_POST['quantity'];
    $price    = $_POST['price'];
    $amount   = $qty * $price;

    mysqli_query($koneksi, "INSERT INTO transaction_temp (id_item,quantity,price,amount,session_id,remark)
                VALUES ('$id_item','$qty','$price','$amount','$cart_id','')");
}

// Hapus item dari temp
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    mysqli_query($koneksi, "DELETE FROM transaction_temp WHERE id_transaction='$id'");
}

$list_item = mysqli_query($koneksi, "SELECT * FROM item");
$cart = mysqli_query($koneksi, "
    SELECT t.id_transaction, i.nama_item, t.quantity, t.price, t.amount
    FROM transaction_temp t
    LEFT JOIN item i ON t.id_item=i.id_item
    WHERE t.session_id='$cart_id'
");
?>
<!DOCTYPE html>
<html lang="id">
<head><meta charset="UTF-8"><title>Keranjang Invoice</title></head>
<body>
<h2>Keranjang Invoice (sementara)</h2>

<form method="POST">
    <select name="id_item" required>
        <option value="">-- pilih item --</option>
        <?php while($i=mysqli_fetch_assoc($list_item)) { ?>
        <option value="<?= $i['id_item']; ?>"><?= $i['nama_item']; ?></option>
        <?php } ?>
    </select>
    <input type="number" name="quantity" placeholder="Qty" required>
    <input type="number" name="price" placeholder="Harga" required>
    <button type="submit" name="tambah_item">Tambah</button>
</form>

<table border="1" cellpadding="5">
<tr><th>ID</th><th>Item</th><th>Qty</th><th>Harga</th><th>Total</th><th>Aksi</th></tr>
<?php while($c=mysqli_fetch_assoc($cart)) { ?>
<tr>
    <td><?= $c['id_transaction']; ?></td>
    <td><?= $c['nama_item']; ?></td>
    <td><?= $c['quantity']; ?></td>
    <td><?= $c['price']; ?></td>
    <td><?= $c['amount']; ?></td>
    <td><a href="?hapus=<?= $c['id_transaction']; ?>">Hapus</a></td>
</tr>
<?php } ?>
</table>

<a href="sales_tambah.php">← Kembali ke Form Invoice</a>
</body>
</html>
