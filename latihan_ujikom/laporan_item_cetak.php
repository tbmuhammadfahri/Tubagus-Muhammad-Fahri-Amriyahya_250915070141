<?php
include "koneksi.php";
$q = mysqli_query($koneksi, "SELECT * FROM item ORDER BY id_item DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak Laporan Item</title>
    <style>
        body { font-family: Arial, sans-serif; }
        h2 { text-align:center; }
        table { width:100%; border-collapse:collapse; margin-top:20px; }
        table th, table td { border:1px solid #000; padding:6px; text-align:center; }
        table th { background:#eee; }
    </style>
</head>
<body onload="window.print()">
    <h2>LAPORAN ITEM</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>ID Item</th>
                <th>Nama Item</th>
                <th>UOM</th>
                <th>Harga Beli</th>
                <th>Harga Jual</th>
            </tr>
        </thead>
        <tbody>
        <?php 
        $no = 1;
        while ($row = mysqli_fetch_assoc($q)) {
            echo "<tr>
                <td>$no</td>
                <td>{$row['id_item']}</td>
                <td>{$row['nama_item']}</td>
                <td>{$row['uom']}</td>
                <td>Rp ".number_format($row['harga_beli'],0,',','.')."</td>
                <td>Rp ".number_format($row['harga_jual'],0,',','.')."</td>
            </tr>";
            $no++;
        }
        ?>
        </tbody>
    </table>
</body>
</html>
