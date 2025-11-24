<?php
session_start();
include 'koneksi.php';

// 1. CEK LOGIN
if (!isset($_SESSION['user']) || $_SESSION['user']['level'] != 1) {
    header('Location: dashboard.php'); exit;
}

$id = isset($_GET['id']) ? $_GET['id'] : '';
if (!$id) { header('Location: index_barang.php'); exit; }

// 2. PROSES UPDATE
if (isset($_POST['update'])) {
    $kode     = $_POST['kode_barang'];
    $nama     = $_POST['nama_barang'];
    $harga    = $_POST['harga'];
    $stok     = $_POST['stok'];
    $supplier = $_POST['supplier_id'];

    $query = "UPDATE barang SET 
              kode_barang='$kode', 
              nama_barang='$nama', 
              harga='$harga', 
              stok='$stok', 
              supplier_id='$supplier' 
              WHERE id='$id'";

    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Data Barang berhasil diupdate!'); window.location='index_barang.php';</script>";
        exit;
    } else {
        echo "<script>alert('Gagal update!');</script>";
    }
}

// 3. AMBIL DATA LAMA
$data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM barang WHERE id='$id'"));
if (!$data) { header('Location: index_barang.php'); exit; }
?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8"><title>Edit Barang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5" style="max-width: 600px;">
    <div class="card shadow">
        <div class="card-header bg-warning text-white">
            <h5 class="mb-0">Edit Data Barang</h5>
        </div>
        <div class="card-body">
            <form method="post">
                
                <div class="form-group">
                    <label>Kode Barang</label>
                    <input type="text" name="kode_barang" class="form-control" value="<?= $data['kode_barang'] ?>" required>
                </div>

                <div class="form-group">
                    <label>Nama Barang</label>
                    <input type="text" name="nama_barang" class="form-control" value="<?= $data['nama_barang'] ?>" required>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Harga (Rp)</label>
                            <input type="number" name="harga" class="form-control" value="<?= $data['harga'] ?>" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Stok</label>
                            <input type="number" name="stok" class="form-control" value="<?= $data['stok'] ?>" required>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>Supplier</label>
                    <select name="supplier_id" class="form-control" required>
                        <option value="">-- Pilih Supplier --</option>
                        <?php
                        $sup = mysqli_query($conn, "SELECT * FROM supplier ORDER BY nama ASC");
                        while ($s = mysqli_fetch_assoc($sup)) {
                            // Cek agar supplier lama terpilih otomatis
                            $selected = ($s['id'] == $data['supplier_id']) ? 'selected' : '';
                            echo "<option value='{$s['id']}' $selected>{$s['nama']}</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group mt-4">
                    <button type="submit" name="update" class="btn btn-warning btn-block font-weight-bold text-white">Simpan Perubahan</button>
                    <a href="index_barang.php" class="btn btn-secondary btn-block">Batal</a>
                </div>

            </form>
        </div>
    </div>
</div>
</body>
</html>