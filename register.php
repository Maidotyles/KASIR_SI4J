<?php
include 'koneksi.php';

if (isset($_POST['register'])) {
    $username = htmlspecialchars($_POST['username']);
    $password = md5($_POST['password']); // Enkripsi md5
    $konfirmasi = md5($_POST['konfirmasi']);

    // Cek apakah username sudah terdaftar
    $cek = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");
    if (mysqli_num_rows($cek) > 0) {
        echo "<script>alert('Username sudah digunakan!'); window.location='register.php';</script>";
    } elseif ($password !== $konfirmasi) {
        echo "<script>alert('Konfirmasi password tidak cocok!'); window.location='register.php';</script>";
    } else {
        // Simpan user baru ke database
        $query = mysqli_query($conn, "INSERT INTO users (username, password, role) VALUES ('$username', '$password', 'kasir')");

        if ($query) {
            echo "<script>alert('Registrasi berhasil! Silakan login.'); window.location='index.php';</script>";
        } else {
            echo "<script>alert('Registrasi gagal. Coba lagi.');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Register - Aplikasi Kasir Skincare</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow">
                <div class="card-header bg-success text-white text-center">
                    <h4>Daftar Akun Kasir</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="">
                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" name="username" required class="form-control">
                        </div>
                        <div class="form-group mt-3">
                            <label>Password</label>
                            <input type="password" name="password" required class="form-control">
                        </div>
                        <div class="form-group mt-3">
                            <label>Konfirmasi Password</label>
                            <input type="password" name="konfirmasi" required class="form-control">
                        </div>
                        <button type="submit" name="register" class="btn btn-success w-100 mt-4">Daftar</button>
                        <div class="text-center mt-3">
                            Sudah punya akun? <a href="index.php">Login di sini</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="assets/js/bootstrap.min.js"></script>
</body>
</html>
