<?php include 'connection.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Barang</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h2>Input Data Barang</h2>
<form id="barangForm" action="result.php" method="post" enctype="multipart/form-data">
    <label for="kode_barang">Kode Barang:</label>
    <input type="number" id="kode_barang" name="kode_barang" required>

    <label for="nama_barang">Nama Barang:</label>
    <input type="text" id="nama_barang" name="nama_barang" required>

    <label for="harga">Harga (Rp):</label>
    <input type="number" id="harga" step="0.01" name="harga" required>

    <label for="image">Image:</label>
    <input type="file" id="image" name="image" accept="image/*" required>

    <label for="keterangan">Keterangan:</label>
    <textarea id="keterangan" name="keterangan" required></textarea>

    <input type="submit" name="submit" value="Simpan">
</form>

<script>
document.getElementById('barangForm').addEventListener('submit', function(e) {
    var kode_barang = document.getElementById('kode_barang').value;
    var nama_barang = document.getElementById('nama_barang').value;
    var harga = document.getElementById('harga').value;
    var image = document.getElementById('image').files[0];
    var keterangan = document.getElementById('keterangan').value;

    if (kode_barang <= 0) {
        alert('Kode barang harus berupa angka positif.');
        e.preventDefault();
        return;
    }

    if (harga <= 0) {
        alert('Harga harus lebih dari 0.');
        e.preventDefault();
        return;
    }

    if (keterangan.length < 5) {
        alert('Keterangan harus minimal 5 karakter.');
        e.preventDefault();
        return;
    }

    if (image) {
        var fileSize = image.size / 1024 / 1024;
        var fileExtension = image.name.split('.').pop().toLowerCase();

        if (fileSize > 2) {
            alert('Ukuran gambar tidak boleh lebih dari 2MB.');
            e.preventDefault();
            return;
        }

        if (['jpg', 'jpeg', 'png'].indexOf(fileExtension) === -1) {
            alert('Format gambar harus jpg, jpeg, atau png.');
            e.preventDefault();
            return;
        }
    }
});
</script>

</body>
</html>
