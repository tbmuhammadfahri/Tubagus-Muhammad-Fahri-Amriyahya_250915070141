<?php
include "koneksi.php";
$id   = $_GET['id'];
$role = $_GET['role'];

if ($role == "Petugas") {
    mysqli_query($koneksi, "DELETE FROM petugas WHERE id_user='$id'");
} else {
    mysqli_query($koneksi, "DELETE FROM manager WHERE id_manager='$id'");
}

header("Location: user_index.php");
exit;
