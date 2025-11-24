<?php
session_start();

// 1. Cek Login & Level (Proteksi Halaman)
// Hanya Level 1 (Owner) yang boleh akses
if (!isset($_SESSION['user']) || $_SESSION['user']['level'] != 1) {
    header('Location: ../dashboard.php');
    exit;
}
?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Tambah User Baru</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <div class="container mt-5" style="max-width: 500px;">
        
        <div class="card shadow">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">Tambah User Baru</h5>
            </div>

            <div class="card-body">
                <form action="store.php" method="post">
                    
                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" name="username" class="form-control" placeholder="Contoh: kasir01" required>
                    </div>

                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Masukkan password" required>
                    </div>

                    <div class="form-group">
                        <label>Nama Lengkap</label>
                        <input type="text" name="nama" class="form-control" placeholder="Contoh: Budi Santoso" required>
                    </div>

                    <div class="form-group">
                        <label>Level Akses</label>
                        <select name="level" class="form-control">
                            <option value="2">Kasir (Level 2)</option>
                            <option value="1">Owner / Admin (Level 1)</option>
                        </select>
                    </div>

                    <div class="form-group mt-4">
                        <button type="submit" class="btn btn-success btn-block font-weight-bold">Simpan User</button>
                        <a href="index.php" class="btn btn-secondary btn-block">Batal</a>
                    </div>

                </form>
            </div>
        </div>

    </div>

</body>
</html>