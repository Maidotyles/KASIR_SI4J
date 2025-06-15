<?php
include 'koneksi.php';
include 'partials/header.php';
if (isset($_POST['simpan'])) {
    $nama = htmlspecialchars($_POST['nama_kategori']);
    $query = "INSERT INTO kategori (nama_kategori) VALUES ('$nama')";
    mysqli_query($conn, $query);
    header("Location: kategori.php");
    exit;
}
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.6.0/css/bootstrap.min.css">

  <!-- Font Awesome 5 -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

  <!-- Custom CSS -->
  <link rel="stylesheet" href="assets/css/bootstrap.min.css">
 

<div class="content"><br><br><br>
  <h4>Tambah Kategori</h4>
  <form method="POST">
    <div class="form-group">
      <label>Nama Kategori</label>
      <input type="text" name="nama_kategori" class="form-control" required>
    </div>
    <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
    <a href="kategori.php" class="btn btn-secondary">Kembali</a>
  </form>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

<!-- Bootstrap 4.6 JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.6.0/js/bootstrap.bundle.min.js"></script>

<!-- Custom JS -->
<script src="assets/js/script.js"></script>

