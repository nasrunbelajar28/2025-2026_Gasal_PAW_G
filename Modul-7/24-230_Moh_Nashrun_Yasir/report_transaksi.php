<?php
include 'koneksi.php';

$tgl_mulai = isset($_GET['tgl_mulai']) ? $_GET['tgl_mulai'] : '';
$tgl_selesai = isset($_GET['tgl_selesai']) ? $_GET['tgl_selesai'] : '';
$data_laporan = [];
$data_summary = null;
$labels_chart = [];
$data_chart = [];

$page_title = "Rekap Laporan Penjualan";

if ($tgl_mulai && $tgl_selesai) {
    $page_title = "Rekap Laporan Penjualan $tgl_mulai sampai $tgl_selesai";

    $query_rekap = "SELECT DATE(waktu) as tanggal, SUM(total) as total_harian 
                    FROM transaksi 
                    WHERE DATE(waktu) BETWEEN '$tgl_mulai' AND '$tgl_selesai' 
                    GROUP BY DATE(waktu) 
                    ORDER BY DATE(waktu) ASC";
    $result_rekap = mysqli_query($conn, $query_rekap);
    while ($row = mysqli_fetch_assoc($result_rekap)) {
        $data_laporan[] = $row;
        $labels_chart[] = date('Y-m-d', strtotime($row['tanggal']));
        $data_chart[] = $row['total_harian'];
    }

    $query_summary = "SELECT COUNT(DISTINCT pelanggan_id) as jumlah_pelanggan,
    SUM(total) as jumlah_pendapatan
    FROM transaksi
    WHERE DATE(waktu) BETWEEN '$tgl_mulai' AND '$tgl_selesai'";
    $result_summary = mysqli_query($conn, $query_summary);
    $data_summary = mysqli_fetch_assoc($result_summary);
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Laporan Penjualan</title>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>
body { font-family: Arial; background-color: #f7f7f7; padding: 20px; }
.container { background-color: white; padding: 25px; border-radius: 8px; box-shadow: 0 0 5px rgba(0,0,0,0.1); max-width: 900px; margin: auto; }
.header-bar { background-color: #007bff; color: white; padding: 15px; border-radius: 8px 8px 0 0; font-size: 1.2em; }
.filter-box { padding: 20px; background-color: #fdfdfd; border: 1px solid #eee; border-radius: 5px; margin-bottom: 20px; }
.btn {
    padding: 8px 15px;
    color: white;
    background-color: #007bff;
    text-decoration: none;
    border-radius: 5px;
    border: none;
    cursor: pointer;
    font-size: 14px;
}
.btn-green { background-color: #28a745; }
.btn-green:hover { background-color: #218838; }
.btn-blue { background-color: #007bff; }
.btn-blue:hover { background-color: #0056b3; }
.btn-yellow { background-color: #ffc107; color: black; }
.btn-yellow:hover { background-color: #e0a800; }
input[type="date"] { padding: 7px; border: 1px solid #ccc; border-radius: 4px; margin: 0 10px; }
table { border-collapse: collapse; width: 100%; margin-top: 20px; }
table, th, td { border: 1px solid #ddd; }
th, td { padding: 8px; text-align: left; }
th { background-color: #e2eafc; }
.summary-table { width: 400px; margin-top: 10px; }

@media print {
    .no-print {
        display: none !important;
    }
    body, .container {
        background-color: white;
        box-shadow: none;
        padding: 0;
        margin: 0;
    }
    .header-bar {
        background-color: #007bff !important;
        color: white !important;
        -webkit-print-color-adjust: exact;
        color-adjust: exact;
    }
    th {
        background-color: #e2eafc !important;
        -webkit-print-color-adjust: exact;
        color-adjust: exact;
    }
}
</style>
</head>
<body>
<div class="container">
    <div class="header-bar"><?php echo htmlspecialchars($page_title); ?></div>
    
    <div class="filter-box no-print">
        <a href="index.php" class="btn btn-blue">Kembali</a>
        <form method="GET" style="display: inline-block; margin-left: 20px;">
            <label>Dari Tanggal:</label>
            <input type="date" name="tgl_mulai" value="<?php echo $tgl_mulai; ?>" required>
            <label>Sampai Tanggal:</label>
            <input type="date" name="tgl_selesai" value="<?php echo $tgl_selesai; ?>" required>
            <button type="submit" class="btn btn-green">Tampilkan</button>
        </form>
    </div>

    <?php if ($tgl_mulai && $tgl_selesai): ?>
    
    <div class="no-print" style="margin-bottom: 20px;">
        <button onclick="window.print()" class="btn btn-yellow">Cetak</button>
        <a href="excel_laporan.php?tgl_mulai=<?php echo $tgl_mulai; ?>&tgl_selesai=<?php echo $tgl_selesai; ?>" class="btn btn-green">Excel</a>
    </div>

    <div id="laporan-area">
        
        <div style="width: 100%; margin-bottom: 30px;">
            <canvas id="myChart"></canvas>
        </div>

        <h4>Rekap Total Penerimaan</h4>
        <table>
            <tr>
                <th>No</th>
                <th>Total</th>
                <th>Tanggal</th>
            </tr>
            <?php
            $no = 1;
            foreach ($data_laporan as $row) {
                echo "<tr>
                        <td>" . $no++ . "</td>
                        <td>Rp " . number_format($row['total_harian'], 0, ',', '.') . "</td>
                        <td>" . date('d Nov Y', strtotime($row['tanggal'])) . "</td>
                      </tr>";
            }
            if ($no == 1) {
                echo "<tr><td colspan='3' style='text-align:center;'>Tidak ada data transaksi pada rentang tanggal ini.</td></tr>";
            }
            ?>
        </table>

        <h4 style="margin-top: 30px;">Total</h4>
        <table class="summary-table">
            <tr>
                <th>Jumlah Pelanggan</th>
                <th>Jumlah Pendapatan</th>
            </tr>
            <tr>
                <td><?php echo $data_summary['jumlah_pelanggan']; ?> Orang</td>
                <td>Rp <?php echo number_format($data_summary['jumlah_pendapatan'], 0, ',', '.'); ?></td>
            </tr>
        </table>
    </div>

    <script>
    const ctx = document.getElementById('myChart');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($labels_chart); ?>,
            datasets: [{
                label: 'Total',
                data: <?php echo json_encode($data_chart); ?>,
                backgroundColor: 'rgba(153, 153, 153, 0.5)',
                borderColor: 'rgba(153, 153, 153, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: { y: { beginAtZero: true } },
            plugins: { legend: { display: true } }
        }
    });
    </script>
    
    <?php elseif (isset($_GET['tgl_mulai'])): ?>
        <p style="text-align: center;">Tidak ada data untuk rentang tanggal yang dipilih.</p>
    <?php endif; ?>
</div>
</body>
</html>