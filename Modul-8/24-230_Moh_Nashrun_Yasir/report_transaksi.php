<?php
session_start();
include 'koneksi.php';

// Ambil input tanggal dari URL (jika ada)
$tgl_mulai = isset($_GET['tgl_mulai']) ? $_GET['tgl_mulai'] : '';
$tgl_selesai = isset($_GET['tgl_selesai']) ? $_GET['tgl_selesai'] : '';
$data_laporan = [];
$labels_chart = [];
$data_chart = [];

if ($tgl_mulai && $tgl_selesai) {
    // Query mengambil data per tanggal
    // Perbaikan: Menggunakan kolom 'waktu_transaksi' sesuai database store.sql
    $query_rekap = "SELECT DATE(waktu_transaksi) as tanggal, SUM(total) as total_harian 
                    FROM transaksi 
                    WHERE DATE(waktu_transaksi) BETWEEN '$tgl_mulai' AND '$tgl_selesai' 
                    GROUP BY DATE(waktu_transaksi) 
                    ORDER BY DATE(waktu_transaksi) ASC";
    
    $result_rekap = mysqli_query($conn, $query_rekap);
    
    // Cek error query
    if (!$result_rekap) { die("Query Error: " . mysqli_error($conn)); }

    while ($row = mysqli_fetch_assoc($result_rekap)) {
        $data_laporan[] = $row;
        // Siapkan data untuk Grafik
        $labels_chart[] = date('d-m-Y', strtotime($row['tanggal']));
        $data_chart[] = $row['total_harian'];
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8"><title>Laporan Penjualan</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style> 
    /* Sembunyikan tombol navigasi saat diprint */
    @media print { .no-print { display: none !important; } } 
</style>
</head>
<body class="bg-light">
<div class="container mt-4 bg-white p-4 shadow rounded">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>Laporan Penjualan</h3>
        <a href="dashboard.php" class="btn btn-secondary no-print">Kembali ke Dashboard</a>
    </div>

    <div class="card mb-4 no-print">
        <div class="card-body">
            <form method="GET" class="form-inline">
                <label class="mr-2 font-weight-bold">Dari:</label>
                <input type="date" name="tgl_mulai" class="form-control mr-3" value="<?= $tgl_mulai ?>" required>
                
                <label class="mr-2 font-weight-bold">Sampai:</label>
                <input type="date" name="tgl_selesai" class="form-control mr-3" value="<?= $tgl_selesai ?>" required>
                
                <button type="submit" class="btn btn-primary">Tampilkan</button>
                
                <?php if($tgl_mulai): ?>
                    <button type="button" onclick="window.print()" class="btn btn-warning ml-2">Cetak PDF</button>
                    
                    <a href="excel_laporan.php?tgl_mulai=<?= $tgl_mulai; ?>&tgl_selesai=<?= $tgl_selesai; ?>" 
                       class="btn btn-success ml-2" target="_blank">Export Excel</a>
                <?php endif; ?>
            </form>
        </div>
    </div>

    <?php if ($tgl_mulai && $tgl_selesai): ?>
        
        <div style="width: 100%; height: 350px;" class="mb-5">
            <canvas id="myChart"></canvas>
        </div>

        <h5>Tabel Rincian Harian</h5>
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th width="10%">No</th>
                    <th>Tanggal</th>
                    <th>Total Pendapatan</th>
                </tr>
            </thead>
            <tbody>
            <?php 
            $no = 1; 
            $grand_total = 0;
            
            if (empty($data_laporan)) {
                echo "<tr><td colspan='3' class='text-center'>Tidak ada transaksi pada periode ini.</td></tr>";
            }

            foreach ($data_laporan as $row) {
                $grand_total += $row['total_harian'];
                echo "<tr>
                    <td>{$no}</td>
                    <td>".date('d F Y', strtotime($row['tanggal']))."</td>
                    <td>Rp ".number_format($row['total_harian'],0,',','.')."</td>
                </tr>"; 
                $no++;
            }
            ?>
            <tr class="font-weight-bold bg-warning text-dark">
                <td colspan="2" class="text-right">TOTAL KESELURUHAN</td>
                <td>Rp <?= number_format($grand_total, 0, ',', '.') ?></td>
            </tr>
            </tbody>
        </table>

        <script>
        const ctx = document.getElementById('myChart');
        new Chart(ctx, {
            type: 'bar', // Grafik Batang
            data: {
                labels: <?= json_encode($labels_chart); ?>,
                datasets: [{
                    label: 'Pendapatan Harian (Rp)',
                    data: <?= json_encode($data_chart); ?>,
                    backgroundColor: 'rgba(23, 162, 184, 0.6)', // Warna Biru Tosca transparan
                    borderColor: 'rgba(23, 162, 184, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });
        </script>

    <?php else: ?>
        <div class="alert alert-info text-center">Silakan pilih rentang tanggal dan klik tombol <b>Tampilkan</b> untuk melihat laporan.</div>
    <?php endif; ?>
</div>
</body>
</html>