<?php
require_once 'env.php';
$host = DB_HOST;
$user = DB_USER;
$password = DB_PASS;
$database = DB_NAME;

// Buat koneksi
$conn = mysqli_connect($host, $user, $password, $database);

// Cek koneksi  
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>