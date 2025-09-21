<?php
session_start();
include "koneksi.php";
$data = mysqli_query($koneksi, "SELECT * FROM item ORDER BY id_item DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Item</title>
    <style>
        body { font-family: Arial, sans-serif; background:#f4f4f4; margin:0; }
        .main { margin-left:220px; padding:20px; }
        .content-box { background:white; padding:20px; border-radius:5px; box-shadow:0 4px 10px rgba(0,0,0,0.1); }
        table { width:100%; border-collapse:collapse; margin-top:15px; }
        table th, table td { border:1px solid #ddd; padding:8px; text-align:center; }
        table th { background:#007bff; color:white; }
        .btn { padding:5px 10px; border-radius:3px; text-decoration:none; font-size:12px; }
        .btn-add { background:#28a745; color:white; }
        .btn-edit { background:#ffc107; color:black; }
        .btn-del { background:#dc3545; color:white; }
    </style>
</head>
<body>
    <?php include "sidebar.php"; ?>
    <div class="main">
        <div class="content-box">
            <h2>Data Item</h2>
            <a href="item_tambah.php" class="btn btn-add">+ Tambah Item</a>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Item</th>
                        <th>UOM</th>
                        <th>Harga Beli</th>
                        <th>Harga Jual</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                if (mysqli_num_rows($data) > 0) {
                    while ($row = mysqli_fetch_assoc($data)) {
                        echo "<tr>
                            <td>{$row['id_item']}</td>
                            <td>{$row['nama_item']}</td>
                            <td>{$row['uom']}</td>
                            <td>Rp ".number_format($row['harga_beli'],0,',','.')."</td>
                            <td>Rp ".number_format($row['harga_jual'],0,',','.')."</td>
                            <td>
                                <a href='item_edit.php?id={$row['id_item']}' class='btn btn-edit'>Edit</a>
                                <a href='item_hapus.php?id={$row['id_item']}' class='btn btn-del' onclick=\"return confirm('Yakin hapus data ini?')\">Hapus</a>
                            </td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>Belum ada data</td></tr>";
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
