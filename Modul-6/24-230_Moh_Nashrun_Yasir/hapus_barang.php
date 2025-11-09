<?php
include 'koneksi.php';
$id = $_GET['id'];

$cek = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM transaksi_detail WHERE barang_id='$id'"));
if ($cek > 0) {
    echo "<script>alert('Barang tidak dapat dihapus karena digunakan dalam transaksi detail');
          window.location='index.php';</script>";
} else {
    mysqli_query($conn, "DELETE FROM barang WHERE id='$id'");
    echo "<script>alert('Barang berhasil dihapus!');
          window.location='index.php';</script>";
}
?>