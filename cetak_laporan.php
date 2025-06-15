<?php
include 'koneksi.php';

$dari = isset($_POST['dari']) ? $_POST['dari'] : date('Y-m-01');
$sampai = isset($_POST['sampai']) ? $_POST['sampai'] : date('Y-m-d');

$query = "SELECT t.*, p.nama AS nama_pelanggan, u.username 
          FROM transaksi t
          LEFT JOIN pelanggan p ON t.id_pelanggan = p.id_pelanggan
          LEFT JOIN users u ON t.id_user = u.id_user
          WHERE t.tanggal BETWEEN '$dari' AND '$sampai'";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html>
<head>
  <title>Cetak Laporan Transaksi</title>
  <style>
    body { font-family: Arial; }
    table { width: 100%; border-collapse: collapse; margin-top: 20px; }
    th, td { border: 1px solid #333; padding: 8px; text-align: center; }
    th { background-color: #f2f2f2; }
  </style>
</head>
<body onload="window.print()">
  <h2 align="center">Laporan Transaksi</h2>
  <p align="center">Periode: <?= $dari ?> s.d <?= $sampai ?></p>
  <table>
    <thead>
      <tr>
        <th>No</th>
        <th>Tanggal</th>
        <th>Kasir</th>
        <th>Pelanggan</th>
        <th>Total Harga</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $no = 1;
      while($row = mysqli_fetch_assoc($result)) {
      ?>
        <tr>
          <td><?= $no++ ?></td>
          <td><?= $row['tanggal'] ?></td>
          <td><?= $row['username'] ?></td>
          <td><?= $row['nama_pelanggan'] ?></td>
          <td>Rp <?= number_format($row['total_harga'], 0, ',', '.') ?></td>
        </tr>
      <?php } ?>
    </tbody>
  </table>
</body>
</html>
