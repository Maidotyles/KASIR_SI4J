<?php
include 'koneksi.php';
include 'partials/header.php';

// Proses simpan data jika form disubmit
if (isset($_POST['simpan'])) {
    $nama_produk   = $_POST['nama_produk'];
    $id_kategori   = $_POST['id_kategori'];
    $harga         = $_POST['harga'];
    $stok          = $_POST['stok'];
    $tanggal_exp   = $_POST['tanggal_exp'];

    $query = "INSERT INTO produk (nama_produk, id_kategori, harga, stok, tanggal_exp)
              VALUES ('$nama_produk', '$id_kategori', '$harga', '$stok', '$tanggal_exp')";
    $result = mysqli_query($conn, $query);

    if ($result) {
        echo "<script>alert('Produk berhasil ditambahkan'); window.location='produk.php';</script>";
    } else {
        echo "<div class='alert alert-danger'>Gagal menambahkan produk.</div>";
    }
}
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.6.0/css/bootstrap.min.css">

  <!-- Font Awesome 5 -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

  <!-- Custom CSS -->
  <link rel="stylesheet" href="assets/css/bootstrap.min.css">


<div class="container mt-4">
  <h2 class="mb-4">Tambah Produk</h2>

  <form method="POST" action="">
    <div class="form-group">
      <label>Nama Produk</label>
      <input type="text" name="nama_produk" class="form-control" required>
    </div>

    <div class="form-group">
      <label>Kategori</label>
      <select name="id_kategori" class="form-control" required>
        <option value="">-- Pilih Kategori --</option>
        <?php
        $kategori = mysqli_query($conn, "SELECT * FROM kategori");
        while ($k = mysqli_fetch_assoc($kategori)) {
          echo "<option value='" . $k['id_kategori'] . "'>" . htmlspecialchars($k['nama_kategori']) . "</option>";
        }
        ?>
      </select>
    </div>

    <div class="form-group">
      <label>Harga</label>
      <input type="number" name="harga" class="form-control" required>
    </div>

    <div class="form-group">
      <label>Stok</label>
      <input type="number" name="stok" class="form-control" required>
    </div>

    <div class="form-group">
      <label>Tanggal Expired</label>
      <input type="date" name="tanggal_exp" class="form-control" required>
    </div>

    <button type="submit" name="simpan" class="btn btn-success">Simpan</button>
    <a href="produk.php" class="btn btn-secondary">Kembali</a>
  </form>
</div>


 
</div> <!-- penutup sidebar -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

<!-- Bootstrap 4.6 JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.6.0/js/bootstrap.bundle.min.js"></script>

<!-- Custom JS -->
<script src="assets/js/script.js"></script>

