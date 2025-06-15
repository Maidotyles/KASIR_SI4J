<?php
include 'koneksi.php';

// Pastikan ID kategori dikirim melalui URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
  echo "<script>alert('ID kategori tidak ditemukan!'); window.location='kategori.php';</script>";
  exit;
}

$id = intval($_GET['id']);
$query = mysqli_query($conn, "SELECT * FROM kategori WHERE id_kategori = $id");
$data = mysqli_fetch_assoc($query);

// Jika kategori tidak ditemukan
if (!$data) {
  echo "<script>alert('Data kategori tidak ditemukan!'); window.location='kategori.php';</script>";
  exit;
}

// Proses update saat form disubmit
if (isset($_POST['update'])) {
  $nama_kategori = mysqli_real_escape_string($conn, $_POST['nama_kategori']);

  $update = mysqli_query($conn, "UPDATE kategori SET nama_kategori = '$nama_kategori' WHERE id_kategori = $id");

  if ($update) {
    echo "<script>alert('Data berhasil diperbarui!'); window.location='kategori.php';</script>";
  } else {
    echo "<script>alert('Gagal memperbarui data!');</script>";
  }
}
?>

<?php include 'partials/header.php'; ?>
<?php include 'partials/navbar.php'; ?>

<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card shadow">
        <div class="card-header bg-warning text-white">
          <h5 class="mb-0">Edit Kategori</h5>
        </div>
        <div class="card-body">
          <form method="POST">
            <div class="form-group">
              <label for="nama_kategori">Nama Kategori</label>
              <input type="text" name="nama_kategori" id="nama_kategori" class="form-control" value="<?= htmlspecialchars($data['nama_kategori']); ?>" required>
            </div>
            <div class="mt-4">
              <button type="submit" name="update" class="btn btn-primary">Simpan Perubahan</button>
              <a href="kategori.php" class="btn btn-secondary">Kembali</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

