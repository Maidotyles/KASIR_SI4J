<?php
include 'koneksi.php';
include 'partials/header.php';
include 'partials/navbar.php';

$query = mysqli_query($conn, "SELECT * FROM kategori");
?>

<div class="container mt-4">
  <h3 class="mb-4">Data Kategori</h3>
  <a href="tambah_kategori.php" class="btn btn-primary mb-3">+ Tambah Kategori</a>
  <table class="table table-bordered table-striped">
    <thead class="thead-dark">
      <tr>
        <th>No</th>
        <th>Nama Kategori</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      <?php $no = 1; while ($data = mysqli_fetch_assoc($query)) : ?>
      <tr>
        <td><?= $no++ ?></td>
        <td><?= htmlspecialchars($data['nama_kategori']) ?></td>
        <td>
          <a href="edit_kategori.php?id=<?= $data['id_kategori'] ?>" class="btn btn-sm btn-warning">Edit</a>
          <a href="hapus_kategori.php?id=<?= $data['id_kategori'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus kategori ini?')">Hapus</a>
        </td>
      </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>
