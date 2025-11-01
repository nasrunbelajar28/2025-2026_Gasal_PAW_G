<?php
$conn = mysqli_connect("localhost", "root", "", "store");
$id = $_GET['id'];

if (isset($_POST['hapus'])) {
    mysqli_query($conn, "DELETE FROM supplier WHERE id='$id'");
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Hapus Data Supplier</title>
<style>
    body { font-family: Arial; background: #f5f5f5; }
    .container {
        width: 400px; margin: 80px auto; background: #fff;
        padding: 30px; border-radius: 10px;
        text-align: center; box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    h3 { color: #333; margin-bottom: 25px; }
    .btn {
        display: inline-block; padding: 8px 15px;
        border-radius: 5px; text-decoration: none;
        color: white; margin: 5px;
    }
    .yes { background: #dc3545; }
    .no { background: #6c757d; }
    .btn:hover { opacity: 0.8; }
</style>
</head>
<body>
<div class="container">
    <h3>Apakah Anda yakin ingin menghapus data ini?</h3>
    <form method="POST">
        <input type="submit" name="hapus" value="Ya, Hapus" class="btn yes">
        <a href="index.php" class="btn no">Batal</a>
    </form>
</div>
</body>
</html>