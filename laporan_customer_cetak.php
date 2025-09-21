<?php
include "koneksi.php";
$q = mysqli_query($koneksi, "SELECT * FROM customer ORDER BY id_customer DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak Laporan Customer</title>
    <style>
        body { font-family: Arial, sans-serif; }
        h2 { text-align:center; }
        table { width:100%; border-collapse:collapse; margin-top:20px; }
        table th, table td { border:1px solid #000; padding:6px; text-align:center; }
        table th { background:#eee; }
    </style>
</head>
<body onload="window.print()">
    <h2>LAPORAN CUSTOMER</h2>
    <table>
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
        $no = 1;
        while ($row = mysqli_fetch_assoc($q)) {
            echo "<tr>
                <td>$no</td>
                <td>{$row['id_customer']}</td>
                <td>{$row['nama_customer']}</td>
                <td>{$row['alamat']}</td>
                <td>{$row['telp']}</td>
                <td>{$row['fax']}</td>
                <td>{$row['email']}</td>
            </tr>";
            $no++;
        }
        ?>
        </tbody>
    </table>
</body>
</html>
