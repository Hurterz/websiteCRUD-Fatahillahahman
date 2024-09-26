<?php
include 'connection.php';

if (isset($_POST['delete'])) {
    $kode_barang = $_POST['kode_barang'];

    // Hapus gambar dari folder uploads terlebih dahulu
    $sql = "SELECT image FROM barang WHERE kode_barang = '$kode_barang'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $image_path = "uploads/" . $row['image'];
        if (file_exists($image_path)) {
            unlink($image_path); // Menghapus file gambar dari folder
        }
    }

    // Hapus data dari database
    $sql = "DELETE FROM barang WHERE kode_barang = '$kode_barang'";

    if ($conn->query($sql) === TRUE) {
        // Redirect ke result.php setelah delete berhasil
        header("Location: result.php");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}

$conn->close();
?>
