<?php include 'koneksi.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Tambah Data Transaksi</title>
<style>
body { background-color: #f7f7f7; font-family: Arial; }
.container {
    width: 350px;
    margin: 50px auto;
    background-color: white;
    padding: 25px;
    border-radius: 8px;
    box-shadow: 0 0 5px rgba(0,0,0,0.2);
}
h3 { text-align: center; }
label { font-weight: bold; }
input, textarea, select {
    width: 100%;
    padding: 8px;
    margin: 6px 0;
    border: 1px solid #ccc;
    border-radius: 4px;
}
.btn {
    width: 100%;
    padding: 10px;
    border: none;
    color: white;
    background-color: #007bff;
    border-radius: 4px;
    cursor: pointer;
}
.btn:hover { background-color: #0056b3; }
</style>
</head>
<body>
<div class="container">
<h3>Tambah Data Transaksi</h3>
<form method="post">
    <label>Waktu Transaksi</label>
    <input type="date" name="waktu" required>

    <label>Keterangan</label>
    <textarea name="keterangan" placeholder="Masukkan keterangan transaksi" minlength="3" required></textarea>

    <label>Total</label>
    <input type="text" value="0" readonly>

    <label>Pelanggan</label>
    <select name="pelanggan_id" required>
        <option value="">Pilih Pelanggan</option>
        <?php
        $pelanggan = mysqli_query($conn, "SELECT * FROM pelanggan");
        while ($p = mysqli_fetch_assoc($pelanggan)) {
            echo "<option value='$p[id]'>$p[nama]</option>";
        }
        ?>
    </select>

    <button type="submit" name="simpan" class="btn">Tambah Transaksi</button>
</form>
</div>
</body>
</html>

<?php
if (isset($_POST['simpan'])) {
    $waktu = $_POST['waktu'];
    $keterangan = trim($_POST['keterangan']);
    $pelanggan_id = $_POST['pelanggan_id'];

    if ($waktu < date('Y-m-d')) {
        echo "<script>alert('Tanggal transaksi tidak boleh sebelum hari ini!');</script>";
    } elseif (strlen($keterangan) < 3) {
        echo "<script>alert('Keterangan minimal 3 karakter!');</script>";
    } else {
        mysqli_query($conn, "INSERT INTO transaksi (waktu, keterangan, pelanggan_id, total)
                             VALUES ('$waktu', '$keterangan', '$pelanggan_id', 0)");
        echo "<script>alert('Data transaksi berhasil disimpan!'); window.location='index.php';</script>";
    }
}
?>