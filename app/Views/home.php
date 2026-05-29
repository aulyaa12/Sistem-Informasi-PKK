<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Sistem Informasi Data PKK Desa</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">

<style>
body { min-height:100vh; display:flex; flex-direction:column; font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif; }
.navbar-brand img { height:40px; }
.card-hover { transition: transform 0.2s, box-shadow 0.2s; }
.card-hover:hover { transform: translateY(-5px); box-shadow:0 12px 25px rgba(0,0,0,0.15); }
header.bg-success { background: linear-gradient(135deg,#0b355c,#0f4c81); color: #fff; }
.hero-img { max-width:100%; border-radius:20px; box-shadow:0 10px 30px rgba(0,0,0,0.1); }
section h2 { font-weight:700; margin-bottom:2rem; }
section .card { border-radius:16px; box-shadow:0 6px 20px rgba(0,0,0,0.05); }
.btn-lg { border-radius:14px; font-weight:600; }
footer { font-size:14px; }
main { flex:1; }
</style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top shadow-sm">
  <div class="container">
    <a class="navbar-brand" href="<?= base_url('/') ?>">
      <img src="<?= base_url('logo_pkk_transparan.png') ?>" alt="Logo PKK">
      Sistem PKK Desa
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto align-items-center">
        <li class="nav-item"><a class="nav-link" href="#fitur">Fitur</a></li>
        <li class="nav-item"><a class="nav-link" href="#alur">Alur Kerja</a></li>
        <li class="nav-item"><a class="btn btn-primary ms-2" href="<?= base_url('login') ?>">Masuk</a></li>
      </ul>
    </div>
  </div>
</nav>

<!-- HERO -->
<header class="py-5 bg-success">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-md-6 text-light">
        <h1>Data PKK Desa <br><em>lebih rapi, siap direkap.</em></h1>
        <p>Kelola data penduduk, kelahiran, kematian, dan lansia dalam satu sistem yang aman, mudah, dan profesional.</p>
        <a href="<?= base_url('register') ?>" class="btn btn-light btn-lg me-2"><i class="bi bi-person-plus"></i> Daftar Akun PKK</a>
        <a href="#fitur" class="btn btn-outline-light btn-lg"><i class="bi bi-grid-3x3-gap"></i> Lihat Fitur</a>
      </div>
      <div class="col-md-6 text-center">
        <img src="<?= base_url('gambarpkk.png') ?>" alt="Ilustrasi PKK Desa" class="hero-img">
      </div>
    </div>
  </div>
</header>

<!-- FEATURES -->
<section id="fitur" class="py-5">
  <div class="container">
    <h2>Empat modul untuk satu tujuan: data desa rapi</h2>
    <div class="row g-4">
      <div class="col-md-3">
        <div class="card h-100 card-hover">
          <div class="card-body">
            <h5>Data Penduduk</h5>
            <p>NIK, nama lengkap, alamat, RT, pekerjaan, pendidikan, dan status pernikahan warga desa.</p>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card h-100 card-hover">
          <div class="card-body">
            <h5>Data Kelahiran</h5>
            <p>Catatan kelahiran bayi berdasarkan data ibu, tanggal lahir, berat badan, tenaga penolong persalinan.</p>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card h-100 card-hover">
          <div class="card-body">
            <h5>Data Kematian</h5>
            <p>Laporan kematian warga, tanggal, lokasi, dan keterangan untuk pembaruan arsip desa.</p>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card h-100 card-hover">
          <div class="card-body">
            <h5>Data Lansia</h5>
            <p>Pemantauan hobi, produktivitas, dan kondisi kesehatan warga lanjut usia di seluruh RT.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- HOW IT WORKS -->
<section id="alur" class="py-5 bg-light">
  <div class="container">
    <h2>Tiga langkah mulai mengelola data</h2>
    <div class="row g-4">
      <div class="col-md-4">
        <div class="card text-center p-3 card-hover">
          <div class="card-body">
            <h5>1. Daftar Akun PKK</h5>
            <p>Isi data akun, pilih wilayah desa, dan kirim permintaan. Proses cepat tanpa dokumen tambahan.</p>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card text-center p-3 card-hover">
          <div class="card-body">
            <h5>2. Diverifikasi Admin</h5>
            <p>Admin wilayah memeriksa dan menyetujui akun baru. Notifikasi dikirim setelah verifikasi selesai.</p>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card text-center p-3 card-hover">
          <div class="card-body">
            <h5>3. Kelola Data Desa</h5>
            <p>Akses empat modul, lihat grafik statistik, dan unduh rekap Excel kapan saja.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- CTA -->
<section class="py-5 text-white text-center" style="background: linear-gradient(135deg,#0b355c,#0f4c81);">
  <div class="container d-flex flex-column align-items-center">
    <h2 class="fw-bold mb-2">Siap digitalisasi data desa Anda?</h2>
    <p class="mb-4" style="max-width:600px;">
      Daftar akun PKK dan mulai kelola data warga secara terstruktur, aman, dan efisien.
    </p>
    <div class="d-flex flex-column flex-md-row gap-2">
      <a href="<?= base_url('register') ?>" class="btn btn-light btn-lg w-100 w-md-auto">
        <i class="bi bi-person-plus"></i> Daftar Akun PKK
      </a>
      <a href="<?= base_url('login') ?>" class="btn btn-outline-light btn-lg w-100 w-md-auto">
        <i class="bi bi-box-arrow-in-right"></i> Sudah punya akun
      </a>
    </div>
  </div>
</section>

<!-- FOOTER -->
<footer class="bg-dark text-white py-4 mt-auto">
  <div class="container d-flex flex-column flex-md-row justify-content-between align-items-center">
    <span>&copy; <?= date('Y') ?> Sistem Informasi Data PKK Desa. Hak cipta dilindungi.</span>
    <a href="<?= base_url('admin/login') ?>" class="text-white mt-2 mt-md-0">Admin</a>
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>