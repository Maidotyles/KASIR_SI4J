<?php
include 'auth.php';
include 'koneksi.php';

if (!isset($_GET['id'])) {
    echo "<script>alert('ID transaksi tidak ditemukan'); location.href='transaksi.php';</script>";
    exit;
}

$id = $_GET['id'];

// Hapus data detail transaksi terlebih dahulu
$hapus_detail = mysqli_query($conn, "DELETE FROM detail_transaksi WHERE id_transaksi = '$id'");

// Setelah detail dihapus, baru hapus transaksi utamanya
$hapus_transaksi = mysqli_query($conn, "DELETE FROM transaksi WHERE id_transaksi = '$id'");

if ($hapus_detail && $hapus_transaksi) {
    echo "<script>alert('Transaksi berhasil dihapus!'); location.href='transaksi.php';</script>";
} else {
    echo "<script>alert('Gagal menghapus transaksi.'); location.href='transaksi.php';</script>";
}
