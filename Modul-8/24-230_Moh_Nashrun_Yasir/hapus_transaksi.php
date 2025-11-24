<?php
session_start();
include 'koneksi.php';

// 1. CEK LOGIN
if (!isset($_SESSION['user'])) {
    header('Location: index.php');
    exit;
}

// 2. LOGIKA HAPUS (Menghapus Transaksi + Detail Barang)
if (isset($_GET['hapus_id'])) {
    $id_hapus = $_GET['hapus_id'];
    
    // Hapus detailnya dulu
    mysqli_query($conn, "DELETE FROM transaksi_detail WHERE transaksi_id='$id_hapus'");
    
    // Hapus header transaksi
    $hapus = mysqli_query($conn, "DELETE FROM transaksi WHERE id='$id_hapus'");
    
    if ($hapus) {
        echo "<script>alert('Transaksi berhasil dihapus!'); window.location='hapus_transaksi.php';</script>";
    } else {
        echo "<script>alert('Gagal menghapus!'); window.location='hapus_transaksi.php';</script>";
    }
}
?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8"><title>Data Transaksi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Daftar Transaksi</h4>
            <div>
                <a href="tambah_transaksi.php" class="btn btn-success btn-sm font-weight-bold">
                    <i class="fas fa-plus"></i>   Baru
                </a>
                <a href="dashboard.php" class="btn btn-light btn-sm font-weight-bold">Kembali</a>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th width="5%">No</th>
                        <th>Tanggal</th>
                        <th>Pelanggan</th>
                        <th>Ket</th>
                        <th>Total</th>
                        <th width="20%" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $query = "SELECT t.*, p.nama AS nama_pelanggan 
                          FROM transaksi t 
                          LEFT JOIN pelanggan p ON t.pelanggan_id = p.id 
                          ORDER BY t.waktu_transaksi DESC, t.id DESC";
                          
                $result = mysqli_query($conn, $query);
                $no = 1;
                
                while ($row = mysqli_fetch_assoc($result)) {
                    $tgl = date('d-m-Y', strtotime($row['waktu_transaksi']));
                    $total = number_format($row['total'], 0, ',', '.');
                    ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= $tgl; ?></td>
                        <td><?= htmlspecialchars($row['nama_pelanggan']); ?></td>
                        <td><?= htmlspecialchars($row['keterangan']); ?></td>
                        <td class="font-weight-bold">Rp <?= $total; ?></td>
                        <td class="text-center">
                            
                            <a href="edit_transaksi.php?id=<?= $row['id']; ?>" class="btn btn-warning btn-sm text-white" title="Edit Info">
                                Edit
                            </a>
                            
                            <a href="hapus_transaksi.php?hapus_id=<?= $row['id']; ?>" 
                               class="btn btn-danger btn-sm" 
                               onclick="return confirm('Yakin hapus transaksi ini? Data barang juga akan hilang.')" title="Hapus">
                               Hapus
                            </a>
                        </td>
                    </tr>
                    <?php
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>