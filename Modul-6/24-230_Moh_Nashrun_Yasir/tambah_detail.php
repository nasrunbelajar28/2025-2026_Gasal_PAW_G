<?php include 'koneksi.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Tambah Detail Transaksi</title>
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
input, select {
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
<h3>Tambah Detail Transaksi</h3>
<form method="post">
    <label>Transaksi</label>
    <select name="transaksi_id" required>
        <?php
        $transaksi = mysqli_query($conn, "SELECT * FROM transaksi");
        while ($t = mysqli_fetch_assoc($transaksi)) {
            echo "<option value='$t[id]'>ID $t[id] - $t[keterangan]</option>";
        }
        ?>
    </select>

    <label>Barang</label>
    <select name="barang_id" required>
        <?php
        $barang = mysqli_query($conn, "SELECT * FROM barang");
        while ($b = mysqli_fetch_assoc($barang)) {
            echo "<option value='$b[id]'>$b[nama]</option>";
        }
        ?>
    </select>

    <label>Qty</label>
    <input type="number" name="qty" min="1" required>

    <button type="submit" name="tambah" class="btn">Tambah Detail</button>
</form>
</div>
</body>
</html>

<?php
if (isset($_POST['tambah'])) {
    $transaksi_id = $_POST['transaksi_id'];
    $barang_id = $_POST['barang_id'];
    $qty = $_POST['qty'];

    $cek = mysqli_num_rows(mysqli_query($conn, 
        "SELECT * FROM transaksi_detail WHERE transaksi_id='$transaksi_id' AND barang_id='$barang_id'"));
    if ($cek > 0) {
        echo "<script>alert('Barang sudah ada di transaksi ini!');</script>";
    } else {
        $barang = mysqli_fetch_assoc(mysqli_query($conn, "SELECT harga FROM barang WHERE id='$barang_id'"));
        $harga = $barang['harga'] * $qty;
        mysqli_query($conn, "INSERT INTO transaksi_detail (transaksi_id, barang_id, qty, harga)
                             VALUES ('$transaksi_id', '$barang_id', '$qty', '$harga')");
        mysqli_query($conn, "UPDATE transaksi 
                             SET total = (SELECT SUM(harga) FROM transaksi_detail WHERE transaksi_id='$transaksi_id')
                             WHERE id='$transaksi_id'");
        echo "<script>alert('Detail transaksi berhasil ditambahkan!'); window.location='index.php';</script>";
    }
}
?>