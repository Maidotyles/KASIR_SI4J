<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.6.0/css/bootstrap.min.css">

  <!-- Font Awesome 5 -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

  <!-- Custom CSS -->
  <link rel="stylesheet" href="assets/css/bootstrap.min.css">
  <?php
include 'koneksi.php';
include 'partials/header.php';

// Ambil ID produk dari URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "<script>alert('ID produk tidak ditemukan'); window.location='produk.php';</script>";
    exit;
}

$id_produk = $_GET['id'];

// Ambil data produk berdasarkan ID
$query = mysqli_query($conn, "SELECT * FROM produk WHERE id_produk = '$id_produk'");
$produk = mysqli_fetch_assoc($query);

if (!$produk) {
    echo "<script>alert('Produk tidak ditemukan'); window.location='produk.php';</script>";
    exit;
}

// Proses update data
if (isset($_POST['update'])) {
    $nama_produk = $_POST['nama_produk'];
    $id_kategori = $_POST['id_kategori'];
    $harga       = $_POST['harga'];
    $stok        = $_POST['stok'];
    $tanggal_exp = $_POST['tanggal_exp'];

    $update = mysqli_query($conn, "UPDATE produk SET 
        nama_produk = '$nama_produk',
        id_kategori = '$id_kategori',
        harga = '$harga',
        stok = '$stok',
        tanggal_exp = '$tanggal_exp'
        WHERE id_produk = '$id_produk'
    ");

    if ($update) {
        echo "<script>alert('Produk berhasil diperbarui'); window.location='produk.php';</script>";
    } else {
        echo "<div class='alert alert-danger'>Gagal memperbarui produk.</div>";
    }
}
?>

<div class="container mt-4">
  <h2 class="mb-4">Edit Produk</h2>

  <form method="POST">
    <div class="form-group">
      <label>Nama Produk</label>
      <input type="text" name="nama_produk" class="form-control" value="<?= htmlspecialchars($produk['nama_produk']) ?>" required>
    </div>

    <div class="form-group">
      <label>Kategori</label>
      <select name="id_kategori" class="form-control" required>
        <?php
        $kategori = mysqli_query($conn, "SELECT * FROM kategori");
        while ($k = mysqli_fetch_assoc($kategori)) {
          $selected = ($k['id_kategori'] == $produk['id_kategori']) ? 'selected' : '';
          echo "<option value='" . $k['id_kategori'] . "' $selected>" . htmlspecialchars($k['nama_kategori']) . "</option>";
        }
        ?>
      </select>
    </div>

    <div class="form-group">
      <label>Harga</label>
      <input type="number" name="harga" class="form-control" value="<?= $produk['harga'] ?>" required>
    </div>

    <div class="form-group">
      <label>Stok</label>
      <input type="number" name="stok" class="form-control" value="<?= $produk['stok'] ?>" required>
    </div>

    <div class="form-group">
      <label>Tanggal Expired</label>
      <input type="date" name="tanggal_exp" class="form-control" value="<?= $produk['tanggal_exp'] ?>" required>
    </div>

    <button type="submit" name="update" class="btn btn-primary">Update</button>
    <a href="produk.php" class="btn btn-secondary">Kembali</a>
  </form>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.6.0/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/script.js"></script>