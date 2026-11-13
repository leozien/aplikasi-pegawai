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

$namaArray = explode(' ', trim($pegawai['nama']));
$inisial = '';
if (count($namaArray) >= 2) {
    $inisial = mb_substr($namaArray[0], 0, 1) . mb_substr($namaArray[1], 0, 1);
} else {
    $inisial = mb_substr($pegawai['nama'], 0, 2);
}
$inisial = strtoupper($inisial);

$cleanPhone = preg_replace('/[^0-9]/', '', $pegawai['no_telepon']);
if (substr($cleanPhone, 0, 1) === '0') {
    $cleanPhone = '62' . substr($cleanPhone, 1);
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pegawai — <?= htmlspecialchars($pegawai['nama']) ?> — Manajemen Pegawai</title>
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
                <li class="breadcrumb-item active" aria-current="page">Detail Pegawai</li>
            </ol>
        </nav>

        <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-4">
            <div>
                <h3 class="fw-bold text-dark mb-0">
                    <i class="bi bi-person-badge me-2"></i>Detail Pegawai
                </h3>
                <p class="text-muted small mb-0">Rincian data dan kontak pegawai.</p>
            </div>
            <div class="d-flex gap-2">
                <a href="pegawai.php" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                </a>
                <a href="edit.php?id=<?= $pegawai['id'] ?>" class="btn btn-dark">
                    <i class="bi bi-pencil me-1"></i> Edit
                </a>
                <button type="button" class="btn btn-outline-danger" 
                    onclick="confirmDelete('<?= $pegawai['id'] ?>', '<?= addslashes(htmlspecialchars($pegawai['nama'])) ?>')">
                    <i class="bi bi-trash me-1"></i> Hapus
                </button>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-9">
                <div class="card overflow-hidden">
                    <div class="bg-black p-4 text-white">
                        <div class="d-flex flex-column flex-sm-row align-items-center gap-4">
                            <div class="avatar-circle avatar-large shadow border border-2 border-white">
                                <?= htmlspecialchars($inisial) ?>
                            </div>
                            <div class="text-center text-sm-start">
                                <h4 class="fw-bold mb-1 text-white"><?= htmlspecialchars($pegawai['nama']) ?></h4>
                                <div class="badge bg-white text-dark fw-semibold px-3 py-2 rounded-pill mb-2">
                                    <?= htmlspecialchars($pegawai['jabatan']) ?>
                                </div>
                                <div class="text-white-50 small">
                                    <i class="bi bi-credit-card-2-front me-1"></i> NIP: <?= htmlspecialchars($pegawai['nip']) ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-4">
                        <h6 class="fw-bold text-dark text-uppercase small tracking-wide border-bottom pb-2 mb-3">
                            <i class="bi bi-file-text me-1"></i> Data Lengkap
                        </h6>

                        <div class="row g-3">
                            <div class="col-sm-6">
                                <div class="p-3 bg-light rounded-2 border">
                                    <div class="small text-muted mb-1"><i class="bi bi-hash"></i> ID</div>
                                    <div class="fw-bold text-dark fs-6">#<?= htmlspecialchars($pegawai['id']) ?></div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="p-3 bg-light rounded-2 border">
                                    <div class="small text-muted mb-1"><i class="bi bi-credit-card"></i> NIP</div>
                                    <div class="fw-bold text-dark fs-6 font-monospace"><?= htmlspecialchars($pegawai['nip']) ?></div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="p-3 bg-light rounded-2 border">
                                    <div class="small text-muted mb-1"><i class="bi bi-person"></i> Nama Lengkap</div>
                                    <div class="fw-bold text-dark fs-6"><?= htmlspecialchars($pegawai['nama']) ?></div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="p-3 bg-light rounded-2 border">
                                    <div class="small text-muted mb-1"><i class="bi bi-briefcase"></i> Jabatan</div>
                                    <div class="fw-bold text-dark fs-6"><?= htmlspecialchars($pegawai['jabatan']) ?></div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="p-3 bg-light rounded-2 border">
                                    <div class="small text-muted mb-1"><i class="bi bi-envelope"></i> Email</div>
                                    <div class="fw-bold text-dark fs-6 mb-2">
                                        <a href="mailto:<?= htmlspecialchars($pegawai['email']) ?>" class="text-dark text-decoration-underline">
                                            <?= htmlspecialchars($pegawai['email']) ?>
                                        </a>
                                    </div>
                                    <a href="mailto:<?= htmlspecialchars($pegawai['email']) ?>" class="btn btn-sm btn-outline-dark">
                                        <i class="bi bi-send me-1"></i> Kirim Email
                                    </a>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="p-3 bg-light rounded-2 border">
                                    <div class="small text-muted mb-1"><i class="bi bi-telephone"></i> Nomor Telepon</div>
                                    <div class="fw-bold text-dark fs-6 mb-2"><?= htmlspecialchars($pegawai['no_telepon']) ?></div>
                                    <div class="d-flex gap-2">
                                        <a href="tel:<?= htmlspecialchars($pegawai['no_telepon']) ?>" class="btn btn-sm btn-outline-dark">
                                            <i class="bi bi-telephone me-1"></i> Telepon
                                        </a>
                                        <a href="https://wa.me/<?= htmlspecialchars($cleanPhone) ?>" target="_blank" rel="noopener noreferrer" class="btn btn-sm btn-outline-dark">
                                            <i class="bi bi-whatsapp me-1"></i> WhatsApp
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer bg-white p-3 border-top d-flex justify-content-between align-items-center">
                        <span class="small text-muted">
                            <i class="bi bi-check-circle text-dark me-1"></i> Data tersimpan di sistem
                        </span>
                        <a href="pegawai.php" class="btn btn-sm btn-outline-secondary">
                            <i class="bi bi-arrow-left me-1"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include 'includes/footer.php'; ?>
