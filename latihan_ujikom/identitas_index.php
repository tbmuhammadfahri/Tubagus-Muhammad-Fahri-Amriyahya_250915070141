<?php
session_start();
include "koneksi.php";
$data = mysqli_query($koneksi, "SELECT * FROM identitas ORDER BY id_identitas DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Identitas</title>
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
        .btn-add { background:#28a745; color:white; margin-bottom:10px; display:inline-block; }
        .btn-edit { background:#ffc107; color:black; }
        .btn-del { background:#dc3545; color:white; }
        table.dataTable thead th { background:#007bff; color:white; }
        img { max-height:50px; border-radius:4px; }
    </style>
</head>
<body>
    <?php include "sidebar.php"; ?>
    <div class="main">
        <div class="content-box">
            <h2>DATA IDENTITAS</h2>
            <a href="identitas_tambah.php" class="btn btn-add">+ Tambah Identitas</a>
            <table id="identitasTable" class="display">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama</th>
                        <th>Badan Hukum</th>
                        <th>NPWP</th>
                        <th>Email</th>
                        <th>Telp</th>
                        <th>Rekening</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                if (mysqli_num_rows($data) > 0) {
                    while ($row = mysqli_fetch_assoc($data)) {
                        echo "<tr>
                            <td>{$row['id_identitas']}</td>
                            <td>{$row['nama_identitas']}</td>
                            <td>{$row['badan_hukum']}</td>
                            <td>{$row['npwp']}</td>
                            <td>{$row['email']}</td>
                            <td>{$row['telp']}</td>
                            <td>{$row['rekening']}</td>
                            
                            <td>
                                <a href='identitas_edit.php?id={$row['id_identitas']}' class='btn btn-edit'>Edit</a>
                                <a href='identitas_hapus.php?id={$row['id_identitas']}' class='btn btn-del' onclick=\"return confirm('Yakin hapus?')\">Hapus</a>
                            </td>
                        </tr>";
                    }
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>

<script>
$(document).ready(function() {
    $('#identitasTable').DataTable();
});
</script>
</body>
</html>
