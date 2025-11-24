<?php
session_start();
include '../koneksi.php';

// 1. Cek apakah ada kiriman form (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // 2. Ambil dan bersihkan data input
    $username = trim($_POST['username']);
    $nama     = trim($_POST['nama']);
    $level    = $_POST['level'];
    
    // Enkripsi Password dengan MD5 (Sesuai sistem login kamu)
    $password = md5($_POST['password']);

    // 3. Validasi: Cek apakah username sudah ada?
    // Kita gunakan escape string untuk keamanan query cek sederhana ini
    $user_safe = mysqli_real_escape_string($conn, $username);
    $cek_query = mysqli_query($conn, "SELECT id_user FROM user WHERE username = '$user_safe'");

    if (mysqli_num_rows($cek_query) > 0) {
        // Jika username sudah ada, tolak dan kembalikan ke form
        echo "<script>
            alert('Gagal! Username \"$username\" sudah terdaftar. Gunakan username lain.');
            window.location='create.php';
        </script>";
        exit;
    }

    // 4. Proses Simpan (Menggunakan Prepared Statement agar Aman)
    $query = "INSERT INTO user (username, password, nama, level) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $query);
    
    // Bind parameter: s = string, s = string, s = string, i = integer
    mysqli_stmt_bind_param($stmt, "sssi", $username, $password, $nama, $level);

    if (mysqli_stmt_execute($stmt)) {
        echo "<script>
            alert('User berhasil ditambahkan!');
            window.location='index.php';
        </script>";
    } else {
        echo "<script>
            alert('Terjadi kesalahan sistem saat menyimpan data.');
            window.location='create.php';
        </script>";
    }

} else {
    // Jika file diakses langsung tanpa lewat form, kembalikan ke index
    header("Location: index.php");
    exit;
}
?>