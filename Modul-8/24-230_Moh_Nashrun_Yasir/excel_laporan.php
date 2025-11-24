<?php
include 'koneksi.php';

// Validasi Input Tanggal
if (!isset($_GET['tgl_mulai']) || !isset($_GET['tgl_selesai'])) {
    die("Error: Rentang tanggal tidak valid. Silakan kembali ke halaman laporan.");
}

$tgl_mulai = $_GET['tgl_mulai'];
$tgl_selesai = $_GET['tgl_selesai'];

// HEADER EXCEL (Penting!)
// Ini memberitahu browser bahwa output file ini adalah Excel
$filename = "Laporan_Penjualan_$tgl_mulai-sd-$tgl_selesai.xls";
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=\"$filename\"");

// Query Rekap Harian (Sama dengan report_transaksi.php)
$query_rekap = "SELECT DATE(waktu_transaksi) as tanggal, SUM(total) as total_harian 
                FROM transaksi 
                WHERE DATE(waktu_transaksi) BETWEEN '$tgl_mulai' AND '$tgl_selesai' 
                GROUP BY DATE(waktu_transaksi) 
                ORDER BY DATE(waktu_transaksi) ASC";
$result_rekap = mysqli_query($conn, $query_rekap);

// Query Summary Total (Untuk ringkasan bawah)
$query_summary = "SELECT COUNT(DISTINCT pelanggan_id) as jumlah_pelanggan,
                  SUM(total) as jumlah_pendapatan
                  FROM transaksi
                  WHERE DATE(waktu_transaksi) BETWEEN '$tgl_mulai' AND '$tgl_selesai'";
$result_summary = mysqli_query($conn, $query_summary);
$data_summary = mysqli_fetch_assoc($result_summary);
?>

<h3>Laporan Penjualan Periode <?php echo "$tgl_mulai s/d $tgl_selesai"; ?></h3>

<table border="1">
    <thead>
        <tr style="background-color: #f2f2f2;">
            <th>No</th>
            <th>Tanggal</th>
            <th>Total Pendapatan</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $no = 1;
        while ($row = mysqli_fetch_assoc($result_rekap)) {
            echo "<tr>
                    <td>" . $no++ . "</td>
                    <td>" . date('d-M-Y', strtotime($row['tanggal'])) . "</td>
                    <td>" . $row['total_harian'] . "</td>
                  </tr>";
        }
        ?>
    </tbody>
</table>

<br>

<h3>Ringkasan</h3>
<table border="1">
    <thead>
        <tr style="background-color: #f2f2f2;">
            <th>Jumlah Pelanggan Unik</th>
            <th>Total Pendapatan Keseluruhan</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><?php echo $data_summary['jumlah_pelanggan']; ?> Orang</td>
            <td>Rp <?php echo $data_summary['jumlah_pendapatan']; ?></td>
        </tr>
    </tbody>
</table>