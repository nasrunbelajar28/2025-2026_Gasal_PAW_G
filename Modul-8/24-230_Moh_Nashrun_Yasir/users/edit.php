<?php
session_start();
include '../koneksi.php';

// 1. Cek Login & Level (Proteksi Halaman)
if (!isset($_SESSION['user']) || $_SESSION['user']['level'] != 1) {
    header('Location: ../dashboard.php');
    exit;
}

// 2. Ambil ID dari URL
$id = isset($_GET['id']) ? $_GET['id'] : '';

// 3. Ambil Data User berdasarkan ID
$query = mysqli_query($conn, "SELECT * FROM user WHERE id_user='$id'");
$data  = mysqli_fetch_assoc($query);

// Jika data tidak ditemukan, kembalikan ke index
if (!$data) {
    header('Location: index.php');
    exit;
}
?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Edit Data User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <div class="container mt-5" style="max-width: 500px;">
        
        <div class="card shadow">
            <div class="card-header bg-warning text-white">
                <h5 class="mb-0">Edit Data User</h5>
            </div>

            <div class="card-body">
                <form action="update.php" method="post">
                    
                    <input type="hidden" name="id" value="<?= $data['id_user'] ?>">

                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" name="username" class="form-control" value="<?= $data['username'] ?>" required>
                    </div>

                    <div class="form-group">
                        <label>Password Baru</label>
                        <input type="password" name="password" class="form-control" placeholder="Kosongkan jika tidak ingin mengganti password">
                        <small class="text-muted">Isi hanya jika Anda ingin mereset password user ini.</small>
                    </div>

                    <div class="form-group">
                        <label>Nama Lengkap</label>
                        <input type="text" name="nama" class="form-control" value="<?= $data['nama'] ?>" required>
                    </div>

                    <div class="form-group">
                        <label>Level Akses</label>
                        <select name="level" class="form-control">
                            <option value="2" <?= ($data['level'] == 2) ? 'selected' : '' ?>>Kasir (Level 2)</option>
                            <option value="1" <?= ($data['level'] == 1) ? 'selected' : '' ?>>Owner / Admin (Level 1)</option>
                        </select>
                    </div>

                    <div class="form-group mt-4">
                        <button type="submit" class="btn btn-warning btn-block font-weight-bold text-white">Simpan Perubahan</button>
                        <a href="index.php" class="btn btn-secondary btn-block">Batal</a>
                    </div>

                </form>
            </div>
        </div>

    </div>

</body>
</html>