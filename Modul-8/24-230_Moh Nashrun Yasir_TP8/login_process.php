<?php
session_start();
include 'koneksi.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = trim($_POST['username']);
    $pass = md5($_POST['password']);
    $stmt = mysqli_prepare($conn, "SELECT * FROM user WHERE username=? AND password=?");
    mysqli_stmt_bind_param($stmt, "ss", $user, $pass);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    if ($row = mysqli_fetch_assoc($res)) {
        $_SESSION['user'] = ['id'=>$row['id_user'], 'username'=>$row['username'], 'nama'=>$row['nama'], 'level'=>$row['level']];
        header('Location: dashboard.php');
    } else {
        header('Location: index.php?msg=Username atau Password Salah');
    }
}
?>