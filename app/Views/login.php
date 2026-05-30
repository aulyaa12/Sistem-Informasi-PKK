<!-- File: login.php -->
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login | SIP-DESA PKK</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
<style>
body { min-height:100vh; background: linear-gradient(135deg, rgba(13,39,76,0.96), rgba(30,83,150,0.94)), radial-gradient(circle at top right, rgba(255,255,255,0.16), transparent 30%); font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif; }
.login-card { border:0; border-radius:24px; box-shadow:0 24px 70px rgba(15,23,42,0.25); }
.brand-icon { width:56px; height:56px; display:inline-flex; align-items:center; justify-content:center; border-radius:18px; background-color: rgba(13,110,253,0.12); color:#0d6efd; font-size:28px; }
.form-control { border-radius:14px; padding:12px 14px; }
.password-wrapper { position:relative; }
.password-wrapper .form-control { padding-right:48px; }
.toggle-password { position:absolute; top:50%; right:14px; transform:translateY(-50%); border:0; background:transparent; color:#6c757d; font-size:18px; padding:0; cursor:pointer; }
.toggle-password:hover { color:#0d6efd; }
.btn { border-radius:14px; padding:11px 14px; }
.side-panel { color:#ffffff; }
.side-check { width:32px; height:32px; border-radius:50%; background-color: rgba(255,193,7,0.18); color:#ffc107; display:inline-flex; align-items:center; justify-content:center; flex:0 0 32px; }
</style>
</head>
<body>
<div class="container min-vh-100 d-flex align-items-center py-5">
    <div class="row justify-content-center align-items-center g-5 w-100">
        <div class="col-lg-5 d-none d-lg-block side-panel">
            <a href="<?= base_url('/'); ?>" class="text-white text-decoration-none fw-bold fs-4"><i class="bi bi-grid-1x2-fill me-2"></i>SIP-DESA PKK</a>
            <h1 class="fw-bold mt-5 mb-3">Masuk ke sistem pengelolaan data PKK Desa.</h1>
            <p class="text-white-50 fs-5">Gunakan akun Ketua PKK yang sudah disetujui admin untuk mengakses dashboard wilayah desa.</p>
            <div class="mt-4">
                <div class="d-flex align-items-start mb-3">
                    <span class="side-check me-3"><i class="bi bi-check-lg"></i></span>
                    <p class="mb-0 text-white-50">Akun baru harus melalui persetujuan admin pusat.</p>
                </div>
                <div class="d-flex align-items-start">
                    <span class="side-check me-3"><i class="bi bi-check-lg"></i></span>
                    <p class="mb-0 text-white-50">Setelah disetujui, Ketua PKK dapat mengelola data sesuai wilayah desa.</p>
                </div>
            </div>
        </div>

        <div class="col-md-8 col-lg-5">
            <div class="card login-card">
                <div class="card-body p-4 p-md-5 text-center">
                    <div class="brand-icon mb-3"><i class="bi bi-person-lock"></i></div>
                    <h3 class="fw-bold mb-1">Login</h3>
                    <p class="text-muted mb-4">Masuk sebagai Ketua PKK Desa.</p>

                    <?php if(session()->getFlashdata('success')): ?>
                        <div class="alert alert-success"><?= session()->getFlashdata('success'); ?></div>
                    <?php endif; ?>
                    <?php if(session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger"><?= session()->getFlashdata('error'); ?></div>
                    <?php endif; ?>

                    <form action="<?= base_url('login'); ?>" method="POST">
                        <?= csrf_field(); ?>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Username atau Email</label>
                            <input type="text" name="username" class="form-control" placeholder="Masukkan username atau email" value="<?= old('username'); ?>" required autocomplete="off">
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold">Password</label>
                            <div class="password-wrapper">
                                <input type="password" id="passwordInput" name="password" class="form-control" placeholder="Masukkan password" required>
                                <button type="button" class="toggle-password" onclick="togglePassword()"><i class="bi bi-eye" id="passwordIcon"></i></button>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 fw-semibold">Masuk</button>
                    </form>

                    <div class="text-center mt-4">
                        <span class="text-muted">Belum punya akun?</span>
                        <a href="<?= base_url('register'); ?>" class="fw-semibold text-decoration-none">Buat akun</a>
                    </div>
                    <div class="text-center mt-3">
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
    if(passwordInput.type==='password'){ passwordInput.type='text'; passwordIcon.classList.replace('bi-eye','bi-eye-slash'); }
    else{ passwordInput.type='password'; passwordIcon.classList.replace('bi-eye-slash','bi-eye'); }
}
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>