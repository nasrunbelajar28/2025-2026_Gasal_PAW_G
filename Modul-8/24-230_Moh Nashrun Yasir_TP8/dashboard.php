<?php
session_start();

// 1. Cek Login
if (!isset($_SESSION['user'])) {
    header('Location: index.php');
    exit;
}

$u = $_SESSION['user'];
$role = ($u['level'] == 1) ? 'Owner' : 'Kasir';
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
      .bg-teal { background-color: #17a2b8 !important; }
  </style>
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-teal shadow-sm">
  <div class="container">
      <a class="navbar-brand font-weight-bold" href="#">Sistem Penjualan</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#mainNav">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="mainNav">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item active">
            <a class="nav-link" href="dashboard.php">Home</a>
          </li>

          <?php if ($u['level'] == 1): ?>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Data Master
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="index_barang.php">Data Barang</a>
              <a class="dropdown-item" href="index_supplier.php">Data Supplier</a>
              <a class="dropdown-item" href="index_pelanggan.php">Data Pelanggan</a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="users/index.php">Data User</a>
            </div>
          </li>
          <?php endif; ?>

          <li class="nav-item">
            <a class="nav-link" href="hapus_transaksi.php">Transaksi</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="report_transaksi.php">Laporan</a>
          </li>
        </ul>

        <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle font-weight-bold" href="#" data-toggle="dropdown">
                    Halo, <?= $u['nama'] ?> (<?= $role ?>)
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item text-danger" href="logout.php">Logout</a>
                </div>
            </li>
        </ul>
      </div>
  </div>
</nav>

<div class="container mt-4">
  <div class="jumbotron bg-white shadow-sm">
    <h1 class="display-4">Selamat Datang!</h1>
    <p class="lead">Anda login sebagai <b><?= $u['nama'] ?></b> di level <b><?= $role ?></b>.</p>
    <hr class="my-4">
    
    <?php if ($u['level'] == 1): ?>
        <p>Silakan kelola data Master Barang, Supplier, Pelanggan, dan User melalui menu di atas.</p>
        <a href="users/index.php" class="btn btn-info btn-lg">Kelola User</a>
    <?php else: ?>
        <p>Silakan lakukan transaksi penjualan atau cek laporan harian Anda.</p>
        <a href="tambah_transaksi.php" class="btn btn-success btn-lg">Mulai Transaksi</a>
    <?php endif; ?>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>