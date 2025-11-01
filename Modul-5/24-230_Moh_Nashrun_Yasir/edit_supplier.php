<?php
$conn = mysqli_connect("localhost", "root", "", "store");

$id = $_GET['id'];
$data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM supplier WHERE id='$id'"));

$errors = [];
if (isset($_POST['update'])) {
    $nama = trim($_POST['nama']);
    $telp = trim($_POST['telp']);
    $alamat = trim($_POST['alamat']);

    if ($nama == '' || !preg_match("/^[a-zA-Z ]+$/", $nama))
        $errors[] = "Nama hanya boleh huruf dan tidak boleh kosong.";
    if ($telp == '' || !preg_match("/^[0-9]+$/", $telp))
        $errors[] = "Telepon hanya boleh angka dan tidak boleh kosong.";
    if ($alamat == '' || !preg_match("/^(?=.*[a-zA-Z])(?=.*[0-9]).+$/", $alamat))
        $errors[] = "Alamat harus mengandung huruf dan angka.";

    if (empty($errors)) {
        mysqli_query($conn, "UPDATE supplier SET nama='$nama', telp='$telp', alamat='$alamat' WHERE id='$id'");
        header("Location: index.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Edit Data Supplier</title>
<style>
    body { font-family: Arial; background: #f5f5f5; }
    .container {
        width: 400px; margin: 60px auto; background: #fff;
        padding: 25px; border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    h2 { text-align: center; color: #333; }
    label { display: block; margin-top: 10px; }
    input[type=text] {
        width: 100%; padding: 8px; border: 1px solid #ccc;
        border-radius: 4px; margin-top: 5px;
    }
    input[type=submit] {
        background: #28a745; color: white;
        border: none; padding: 10px 15px;
        border-radius: 5px; margin-top: 15px;
        cursor: pointer;
    }
    input[type=submit]:hover { background: #218838; }
    a { text-decoration: none; color: #007bff; margin-left: 10px; }
    .error { color: red; margin-bottom: 8px; }
</style>
</head>
<body>
<div class="container">
    <h2>Edit Data Supplier</h2>
    <?php foreach ($errors as $err) echo "<div class='error'>$err</div>"; ?>
    <form method="POST">
        <label>Nama Supplier</label>
        <input type="text" name="nama" value="<?= $_POST['nama'] ?? $data['nama'] ?>">
        <label>Telepon</label>
        <input type="text" name="telp" value="<?= $_POST['telp'] ?? $data['telp'] ?>">
        <label>Alamat</label>
        <input type="text" name="alamat" value="<?= $_POST['alamat'] ?? $data['alamat'] ?>">
        <input type="submit" name="update" value="Simpan">
        <a href="index.php">Batal</a>
    </form>
</div>
</body>
</html>
