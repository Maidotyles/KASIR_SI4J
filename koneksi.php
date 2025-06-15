<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "db_skincare";

// Buat koneksi
$conn = mysqli_connect($host, $user, $pass, $db);

// Periksa koneksi
if (!$conn) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

// Optional: set charset (rekomendasi)
mysqli_set_charset($conn, "utf8mb4");
?>
