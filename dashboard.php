<?php
include 'auth.php';
include 'koneksi.php';


// 1. Total Produk
$q_produk = mysqli_query($conn, "SELECT COUNT(*) AS total_produk FROM produk");
$total_produk = mysqli_fetch_assoc($q_produk)['total_produk'];

// 2. Total Stok
$q_stok = mysqli_query($conn, "SELECT SUM(stok) AS total_stok FROM produk");
$total_stok = mysqli_fetch_assoc($q_stok)['total_stok'];

// 3. Uang Masuk Bulan Ini (Omset)
$bulan_ini = date('Y-m');
$q_omset = mysqli_query($conn, "SELECT SUM(total_harga) AS uang_masuk FROM transaksi WHERE DATE_FORMAT(tanggal, '%Y-%m') = '$bulan_ini'");
$uang_masuk = mysqli_fetch_assoc($q_omset)['uang_masuk'] ?? 0;

// 4. Pelanggan Bulan Ini
$q_pelanggan = mysqli_query($conn, "
    SELECT COUNT(DISTINCT id_pelanggan) AS pelanggan_bulan_ini 
    FROM transaksi 
    WHERE DATE_FORMAT(tanggal, '%Y-%m') = '$bulan_ini' 
    AND id_pelanggan IS NOT NULL AND id_pelanggan != 0
");
$pelanggan_bulan_ini = mysqli_fetch_assoc($q_pelanggan)['pelanggan_bulan_ini'] ?? 0;

// 5. Grafik Omset
$query_chart = mysqli_query($conn, "
  SELECT DATE_FORMAT(tanggal, '%M %Y') AS bulan, SUM(total_harga) AS total 
  FROM transaksi 
  WHERE tanggal >= DATE_SUB(CURDATE(), INTERVAL 6 MONTH)
  GROUP BY DATE_FORMAT(tanggal, '%Y-%m')
  ORDER BY DATE_FORMAT(tanggal, '%Y-%m') ASC
");

$labels = [];
$data = [];
while ($row = mysqli_fetch_assoc($query_chart)) {
    $labels[] = $row['bulan'];
    $data[] = $row['total'];
}
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.6.0/css/bootstrap.min.css">

  <!-- Font Awesome 5 -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

  <!-- Custom CSS -->
  <link rel="stylesheet" href="assets/css/bootstrap.min.css">
<?php 
include 'partials/header.php';


?>
<div class="container mt-4">
    <h2 class="mb-4">Dashboard</h2>
    <div class="row">
        <div class="col-md-3 mb-3">
            <div class="card bg-primary text-white shadow">
                <div class="card-body">
                    <h5>Total Produk</h5>
                    <h3><?= $total_produk ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card bg-success text-white shadow">
                <div class="card-body">
                    <h5>Total Stok</h5>
                    <h3><?= $total_stok ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card bg-warning text-white shadow">
                <div class="card-body">
                    <h5>Omset Bulan Ini</h5>
                    <h3>Rp <?= number_format($uang_masuk, 0, ',', '.') ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card bg-danger text-white shadow">
                <div class="card-body">
                    <h5>Pelanggan Bulan Ini</h5>
                    <h3><?= $pelanggan_bulan_ini ?></h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Grafik -->
    <div class="card mt-4">
        <div class="card-header bg-info text-white">
            Grafik Omset 6 Bulan Terakhir
        </div>
        <div class="card-body">
            <canvas id="grafikOmset" height="100"></canvas>
        </div>
    </div>

    <!-- Produk Kedaluwarsa -->
    <div class="card mt-4">
        <div class="card-header bg-secondary text-white">
            Produk Kedaluwarsa
        </div>
        <div class="card-body table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Nama Produk</th>
                        <th>Kategori</th>
                        <th>Stok</th>
                        <th>Harga</th>
                        <th>Tanggal Exp</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $today = date('Y-m-d');
                    $q_expired = mysqli_query($conn, "
                        SELECT p.*, k.nama_kategori 
                        FROM produk p 
                        JOIN kategori k ON p.id_kategori = k.id_kategori 
                        WHERE tanggal_exp < '$today'
                        ORDER BY tanggal_exp ASC
                    ");
                    if (mysqli_num_rows($q_expired) > 0):
                        while ($row = mysqli_fetch_assoc($q_expired)):
                    ?>
                        <tr>
                            <td><?= $row['nama_produk'] ?></td>
                            <td><?= $row['nama_kategori'] ?></td>
                            <td><?= $row['stok'] ?></td>
                            <td>Rp <?= number_format($row['harga'], 0, ',', '.') ?></td>
                            <td class="text-danger"><?= $row['tanggal_exp'] ?></td>
                        </tr>
                    <?php
                        endwhile;
                    else:
                        echo '<tr><td colspan="5" class="text-center text-muted">Tidak ada produk yang kedaluwarsa.</td></tr>';
                    endif;
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('grafikOmset').getContext('2d');
    const chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?= json_encode($labels) ?>,
            datasets: [{
                label: 'Total Omset',
                data: <?= json_encode($data) ?>,
                backgroundColor: 'rgba(54, 162, 235, 0.7)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + value.toLocaleString();
                        }
                    }
                }
            }
        }
    });
</script>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

<!-- Bootstrap 4.6 JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.6.0/js/bootstrap.bundle.min.js"></script>

<!-- Custom JS -->
<script src="assets/js/script.js"></script>