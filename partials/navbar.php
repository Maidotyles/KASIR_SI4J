<?php
if (session_status() == PHP_SESSION_NONE) session_start();
include 'koneksi.php';

// Ambil data user dari session dan database
$id_user = $_SESSION['id_user'] ?? null;
$user = 'User';
$foto = 'profil/default.png';

if ($id_user) {
    $query = mysqli_query($conn, "SELECT * FROM users WHERE id_user = $id_user");
    if ($row = mysqli_fetch_assoc($query)) {
        $user = $row['username'];
        if (!empty($row['profil']) && file_exists("profil/" . $row['profil'])) {
            $foto = "profil/" . $row['profil'];
        }
    }
}
?>

<!-- CSS dan Bootstrap -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<link rel="stylesheet" href="assets/css/bootstrap.min.css">

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
  <a class="navbar-brand ml-3" href="dashboard.php"><i class="fas fa-store"></i> Kasir Skincare</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse justify-content-end mr-3" id="navbarNav">
    <ul class="navbar-nav">
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <img src="<?= $foto ?>" width="40" height="40" class="rounded-circle mr-2" alt="User">
          <span><?= htmlspecialchars($user) ?></span>
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="profil.php"><i class="fas fa-user mr-2"></i>Profil</a>
          <a class="dropdown-item" href="performance.php"><i class="fas fa-chart-line mr-2"></i>Performance</a>
          <a class="dropdown-item" href="daftar_kasir.php"><i class="fas fa-users mr-2"></i>Kasir Lain</a>

          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item text-danger" data-toggle="modal" data-target="#logoutModal">
            <i class="fas fa-sign-out-alt mr-2"></i> Logout
          </a>
        </div>
      </li>
    </ul>
  </div>
</nav>

<!-- Logout Modal -->
<div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title" id="logoutModalLabel">Konfirmasi Logout</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Tutup">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Apakah Anda yakin ingin logout?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        <a href="logout.php" class="btn btn-danger">Logout</a>
      </div>
    </div>
  </div>
</div>

<!-- Script JS Bootstrap -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js" integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+" crossorigin="anonymous"></script>
