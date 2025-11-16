<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "db_penjualan7";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    echo "Koneksi ke database gagal: " . mysqli_connect_error();
    exit;
}