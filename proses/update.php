<?php
require_once '../includes/auth_check.php';
require_once '../config/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id         = isset($_POST['id']) ? filter_var($_POST['id'], FILTER_VALIDATE_INT) : false;
    $nip        = isset($_POST['nip']) ? trim($_POST['nip']) : '';
    $nama       = isset($_POST['nama']) ? trim($_POST['nama']) : '';
    $email      = isset($_POST['email']) ? trim($_POST['email']) : '';
    $jabatan    = isset($_POST['jabatan']) ? trim($_POST['jabatan']) : '';
    $no_telepon = isset($_POST['no_telepon']) ? trim($_POST['no_telepon']) : '';

    if (!$id) {
        header("Location: ../pegawai.php?pesan=id_tidak_valid");
        exit;
    }

    if (empty($nip) || empty($nama) || empty($email) || empty($jabatan) || empty($no_telepon)) {
        header("Location: ../edit.php?id=$id&pesan=kosong");
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: ../edit.php?id=$id&pesan=email_invalid");
        exit;
    }

    try {
        $cekStmt = $pdo->prepare("SELECT id FROM pegawai WHERE nip = :nip AND id != :id LIMIT 1");
        $cekStmt->execute([':nip' => $nip, ':id' => $id]);

        if ($cekStmt->rowCount() > 0) {
            header("Location: ../edit.php?id=$id&pesan=nip_duplikat");
            exit;
        }

        $sql = "UPDATE pegawai 
                SET nip = :nip, nama = :nama, email = :email, jabatan = :jabatan, no_telepon = :no_telepon 
                WHERE id = :id";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':nip'        => $nip,
            ':nama'       => $nama,
            ':email'      => $email,
            ':jabatan'    => $jabatan,
            ':no_telepon' => $no_telepon,
            ':id'         => $id,
        ]);

        header("Location: ../pegawai.php?pesan=edit_sukses");
        exit;

    } catch (PDOException $e) {
        header("Location: ../edit.php?id=$id&pesan=gagal_database");
        exit;
    }
} else {
    header("Location: ../pegawai.php");
    exit;
}
