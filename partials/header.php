<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Kasir Skincare</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.6.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <style>
    body { padding-top: 56px; }
    .sidebar { width: 220px; position: fixed; top: 56px; bottom: 0; overflow-y: auto; }
    .main { margin-left: 220px; padding: 20px; }
    .sidebar .nav-link.active { background: #495057; color: #fff; }
  </style>
</head>
<body>
<?php include 'partials/navbar.php'; ?><!-- Modal Logout -->
<div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-warning text-dark">
        <h5 class="modal-title" id="logoutModalLabel"><i class="fas fa-sign-out-alt"></i> Konfirmasi Logout</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Apakah Anda yakin ingin logout?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        <a href="logout.php" class="btn btn-danger">Ya, Logout</a>
      </div>
    </div>
  </div>
</div>

<!-- Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.6.2/js/bootstrap.bundle.min.js"></script>



<div class="d-flex">
  <?php include 'partials/sidebar.php'; ?>
  <div class="main flex-fill">
