<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Formulir Pencatatan Kelahiran'); ?></title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <style>
        :root {
            --bg: #f4f6f9;
            --card: #ffffff;
            --success: #16a34a;
            --success-dark: #15803d;
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
            overflow: visible;
            background: var(--card);
            box-shadow: 0 8px 24px rgba(15, 23, 42, 0.08);
        }

        .form-card .card-header {
            background: var(--success);
            border: none;
            padding: 18px 24px;
            border-radius: 18px 18px 0 0;
        }

        .form-card .card-header h5 {
            margin: 0;
            color: #ffffff;
            font-size: 1.2rem;
            font-weight: 700;
        }

        .form-card .card-body {
            padding: 28px;
            background: #ffffff;
            border-radius: 0 0 18px 18px;
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
            border-color: #86efac;
            box-shadow: 0 0 0 0.18rem rgba(22, 163, 74, 0.13);
        }

        .form-control[readonly] {
            background: #f8fafc;
            color: #111827;
            font-weight: 600;
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

        .autocomplete-wrap {
            position: relative;
        }

        .suggestion-box {
            position: absolute;
            left: 0;
            right: 0;
            top: calc(100% + 6px);
            z-index: 50;
            background: #ffffff;
            border: 1px solid #d1d5db;
            border-radius: 12px;
            box-shadow: 0 12px 28px rgba(15, 23, 42, 0.12);
            max-height: 260px;
            overflow-y: auto;
            display: none;
        }

        .suggestion-item {
            padding: 12px 14px;
            cursor: pointer;
            border-bottom: 1px solid #eef2f6;
        }

        .suggestion-item:last-child {
            border-bottom: none;
        }

        .suggestion-item:hover {
            background: #f0fdf4;
        }

        .suggestion-nik {
            font-size: 0.95rem;
            font-weight: 800;
            color: #111827;
            margin-bottom: 3px;
        }

        .suggestion-name {
            font-size: 0.88rem;
            color: #4b5563;
        }

        .suggestion-empty {
            padding: 12px 14px;
            color: #6b7280;
            font-size: 0.9rem;
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

        .btn-success-custom {
            background: var(--success);
            border: 1px solid var(--success);
            color: #ffffff;
        }

        .btn-success-custom:hover {
            background: var(--success-dark);
            border-color: var(--success-dark);
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
                border-radius: 14px 14px 0 0;
            }

            .form-card .card-header h5 {
                font-size: 1rem;
                line-height: 1.4;
            }

            .form-card .card-body {
                padding: 18px;
                border-radius: 0 0 14px 14px;
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

            .suggestion-box {
                max-height: 230px;
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
    $dataIbu = [];

    if (!empty($para_ibu)) {
        foreach ($para_ibu as $ibu) {
            $dataIbu[] = [
                'nik'  => (string) ($ibu['nik'] ?? ''),
                'nama' => (string) ($ibu['nama'] ?? ''),
            ];
        }
    }
?>

<div class="page-wrap">
    <div class="main-container">

        <div class="card form-card">
            <div class="card-header">
                <h5>Formulir Pencatatan Kelahiran</h5>
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

                <form action="<?= base_url('pkk/kelahiran/store'); ?>" method="post">
                    <?= csrf_field(); ?>

                    <input type="hidden" name="berat_badan" value="0">
                    <input type="hidden" name="panjang_badan" value="0">
                    <input type="hidden" name="nama_penolong" value="-">

                    <div class="mb-3 autocomplete-wrap">
                        <label class="form-label">NIK Ibu Kandung</label>
                        <input type="text"
                               name="nik_ibu"
                               id="nik_ibu"
                               class="form-control"
                               maxlength="16"
                               inputmode="numeric"
                               value="<?= esc(old('nik_ibu')); ?>"
                               placeholder="Ketik NIK atau nama ibu"
                               autocomplete="off"
                               required>

                        <div id="suggestionBox" class="suggestion-box"></div>

                        <div class="helper-text">
                            Ketik NIK atau nama ibu. Pilih salah satu saran yang muncul di bawah kolom.
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nama Ibu Kandung</label>
                        <input type="text"
                               id="nama_ibu_otomatis"
                               class="form-control"
                               readonly
                               placeholder="Nama ibu akan muncul otomatis setelah NIK dipilih">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nama Anak / Bayi</label>
                        <input type="text"
                               name="nama_bayi"
                               class="form-control"
                               value="<?= esc(old('nama_bayi')); ?>"
                               placeholder="Masukkan nama lengkap bayi"
                               required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Jenis Kelamin Anak</label>
                        <select name="jenis_kelamin" class="form-select" required>
                            <option value="" disabled <?= old('jenis_kelamin') == '' ? 'selected' : ''; ?>>Pilih jenis kelamin</option>
                            <option value="L" <?= old('jenis_kelamin') == 'L' ? 'selected' : ''; ?>>Laki-laki</option>
                            <option value="P" <?= old('jenis_kelamin') == 'P' ? 'selected' : ''; ?>>Perempuan</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tanggal Lahir</label>
                        <input type="date"
                               name="tgl_lahir"
                               class="form-control"
                               value="<?= esc(old('tgl_lahir')); ?>"
                               required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tempat Kelahiran</label>
                        <input type="text"
                               name="tempat_lahir"
                               class="form-control"
                               value="<?= esc(old('tempat_lahir')); ?>"
                               placeholder="Contoh: Desa Makmur, RS Daerah, Puskesmas"
                               required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Keterangan</label>
                        <textarea name="keterangan"
                                  class="form-control"
                                  rows="4"
                                  placeholder="Contoh: Lahir di RS Daerah, ditolong oleh bidan."><?= esc(old('keterangan')); ?></textarea>
                    </div>

                    <div class="divider"></div>

                    <div class="action-row">
                        <button type="reset" class="btn btn-light-custom btn-action" id="btnReset">Reset</button>
                        <button type="submit" class="btn btn-success-custom btn-action">Simpan Kelahiran</button>
                    </div>
                </form>

            </div>
        </div>

        <div class="back-button-wrap">
            <a href="<?= base_url('pkk/kelahiran'); ?>" class="btn-back-professional">
                <i class="bi bi-arrow-left-circle"></i>
                Kembali ke Daftar Kelahiran
            </a>
        </div>

    </div>
</div>

<script>
const dataIbu = <?= json_encode($dataIbu, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP); ?>;

const nikInput = document.getElementById('nik_ibu');
const namaInput = document.getElementById('nama_ibu_otomatis');
const suggestionBox = document.getElementById('suggestionBox');
const btnReset = document.getElementById('btnReset');

function normalizeText(value) {
    return String(value || '').toLowerCase().trim();
}

function findExactMother(nik) {
    return dataIbu.find(item => String(item.nik) === String(nik));
}

function setSelectedMother(item) {
    nikInput.value = item.nik;
    namaInput.value = item.nama;
    closeSuggestions();
}

function closeSuggestions() {
    suggestionBox.style.display = 'none';
    suggestionBox.innerHTML = '';
}

function renderSuggestions(keyword) {
    const key = normalizeText(keyword);

    suggestionBox.innerHTML = '';

    if (key.length === 0) {
        closeSuggestions();
        namaInput.value = '';
        return;
    }

    const exact = findExactMother(nikInput.value);

    if (exact) {
        namaInput.value = exact.nama;
    } else {
        namaInput.value = '';
    }

    const results = dataIbu
        .filter(item => {
            const nik = normalizeText(item.nik);
            const nama = normalizeText(item.nama);

            return nik.includes(key) || nama.includes(key);
        })
        .slice(0, 8);

    if (results.length === 0) {
        suggestionBox.innerHTML = '<div class="suggestion-empty">Data ibu tidak ditemukan.</div>';
        suggestionBox.style.display = 'block';
        return;
    }

    results.forEach(item => {
        const div = document.createElement('div');
        div.className = 'suggestion-item';
        div.innerHTML = `
            <div class="suggestion-nik">${item.nik}</div>
            <div class="suggestion-name">${item.nama}</div>
        `;

        div.addEventListener('mousedown', function (event) {
            event.preventDefault();
            setSelectedMother(item);
        });

        suggestionBox.appendChild(div);
    });

    suggestionBox.style.display = 'block';
}

nikInput.addEventListener('input', function () {
    renderSuggestions(this.value);
});

nikInput.addEventListener('focus', function () {
    if (this.value.trim() !== '') {
        renderSuggestions(this.value);
    }
});

nikInput.addEventListener('blur', function () {
    setTimeout(closeSuggestions, 160);

    const exact = findExactMother(nikInput.value);
    namaInput.value = exact ? exact.nama : '';
});

btnReset.addEventListener('click', function () {
    setTimeout(function () {
        namaInput.value = '';
        closeSuggestions();
    }, 50);
});

window.addEventListener('DOMContentLoaded', function () {
    const exact = findExactMother(nikInput.value);
    namaInput.value = exact ? exact.nama : '';
});

document.addEventListener('click', function (event) {
    if (!event.target.closest('.autocomplete-wrap')) {
        closeSuggestions();
    }
});
</script>

</body>
</html>