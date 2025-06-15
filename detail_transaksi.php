<?php
include 'auth.php';
include 'koneksi.php';
include 'partials/header.php';

if (!isset($_GET['id'])) {
    echo "<script>alert('ID transaksi tidak ditemukan'); location.href='transaksi.php';</script>";
    exit;
}

$id = $_GET['id'];

// Ambil data transaksi utama
$transaksi = mysqli_query($conn, "
    SELECT t.*, u.username, p.nama 
    FROM transaksi t
    JOIN users u ON t.id_user = u.id_user
    LEFT JOIN pelanggan p ON t.id_pelanggan = p.id_pelanggan
    WHERE t.id_transaksi = '$id'
");
$data = mysqli_fetch_assoc($transaksi);

// Ambil detail produk yang dibeli
$detail = mysqli_query($conn, "
    SELECT dt.*, pr.nama_produk 
    FROM detail_transaksi dt
    JOIN produk pr ON dt.id_produk = pr.id_produk
    WHERE dt.id_transaksi = '$id'
");
?>

<div class="main">
    <h3>Detail Transaksi</h3>
    <table class="table table-bordered">
        <tr>
            <th>ID Transaksi</th>
            <td><?= $data['id_transaksi'] ?></td>
        </tr>
        <tr>
            <th>Tanggal</th>
            <td><?= $data['tanggal'] ?></td>
        </tr>
        <tr>
            <th>Pelanggan</th>
            <td><?= $data['nama'] ?? '-' ?></td>
        </tr>
        <tr>
            <th>Kasir</th>
            <td><?= $data['username'] ?></td>
        </tr>
        <tr>
            <th>Total Harga</th>
            <td>Rp <?= number_format($data['total_harga'], 0, ',', '.') ?></td>
        </tr>
    </table>

    <h5>Rincian Produk</h5>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Produk</th>
                <th>Harga Satuan</th>
                <th>Jumlah</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            $grand_total = 0;
            while ($d = mysqli_fetch_assoc($detail)) :
                $subtotal = $d['jumlah'] * $d['harga'];
                $grand_total += $subtotal;
            ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $d['nama_produk'] ?></td>
                    <td>Rp <?= number_format($d['harga'], 0, ',', '.') ?></td>
                    <td><?= $d['jumlah'] ?></td>
                    <td>Rp <?= number_format($subtotal, 0, ',', '.') ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="4">Grand Total</th>
                <th>Rp <?= number_format($grand_total, 0, ',', '.') ?></th>
            </tr>
        </tfoot>
    </table>

    <a href="transaksi.php" class="btn btn-secondary">Kembali</a>
</div>

