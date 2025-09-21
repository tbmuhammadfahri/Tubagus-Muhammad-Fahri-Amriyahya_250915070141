<?php
include "koneksi.php";

// Ambil filter
$tgl_awal   = isset($_GET['tgl_awal']) ? $_GET['tgl_awal'] : '';
$tgl_akhir  = isset($_GET['tgl_akhir']) ? $_GET['tgl_akhir'] : '';
$id_customer = isset($_GET['id_customer']) ? $_GET['id_customer'] : '';

// Ambil data customer untuk filter
$customers = mysqli_query($koneksi, "SELECT * FROM customer ORDER BY nama_customer ASC");

// Query dasar
$sql = "SELECT t.*, s.tgl_sales, s.do_number, s.status, c.nama_customer, i.nama_item 
        FROM transaction t
        LEFT JOIN sales s ON t.id_sales=s.id_sales
        LEFT JOIN customer c ON s.id_customer=c.id_customer
        LEFT JOIN item i ON t.id_item=i.id_item
        WHERE 1=1";

// Filter tanggal
if ($tgl_awal != '' && $tgl_akhir != '') {
    $sql .= " AND s.tgl_sales BETWEEN '$tgl_awal' AND '$tgl_akhir'";
}

// Filter customer
if ($id_customer != '') {
    $sql .= " AND s.id_customer='$id_customer'";
}

$sql .= " ORDER BY s.tgl_sales DESC, t.id_transaction DESC";
$q = mysqli_query($koneksi, $sql);

$data = [];
while ($row = mysqli_fetch_assoc($q)) {
    $data[] = $row;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Transaksi</title>
    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <style>
        body { font-family: Arial, sans-serif; background:#f4f4f4; margin:0; }
        .main { margin-left:220px; padding:20px; }
        .content-box { background:white; padding:20px; border-radius:5px; box-shadow:0 4px 10px rgba(0,0,0,0.1); }
        h2 { margin-top:0; }
        .btn { padding:6px 12px; border-radius:3px; text-decoration:none; font-size:12px; }
        .btn-filter { background:#28a745; color:white; }
        .btn-print { background:#17a2b8; color:white; }
        form { margin-bottom:15px; }
    </style>
</head>
<body>
<?php include "sidebar.php"; ?>
<div class="main">
    <div class="content-box">
        <h2>LAPORAN TRANSAKSI</h2>

        <form method="get">
            <label>Tanggal: </label>
            <input type="date" name="tgl_awal" value="<?= $tgl_awal; ?>"> s/d
            <input type="date" name="tgl_akhir" value="<?= $tgl_akhir; ?>">
            
            <label>Customer: </label>
            <select name="id_customer">
                <option value="">-- Semua --</option>
                <?php while($c=mysqli_fetch_assoc($customers)) { ?>
                    <option value="<?= $c['id_customer']; ?>" <?= ($id_customer==$c['id_customer'])?'selected':''; ?>>
                        <?= $c['nama_customer']; ?>
                    </option>
                <?php } ?>
            </select>
            <button type="submit" class="btn btn-filter">Filter</button>
        </form>

        <a href="laporan_transaksi_cetak.php?tgl_awal=<?= $tgl_awal; ?>&tgl_akhir=<?= $tgl_akhir; ?>&id_customer=<?= $id_customer; ?>" 
           target="_blank" class="btn btn-print">Cetak Laporan</a>

        <table id="trxTable" class="display">
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
                if (count($data) > 0) {
                    $no = 1;
                    foreach ($data as $row) { ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= $row['tgl_sales']; ?></td>
                            <td><?= $row['do_number']; ?></td>
                            <td><?= $row['nama_customer']; ?></td>
                            <td><?= $row['nama_item']; ?></td>
                            <td><?= $row['quantity']; ?></td>
                            <td>Rp <?= number_format($row['price'],0,',','.'); ?></td>
                            <td>Rp <?= number_format($row['amount'],0,',','.'); ?></td>
                            <td><?= $row['status']; ?></td>
                        </tr>
                <?php }
                } else {
                    echo "<tr><td colspan='9'>Belum ada data transaksi</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#trxTable').DataTable();
});
</script>
</body>
</html>
