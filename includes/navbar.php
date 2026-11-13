<?php
$currentPage = basename($_SERVER['PHP_SELF']);
$adminName   = isset($_SESSION['nama_lengkap']) ? str_replace(' SIMPEG', '', $_SESSION['nama_lengkap']) : 'Administrator';
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-black sticky-top">
    <div class="container">
        <a class="navbar-brand py-1" href="dashboard.php">
            <span class="fw-bold tracking-tight">Manajemen Pegawai</span>
        </a>

        <button class="navbar-toggler border-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-2">
                <li class="nav-item">
                    <a class="nav-link <?= ($currentPage === 'dashboard.php') ? 'active' : '' ?>" href="dashboard.php">
                        <i class="bi bi-speedometer2 me-1"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= in_array($currentPage, ['pegawai.php', 'tambah.php', 'edit.php', 'detail.php']) ? 'active' : '' ?>" href="pegawai.php">
                        <i class="bi bi-people me-1"></i> Data Pegawai
                    </a>
                </li>
            </ul>

            <div class="d-flex align-items-center gap-2">
                <a href="tambah.php" class="btn btn-sm btn-light text-dark fw-semibold">
                    <i class="bi bi-plus-lg"></i> Tambah Pegawai
                </a>

                <div class="dropdown">
                    <button class="btn btn-sm btn-outline-light dropdown-toggle d-flex align-items-center gap-2" type="button" id="userMenu" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-person-circle"></i>
                        <span><?= htmlspecialchars($adminName) ?></span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="userMenu">
                        <li>
                            <div class="px-3 py-2 small text-muted border-bottom">
                                Akun: <strong><?= htmlspecialchars($_SESSION['username'] ?? 'admin') ?></strong>
                            </div>
                        </li>
                        <li>
                            <a class="dropdown-item text-danger py-2" href="proses/logout.php" onclick="return confirm('Yakin ingin logout?');">
                                <i class="bi bi-box-arrow-right me-2"></i> Logout
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</nav>
