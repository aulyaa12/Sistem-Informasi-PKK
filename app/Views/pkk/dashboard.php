<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Dashboard'); ?> | Sistem Informasi PKK</title>

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
            margin-bottom: 24px;
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
            max-width: 680px;
        }

        .section-title {
            margin: 12px 0 12px;
            font-size: 19px;
            font-weight: 800;
            color: #111827;
        }

        .panel,
        .export-panel,
        .module-panel,
        .stat-card,
        .insight-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(15, 23, 42, .045);
        }

        .module-card {
            border-radius: 12px;
            min-height: 145px;
            position: relative;
            overflow: hidden;
            text-decoration: none;
            color: #ffffff;
            box-shadow: 0 3px 9px rgba(15, 23, 42, .12);
            transition: .15s ease;
        }

        .module-card:hover {
            transform: translateY(-2px);
            color: #ffffff;
            box-shadow: 0 6px 16px rgba(15, 23, 42, .16);
        }

        .module-card.blue {
            background: linear-gradient(135deg, #2f9fb3, #247e91);
        }

        .module-card.green {
            background: linear-gradient(135deg, #36a852, #2b8b43);
        }

        .module-card.red {
            background: linear-gradient(135deg, #dc3f4f, #b83240);
        }

        .module-card.purple {
            background: linear-gradient(135deg, #7655c7, #5d42a3);
        }

        .module-card-body {
            padding: 24px 20px 48px;
            position: relative;
            z-index: 2;
        }

        .module-card-title {
            font-size: 27px;
            font-weight: 800;
            margin-bottom: 8px;
            line-height: 1.08;
        }

        .module-card-desc {
            font-size: 13px;
            color: rgba(255,255,255,.92);
            margin: 0;
            max-width: 210px;
            line-height: 1.45;
        }

        .module-card-icon {
            position: absolute;
            right: 18px;
            top: 30px;
            font-size: 58px;
            color: rgba(0,0,0,.18);
            z-index: 1;
        }

        .module-card-footer {
            position: absolute;
            left: 0;
            right: 0;
            bottom: 0;
            height: 40px;
            background: rgba(0,0,0,.16);
            color: rgba(255,255,255,.95);
            font-size: 13px;
            font-weight: 800;
            z-index: 3;
        }

        .export-panel {
            padding: 16px 18px;
            margin-bottom: 22px;
        }

        .export-icon {
            width: 44px;
            height: 44px;
            border-radius: 10px;
            background: #ecfdf5;
            border: 1px solid #bbf7d0;
            color: #047857;
            font-size: 21px;
            flex-shrink: 0;
        }

        .export-title {
            font-size: 16px;
            font-weight: 800;
            color: #0f172a;
            margin-bottom: 2px;
        }

        .export-desc {
            font-size: 13px;
            color: #475569;
            margin: 0;
            line-height: 1.45;
        }

        .btn-export-all {
            background: #047857;
            border: 1px solid #047857;
            color: #ffffff;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 800;
            padding: 10px 15px;
            text-decoration: none;
            white-space: nowrap;
        }

        .btn-export-all:hover {
            background: #065f46;
            color: #ffffff;
            border-color: #065f46;
        }

        .dashboard-note {
            border-radius: 12px;
            background: #f8fafc;
            border: 1px solid var(--border);
            padding: 12px 14px;
            color: #475569;
            font-size: 13px;
            margin-bottom: 20px;
            line-height: 1.45;
        }

        .module-panel {
            padding: 17px;
            margin-bottom: 20px;
        }

        .module-heading {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 14px;
            padding-bottom: 12px;
            border-bottom: 1px solid #edf2f7;
        }

        .module-heading-title {
            font-size: 18px;
            font-weight: 800;
            color: #0f172a;
            margin: 0;
        }

        .module-heading-subtitle {
            font-size: 13px;
            color: #475569;
            margin: 4px 0 0;
            line-height: 1.45;
        }

        .module-badge {
            font-size: 11px;
            font-weight: 800;
            padding: 6px 10px;
            border-radius: 999px;
            background: #f8fafc;
            border: 1px solid var(--border);
            color: #475569;
            white-space: nowrap;
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

        .stat-icon.gray {
            background: #f8fafc;
            color: #475569;
            border: 1px solid #e2e8f0;
        }

        .stat-label {
            font-size: 13px;
            color: #475569;
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
            padding: 14px;
        }

        .panel-title {
            font-size: 15px;
            font-weight: 800;
            color: #111827;
            margin-bottom: 8px;
        }

        .panel-subtitle {
            display: none;
        }

        .chart-box {
            position: relative;
            height: 220px;
        }

        .chart-box-sm {
            position: relative;
            height: 185px;
        }

        .insight-card {
            padding: 13px;
            height: 100%;
        }

        .insight-icon {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            background: #f8fafc;
            border: 1px solid #dfe5ec;
            color: var(--blue);
            font-size: 17px;
            flex-shrink: 0;
        }

        .insight-title {
            font-size: 14px;
            font-weight: 800;
            color: #111827;
            margin-bottom: 4px;
        }

        .insight-text {
            font-size: 13px;
            color: #475569;
            line-height: 1.45;
            margin: 0;
        }

        .api-loading {
            font-size: 13px;
            color: #475569;
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

            .page-title h1 {
                font-size: 25px;
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

            .module-card {
                min-height: 138px;
            }

            .module-card-title {
                font-size: 27px;
            }

            .export-panel {
                align-items: stretch !important;
            }

            .btn-export-all {
                width: 100%;
                justify-content: center;
            }

            .module-heading {
                align-items: flex-start;
                flex-direction: column;
            }

            .chart-box,
            .chart-box-sm {
                height: 230px;
            }
        }
    </style>
</head>

<body>

<?php
    $menus = [
        ['url' => 'pkk/dashboard', 'icon' => 'bi-speedometer2', 'label' => 'Dashboard', 'active' => true],
        ['url' => 'pkk/penduduk', 'icon' => 'bi-people-fill', 'label' => 'Data Penduduk', 'active' => false],
        ['url' => 'pkk/kelahiran', 'icon' => 'bi-person-plus-fill', 'label' => 'Data Kelahiran', 'active' => false],
        ['url' => 'pkk/kematian', 'icon' => 'bi-file-earmark-medical-fill', 'label' => 'Data Kematian', 'active' => false],
        ['url' => 'pkk/lansia', 'icon' => 'bi-person-standing', 'label' => 'Data Lansia', 'active' => false],
        ['url' => 'pkk/laporan', 'icon' => 'bi-clipboard-data-fill', 'label' => 'Laporan Bulanan', 'active' => false],
    ];

    $modules = [
        [
            'class' => 'blue',
            'title' => 'Penduduk',
            'desc' => 'Data warga desa.',
            'icon' => 'bi-people-fill',
            'url' => 'pkk/penduduk',
        ],
        [
            'class' => 'green',
            'title' => 'Kelahiran',
            'desc' => 'Data bayi lahir.',
            'icon' => 'bi-person-plus-fill',
            'url' => 'pkk/kelahiran',
        ],
        [
            'class' => 'red',
            'title' => 'Kematian',
            'desc' => 'Data warga wafat.',
            'icon' => 'bi-file-earmark-medical-fill',
            'url' => 'pkk/kematian',
        ],
        [
            'class' => 'purple',
            'title' => 'Lansia',
            'desc' => 'Data warga lansia.',
            'icon' => 'bi-person-standing',
            'url' => 'pkk/lansia',
        ],
    ];
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

            <?php if (session()->getFlashdata('success')) : ?>
                <div class="alert alert-success">
                    <?= session()->getFlashdata('success'); ?>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')) : ?>
                <div class="alert alert-danger">
                    <?= session()->getFlashdata('error'); ?>
                </div>
            <?php endif; ?>

            <div class="page-title">
                <h1>Sistem Informasi PKK <?= esc($nama_desa ?? 'Desa'); ?></h1>
                <p>Kelola dan pantau data warga desa secara ringkas melalui fitur penduduk, kelahiran, kematian, dan lansia.</p>
            </div>

            <div class="section-title">Menu Modul</div>

            <div class="row g-3 mb-3">
                <?php foreach ($modules as $module) : ?>
                    <div class="col-12 col-md-6 col-xl-3">
                        <a href="<?= base_url($module['url']); ?>" class="module-card <?= esc($module['class']); ?> d-block">
                            <div class="module-card-body">
                                <div class="module-card-title"><?= esc($module['title']); ?></div>
                                <p class="module-card-desc"><?= esc($module['desc']); ?></p>
                            </div>

                            <i class="bi <?= esc($module['icon']); ?> module-card-icon"></i>

                            <div class="module-card-footer d-flex align-items-center justify-content-center gap-1">
                                Selengkapnya <i class="bi bi-arrow-circle-right"></i>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="export-panel d-flex align-items-center justify-content-between gap-3 flex-column flex-md-row">
                <div class="d-flex align-items-center gap-3">
                    <div class="export-icon d-flex align-items-center justify-content-center">
                        <i class="bi bi-file-earmark-excel"></i>
                    </div>

                    <div>
                        <div class="export-title">Unduh Rekap Data PKK</div>
                        <p class="export-desc">
                            Unduh data penduduk, kelahiran, kematian, dan lansia dalam format Excel.
                        </p>
                    </div>
                </div>

                <a href="<?= base_url('pkk/export-all'); ?>" class="btn-export-all d-inline-flex align-items-center gap-2">
                    <i class="bi bi-download"></i>
                    Unduh Semua Data
                </a>
            </div>

            <div class="dashboard-note">
                <i class="bi bi-info-circle me-1"></i>
                Dashboard ini menampilkan ringkasan data utama PKK secara cepat dan sederhana.
            </div>

            <div class="section-title">Ringkasan Statistik</div>

            <section class="module-panel">
                <div class="module-heading">
                    <div>
                        <h2 class="module-heading-title">Data Penduduk</h2>
                        <p class="module-heading-subtitle">Data utama penduduk yang tercatat.</p>
                    </div>
                    <span class="module-badge">Penduduk</span>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-12 col-md-4">
                        <div class="stat-card">
                            <div class="d-flex align-items-center gap-3">
                                <div class="stat-icon blue d-flex align-items-center justify-content-center">
                                    <i class="bi bi-people-fill"></i>
                                </div>
                                <div>
                                    <div class="stat-label">Total Penduduk</div>
                                    <div class="stat-value" id="pendudukTotal">0</div>
                                </div>
                            </div>
                            <div class="stat-desc">Jumlah seluruh warga yang tercatat.</div>
                        </div>
                    </div>

                    <div class="col-12 col-md-4">
                        <div class="stat-card">
                            <div class="d-flex align-items-center gap-3">
                                <div class="stat-icon green d-flex align-items-center justify-content-center">
                                    <i class="bi bi-gender-male"></i>
                                </div>
                                <div>
                                    <div class="stat-label">Laki-laki</div>
                                    <div class="stat-value" id="pendudukLaki">0</div>
                                </div>
                            </div>
                            <div class="stat-desc">Jumlah laki-laki.</div>
                        </div>
                    </div>

                    <div class="col-12 col-md-4">
                        <div class="stat-card">
                            <div class="d-flex align-items-center gap-3">
                                <div class="stat-icon purple d-flex align-items-center justify-content-center">
                                    <i class="bi bi-gender-female"></i>
                                </div>
                                <div>
                                    <div class="stat-label">Perempuan</div>
                                    <div class="stat-value" id="pendudukPerempuan">0</div>
                                </div>
                            </div>
                            <div class="stat-desc">Jumlah perempuan.</div>
                        </div>
                    </div>
                </div>

                <div class="row g-3">
                    <div class="col-12 col-lg-4">
                        <div class="panel h-100">
                            <div class="panel-title">Jenis Kelamin</div>
                            <div class="panel-subtitle">Perbandingan laki-laki dan perempuan.</div>
                            <div class="chart-box-sm">
                                <canvas id="chartPendudukGender"></canvas>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-lg-4">
                        <div class="panel h-100">
                            <div class="panel-title">Penduduk per RT</div>
                            <div class="panel-subtitle">Sebaran warga berdasarkan RT.</div>
                            <div class="chart-box-sm">
                                <canvas id="chartPendudukRt"></canvas>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-lg-4">
                        <div class="panel h-100">
                            <div class="panel-title">Pendidikan</div>
                            <div class="panel-subtitle">Komposisi pendidikan warga.</div>
                            <div class="chart-box-sm">
                                <canvas id="chartPendudukPendidikan"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="module-panel">
                <div class="module-heading">
                    <div>
                        <h2 class="module-heading-title">Data Kelahiran</h2>
                        <p class="module-heading-subtitle">Data kelahiran yang tercatat dalam sistem.</p>
                    </div>
                    <span class="module-badge">Kelahiran</span>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-12 col-md-3">
                        <div class="stat-card">
                            <div class="d-flex align-items-center gap-3">
                                <div class="stat-icon green d-flex align-items-center justify-content-center">
                                    <i class="bi bi-person-plus-fill"></i>
                                </div>
                                <div>
                                    <div class="stat-label">Total</div>
                                    <div class="stat-value" id="kelahiranTotal">0</div>
                                </div>
                            </div>
                            <div class="stat-desc">Total kelahiran.</div>
                        </div>
                    </div>

                    <div class="col-12 col-md-3">
                        <div class="stat-card">
                            <div class="d-flex align-items-center gap-3">
                                <div class="stat-icon blue d-flex align-items-center justify-content-center">
                                    <i class="bi bi-calendar-heart"></i>
                                </div>
                                <div>
                                    <div class="stat-label">Bulan Ini</div>
                                    <div class="stat-value" id="kelahiranBulanIni">0</div>
                                </div>
                            </div>
                            <div class="stat-desc">Kelahiran bulan ini.</div>
                        </div>
                    </div>

                    <div class="col-12 col-md-3">
                        <div class="stat-card">
                            <div class="d-flex align-items-center gap-3">
                                <div class="stat-icon gray d-flex align-items-center justify-content-center">
                                    <i class="bi bi-gender-male"></i>
                                </div>
                                <div>
                                    <div class="stat-label">Laki-laki</div>
                                    <div class="stat-value" id="kelahiranLaki">0</div>
                                </div>
                            </div>
                            <div class="stat-desc">Bayi laki-laki.</div>
                        </div>
                    </div>

                    <div class="col-12 col-md-3">
                        <div class="stat-card">
                            <div class="d-flex align-items-center gap-3">
                                <div class="stat-icon purple d-flex align-items-center justify-content-center">
                                    <i class="bi bi-gender-female"></i>
                                </div>
                                <div>
                                    <div class="stat-label">Perempuan</div>
                                    <div class="stat-value" id="kelahiranPerempuan">0</div>
                                </div>
                            </div>
                            <div class="stat-desc">Bayi perempuan.</div>
                        </div>
                    </div>
                </div>

                <div class="row g-3">
                    <div class="col-12 col-xl-5">
                        <div class="panel h-100">
                            <div class="panel-title">Jenis Kelamin Bayi</div>
                            <div class="panel-subtitle">Distribusi bayi.</div>
                            <div class="chart-box-sm">
                                <canvas id="chartKelahiranGender"></canvas>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-xl-7">
                        <div class="panel h-100">
                            <div class="panel-title">Tren Kelahiran</div>
                            <div class="panel-subtitle">Enam bulan terakhir.</div>
                            <div class="chart-box-sm">
                                <canvas id="chartKelahiranTren"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="module-panel">
                <div class="module-heading">
                    <div>
                        <h2 class="module-heading-title">Data Kematian</h2>
                        <p class="module-heading-subtitle">Data kematian yang tercatat dalam sistem.</p>
                    </div>
                    <span class="module-badge">Kematian</span>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-12 col-md-4">
                        <div class="stat-card">
                            <div class="d-flex align-items-center gap-3">
                                <div class="stat-icon red d-flex align-items-center justify-content-center">
                                    <i class="bi bi-file-earmark-medical-fill"></i>
                                </div>
                                <div>
                                    <div class="stat-label">Total</div>
                                    <div class="stat-value" id="kematianTotal">0</div>
                                </div>
                            </div>
                            <div class="stat-desc">Total kematian.</div>
                        </div>
                    </div>

                    <div class="col-12 col-md-4">
                        <div class="stat-card">
                            <div class="d-flex align-items-center gap-3">
                                <div class="stat-icon blue d-flex align-items-center justify-content-center">
                                    <i class="bi bi-calendar2-week"></i>
                                </div>
                                <div>
                                    <div class="stat-label">Bulan Ini</div>
                                    <div class="stat-value" id="kematianBulanIni">0</div>
                                </div>
                            </div>
                            <div class="stat-desc">Kematian bulan ini.</div>
                        </div>
                    </div>

                    <div class="col-12 col-md-4">
                        <div class="stat-card">
                            <div class="d-flex align-items-center gap-3">
                                <div class="stat-icon gray d-flex align-items-center justify-content-center">
                                    <i class="bi bi-graph-up"></i>
                                </div>
                                <div>
                                    <div class="stat-label">Puncak 6 Bulan</div>
                                    <div class="stat-value" id="kematianPuncak">0</div>
                                </div>
                            </div>
                            <div class="stat-desc" id="kematianPuncakDesc">Puncak tren.</div>
                        </div>
                    </div>
                </div>

                <div class="panel">
                    <div class="panel-title">Tren Kematian</div>
                    <div class="panel-subtitle">Enam bulan terakhir.</div>
                    <div class="chart-box">
                        <canvas id="chartKematianTren"></canvas>
                    </div>
                </div>
            </section>

            <section class="module-panel">
                <div class="module-heading">
                    <div>
                        <h2 class="module-heading-title">Data Lansia</h2>
                        <p class="module-heading-subtitle">Data lansia dan status produktivitas.</p>
                    </div>
                    <span class="module-badge">Lansia</span>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-12 col-md-4">
                        <div class="stat-card">
                            <div class="d-flex align-items-center gap-3">
                                <div class="stat-icon purple d-flex align-items-center justify-content-center">
                                    <i class="bi bi-person-standing"></i>
                                </div>
                                <div>
                                    <div class="stat-label">Total Lansia</div>
                                    <div class="stat-value" id="lansiaTotal">0</div>
                                </div>
                            </div>
                            <div class="stat-desc">Total lansia.</div>
                        </div>
                    </div>

                    <div class="col-12 col-md-4">
                        <div class="stat-card">
                            <div class="d-flex align-items-center gap-3">
                                <div class="stat-icon green d-flex align-items-center justify-content-center">
                                    <i class="bi bi-check-circle-fill"></i>
                                </div>
                                <div>
                                    <div class="stat-label">Produktif</div>
                                    <div class="stat-value" id="lansiaProduktif">0</div>
                                </div>
                            </div>
                            <div class="stat-desc">Lansia produktif.</div>
                        </div>
                    </div>

                    <div class="col-12 col-md-4">
                        <div class="stat-card">
                            <div class="d-flex align-items-center gap-3">
                                <div class="stat-icon red d-flex align-items-center justify-content-center">
                                    <i class="bi bi-exclamation-circle-fill"></i>
                                </div>
                                <div>
                                    <div class="stat-label">Nonproduktif</div>
                                    <div class="stat-value" id="lansiaNonproduktif">0</div>
                                </div>
                            </div>
                            <div class="stat-desc">Perlu perhatian.</div>
                        </div>
                    </div>
                </div>

                <div class="row g-3">
                    <div class="col-12 col-xl-5">
                        <div class="panel h-100">
                            <div class="panel-title">Produktivitas Lansia</div>
                            <div class="panel-subtitle">Produktif dan nonproduktif.</div>
                            <div class="chart-box-sm">
                                <canvas id="chartLansiaProduktivitas"></canvas>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-xl-7">
                        <div class="panel h-100">
                            <div class="panel-title">Insight Data Desa</div>
                            <div class="panel-subtitle">Catatan otomatis.</div>
                            <div class="row g-3" id="insightContainer">
                                <div class="col-12">
                                    <div class="api-loading">
                                        <i class="bi bi-hourglass-split"></i>
                                        Memuat insight data desa...
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

        </main>

        <footer class="footer">
            &copy; <?= date('Y'); ?> Sistem Informasi PKK. Data ditampilkan sesuai wilayah akun yang sedang login.
        </footer>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
const ID_DESA_DASHBOARD = <?= json_encode(session()->get('id_desa') ?? ($id_desa ?? null)); ?>;

const formatNumber = value => new Intl.NumberFormat('id-ID').format(Number(value) || 0);

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

        if (chart.config.type === 'line') {
            ctx.save();
            ctx.textAlign = 'center';
            ctx.textBaseline = 'bottom';
            ctx.fillStyle = '#0f172a';
            ctx.font = '700 11px Arial';

            meta.data.forEach((point, index) => {
                const value = Number(data[index]) || 0;

                if (value > 0) {
                    ctx.fillText(formatNumber(value), point.x, point.y - 8);
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

function makeDoughnut(id, labels, data, colors) {
    const element = document.getElementById(id);

    if (!element) {
        return;
    }

    const total = totalData(data);

    new Chart(element, {
        type: 'doughnut',
        data: {
            labels: labels,
            datasets: [{
                data: data,
                backgroundColor: colors,
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
                        padding: 12,
                        color: '#475569',
                        font: {
                            size: 11,
                            weight: 'bold'
                        },
                        generateLabels(chart) {
                            const labels = chart.data.labels || [];
                            const data = chart.data.datasets[0].data || [];
                            const backgroundColor = chart.data.datasets[0].backgroundColor || [];

                            return labels.map((label, index) => {
                                const value = Number(data[index]) || 0;

                                return {
                                    text: label + ': ' + formatNumber(value),
                                    fillStyle: backgroundColor[index],
                                    strokeStyle: backgroundColor[index],
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
                            const value = Number(ctx.raw) || 0;
                            return ' ' + ctx.label + ': ' + formatNumber(value) + ' (' + percentText(value, total) + ')';
                        }
                    }
                }
            }
        }
    });
}

function makeBar(id, labels, data, color, bgColor, suffix = 'data') {
    const element = document.getElementById(id);

    if (!element) {
        return;
    }

    new Chart(element, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                data: data,
                backgroundColor: bgColor,
                borderColor: color,
                borderWidth: 1.5,
                borderRadius: 6,
                borderSkipped: false,
                maxBarThickness: 36
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
                            return ' ' + formatNumber(ctx.raw) + ' ' + suffix;
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
                    suggestedMax: suggestedMax(data),
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
}

function makeLine(id, label, labels, data, color, bgColor) {
    const element = document.getElementById(id);

    if (!element) {
        return;
    }

    new Chart(element, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: label,
                data: data,
                borderColor: color,
                backgroundColor: bgColor,
                borderWidth: 2,
                tension: 0.35,
                fill: true,
                pointRadius: 4,
                pointHoverRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            layout: {
                padding: {
                    top: 22,
                    left: 4,
                    right: 8,
                    bottom: 4
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
                    suggestedMax: suggestedMax(data),
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
}

function setText(id, value) {
    const element = document.getElementById(id);

    if (element) {
        element.textContent = formatNumber(value);
    }
}

function renderInsight(insights) {
    const container = document.getElementById('insightContainer');

    if (!container) {
        return;
    }

    if (!Array.isArray(insights) || insights.length === 0) {
        container.innerHTML = `
            <div class="col-12">
                <div class="api-loading">
                    <i class="bi bi-info-circle"></i>
                    Belum ada insight yang dapat ditampilkan.
                </div>
            </div>
        `;
        return;
    }

    container.innerHTML = insights.map(item => `
        <div class="col-12 col-md-6">
            <div class="insight-card">
                <div class="d-flex align-items-start gap-3">
                    <div class="insight-icon d-flex align-items-center justify-content-center">
                        <i class="bi ${item.icon || 'bi-info-circle'}"></i>
                    </div>

                    <div>
                        <div class="insight-title">${item.judul || 'Insight Data'}</div>
                        <p class="insight-text">${item.isi || '-'}</p>
                    </div>
                </div>
            </div>
        </div>
    `).join('');
}

function getMaxTrend(trend) {
    if (!Array.isArray(trend) || trend.length === 0) {
        return null;
    }

    let max = trend[0];

    trend.forEach(item => {
        if ((Number(item.jumlah) || 0) > (Number(max.jumlah) || 0)) {
            max = item;
        }
    });

    return max;
}

async function loadDashboardVisualization() {
    if (!ID_DESA_DASHBOARD) {
        renderInsight([]);
        console.warn('id_desa tidak ditemukan di session.');
        return;
    }

    try {
        const response = await fetch(`<?= base_url('api/v1/statistik-dashboard'); ?>?id_desa=${encodeURIComponent(ID_DESA_DASHBOARD)}`, {
            headers: {
                'Accept': 'application/json'
            }
        });

        const result = await response.json();

        if (!result.status) {
            renderInsight([]);
            console.warn(result.message || 'Gagal mengambil statistik dashboard.');
            return;
        }

        const data = result.data || {};
        const ringkasan = data.ringkasan || {};
        const grafik = data.grafik || {};
        const insight = data.insight || [];

        const pendudukRt = grafik.penduduk_per_rt || [];
        const pendidikan = grafik.pendidikan || [];
        const trenKelahiran = grafik.tren_kelahiran || [];
        const trenKematian = grafik.tren_kematian || [];

        setText('pendudukTotal', ringkasan.total_penduduk);
        setText('pendudukLaki', ringkasan.total_laki_laki);
        setText('pendudukPerempuan', ringkasan.total_perempuan);

        setText('kelahiranTotal', ringkasan.total_kelahiran);
        setText('kelahiranBulanIni', ringkasan.kelahiran_bulan_ini);
        setText('kelahiranLaki', ringkasan.kelahiran_laki_laki);
        setText('kelahiranPerempuan', ringkasan.kelahiran_perempuan);

        setText('kematianTotal', ringkasan.total_kematian);
        setText('kematianBulanIni', ringkasan.kematian_bulan_ini);

        const puncakKematian = getMaxTrend(trenKematian);

        if (puncakKematian) {
            setText('kematianPuncak', puncakKematian.jumlah);

            const desc = document.getElementById('kematianPuncakDesc');

            if (desc) {
                desc.textContent = 'Tertinggi pada ' + puncakKematian.bulan + ' ' + puncakKematian.tahun + '.';
            }
        }

        setText('lansiaTotal', ringkasan.total_lansia);
        setText('lansiaProduktif', ringkasan.lansia_produktif);
        setText('lansiaNonproduktif', ringkasan.lansia_nonproduktif);

        makeDoughnut(
            'chartPendudukGender',
            ['Laki-laki', 'Perempuan'],
            [Number(ringkasan.total_laki_laki) || 0, Number(ringkasan.total_perempuan) || 0],
            ['#2f9fb3', '#7655c7']
        );

        makeBar(
            'chartPendudukRt',
            pendudukRt.map(item => 'RT ' + item.rt),
            pendudukRt.map(item => Number(item.total) || 0),
            '#2f9fb3',
            'rgba(47, 159, 179, .18)',
            'warga'
        );

        makeBar(
            'chartPendudukPendidikan',
            pendidikan.map(item => item.pendidikan),
            pendidikan.map(item => Number(item.jumlah) || 0),
            '#36a852',
            'rgba(54, 168, 82, .18)',
            'warga'
        );

        makeDoughnut(
            'chartKelahiranGender',
            ['Laki-laki', 'Perempuan'],
            [Number(ringkasan.kelahiran_laki_laki) || 0, Number(ringkasan.kelahiran_perempuan) || 0],
            ['#36a852', '#f5bd38']
        );

        makeLine(
            'chartKelahiranTren',
            'Kelahiran',
            trenKelahiran.map(item => item.bulan + ' ' + item.tahun),
            trenKelahiran.map(item => Number(item.jumlah) || 0),
            '#36a852',
            'rgba(54, 168, 82, .14)'
        );

        makeLine(
            'chartKematianTren',
            'Kematian',
            trenKematian.map(item => item.bulan + ' ' + item.tahun),
            trenKematian.map(item => Number(item.jumlah) || 0),
            '#dc3f4f',
            'rgba(220, 63, 79, .14)'
        );

        makeDoughnut(
            'chartLansiaProduktivitas',
            ['Produktif', 'Nonproduktif'],
            [Number(ringkasan.lansia_produktif) || 0, Number(ringkasan.lansia_nonproduktif) || 0],
            ['#7655c7', '#94a3b8']
        );

        renderInsight(insight);

    } catch (error) {
        renderInsight([]);
        console.error('Gagal memuat visualisasi dashboard:', error);
    }
}

document.addEventListener('DOMContentLoaded', loadDashboardVisualization);
</script>

</body>
</html>