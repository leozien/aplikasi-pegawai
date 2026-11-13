<?php
require_once 'includes/auth_check.php';
require_once 'config/koneksi.php';

try {
    $totalQuery = $pdo->query("SELECT COUNT(*) AS total FROM pegawai");
    $totalPegawai = $totalQuery->fetch()['total'];

    $jabatanQuery = $pdo->query("SELECT COUNT(DISTINCT jabatan) AS total_jabatan FROM pegawai");
    $totalJabatan = $jabatanQuery->fetch()['total_jabatan'];

    $recentStmt = $pdo->query("SELECT id, nip, nama, email, jabatan, no_telepon FROM pegawai ORDER BY id DESC LIMIT 5");
    $recentPegawai = $recentStmt->fetchAll();
} catch (PDOException $e) {
    $totalPegawai = 0;
    $totalJabatan = 0;
    $recentPegawai = [];
    $errorDb = $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard — Manajemen Pegawai</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<?php include 'includes/navbar.php'; ?>

<main class="py-4">
    <div class="container">
        <div class="card bg-white border mb-4">
            <div class="card-body p-4">
                <div class="row align-items-center g-3">
                    <div class="col-auto">
                        <img src="assets/img/logo.svg" alt="Logo" width="64" height="64" class="img-fluid rounded border p-1 bg-light">
                    </div>
                    <div class="col">
                        <div class="badge bg-light text-dark border mb-2 px-3 py-1 rounded-pill fw-normal">
                            <i class="bi bi-person-check me-1"></i> Masuk sebagai: <?= htmlspecialchars($_SESSION['username']) ?>
                        </div>
                        <h2 class="fw-bold text-dark mb-1">Selamat Datang di Manajemen Pegawai!</h2>
                        <p class="text-muted mb-0">Kelola dan pantau data pegawai dengan rapi dan mudah.</p>
                    </div>
                    <div class="col-12 col-lg-auto d-flex flex-wrap gap-2 mt-3 mt-lg-0">
                        <a href="tambah.php" class="btn btn-dark">
                            <i class="bi bi-plus-lg"></i> Tambah Pegawai
                        </a>
                        <a href="pegawai.php" class="btn btn-outline-dark">
                            <i class="bi bi-table"></i> Data Pegawai
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <?php if (isset($errorDb)): ?>
            <div class="alert alert-danger" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                Koneksi database bermasalah: <?= htmlspecialchars($errorDb) ?>
            </div>
        <?php endif; ?>

        <div class="row g-3 mb-4">
            <div class="col-sm-6 col-lg-4">
                <div class="card h-100 border-start border-4 border-dark">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div>
                            <div class="text-muted small text-uppercase fw-semibold mb-1">Total Pegawai</div>
                            <div class="fs-2 fw-bold text-dark"><?= number_format($totalPegawai, 0, ',', '.') ?></div>
                            <div class="small text-muted">Pegawai terdaftar</div>
                        </div>
                        <div class="rounded-circle bg-light border p-3 text-dark fs-3">
                            <i class="bi bi-people"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-lg-4">
                <div class="card h-100 border-start border-4 border-dark">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div>
                            <div class="text-muted small text-uppercase fw-semibold mb-1">Ragam Jabatan</div>
                            <div class="fs-2 fw-bold text-dark"><?= number_format($totalJabatan, 0, ',', '.') ?></div>
                            <div class="small text-muted">Posisi / divisi</div>
                        </div>
                        <div class="rounded-circle bg-light border p-3 text-dark fs-3">
                            <i class="bi bi-briefcase"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-12 col-lg-4">
                <div class="card h-100 border-start border-4 border-dark">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div>
                            <div class="text-muted small text-uppercase fw-semibold mb-1">Status Database</div>
                            <div class="fs-4 fw-bold text-dark text-truncate">db_pegawai</div>
                            <div class="small text-dark"><i class="bi bi-check-circle me-1"></i> Terhubung</div>
                        </div>
                        <div class="rounded-circle bg-light border p-3 text-dark fs-3">
                            <i class="bi bi-database"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card h-100">
                    <div class="card-header d-flex justify-content-between align-items-center py-3">
                        <h6 class="mb-0 fw-bold text-dark">
                            <i class="bi bi-clock-history me-1"></i> Pegawai Terbaru
                        </h6>
                        <a href="pegawai.php" class="btn btn-sm btn-outline-dark">
                            Lihat Semua <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th class="ps-3">NIP</th>
                                        <th>Nama</th>
                                        <th>Jabatan</th>
                                        <th class="text-end pe-3">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (count($recentPegawai) > 0): ?>
                                        <?php foreach ($recentPegawai as $row): ?>
                                            <tr>
                                                <td class="ps-3">
                                                    <span class="badge bg-light text-dark border font-monospace">
                                                        <?= htmlspecialchars($row['nip']) ?>
                                                    </span>
                                                </td>
                                                <td class="fw-semibold text-dark">
                                                    <?= htmlspecialchars($row['nama']) ?>
                                                </td>
                                                <td>
                                                    <span class="badge-jabatan"><?= htmlspecialchars($row['jabatan']) ?></span>
                                                </td>
                                                <td class="text-end pe-3">
                                                    <a href="detail.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-outline-dark btn-action" title="Detail">
                                                        <i class="bi bi-eye"></i>
                                                    </a>
                                                    <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-outline-dark btn-action" title="Edit">
                                                        <i class="bi bi-pencil"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="4" class="text-center py-4 text-muted">
                                                <i class="bi bi-inbox me-1"></i> Belum ada data pegawai.
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card h-100">
                    <div class="card-header py-3">
                        <h6 class="mb-0 fw-bold text-dark">
                            <i class="bi bi-grid me-1"></i> Navigasi Cepat
                        </h6>
                    </div>
                    <div class="card-body p-3">
                        <div class="list-group list-group-flush">
                            <a href="pegawai.php" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-3">
                                <div class="fw-semibold text-dark">
                                    <i class="bi bi-search me-2"></i> Cari Pegawai
                                </div>
                                <i class="bi bi-chevron-right text-muted"></i>
                            </a>
                            <a href="tambah.php" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-3">
                                <div class="fw-semibold text-dark">
                                    <i class="bi bi-file-earmark-plus me-2"></i> Tambah Pegawai
                                </div>
                                <i class="bi bi-chevron-right text-muted"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include 'includes/footer.php'; ?>
