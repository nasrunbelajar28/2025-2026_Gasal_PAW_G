<?php
session_start();

// 1. CEK LOGIN & LEVEL (Wajib Owner)
if (!isset($_SESSION['user']) || $_SESSION['user']['level'] != 1) {
    header('Location: dashboard.php');
    exit;
}

include 'koneksi.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Cek apakah supplier ini dipakai di tabel barang? (Opsional, biar aman)
    $cek_barang = mysqli_query($conn, "SELECT * FROM barang WHERE supplier_id='$id'");
    
    if (mysqli_num_rows($cek_barang) > 0) {
        // Jika sedang dipakai barang, tolak hapus
        echo "<script>
            alert('Gagal! Supplier ini tidak bisa dihapus karena masih menyuplai barang tertentu. Hapus dulu barangnya.');
            window.location='index_supplier.php';
        </script>";
    } else {
        // Jika aman, hapus
        $query = "DELETE FROM supplier WHERE id='$id'";
        if (mysqli_query($conn, $query)) {
            echo "<script>alert('Data Supplier berhasil dihapus!'); window.location='index_supplier.php';</script>";
        } else {
            echo "<script>alert('Gagal menghapus database.'); window.location='index_supplier.php';</script>";
        }
    }
} else {
    header('Location: index_supplier.php');
}
?>