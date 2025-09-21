<?php
include "koneksi.php";
$id = $_GET['id'];
mysqli_query($koneksi, "DELETE FROM identitas WHERE id_identitas='$id'");
header("Location: identitas_index.php");
exit;
