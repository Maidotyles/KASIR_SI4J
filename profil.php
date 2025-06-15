<?php
session_start();
include 'koneksi.php';
include 'partials/header.php';


$id_user = $_SESSION['id_user'];
$query = mysqli_query($conn, "SELECT * FROM users WHERE id_user = $id_user");
$data = mysqli_fetch_assoc($query);
$foto = 'profil/default.png';
if (!empty($data['profil']) && file_exists('profil/' . $data['profil'])) {
    $foto = 'profil/' . $data['profil'];
}
?>

<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card shadow-lg border-0 rounded-lg">
        <div class="card-header bg-primary text-white text-center">
          <h4 class="m-0">Profil Pengguna</h4>
        </div>
        <div class="card-body text-center">
          <img src="<?= $foto ?>" class="rounded-circle mb-3" width="120" height="120" alt="Foto Profil">
          <h5><?= htmlspecialchars($data['username']) ?></h5>
          <p class="text-muted"><?= ucfirst($data['role']) ?></p>

          <table class="table table-borderless mt-4">
            <tr>
              <th scope="row" class="text-left">ID User</th>
              <td class="text-left"><?= $data['id_user'] ?></td>
            </tr>
            <tr>
              <th scope="row" class="text-left">Username</th>
              <td class="text-left"><?= htmlspecialchars($data['username']) ?></td>
            </tr>
            <tr>
              <th scope="row" class="text-left">Role</th>
              <td class="text-left"><?= htmlspecialchars($data['role']) ?></td>
            </tr>
          </table>

          <a href="edit_profil.php?id=<?= $id_user ?>" class="btn btn-outline-primary mt-3">
            <i class="fas fa-edit"></i> Edit Profil
          </a>
        </div>
      </div>
    </div>
  </div>
</div>
