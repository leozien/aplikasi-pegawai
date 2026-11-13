<?php
require_once 'includes/auth_check.php';
require_once 'config/koneksi.php';

$pesan = isset($_GET['pesan']) ? $_GET['pesan'] : '';

try {
    $stmt = $pdo->query("SELECT id, nip, nama, email, jabatan, no_telepon FROM pegawai ORDER BY id DESC");
    $daftarPegawai = $stmt->fetchAll();
} catch (PDOException $e) {
    $daftarPegawai = [];
    $errorDb = $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pegawai — Manajemen Pegawai</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<?php include 'includes/navbar.php'; ?>

<main class="py-4">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-2 small">
                <li class="breadcrumb-item"><a href="dashboard.php" class="text-decoration-none text-dark">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Data Pegawai</li>
            </ol>
        </nav>

        <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-4">
            <div>
                <h3 class="fw-bold text-dark mb-0">
                    <i class="bi bi-people me-2"></i>Daftar Pegawai
                </h3>
                <p class="text-muted small mb-0">Kelola dan telusuri data pegawai yang tersimpan.</p>
            </div>
            <a href="tambah.php" class="btn btn-dark">
                <i class="bi bi-plus-lg me-1"></i> Tambah Pegawai
            </a>
        </div>

        <?php if ($pesan === 'tambah_sukses'): ?>
            <div class="alert alert-secondary alert-dismissible fade show d-flex align-items-center border" role="alert">
                <i class="bi bi-check-circle-fill me-2 fs-5"></i>
                <div>Data pegawai berhasil disimpan.</div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php elseif ($pesan === 'edit_sukses'): ?>
            <div class="alert alert-secondary alert-dismissible fade show d-flex align-items-center border" role="alert">
                <i class="bi bi-check-circle-fill me-2 fs-5"></i>
                <div>Data pegawai berhasil diubah.</div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php elseif ($pesan === 'hapus_sukses'): ?>
            <div class="alert alert-secondary alert-dismissible fade show d-flex align-items-center border" role="alert">
                <i class="bi bi-check-circle-fill me-2 fs-5"></i>
                <div>Data pegawai berhasil dihapus.</div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php elseif ($pesan === 'hapus_gagal'): ?>
            <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center" role="alert">
                <i class="bi bi-x-circle-fill me-2 fs-5"></i>
                <div>Gagal menghapus data pegawai.</div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php elseif ($pesan === 'id_tidak_valid'): ?>
            <div class="alert alert-warning alert-dismissible fade show d-flex align-items-center" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
                <div>Data pegawai tidak ditemukan.</div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="card">
            <div class="card-header bg-white py-3">
                <div class="row align-items-center g-2">
                    <div class="col-md-6 col-lg-5">
                        <div class="input-group">
                            <span class="input-group-text bg-white text-muted">
                                <i class="bi bi-search"></i>
                            </span>
                            <input type="text" id="inputCari" class="form-control" placeholder="Cari nama atau NIP..." autocomplete="off">
                            <button class="btn btn-outline-secondary" type="button" id="btnResetCari" title="Reset">
                                <i class="bi bi-x-lg"></i>
                            </button>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-7 text-md-end">
                        <span id="loadingSpinner" class="spinner-border spinner-border-sm text-dark me-2 d-none" role="status" aria-hidden="true"></span>
                        <span id="totalHasil" class="badge bg-light text-dark border px-3 py-2">
                            Total: <?= count($daftarPegawai) ?> pegawai
                        </span>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 50px;">No</th>
                            <th style="width: 170px;">NIP</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Jabatan</th>
                            <th>No. Telepon</th>
                            <th class="text-center" style="width: 140px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="tabelPegawaiBody">
                        <?php if (count($daftarPegawai) > 0): ?>
                            <?php $no = 1; foreach ($daftarPegawai as $pegawai): ?>
                                <tr>
                                    <td class="text-center fw-semibold text-secondary"><?= $no++ ?></td>
                                    <td>
                                        <span class="badge bg-light text-dark border font-monospace">
                                            <?= htmlspecialchars($pegawai['nip']) ?>
                                        </span>
                                    </td>
                                    <td class="fw-semibold text-dark">
                                        <?= htmlspecialchars($pegawai['nama']) ?>
                                    </td>
                                    <td>
                                        <a href="mailto:<?= htmlspecialchars($pegawai['email']) ?>" class="text-decoration-none text-muted">
                                            <?= htmlspecialchars($pegawai['email']) ?>
                                        </a>
                                    </td>
                                    <td>
                                        <span class="badge-jabatan">
                                            <?= htmlspecialchars($pegawai['jabatan']) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="text-muted">
                                            <?= htmlspecialchars($pegawai['no_telepon']) ?>
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <a href="detail.php?id=<?= $pegawai['id'] ?>" class="btn btn-sm btn-outline-dark btn-action" title="Detail">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="edit.php?id=<?= $pegawai['id'] ?>" class="btn btn-sm btn-outline-dark btn-action" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <button type="button" class="btn btn-sm btn-outline-danger btn-action" title="Hapus" 
                                                onclick="confirmDelete('<?= $pegawai['id'] ?>', '<?= addslashes(htmlspecialchars($pegawai['nama'])) ?>')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">
                                    <i class="bi bi-inbox fs-2 d-block mb-2 text-secondary"></i>
                                    Belum ada data pegawai.<br>
                                    <a href="tambah.php" class="btn btn-sm btn-dark mt-2">
                                        <i class="bi bi-plus-lg me-1"></i> Tambah Pegawai
                                    </a>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <div class="card-footer bg-white py-3 border-top">
                <div class="small text-muted">
                    <i class="bi bi-info-circle me-1"></i> Data diurutkan dari yang terbaru.
                </div>
            </div>
        </div>
    </div>
</main>

<?php include 'includes/footer.php'; ?>
