<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = isset($_POST['username']) ? trim($_POST['username']) : '';
    $password = isset($_POST['password']) ? trim($_POST['password']) : '';

    $defaultUser = 'admin';
    $defaultPass = 'admin123';

    if (empty($username) || empty($password)) {
        header("Location: ../index.php?pesan=kosong");
        exit;
    }

    if ($username === $defaultUser && $password === $defaultPass) {
        session_regenerate_id(true);

        $_SESSION['login']        = true;
        $_SESSION['username']     = $username;
        $_SESSION['nama_lengkap'] = 'Administrator';

        header("Location: ../dashboard.php");
        exit;
    } else {
        header("Location: ../index.php?pesan=gagal");
        exit;
    }
} else {
    header("Location: ../index.php");
    exit;
}
