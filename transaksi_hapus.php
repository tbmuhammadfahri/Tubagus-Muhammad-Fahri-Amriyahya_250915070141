<?php
include "koneksi.php";
$id  = $_GET['id'];
$id_sales = $_GET['sales'];
mysqli_query($koneksi, "DELETE FROM transaction WHERE id_transaction='$id'");
header("Location: sales_detail.php?id=$id_sales");
exit;
