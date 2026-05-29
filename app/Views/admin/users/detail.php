<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= esc($title ?? 'Detail Akun PKK'); ?></title>

<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">

<style>
body { background:#f4f7fb; color:#102033; font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif; }
.page-header { background: linear-gradient(135deg,#0b355c 0%,#0f4c81 100%); color:#fff; padding:60px 0 50px; border-radius:0 0 20px 20px; text-align:center; }
.page-header h1 { font-weight:800; }
.page-header p { color:rgba(255,255,255,0.8); }
.main-card { margin-top:-40px; border-radius:20px; box-shadow:0 20px 50px rgba(15,23,42,0.12); background:#fff; }
.profile-icon { width:72px; height:72px; border-radius:22px; background:#eff6ff; color:#0f4c81; display:flex; align-items:center; justify-content:center; font-size:36px; }
.status-badge { background:#ecfdf5; color:#047857; border:1px solid #bbf7d0; font-weight:700; border-radius:999px; padding:7px 12px; font-size:12px; }
.role-badge { background:#eff6ff; color:#0f4c81; border:1px solid #dbeafe; font-weight:700; border-radius:999px; padding:7px 12px; font-size:12px; }
.section-title { font-weight:800; font-size:16px; margin-bottom:16px; }
.info-box { border:1px solid #e5eaf0; border-radius:18px; padding:20px; background:#fff; height:100%; }
.info-row { margin-bottom:15px; }
.info-row:last-child { margin-bottom:0; }
.info-label { color:#64748b; font-size:13px; font-weight:700; text-transform:uppercase; letter-spacing:0.03em; margin-bottom:4px; }
.info-value { font-weight:600; color:#102033; word-break:break-word; }
.contact-link { color:#0f4c81; text-decoration:none; font-weight:600; }
.contact-link:hover { text-decoration:underline; }
.note-box { background:#fff7e6; border:1px solid #fed7aa; color:#92400e; border-radius:16px; padding:16px; font-size:14px; line-height:1.65; margin-bottom:20px; }
.bottom-navigation { display:flex; justify-content:center; align-items:center; background:#f8fafc; border:1px solid #e5eaf0; border-radius:18px; padding:18px 20px; margin-top:24px; }
.btn-back-bottom { background:#fff; color:#0f4c81; border:1px solid #cbd5e1; padding:10px 20px; border-radius:12px; font-weight:700; box-shadow:0 8px 20px rgba(15,23,42,0.06); transition:0.2s ease; }
.btn-back-bottom:hover { background:#0f4c81; color:#fff; border-color:#0b355c; transform:translateY(-1px); box-shadow:0 12px 26px rgba(15,76,129,0.22); }
</style>
</head>

<body>

<header class="page-header">
<div class="container text-center">
<h1 class="h3 mb-2">Detail Akun PKK</h1>
<p>Profil lengkap akun Ketua PKK berdasarkan data pendaftaran dan persetujuan admin.</p>
</div>
</header>

<main class="container pb-5">
<div class="card main-card border-0">
<div class="card-body p-4 p-md-5">

<div class="d-flex align-items-start justify-content-between flex-wrap gap-3 mb-4">
<div class="d-flex align-items-center gap-3">
<div class="profile-icon"><i class="bi bi-person-badge"></i></div>
<div>
<h4 class="fw-bold mb-1"><?= esc($user['nama_lengkap'] ?? '-'); ?></h4>
<div class="text-muted">@<?= esc($user['username'] ?? '-'); ?></div>
<div class="mt-2">
<span class="role-badge me-2"><?= esc(strtoupper(str_replace('_',' ',$user['role']??''))); ?></span>
<span class="status-badge"><?= esc(strtoupper($user['status']??'')); ?></span>
</div>
</div>
</div>
<a href="<?= base_url('admin/users/delete/' . ($user['id_user'] ?? 0)); ?>" class="btn btn-outline-danger" onclick="return confirm('Hapus akun ini? Akun tidak akan bisa login lagi setelah dihapus.')"><i class="bi bi-trash me-1"></i>Hapus Akun</a>
</div>

<div class="row g-4 mb-4">
<div class="col-lg-6">
<div class="info-box">
<h6 class="section-title"><i class="bi bi-person-lines-fill text-primary me-1"></i>Data Akun</h6>
<div class="info-row"><div class="info-label">ID User</div><div class="info-value"><?= esc($user['id_user']??'-'); ?></div></div>
<div class="info-row"><div class="info-label">Nama Lengkap</div><div class="info-value"><?= esc($user['nama_lengkap']??'-'); ?></div></div>
<div class="info-row"><div class="info-label">Username</div><div class="info-value"><?= esc($user['username']??'-'); ?></div></div>
<div class="info-row"><div class="info-label">Email Aktif</div><div class="info-value"><?php if(!empty($user['email'])):?><a href="mailto:<?= esc($user['email']); ?>" class="contact-link"><?= esc($user['email']); ?></a><?php else:?><span class="text-muted">-</span><?php endif;?></div></div>
<div class="info-row"><div class="info-label">Nomor HP / WhatsApp</div><div class="info-value"><?php
$phoneRaw=$user['no_hp']??'';$phoneDigits=preg_replace('/[^0-9]/','',$phoneRaw);$phoneWa=(substr($phoneDigits,0,1)=='0')?'62'.substr($phoneDigits,1):$phoneDigits;?>
<?php if(!empty($phoneWa)):?><a href="https://wa.me/<?= esc($phoneWa); ?>" target="_blank" class="contact-link"><?= esc($phoneRaw); ?></a><?php else:?><span class="text-muted">-</span><?php endif;?></div></div>
</div>
</div>

<div class="col-lg-6">
<div class="info-box">
<h6 class="section-title"><i class="bi bi-geo-alt-fill text-primary me-1"></i>Data Wilayah</h6>
<div class="info-row"><div class="info-label">Desa Aktif</div><div class="info-value"><?= esc($user['nama_desa']??'-'); ?></div></div>
<div class="info-row"><div class="info-label">ID Desa Aktif</div><div class="info-value"><?= esc($user['id_desa']??'-'); ?></div></div>
<div class="info-row"><div class="info-label">Desa Saat Pendaftaran</div><div class="info-value"><?= esc($user['requested_nama_desa']??$user['nama_desa']??'-'); ?></div></div>
<div class="info-row"><div class="info-label">ID Desa Saat Pendaftaran</div><div class="info-value"><?= esc($user['requested_id_desa']??$user['id_desa']??'-'); ?></div></div>
</div>
</div>
</div>

<div class="row g-4 mb-4">
<div class="col-lg-6">
<div class="info-box">
<h6 class="section-title"><i class="bi bi-clipboard-check text-primary me-1"></i>Data Pengajuan</h6>
<div class="info-row"><div class="info-label">Jabatan / Keterangan</div><div class="info-value"><?= esc($user['jabatan']??'-'); ?></div></div>
<div class="info-row"><div class="info-label">Alasan Pengajuan Akun</div><div class="info-value"><?= esc($user['alasan_pengajuan']??'-'); ?></div></div>
<div class="info-row"><div class="info-label">Kode Registrasi</div><div class="info-value"><?= esc($user['registration_code']??'-'); ?></div></div>
<div class="info-row"><div class="info-label">Tanggal Daftar</div><div class="info-value"><?= esc($user['created_at']??'-'); ?></div></div>
</div>
</div>

<div class="col-lg-6">
<div class="info-box">
<h6 class="section-title"><i class="bi bi-shield-check text-primary me-1"></i>Data Persetujuan</h6>
<div class="info-row"><div class="info-label">Disetujui Oleh</div><div class="info-value"><?= esc($user['approved_by_nama']??$user['approved_by_username']??'-'); ?></div></div>
<div class="info-row"><div class="info-label">ID Admin</div><div class="info-value"><?= esc($user['approved_by']??'-'); ?></div></div>
<div class="info-row"><div class="info-label">Tanggal Disetujui</div><div class="info-value"><?= esc($user['approved_at']??'-'); ?></div></div>
<div class="info-row"><div class="info-label">Terakhir Diperbarui</div><div class="info-value"><?= esc($user['updated_at']??'-'); ?></div></div>
</div>
</div>
</div>

<div class="note-box">
<i class="bi bi-info-circle-fill me-1"></i>
Halaman ini menampilkan data akun yang sudah disetujui. Untuk pendaftaran yang belum diproses, gunakan modul Persetujuan Akun PKK.
</div>

<div class="bottom-navigation">
<a href="<?= base_url('admin/users'); ?>" class="btn btn-back-bottom"><i class="bi bi-arrow-left-circle me-1"></i>Kembali ke Daftar Akun</a>
</div>

</div>
</div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>