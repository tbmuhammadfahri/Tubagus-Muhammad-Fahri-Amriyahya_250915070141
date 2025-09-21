<?php
include "koneksi.php";

$id_sales = isset($_GET['id_sales']) ? (int)$_GET['id_sales'] : 0;

// Ambil data identitas perusahaan
$identitas = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM identitas LIMIT 1"));

// Ambil data sales & customer
$q_sales = mysqli_query($koneksi, "
    SELECT s.*, c.nama_customer, c.alamat, c.telp, c.email 
    FROM sales s
    LEFT JOIN customer c ON s.id_customer = c.id_customer
    WHERE s.id_sales = '$id_sales'
");
$sales = mysqli_fetch_assoc($q_sales);

if (!$sales) {
    die("❌ Data sales dengan ID $id_sales tidak ditemukan.");
}

// Ambil detail transaksi
$q_detail = mysqli_query($koneksi, "
    SELECT t.*, i.nama_item, i.uom 
    FROM transaction t
    LEFT JOIN item i ON t.id_item = i.id_item
    WHERE t.id_sales = '$id_sales'
");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Invoice #<?= $sales['id_sales']; ?></title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        h2 { text-align: center; margin-bottom: 5px; }
        .company { text-align: center; margin-bottom: 30px; }
        .company img { max-height: 80px; }
        .info { margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        table, th, td { border: 1px solid #000; }
        th, td { padding: 8px; text-align: center; }
        th { background: #f2f2f2; }
        .right { text-align: right; }
        .total { font-weight: bold; }
        .footer { margin-top: 40px; font-size: 12px; }
        .print-btn { margin-top:20px; text-align:center; }
        .print-btn button { padding:10px 20px; }
    </style>
</head>
<body>

<div class="company">
    
    <h2><?= $identitas['nama_identitas']; ?></h2>
    <p>
        <?= $identitas['badan_hukum']; ?><br>
        NPWP: <?= $identitas['npwp']; ?><br>
        <?= $identitas['alamat']; ?><br>
        Telp: <?= $identitas['telp']; ?> | Fax: <?= $identitas['fax']; ?><br>
        Email: <?= $identitas['email']; ?> | Website: <?= $identitas['url']; ?><br>
        Rekening: <?= $identitas['rekening']; ?>
    </p>
    <hr>
</div>

<div class="info">
    <p>
        <b>No. Invoice:</b> INV-<?= $sales['id_sales']; ?><br>
        <b>Tanggal:</b> <?= $sales['tgl_sales']; ?><br><br>

        <b>Kepada Yth:</b><br>
        <?= $sales['nama_customer']; ?><br>
        <?= $sales['alamat']; ?><br>
        Telp: <?= $sales['telp']; ?><br>
        Email: <?= $sales['email']; ?><br><br>

        <b>Status:</b> <?= $sales['status']; ?>
    </p>
</div>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Item</th>
            <th>UOM</th>
            <th>Qty</th>
            <th>Harga</th>
            <th>Subtotal</th>
        </tr>
    </thead>
    <tbody>
    <?php 
    $no = 1; $grandtotal = 0;
    while ($d = mysqli_fetch_assoc($q_detail)) {
        $grandtotal += $d['amount']; ?>
        <tr>
            <td><?= $no++; ?></td>
            <td><?= $d['nama_item']; ?></td>
            <td><?= $d['uom']; ?></td>
            <td><?= $d['quantity']; ?></td>
            <td class="right">Rp <?= number_format($d['price'],0,',','.'); ?></td>
            <td class="right">Rp <?= number_format($d['amount'],0,',','.'); ?></td>
        </tr>
    <?php } ?>
        <tr>
            <td colspan="5" class="total right">TOTAL</td>
            <td class="total right">Rp <?= number_format($grandtotal,0,',','.'); ?></td>
        </tr>
    </tbody>
</table>

<div class="footer">
    <p><i>Terima kasih atas kepercayaan Anda.</i></p>
</div>

<div class="print-btn">
    <button onclick="window.print()">🖨 Cetak Invoice</button>
</div>

</body>
</html>
