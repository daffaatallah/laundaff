<?php
require_once 'config.php';

if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit;
}

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    $stmt = mysqli_prepare($conn, "SELECT id, username, password, role FROM users WHERE username = ? LIMIT 1");
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($result);

    $valid = false;
    if ($user) {
        if (password_verify($password, $user['password']) || md5($password) === $user['password']) {
            $valid = true;
        }
    }

    if ($valid) {
        $_SESSION['user_id']  = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role']     = $user['role'];
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Username atau password salah.";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login - Sistem Laundry</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center min-vh-100">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <h4 class="text-center mb-1 fw-bold">LaundryApp</h4>
                    <p class="text-center text-muted small mb-4">Login Admin & Kasir</p>

                    <?php if ($error): ?>
                        <div class="alert alert-danger py-2 small"><?= htmlspecialchars($error) ?></div>
                    <?php endif; ?>

                    <form method="POST">
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
                    <hr>
                    <div class="small text-muted">
                        <strong>Akun Uji Coba:</strong><br>
                        Admin: <code>admin</code> / <code>admin123</code><br>
                        Kasir: <code>kasir</code> / <code>kasir123</code>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>