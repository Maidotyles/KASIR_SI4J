<?php
$current = basename($_SERVER['PHP_SELF']);
?>

<div class="sidebar bg-dark">
  <ul class="nav flex-column mt-5">
    <li class="nav-item">
      <a class="nav-link <?= $current=='dashboard.php'?'active':'' ?>" href="dashboard.php">
        <i class="fas fa-tachometer-alt"></i> Dashboard
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link <?= $current=='produk.php'?'active':'' ?>" href="produk.php">
        <i class="fas fa-box-open"></i> Produk
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link <?= $current=='kategori.php'?'active':'' ?>" href="kategori.php">
        <i class="fas fa-tags"></i> Kategori
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link <?= $current=='pelanggan.php'?'active':'' ?>" href="pelanggan.php">
        <i class="fas fa-users"></i> Pelanggan
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link <?= $current=='transaksi.php'?'active':'' ?>" href="transaksi.php">
        <i class="fas fa-receipt"></i> Transaksi
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link <?= $current=='laporan.php'?'active':'' ?>" href="laporan.php">
        <i class="fas fa-file-alt"></i> Laporan
      </a>
    </li>
    <li class="nav-item mt-auto">
      <li class="nav-item">
  <a class="nav-link text-danger" href="logout.php" onclick="return confirm('Yakin ingin logout?')">
    <i class="fas fa-sign-out-alt"></i> Logout
  </a>
</li>

      </a>
    </li>
  </ul>
</div>
