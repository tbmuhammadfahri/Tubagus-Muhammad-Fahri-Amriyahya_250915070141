<?php
include "koneksi.php";
$q = mysqli_query($koneksi, "
    SELECT s.id_sales, s.tgl_sales, s.do_number, s.status, c.nama_customer
    FROM sales s
    LEFT JOIN customer c ON s.id_customer = c.id_customer
    ORDER BY s.id_sales DESC
");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Sales</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <style>
        body { font-family: Arial, sans-serif; background:#f4f4f4; margin:0; }
        .main { margin-left:220px; padding:20px; }
        .content-box { background:white; padding:20px; border-radius:5px; }
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
        <h2>DATA SALES</h2>
        <a href="sales_tambah.php" class="btn btn-add">+ Tambah Transaksi</a>
        <table id="salesTable" class="display">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>DO Number</th>
                    <th>Customer</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $no=1;
                while($row=mysqli_fetch_assoc($q)) { ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= $row['tgl_sales']; ?></td>
                    <td><?= $row['do_number']; ?></td>
                    <td><?= $row['nama_customer']; ?></td>
                    <td><?= $row['status']; ?></td>
                    <td>
    <a href="sales_edit.php?id=<?= $row['id_sales']; ?>" class="btn btn-edit">Edit</a>
    <a href="sales_hapus.php?id=<?= $row['id_sales']; ?>" class="btn btn-del" onclick="return confirm('Hapus data ini?')">Hapus</a>
    <a href="invoice_cetak.php?id_sales=<?= $row['id_sales']; ?>" target="_blank" class="btn btn-print">Cetak Invoice</a>
</td>

                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
<script>
$(document).ready(function() {
    $('#salesTable').DataTable();
});
</script>
</body>
</html>
