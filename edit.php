<?php
require_once 'includes/auth_check.php';
require_once 'config/koneksi.php';

$id = isset($_GET['id']) ? filter_var($_GET['id'], FILTER_VALIDATE_INT) : false;

if (!$id) {
    header("Location: pegawai.php?pesan=id_tidak_valid");
    exit;
}

try {
    $stmt = $pdo->prepare("SELECT id, nip, nama, email, jabatan, no_telepon FROM pegawai WHERE id = :id LIMIT 1");
    $stmt->execute([':id' => $id]);
    $pegawai = $stmt->fetch();

    if (!$pegawai) {
        header("Location: pegawai.php?pesan=id_tidak_valid");
        exit;
    }
} catch (PDOException $e) {
    header("Location: pegawai.php?pesan=gagal_database");
    exit;
}

$pesan = isset($_GET['pesan']) ? $_GET['pesan'] : '';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pegawai — <?= htmlspecialchars($pegawai['nama']) ?> — Manajemen Pegawai</title>
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
                <li class="breadcrumb-item"><a href="pegawai.php" class="text-decoration-none text-dark">Data Pegawai</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit Pegawai</li>
            </ol>
        </nav>

        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h3 class="fw-bold text-dark mb-0">
                    <i class="bi bi-pencil me-2"></i>Edit Data Pegawai
                </h3>
                <p class="text-muted small mb-0">Ubah data pegawai ID #<?= htmlspecialchars($pegawai['id']) ?>.</p>
            </div>
            <div class="d-flex gap-2">
                <a href="detail.php?id=<?= $pegawai['id'] ?>" class="btn btn-outline-dark">
                    <i class="bi bi-eye me-1"></i> Detail
                </a>
                <a href="pegawai.php" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                </a>
            </div>
        </div>

        <?php if ($pesan === 'kosong'): ?>
            <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center" role="alert">
                <i class="bi bi-exclamation-circle-fill me-2 fs-5"></i>
                <div>Semua kolom wajib diisi.</div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php elseif ($pesan === 'email_invalid'): ?>
            <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center" role="alert">
                <i class="bi bi-exclamation-circle-fill me-2 fs-5"></i>
                <div>Format email tidak valid.</div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php elseif ($pesan === 'nip_duplikat'): ?>
            <div class="alert alert-warning alert-dismissible fade show d-flex align-items-center" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
                <div>NIP sudah digunakan pegawai lain.</div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php elseif ($pesan === 'gagal_database'): ?>
            <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center" role="alert">
                <i class="bi bi-x-circle-fill me-2 fs-5"></i>
                <div>Gagal mengubah data ke database.</div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header bg-white py-3">
                        <span class="fw-bold text-dark">
                            <i class="bi bi-pencil-square me-2"></i>Form Edit Pegawai
                        </span>
                    </div>
                    <div class="card-body p-4">
                        <form id="formPegawai" action="proses/update.php" method="POST" novalidate autocomplete="off">
                            <input type="hidden" name="id" value="<?= htmlspecialchars($pegawai['id']) ?>">

                            <div class="mb-3">
                                <label for="nip" class="form-label">
                                    NIP <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white text-muted"><i class="bi bi-credit-card-2-front"></i></span>
                                    <input type="text" class="form-control" id="nip" name="nip" value="<?= htmlspecialchars($pegawai['nip']) ?>" required>
                                    <div class="invalid-feedback">NIP wajib diisi minimal 5 digit angka.</div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="nama" class="form-label">
                                    Nama Lengkap <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white text-muted"><i class="bi bi-person"></i></span>
                                    <input type="text" class="form-control" id="nama" name="nama" value="<?= htmlspecialchars($pegawai['nama']) ?>" required>
                                    <div class="invalid-feedback">Nama lengkap wajib diisi minimal 3 karakter.</div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">
                                    Email <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white text-muted"><i class="bi bi-envelope"></i></span>
                                    <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($pegawai['email']) ?>" required>
                                    <div class="invalid-feedback">Format email tidak valid.</div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="jabatan" class="form-label">
                                    Jabatan <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white text-muted"><i class="bi bi-briefcase"></i></span>
                                    <input type="text" class="form-control" id="jabatan" name="jabatan" list="daftarJabatan" value="<?= htmlspecialchars($pegawai['jabatan']) ?>" required>
                                    <datalist id="daftarJabatan">
                                        <option value="Staff IT">
                                        <option value="HRD">
                                        <option value="Manager">
                                        <option value="Finance">
                                        <option value="Marketing">
                                    </datalist>
                                    <div class="invalid-feedback">Jabatan wajib diisi.</div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="no_telepon" class="form-label">
                                    Nomor Telepon <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white text-muted"><i class="bi bi-telephone"></i></span>
                                    <input type="tel" class="form-control" id="no_telepon" name="no_telepon" value="<?= htmlspecialchars($pegawai['no_telepon']) ?>" required>
                                    <div class="invalid-feedback">Nomor telepon wajib diisi (10-16 digit angka).</div>
                                </div>
                            </div>

                            <hr class="my-4">

                            <div class="d-flex justify-content-end gap-2">
                                <a href="pegawai.php" class="btn btn-outline-secondary">
                                    <i class="bi bi-x-lg me-1"></i> Batal
                                </a>
                                <button type="submit" class="btn btn-dark px-4">
                                    <i class="bi bi-check-lg me-1"></i> Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include 'includes/footer.php'; ?>
