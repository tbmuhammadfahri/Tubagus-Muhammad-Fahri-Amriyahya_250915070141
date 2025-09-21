<?php
session_start();
include "koneksi.php";
$data = mysqli_query($koneksi, "SELECT * FROM customer ORDER BY id_customer DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Customer</title>
    <!-- DataTables CSS & JS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <style>
        body { font-family: Arial, sans-serif; background:#f4f4f4; margin:0; }
        .main { margin-left:220px; padding:20px; }
        .content-box {
            background:white; padding:20px;
            border-radius:5px; box-shadow:0 4px 10px rgba(0,0,0,0.1);
        }
        h2 { margin-top:0; }
        .btn {
            padding:5px 10px; border-radius:3px;
            text-decoration:none; font-size:12px;
            margin:2px; display:inline-block;
        }
        .btn-add { background:#28a745; color:white; margin-bottom:10px; }
        .btn-edit { background:#ffc107; color:black; }
        .btn-del { background:#dc3545; color:white; }
    </style>
</head>
<body>
<?php include "sidebar.php"; ?>
<div class="main">
    <div class="content-box">
        <h2>DATA CUSTOMER</h2>
        <a href="customer_tambah.php" class="btn btn-add">+ Tambah Customer</a>
        <table id="customerTable" class="display" style="width:100%">
            <thead>
                <tr>
                    <th>No</th>
                    <th>ID</th>
                    <th>Nama Customer</th>
                    <th>Alamat</th>
                    <th>Telp</th>
                    <th>Fax</th>
                    <th>Email</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                if (mysqli_num_rows($data) > 0) {
                    $no = 1;
                    while ($row = mysqli_fetch_assoc($data)) { ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= $row['id_customer']; ?></td>
                            <td><?= $row['nama_customer']; ?></td>
                            <td><?= $row['alamat']; ?></td>
                            <td><?= $row['telp']; ?></td>
                            <td><?= $row['fax']; ?></td>
                            <td><?= $row['email']; ?></td>
                            <td>
                                <a href="customer_edit.php?id=<?= $row['id_customer']; ?>" class="btn btn-edit">Edit</a>
                                <a href="customer_hapus.php?id=<?= $row['id_customer']; ?>" class="btn btn-del" onclick="return confirm('Yakin hapus customer ini?')">Hapus</a>
                            </td>
                        </tr>
                <?php }
                } else {
                    echo "<tr><td colspan='8'>Belum ada data customer</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#customerTable').DataTable();
});
</script>
</body>
</html>
