<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title><?= esc($title ?? 'Pendaftaran Berhasil'); ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">

<style>
body {
    min-height: 100vh;
    background: linear-gradient(135deg, rgba(11,53,92,0.95), rgba(15,76,129,0.92)),
                radial-gradient(circle at top right, rgba(255,255,255,0.12), transparent 35%);
    font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
    color: #102033;
}

.success-card {
    border: 0;
    border-radius: 26px;
    box-shadow: 0 24px 70px rgba(15, 23, 42, 0.25);
}

.success-icon {
    width: 76px;
    height: 76px;
    border-radius: 24px;
    background: #ecfdf5;
    color: #047857;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 40px;
    margin-bottom: 20px;
}

.btn-primary, .btn-outline-secondary {
    border-radius: 13px;
    padding: 12px 14px;
    font-weight: 700;
}

.btn-primary { background-color: #0f4c81; border-color: #0f4c81; }
.btn-primary:hover { background-color: #0b355c; border-color: #0b355c; }

.btn-outline-secondary { border-color: #0f4c81; color: #0f4c81; }
.btn-outline-secondary:hover { background-color: #0f4c81; color: #fff; border-color: #0b355c; }

.info-box {
    background: #eff6ff;
    border: 1px solid #dbeafe;
    color: #1e3a8a;
    border-radius: 16px;
    padding: 16px;
    text-align: left;
    margin-bottom: 20px;
}

.small-note { color: #64748b; font-size: 14px; line-height: 1.7; }
</style>
</head>

<body>

<div class="container min-vh-100 d-flex align-items-center justify-content-center py-5">
    <div class="row justify-content-center w-100">
        <div class="col-md-7 col-lg-6">

            <div class="card success-card">
                <div class="card-body p-4 p-md-5 text-center">

                    <div class="success-icon">
                        <i class="bi bi-check2-circle"></i>
                    </div>

                    <h3 class="fw-bold mb-3">Pendaftaran Berhasil Dikirim</h3>

                    <p class="text-muted mb-4">
                        Data pendaftaran akun Ketua PKK Anda telah diterima dan sedang menunggu verifikasi admin pusat.
                    </p>

                    <div class="info-box">
                        <div class="d-flex align-items-start">
                            <i class="bi bi-info-circle-fill me-2 mt-1"></i>
                            <div>
                                <strong>Informasi Verifikasi</strong>
                                <p class="mb-0 mt-1">
                                    Admin akan menghubungi Anda melalui email aktif atau nomor HP/WhatsApp yang telah dicantumkan pada formulir pendaftaran.
                                </p>
                            </div>
                        </div>
                    </div>

                    <p class="small-note mb-4">
                        Akun belum dapat digunakan untuk login sebelum disetujui oleh admin. Setelah disetujui, Anda dapat masuk menggunakan username/email dan password yang dibuat saat pendaftaran.
                    </p>

                    <a href="<?= base_url('/'); ?>" class="btn btn-primary w-100 mb-2">
                        Kembali ke Beranda
                    </a>

                    <a href="<?= base_url('login'); ?>" class="btn btn-outline-secondary w-100">
                        Ke Halaman Masuk
                    </a>

                </div>
            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>