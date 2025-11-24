<?php
session_start();
include 'koneksi.php';

// 1. Cek Login & Level (Proteksi Halaman)
// Hanya Level 1 (Owner) yang boleh akses
if (!isset($_SESSION['user']) || $_SESSION['user']['level'] != 1) {
    header('Location: dashboard.php');
    exit;
}
?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Data Barang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <div class="container mt-5">
        
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="mb-0">Data Barang</h3>
            <div>
                <a href="tambah_barang.php" class="btn btn-success font-weight-bold">+ Tambah Barang</a>
                <a href="dashboard.php" class="btn btn-secondary font-weight-bold">Kembali</a>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-body p-0">
                <table class="table table-bordered table-striped table-hover mb-0">
                    <thead class="thead-dark">
                        <tr>
                            <th width="5%" class="text-center">No</th>
                            <th>Kode Barang</th>
                            <th>Nama Barang</th>
                            <th>Harga</th>
                            <th width="10%" class="text-center">Stok</th>
                            <th width="15%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Mengambil data barang
                        $query = mysqli_query($conn, "SELECT * FROM barang ORDER BY nama_barang ASC");
                        $no = 1;

                        if (mysqli_num_rows($query) > 0) {
                            while ($row = mysqli_fetch_assoc($query)) {
                                echo "<tr>
                                    <td class='text-center'>{$no}</td>
                                    <td class='font-weight-bold'>{$row['kode_barang']}</td>
                                    <td>" . htmlspecialchars($row['nama_barang']) . "</td>
                                    <td>Rp " . number_format($row['harga'], 0, ',', '.') . "</td>
                                    <td class='text-center'>" . number_format($row['stok']) . "</td>
                                    <td class='text-center'>
                                        <a href='edit_barang.php?id={$row['id']}' class='btn btn-warning btn-sm text-white'>Edit</a>
                                        <a href='hapus_barang.php?id={$row['id']}' class='btn btn-danger btn-sm' onclick=\"return confirm('Yakin ingin menghapus barang ini?')\">Hapus</a>
                                    </td>
                                </tr>";
                                $no++;
                            }
                        } else {
                            echo "<tr><td colspan='6' class='text-center text-muted py-3'>Belum ada data barang.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        
    </div>
</body>
</html>