<?php
session_start();
include 'koneksi.php';

// 1. CEK LOGIN & LEVEL (Wajib Owner/Level 1)
if (!isset($_SESSION['user']) || $_SESSION['user']['level'] != 1) {
    header('Location: dashboard.php');
    exit;
}

// 2. AMBIL ID DARI URL
$id = isset($_GET['id']) ? $_GET['id'] : '';
if (empty($id)) {
    header('Location: index_pelanggan.php');
    exit;
}

// 3. PROSES UPDATE DATA (Jika tombol Update diklik)
if (isset($_POST['update'])) {
    $id_pelanggan = $_POST['id']; // ID tidak diubah (readonly)
    $nama         = $_POST['nama'];
    $jk           = $_POST['jenis_kelamin'];
    $telp         = $_POST['telp'];
    $alamat       = $_POST['alamat'];

    $query_update = "UPDATE pelanggan SET 
                     nama = '$nama', 
                     jenis_kelamin = '$jk', 
                     telp = '$telp', 
                     alamat = '$alamat' 
                     WHERE id = '$id_pelanggan'";
    
    if (mysqli_query($conn, $query_update)) {
        echo "<script>alert('Data Pelanggan berhasil diperbarui!'); window.location='index_pelanggan.php';</script>";
        exit;
    } else {
        echo "<script>alert('Gagal update data.');</script>";
    }
}

// 4. AMBIL DATA LAMA UNTUK DITAMPILKAN DI FORM
$query = mysqli_query($conn, "SELECT * FROM pelanggan WHERE id = '$id'");
$data = mysqli_fetch_assoc($query);

// Jika ID tidak ditemukan di database
if (!$data) {
    echo "<script>alert('Data tidak ditemukan!'); window.location='index_pelanggan.php';</script>";
    exit;
}
?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Edit Pelanggan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5" style="max-width: 600px;">
    <div class="card shadow">
        <div class="card-header bg-warning text-white">
            <h5 class="mb-0">Edit Data Pelanggan</h5>
        </div>
        <div class="card-body">
            <form method="post">
                
                <div class="form-group">
                    <label>ID Pelanggan</label>
                    <input type="text" name="id" class="form-control" value="<?= $data['id']; ?>" readonly style="background-color: #e9ecef;">
                    <small class="text-muted">ID Pelanggan tidak dapat diubah.</small>
                </div>

                <div class="form-group">
                    <label>Nama Lengkap</label>
                    <input type="text" name="nama" class="form-control" value="<?= $data['nama']; ?>" required>
                </div>

                <div class="form-group">
                    <label>Jenis Kelamin</label>
                    <select name="jenis_kelamin" class="form-control" required>
                        <option value="L" <?= ($data['jenis_kelamin'] == 'L') ? 'selected' : ''; ?>>Laki-laki (L)</option>
                        <option value="P" <?= ($data['jenis_kelamin'] == 'P') ? 'selected' : ''; ?>>Perempuan (P)</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>No. Telepon</label>
                    <input type="number" name="telp" class="form-control" value="<?= $data['telp']; ?>" required>
                </div>

                <div class="form-group">
                    <label>Alamat</label>
                    <textarea name="alamat" class="form-control" rows="3" required><?= $data['alamat']; ?></textarea>
                </div>

                <div class="form-group mt-4">
                    <button type="submit" name="update" class="btn btn-warning btn-block font-weight-bold text-white">Update Data</button>
                    <a href="index_pelanggan.php" class="btn btn-secondary btn-block">Batal</a>
                </div>

            </form>
        </div>
    </div>
</div>

</body>
</html>