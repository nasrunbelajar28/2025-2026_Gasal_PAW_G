<?php
session_start(); include 'koneksi.php';
$id = $_GET['id'];
if (isset($_POST['update'])) {
    $waktu=$_POST['waktu']; $pel=$_POST['pelanggan_id']; $ket=$_POST['keterangan'];
    mysqli_query($conn, "UPDATE transaksi SET waktu_transaksi='$waktu', pelanggan_id='$pel', keterangan='$ket' WHERE id='$id'");
    header("Location: hapus_transaksi.php");
}
$d = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM transaksi WHERE id='$id'"));
?>
<!doctype html><html><body class="bg-light"><div class="container mt-5" style="width:500px;"><div class="card shadow"><div class="card-header bg-warning">Edit Transaksi</div><div class="card-body">
<form method="post">
    <input type="date" name="waktu" class="form-control mb-2" value="<?= $d['waktu_transaksi'] ?>">
    <select name="pelanggan_id" class="form-control mb-2"><?php $q=mysqli_query($conn,"SELECT * FROM pelanggan"); while($r=mysqli_fetch_assoc($q)){ $s=($r['id']==$d['pelanggan_id'])?'selected':''; echo "<option value='{$r['id']}' $s>{$r['nama']}</option>"; } ?></select>
    <textarea name="keterangan" class="form-control mb-2"><?= $d['keterangan'] ?></textarea>
    <button name="update" class="btn btn-warning btn-block">Simpan</button>
</form></div></div></div></body></html>