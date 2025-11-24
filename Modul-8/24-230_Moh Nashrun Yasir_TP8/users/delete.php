<?php
session_start();
include '../koneksi.php';

// 1. Cek Login & Level (Proteksi Halaman)
// Hanya Level 1 (Owner) yang boleh akses
if (!isset($_SESSION['user']) || $_SESSION['user']['level'] != 1) {
    header('Location: ../dashboard.php');
    exit;
}

// 2. Cek apakah ada ID di URL?
if (isset($_GET['id'])) {
    
    // Ambil ID dan pastikan formatnya angka (integer) untuk keamanan
    $id = intval($_GET['id']);

    // 3. Validasi: Mencegah Admin menghapus akunnya sendiri yang sedang login
    if ($_SESSION['user']['id'] == $id) {
        echo "<script>
            alert('Gagal! Anda tidak bisa menghapus akun yang sedang Anda gunakan login.');
            window.location='index.php';
        </script>";
        exit;
    }

    // 4. Proses Hapus Data
    $query = "DELETE FROM user WHERE id_user = $id";
    
    if (mysqli_query($conn, $query)) {
        echo "<script>
            alert('Data user berhasil dihapus!');
            window.location='index.php';
        </script>";
    } else {
        echo "<script>
            alert('Terjadi kesalahan saat menghapus user.');
            window.location='index.php';
        </script>";
    }

} else {
    // Jika tidak ada parameter ID, kembalikan ke halaman index
    header("Location: index.php");
    exit;
}
?>