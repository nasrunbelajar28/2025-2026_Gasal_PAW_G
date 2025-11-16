<?php include 'koneksi.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Data Master Transaksi</title>
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
    background-color: #007bff;
    color: white;
    padding: 15px;
    border-radius: 5px;
}
table {
    border-collapse: collapse;
    width: 100%;
    margin-top: 10px;
}
table th, table td {
    border: 1px solid #ddd;
    padding: 8px;
    text-align: left;
}
table th {
    background-color: #e2eafc;
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
.btn-green {
    background-color: #28a745;
}
.btn-green:hover {
    background-color: #218838;
}
.action-bar {
    margin-bottom: 15px;
    margin-top: 15px;
}
.clearfix::after {
    content: "";
    clear: both;
    display: table;
}
.float-right {
    float: right;
}
</style>
</head>
<body>
<div class="container">
<h2>Data Master Transaksi</h2>

<div class="action-bar clearfix">
    <a href="report_transaksi.php" class="btn">Lihat Laporan Penjualan</a>
    <a href="tambah_transaksi.php" class="btn btn-green float-right">Tambah Transaksi</a>
</div>

<table>
<tr>
    <th>No</th>
    <th>ID Transaksi</th>
    <th>Waktu Transaksi</th>
    <th>Nama Pelanggan</th>
    <th>Keterangan</th>
    <th>Total</th>
</tr>
<?php
$query = "SELECT t.*, p.nama AS nama_pelanggan
FROM transaksi t
LEFT JOIN pelanggan p ON p.id = t.pelanggan_id
ORDER BY t.id ASC";
$transaksi = mysqli_query($conn, $query);
$no = 1;
while ($t = mysqli_fetch_assoc($transaksi)) {
    echo "<tr>
            <td>" . $no++ . "</td>
            <td>$t[id]</td>
            <td>" . date('Y-m-d', strtotime($t['waktu'])) . "</td>
            <td>$t[nama_pelanggan]</td>
            <td>$t[keterangan]</td>
            <td>Rp " . number_format($t['total'], 0, ',', '.') . "</td>
            </tr>";
}
?>
</table>

</div>
</body>
</html>