<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Edit Status Pemantauan Lansia'); ?></title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <style>
        :root {
            --bg: #f4f6f9;
            --card: #ffffff;
            --warning: #d97706;
            --warning-dark: #b45309;
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
            background: var(--warning);
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

        .form-control:disabled {
            background: #f3f4f6;
            color: #374151;
            font-weight: 600;
        }

        textarea.form-control {
            min-height: 115px;
            padding-top: 12px;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #fbbf24;
            box-shadow: 0 0 0 0.18rem rgba(217, 119, 6, 0.14);
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
            min-width: 170px;
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

        .btn-warning-custom {
            background: var(--warning);
            border: 1px solid var(--warning);
            color: #ffffff;
        }

        .btn-warning-custom:hover {
            background: var(--warning-dark);
            border-color: var(--warning-dark);
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

<?php
    $idLansia = $lansia['id_lansia'] ?? '';
    $namaLansia = $lansia['nama_lansia'] ?? '-';
    $nik = $lansia['nik'] ?? '-';

    $hobi = old('hobi', $lansia['hobi'] ?? '');
    $produktivitas = old(
        'produktivitas',
        $lansia['produktivitas'] ?? $lansia['produktifitas'] ?? ''
    );
    $keterangan = old('keterangan', $lansia['keterangan'] ?? '');
?>

<div class="page-wrap">
    <div class="main-container">

        <div class="card form-card">
            <div class="card-header">
                <h5>Edit Status Pemantauan Lansia</h5>
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

                <?php if (session()->getFlashdata('error')) : ?>
                    <div class="alert alert-danger">
                        <?= esc(session()->getFlashdata('error')); ?>
                    </div>
                <?php endif; ?>

                <form action="<?= base_url('pkk/lansia/update/' . rawurlencode((string) $idLansia)); ?>" method="post">
                    <?= csrf_field(); ?>

                    <div class="mb-3">
                        <label class="form-label">Nama Lansia</label>
                        <input type="text"
                               class="form-control"
                               value="<?= esc($namaLansia); ?>"
                               disabled>
                        <div class="helper-text">Nama lansia tidak dapat diubah dari halaman edit pemantauan.</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">NIK</label>
                        <input type="text"
                               class="form-control"
                               value="<?= esc($nik); ?>"
                               disabled>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Hobi Lansia</label>
                        <input type="text"
                               name="hobi"
                               class="form-control"
                               value="<?= esc($hobi); ?>"
                               placeholder="Contoh: Berkebun, mengaji, bersepeda"
                               required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status Produktivitas</label>
                        <select name="produktivitas" class="form-select" required>
                            <option value="" disabled <?= $produktivitas == '' ? 'selected' : ''; ?>>Pilih status produktivitas</option>
                            <option value="Produktif" <?= $produktivitas == 'Produktif' ? 'selected' : ''; ?>>Produktif</option>
                            <option value="Non-Produktif" <?= $produktivitas == 'Non-Produktif' ? 'selected' : ''; ?>>Non-Produktif</option>
                        </select>
                        <div class="helper-text">
                            Pilih produktif jika lansia masih aktif berkegiatan atau bekerja ringan.
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Catatan Tambahan</label>
                        <textarea name="keterangan"
                                  class="form-control"
                                  rows="4"
                                  placeholder="Contoh: Aktif posyandu, riwayat hipertensi, perlu pemantauan rutin"><?= esc($keterangan); ?></textarea>
                    </div>

                    <div class="divider"></div>

                    <div class="action-row">
                        <a href="<?= base_url('pkk/lansia'); ?>" class="btn btn-light-custom btn-action">Batal</a>
                        <button type="submit" class="btn btn-warning-custom btn-action">Simpan Perubahan</button>
                    </div>
                </form>

            </div>
        </div>

        <div class="back-button-wrap">
            <a href="<?= base_url('pkk/lansia'); ?>" class="btn-back-professional">
                <i class="bi bi-arrow-left-circle"></i>
                Kembali ke Daftar Lansia
            </a>
        </div>

    </div>
</div>

</body>
</html>