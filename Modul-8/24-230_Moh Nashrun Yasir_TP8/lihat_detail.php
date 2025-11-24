<?php
session_start(); include 'koneksi.php';
if (!isset($_SESSION['user'])) { header('Location: index.php'); exit; }
$id = $_GET['id'];

if (isset($_POST['tambah_barang'])) {
    $bid = $_POST['barang_id']; $qty = $_POST['qty'];
    $hrg = mysqli_fetch_assoc(mysqli_query($conn, "SELECT harga FROM barang WHERE id='$bid'"))['harga'];
    mysqli_query($conn, "INSERT INTO transaksi_detail (transaksi_id, barang_id, harga, qty) VALUES ('$id', '$bid', '$hrg', '$qty')");
    mysqli_query($conn, "UPDATE transaksi SET total = (SELECT SUM(harga*qty) FROM transaksi_detail WHERE transaksi_id='$id') WHERE id='$id'");
    header("Location: lihat_detail.php?id=$id");
}
if (isset($_GET['del_item'])) {
    $bid = $_GET['del_item'];
    mysqli_query($conn, "DELETE FROM transaksi_detail WHERE transaksi_id='$id' AND barang_id='$bid'");
    mysqli_query($conn, "UPDATE transaksi SET total = (SELECT IFNULL(SUM(harga*qty),0) FROM transaksi_detail WHERE transaksi_id='$id') WHERE id='$id'");
    header("Location: lihat_detail.php?id=$id");
}
$trx = mysqli_fetch_assoc(mysqli_query($conn, "SELECT t.*, p.nama FROM transaksi t JOIN pelanggan p ON t.pelanggan_id=p.id WHERE t.id='$id'"));
?>
<!doctype html>
<html>
<head><title>Detail Transaksi</title><link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet"></head>
<body class="bg-light">
<div class="container mt-4">
    <div class="row">
        <div class="col-md-4">
            <div class="card mb-3"><div class="card-body"><h5>Info Transaksi #<?= $id ?></h5><p><?= $trx['nama'] ?><br><?= $trx['waktu_transaksi'] ?></p><a href="hapus_transaksi.php" class="btn btn-secondary btn-block">Kembali</a></div></div>
            <div class="card"><div class="card-header bg-info text-white">Tambah Barang</div><div class="card-body">
                <form method="post">
                    <div class="form-group"><select name="barang_id" class="form-control"><?php $q=mysqli_query($conn,"SELECT * FROM barang"); while($r=mysqli_fetch_assoc($q)){ echo "<option value='{$r['id']}'>{$r['nama_barang']} (Rp{$r['harga']})</option>"; } ?></select></div>
                    <div class="form-group"><input type="number" name="qty" class="form-control" value="1" min="1"></div>
                    <button name="tambah_barang" class="btn btn-primary btn-block">Tambah</button>
                </form>
            </div></div>
        </div>
        <div class="col-md-8">
            <div class="card"><div class="card-header">Isi Keranjang</div>
                <table class="table mb-0">
                    <thead><tr><th>Barang</th><th>Harga</th><th>Qty</th><th>Subtotal</th><th>Aksi</th></tr></thead>
                    <tbody>
                    <?php
                    $d = mysqli_query($conn, "SELECT d.*, b.nama_barang FROM transaksi_detail d JOIN barang b ON d.barang_id=b.id WHERE transaksi_id='$id'");
                    while($r=mysqli_fetch_assoc($d)){ echo "<tr><td>{$r['nama_barang']}</td><td>{$r['harga']}</td><td>{$r['qty']}</td><td>".($r['harga']*$r['qty'])."</td><td><a href='?id=$id&del_item={$r['barang_id']}' class='text-danger'>[x]</a></td></tr>"; }
                    ?>
                    </tbody>
                    <tfoot class="bg-dark text-white"><tr><td colspan="3" align="right">TOTAL</td><td colspan="2">Rp <?= number_format($trx['total']) ?></td></tr></tfoot>
                </table>
            </div>
        </div>
    </div>
</div></body></html>