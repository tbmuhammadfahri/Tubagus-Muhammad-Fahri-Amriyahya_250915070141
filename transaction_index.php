<?php
include "koneksi.php";

$q = mysqli_query($koneksi, "
    SELECT t.id_transaction, s.id_sales, i.nama_item, t.quantity, t.price, t.amount
    FROM transaction t
    LEFT JOIN sales s ON t.id_sales = s.id_sales
    LEFT JOIN item i ON t.id_item = i.id_item
    ORDER BY t.id_transaction DESC
");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Transaksi</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <style>
        body { font-family: Arial, sans-serif; background:#f4f4f4; margin:0; }
        .main { margin-left:220px; padding:20px; }
        .content-box { background:white; padding:20px; border-radius:5px; box-shadow:0 4px 10px rgba(0,0,0,0.1); }
        table { width:100%; border-collapse:collapse; margin-top:15px; }
        table th, table td { border:1px solid #ddd; padding:8px; text-align:center; }
        table th { background:#007bff; color:white; }
        .btn { padding:5px 10px; border-radius:3px; text-decoration:none; font-size:12px; }
        .btn-add { background:#28a745; color:white; margin-bottom:10px; display:inline-block; }
        .btn-edit { background:#ffc107; color:black; }
        .btn-del { background:#dc3545; color:white; }
    </style>
</head>
<body>
<?php include "sidebar.php"; ?>
<div class="main">
    <div class="content-box">
        <h2>Data Transaksi</h2>
        <a href="transaction_tambah.php" class="btn btn-add">+ Tambah Transaksi</a>
        <table id="transactionTable" class="display">
            <thead>
                <tr>
                    <th>No</th>
                    <th>ID Sales</th>
                    <th>Item</th>
                    <th>Qty</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no=1; while($row=mysqli_fetch_assoc($q)) { ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td>INV<?= str_pad($row['id_sales'], 4, "0", STR_PAD_LEFT); ?></td>
                    <td><?= $row['nama_item']; ?></td>
                    <td><?= $row['quantity']; ?></td>
                    <td><?= number_format($row['price']); ?></td>
                    <td><?= number_format($row['amount']); ?></td>
                    <td>
                        <a href="transaction_edit.php?id=<?= $row['id_transaction']; ?>" class="btn btn-edit">Edit</a>
                        <a href="transaction_hapus.php?id=<?= $row['id_transaction']; ?>" class="btn btn-del" onclick="return confirm('Hapus transaksi ini?')">Hapus</a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
<script>
$(document).ready(function() {
    $('#transactionTable').DataTable();
});
</script>
</body>
</html>
