<?php
session_start();
include '../koneksi.php';

// 1. Pastikan akses via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // 2. Ambil data dari form
    $id       = $_POST['id'];
    $username = trim($_POST['username']);
    $nama     = trim($_POST['nama']);
    $level    = $_POST['level'];
    $password = $_POST['password'];

    // 3. Validasi: Cek apakah username sudah dipakai orang lain?
    // Logika: Cari username yang SAMA, tapi ID-nya BUKAN user ini
    $query_cek = "SELECT id_user FROM user WHERE username = ? AND id_user != ?";
    $stmt_cek = mysqli_prepare($conn, $query_cek);
    mysqli_stmt_bind_param($stmt_cek, "si", $username, $id);
    mysqli_stmt_execute($stmt_cek);
    mysqli_stmt_store_result($stmt_cek);

    if (mysqli_stmt_num_rows($stmt_cek) > 0) {
        echo "<script>
            alert('Gagal! Username \"$username\" sudah digunakan user lain.');
            window.location='edit.php?id=$id';
        </script>";
        exit;
    }

    // 4. Proses Update
    if (!empty($password)) {
        // SKENARIO A: Password Diisi -> Update Password juga
        $pass_md5 = md5($password);
        $query = "UPDATE user SET username=?, password=?, nama=?, level=? WHERE id_user=?";
        $stmt = mysqli_prepare($conn, $query);
        // Bind: s(string), s(string), s(string), i(int), i(int)
        mysqli_stmt_bind_param($stmt, "sssii", $username, $pass_md5, $nama, $level, $id);
    } else {
        // SKENARIO B: Password Kosong -> Jangan ubah password lama
        $query = "UPDATE user SET username=?, nama=?, level=? WHERE id_user=?";
        $stmt = mysqli_prepare($conn, $query);
        // Bind: s(string), s(string), i(int), i(int)
        mysqli_stmt_bind_param($stmt, "ssii", $username, $nama, $level, $id);
    }

    // Eksekusi Query
    if (mysqli_stmt_execute($stmt)) {
        echo "<script>
            alert('Data user berhasil diperbarui!');
            window.location='index.php';
        </script>";    
    } else {
        echo "<script>
            alert('Terjadi kesalahan saat mengupdate data.');
            window.location='edit.php?id=$id';
        </script>";
    }

} else {
    header("Location: index.php");
    exit;
}
?>