<?php
include 'koneksi.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "<script>alert('ID produk tidak ditemukan'); window.location='produk.php';</script>";
    exit;
}

$id_produk = $_GET['id'];

// Jalankan query hapus
$hapus = mysqli_query($conn, "DELETE FROM produk WHERE id_produk = '$id_produk'");

if ($hapus) {
    echo "<script>alert('Produk berhasil dihapus'); window.location='produk.php';</script>";
} else {
    echo "<script>alert('Gagal menghapus produk'); window.location='produk.php';</script>";
}
?>
