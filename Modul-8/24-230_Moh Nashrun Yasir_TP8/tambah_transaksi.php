<?php
session_start(); include 'koneksi.php';
if (!isset($_SESSION['user'])) { header('Location: index.php'); exit; }

if (isset($_POST['simpan'])) {
    $waktu = $_POST['waktu']; $pel = $_POST['pelanggan_id']; $ket = $_POST['keterangan'];
    mysqli_query($conn, "INSERT INTO transaksi (waktu_transaksi, pelanggan_id, keterangan, total) VALUES ('$waktu', '$pel', '$ket', 0)");
    $id = mysqli_insert_id($conn);
    header("Location: lihat_detail.php?id=$id");
}
?>
<!doctype html>
<html>
<head><title>Tambah Transaksi</title><link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet"></head>
<body class="bg-light">
<div class="container mt-5" style="width: 500px;">
    <div class="card shadow">
        <div class="card-header bg-success text-white"><h5>Tambah Transaksi</h5></div>
        <div class="card-body">
            <form method="post">
                <div class="form-group"><label>Tanggal</label><input type="date" name="waktu" class="form-control" value="<?= date('Y-m-d') ?>" required></div>
                <div class="form-group"><label>Pelanggan</label>
                    <select name="pelanggan_id" class="form-control" required>
                        <?php $q=mysqli_query($conn,"SELECT * FROM pelanggan"); while($r=mysqli_fetch_assoc($q)){ echo "<option value='{$r['id']}'>{$r['nama']}</option>"; } ?>
                    </select>
                </div>
                <div class="form-group"><label>Keterangan</label><textarea name="keterangan" class="form-control"></textarea></div>
                <button type="submit" name="simpan" class="btn btn-success btn-block">Lanjut Pilih Barang</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>