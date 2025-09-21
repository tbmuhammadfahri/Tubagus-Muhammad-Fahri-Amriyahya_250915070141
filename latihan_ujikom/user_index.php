<?php
include "koneksi.php";

// ambil data petugas
$q_petugas = mysqli_query($koneksi, "SELECT id_user AS id, nama_user AS nama, username, 'Petugas' AS role FROM petugas");
// ambil data manager
$q_manager = mysqli_query($koneksi, "SELECT id_manager AS id, nama_manager AS nama, username, 'Manager' AS role FROM manager");

// gabung data
$data = [];
while ($row = mysqli_fetch_assoc($q_petugas)) { $data[] = $row; }
while ($row = mysqli_fetch_assoc($q_manager)) { $data[] = $row; }
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data User</title>
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
        .btn-print { background:#17a2b8; color:white; }
    </style>
</head>
<body>
<?php include "sidebar.php"; ?>
<div class="main">
    <div class="content-box">
        <h2>DATA USER</h2>
        <a href="user_tambah.php" class="btn btn-add">+ Tambah User</a>
        <table id="userTable" class="display">
            <thead>
                <tr>
                    <th>No</th>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Username</th>
                    <th>Role</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                if (count($data) > 0) {
                    $no = 1;
                    foreach ($data as $row) { ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= $row['id']; ?></td>
                            <td><?= $row['nama']; ?></td>
                            <td><?= $row['username']; ?></td>
                            <td><?= $row['role']; ?></td>
                            <td>
                                <a href="user_edit.php?id=<?= $row['id']; ?>&role=<?= $row['role']; ?>" class="btn btn-edit">Detail</a>
                                <a href="user_hapus.php?id=<?= $row['id']; ?>&role=<?= $row['role']; ?>" class="btn btn-del" onclick="return confirm('Yakin hapus user ini?')">Hapus</a>
                                <!-- <a href="user_cetak.php?id=<?= $row['id']; ?>&role=<?= $row['role']; ?>" class="btn btn-print">Cetak</a> -->
                            </td>
                        </tr>
                <?php }
                } else {
                    echo "<tr><td colspan='6'>Belum ada data user</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#userTable').DataTable();
});
</script>
</body>
</html>
