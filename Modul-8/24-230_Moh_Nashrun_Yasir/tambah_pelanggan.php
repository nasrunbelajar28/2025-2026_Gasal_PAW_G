<?php
session_start();

// 1. CEK LOGIN & LEVEL (Wajib Owner/Level 1)
if (!isset($_SESSION['user']) || $_SESSION['user']['level'] != 1) {
    header('Location: dashboard.php');
    exit;
}

include 'koneksi.php';

// 2. PROSES PENYIMPANAN DATA
if (isset($_POST['simpan'])) {
    $id     = $_POST['id'];
    $nama   = $_POST['nama'];
    $jk     = $_POST['jenis_kelamin'];
    $telp   = $_POST['telp'];
    $alamat = $_POST['alamat'];

    // Cek apakah ID Pelanggan sudah ada di database?
    $cek_id = mysqli_query($conn, "SELECT * FROM pelanggan WHERE id = '$id'");
    
    if (mysqli_num_rows($cek_id) > 0) {
        echo "<script>alert('Gagal! ID Pelanggan $id sudah digunakan. Gunakan ID lain.');</script>";
    } else {
        // Query Simpan
        $query = "INSERT INTO pelanggan (id, nama, jenis_kelamin, telp, alamat) 
                  VALUES ('$id', '$nama', '$jk', '$telp', '$alamat')";
        
        if (mysqli_query($conn, $query)) {
            echo "<script>alert('Data Pelanggan berhasil ditambahkan!'); window.location='index_pelanggan.php';</script>";
            exit;
        } else {
            echo "<script>alert('Gagal menyimpan database.');</script>";
        }
    }
}
?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Tambah Pelanggan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5" style="max-width: 600px;">
    <div class="card shadow">
        <div class="card-header bg-success text-white">
            <h5 class="mb-0">Tambah Pelanggan Baru</h5>
        </div>
        <div class="card-body">
            <form method="post">
                
                <div class="form-group">
                    <label>ID Pelanggan</label>
                    <input type="text" name="id" class="form-control" placeholder="Contoh: C011" required>
                </div>

                <div class="form-group">
                    <label>Nama Lengkap</label>
                    <input type="text" name="nama" class="form-control" placeholder="Nama Pelanggan" required>
                </div>

                <div class="form-group">
                    <label>Jenis Kelamin</label>
                    <select name="jenis_kelamin" class="form-control" required>
                        <option value="">-- Pilih --</option>
                        <option value="L">Laki-laki (L)</option>
                        <option value="P">Perempuan (P)</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>No. Telepon</label>
                    <input type="number" name="telp" class="form-control" placeholder="08..." required>
                </div>

                <div class="form-group">
                    <label>Alamat</label>
                    <textarea name="alamat" class="form-control" rows="3" placeholder="Alamat Lengkap" required></textarea>
                </div>

                <div class="form-group mt-4">
                    <button type="submit" name="simpan" class="btn btn-success btn-block font-weight-bold">Simpan Data</button>
                    <a href="index_pelanggan.php" class="btn btn-secondary btn-block">Batal</a>
                </div>

            </form>
        </div>
    </div>
</div>

</body>
</html>