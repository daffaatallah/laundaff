<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login - LaundryApp</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center min-vh-100">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h4 class="text-center fw-bold mb-1">LaundryApp</h4>
                    <p class="text-center text-muted small mb-4">Login Admin & Kasir</p>

                    @if(session('error'))
                        <div class="alert alert-danger py-2 small">{{ session('error') }}</div>
                    @endif

                    <form method="POST" action="{{ route('login.post') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Username</label>
                            <input type="text" name="username" class="form-control" required autofocus>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Masuk</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>