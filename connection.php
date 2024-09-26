<?php
$servername = "localhost";
$username = "root"; // Sesuaikan username
$password = "";     // Sesuaikan password
$dbname = "barangku";

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
