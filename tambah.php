<?php
require_once 'includes/auth_check.php';

$pesan = isset($_GET['pesan']) ? $_GET['pesan'] : '';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Pegawai — Manajemen Pegawai</title>
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
                <li class="breadcrumb-item active" aria-current="page">Tambah Pegawai</li>
            </ol>
        </nav>

        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h3 class="fw-bold text-dark mb-0">
                    <i class="bi bi-person-plus me-2"></i>Tambah Pegawai
                </h3>
                <p class="text-muted small mb-0">Lengkapi formulir berikut untuk menambah data pegawai.</p>
            </div>
            <a href="pegawai.php" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
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
                <div>NIP sudah terdaftar, gunakan NIP lain.</div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php elseif ($pesan === 'gagal_database'): ?>
            <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center" role="alert">
                <i class="bi bi-x-circle-fill me-2 fs-5"></i>
                <div>Gagal menyimpan data ke database.</div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header bg-white py-3">
                        <span class="fw-bold text-dark">
                            <i class="bi bi-card-checklist me-2"></i>Form Pegawai
                        </span>
                    </div>
                    <div class="card-body p-4">
                        <form id="formPegawai" action="proses/simpan.php" method="POST" novalidate autocomplete="off">
                            <div class="mb-3">
                                <label for="nip" class="form-label">
                                    NIP <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white text-muted"><i class="bi bi-credit-card-2-front"></i></span>
                                    <input type="text" class="form-control" id="nip" name="nip" placeholder="Contoh: 97948069367953" required>
                                    <div class="invalid-feedback">NIP wajib diisi minimal 5 digit angka.</div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="nama" class="form-label">
                                    Nama Lengkap <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white text-muted"><i class="bi bi-person"></i></span>
                                    <input type="text" class="form-control" id="nama" name="nama" placeholder="Contoh: Leo Rendra, S.Kom" required>
                                    <div class="invalid-feedback">Nama lengkap wajib diisi minimal 3 karakter.</div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">
                                    Email <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white text-muted"><i class="bi bi-envelope"></i></span>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="Contoh: leorendra.id@gmail.com" required>
                                    <div class="invalid-feedback">Format email tidak valid.</div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="jabatan" class="form-label">
                                    Jabatan <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white text-muted"><i class="bi bi-briefcase"></i></span>
                                    <input type="text" class="form-control" id="jabatan" name="jabatan" list="daftarJabatan" placeholder="Ketik atau pilih jabatan..." required>
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
                                    <input type="tel" class="form-control" id="no_telepon" name="no_telepon" placeholder="Contoh: 081234567890" required>
                                    <div class="invalid-feedback">Nomor telepon wajib diisi (10-16 digit angka).</div>
                                </div>
                            </div>

                            <hr class="my-4">

                            <div class="d-flex justify-content-end gap-2">
                                <a href="pegawai.php" class="btn btn-outline-secondary">
                                    <i class="bi bi-x-lg me-1"></i> Batal
                                </a>
                                <button type="submit" class="btn btn-dark px-4">
                                    <i class="bi bi-check-lg me-1"></i> Simpan
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
