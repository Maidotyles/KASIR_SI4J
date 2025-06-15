<?php
include 'koneksi.php';
include 'partials/header.php';
?>

<div class="container mt-4">
    <h2>Data Pelanggan</h2>
    <a href="tambah_pelanggan.php" class="btn btn-primary mb-3">+ Tambah Pelanggan</a>
    <table class="table table-bordered table-striped">
        <thead class="thead-dark">
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>No. HP</th>
                <th>Alamat</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            $query = mysqli_query($conn, "SELECT * FROM pelanggan");
            while ($data = mysqli_fetch_assoc($query)) {
                echo "<tr>
                    <td>$no</td>
                    <td>{$data['nama']}</td>
                    <td>{$data['no_hp']}</td>
                    <td>{$data['alamat']}</td>
                    <td>
                        <a href='edit_pelanggan.php?id={$data['id_pelanggan']}' class='btn btn-warning btn-sm'>Edit</a>
                        <a href='hapus_pelanggan.php?id={$data['id_pelanggan']}' onclick='return confirm(\"Yakin hapus data ini?\")' class='btn btn-danger btn-sm'>Hapus</a>
                    </td>
                </tr>";
                $no++;
            }
            ?>
        </tbody>
    </table>
</div>

