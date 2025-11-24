<?php
session_start();
include '../koneksi.php';

// 1. Cek Login & Level (Proteksi Halaman)
// Hanya Level 1 (Owner) yang boleh akses halaman ini
if (!isset($_SESSION['user']) || $_SESSION['user']['level'] != 1) {
    header('Location: ../dashboard.php');
    exit;
}
?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Kelola Users</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <div class="container mt-5">
        
        <div class="card shadow">
            <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Kelola Data User</h4>
                <div>
                    <a href="create.php" class="btn btn-light btn-sm font-weight-bold">+ Tambah User</a>
                    <a href="../dashboard.php" class="btn btn-secondary btn-sm font-weight-bold">Kembali</a>
                </div>
            </div>

            <div class="card-body p-0">
                <table class="table table-bordered table-striped table-hover mb-0">
                    <thead class="thead-dark">
                        <tr>
                            <th width="5%" class="text-center">No</th>
                            <th>Username</th>
                            <th>Nama Lengkap</th>
                            <th width="15%" class="text-center">Level</th>
                            <th width="15%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Query mengambil semua data user
                        $query = mysqli_query($conn, "SELECT * FROM user ORDER BY level ASC, nama ASC");
                        $no = 1;

                        if (mysqli_num_rows($query) > 0) {
                            while ($row = mysqli_fetch_assoc($query)) {
                                
                                // Logika tampilan Badge Level
                                if ($row['level'] == 1) {
                                    $level_badge = '<span class="badge badge-primary">Owner</span>';
                                } else {
                                    $level_badge = '<span class="badge badge-secondary">Kasir</span>';
                                }

                                echo "<tr>
                                    <td class='text-center'>{$no}</td>
                                    <td class='font-weight-bold'>{$row['username']}</td>
                                    <td>" . htmlspecialchars($row['nama']) . "</td>
                                    <td class='text-center'>{$level_badge}</td>
                                    <td class='text-center'>
                                        <a href='edit.php?id={$row['id_user']}' class='btn btn-warning btn-sm text-white'>Edit</a>
                                        <a href='delete.php?id={$row['id_user']}' class='btn btn-danger btn-sm' onclick=\"return confirm('Yakin ingin menghapus user ini?')\">Hapus</a>
                                    </td>
                                </tr>";
                                $no++;
                            }
                        } else {
                            echo "<tr><td colspan='5' class='text-center text-muted py-3'>Tidak ada data user lain.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>