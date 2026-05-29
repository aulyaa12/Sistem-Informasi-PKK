<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Detail Riwayat Kelahiran'); ?></title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <style>
        :root {
            --bg: #f4f6f9;
            --card: #ffffff;
            --success: #16a34a;
            --success-dark: #15803d;
            --warning: #d97706;
            --warning-dark: #b45309;
            --text: #111827;
            --muted: #6b7280;
            --border: #e5e7eb;
            --soft: #f8fafc;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            background: var(--bg);
            font-family: Arial, Helvetica, sans-serif;
            color: var(--text);
        }

        .page-wrap {
            padding: 32px 12px 48px;
        }

        .main-container {
            max-width: 880px;
            margin: 0 auto;
        }

        .detail-card {
            background: var(--card);
            border: none;
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 8px 24px rgba(15, 23, 42, 0.08);
        }

        .detail-header {
            background: var(--success);
            color: #ffffff;
            padding: 24px 28px;
            display: flex;
            align-items: center;
            gap: 18px;
        }

        .detail-icon {
            width: 64px;
            height: 64px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.18);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .detail-icon i {
            font-size: 32px;
        }

        .detail-name {
            margin: 0 0 6px;
            font-size: 1.45rem;
            font-weight: 700;
            line-height: 1.25;
        }

        .detail-sub {
            margin: 0;
            font-size: 0.95rem;
            color: rgba(255, 255, 255, 0.82);
            word-break: break-word;
        }

        .detail-body {
            padding: 26px 28px;
        }

        .section-title {
            font-size: 1.05rem;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 16px;
            padding-bottom: 12px;
            border-bottom: 1px solid var(--border);
        }

        .biodata-table {
            width: 100%;
            margin: 0;
            border-collapse: collapse;
        }

        .biodata-table tr {
            border-bottom: 1px solid #eef2f6;
        }

        .biodata-table tr:last-child {
            border-bottom: none;
        }

        .biodata-table th {
            width: 34%;
            padding: 14px 12px;
            color: #374151;
            font-size: 0.95rem;
            font-weight: 700;
            vertical-align: top;
            background: #f8fafc;
        }

        .biodata-table td {
            padding: 14px 12px;
            color: #000000;
            font-size: 0.98rem;
            font-weight: 500;
            vertical-align: top;
            word-break: break-word;
        }

        .badge-gender {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 999px;
            padding: 6px 12px;
            font-size: 0.86rem;
            font-weight: 700;
        }

        .badge-male {
            background: #dbeafe;
            color: #1d4ed8;
        }

        .badge-female {
            background: #fee2e2;
            color: #be123c;
        }

        .record-info {
            margin-top: 22px;
            padding-top: 16px;
            border-top: 1px solid var(--border);
        }

        .record-text {
            margin: 0 0 6px;
            font-size: 0.92rem;
            color: #6b7280;
            line-height: 1.6;
        }

        .record-text strong {
            color: #111827;
            font-weight: 700;
        }

        .detail-footer {
            background: #ffffff;
            border-top: 1px solid var(--border);
            padding: 18px 28px;
            display: flex;
            justify-content: flex-end;
        }

        .btn-edit {
            background: var(--warning);
            border: 1px solid var(--warning);
            color: #ffffff;
            border-radius: 10px;
            font-size: 0.95rem;
            font-weight: 700;
            padding: 10px 18px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            min-width: 145px;
            justify-content: center;
        }

        .btn-edit:hover {
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

        .btn-back-professional i,
        .btn-edit i {
            line-height: 1;
        }

        @media (max-width: 767.98px) {
            .page-wrap {
                padding: 18px 10px 32px;
            }

            .detail-card {
                border-radius: 14px;
            }

            .detail-header {
                padding: 20px 18px;
                align-items: flex-start;
                gap: 14px;
            }

            .detail-icon {
                width: 56px;
                height: 56px;
            }

            .detail-icon i {
                font-size: 28px;
            }

            .detail-name {
                font-size: 1.15rem;
            }

            .detail-sub {
                font-size: 0.88rem;
            }

            .detail-body {
                padding: 18px;
            }

            .biodata-table th,
            .biodata-table td {
                display: block;
                width: 100%;
                padding: 10px 12px;
            }

            .biodata-table th {
                padding-bottom: 4px;
                background: transparent;
                color: var(--muted);
                font-size: 0.88rem;
            }

            .biodata-table td {
                padding-top: 0;
                font-size: 0.96rem;
            }

            .biodata-table tr {
                display: block;
                padding: 8px 0;
            }

            .detail-footer {
                padding: 16px 18px;
            }

            .btn-edit {
                width: 100%;
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

            .detail-body {
                padding: 16px;
            }

            .section-title {
                font-size: 1rem;
            }

            .record-text {
                font-size: 0.88rem;
            }
        }
    </style>
</head>
<body>

<?php
    $idKelahiran = $kelahiran['id_kelahiran'] ?? '';
    $nikIbu = $kelahiran['nik_ibu'] ?? '-';
    $namaIbu = $kelahiran['nama_ibu'] ?? '-';
    $namaBayi = $kelahiran['nama_bayi'] ?? '-';

    $jenisKelamin = '-';
    $genderClass = 'badge-male';

    if (($kelahiran['jenis_kelamin'] ?? '') === 'L') {
        $jenisKelamin = 'Laki-laki';
        $genderClass = 'badge-male';
    } elseif (($kelahiran['jenis_kelamin'] ?? '') === 'P') {
        $jenisKelamin = 'Perempuan';
        $genderClass = 'badge-female';
    }

    $tanggalLahir = '-';
    if (!empty($kelahiran['tgl_lahir'])) {
        $tanggalLahir = date('d-m-Y', strtotime($kelahiran['tgl_lahir']));
    }

    $usiaAnak = '-';
    if (!empty($kelahiran['tgl_lahir'])) {
        try {
            $tanggalLahirObj = new DateTime($kelahiran['tgl_lahir']);
            $hariIni = new DateTime('today');
            $selisih = $hariIni->diff($tanggalLahirObj);

            $usiaTeks = [];

            if ($selisih->y > 0) {
                $usiaTeks[] = $selisih->y . ' Tahun';
            }

            if ($selisih->m > 0) {
                $usiaTeks[] = $selisih->m . ' Bulan';
            }

            if ($selisih->y === 0 && $selisih->m === 0) {
                $usiaTeks[] = 'Kurang dari 1 Bulan';
            }

            $usiaAnak = implode(', ', $usiaTeks);
        } catch (\Throwable $e) {
            $usiaAnak = '-';
        }
    }

    $tempatLahir = $kelahiran['tempat_lahir'] ?? '-';
    $keterangan = !empty($kelahiran['keterangan']) ? $kelahiran['keterangan'] : '-';

    $createdAt = '-';
    if (!empty($kelahiran['created_at'])) {
        $createdAt = date('d-m-Y H:i', strtotime($kelahiran['created_at'])) . ' WIB';
    }

    $updatedAt = '-';
    if (!empty($kelahiran['updated_at'])) {
        $updatedAt = date('d-m-Y H:i', strtotime($kelahiran['updated_at'])) . ' WIB';
    }
?>

<div class="page-wrap">
    <div class="main-container">

        <div class="detail-card">
            <div class="detail-header">
                <div class="detail-icon">
                    <i class="bi bi-person-plus-fill"></i>
                </div>

                <div>
                    <h1 class="detail-name"><?= esc($namaBayi); ?></h1>
                    <p class="detail-sub">
                        <i class="bi bi-person-heart me-1"></i>
                        Ibu: <?= esc($namaIbu); ?>
                    </p>
                </div>
            </div>

            <div class="detail-body">
                <div class="section-title">Detail Riwayat Kelahiran</div>

                <table class="biodata-table">
                    <tbody>
                        <tr>
                            <th>NIK Ibu Kandung</th>
                            <td><?= esc($nikIbu); ?></td>
                        </tr>
                        <tr>
                            <th>Nama Ibu Kandung</th>
                            <td>
                                <?php if (!empty($kelahiran['nama_ibu'])) : ?>
                                    <?= esc($namaIbu); ?>
                                <?php else : ?>
                                    <span class="text-danger">Tidak Terdata</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <tr>
                            <th>Nama Anak / Bayi</th>
                            <td><?= esc($namaBayi); ?></td>
                        </tr>
                        <tr>
                            <th>Jenis Kelamin Anak</th>
                            <td>
                                <span class="badge-gender <?= esc($genderClass); ?>">
                                    <?= esc($jenisKelamin); ?>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>Tanggal Lahir</th>
                            <td><?= esc($tanggalLahir); ?></td>
                        </tr>
                        <tr>
                            <th>Usia Anak Saat Ini</th>
                            <td><?= esc($usiaAnak); ?></td>
                        </tr>
                        <tr>
                            <th>Tempat Kelahiran</th>
                            <td><?= esc($tempatLahir); ?></td>
                        </tr>
                        <tr>
                            <th>Keterangan</th>
                            <td><?= nl2br(esc($keterangan)); ?></td>
                        </tr>
                    </tbody>
                </table>

                <div class="record-info">
                    <p class="record-text">
                        Data ini dibuat pada <strong><?= esc($createdAt); ?></strong>.
                    </p>

                    <p class="record-text">
                        Terakhir kali diperbaiki pada <strong><?= esc($updatedAt); ?></strong>.
                    </p>
                </div>
            </div>

            <div class="detail-footer">
                <a href="<?= base_url('pkk/kelahiran/edit/' . rawurlencode((string) $idKelahiran)); ?>" class="btn-edit">
                    <i class="bi bi-pencil-square"></i>
                    Edit Data
                </a>
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>