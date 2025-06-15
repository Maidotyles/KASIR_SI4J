<?php
include 'koneksi.php';

$id = $_GET['id'];
$hapus = mysqli_query($conn, "DELETE FROM pelanggan WHERE id_pelanggan = $id");

if ($hapus) {
    echo "<script>alert('Data berhasil dihapus'); window.location='pelanggan.php';</script>";
} else {
    echo "<script>alert('Gagal menghapus data'); window.location='pelanggan.php';</script>";
}
