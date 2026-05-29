<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title><?= esc($title ?? 'Persetujuan Pendaftaran Akun PKK'); ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

<style>
  body { background: #f4f7fb; color: #102033; font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif; }
  .page-header { background: linear-gradient(135deg, #0b355c 0%, #0f4c81 100%); color: #fff; padding: 60px 0 50px; border-radius: 0 0 20px 20px; text-align: center; }
  .page-header h1 { font-weight: 800; }
  .page-header p { color: rgba(255,255,255,0.8); }
  .main-card { margin-top: -40px; border-radius: 20px; box-shadow: 0 20px 50px rgba(15,23,42,0.12); background:#fff; }
  .btn { border-radius: 10px; font-weight: 600; }
  .table thead th { font-size: 13px; text-transform: uppercase; color: #475569; letter-spacing: 0.03em; }
  .user-name { font-weight: 800; }
  .muted-small { color: #64748b; font-size: 13px; }
  .contact-link { font-size:13px; text-decoration:none; font-weight:600; }
  .reason-box { max-width:260px; font-size:13px; color:#475569; line-height:1.55; }
  .action-box { min-width:210px; }
  .reject-input { border-radius:8px; font-size:13px; }
  .empty-state { padding:50px 20px; text-align:center; color:#64748b; }
  .empty-icon { width:64px; height:64px; border-radius:20px; background:#eff6ff; color:#0f4c81; display:flex; align-items:center; justify-content:center; font-size:30px; margin-bottom:12px; }
  .info-note { background:#eff6ff; border:1px solid #dbeafe; color:#1e3a8a; border-radius:14px; padding:14px 16px; font-size:14px; margin-bottom:20px; }
  .bottom-navigation { display:flex; justify-content:center; align-items:center; gap:16px; background:#f8fafc; border:1px solid #e5eaf0; border-radius:16px; padding:16px 20px; margin-top:20px; }
  .btn-dashboard-bottom { background:#fff; color:#0f4c81; border:1px solid #cbd5e1; padding:10px 18px; box-shadow:0 6px 15px rgba(15,23,42,0.06); transition:0.2s; }
  .btn-dashboard-bottom:hover { background:#0f4c81; color:#fff; border-color:#0b355c; }
</style>
</head>
<body>

<header class="page-header">
  <div class="container">
    <h1 class="h3 mb-2">Persetujuan Pendaftaran Akun PKK</h1>
    <p class="mb-0">Periksa data pendaftar, hubungi melalui email atau WhatsApp, lalu setujui atau tolak akun.</p>
  </div>
</header>

<main class="container pb-5">
  <div class="card main-card border-0">
    <div class="card-body p-4">

      <?php if (session()->getFlashdata('sukses')): ?>
        <div class="alert alert-success rounded-3"><?= session()->getFlashdata('sukses'); ?></div>
      <?php endif; ?>

      <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger rounded-3"><?= session()->getFlashdata('error'); ?></div>
      <?php endif; ?>

      <div class="info-note">
        <i class="bi bi-info-circle-fill me-1"></i>
        Setelah akun disetujui, admin dapat menghubungi pendaftar via email/WhatsApp agar akun dapat digunakan.
      </div>

      <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
          <thead class="table-light">
            <tr>
              <th style="width: 50px;">No</th>
              <th>Pendaftar</th>
              <th>Kontak</th>
              <th>Wilayah Diajukan</th>
              <th>Jabatan</th>
              <th>Alasan</th>
              <th style="width: 230px;">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php if (empty($users)): ?>
            <tr>
              <td colspan="7">
                <div class="empty-state">
                  <div class="empty-icon"><i class="bi bi-inbox"></i></div>
                  <h6 class="fw-bold mb-1">Tidak ada pendaftaran pending</h6>
                  <p class="mb-0">Semua pendaftaran akun Ketua PKK sudah diproses.</p>
                </div>
              </td>
            </tr>
            <?php endif; ?>

            <?php $no=1; foreach($users as $user): ?>
            <?php
              $email = $user['email'] ?? '';
              $phoneRaw = $user['no_hp'] ?? '';
              $phoneDigits = preg_replace('/[^0-9]/', '', $phoneRaw);
              $phoneWa = (substr($phoneDigits,0,1)=='0')?'62'.substr($phoneDigits,1):$phoneDigits;
              $namaWilayah = $user['requested_nama_desa'] ?? $user['nama_desa'] ?? '-';
              $idWilayah = $user['requested_id_desa'] ?? $user['id_desa'] ?? '-';
            ?>
            <tr>
              <td><?= $no++; ?></td>
              <td>
                <div class="user-name"><?= esc($user['nama_lengkap'] ?? '-'); ?></div>
                <div class="muted-small">Username: <?= esc($user['username'] ?? '-'); ?></div>
                <?php if(!empty($user['registration_code'])): ?>
                <div class="muted-small">Kode: <?= esc($user['registration_code']); ?></div>
                <?php endif; ?>
              </td>
              <td>
                <div class="mb-1"><i class="bi bi-envelope me-1 text-primary"></i>
                  <?php if(!empty($email)): ?><a href="mailto:<?= esc($email); ?>" class="contact-link"><?= esc($email); ?></a><?php else: ?><span class="text-muted">-</span><?php endif; ?>
                </div>
                <div><i class="bi bi-whatsapp me-1 text-success"></i>
                  <?php if(!empty($phoneWa)): ?><a href="https://wa.me/<?= esc($phoneWa); ?>" target="_blank" class="contact-link text-success"><?= esc($phoneRaw); ?></a><?php else: ?><span class="text-muted">-</span><?php endif; ?>
                </div>
              </td>
              <td><strong><?= esc($namaWilayah); ?></strong><div class="muted-small">ID Desa: <?= esc($idWilayah); ?></div></td>
              <td><?= esc($user['jabatan'] ?? '-'); ?></td>
              <td><div class="reason-box"><?= esc($user['alasan_pengajuan'] ?? '-'); ?></div></td>
              <td>
                <div class="action-box">
                  <a href="<?= base_url('admin/users/approve/' . $user['id_user']); ?>" class="btn btn-success btn-sm w-100 mb-2" onclick="return confirm('Setujui akun ini?')"><i class="bi bi-check-circle me-1"></i>Approve</a>
                  <form action="<?= base_url('admin/users/reject/' . $user['id_user']); ?>" method="POST">
                    <?= csrf_field(); ?>
                    <input type="text" name="rejected_reason" class="form-control form-control-sm reject-input mb-2" placeholder="Alasan ditolak">
                    <button type="submit" class="btn btn-outline-danger btn-sm w-100" onclick="return confirm('Tolak akun ini?')"><i class="bi bi-x-circle me-1"></i>Reject</button>
                  </form>
                </div>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>

      <div class="bottom-navigation mt-4">
        <a href="<?= base_url('admin/dashboard'); ?>" class="btn btn-dashboard-bottom"><i class="bi bi-arrow-left-circle me-1"></i>Kembali ke Dashboard</a>
      </div>

    </div>
  </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>