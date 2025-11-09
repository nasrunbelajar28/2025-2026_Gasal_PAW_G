<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "toko1";

$conn = mysqli_connect($host, $user, $pass, $db);
if ($conn) {
    // echo "koneksi berhasil";
} else {
    echo "Koneksi ke database gagal: " . mysqli_connect_error();
    exit;
}
?>