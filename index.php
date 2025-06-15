<?php
session_start();
include 'koneksi.php';

// Jika form login disubmit
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = md5($_POST['password']); // cocokkan dengan md5 di database

    $query = mysqli_query($conn, "SELECT * FROM users WHERE username='$username' AND password='$password'");
    $data = mysqli_fetch_assoc($query);

    if ($data) {
        // Set session
        $_SESSION['id_user'] = $data['id_user'];
        $_SESSION['username'] = $data['username'];
        $_SESSION['role'] = $data['role'];

        // Redirect berdasarkan role
        if ($data['role'] == 'admin') {
            header("Location: dashboard.php");
        } else {
            header("Location: dashboard.php");
        }
        exit;
    } else {
        echo "<script>alert('Login gagal! Username atau password salah.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login - Aplikasi Kasir Skincare</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white text-center">
                    <h4>Login Kasir Skincare</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="">
                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" name="username" class="form-control" required autofocus>
                        </div>
                        <div class="form-group mt-3">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <button type="submit" name="login" class="btn btn-primary w-100 mt-4">Login</button>
                        <div class="text-center mt-3">
                            Belum punya akun? <a href="register.php">Daftar di sini</a>
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
