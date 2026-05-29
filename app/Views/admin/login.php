<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login Admin | SIP-DESA PKK</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">

<style>
body {
    min-height: 100vh;
    background: linear-gradient(135deg, rgba(17,24,39,0.97), rgba(30,64,175,0.94)),
                radial-gradient(circle at top right, rgba(255,255,255,0.14), transparent 30%);
    font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
}

.login-card {
    border: 0;
    border-radius: 24px;
    box-shadow: 0 24px 70px rgba(15,23,42,0.28);
    background: #fff;
}

.brand-icon {
    width: 56px;
    height: 56px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 18px;
    background-color: rgba(25,135,84,0.12);
    color: #198754;
    font-size: 28px;
}

.form-control {
    border-radius: 14px;
    padding: 12px 14px;
}

.password-wrapper {
    position: relative;
}

.password-wrapper .form-control {
    padding-right: 48px;
}

.toggle-password {
    position: absolute;
    top: 50%;
    right: 14px;
    transform: translateY(-50%);
    border: 0;
    background: transparent;
    color: #6c757d;
    font-size: 18px;
    cursor: pointer;
}

.toggle-password:hover {
    color: #198754;
}

.btn {
    border-radius: 14px;
    padding: 11px 14px;
    font-weight: 600;
}

.side-panel {
    color: #ffffff;
}

.side-check {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background-color: rgba(25,135,84,0.20);
    color: #75d7a2;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    flex: 0 0 32px;
}

@media(max-width: 992px) {
    .side-panel { display:none; }
}
</style>
</head>

<body>
<div class="container min-vh-100 d-flex align-items-center py-5">
    <div class="row justify-content-center align-items-center g-5 w-100">

        <!-- Side Panel Desktop -->
        <div class="col-lg-5 side-panel">
            <a href="<?= base_url('/'); ?>" class="text-white text-decoration-none fw-bold fs-4">
                <i class="bi bi-grid-1x2-fill me-2"></i>SIP-DESA PKK
            </a>

            <h1 class="fw-bold mt-5 mb-3">Portal Admin Pusat.</h1>
            <p class="text-white-50 fs-5">Halaman khusus admin untuk mengelola akun, approval, dan data sistem.</p>

            <div class="mt-4">
                <div class="d-flex align-items-start mb-3">
                    <span class="side-check me-3"><i class="bi bi-check-lg"></i></span>
                    <p class="mb-0 text-white-50">Admin dapat menyetujui atau menolak pendaftaran akun Ketua PKK.</p>
                </div>
                <div class="d-flex align-items-start">
                    <span class="side-check me-3"><i class="bi bi-check-lg"></i></span>
                    <p class="mb-0 text-white-50">Akses admin hanya diberikan kepada akun dengan role admin.</p>
                </div>
            </div>
        </div>

        <!-- Login Card -->
        <div class="col-md-8 col-lg-5">
            <div class="card login-card">
                <div class="card-body p-4 p-md-5">

                    <div class="text-center mb-4">
                        <div class="brand-icon mb-3"><i class="bi bi-shield-lock"></i></div>
                        <h3 class="fw-bold mb-1">Login Admin</h3>
                        <p class="text-muted mb-0">Masuk sebagai Admin Pusat.</p>
                    </div>

                    <?php if(session()->getFlashdata('success')): ?>
                        <div class="alert alert-success"><?= session()->getFlashdata('success'); ?></div>
                    <?php endif; ?>

                    <?php if(session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger"><?= session()->getFlashdata('error'); ?></div>
                    <?php endif; ?>

                    <form action="<?= base_url('admin/login'); ?>" method="POST">
                        <?= csrf_field(); ?>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Username atau Email Admin</label>
                            <input type="text" name="username" class="form-control" placeholder="Masukkan username atau email admin" value="<?= old('username'); ?>" required autocomplete="off">
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold">Password</label>
                            <div class="password-wrapper">
                                <input type="password" id="passwordInput" name="password" class="form-control" placeholder="Masukkan password" required>
                                <button type="button" class="toggle-password" onclick="togglePassword()">
                                    <i class="bi bi-eye" id="passwordIcon"></i>
                                </button>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-success w-100 fw-semibold">Masuk sebagai Admin</button>
                    </form>

                    <div class="text-center mt-4">
                        <a href="<?= base_url('/'); ?>" class="small text-muted text-decoration-none">Kembali ke beranda</a>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>

<script>
function togglePassword() {
    const passwordInput = document.getElementById('passwordInput');
    const passwordIcon = document.getElementById('passwordIcon');
    if(passwordInput.type === 'password') {
        passwordInput.type = 'text';
        passwordIcon.classList.replace('bi-eye','bi-eye-slash');
    } else {
        passwordInput.type = 'password';
        passwordIcon.classList.replace('bi-eye-slash','bi-eye');
    }
}
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>