<?php
include 'connection.php';

if (isset($_POST['submit'])) {
    $kode_barang = $_POST['kode_barang'];
    $nama_barang = $_POST['nama_barang'];
    $harga = $_POST['harga'];
    $keterangan = $_POST['keterangan'];
    
    // Handle file upload
    $image = $_FILES['image']['name'];
    $target = "uploads/" . basename($image);

    if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
        $sql = "INSERT INTO barang (kode_barang, nama_barang, harga, image, keterangan)
                VALUES ('$kode_barang', '$nama_barang', '$harga', '$image', '$keterangan')";

        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Data berhasil disimpan!');</script>";
        } else {
            echo "<script>alert('Error: " . $sql . "<br>" . $conn->error . "');</script>";
        }
    } else {
        echo "<script>alert('Gagal mengupload gambar. Pastikan ukuran dan format gambar benar.');</script>";
    }
}

// Menampilkan data
$result = $conn->query("SELECT * FROM barang");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Barang</title>
    <link rel="stylesheet" href="style.css">
        <script>
        // Fungsi konfirmasi sebelum menghapus data
        function confirmDelete() {
            return confirm("Apakah Anda yakin ingin menghapus data ini?");
        }
    </script>
</head>
<body>

<h2>Data Barang</h2>

<!-- Button Kembali ke index.php -->
<a href="index.php" class="back-btn">Tambah Data Baru</a>

<table>
    <tr>
        <th>Kode Barang</th>
        <th>Nama Barang</th>
        <th>Harga</th>
        <th>Image</th>
        <th>Keterangan</th>
        <th>Aksi</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()): ?>
    <tr>
        <td><?php echo $row['kode_barang']; ?></td>
        <td><?php echo $row['nama_barang']; ?></td>
        <td><?php echo "Rp " . number_format($row['harga'], 2); ?></td>
        <td><img src="uploads/<?php echo $row['image']; ?>" width="100" alt="Image"></td>
        <td><?php echo $row['keterangan']; ?></td>
        <td class="actions">
            <form action="update.php" method="post">
                <input type="hidden" name="kode_barang" value="<?php echo $row['kode_barang']; ?>">
                <input type="submit" name="edit" value="Edit" class="edit">
            </form>
            <form action="delete.php" method="post" onsubmit="return confirmDelete();">
                <input type="hidden" name="kode_barang" value="<?php echo $row['kode_barang']; ?>">
                <input type="submit" name="delete" value="Hapus">
            </form>
        </td>
    </tr>
    <?php endwhile; ?>
</table>

</body>
</html>

<?php $conn->close(); ?>
