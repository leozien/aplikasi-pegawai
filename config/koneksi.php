<?php
$host = "127.0.0.1";
$port = "3306";
$user = "root";
$pass = "";
$db   = "db_pegawai";

try {
    $dsn = "mysql:host=$host;port=$port;dbname=$db;charset=utf8";
    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ]);
} catch (PDOException $e) {
    $socketXampp = "/Applications/XAMPP/xamppfiles/var/mysql/mysql.sock";
    if (file_exists($socketXampp)) {
        try {
            $dsnSocket = "mysql:unix_socket=$socketXampp;dbname=$db;charset=utf8";
            $pdo = new PDO($dsnSocket, $user, $pass, [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ]);
        } catch (PDOException $ex) {
            die("Koneksi database gagal: " . $ex->getMessage());
        }
    } else {
        die("Koneksi database gagal: " . $e->getMessage());
    }
}
