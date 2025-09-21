<?php
include "koneksi.php";
$id = $_GET['id'];
mysqli_query($koneksi, "DELETE FROM customer WHERE id_customer='$id'");
header("Location: customer_index.php");
exit;
