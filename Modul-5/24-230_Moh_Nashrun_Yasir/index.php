<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "store";

$conn = mysqli_connect($host, $user, $pass, $db);

if ($conn) {
    // echo "koneksi berhasil";
} else {
    echo "Koneksi ke database gagal: " . mysqli_connect_error();
    exit;
}



$query = mysqli_query($conn, "SELECT * FROM supplier");
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Data Master Supplier</title>
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f5f5f5;
        margin: 0;
        padding: 0;
    }
    .container {
        width: 80%;
        margin: 40px auto;
        background: #fff;
        padding: 25px 30px;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    h2 { text-align: center; color: #333; }
    a.btn {
        background-color: #007bff;
        color: white;
        padding: 8px 12px;
        text-decoration: none;
        border-radius: 4px;
        margin-bottom: 10px;
        display: inline-block;
    }
    a.btn:hover { background-color: #0056b3; }
    table { width: 100%; border-collapse: collapse; margin-top: 10px; }
    th, td { border: 1px solid #ccc; padding: 10px; }
    th { background: #007bff; color: white; text-align: left; }
    .aksi a {
        text-decoration: none; padding: 5px 10px;
        border-radius: 4px; color: white;
    }
    .aksi a.edit { background: #28a745; }
    .aksi a.delete { background: #dc3545; }
    .aksi a:hover { opacity: 0.8; }
</style>
</head>
<body>
<div class="container">
    <h2>Data Master Supplier</h2>
    <a href="tambah_supplier.php" class="btn">Tambah Data</a>
    <table>
        <tr>
            <th>ID</th>
            <th>Nama Supplier</th>
            <th>Telepon</th>
            <th>Alamat</th>
            <th>Aksi</th>
        </tr>
        <?php while ($d = mysqli_fetch_assoc($query)) { ?>
        <tr>
            <td><?= $d['id'] ?></td>
            <td><?= htmlspecialchars($d['nama']) ?></td>
            <td><?= htmlspecialchars($d['telp']) ?></td>
            <td><?= htmlspecialchars($d['alamat']) ?></td>
            <td class="aksi">
                <a href="edit_supplier.php?id=<?= $d['id'] ?>" class="edit">Edit</a>
                <a href="hapus_supplier.php?id=<?= $d['id'] ?>" class="delete" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>
            </td>
        </tr>
        <?php } ?>
    </table>
</div>
</body>
</html>
