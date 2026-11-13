<?php
require_once '../includes/auth_check.php';
require_once '../config/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nip        = isset($_POST['nip']) ? trim($_POST['nip']) : '';
    $nama       = isset($_POST['nama']) ? trim($_POST['nama']) : '';
    $email      = isset($_POST['email']) ? trim($_POST['email']) : '';
    $jabatan    = isset($_POST['jabatan']) ? trim($_POST['jabatan']) : '';
    $no_telepon = isset($_POST['no_telepon']) ? trim($_POST['no_telepon']) : '';

    if (empty($nip) || empty($nama) || empty($email) || empty($jabatan) || empty($no_telepon)) {
        header("Location: ../tambah.php?pesan=kosong");
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: ../tambah.php?pesan=email_invalid");
        exit;
    }

    try {
        $cekStmt = $pdo->prepare("SELECT id FROM pegawai WHERE nip = :nip LIMIT 1");
        $cekStmt->execute([':nip' => $nip]);

        if ($cekStmt->rowCount() > 0) {
            header("Location: ../tambah.php?pesan=nip_duplikat");
            exit;
        }

        $sql = "INSERT INTO pegawai (nip, nama, email, jabatan, no_telepon) 
                VALUES (:nip, :nama, :email, :jabatan, :no_telepon)";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':nip'        => $nip,
            ':nama'       => $nama,
            ':email'      => $email,
            ':jabatan'    => $jabatan,
            ':no_telepon' => $no_telepon,
        ]);

        header("Location: ../pegawai.php?pesan=tambah_sukses");
        exit;

    } catch (PDOException $e) {
        header("Location: ../tambah.php?pesan=gagal_database");
        exit;
    }
} else {
    header("Location: ../pegawai.php");
    exit;
}
