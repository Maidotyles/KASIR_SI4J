<?php
session_start();
include 'koneksi.php';
include 'partials/header.php';


$username = $_SESSION['username'] ?? '';
$user_query = mysqli_query($conn, "SELECT id_user FROM users WHERE username = '$username'");
$user = mysqli_fetch_assoc($user_query);
$id_user = $user['id_user'] ?? 0;

// Query box performa
$jumlah_transaksi = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM transaksi WHERE id_user = $id_user"))['total'];
$total_omzet = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(total_harga) as total FROM transaksi WHERE id_user = $id_user"))['total'] ?? 0;
$total_produk = mysqli_fetch_assoc(mysqli_query($conn, "
    SELECT SUM(dt.jumlah) as total FROM detail_transaksi dt
    JOIN transaksi t ON dt.id_transaksi = t.id_transaksi
    WHERE t.id_user = $id_user
"))['total'] ?? 0;
$resultPelanggan = mysqli_query($conn, "
    SELECT COUNT(DISTINCT id_pelanggan) AS total_pelanggan 
    FROM transaksi 
    WHERE id_user = $id_user AND id_pelanggan IS NOT NULL
");
$pelanggan = mysqli_fetch_assoc($resultPelanggan)['total_pelanggan'] ?? 0;

// Query untuk grafik omzet per bulan
$query_chart = mysqli_query($conn, "
    SELECT DATE_FORMAT(tanggal, '%Y-%m') as bulan, SUM(total_harga) as total
    FROM transaksi
    WHERE id_user = $id_user
    GROUP BY DATE_FORMAT(tanggal, '%Y-%m')
    ORDER BY bulan ASC
");

$bulan = [];
$omzet = [];
while ($row = mysqli_fetch_assoc($query_chart)) {
    $bulan[] = $row['bulan'];
    $omzet[] = $row['total'];
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Performance Saya</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

<div class="container mt-5 pt-5">
  <h3 class="mb-4">📊 Performa Kasir: <?= htmlspecialchars($username) ?></h3>

  <div class="row">
    <div class="col-md-4">
      <div class="card text-white bg-primary mb-2">
        <div class="card-body">
          <h5 class="card-title">Total Transaksi</h5>
          <h3><?= $jumlah_transaksi ?></h3>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card text-white bg-success mb-2">
        <div class="card-body">
          <h5 class="card-title">Total Omzet</h5>
          <h3>Rp <?= number_format($total_omzet, 0, ',', '.') ?></h3>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card text-white bg-warning mb-2">
        <div class="card-body">
          <h5 class="card-title">Produk Terjual</h5>
          <h3><?= $total_produk ?> pcs</h3>
        </div>
      </div>
    </div>
        <div class="col-md-4">
            <div class="card bg-success text-white mb-2">
                <div class="card-body">
                    <h5 class="card-title"><i class="fas fa-users"></i> Pelanggan Terlayani</h5>
                    <h3><?= $pelanggan ?></h3>
                </div>
            </div>
        </div>
    </div>
  <div class="card mt-4">
    <div class="card-header bg-dark text-white">
      Grafik Omzet Bulanan
    </div>
    <div class="card-body">
      <canvas id="chartOmzet" height="100"></canvas>
    </div>
  </div>
</div>

<script>
const ctx = document.getElementById('chartOmzet').getContext('2d');
const chart = new Chart(ctx, {
  type: 'line',
  data: {
    labels: <?= json_encode($bulan) ?>,
    datasets: [{
      label: 'Omzet per Bulan (Rp)',
      data: <?= json_encode($omzet) ?>,
      backgroundColor: 'rgba(0, 123, 255, 0.3)',
      borderColor: 'rgba(0, 123, 255, 1)',
      borderWidth: 2,
      fill: true,
      tension: 0.3,
      pointRadius: 4,
      pointBackgroundColor: '#007bff'
    }]
  },
  options: {
    scales: {
      y: {
        beginAtZero: true,
        ticks: {
          callback: function(value) {
            return 'Rp ' + value.toLocaleString('id-ID');
          }
        }
      }
    }
  }
});
</script>

</body>
</html>
