<?php
session_start();

if (isset($_SESSION['login']) && $_SESSION['login'] === true) {
    header("Location: dashboard.php");
    exit;
}

$pesan = isset($_GET['pesan']) ? $_GET['pesan'] : '';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — Manajemen Pegawai</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="bg-light">

<div class="login-container">
    <div class="card login-card p-3 p-md-4">
        <div class="card-body">
            <div class="text-center mb-4">
                <h3 class="fw-bold text-dark mb-1">Manajemen Pegawai</h3>
                <p class="text-muted small mb-0">Sistem Pencatatan Data Pegawai</p>
            </div>

            <?php if ($pesan === 'gagal'): ?>
                <div class="alert alert-dark alert-dismissible fade show d-flex align-items-center small py-2 border" role="alert">
                    <i class="bi bi-x-circle me-2 fs-6"></i>
                    <div>Username atau password salah.</div>
                    <button type="button" class="btn-close ms-auto p-2" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php elseif ($pesan === 'logout'): ?>
                <div class="alert alert-secondary alert-dismissible fade show d-flex align-items-center small py-2 border" role="alert">
                    <i class="bi bi-check-circle me-2 fs-6"></i>
                    <div>Anda berhasil logout.</div>
                    <button type="button" class="btn-close ms-auto p-2" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php elseif ($pesan === 'belum_login'): ?>
                <div class="alert alert-dark alert-dismissible fade show d-flex align-items-center small py-2 border" role="alert">
                    <i class="bi bi-exclamation-circle me-2 fs-6"></i>
                    <div>Silakan login terlebih dahulu.</div>
                    <button type="button" class="btn-close ms-auto p-2" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php elseif ($pesan === 'kosong'): ?>
                <div class="alert alert-dark alert-dismissible fade show d-flex align-items-center small py-2 border" role="alert">
                    <i class="bi bi-exclamation-circle me-2 fs-6"></i>
                    <div>Username dan password wajib diisi.</div>
                    <button type="button" class="btn-close ms-auto p-2" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <form action="proses/login_proses.php" method="POST" autocomplete="off">
                <div class="mb-3">
                    <label for="username" class="form-label small fw-semibold text-dark">Username</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white text-dark border-end-0"><i class="bi bi-person"></i></span>
                        <input type="text" class="form-control border-start-0 ps-1" id="username" name="username" placeholder="Masukkan username" required autofocus>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="password" class="form-label small fw-semibold text-dark">Password</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white text-dark border-end-0"><i class="bi bi-lock"></i></span>
                        <input type="password" class="form-control border-start-0 ps-1" id="password" name="password" placeholder="Masukkan password" required>
                    </div>
                </div>

                <button type="submit" class="btn btn-dark w-100 py-2 justify-content-center fw-semibold">
                    <i class="bi bi-box-arrow-in-right me-1"></i> Masuk
                </button>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
