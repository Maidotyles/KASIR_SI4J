<?php
session_start();
include 'koneksi.php';
include 'partials/header.php';

$id_user = $_SESSION['id_user']; // user yang sedang login

$query = mysqli_query($conn, "SELECT * FROM users WHERE id_user != $id_user");
?>

<div class="container mt-5">
    <h3 class="mb-4">Daftar Kasir Lainnya</h3>
    <div class="row">
        <?php while ($row = mysqli_fetch_assoc($query)) : 
            $foto = 'profil/default.png';
            if (!empty($row['profil']) && file_exists('profil/' . $row['profil'])) {
                $foto = 'profil/' . $row['profil'];
            }
        ?>
        <div class="col-md-4 mb-4">
            <div class="card shadow">
                <div class="card-body text-center">
                    <img src="<?= $foto ?>" class="rounded-circle mb-2" width="80" height="80" alt="Foto Profil">
                    <h5><?= htmlspecialchars($row['username']) ?></h5>
                    <p class="text-muted"><?= ucfirst($row['role']) ?></p>
                    <!-- Optional: tombol lihat detail -->
                    <a href="lihat_kasir.php?id=<?= $row['id_user'] ?>" class="btn btn-outline-primary btn-sm">Lihat Profil</a>
                </div>
            </div>
        </div>
        <?php endwhile; ?>
    </div>
</div>
