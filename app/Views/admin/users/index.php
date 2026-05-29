<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= esc($title ?? 'Akun PKK Aktif'); ?></title>

<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

<style>
body { background: #f4f7fb; color: #102033; font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif; }
.page-header { background: linear-gradient(135deg,#0b355c 0%,#0f4c81 100%); color: #fff; padding: 60px 0 50px; border-radius: 0 0 20px 20px; text-align: center; }
.page-header h1 { font-weight: 800; }
.page-header p { color: rgba(255,255,255,0.8); }
.main-card { margin-top: -40px; border-radius: 20px; box-shadow: 0 20px 50px rgba(15,23,42,0.12); background:#fff; }
.btn { border-radius: 10px; font-weight: 600; }
.table thead th { font-size: 13px; text-transform: uppercase; color: #475569; letter-spacing: 0.03em; }
.user-name { font-weight: 800; }
.muted-small { color: #64748b; font-size: 13px; }
.contact-link { font-size:13px; text-decoration:none; font-weight:600; }
.status-badge { background:#ecfdf5; color:#047857; border:1px solid #bbf7d0; font-weight:700; border-radius:999px; padding:6px 10px; font-size:12px; }
.role-badge { background:#eff6ff; color:#0f4c81; border:1px solid #dbeafe; font-weight:700; border-radius:999px; padding:6px 10px; font-size:12px; }
.empty-state { padding:50px 20px; text-align:center; color:#64748b; }
.empty-icon { width:64px; height:64px; border-radius:20px; background:#eff6ff; color:#0f4c81; display:flex; align-items:center; justify-content:center; font-size:30px; margin-bottom:12px; }
.summary-box { background:#fff; border:1px solid #e5eaf0; border-radius:18px; padding:16px 18px; box-shadow:0 10px 28px rgba(15,23,42,0.05); margin-bottom:18px; }
.summary-box p { color:#64748b; font-size:14px; margin-bottom:0; line-height:1.6; }
.bottom-navigation { display:flex; justify-content:center; align-items:center; background:#f8fafc; border:1px solid #e5eaf0; border-radius:18px; padding:18px 20px; margin-top:24px; }
.btn-dashboard-bottom { background:#fff; color:#0f4c81; border:1px solid #cbd5e1; padding:10px 20px; border-radius:12px; font-weight:700; box-shadow:0 8px 20px rgba(15,23,42,0.06); transition:0.2s ease; }
.btn-dashboard-bottom:hover { background:#0f4c81; color:#fff; border-color:#0b355c; transform:translateY(-1px); box-shadow:0 12px 26px rgba(15,76,129,0.22); }
.action-buttons { min-width:170px; display:flex; gap:8px; flex-wrap:wrap; }
</style>
</head>

<body>

<header class="page-header">
<div class="container text-center">
<h1 class="h3 mb-2">Akun PKK Aktif</h1>
<p class="mb-0">Daftar akun Ketua PKK yang sudah disetujui dan memiliki akses ke dashboard wilayah desa.</p>
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

<div class="summary-box d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
<div>
<h6 class="fw-bold mb-1">Manajemen Akun Aktif</h6>
<p>Admin dapat memeriksa detail akun yang sudah aktif dan menghapus akses jika diperlukan.</p>
</div>
<span class="badge text-bg-success px-3 py-2"><?= count($users ?? []); ?> akun aktif</span>
</div>

<div class="table-responsive">
<table class="table table-hover align-middle mb-0">
<thead class="table-light">
<tr>
<th style="width: 52px;">No</th>
<th>Akun</th>
<th>Kontak</th>
<th>Wilayah</th>
<th>Role</th>
<th>Status</th>
<th style="width: 180px;">Aksi</th>
</tr>
</thead>
<tbody>
<?php if (empty($users)): ?>
<tr>
<td colspan="7">
<div class="empty-state">
<div class="empty-icon"><i class="bi bi-people"></i></div>
<h6 class="fw-bold mb-1">Belum ada akun PKK aktif</h6>
<p class="mb-0">Akun yang sudah disetujui akan muncul di halaman ini.</p>
</div>
</td>
</tr>
<?php endif; ?>

<?php $no=1; foreach($users as $user): ?>
<?php
$userId = $user['id_user'] ?? null;
$email = $user['email'] ?? '';
$phoneRaw = $user['no_hp'] ?? '';
$phoneDigits = preg_replace('/[^0-9]/','',$phoneRaw);
$phoneWa = (substr($phoneDigits,0,1)=='0')?'62'.substr($phoneDigits,1):$phoneDigits;
?>
<tr>
<td><?= $no++; ?></td>
<td>
<div class="user-name"><?= esc($user['nama_lengkap'] ?? $user['username'] ?? '-'); ?></div>
<div class="muted-small">Username: <?= esc($user['username'] ?? '-'); ?></div>
<div class="muted-small">ID User: <?= esc($userId ?? '-'); ?></div>
</td>
<td>
<div class="mb-1"><i class="bi bi-envelope me-1 text-primary"></i>
<?php if(!empty($email)): ?><a href="mailto:<?= esc($email); ?>" class="contact-link"><?= esc($email); ?></a><?php else: ?><span class="text-muted">-</span><?php endif; ?>
</div>
<div><i class="bi bi-whatsapp me-1 text-success"></i>
<?php if(!empty($phoneWa)): ?><a href="https://wa.me/<?= esc($phoneWa); ?>" target="_blank" class="contact-link text-success"><?= esc($phoneRaw); ?></a><?php else: ?><span class="text-muted">-</span><?php endif; ?>
</div>
</td>
<td><strong><?= esc($user['nama_desa'] ?? 'Belum diatur'); ?></strong><div class="muted-small">ID Desa: <?= esc($user['id_desa'] ?? '-'); ?></div></td>
<td><span class="role-badge"><?= esc(strtoupper(str_replace('_',' ',$user['role'] ?? ''))); ?></span></td>
<td><span class="status-badge">Aktif</span></td>
<td>
<?php if($userId): ?>
<div class="action-buttons">
<a href="<?= base_url('admin/users/detail/'.$userId); ?>" class="btn btn-sm btn-outline-primary"><i class="bi bi-eye me-1"></i>Detail</a>
<a href="<?= base_url('admin/users/delete/'.$userId); ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus akun ini? Akun tidak akan bisa login lagi setelah dihapus.')"><i class="bi bi-trash me-1"></i>Hapus</a>
</div>
<?php else: ?><span class="text-muted small">-</span><?php endif; ?>
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