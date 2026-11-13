<?php
header('Content-Type: application/json; charset=utf-8');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    http_response_code(401);
    echo json_encode(['error' => 'Silakan login terlebih dahulu.']);
    exit;
}

require_once '../config/koneksi.php';

$keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';

try {
    if ($keyword !== '') {
        $sql = "SELECT id, nip, nama, email, jabatan, no_telepon 
                FROM pegawai 
                WHERE nama LIKE :kw_nama OR nip LIKE :kw_nip 
                ORDER BY id DESC";
        $stmt = $pdo->prepare($sql);
        $searchTerm = "%" . $keyword . "%";
        $stmt->execute([
            ':kw_nama' => $searchTerm,
            ':kw_nip'  => $searchTerm,
        ]);
    } else {
        $sql = "SELECT id, nip, nama, email, jabatan, no_telepon FROM pegawai ORDER BY id DESC";
        $stmt = $pdo->query($sql);
    }

    $pegawaiList = $stmt->fetchAll();
    echo json_encode($pegawaiList);
    exit;
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Gagal mengambil data.']);
    exit;
}
