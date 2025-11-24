<?php
session_start();

// 1. CEK LOGIN & LEVEL
if (!isset($_SESSION['user']) || $_SESSION['user']['level'] != 1) {
    header('Location: dashboard.php');
    exit;
}

include 'koneksi.php';

// Ambil ID dari URL
$id = isset($_GET['id']) ? $_GET['id'] : '';
if (!$id) { header('Location: index_supplier.php'); exit; }

// Ambil Data Lama
$query_old = mysqli_query($conn, "SELECT * FROM supplier WHERE id='$id'");
$data = mysqli_fetch_assoc($query_old);

if (!$data) { die("Data tidak ditemukan!"); }

$errors = [];

// PROSES UPDATE
if (isset($_POST['update'])) {
    $nama   = trim($_POST['nama']);
    $telp   = trim($_POST['telp']);
    $alamat = trim($_POST['alamat']);

    // Validasi
    if (empty($nama)) $errors[] = "Nama tidak boleh kosong.";
    if (empty($telp)) $errors[] = "Telepon tidak boleh kosong.";
    if (empty($alamat)) $errors[] = "Alamat tidak boleh kosong.";

    if (empty($errors)) {
        $update = "UPDATE supplier SET nama='$nama', telp='$telp', alamat='$alamat' WHERE id='$id'";
        if (mysqli_query($conn, $update)) {
            echo "<script>alert('Data berhasil diperbarui!'); window.location='index_supplier.php';</script>";
            exit;
        } else {
            $errors[] = "Gagal Update: " . mysqli_error($conn);
        }
    }
}
?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8"><title>Edit Supplier</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5" style="max-width: 600px;">
    <div class="card shadow-sm">
        <div class="card-header bg-warning text-white">
            <h4 class="mb-0">Edit Data Supplier</h4>
        </div>
        <div class="card-body">
            
            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger">
                    <ul class="mb-0 pl-3">
                        <?php foreach ($errors as $err): echo "<li>$err</li>"; endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form method="post">
                <div class="form-group">
                    <label>Nama Supplier</label>
                    <input type="text" name="nama" class="form-control" required 
                           value="<?php echo htmlspecialchars($data['nama']); ?>">
                </div>

                <div class="form-group">
                    <label>Nomor Telepon</label>
                    <input type="text" name="telp" class="form-control" required 
                           value="<?php echo htmlspecialchars($data['telp']); ?>">
                </div>

                <div class="form-group">
                    <label>Alamat</label>
                    <textarea name="alamat" class="form-control" rows="3" required><?php echo htmlspecialchars($data['alamat']); ?></textarea>
                </div>

                <div class="form-group mt-4">
                    <button type="submit" name="update" class="btn btn-warning btn-block font-weight-bold text-white">Update Data</button>
                    <a href="index_supplier.php" class="btn btn-secondary btn-block">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>