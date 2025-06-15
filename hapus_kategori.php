<?php
include 'koneksi.php';

if (isset($_GET['id'])) {
    $id_kategori = $_GET['id'];

    // Cek apakah kategori digunakan oleh produk
    $cek_produk = mysqli_query($conn, "SELECT COUNT(*) as total FROM produk WHERE id_kategori = '$id_kategori'");
    $data = mysqli_fetch_assoc($cek_produk);

    if ($data['total'] > 0) {
        echo "<script>
            alert('Kategori tidak bisa dihapus karena masih digunakan oleh produk!');
            window.location.href='kategori.php';
        </script>";
    } else {
        // Hapus kategori
        $query = mysqli_query($conn, "DELETE FROM kategori WHERE id_kategori = '$id_kategori'");

        if ($query) {
            echo "<script>
                alert('Kategori berhasil dihapus!');
                window.location.href='kategori.php';
            </script>";
        } else {
            echo "<script>
                alert('Gagal menghapus kategori!');
                window.location.href='kategori.php';
            </script>";
        }
    }
} else {
    echo "<script>
        alert('ID kategori tidak ditemukan!');
        window.location.href='kategori.php';
    </script>";
}
?>
