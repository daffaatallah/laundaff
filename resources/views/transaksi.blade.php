<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Rekap Transaksi Laundry</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ route('dashboard') }}">LaundryApp</a>
        <div class="navbar-nav me-auto">
            <a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a>
            <a class="nav-link" href="{{ route('layanan') }}">Data Layanan</a>
            <a class="nav-link active" href="{{ route('transaksi') }}">Rekap Transaksi Laundry</a>
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

    <h4 class="fw-bold mb-3">Transaksi & Rekap Laundry</h4>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <h5 class="fw-bold mb-3">Input Transaksi Baru</h5>
            <form method="POST" action="{{ route('transaksi.store') }}" class="row g-3">
                @csrf
                <div class="col-md-3">
                    <label class="form-label">Nama Pelanggan</label>
                    <input type="text" name="nama_pelanggan" class="form-control" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">No. HP</label>
                    <input type="text" name="no_hp" class="form-control" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Jenis Layanan</label>
                    <select name="layanan_id" class="form-select" required>
                        <option value="">-- Pilih Layanan --</option>
                        @foreach($layanans as $l)
                            <option value="{{ $l->id }}">
                                {{ $l->nama_layanan }} (Rp {{ number_format($l->harga_per_kg, 0, ',', '.') }}/kg - {{ $l->estimasi_waktu }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Berat (Kg)</label>
                    <input type="number" step="0.1" min="0.1" name="berat_kg" class="form-control" required>
                </div>
                <div class="col-md-1 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <h5 class="fw-bold mb-3">Rekap Transaksi</h5>
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Pelanggan</th>
                            <th>No. HP</th>
                            <th>Layanan</th>
                            <th>Berat (Kg)</th>
                            <th>Total Harga</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transaksis as $i => $t)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td><strong>{{ $t->nama_pelanggan }}</strong></td>
                            <td>{{ $t->no_hp }}</td>
                            <td>{{ $t->layanan->nama_layanan ?? '-' }}</td>
                            <td>{{ $t->berat_kg }} kg</td>
                            <td><strong>Rp {{ number_format($t->total_harga, 0, ',', '.') }}</strong></td>
                            <td>
                                @if($t->status_pengerjaan === 'Selesai')
                                    <span class="badge bg-success">Selesai</span>
                                @else
                                    <span class="badge bg-warning text-dark">Proses</span>
                                @endif
                            </td>
                            <td>
                                @if($t->status_pengerjaan === 'Proses')
                                    <form method="POST" action="{{ route('transaksi.selesai', $t->id) }}" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button class="btn btn-sm btn-success">Tandai Selesai</button>
                                    </form>
                                @else
                                    <span class="text-muted small">Tuntas</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</body>
</html>