<?php
include 'connection.php';

$kode_barang = "";
$nama_barang = "";
$harga = "";
$image = "";
$keterangan = "";

// Jika form "Edit" di-submit
if (isset($_POST['edit'])) {
    $kode_barang = $_POST['kode_barang'];

    // Ambil data dari database berdasarkan kode_barang
    $sql = "SELECT * FROM barang WHERE kode_barang = '$kode_barang'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $nama_barang = $row['nama_barang'];
        $harga = $row['harga'];
        $image = $row['image'];
        $keterangan = $row['keterangan'];
    }
}

if (isset($_POST['update'])) {
    $kode_barang = $_POST['kode_barang'];
    $nama_barang = $_POST['nama_barang'];
    $harga = $_POST['harga'];
    $keterangan = $_POST['keterangan'];

    // Handle file upload jika ada file baru yang diunggah
    if ($_FILES['image']['name'] != "") {
        $image = $_FILES['image']['name'];
        $target = "uploads/" . basename($image);

        if (!is_dir('uploads')) {
            mkdir('uploads');
        }

        if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
            // Lakukan pembaruan gambar di database
            $sql = "UPDATE barang SET nama_barang = '$nama_barang', harga = '$harga', image = '$image', keterangan = '$keterangan' WHERE kode_barang = '$kode_barang'";
        }
    } else {
        // Jika tidak ada gambar baru yang diunggah, hanya update kolom lainnya
        $sql = "UPDATE barang SET nama_barang = '$nama_barang', harga = '$harga', keterangan = '$keterangan' WHERE kode_barang = '$kode_barang'";
    }

    if ($conn->query($sql) === TRUE) {
        // Redirect ke result.php setelah update berhasil
        header("Location: result.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Barang</title>
    <link rel="stylesheet" href="style.css">
    <script>
        // Fungsi konfirmasi sebelum update
        function confirmUpdate() {
            return confirm("Apakah Anda yakin ingin memperbarui data ini?");
        }

        // Fungsi untuk menampilkan pratinjau gambar
        function previewImage() {
            var file = document.querySelector("input[name='image']").files[0];
            var preview = document.getElementById("imagePreview");
            var reader = new FileReader();

            reader.onloadend = function() {
                preview.src = reader.result;
            }

            if (file) {
                reader.readAsDataURL(file); // Mengubah gambar ke base64 string
            } else {
                preview.src = "";
            }
        }
    </script>
</head>
<body>

<h2>Update Data Barang</h2>

<form action="update.php" method="post" enctype="multipart/form-data" onsubmit="return confirmUpdate();">
    <input type="hidden" name="kode_barang" value="<?php echo $kode_barang; ?>">

    <label for="nama_barang">Nama Barang:</label>
    <input type="text" name="nama_barang" value="<?php echo $nama_barang; ?>" required>

    <label for="harga">Harga (Rp):</label>
    <input type="number" step="0.01" name="harga" value="<?php echo $harga; ?>" required>

    <label for="image">Image:</label>
    <input type="file" name="image" onchange="previewImage()">
    <p>Image saat ini: <img id="imagePreview" src="uploads/<?php echo $image; ?>" alt="Image Preview"></p>

    <label for="keterangan">Keterangan:</label>
    <textarea name="keterangan" required><?php echo $keterangan; ?></textarea>

    <input type="submit" name="update" value="Update">
    <a href="result.php" class="cancel-btn">Cancel</a>
</form>

</body>
</html>
