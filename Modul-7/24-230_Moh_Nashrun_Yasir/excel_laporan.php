<?php
include 'koneksi.php';

if (!isset($_GET['tgl_mulai']) || !isset($_GET['tgl_selesai'])) {
    die("Error: Rentang tanggal tidak valid.");
}

$tgl_mulai = $_GET['tgl_mulai'];
$tgl_selesai = $_GET['tgl_selesai'];

$filename = "laporan_penjualan ($tgl_mulai sampai $tgl_selesai).xls";
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=\"$filename\"");

$query_rekap = "SELECT DATE(waktu) as tanggal, SUM(total) as total_harian 
                FROM transaksi 
                WHERE DATE(waktu) BETWEEN '$tgl_mulai' AND '$tgl_selesai' 
                GROUP BY DATE(waktu) 
                ORDER BY DATE(waktu) ASC";
$result_rekap = mysqli_query($conn, $query_rekap);

$query_summary = "SELECT COUNT(DISTINCT pelanggan_id) as jumlah_pelanggan,
SUM(total) as jumlah_pendapatan
FROM transaksi
WHERE DATE(waktu) BETWEEN '$tgl_mulai' AND '$tgl_selesai'";
$result_summary = mysqli_query($conn, $query_summary);
$data_summary = mysqli_fetch_assoc($result_summary);

echo "<h3>Rekap Laporan Penjualan $tgl_mulai sampai $tgl_selesai</h3>";

echo "<table border='1'>
        <thead>
            <tr>
                <th>No</th>
                <th>Total</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>";

$no = 1;
while ($row = mysqli_fetch_assoc($result_rekap)) {
    echo "<tr>
            <td>" . $no++ . "</td>
            <td>Rp " . number_format($row['total_harian'], 0, ',', '.') . "</td>
            <td>" . date('d-M-y', strtotime($row['tanggal'])) . "</td>
            </tr>";
}
echo "</tbody></table>";

echo "<br><br>";
echo "<table border='1'>
        <thead>
            <tr>
                <th>Jumlah Pelanggan</th>
                <th>Jumlah Pendapatan</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>" . $data_summary['jumlah_pelanggan'] . " Orang</td>
                <td>Rp " . number_format($data_summary['jumlah_pendapatan'], 0, ',', '.') . "</td>
            </tr>
        </tbody>
      </table>";

exit;
?>