<?php include 'koneksi.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Pengelolaan Master Detail</title>
<style>
body {
    font-family: Arial, sans-serif;
    background-color: #f7f7f7;
    padding: 30px;
}
.container {
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 5px rgba(0,0,0,0.1);
}
h2 {
    text-align: center;
}
table {
    border-collapse: collapse;
    width: 100%;
    margin-top: 10px;
}
table, th, td {
    border: 1px solid #333;
}
th, td {
    padding: 6px;
    text-align: left;
}
th {
    background-color: #eee;
}
.btn {
    display: inline-block;
    padding: 8px 15px;
    color: white;
    background-color: #007bff;
    text-decoration: none;
    border-radius: 5px;
}
.btn:hover {
    background-color: #0056b3;
}
.btn-red {
    background-color: #dc3545;
}
.btn-red:hover {
    background-color: #b02a37;
}
</style>
</head>
<body>
<div class="container">
<h2>Pengelolaan Master Detail</h2>

<h3>Barang</h3>
<table>
<tr>
    <th>ID</th><th>Kode Barang</th><th>Nama Barang</th><th>Harga</th><th>Stok</th><th>Nama Supplier</th><th>Action</th>
</tr>
<?php
$barang = mysqli_query($conn, "SELECT * FROM barang");
while ($b = mysqli_fetch_assoc($barang)) {
    echo "<tr>
            <td>$b[id]</td>
            <td>$b[kode_barang]</td>
            <td>$b[nama]</td>
            <td>$b[harga]</td>
            <td>$b[stok]</td>
            <td>$b[supplier]</td>
            <td><a href='hapus_barang.php?id=$b[id]' class='btn btn-red' onclick='return confirm(\"Apakah anda yakin ingin menghapus data ini?\")'>Delete</a></td>
          </tr>";
}
?>
</table>

<h3>Transaksi</h3>
<table>
<tr>
    <th>ID</th><th>Waktu Transaksi</th><th>Keterangan</th><th>Total</th><th>Nama Pelanggan</th>
</tr>
<?php
$transaksi = mysqli_query($conn, "SELECT t.*, p.nama AS pelanggan FROM transaksi t 
                                  LEFT JOIN pelanggan p ON p.id=t.pelanggan_id");
while ($t = mysqli_fetch_assoc($transaksi)) {
    echo "<tr>
            <td>$t[id]</td>
            <td>$t[waktu]</td>
            <td>$t[keterangan]</td>
            <td>$t[total]</td>
            <td>$t[pelanggan]</td>
          </tr>";
}
?>
</table>

<h3>Transaksi Detail</h3>
<table>
<tr>
    <th>Transaksi ID</th><th>Nama Barang</th><th>Harga</th><th>Qty</th>
</tr>
<?php
$detail = mysqli_query($conn, "SELECT d.*, b.nama AS barang FROM transaksi_detail d 
                               LEFT JOIN barang b ON b.id=d.barang_id");
while ($d = mysqli_fetch_assoc($detail)) {
    echo "<tr>
            <td>$d[transaksi_id]</td>
            <td>$d[barang]</td>
            <td>$d[harga]</td>
            <td>$d[qty]</td>
          </tr>";
}
?>
</table>

<div style="text-align:center; margin-top:20px;">
    <a href="tambah_transaksi.php" class="btn">Tambah Transaksi</a>
    <a href="tambah_detail.php" class="btn">Tambah Transaksi Detail</a>
</div>
</div>
</body>
</html>