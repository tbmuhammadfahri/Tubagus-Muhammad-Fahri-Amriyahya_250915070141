<?php
include "koneksi.php";

$tgl_awal   = isset($_GET['tgl_awal']) ? $_GET['tgl_awal'] : '';
$tgl_akhir  = isset($_GET['tgl_akhir']) ? $_GET['tgl_akhir'] : '';
$id_customer = isset($_GET['id_customer']) ? $_GET['id_customer'] : '';

$sql = "SELECT t.*, s.tgl_sales, s.do_number, s.status, c.nama_customer, i.nama_item 
        FROM transaction t
        LEFT JOIN sales s ON t.id_sales=s.id_sales
        LEFT JOIN customer c ON s.id_customer=c.id_customer
        LEFT JOIN item i ON t.id_item=i.id_item
        WHERE 1=1";

if ($tgl_awal != '' && $tgl_akhir != '') {
    $sql .= " AND s.tgl_sales BETWEEN '$tgl_awal' AND '$tgl_akhir'";
}
if ($id_customer != '') {
    $sql .= " AND s.id_customer='$id_customer'";
}

$sql .= " ORDER BY s.tgl_sales DESC, t.id_transaction DESC";
$q = mysqli_query($koneksi, $sql);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak Laporan Transaksi</title>
    <style>
        body { font-family: Arial, sans-serif; }
        h2 { text-align:center; }
        table { width:100%; border-collapse:collapse; margin-top:20px; }
        table th, table td { border:1px solid #000; padding:6px; text-align:center; }
        table th { background:#eee; }
    </style>
</head>
<body onload="window.print()">
    <h2>LAPORAN TRANSAKSI</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>DO Number</th>
                <th>Customer</th>
                <th>Item</th>
                <th>Qty</th>
                <th>Harga</th>
                <th>Amount</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
        <?php 
        $no=1; $total=0;
        while ($row=mysqli_fetch_assoc($q)) {
            echo "<tr>
                <td>$no</td>
                <td>{$row['tgl_sales']}</td>
                <td>{$row['do_number']}</td>
                <td>{$row['nama_customer']}</td>
                <td>{$row['nama_item']}</td>
                <td>{$row['quantity']}</td>
                <td>Rp ".number_format($row['price'],0,',','.')."</td>
                <td>Rp ".number_format($row['amount'],0,',','.')."</td>
                <td>{$row['status']}</td>
            </tr>";
            $total += $row['amount'];
            $no++;
        }
        ?>
        <tr>
            <td colspan="7"><b>Total</b></td>
            <td colspan="2"><b>Rp <?= number_format($total,0,',','.'); ?></b></td>
        </tr>
        </tbody>
    </table>
</body>
</html>
