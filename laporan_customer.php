<?php
include "koneksi.php";

// Ambil data customer
$q = mysqli_query($koneksi, "SELECT * FROM customer ORDER BY id_customer DESC");
$data = [];
while ($row = mysqli_fetch_assoc($q)) {
    $data[] = $row;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Customer</title>
    <!-- DataTables CSS & JS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <style>
        body { font-family: Arial, sans-serif; background:#f4f4f4; margin:0; }
        .main { margin-left:220px; padding:20px; }
        .content-box { background:white; padding:20px; border-radius:5px; box-shadow:0 4px 10px rgba(0,0,0,0.1); }
        h2 { margin-top:0; }
        .btn { padding:5px 10px; border-radius:3px; text-decoration:none; font-size:12px; }
        .btn-print { background:#17a2b8; color:white; margin-bottom:10px; display:inline-block; }
    </style>
</head>
<body>
<?php include "sidebar.php"; ?>
<div class="main">
    <div class="content-box">
        <h2>LAPORAN CUSTOMER</h2>
        <a href="laporan_customer_cetak.php" target="_blank" class="btn btn-print">Cetak Laporan</a>

        <table id="custTable" class="display">
            <thead>
                <tr>
                    <th>No</th>
                    <th>ID Customer</th>
                    <th>Nama Customer</th>
                    <th>Alamat</th>
                    <th>Telp</th>
                    <th>Fax</th>
                    <th>Email</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                if (count($data) > 0) {
                    $no = 1;
                    foreach ($data as $row) { ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= $row['id_customer']; ?></td>
                            <td><?= $row['nama_customer']; ?></td>
                            <td><?= $row['alamat']; ?></td>
                            <td><?= $row['telp']; ?></td>
                            <td><?= $row['fax']; ?></td>
                            <td><?= $row['email']; ?></td>
                        </tr>
                <?php }
                } else {
                    echo "<tr><td colspan='7'>Belum ada data customer</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#custTable').DataTable();
});
</script>
</body>
</html>
