<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'LaundryApp')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ route('dashboard') }}">LaundryApp</a>
        <div class="navbar-nav me-auto">
            <a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a>
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
    @yield('content')
</div>
</body>
</html>