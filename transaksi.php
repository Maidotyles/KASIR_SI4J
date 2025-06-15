<?php
include 'koneksi.php';
include 'partials/header.php';
?>

<div class="container mt-4">
    <h2>Data Transaksi</h2>
    <a href="tambah_transaksi.php" class="btn btn-success mb-3">
        <i class="fas fa-plus"></i> Tambah Transaksi
    </a>

    <table class="table table-bordered table-hover table-striped">
        <thead class="thead-dark">
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Pelanggan</th>
                <th>Total Harga</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            $query = mysqli_query($conn, "SELECT t.*, p.nama FROM transaksi t LEFT JOIN pelanggan p ON t.id_pelanggan = p.id_pelanggan ORDER BY t.tanggal DESC");
            while ($data = mysqli_fetch_array($query)) {
            ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= date('d-m-Y', strtotime($data['tanggal'])) ?></td>
                    <td><?= $data['nama'] ?></td>
                    <td>Rp<?= number_format($data['total_harga'], 0, ',', '.') ?></td>
                    <td>
                        <a href="detail_transaksi.php?id=<?= $data['id_transaksi'] ?>" class="btn btn-info btn-sm">
                            <i class="fas fa-eye"></i> Detail
                        </a>
                        <a href="hapus_transaksi.php?id=<?= $data['id_transaksi'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin hapus transaksi ini?')">
                            <i class="fas fa-trash"></i> Hapus
                        </a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
