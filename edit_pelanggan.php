<?php
include 'koneksi.php';
include 'partials/header.php';

$id = $_GET['id'];
$query = mysqli_query($conn, "SELECT * FROM pelanggan WHERE id_pelanggan = $id");
$data = mysqli_fetch_assoc($query);

if (isset($_POST['update'])) {
    $nama = $_POST['nama'];
    $no_hp = $_POST['no_hp'];
    $alamat = $_POST['alamat'];

    $update = mysqli_query($conn, "UPDATE pelanggan SET 
        nama = '$nama',
        no_hp = '$no_hp',
        alamat = '$alamat'
        WHERE id_pelanggan = $id
    ");

    if ($update) {
        echo "<script>alert('Data berhasil diupdate'); window.location='pelanggan.php';</script>";
    } else {
        echo "<script>alert('Gagal update data');</script>";
    }
}
?>

<div class="container mt-4">
    <h2>Edit Data Pelanggan</h2>
    <form method="post">
        <div class="form-group">
            <label>Nama</label>
            <input type="text" name="nama" class="form-control" value="<?= $data['nama'] ?>" required>
        </div>
        <div class="form-group">
            <label>No. HP</label>
            <input type="text" name="no_hp" class="form-control" value="<?= $data['no_hp'] ?>">
        </div>
        <div class="form-group">
            <label>Alamat</label>
            <textarea name="alamat" class="form-control" required><?= $data['alamat'] ?></textarea>
        </div>
        <button type="submit" name="update" class="btn btn-primary">Update</button>
        <a href="pelanggan.php" class="btn btn-secondary">Kembali</a>
    </form>
</div>

