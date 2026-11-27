<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Layanan - LaundryApp</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ route('dashboard') }}">LaundryApp</a>
        <div class="navbar-nav me-auto">
            <a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a>
            <a class="nav-link active" href="{{ route('layanan') }}">Data Layanan</a>
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

    @php $isAdmin = session('role') === 'admin'; @endphp
    <h4 class="fw-bold mb-3">Data Layanan Laundry</h4>

    <div class="row g-4">
        @if($isAdmin)
        <div class="col-md-4">
            <div class="card border-0 shadow-sm"><div class="card-body">
                <h5 class="fw-bold mb-3">{{ $editData ? 'Edit Layanan' : 'Tambah Layanan' }}</h5>
                <form method="POST" action="{{ $editData ? route('layanan.update', $editData->id) : route('layanan.store') }}">
                    @csrf
                    @if($editData)
                        @method('PUT')
                    @endif
                    <div class="mb-3">
                        <label class="form-label">Nama Layanan</label>
                        <input type="text" name="nama_layanan" class="form-control" required
                               value="{{ $editData->nama_layanan ?? '' }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Harga per Kg (Rp)</label>
                        <input type="number" name="harga_per_kg" class="form-control" min="1" required
                               value="{{ $editData->harga_per_kg ?? '' }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Estimasi Waktu</label>
                        <input type="text" name="estimasi_waktu" class="form-control" required
                               value="{{ $editData->estimasi_waktu ?? '' }}">
                    </div>
                    <button type="submit" class="btn {{ $editData ? 'btn-warning' : 'btn-primary' }} w-100">
                        {{ $editData ? 'Simpan Perubahan' : 'Tambah Layanan' }}
                    </button>
                    @if($editData)
                        <a href="{{ route('layanan') }}" class="btn btn-secondary w-100 mt-2">Batal</a>
                    @endif
                </form>
            </div></div>
        </div>
        @endif

        <div class="{{ $isAdmin ? 'col-md-8' : 'col-md-12' }}">
            <div class="card border-0 shadow-sm"><div class="card-body">
                <table class="table table-bordered table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Nama Layanan</th>
                            <th>Harga / Kg</th>
                            <th>Estimasi</th>
                            @if($isAdmin)<th>Aksi</th>@endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($layanans as $i => $l)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td><strong>{{ $l->nama_layanan }}</strong></td>
                            <td>Rp {{ number_format($l->harga_per_kg, 0, ',', '.') }}</td>
                            <td>{{ $l->estimasi_waktu }}</td>
                            @if($isAdmin)
                            <td>
                                <a href="{{ route('layanan', ['edit' => $l->id]) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form method="POST" action="{{ route('layanan.destroy', $l->id) }}" class="d-inline"
                                      onsubmit="return confirm('Hapus layanan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Hapus</button>
                                </form>
                            </td>
                            @endif
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div></div>
        </div>
    </div>
</div>
</body>
</html>