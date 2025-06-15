<?php
include 'auth.php';
include 'koneksi.php';
include 'partials/header.php';


$filter = isset($_GET['tanggal']) ? $_GET['tanggal'] : date('Y-m-d');

$query = mysqli_query($conn, "
    SELECT t.id_transaksi, t.tanggal, p.nama, t.total_harga
    FROM transaksi t
    LEFT JOIN pelanggan p ON t.id_pelanggan = p.id_pelanggan
    WHERE t.tanggal = '$filter'
    ORDER BY t.tanggal DESC
");
?>

<div class="main p-4">
    <h4>Laporan Penjualan</h4>
    <form method="GET" class="mb-3">
        <div class="form-group">
            <label for="tanggal">Filter Tanggal:</label>
            <input type="date" name="tanggal" id="tanggal" value="<?= $filter ?>" class="form-control" style="width: 250px;">
        </div>
        <a href="cetak_laporan.php?dari=<?= $dari ?>&sampai=<?= $sampai ?>" target="_blank" class="btn btn-danger mb-3">
    <i class="fas fa-file-pdf"></i> Cetak PDF
</a>

    </form>

    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Pelanggan</th>
                <th>Total (Rp)</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1; $grand_total = 0;
            while ($row = mysqli_fetch_assoc($query)) :
                $grand_total += $row['total_harga'];
            ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $row['tanggal'] ?></td>
                    <td><?= $row['nama'] ?: 'Umum' ?></td>
                    <td><?= number_format($row['total_harga'], 0, ',', '.') ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="3" class="text-right">Total Omset</th>
                <th>Rp <?= number_format($grand_total, 0, ',', '.') ?></th>
            </tr>
        </tfoot>
    </table>
</div>
