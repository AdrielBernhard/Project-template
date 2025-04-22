<?php
$host = "localhost";      // atau IP address database server
$user = "root";           // username MySQL
$password = "";           // password MySQL
$database = "inventory";  // ganti dengan nama database kamu

// Buat koneksi
$conn = mysqli_connect($host, $user, $password, $database);

// Cek koneksi
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
