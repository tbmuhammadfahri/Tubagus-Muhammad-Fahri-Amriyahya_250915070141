<?php
session_start();
if (!isset($_SESSION['id_user']) || $_SESSION['role'] !== "petugas") {
    header("Location: login_petugas.php");
    exit;
}
include "koneksi.php";

// Ambil data jumlah dari database
$totalTransaksi = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) AS jml FROM transaction"))['jml'];
$totalCustomer  = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) AS jml FROM customer"))['jml'];
$totalItem      = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) AS jml FROM item"))['jml'];

?>
<?php include "sidebar.php"; ?>
<div class="main" style=" margin-left: 250px; padding:20px; font-family: Arial, sans-serif;">

    <h2>Selamat Datang, <?= $_SESSION['nama_user']; ?> 👋</h2>
    <p>Anda login sebagai <b>Petugas</b>.</p>

    <!-- Info Box -->
    <div style="display:flex; gap:15px; margin:20px 0; flex-wrap:wrap;">
        <div style="flex:1; min-width:200px; background:#007bff; color:white; padding:20px; border-radius:8px;">
            <h3>📑 Total Transaksi</h3>
            <p style="font-size:22px; font-weight:bold;"><?= $totalTransaksi; ?></p>
        </div>
        <div style="flex:1; min-width:200px; background:#28a745; color:white; padding:20px; border-radius:8px;">
            <h3>👥 Total Customer</h3>
            <p style="font-size:22px; font-weight:bold;"><?= $totalCustomer; ?></p>
        </div>
        <div style="flex:1; min-width:200px; background:#ffc107; color:white; padding:20px; border-radius:8px;">
            <h3>📦 Total Item (UOM)</h3>
            <p style="font-size:22px; font-weight:bold;"><?= $totalItem; ?></p>
        </div>
    </div>

    <footer style="margin-top:40px; font-size:12px; color:#777;">
        &copy; <?= date("Y"); ?> Koperasi Fahri - Dashboard Petugas
    </footer>
</div>
