<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title><?= esc($title ?? 'Daftar Akun Ketua PKK Desa'); ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">

<style>
body {
    min-height: 100vh;
    background: #f4f7fb;
    color: #102033;
    font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
}
.page-header {
    background: linear-gradient(135deg, #0b355c 0%, #0f4c81 100%);
    color: #fff;
    padding: 52px 0 72px;
    text-align: center;
    border-radius: 0 0 20px 20px;
}
.page-header h1 { font-weight: 800; }
.page-header p { color: rgba(255,255,255,0.74); max-width: 680px; margin:0 auto; }

.register-card {
    margin-top: -48px;
    border-radius: 24px;
    box-shadow: 0 22px 60px rgba(15,23,42,0.12);
    background:#fff;
}

.section-label { font-size: 13px; text-transform: uppercase; font-weight:700; color:#64748b; margin-bottom:16px; }
.form-control, .form-select { border-radius:13px; padding:11px 13px; border-color:#d8e0ea; }
.form-control:focus, .form-select:focus { border-color:#0f4c81; box-shadow:0 0 0 0.2rem rgba(15,76,129,0.14); }
.password-wrapper { position: relative; }
.password-wrapper .form-control { padding-right:48px; }
.toggle-password {
    position:absolute; top:50%; right:14px; transform:translateY(-50%);
    border:0; background:transparent; font-size:18px; cursor:pointer; color:#64748b;
}
.toggle-password:hover { color:#0f4c81; }

.btn-primary { background:#0f4c81; border-color:#0f4c81; border-radius:13px; padding:12px 14px; font-weight:700; }
.btn-primary:hover { background:#0b355c; border-color:#0b355c; }

.info-box { background:#eff6ff; border:1px solid #dbeafe; color:#1e3a8a; border-radius:16px; padding:14px 16px; font-size:14px; margin-bottom:16px; }

</style>
</head>

<body>

<header class="page-header">
<div class="container text-center">
<h1>Daftar Akun Ketua PKK Desa</h1>
<p>Lengkapi data akun dan wilayah tugas. Akun akan aktif setelah diverifikasi admin pusat.</p>
</div>
</header>

<main class="container pb-5">
<div class="row justify-content-center">
<div class="col-lg-8">

<div class="card register-card border-0">
<div class="card-body p-4 p-md-5">

<?php if(session()->getFlashdata('error')): ?>
<div class="alert alert-danger rounded-3"><?= session()->getFlashdata('error'); ?></div>
<?php endif; ?>

<form action="<?= base_url('register/store'); ?>" method="POST">
<?= csrf_field(); ?>

<div class="section-label"><i class="bi bi-person-badge me-1"></i>Data Akun</div>

<div class="mb-3">
<label class="form-label">Nama Lengkap</label>
<input type="text" name="nama_lengkap" class="form-control" value="<?= old('nama_lengkap'); ?>" placeholder="Masukkan nama lengkap" required>
</div>

<div class="mb-3">
<label class="form-label">Email Aktif</label>
<input type="email" name="email" class="form-control" value="<?= old('email'); ?>" placeholder="contoh@gmail.com" required>
<div class="form-text">Email digunakan admin untuk menghubungi Anda setelah verifikasi.</div>
</div>

<div class="mb-3">
<label class="form-label">Nomor HP / WhatsApp Aktif</label>
<input type="text" name="no_hp" class="form-control" value="<?= old('no_hp'); ?>" placeholder="Contoh: 081234567890" required>
<div class="form-text">Nomor digunakan untuk pemberitahuan hasil persetujuan akun.</div>
</div>

<div class="mb-3">
<label class="form-label">Username</label>
<input type="text" name="username" class="form-control" value="<?= old('username'); ?>" placeholder="Contoh: pkk_kemuning" required>
<div class="form-text">Gunakan huruf kecil, angka, atau underscore. Hindari spasi.</div>
</div>

<div class="row g-3 mb-3">
<div class="col-md-6">
<label class="form-label">Password</label>
<div class="password-wrapper">
<input type="password" id="password" name="password" class="form-control" placeholder="Minimal 5 karakter" required>
<button type="button" class="toggle-password" onclick="togglePassword('password','passwordIcon')"><i class="bi bi-eye" id="passwordIcon"></i></button>
</div>
</div>

<div class="col-md-6">
<label class="form-label">Konfirmasi Password</label>
<div class="password-wrapper">
<input type="password" id="passwordConfirm" name="password_confirm" class="form-control" placeholder="Ulangi password" required>
<button type="button" class="toggle-password" onclick="togglePassword('passwordConfirm','passwordConfirmIcon')"><i class="bi bi-eye" id="passwordConfirmIcon"></i></button>
</div>
</div>
</div>

<hr class="my-4">

<div class="section-label"><i class="bi bi-geo-alt me-1"></i>Wilayah Tugas</div>

<div class="mb-3">
<label class="form-label">Provinsi</label>
<select id="provinsi" class="form-select" required>
<option value="">-- Memuat Provinsi... --</option>
</select>
</div>

<div class="mb-3">
<label class="form-label">Kabupaten / Kota</label>
<select id="kabupaten" class="form-select" required disabled>
<option value="">-- Pilih Kabupaten / Kota --</option>
</select>
</div>

<div class="mb-3">
<label class="form-label">Kecamatan</label>
<select id="kecamatan" class="form-select" required disabled>
<option value="">-- Pilih Kecamatan --</option>
</select>
</div>

<div class="mb-3">
<label class="form-label">Desa / Kelurahan</label>
<select id="desa" name="id_desa" class="form-select" required disabled>
<option value="">-- Pilih Desa / Kelurahan --</option>
</select>
<div class="form-text">Pilih wilayah desa yang menjadi tanggung jawab Anda.</div>
</div>

<input type="hidden" id="nama_desa" name="nama_desa">

<hr class="my-4">

<div class="mb-3">
<label class="form-label">Jabatan / Keterangan</label>
<input type="text" name="jabatan" class="form-control" placeholder="Contoh: Ketua PKK Desa Kemuning" value="<?= old('jabatan'); ?>" required>
</div>

<div class="mb-4">
<label class="form-label">Alasan Pengajuan Akun</label>
<textarea name="alasan_pengajuan" class="form-control" rows="4" placeholder="Tuliskan alasan pengajuan akun secara singkat" required><?= old('alasan_pengajuan'); ?></textarea>
</div>

<div class="info-box mb-4"><i class="bi bi-info-circle me-1"></i>Setelah formulir dikirim, admin pusat akan memeriksa data Anda. Informasi persetujuan akan disampaikan melalui email atau nomor HP/WhatsApp.</div>

<button type="submit" class="btn btn-primary w-100">Ajukan Pendaftaran</button>

<div class="text-center mt-4"><span class="text-muted">Sudah punya akun?</span> <a href="<?= base_url('login'); ?>" class="fw-semibold text-decoration-none">Masuk</a></div>

<div class="text-center mt-3"><a href="<?= base_url('/'); ?>" class="text-decoration-none fw-semibold text-secondary">Kembali ke Beranda</a></div>

</form>
</div>
</div>
</div>
</div>
</main>

<script>
function togglePassword(inputId, iconId) {
    const input = document.getElementById(inputId);
    const icon = document.getElementById(iconId);
    if(input.type==='password'){ input.type='text'; icon.classList.replace('bi-eye','bi-eye-slash'); } 
    else{ input.type='password'; icon.classList.replace('bi-eye-slash','bi-eye'); }
}

// Dynamic wilayah dropdown
document.addEventListener("DOMContentLoaded",function(){
    const provSelect = document.getElementById('provinsi');
    const kabSelect = document.getElementById('kabupaten');
    const kecSelect = document.getElementById('kecamatan');
    const desaSelect = document.getElementById('desa');
    const namaDesaInput = document.getElementById('nama_desa');
    const appUrl = '<?= base_url('wilayah/proxy'); ?>';

    fetch(`${appUrl}?endpoint=provinces`).then(res=>res.json()).then(provinces=>{
        provSelect.innerHTML='<option value="">-- Pilih Provinsi --</option>';
        provinces.forEach(prov=>{ let opt=document.createElement('option'); opt.value=prov.id; opt.text=prov.name; provSelect.add(opt); });
    });

    provSelect.addEventListener('change',function(){
        kabSelect.innerHTML='<option value="">-- Pilih Kabupaten / Kota --</option>';
        kecSelect.innerHTML='<option value="">-- Pilih Kecamatan --</option>';
        desaSelect.innerHTML='<option value="">-- Pilih Desa / Kelurahan --</option>';
        namaDesaInput.value=''; kabSelect.disabled=true; kecSelect.disabled=true; desaSelect.disabled=true;
        if(this.value){
            fetch(`${appUrl}?endpoint=regencies&id=${this.value}`).then(res=>res.json()).then(regencies=>{
                regencies.forEach(kab=>{ let opt=document.createElement('option'); opt.value=kab.id; opt.text=kab.name; kabSelect.add(opt); });
                kabSelect.disabled=false;
            });
        }
    });

    kabSelect.addEventListener('change',function(){
        kecSelect.innerHTML='<option value="">-- Pilih Kecamatan --</option>';
        desaSelect.innerHTML='<option value="">-- Pilih Desa / Kelurahan --</option>';
        namaDesaInput.value=''; kecSelect.disabled=true; desaSelect.disabled=true;
        if(this.value){
            fetch(`${appUrl}?endpoint=districts&id=${this.value}`).then(res=>res.json()).then(districts=>{
                districts.forEach(kec=>{ let opt=document.createElement('option'); opt.value=kec.id; opt.text=kec.name; kecSelect.add(opt); });
                kecSelect.disabled=false;
            });
        }
    });

    kecSelect.addEventListener('change',function(){
        desaSelect.innerHTML='<option value="">-- Pilih Desa / Kelurahan --</option>';
        namaDesaInput.value=''; desaSelect.disabled=true;
        if(this.value){
            fetch(`${appUrl}?endpoint=villages&id=${this.value}`).then(res=>res.json()).then(villages=>{
                villages.forEach(desa=>{ let opt=document.createElement('option'); opt.value=desa.id; opt.text=desa.name; opt.dataset.nama=desa.name; desaSelect.add(opt); });
                desaSelect.disabled=false;
            });
        }
    });

    desaSelect.addEventListener('change',function(){
        namaDesaInput.value=this.options[this.selectedIndex].dataset.nama||'';
    });
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>