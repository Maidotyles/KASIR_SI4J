<?php
include 'koneksi.php';
include 'partials/header.php';
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.6.0/css/bootstrap.min.css">

  <!-- Font Awesome 5 -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

  <!-- Custom CSS -->
  <link rel="stylesheet" href="assets/css/bootstrap.min.css">

<div class="container mt-4">
  <h2 class="mb-4">Daftar Produk Skincare</h2>
  
  <a href="tambah_produk.php" class="btn btn-primary mb-3">+ Tambah Produk</a>
  
  <div class="table-responsive">
    <table class="table table-bordered table-hover">
      <thead class="thead-dark">
        <tr>
          <th>No</th>
          <th>Nama Produk</th>
          <th>Kategori</th>
          <th>Harga</th>
          <th>Stok</th>
          <th>Tanggal Expired</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $no = 1;
        $query = "SELECT produk.*, kategori.nama_kategori 
                  FROM produk 
                  JOIN kategori ON produk.id_kategori = kategori.id_kategori";
        $result = mysqli_query($conn, $query);
        while ($row = mysqli_fetch_assoc($result)) {
        ?>
        <tr>
          <td><?= $no++; ?></td>
          <td><?= htmlspecialchars($row['nama_produk']); ?></td>
          <td><?= htmlspecialchars($row['nama_kategori']); ?></td>
          <td>Rp <?= number_format($row['harga'], 0, ',', '.'); ?></td>
          <td><?= $row['stok']; ?></td>
          <td><?= date('d-m-Y', strtotime($row['tanggal_exp'])); ?></td>
          <td>
            <a href="edit_produk.php?id=<?= $row['id_produk']; ?>" class="btn btn-sm btn-warning">Edit</a>
            <a href="hapus_produk.php?id=<?= $row['id_produk']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin hapus produk ini?')">Hapus</a>
          </td>
        </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

<!-- Bootstrap 4.6 JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.6.0/js/bootstrap.bundle.min.js"></script>

<!-- Custom JS -->
<script src="assets/js/script.js"></script>
