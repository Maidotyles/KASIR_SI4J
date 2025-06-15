<?php
session_start();
include 'koneksi.php';
include 'partials/header.php';

if (!isset($_GET['id'])) {
    echo "<script>alert('ID kasir tidak ditemukan!'); window.location='dashboard.php';</script>";
    exit;
}

$id_kasir = intval($_GET['id']);
$query = mysqli_query($conn, "SELECT * FROM users WHERE id_user = $id_kasir");
if (mysqli_num_rows($query) == 0) {
    echo "<script>alert('Kasir tidak ditemukan!'); window.location='dashboard.php';</script>";
    exit;
}

$data = mysqli_fetch_assoc($query);
$foto = (!empty($data['profil']) && file_exists('profil/' . $data['profil'])) ? 'profil/' . $data['profil'] : 'profil/default.png';

// Total transaksi
$total_transaksi = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM transaksi WHERE id_user = $id_kasir"))['total'];

// Total omset
$total_omset = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(total_harga) AS total FROM transaksi WHERE id_user = $id_kasir"))['total'] ?? 0;

// Rata-rata
$rata_penjualan = ($total_transaksi > 0) ? round($total_omset / $total_transaksi) : 0;

// Produk terjual
$produk_terjual = mysqli_fetch_assoc(mysqli_query($conn, "
    SELECT SUM(dt.jumlah) AS total 
    FROM detail_transaksi dt 
    JOIN transaksi t ON dt.id_transaksi = t.id_transaksi 
    WHERE t.id_user = $id_kasir
"))['total'] ?? 0;

// Data chart
$chart_data = mysqli_query($conn, "
    SELECT DATE(tanggal) AS tanggal, SUM(total_harga) AS omset 
    FROM transaksi 
    WHERE id_user = $id_kasir 
    GROUP BY DATE(tanggal) 
    ORDER BY tanggal ASC
");

$labels = [];
$data_chart = [];
while ($row = mysqli_fetch_assoc($chart_data)) {
    $labels[] = $row['tanggal'];
    $data_chart[] = $row['omset'];
}
?>

<div class="container mt-5">
    <div class="row mb-4">
        <div class="col-md-4 text-center">
            <img src="<?= $foto ?>" class="rounded-circle mb-2" width="140" height="140" alt="Foto Kasir">
            <h4><?= htmlspecialchars($data['username']) ?></h4>
            <p class="text-muted">Role: <?= htmlspecialchars($data['role']) ?></p>
        </div>
        <div class="col-md-8">
            <div class="row text-white">
                <div class="col-md-6 mb-3">
                    <div class="card bg-primary shadow">
                        <div class="card-body">
                            <h6>Total Transaksi</h6>
                            <h4><?= $total_transaksi ?></h4>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="card bg-success shadow">
                        <div class="card-body">
                            <h6>Total Omset</h6>
                            <h4>Rp<?= number_format($total_omset, 0, ',', '.') ?></h4>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="card bg-warning shadow">
                        <div class="card-body">
                            <h6>Rata-rata Penjualan</h6>
                            <h4>Rp<?= number_format($rata_penjualan, 0, ',', '.') ?></h4>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="card bg-danger shadow">
                        <div class="card-body">
                            <h6>Produk Terjual</h6>
                            <h4><?= $produk_terjual ?></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header bg-info text-white">
            <h5 class="m-0">Grafik Omset Harian</h5>
        </div>
        <div class="card-body">
            <canvas id="grafikOmset"></canvas>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('grafikOmset').getContext('2d');
    const chart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: <?= json_encode($labels) ?>,
            datasets: [{
                label: 'Omset Harian',
                data: <?= json_encode($data_chart) ?>,
                backgroundColor: 'rgba(78, 115, 223, 0.2)',
                borderColor: 'rgba(78, 115, 223, 1)',
                borderWidth: 2,
                fill: true
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>

