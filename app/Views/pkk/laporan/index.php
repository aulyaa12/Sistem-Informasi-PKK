<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Bulanan PKK Desa <?= esc($nama_desa ?? ''); ?> | Sistem Informasi PKK</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        :root {
            --sidebar: #26313c;
            --sidebar-dark: #202932;
            --bg: #eef2f6;
            --surface: #ffffff;
            --border: #dfe5ec;
            --text: #111827;
            --muted: #334155;
            --soft-muted: #64748b;
            --blue: #2f9fb3;
            --green: #36a852;
            --red: #dc3f4f;
            --purple: #7655c7;
            --yellow: #f5bd38;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            background: var(--bg);
            color: var(--text);
            font-family: Arial, Helvetica, sans-serif;
            font-size: 15px;
        }

        .layout {
            min-height: 100vh;
            display: flex;
        }

        .sidebar {
            width: 245px;
            background: var(--sidebar);
            color: #ffffff;
            position: fixed;
            inset: 0 auto 0 0;
            overflow-y: auto;
            flex-shrink: 0;
        }

        .content {
            margin-left: 245px;
            width: calc(100% - 245px);
            min-height: 100vh;
        }

        .main {
            padding: 28px;
        }

        .brand {
            min-height: 185px;
            padding: 22px 16px 18px;
            background: var(--sidebar-dark);
            border-bottom: 1px solid rgba(255,255,255,0.08);
        }

        .brand-logo {
            width: 132px;
            height: 120px;
            overflow: visible;
            flex-shrink: 0;
        }

        .brand-logo img {
            width: 132px;
            height: 120px;
            object-fit: contain;
            display: block;
            transform: scale(1.08);
        }

        .brand-fallback {
            width: 100%;
            height: 100%;
            display: none;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            font-size: 34px;
        }

        .brand-title {
            font-size: 13px;
            font-weight: 800;
            line-height: 2.1;
            letter-spacing: .3px;
            color: #ffffff;
        }

        .brand-sub {
            font-size: 11px;
            color: rgba(255,255,255,.72);
            margin-top: 4px;
        }

        .profile {
            padding: 18px;
            border-bottom: 1px solid rgba(255,255,255,0.08);
        }

        .profile-avatar {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background: #3b82f6;
            font-size: 20px;
            flex-shrink: 0;
        }

        .profile-name {
            font-weight: 700;
            font-size: 13px;
        }

        .profile-role {
            background: #22c55e;
            color: #ffffff;
            font-size: 10px;
            padding: 2px 7px;
            border-radius: 4px;
        }

        .menu-label {
            padding: 18px 18px 8px;
            font-size: 11px;
            color: rgba(255,255,255,.50);
            text-transform: uppercase;
            letter-spacing: .6px;
        }

        .menu {
            padding: 0 10px 18px;
        }

        .menu-link {
            color: rgba(255,255,255,.82);
            text-decoration: none;
            padding: 11px 12px;
            border-radius: 6px;
            font-size: 13px;
            transition: .15s ease;
        }

        .menu-link:hover,
        .menu-link.active {
            background: rgba(255,255,255,.10);
            color: #ffffff;
        }

        .menu-link i {
            width: 18px;
            text-align: center;
            font-size: 15px;
        }

        .page-title {
            margin-bottom: 22px;
        }

        .page-title h1 {
            margin: 0 0 8px;
            font-size: 31px;
            font-weight: 800;
            color: #071426;
            letter-spacing: -.35px;
            line-height: 1.22;
        }

        .page-title p {
            color: #334155;
            margin: 0;
            font-size: 14px;
            line-height: 1.55;
            max-width: 720px;
        }

        .section-title {
            margin: 12px 0 12px;
            font-size: 19px;
            font-weight: 800;
            color: #111827;
        }

        .panel,
        .stat-card,
        .filter-panel {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(15, 23, 42, .045);
        }

        .filter-panel {
            padding: 17px;
            margin-bottom: 22px;
        }

        .form-label {
            font-size: 13px;
            font-weight: 800;
            color: #334155;
            margin-bottom: 6px;
        }

        .form-select {
            border-radius: 9px;
            border-color: #d6dee8;
            color: #111827;
            font-size: 14px;
            padding: 10px 12px;
        }

        .form-select:focus {
            border-color: var(--blue);
            box-shadow: 0 0 0 .15rem rgba(47, 159, 179, .18);
        }

        .btn-filter {
            background: #2563eb;
            border: 1px solid #2563eb;
            color: #ffffff;
            border-radius: 9px;
            font-size: 13px;
            font-weight: 800;
            padding: 10px 14px;
        }

        .btn-filter:hover {
            background: #1d4ed8;
            border-color: #1d4ed8;
            color: #ffffff;
        }

        .btn-export {
            background: #047857;
            border: 1px solid #047857;
            color: #ffffff;
            border-radius: 9px;
            font-size: 13px;
            font-weight: 800;
            padding: 10px 14px;
            text-decoration: none;
        }

        .btn-export:hover {
            background: #065f46;
            border-color: #065f46;
            color: #ffffff;
        }

        .stat-card {
            padding: 14px;
            height: 100%;
        }

        .stat-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            font-size: 19px;
            flex-shrink: 0;
        }

        .stat-icon.blue {
            background: #eff6ff;
            color: #2563eb;
            border: 1px solid #bfdbfe;
        }

        .stat-icon.green {
            background: #ecfdf5;
            color: #047857;
            border: 1px solid #bbf7d0;
        }

        .stat-icon.red {
            background: #fff1f2;
            color: #dc2626;
            border: 1px solid #fecdd3;
        }

        .stat-icon.purple {
            background: #f5f3ff;
            color: #7655c7;
            border: 1px solid #ddd6fe;
        }

        .stat-label {
            color: #475569;
            font-size: 13px;
            margin-bottom: 5px;
        }

        .stat-value {
            font-size: 27px;
            font-weight: 800;
            color: #0f172a;
            line-height: 1;
        }

        .stat-desc {
            display: none;
        }

        .panel {
            padding: 16px;
            margin-bottom: 22px;
        }

        .panel-title {
            font-size: 16px;
            font-weight: 800;
            color: #111827;
            margin-bottom: 4px;
        }

        .panel-subtitle {
            color: #475569;
            font-size: 13px;
            margin-bottom: 14px;
            line-height: 1.45;
        }

        .chart-box {
            position: relative;
            height: 235px;
        }

        .table-responsive {
            border-radius: 10px;
            border: 1px solid #e5eaf0;
            overflow: auto;
        }

        .table {
            margin-bottom: 0;
        }

        .table thead th {
            font-size: 12px;
            color: #334155;
            background: #f8fafc;
            white-space: nowrap;
            padding: 12px 10px;
            border-bottom: 1px solid #e5eaf0;
        }

        .table tbody td {
            font-size: 13px;
            color: #1f2937;
            vertical-align: middle;
            padding: 11px 10px;
        }

        .table-hover tbody tr:hover {
            background: #f8fafc;
        }

        .empty-state {
            color: #475569;
            font-size: 13px;
            text-align: center;
            padding: 22px;
        }

        .footer {
            text-align: center;
            color: #475569;
            font-size: 12px;
            padding: 20px;
        }

        @media (max-width: 780px) {
            .layout {
                display: block;
            }

            .sidebar {
                position: static;
                width: 100%;
                height: auto;
            }

            .content {
                margin-left: 0;
                width: 100%;
            }

            .main {
                padding: 16px;
            }

            .brand {
                min-height: 165px;
                padding: 18px 16px 16px;
                gap: 7px;
            }

            .brand-logo,
            .brand-logo img {
                width: 118px;
                height: 106px;
            }

            .brand-logo img {
                transform: scale(1.05);
            }

            .profile,
            .menu-label {
                display: none;
            }

            .menu {
                display: flex;
                gap: 8px;
                overflow-x: auto;
                padding: 10px;
                border-top: 1px solid rgba(255,255,255,0.08);
            }

            .menu-link {
                white-space: nowrap;
                flex-shrink: 0;
            }

            .page-title h1 {
                font-size: 25px;
            }

            .chart-box {
                height: 240px;
            }
        }
    </style>
</head>

<body>

<?php
    $menus = [
        ['url' => 'pkk/dashboard', 'icon' => 'bi-speedometer2', 'label' => 'Dashboard', 'active' => false],
        ['url' => 'pkk/penduduk', 'icon' => 'bi-people-fill', 'label' => 'Data Penduduk', 'active' => false],
        ['url' => 'pkk/kelahiran', 'icon' => 'bi-person-plus-fill', 'label' => 'Data Kelahiran', 'active' => false],
        ['url' => 'pkk/kematian', 'icon' => 'bi-file-earmark-medical-fill', 'label' => 'Data Kematian', 'active' => false],
        ['url' => 'pkk/lansia', 'icon' => 'bi-person-standing', 'label' => 'Data Lansia', 'active' => false],
        ['url' => 'pkk/laporan', 'icon' => 'bi-clipboard-data-fill', 'label' => 'Laporan Bulanan', 'active' => true],
    ];

    $fmt = static function ($value) {
        return number_format((int) ($value ?? 0), 0, ',', '.');
    };

    $tgl = static function ($date) {
        if (empty($date)) {
            return '-';
        }

        return date('d-m-Y', strtotime($date));
    };
?>

<div class="layout">

    <aside class="sidebar">
        <div class="brand d-flex flex-column align-items-center justify-content-center text-center gap-2">
            <div class="brand-logo d-flex align-items-center justify-content-center">
                <img src="/logo_pkk_transparan.png?v=3"
                     alt="Logo PKK"
                     onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">

                <div class="brand-fallback">
                    <i class="bi bi-flower1"></i>
                </div>
            </div>

            <div class="w-100">
                <div class="brand-title">SISTEM INFORMASI PKK</div>
                <div class="brand-sub">Kemudahan dalam mengelola data PKK</div>
            </div>
        </div>

        <div class="profile d-flex align-items-center gap-2">
            <div class="profile-avatar d-flex align-items-center justify-content-center">
                <i class="bi bi-person-fill"></i>
            </div>

            <div>
                <div class="profile-name"><?= esc(session()->get('username') ?? 'Ketua PKK'); ?></div>
                <span class="profile-role d-inline-block">Ketua PKK</span>
            </div>
        </div>

        <div class="menu-label">Menu Utama</div>

        <nav class="menu">
            <?php foreach ($menus as $menu) : ?>
                <a href="<?= base_url($menu['url']); ?>"
                   class="menu-link d-flex align-items-center gap-2 <?= $menu['active'] ? 'active' : ''; ?>">
                    <i class="bi <?= esc($menu['icon']); ?>"></i>
                    <?= esc($menu['label']); ?>
                </a>
            <?php endforeach; ?>
        </nav>

        <div class="menu-label">Akun</div>

        <nav class="menu">
            <a href="<?= base_url('logout'); ?>" class="menu-link d-flex align-items-center gap-2">
                <i class="bi bi-box-arrow-right"></i>
                Logout
            </a>
        </nav>
    </aside>

    <div class="content">
        <main class="main">

            <div class="page-title">
                <h1>Laporan Bulanan PKK Desa <?= esc($nama_desa ?? 'Desa'); ?></h1>
                <p>
                    Rekap data PKK periode <?= esc($nama_bulan); ?> <?= esc($tahun); ?><?= $rt !== '' ? ', RT ' . esc($rt) : ', semua RT'; ?>.
                </p>
            </div>

            <div class="filter-panel">
                <form action="<?= base_url('pkk/laporan'); ?>" method="get" class="row g-3 align-items-end">
                    <div class="col-12 col-md-3">
                        <label class="form-label">Bulan</label>
                        <select name="bulan" class="form-select">
                            <?php foreach ($bulan_list as $key => $label) : ?>
                                <option value="<?= esc($key); ?>" <?= (int) $bulan === (int) $key ? 'selected' : ''; ?>>
                                    <?= esc($label); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-12 col-md-3">
                        <label class="form-label">Tahun</label>
                        <select name="tahun" class="form-select">
                            <?php foreach ($tahun_list as $item) : ?>
                                <option value="<?= esc($item); ?>" <?= (int) $tahun === (int) $item ? 'selected' : ''; ?>>
                                    <?= esc($item); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-12 col-md-3">
                        <label class="form-label">RT</label>
                        <select name="rt" class="form-select">
                            <option value="">Semua RT</option>
                            <?php foreach ($rt_list as $item) : ?>
                                <option value="<?= esc($item['RT']); ?>" <?= (string) $rt === (string) $item['RT'] ? 'selected' : ''; ?>>
                                    RT <?= esc($item['RT']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-12 col-md-3">
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-filter">
                                <i class="bi bi-search"></i>
                                Tampilkan
                            </button>

                            <a href="<?= base_url('pkk/laporan/export') . '?bulan=' . urlencode((string) $bulan) . '&tahun=' . urlencode((string) $tahun) . '&rt=' . urlencode((string) $rt); ?>"
                               class="btn btn-export">
                                <i class="bi bi-file-earmark-excel"></i>
                                Unduh Excel
                            </a>
                        </div>
                    </div>
                </form>
            </div>

            <div class="section-title">Ringkasan Laporan</div>

            <div class="row g-3 mb-4">
                <div class="col-12 col-md-6 col-xl-3">
                    <div class="stat-card">
                        <div class="d-flex align-items-center gap-3">
                            <div class="stat-icon blue d-flex align-items-center justify-content-center">
                                <i class="bi bi-people-fill"></i>
                            </div>
                            <div>
                                <div class="stat-label">Total Penduduk</div>
                                <div class="stat-value"><?= esc($fmt($summary['total_penduduk'] ?? 0)); ?></div>
                            </div>
                        </div>
                        <div class="stat-desc">
                            Laki-laki <?= esc($fmt($summary['total_laki_laki'] ?? 0)); ?>,
                            perempuan <?= esc($fmt($summary['total_perempuan'] ?? 0)); ?>.
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-xl-3">
                    <div class="stat-card">
                        <div class="d-flex align-items-center gap-3">
                            <div class="stat-icon green d-flex align-items-center justify-content-center">
                                <i class="bi bi-person-plus-fill"></i>
                            </div>
                            <div>
                                <div class="stat-label">Kelahiran</div>
                                <div class="stat-value"><?= esc($fmt($summary['total_kelahiran'] ?? 0)); ?></div>
                            </div>
                        </div>
                        <div class="stat-desc">Data kelahiran sesuai periode.</div>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-xl-3">
                    <div class="stat-card">
                        <div class="d-flex align-items-center gap-3">
                            <div class="stat-icon red d-flex align-items-center justify-content-center">
                                <i class="bi bi-file-earmark-medical-fill"></i>
                            </div>
                            <div>
                                <div class="stat-label">Kematian</div>
                                <div class="stat-value"><?= esc($fmt($summary['total_kematian'] ?? 0)); ?></div>
                            </div>
                        </div>
                        <div class="stat-desc">Data kematian sesuai periode.</div>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-xl-3">
                    <div class="stat-card">
                        <div class="d-flex align-items-center gap-3">
                            <div class="stat-icon purple d-flex align-items-center justify-content-center">
                                <i class="bi bi-person-standing"></i>
                            </div>
                            <div>
                                <div class="stat-label">Total Lansia</div>
                                <div class="stat-value"><?= esc($fmt($summary['total_lansia'] ?? 0)); ?></div>
                            </div>
                        </div>
                        <div class="stat-desc">
                            Produktif <?= esc($fmt($summary['lansia_produktif'] ?? 0)); ?>,
                            nonproduktif <?= esc($fmt($summary['lansia_nonproduktif'] ?? 0)); ?>.
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-3 mb-4">
                <div class="col-12 col-xl-7">
                    <div class="panel h-100">
                        <div class="panel-title">Grafik Ringkasan</div>
                        <div class="panel-subtitle">Perbandingan data utama pada periode laporan.</div>
                        <div class="chart-box">
                            <canvas id="summaryChart"></canvas>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-xl-5">
                    <div class="panel h-100">
                        <div class="panel-title">Status Lansia</div>
                        <div class="panel-subtitle">Komposisi lansia produktif dan nonproduktif.</div>
                        <div class="chart-box">
                            <canvas id="lansiaChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="panel">
                <div class="panel-title">Rekap Penduduk per RT</div>
                <div class="panel-subtitle">Jumlah penduduk laki-laki dan perempuan berdasarkan RT.</div>

                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle">
                        <thead>
                            <tr>
                                <th>RT</th>
                                <th class="text-end">Laki-laki</th>
                                <th class="text-end">Perempuan</th>
                                <th class="text-end">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($rekap_rt)) : ?>
                                <?php foreach ($rekap_rt as $row) : ?>
                                    <tr>
                                        <td>RT <?= esc($row['RT'] ?? '-'); ?></td>
                                        <td class="text-end"><?= esc($fmt($row['laki_laki'] ?? 0)); ?></td>
                                        <td class="text-end"><?= esc($fmt($row['perempuan'] ?? 0)); ?></td>
                                        <td class="text-end fw-bold"><?= esc($fmt($row['total'] ?? 0)); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <tr>
                                    <td colspan="4" class="empty-state">Belum ada data penduduk.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="panel">
                <div class="panel-title">Data Kelahiran</div>
                <div class="panel-subtitle">Daftar kelahiran pada periode laporan.</div>

                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Bayi</th>
                                <th>Nama Ibu</th>
                                <th>JK</th>
                                <th>RT</th>
                                <th>Tanggal Lahir</th>
                                <th>Tempat Lahir</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($kelahiran)) : ?>
                                <?php foreach ($kelahiran as $i => $row) : ?>
                                    <tr>
                                        <td><?= esc($i + 1); ?></td>
                                        <td><?= esc($row['nama_bayi'] ?? '-'); ?></td>
                                        <td><?= esc($row['nama_ibu'] ?? '-'); ?></td>
                                        <td><?= esc($row['jenis_kelamin'] ?? '-'); ?></td>
                                        <td><?= esc($row['RT'] ?? '-'); ?></td>
                                        <td><?= esc($tgl($row['tgl_lahir'] ?? null)); ?></td>
                                        <td><?= esc($row['tempat_lahir'] ?? '-'); ?></td>
                                        <td><?= esc($row['keterangan'] ?? '-'); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <tr>
                                    <td colspan="8" class="empty-state">Tidak ada data kelahiran pada periode ini.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="panel">
                <div class="panel-title">Data Kematian</div>
                <div class="panel-subtitle">Daftar kematian pada periode laporan.</div>

                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Almarhum/ah</th>
                                <th>NIK</th>
                                <th>RT</th>
                                <th>Tanggal Kematian</th>
                                <th>Tempat Kematian</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($kematian)) : ?>
                                <?php foreach ($kematian as $i => $row) : ?>
                                    <tr>
                                        <td><?= esc($i + 1); ?></td>
                                        <td><?= esc($row['nama_almarhum'] ?? '-'); ?></td>
                                        <td><?= esc($row['nik'] ?? '-'); ?></td>
                                        <td><?= esc($row['RT'] ?? '-'); ?></td>
                                        <td><?= esc($tgl($row['tgl_kematian'] ?? null)); ?></td>
                                        <td><?= esc($row['tempat_kematian'] ?? '-'); ?></td>
                                        <td><?= esc($row['keterangan'] ?? '-'); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <tr>
                                    <td colspan="7" class="empty-state">Tidak ada data kematian pada periode ini.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="panel">
                <div class="panel-title">Data Lansia</div>
                <div class="panel-subtitle">Daftar lansia yang tercatat pada wilayah laporan.</div>

                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Lansia</th>
                                <th>NIK</th>
                                <th>RT</th>
                                <th>Umur</th>
                                <th>Produktivitas</th>
                                <th>Hobi</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($lansia)) : ?>
                                <?php foreach ($lansia as $i => $row) : ?>
                                    <tr>
                                        <td><?= esc($i + 1); ?></td>
                                        <td><?= esc($row['nama_lansia'] ?? '-'); ?></td>
                                        <td><?= esc($row['nik'] ?? '-'); ?></td>
                                        <td><?= esc($row['RT'] ?? '-'); ?></td>
                                        <td><?= esc($row['umur_lansia'] ?? '-'); ?></td>
                                        <td><?= esc($row['produktifitas'] ?? '-'); ?></td>
                                        <td><?= esc($row['hobi'] ?? '-'); ?></td>
                                        <td><?= esc($row['keterangan'] ?? '-'); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <tr>
                                    <td colspan="8" class="empty-state">Belum ada data lansia pada wilayah ini.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </main>

        <footer class="footer">
            &copy; <?= date('Y'); ?> Sistem Informasi PKK. Laporan ditampilkan sesuai wilayah akun yang sedang login.
        </footer>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
const formatNumber = value => new Intl.NumberFormat('id-ID').format(Number(value) || 0);

const summaryLabels = <?= json_encode($chart_summary['labels'] ?? []); ?>;
const summaryData = <?= json_encode($chart_summary['data'] ?? []); ?>;

const lansiaLabels = <?= json_encode($chart_lansia['labels'] ?? []); ?>;
const lansiaData = <?= json_encode($chart_lansia['data'] ?? []); ?>;

const hasData = data => Array.isArray(data) && data.some(value => Number(value) > 0);

const totalData = data => {
    return Array.isArray(data)
        ? data.reduce((sum, value) => sum + (Number(value) || 0), 0)
        : 0;
};

const percentText = (value, total) => {
    if (!total) {
        return '0%';
    }

    return ((Number(value) / total) * 100).toFixed(1).replace('.', ',') + '%';
};

const suggestedMax = data => {
    if (!Array.isArray(data) || data.length === 0) {
        return 5;
    }

    const max = Math.max(...data.map(value => Number(value) || 0));
    return max <= 0 ? 5 : Math.ceil(max + (max * 0.25));
};

const chartNumberPlugin = {
    id: 'chartNumberPlugin',

    afterDraw(chart) {
        const dataset = chart.data.datasets[0];
        const data = dataset?.data || [];
        const { ctx, chartArea } = chart;
        const centerX = (chartArea.left + chartArea.right) / 2;
        const centerY = (chartArea.top + chartArea.bottom) / 2;

        if (!hasData(data)) {
            ctx.save();
            ctx.textAlign = 'center';
            ctx.textBaseline = 'middle';
            ctx.fillStyle = '#94a3b8';
            ctx.font = '600 13px Arial';
            ctx.fillText('Belum ada data', centerX, centerY);
            ctx.restore();
            return;
        }

        if (chart.config.type === 'doughnut') {
            ctx.save();
            ctx.textAlign = 'center';
            ctx.textBaseline = 'middle';
            ctx.fillStyle = '#64748b';
            ctx.font = '700 12px Arial';
            ctx.fillText('Total', centerX, centerY - 10);

            ctx.fillStyle = '#0f172a';
            ctx.font = '800 20px Arial';
            ctx.fillText(formatNumber(totalData(data)), centerX, centerY + 12);
            ctx.restore();
        }
    },

    afterDatasetsDraw(chart) {
        const dataset = chart.data.datasets[0];
        const data = dataset?.data || [];

        if (!hasData(data)) {
            return;
        }

        const { ctx } = chart;
        const meta = chart.getDatasetMeta(0);

        if (chart.config.type === 'bar') {
            ctx.save();
            ctx.textAlign = 'center';
            ctx.textBaseline = 'bottom';
            ctx.fillStyle = '#0f172a';
            ctx.font = '700 11px Arial';

            meta.data.forEach((bar, index) => {
                const value = Number(data[index]) || 0;

                if (value > 0) {
                    ctx.fillText(formatNumber(value), bar.x, bar.y - 6);
                }
            });

            ctx.restore();
        }

        if (chart.config.type === 'doughnut') {
            ctx.save();
            ctx.textAlign = 'center';
            ctx.textBaseline = 'middle';
            ctx.font = '800 12px Arial';
            ctx.lineWidth = 3;
            ctx.strokeStyle = 'rgba(15, 23, 42, 0.45)';
            ctx.fillStyle = '#ffffff';

            meta.data.forEach((arc, index) => {
                const value = Number(data[index]) || 0;

                if (value > 0) {
                    const position = arc.tooltipPosition();
                    const label = formatNumber(value);

                    ctx.strokeText(label, position.x, position.y);
                    ctx.fillText(label, position.x, position.y);
                }
            });

            ctx.restore();
        }
    }
};

Chart.register(chartNumberPlugin);

new Chart(document.getElementById('summaryChart'), {
    type: 'bar',
    data: {
        labels: summaryLabels,
        datasets: [{
            data: summaryData,
            backgroundColor: [
                'rgba(47, 159, 179, .18)',
                'rgba(54, 168, 82, .18)',
                'rgba(220, 63, 79, .18)',
                'rgba(118, 85, 199, .18)'
            ],
            borderColor: [
                '#2f9fb3',
                '#36a852',
                '#dc3f4f',
                '#7655c7'
            ],
            borderWidth: 1.5,
            borderRadius: 6,
            borderSkipped: false,
            maxBarThickness: 44
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        layout: {
            padding: {
                top: 22
            }
        },
        plugins: {
            legend: {
                display: false
            },
            tooltip: {
                callbacks: {
                    label(ctx) {
                        return ' ' + formatNumber(ctx.raw) + ' data';
                    }
                }
            }
        },
        scales: {
            x: {
                grid: {
                    display: false
                },
                border: {
                    display: false
                },
                ticks: {
                    color: '#475569',
                    font: {
                        size: 11
                    }
                }
            },
            y: {
                beginAtZero: true,
                suggestedMax: suggestedMax(summaryData),
                border: {
                    display: false
                },
                grid: {
                    color: 'rgba(148, 163, 184, 0.22)'
                },
                ticks: {
                    precision: 0,
                    color: '#475569',
                    font: {
                        size: 11
                    }
                }
            }
        }
    }
});

new Chart(document.getElementById('lansiaChart'), {
    type: 'doughnut',
    data: {
        labels: lansiaLabels,
        datasets: [{
            data: lansiaData,
            backgroundColor: ['#7655c7', '#94a3b8'],
            borderColor: '#ffffff',
            borderWidth: 4,
            hoverOffset: 5
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        cutout: '64%',
        plugins: {
            legend: {
                position: 'bottom',
                labels: {
                    usePointStyle: true,
                    pointStyle: 'circle',
                    boxWidth: 8,
                    padding: 14,
                    color: '#475569',
                    font: {
                        size: 11,
                        weight: 'bold'
                    },
                    generateLabels(chart) {
                        const labels = chart.data.labels || [];
                        const data = chart.data.datasets[0].data || [];
                        const colors = chart.data.datasets[0].backgroundColor || [];
                        const total = totalData(data);

                        return labels.map((label, index) => {
                            const value = Number(data[index]) || 0;

                            return {
                                text: label + ': ' + formatNumber(value) + ' (' + percentText(value, total) + ')',
                                fillStyle: colors[index],
                                strokeStyle: colors[index],
                                lineWidth: 0,
                                hidden: !chart.getDataVisibility(index),
                                index: index,
                                pointStyle: 'circle'
                            };
                        });
                    }
                }
            },
            tooltip: {
                callbacks: {
                    label(ctx) {
                        const total = totalData(lansiaData);
                        const value = Number(ctx.raw) || 0;

                        return ' ' + ctx.label + ': ' + formatNumber(value) + ' (' + percentText(value, total) + ')';
                    }
                }
            }
        }
    }
});
</script>

</body>
</html>