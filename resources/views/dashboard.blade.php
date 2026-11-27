<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - LaundryApp</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ route('dashboard') }}">LaundryApp</a>
        <div class="navbar-nav me-auto">
            <a class="nav-link active" href="{{ route('dashboard') }}">Dashboard</a>
            <a class="nav-link" href="{{ route('layanan') }}">Data Layanan</a>
            <a class="nav-link" href="{{ route('transaksi') }}">Rekap Transaksi Laundry</a>
        </div>
        <span class="navbar-text text-light me-3 small">
            {{ session('username') }} (<strong>{{ strtoupper(session('role')) }}</strong>)
        </span>
        <a href="{{ route('logout') }}" class="btn btn-outline-light btn-sm">Logout</a>
    </div>
</nav>

<div class="container py-4">
    @if(session('success'))
        <div class="alert alert-success py-2">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger py-2">{{ session('error') }}</div>
    @endif

    <h4 class="fw-bold mb-4">Dashboard Manajemen Laundry</h4>

    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm"><div class="card-body">
                <div class="text-muted small">Jenis Layanan</div>
                <h3 class="fw-bold mt-1">{{ $totalLayanan }}</h3>
            </div></div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm"><div class="card-body">
                <div class="text-muted small">Sedang Proses</div>
                <h3 class="fw-bold text-warning mt-1">{{ $totalProses }}</h3>
            </div></div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm"><div class="card-body">
                <div class="text-muted small">Selesai</div>
                <h3 class="fw-bold text-success mt-1">{{ $totalSelesai }}</h3>
            </div></div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm"><div class="card-body">
                <div class="text-muted small">Total Pendapatan</div>
                <h4 class="fw-bold text-primary mt-1">Rp {{ number_format($totalOmzet, 0, ',', '.') }}</h4>
            </div></div>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100"><div class="card-body">
                <h5 class="fw-bold">Data Layanan</h5>
                <p class="text-muted small">Kelola jenis layanan (Reguler, Ekspres, Superkilat), tarif/kg, dan estimasi waktu.</p>
                <a href="{{ route('layanan') }}" class="btn btn-primary btn-sm">Buka Data Layanan</a>
            </div></div>
        </div>
        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100"><div class="card-body">
                <h5 class="fw-bold">Rekap Transaksi Laundry</h5>
                <p class="text-muted small">Catat transaksi pelanggan, hitung total biaya, dan perbarui status pengerjaan.</p>
                <a href="{{ route('transaksi') }}" class="btn btn-success btn-sm">Buka Rekap Transaksi</a>
            </div></div>
        </div>
    </div>
</div>
</body>
</html>