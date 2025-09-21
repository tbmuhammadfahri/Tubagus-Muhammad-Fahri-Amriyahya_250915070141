<?php
include "koneksi.php";
$id = $_GET['id'];
mysqli_query($koneksi, "DELETE FROM item WHERE id_item='$id'");
header("Location: item_index.php");
exit;
