<?php
$host     = "localhost";   
$user     = "root";        
$password = "";            
$database = "koperasi";    

// koneksi
$koneksi = mysqli_connect($host, $user, $password, $database);

// Cek koneksi
if (!$koneksi) {
    die("Koneksi database gagal: " . mysqli_connect_error());
} else {
    // echo "Koneksi berhasil"; // aktifkan untuk cek koneksi
}
?>
