<?php
include 'koneksi.php';
include 'partials/header.php';

if (isset($_POST['simpan'])) {
    $nama = $_POST['nama'];
    $no_hp = $_POST['no_hp'];
    $alamat = $_POST['alamat'];

    $query = mysqli_query($conn, "INSERT INTO pelanggan (nama, no_hp, alamat) VALUES ('$nama', '$no_hp', '$alamat')");

    if ($query) {
        echo "<script>alert('Pelanggan berhasil ditambahkan'); window.location='pelanggan.php';</script>";
    } else {
        echo "<script>alert('Gagal menambahkan pelanggan');</script>";
    }
}
?>

<div class="container mt-4">
    <h2>Tambah Pelanggan</h2>
    <form method="post">
        <div class="form-group">
            <label>Nama</label>
            <input type="text" name="nama" class="form-control" required>
        </div>
        <div class="form-group">
            <label>No. HP</label>
            <input type="text" name="no_hp" class="form-control">
        </div>
        <div class="form-group">
            <label>Alamat</label>
            <textarea name="alamat" class="form-control" required></textarea>
        </div>
        <button type="submit" name="simpan" class="btn btn-success">Simpan</button>
        <a href="pelanggan.php" class="btn btn-secondary">Kembali</a>
    </form>
</div>

