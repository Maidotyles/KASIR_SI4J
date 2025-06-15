<?php
include 'auth.php';
include 'koneksi.php';
include 'partials/header.php';

// Ambil data pelanggan dan produk
$pelanggan = mysqli_query($conn, "SELECT * FROM pelanggan");
$produk = mysqli_query($conn, "SELECT * FROM produk");

if (isset($_POST['submit'])) {
    $tanggal = date('Y-m-d');
    $id_user = $_SESSION['id_user'];
    $id_pelanggan = $_POST['id_pelanggan'];
    $produk_ids = $_POST['id_produk'];
    $jumlahs = $_POST['jumlah'];

    $total_harga = 0;
    $harga_produk = [];

    // Hitung total dan siapkan harga produk
    foreach ($produk_ids as $i => $id_produk) {
        $jumlah = $jumlahs[$i];
        $q = mysqli_query($conn, "SELECT harga FROM produk WHERE id_produk = '$id_produk'");
        $row = mysqli_fetch_assoc($q);
        $harga = $row['harga'];
        $harga_produk[$id_produk] = $harga;
        $total_harga += ($jumlah * $harga);
    }

    // Simpan ke tabel transaksi
    mysqli_query($conn, "INSERT INTO transaksi (tanggal, id_user, id_pelanggan, total_harga) 
        VALUES ('$tanggal', '$id_user', '$id_pelanggan', '$total_harga')");
    $id_transaksi = mysqli_insert_id($conn);

    // Simpan detail transaksi
    foreach ($produk_ids as $i => $id_produk) {
        $jumlah = $jumlahs[$i];
        $harga = $harga_produk[$id_produk];
        mysqli_query($conn, "INSERT INTO detail_transaksi (id_transaksi, id_produk, jumlah, harga) 
            VALUES ('$id_transaksi', '$id_produk', '$jumlah', '$harga')");

        // Kurangi stok produk
        mysqli_query($conn, "UPDATE produk SET stok = stok - $jumlah WHERE id_produk = '$id_produk'");
    }

    echo "<script>alert('Transaksi berhasil ditambahkan!'); location.href='transaksi.php';</script>";
}
?>

<div class="main">
    <h3>Tambah Transaksi</h3>
    <form method="post">
        <div class="form-group">
            <label>Pelanggan</label>
            <select name="id_pelanggan" class="form-control" required>
                <option value="">- Pilih Pelanggan -</option>
                <?php while($p = mysqli_fetch_assoc($pelanggan)) : ?>
                    <option value="<?= $p['id_pelanggan'] ?>"><?= $p['nama'] ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <hr>
        <h5>Produk yang Dibeli</h5>
        <div id="produk-container">
            <div class="produk-item row mb-2">
                <div class="col-md-6">
                    <select name="id_produk[]" class="form-control" required>
                        <option value="">- Pilih Produk -</option>
                        <?php
                        mysqli_data_seek($produk, 0); // reset pointer
                        while($prod = mysqli_fetch_assoc($produk)) : ?>
                            <option value="<?= $prod['id_produk'] ?>">
                                <?= $prod['nama_produk'] ?> (Stok: <?= $prod['stok'] ?>)
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <input type="number" name="jumlah[]" class="form-control" placeholder="Jumlah" min="1" required>
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-danger remove-produk">&times;</button>
                </div>
            </div>
        </div>
        <button type="button" id="tambah-produk" class="btn btn-sm btn-info mb-3">+ Tambah Produk</button>
        <br>
        <button type="submit" name="submit" class="btn btn-primary">Simpan Transaksi</button>
    </form>
</div>

<script>
document.getElementById('tambah-produk').addEventListener('click', function() {
    const container = document.getElementById('produk-container');
    const item = container.querySelector('.produk-item');
    const clone = item.cloneNode(true);
    clone.querySelector('select').value = '';
    clone.querySelector('input').value = '';
    container.appendChild(clone);
});

document.addEventListener('click', function(e) {
    if (e.target.classList.contains('remove-produk')) {
        const items = document.querySelectorAll('.produk-item');
        if (items.length > 1) e.target.closest('.produk-item').remove();
    }
});
</script>

