<?php
include "koneksi.php";
session_start();
$id_sales = $_GET['id'];

// ambil data sales
$sales = mysqli_fetch_assoc(mysqli_query($koneksi,"
    SELECT s.*, c.nama_customer 
    FROM sales s 
    LEFT JOIN customer c ON s.id_customer=c.id_customer
    WHERE s.id_sales=$id_sales
"));

// tambah item ke transaction_temp
if (isset($_POST['add_item'])) {
    $id_item = $_POST['id_item'];
    $qty = $_POST['quantity'];
    $session_id = session_id();

    // ambil harga dari tabel item
    $item = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT harga_jual FROM item WHERE id_item='$id_item'"));
    $price = $item['harga_jual'];
    $amount = $qty * $price;

    mysqli_query($koneksi,"INSERT INTO transaction_temp (id_item,quantity,price,amount,session_id,remark) 
                           VALUES ('$id_item','$qty','$price','$amount','$session_id','-')");
}

// update qty keranjang
if (isset($_POST['update_qty'])) {
    $id_trx = $_POST['id_transaction'];
    $qty = $_POST['quantity'];

    // ambil harga lama
    $row = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT price FROM transaction_temp WHERE id_transaction='$id_trx'"));
    $price = $row['price'];
    $amount = $qty * $price;

    mysqli_query($koneksi,"UPDATE transaction_temp SET quantity='$qty', amount='$amount' WHERE id_transaction='$id_trx'");
    header("Location: sales_detail.php?id=$id_sales");
    exit;
}

// hapus item dari keranjang
if (isset($_GET['del'])) {
    $id_del = $_GET['del'];
    mysqli_query($koneksi,"DELETE FROM transaction_temp WHERE id_transaction=$id_del");
    header("Location: sales_detail.php?id=$id_sales");
    exit;
}

// ambil data keranjang
$cart = mysqli_query($koneksi,"SELECT t.*, i.nama_item 
                               FROM transaction_temp t 
                               LEFT JOIN item i ON t.id_item=i.id_item
                               WHERE session_id='".session_id()."'");

$items = mysqli_query($koneksi,"SELECT * FROM item");

// finalisasi simpan ke transaction
if (isset($_POST['final'])) {
    $cart = mysqli_query($koneksi,"SELECT * FROM transaction_temp WHERE session_id='".session_id()."'");
    while ($row = mysqli_fetch_assoc($cart)) {
        mysqli_query($koneksi,"INSERT INTO transaction (id_sales,id_item,quantity,price,amount) 
                               VALUES ('$id_sales','".$row['id_item']."','".$row['quantity']."','".$row['price']."','".$row['amount']."')");

        // kurangi uom di tabel item
        mysqli_query($koneksi,"UPDATE item SET uom = uom - ".$row['quantity']." WHERE id_item='".$row['id_item']."'");
    }
    mysqli_query($koneksi,"DELETE FROM transaction_temp WHERE session_id='".session_id()."'");
    header("Location: sales_index.php");
    exit;
}


// finalisasi simpan ke transaction
if (isset($_POST['final'])) {
    $cart = mysqli_query($koneksi,"SELECT * FROM transaction_temp WHERE session_id='".session_id()."'");
    while ($row = mysqli_fetch_assoc($cart)) {
        mysqli_query($koneksi,"INSERT INTO transaction (id_sales,id_item,quantity,price,amount) 
                               VALUES ('$id_sales','".$row['id_item']."','".$row['quantity']."','".$row['price']."','".$row['amount']."')");
    }
    mysqli_query($koneksi,"DELETE FROM transaction_temp WHERE session_id='".session_id()."'");
    header("Location: sales_index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail Sales</title>
    <style>
        body { font-family: Arial, sans-serif; background:#f4f4f4; margin:0; }
        .main { margin-left:220px; padding:20px; }
        .content-box { background:white; padding:20px; border-radius:5px; box-shadow:0 4px 10px rgba(0,0,0,0.1); }
        h2, h3 { margin-top:0; }
        table { width:100%; border-collapse:collapse; margin-top:15px; }
        table th, table td { border:1px solid #ddd; padding:8px; text-align:center; }
        table th { background:#007bff; color:white; }
        .btn { padding:6px 12px; border-radius:3px; text-decoration:none; font-size:12px; margin:2px; display:inline-block; }
        .btn-add { background:#28a745; color:white; }
        .btn-del { background:#dc3545; color:white; }
        .btn-final { background:#17a2b8; color:white; margin-top:10px; }
        .btn-update { background:#ffc107; color:black; }
        .form-inline select, .form-inline input { padding:5px; margin:0 5px 5px 0; }
        input[type="number"] { width:70px; }
    </style>
    <script>
        // Ambil harga item otomatis saat pilih barang
        function setPrice() {
            let hargaList = <?= json_encode(array_column(mysqli_fetch_all($items, MYSQLI_ASSOC), 'harga', 'id_item')); ?>;
            let itemId = document.getElementById("id_item").value;
            document.getElementById("price").value = hargaList[itemId] ?? '';
        }
    </script>
</head>
<body>
<?php include "sidebar.php"; ?>
<div class="main">
    <div class="content-box">
        <h2>Detail Sales #<?= $sales['id_sales']; ?></h2>
        <p><b>Tanggal:</b> <?= $sales['tgl_sales']; ?><br>
        <b>Customer:</b> <?= $sales['nama_customer']; ?><br>
        <b>Status:</b> <?= $sales['status']; ?></p>

        <h3>Tambah Item</h3>
        <form method="post" class="form-inline">
            <select name="id_item" id="id_item" onchange="setPrice()" required>
                <option value="">- Pilih Barang -</option>
                <?php
                // ulangi query item
                $items = mysqli_query($koneksi,"SELECT * FROM item");
                while($i=mysqli_fetch_assoc($items)) { ?>
                    <option value="<?= $i['id_item']; ?>"><?= $i['nama_item']; ?></option>
                <?php } ?>
            </select>
            <input type="number" name="quantity" min="1" placeholder="Qty" required>
            <input type="text" id="price" readonly placeholder="Harga otomatis">
            <button type="submit" name="add_item" class="btn btn-add">Tambah</button>
        </form>

        <h3>Keranjang</h3>
        <table>
            <tr>
                <th>Barang</th>
                <th>Qty</th>
                <th>Harga</th>
                <th>Amount</th>
                <th>Aksi</th>
            </tr>
            <?php $total=0; while($row=mysqli_fetch_assoc($cart)) { $total += $row['amount']; ?>
            <tr>
                <td><?= $row['nama_item']; ?></td>
                <td>
                    <form method="post" style="display:inline-block;">
                        <input type="hidden" name="id_transaction" value="<?= $row['id_transaction']; ?>">
                        <input type="number" name="quantity" value="<?= $row['quantity']; ?>" min="1" required>
                        <button type="submit" name="update_qty" class="btn btn-update">Update</button>
                    </form>
                </td>
                <td><?= number_format($row['price']); ?></td>
                <td><?= number_format($row['amount']); ?></td>
                <td><a href="sales_detail.php?id=<?= $id_sales; ?>&del=<?= $row['id_transaction']; ?>" class="btn btn-del" onclick="return confirm('Hapus item ini?')">Hapus</a></td>
            </tr>
            <?php } ?>
            <tr>
                <td colspan="3"><b>Total</b></td>
                <td colspan="2"><b><?= number_format($total); ?></b></td>
            </tr>
        </table>

        <form method="post">
            <button type="submit" name="final" class="btn btn-final">Simpan Transaksi</button>
        </form>
    </div>
</div>
</body>
</html>
