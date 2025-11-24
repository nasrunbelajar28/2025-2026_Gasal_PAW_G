<?php
session_start();

// 1. CEK LOGIN & LEVEL (Wajib Owner)
if (!isset($_SESSION['user']) || $_SESSION['user']['level'] != 1) {
    header('Location: dashboard.php');
    exit;
}

include 'koneksi.php';

// 2. PROSES SIMPAN
if (isset($_POST['simpan'])) {
    $kode     = $_POST['kode_barang'];
    $nama     = $_POST['nama_barang'];
    $harga    = $_POST['harga'];
    $stok     = $_POST['stok'];
    $supplier = $_POST['supplier_id'];

    // Cek Kode Kembar
    $cek = mysqli_query($conn, "SELECT * FROM barang WHERE kode_barang='$kode'");
    if (mysqli_num_rows($cek) > 0) {
        echo "<script>alert('Kode Barang $kode sudah ada! Gunakan kode lain.');</script>";
    } else {
        $query = "INSERT INTO barang (kode_barang, nama_barang, harga, stok, supplier_id) 
                  VALUES ('$kode', '$nama', '$harga', '$stok', '$supplier')";
        
        if (mysqli_query($conn, $query)) {
            echo "<script>alert('Barang berhasil ditambahkan!'); window.location='index_barang.php';</script>";
            exit;
        } else {
            echo "<script>alert('Gagal menyimpan!');</script>";
        }
    }
}
?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8"><title>Tambah Barang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5" style="max-width: 600px;">
    <div class="card shadow">
        <div class="card-header bg-success text-white">
            <h5 class="mb-0">Tambah Barang Baru</h5>
        </div>
        <div class="card-body">
            <form method="post">
                
                <div class="form-group">
                    <label>Kode Barang</label>
                    <input type="text" name="kode_barang" class="form-control" placeholder="Contoh: BRG011" required>
                </div>

                <div class="form-group">
                    <label>Nama Barang</label>
                    <input type="text" name="nama_barang" class="form-control" placeholder="Nama Produk" required>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Harga (Rp)</label>
                            <input type="number" name="harga" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Stok Awal</label>
                            <input type="number" name="stok" class="form-control" required>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>Supplier</label>
                    <select name="supplier_id" class="form-control" required>
                        <option value="">-- Pilih Supplier --</option>
                        <?php
                        // Ambil data supplier untuk dropdown
                        $sup = mysqli_query($conn, "SELECT * FROM supplier ORDER BY nama ASC");
                        while ($s = mysqli_fetch_assoc($sup)) {
                            echo "<option value='{$s['id']}'>{$s['nama']}</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group mt-4">
                    <button type="submit" name="simpan" class="btn btn-success btn-block font-weight-bold">Simpan Barang</button>
                    <a href="index_barang.php" class="btn btn-secondary btn-block">Batal</a>
                </div>

            </form>
        </div>
    </div>
</div>
</body>
</html>