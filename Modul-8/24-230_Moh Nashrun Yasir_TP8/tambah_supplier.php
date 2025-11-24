<?php
session_start();

// 1. CEK LOGIN (Wajib Login)
if (!isset($_SESSION['user'])) {
    header('Location: index.php');
    exit;
}

// 2. CEK LEVEL (Hanya Level 1 / Owner yang boleh akses)
if ($_SESSION['user']['level'] != 1) {
    echo "<script>alert('Akses Ditolak! Anda bukan Owner.'); window.location='dashboard.php';</script>";
    exit;
}

include 'koneksi.php';

$errors = [];

// PROSES SIMPAN DATA
if (isset($_POST['simpan'])) {
    $nama   = trim($_POST['nama']);
    $telp   = trim($_POST['telp']);
    $alamat = trim($_POST['alamat']);

    // Validasi Sederhana
    if (empty($nama)) {
        $errors[] = "Nama Supplier tidak boleh kosong.";
    }
    if (empty($telp) || !is_numeric($telp)) {
        $errors[] = "Nomor Telepon harus berupa angka.";
    }
    if (empty($alamat)) {
        $errors[] = "Alamat tidak boleh kosong.";
    }

    // Jika tidak ada error, simpan ke database
    if (empty($errors)) {
        // Query Insert
        $query = "INSERT INTO supplier (nama, telp, alamat) VALUES ('$nama', '$telp', '$alamat')";
        
        if (mysqli_query($conn, $query)) {
            echo "<script>alert('Supplier berhasil ditambahkan!'); window.location='index_supplier.php';</script>";
            exit;
        } else {
            $errors[] = "Gagal menyimpan ke database: " . mysqli_error($conn);
        }
    }
}
?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Tambah Supplier</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5" style="max-width: 600px;">
    <div class="card shadow-sm">
        <div class="card-header bg-success text-white">
            <h4 class="mb-0">Tambah Supplier Baru</h4>
        </div>
        <div class="card-body">
            
            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger">
                    <ul class="mb-0 pl-3">
                        <?php foreach ($errors as $err): ?>
                            <li><?php echo $err; ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form method="post">
                <div class="form-group">
                    <label>Nama Supplier</label>
                    <input type="text" name="nama" class="form-control" placeholder="Contoh: PT Sumber Rejeki" required value="<?php echo isset($_POST['nama']) ? htmlspecialchars($_POST['nama']) : ''; ?>">
                </div>

                <div class="form-group">
                    <label>Nomor Telepon</label>
                    <input type="text" name="telp" class="form-control" placeholder="Contoh: 08123456789" required value="<?php echo isset($_POST['telp']) ? htmlspecialchars($_POST['telp']) : ''; ?>">
                </div>

                <div class="form-group">
                    <label>Alamat</label>
                    <textarea name="alamat" class="form-control" rows="3" placeholder="Alamat lengkap supplier" required><?php echo isset($_POST['alamat']) ? htmlspecialchars($_POST['alamat']) : ''; ?></textarea>
                </div>

                <div class="form-group mt-4">
                    <button type="submit" name="simpan" class="btn btn-success btn-block">Simpan Data</button>
                    <a href="index_supplier.php" class="btn btn-secondary btn-block">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>