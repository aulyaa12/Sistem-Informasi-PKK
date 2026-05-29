<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Tambah Data Penduduk'); ?></title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <style>
        :root {
            --bg: #f4f6f9;
            --card: #ffffff;
            --primary: #2563eb;
            --primary-dark: #1d4ed8;
            --text: #111827;
            --muted: #6b7280;
            --border: #d1d5db;
            --soft: #f3f4f6;
        }

        * {
            box-sizing: border-box;
        }

        body {
            background: var(--bg);
            font-family: Arial, Helvetica, sans-serif;
            color: var(--text);
            margin: 0;
        }

        .page-wrap {
            padding: 32px 12px 48px;
        }

        .main-container {
            max-width: 760px;
            margin: 0 auto;
        }

        .form-card {
            border: none;
            border-radius: 18px;
            overflow: hidden;
            background: var(--card);
            box-shadow: 0 8px 24px rgba(15, 23, 42, 0.08);
        }

        .form-card .card-header {
            background: var(--primary);
            border: none;
            padding: 18px 24px;
        }

        .form-card .card-header h5 {
            margin: 0;
            color: #ffffff;
            font-size: 1.2rem;
            font-weight: 700;
        }

        .form-card .card-body {
            padding: 28px;
        }

        .form-label {
            font-size: 0.95rem;
            font-weight: 700;
            color: var(--text);
            margin-bottom: 8px;
        }

        .form-control,
        .form-select {
            min-height: 46px;
            border-radius: 10px;
            border: 1px solid var(--border);
            font-size: 0.95rem;
            color: #111827;
            padding-left: 14px;
            padding-right: 14px;
        }

        textarea.form-control {
            min-height: 115px;
            padding-top: 12px;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #93c5fd;
            box-shadow: 0 0 0 0.18rem rgba(37, 99, 235, 0.12);
        }

        .helper-text {
            font-size: 0.82rem;
            color: var(--muted);
            margin-top: 5px;
        }

        .alert {
            border-radius: 12px;
            font-size: 0.95rem;
            margin-bottom: 20px;
        }

        .alert ul {
            margin-bottom: 0;
        }

        .divider {
            margin: 24px 0 0;
            border-top: 1px solid #e5e7eb;
        }

        .action-row {
            display: flex;
            justify-content: flex-end;
            gap: 12px;
            margin-top: 24px;
            flex-wrap: wrap;
        }

        .btn-action {
            min-width: 140px;
            border-radius: 10px;
            font-weight: 700;
            font-size: 0.95rem;
            padding: 10px 18px;
        }

        .btn-light-custom {
            background: var(--soft);
            border: 1px solid var(--border);
            color: var(--text);
        }

        .btn-light-custom:hover {
            background: #e5e7eb;
            color: var(--text);
        }

        .btn-primary-custom {
            background: var(--primary);
            border: 1px solid var(--primary);
            color: #ffffff;
        }

        .btn-primary-custom:hover {
            background: var(--primary-dark);
            border-color: var(--primary-dark);
            color: #ffffff;
        }

        .back-button-wrap {
            margin-top: 24px;
            display: flex;
            justify-content: center;
        }

        .btn-back-professional {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 14px 28px;
            border-radius: 18px;
            border: 1.5px solid #bfd0e4;
            background: #ffffff;
            color: #1d4f8c;
            font-size: 1.03rem;
            font-weight: 700;
            text-decoration: none;
            box-shadow: 0 4px 14px rgba(15, 23, 42, 0.05);
            transition: all 0.2s ease;
        }

        .btn-back-professional:hover {
            background: #f8fbff;
            color: #163e6d;
            border-color: #9fb9d6;
            transform: translateY(-1px);
        }

        .btn-back-professional i {
            font-size: 1.1rem;
            line-height: 1;
        }

        @media (max-width: 767.98px) {
            .page-wrap {
                padding: 18px 10px 32px;
            }

            .main-container {
                max-width: 100%;
            }

            .form-card {
                border-radius: 14px;
            }

            .form-card .card-header {
                padding: 15px 18px;
            }

            .form-card .card-header h5 {
                font-size: 1rem;
                line-height: 1.4;
            }

            .form-card .card-body {
                padding: 18px;
            }

            .form-label {
                font-size: 0.92rem;
            }

            .form-control,
            .form-select {
                min-height: 44px;
                font-size: 0.93rem;
            }

            .action-row {
                flex-direction: column;
                align-items: stretch;
            }

            .btn-action {
                width: 100%;
                min-width: 100%;
            }

            .btn-back-professional {
                width: 100%;
                font-size: 0.98rem;
                padding: 13px 16px;
                border-radius: 16px;
            }
        }

        @media (max-width: 575.98px) {
            .page-wrap {
                padding: 14px 8px 28px;
            }

            .form-card .card-body {
                padding: 16px;
            }

            .helper-text {
                font-size: 0.78rem;
            }
        }
    </style>
</head>
<body>

<div class="page-wrap">
    <div class="main-container">

        <div class="card form-card">
            <div class="card-header">
                <h5>Tambah Data Penduduk Baru</h5>
            </div>

            <div class="card-body">

                <?php if (session()->getFlashdata('errors')) : ?>
                    <div class="alert alert-danger">
                        <strong>Data belum valid:</strong>
                        <ul class="mt-2 ps-3">
                            <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                                <li><?= esc($error); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <form action="<?= base_url('pkk/penduduk/store'); ?>" method="post">
                    <?= csrf_field(); ?>

                    <div class="mb-3">
                        <label class="form-label">Nomor Induk Kependudukan (NIK)</label>
                        <input type="text" name="nik" class="form-control" maxlength="16" value="<?= esc(old('nik')); ?>" required placeholder="Masukkan 16 digit NIK">
                        <div class="helper-text">Wajib 16 digit angka.</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nomor Kartu Keluarga (No. KK)</label>
                        <input type="text" name="no_kk" class="form-control" maxlength="16" value="<?= esc(old('no_kk')); ?>" required placeholder="Masukkan 16 digit nomor KK">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" name="nama" class="form-control" value="<?= esc(old('nama')); ?>" required placeholder="Masukkan nama lengkap">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Jenis Kelamin</label>
                        <select name="jenis_kelamin" class="form-select" required>
                            <option value="" disabled <?= old('jenis_kelamin') == '' ? 'selected' : ''; ?>>Pilih jenis kelamin</option>
                            <option value="L" <?= old('jenis_kelamin') == 'L' ? 'selected' : ''; ?>>Laki-laki</option>
                            <option value="P" <?= old('jenis_kelamin') == 'P' ? 'selected' : ''; ?>>Perempuan</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tempat Lahir</label>
                        <input type="text" name="tempat_lahir" class="form-control" value="<?= esc(old('tempat_lahir')); ?>" required placeholder="Contoh: Ternate">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tanggal Lahir</label>
                        <input type="date" name="tgl_lahir" class="form-control" value="<?= esc(old('tgl_lahir')); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Alamat Jalan / Dusun</label>
                        <textarea name="alamat" class="form-control" rows="4" required placeholder="Masukkan alamat lengkap"><?= esc(old('alamat')); ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">RT</label>
                        <input type="number" name="RT" class="form-control" value="<?= esc(old('RT')); ?>" required placeholder="Contoh: 01">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Pekerjaan</label>
                        <input type="text" name="pekerjaan" class="form-control" value="<?= esc(old('pekerjaan')); ?>" required placeholder="Contoh: Petani, Wiraswasta, IRT">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status Pernikahan</label>
                        <select name="status_pernikahan" class="form-select" required>
                            <option value="" disabled <?= old('status_pernikahan') == '' ? 'selected' : ''; ?>>Pilih status pernikahan</option>
                            <option value="belum_kawin" <?= old('status_pernikahan') == 'belum_kawin' ? 'selected' : ''; ?>>Belum Kawin</option>
                            <option value="kawin" <?= old('status_pernikahan') == 'kawin' ? 'selected' : ''; ?>>Kawin</option>
                            <option value="cerai_hidup" <?= old('status_pernikahan') == 'cerai_hidup' ? 'selected' : ''; ?>>Cerai Hidup</option>
                            <option value="cerai_mati" <?= old('status_pernikahan') == 'cerai_mati' ? 'selected' : ''; ?>>Cerai Mati</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Pendidikan Terakhir</label>
                        <input type="text" name="pendidikan" class="form-control" value="<?= esc(old('pendidikan')); ?>" required placeholder="Contoh: SMA, S1, Tidak Sekolah">
                    </div>

                    <div class="divider"></div>

                    <div class="action-row">
                        <button type="reset" class="btn btn-light-custom btn-action">Reset</button>
                        <button type="submit" class="btn btn-primary-custom btn-action">Simpan Data</button>
                    </div>
                </form>

            </div>
        </div>

        <div class="back-button-wrap">
            <a href="<?= base_url('pkk/penduduk'); ?>" class="btn-back-professional">
                <i class="bi bi-arrow-left-circle"></i>
                Kembali ke Daftar Penduduk
            </a>
        </div>

    </div>
</div>

</body>
</html>