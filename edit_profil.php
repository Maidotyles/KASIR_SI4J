<?php
session_start();
include 'koneksi.php';
include 'partials/header.php';

$id_user = $_SESSION['id_user'];
$query = mysqli_query($conn, "SELECT * FROM users WHERE id_user = $id_user");
$data = mysqli_fetch_assoc($query);

if (isset($_POST['simpan'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    // Update username
    mysqli_query($conn, "UPDATE users SET username='$username' WHERE id_user=$id_user");

    // Jika password diisi, update juga password (md5)
    if (!empty($password)) {
        $pass_md5 = md5($password);
        mysqli_query($conn, "UPDATE users SET password='$pass_md5' WHERE id_user=$id_user");
    }

    // Proses upload foto jika ada
    if ($_FILES['foto']['name']) {
        $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $ekstensi = strtolower(pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION));

        if (in_array($ekstensi, $allowed)) {
            $namaFile = uniqid('foto_') . "." . $ekstensi;
            $target = "profil/" . $namaFile;

            if (move_uploaded_file($_FILES['foto']['tmp_name'], $target)) {
                // Hapus foto lama
                if (!empty($data['profil']) && file_exists("profil/" . $data['profil'])) {
                    unlink("profil/" . $data['profil']);
                }

                // Simpan nama file ke kolom profil
                mysqli_query($conn, "UPDATE users SET profil='$namaFile' WHERE id_user=$id_user");
            }
        } else {
            echo "<script>alert('Hanya file gambar yang diperbolehkan (jpg, jpeg, png, gif, webp)');</script>";
        }
    }

    echo "<script>alert('Profil berhasil diperbarui!'); window.location='profil.php';</script>";
}
?>

<div class="container mt-4">
    <h3>Edit Profil</h3>
    <div class="card p-4">
        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" value="<?= htmlspecialchars($data['username']) ?>" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Password Baru (biarkan kosong jika tidak diubah)</label>
                <input type="password" name="password" class="form-control" placeholder="Masukkan password baru">
            </div>
            <div class="form-group">
                <label>Foto Profil (jpg, png, gif, webp)</label>
                <input type="file" name="foto" accept="image/*" class="form-control-file">
            </div>
            <button type="submit" name="simpan" class="btn btn-success">Simpan Perubahan</button>
            <a href="profil.php" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
