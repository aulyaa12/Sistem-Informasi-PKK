<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= esc($title ?? 'Dashboard Admin'); ?></title>

<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

<style>
  body { font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif; background: #f4f7fb; color: #102033; }
  .hero-admin { background: linear-gradient(135deg, #0b355c 0%, #0f4c81 100%); color: #fff; padding: 60px 0; text-align: center; border-radius: 0 0 20px 20px; }
  .main-content { margin-top: -40px; }
  .stat-card, .menu-card { border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.08); background: #fff; padding: 20px; transition: transform 0.2s; }
  .stat-card:hover, .menu-card:hover { transform: translateY(-5px); }
  .stat-icon, .menu-icon { width: 50px; height: 50px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 24px; margin-left: auto; }
</style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
  <div class="container">
    <a class="navbar-brand fw-bold" href="<?= base_url('admin/dashboard'); ?>">
      <i class="bi bi-shield-lock-fill me-2 text-warning"></i>Admin Pusat
    </a>
    <div class="ms-auto d-flex align-items-center">
      <span class="text-white-50 me-3 d-none d-md-inline"><i class="bi bi-person-circle me-1"></i><?= esc(session()->get('username') ?? 'Administrator'); ?></span>
      <a href="<?= base_url('logout'); ?>" class="btn btn-outline-light btn-sm"><i class="bi bi-box-arrow-right me-1"></i>Keluar</a>
    </div>
  </div>
</nav>

<!-- Hero -->
<header class="hero-admin">
  <div class="container">
    <h1 class="display-6 fw-bold">Dashboard Admin Pusat</h1>
    <p class="lead mb-0">Panel untuk memantau akun Ketua PKK, memproses pendaftaran, dan mengelola akun PKK desa aktif.</p>
  </div>
</header>

<main class="container main-content py-4">

  <?php if(session()->getFlashdata('success')): ?>
    <div class="alert alert-success rounded-3"><?= session()->getFlashdata('success'); ?></div>
  <?php endif; ?>

  <?php if(session()->getFlashdata('error')): ?>
    <div class="alert alert-danger rounded-3"><?= session()->getFlashdata('error'); ?></div>
  <?php endif; ?>

  <div class="mb-4 p-3 bg-white rounded-3 shadow-sm d-flex justify-content-between align-items-center">
    <div>
      <h5 class="fw-bold mb-1">Ringkasan Sistem</h5>
      <p class="mb-0">Data menampilkan kondisi akun Ketua PKK dan pendaftaran yang perlu dipantau admin pusat.</p>
    </div>
    <div>
      <?php if(($total_user_pending ?? 0) > 0): ?>
        <span class="badge bg-warning text-dark px-3 py-2"><?= esc($total_user_pending); ?> pendaftaran menunggu persetujuan</span>
      <?php else: ?>
        <span class="badge bg-success px-3 py-2">Tidak ada pendaftaran pending</span>
      <?php endif; ?>
    </div>
  </div>

  <!-- Stat Cards -->
  <div class="row g-4 mb-5">
    <div class="col-md-4">
      <div class="stat-card d-flex flex-column h-100">
        <div class="d-flex justify-content-between align-items-start mb-3">
          <div>
            <div class="text-uppercase fw-bold text-muted" style="font-size:13px;">Desa Aktif</div>
            <p class="h3 fw-bold mb-0"><?= esc($total_desa ?? 0); ?></p>
          </div>
          <div class="stat-icon text-primary" style="background:#eff6ff;"><i class="bi bi-geo-alt"></i></div>
        </div>
        <p class="text-muted small mb-0">Desa yang memiliki akun Ketua PKK aktif.</p>
      </div>
    </div>

    <div class="col-md-4">
      <div class="stat-card d-flex flex-column h-100">
        <div class="d-flex justify-content-between align-items-start mb-3">
          <div>
            <div class="text-uppercase fw-bold text-muted" style="font-size:13px;">Akun PKK Aktif</div>
            <p class="h3 fw-bold mb-0"><?= esc($total_pkk ?? 0); ?></p>
          </div>
          <div class="stat-icon text-success" style="background:#ecfdf5;"><i class="bi bi-people"></i></div>
        </div>
        <p class="text-muted small mb-0">Akun Ketua PKK yang telah disetujui.</p>
      </div>
    </div>

    <div class="col-md-4">
      <div class="stat-card d-flex flex-column h-100">
        <div class="d-flex justify-content-between align-items-start mb-3">
          <div>
            <div class="text-uppercase fw-bold text-muted" style="font-size:13px;">Pendaftaran Pending</div>
            <p class="h3 fw-bold mb-0"><?= esc($total_user_pending ?? 0); ?></p>
          </div>
          <div class="stat-icon text-warning" style="background:#fff7e6;"><i class="bi bi-person-plus"></i></div>
        </div>
        <p class="text-muted small mb-0">Pendaftar baru yang belum diproses.</p>
      </div>
    </div>
  </div>

  <!-- Menu Cards -->
  <div class="row g-4">
    <div class="col-md-6">
      <div class="menu-card d-flex flex-column h-100 text-center p-4">
        <div class="menu-icon mb-3 text-warning" style="background:#fff7e6;"><i class="bi bi-person-check"></i></div>
        <h5 class="fw-bold mb-2">Persetujuan Akun PKK</h5>
        <p class="text-muted small mb-3">Memeriksa pendaftaran akun Ketua PKK dan menyetujui atau menolak akses.</p>
        <a href="<?= base_url('admin/users/pending'); ?>" class="btn btn-warning w-100">Buka Modul</a>
      </div>
    </div>

    <div class="col-md-6">
      <div class="menu-card d-flex flex-column h-100 text-center p-4">
        <div class="menu-icon mb-3 text-success" style="background:#ecfdf5;"><i class="bi bi-people"></i></div>
        <h5 class="fw-bold mb-2">Akun PKK Aktif</h5>
        <p class="text-muted small mb-3">Melihat daftar akun Ketua PKK aktif, membuka detail profil, dan menghapus akses bila diperlukan.</p>
        <a href="<?= base_url('admin/users'); ?>" class="btn btn-success w-100">Buka Modul</a>
      </div>
    </div>
  </div>

</main>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>