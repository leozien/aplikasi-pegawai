<?php
require_once '../includes/auth_check.php';
require_once '../config/koneksi.php';

$id = isset($_GET['id']) ? filter_var($_GET['id'], FILTER_VALIDATE_INT) : false;

if (!$id) {
    header("Location: ../pegawai.php?pesan=id_tidak_valid");
    exit;
}

try {
    $sql  = "DELETE FROM pegawai WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $id]);

    header("Location: ../pegawai.php?pesan=hapus_sukses");
    exit;
} catch (PDOException $e) {
    header("Location: ../pegawai.php?pesan=hapus_gagal");
    exit;
}
