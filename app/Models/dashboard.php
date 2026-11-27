<?php
require_once 'config.php';
cek_login();

$q_layanan = mysqli_query($conn, "SELECT COUNT(*) AS total FROM layanan");
$total_layanan = mysqli_fetch_assoc($q_layanan)['total'];

$q_proses = mysqli_query($conn, "SELECT COUNT(*) AS total FROM transaksi WHERE status_pengerjaan = 'Proses'");
$total_proses = mysqli_fetch_assoc($q_proses)['total'];

$q_selesai = mysqli_query($conn, "SELECT COUNT(*) AS total FROM transaksi WHERE status_pengerjaan = 'Selesai'");
$total_selesai = mysqli_fetch_assoc($q_selesai)['total'];

$q_omzet = mysqli_query($conn, "SELECT COALESCE(SUM(total_harga), 0) AS omzet FROM transaksi");
$total_omzet = mysqli_fetch_assoc($q_omzet)['omzet'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Sistem Laundry</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand fw-bold" href="dashboard.php">LaundryApp</a>
        <div class="navbar-nav me-auto">
            <a class="nav-link active" href="dashboard.php">Dashboard</a>
            <a class="nav-link" href="layanan.php">Data Layanan</a>
            <a class="nav-link" href="transaksi.php">Rekap Transaksi Laundry</a>
        </div>
        <span class="navbar-text text-light me-3 small">
            <?= htmlspecialchars($_SESSION['username']) ?> (<strong><?= strtoupper($_SESSION['role']) ?></strong>)
        </span>
        <a href="logout.php" class="btn btn-outline-light btn-sm">Logout</a>
    </div>
</nav>

<div class="container py-4">
    <?php if (isset($_GET['err']) && $_GET['err'] === 'akses'): ?>
        <div class="alert alert-warning">Akses ditolak: fitur ubah/hapus layanan hanya untuk role <strong>Admin</strong>.</div>
    <?php endif; ?>

    <h4 class="mb-4 fw-bold">Dashboard Manajemen Laundry</h4>

    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="text-muted small">Jenis Layanan</div>
                    <h3 class="fw-bold mt-1"><?= $total_layanan ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="text-muted small">Sedang Proses</div>
                    <h3 class="fw-bold text-warning mt-1"><?= $total_proses ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="text-muted small">Selesai</div>
                    <h3 class="fw-bold text-success mt-1"><?= $total_selesai ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="text-muted small">Total Pendapatan</div>
                    <h4 class="fw-bold text-primary mt-1"><?= rupiah($total_omzet) ?></h4>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <h5 class="fw-bold">Data Layanan</h5>
                    <p class="text-muted small">Kelola paket cuci (Reguler, Ekspres, Superkilat), harga per kg, dan estimasi waktu.</p>
                    <a href="layanan.php" class="btn btn-primary btn-sm">Buka Data Layanan</a>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <h5 class="fw-bold">Rekap Transaksi Laundry</h5>
                    <p class="text-muted small">Catat transaksi pelanggan baru, hitung otomatis total biaya, dan perbarui status pengerjaan.</p>
                    <a href="transaksi.php" class="btn btn-success btn-sm">Buka Rekap Transaksi</a>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>