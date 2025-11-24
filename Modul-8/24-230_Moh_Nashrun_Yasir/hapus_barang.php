<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['level'] != 1) {
    header('Location: dashboard.php'); exit;
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Cek apakah barang ini ada di detail transaksi?
    $cek = mysqli_query($conn, "SELECT * FROM transaksi_detail WHERE barang_id='$id'");
    
    if (mysqli_num_rows($cek) > 0) {
        echo "<script>
            alert('Gagal! Barang ini sudah pernah terjual dalam transaksi. Tidak bisa dihapus.'); 
            window.location='index_barang.php';
        </script>";
    } else {
        mysqli_query($conn, "DELETE FROM barang WHERE id='$id'");
        echo "<script>
            alert('Barang berhasil dihapus!'); 
            window.location='index_barang.php';
        </script>";
    }
}
?>