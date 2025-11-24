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
    <title>Data Supplier</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <div class="container mt-5">
        
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="mb-0">Data Supplier</h3>
            <div>
                <a href="tambah_supplier.php" class="btn btn-success font-weight-bold">+ Tambah Supplier</a>
                <a href="dashboard.php" class="btn btn-secondary font-weight-bold">Kembali</a>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-body p-0">
                <table class="table table-bordered table-striped table-hover mb-0">
                    <thead class="thead-dark">
                        <tr>
                            <th width="5%" class="text-center">No</th>
                            <th>Nama Supplier</th>
                            <th>No. Telepon</th>
                            <th>Alamat</th>
                            <th width="15%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query = mysqli_query($conn, "SELECT * FROM supplier ORDER BY nama ASC");
                        $no = 1;
                        
                        // Cek apakah ada data
                        if (mysqli_num_rows($query) > 0) {
                            while ($row = mysqli_fetch_assoc($query)) {
                                echo "<tr>
                                    <td class='text-center'>{$no}</td>
                                    <td>" . htmlspecialchars($row['nama']) . "</td>
                                    <td>" . htmlspecialchars($row['telp']) . "</td>
                                    <td>" . htmlspecialchars($row['alamat']) . "</td>
                                    <td class='text-center'>
                                        <a href='edit_supplier.php?id={$row['id']}' class='btn btn-warning btn-sm text-white'>Edit</a>
                                        <a href='hapus_supplier.php?id={$row['id']}' class='btn btn-danger btn-sm' onclick=\"return confirm('Yakin ingin menghapus supplier ini?')\">Hapus</a>
                                    </td>
                                </tr>";
                                $no++;
                            }
                        } else {
                            echo "<tr><td colspan='5' class='text-center text-muted py-3'>Belum ada data supplier.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        
    </div>

</body>
</html>