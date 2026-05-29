<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Dashboard Ketua PKK'); ?> | Sistem PKK Desa</title>

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
            --text: #1f2937;
            --muted: #6b7280;
            --blue: #2f9fb3;
            --green: #36a852;
            --red: #dc3f4f;
            --purple: #7655c7;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            background: var(--bg);
            color: var(--text);
            font-family: Arial, Helvetica, sans-serif;
            font-size: 14px;
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
            gap: 8px;
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
            font-size: 16px;
            font-weight: 800;
            line-height: 1.25;
            letter-spacing: .3px;
            color: #ffffff;
        }

        .brand-sub {
            font-size: 11px;
            color: rgba(255,255,255,.68);
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
            color: rgba(255,255,255,.45);
            text-transform: uppercase;
            letter-spacing: .6px;
        }

        .menu {
            padding: 0 10px 18px;
        }

        .menu-link {
            color: rgba(255,255,255,.78);
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
            margin: 0 0 6px;
            font-size: 29px;
            font-weight: 700;
            color: #0f172a;
        }

        .page-title p,
        .panel-subtitle,
        .summary-label,
        .summary-desc,
        .footer {
            color: var(--muted);
        }

        .section-title {
            margin: 10px 0 14px;
            font-size: 17px;
            font-weight: 700;
            color: var(--text);
        }

        .module-card {
            color: #ffffff;
            border-radius: 6px;
            min-height: 140px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 2px 5px rgba(0,0,0,.12);
        }

        .module-card.blue {
            background: var(--blue);
        }

        .module-card.green {
            background: var(--green);
        }

        .module-card.red {
            background: var(--red);
        }

        .module-card.purple {
            background: var(--purple);
        }

        .module-main {
            padding: 30px 18px 14px;
            position: relative;
            z-index: 2;
        }

        .module-title {
            font-size: 30px;
            font-weight: 700;
            line-height: 1.1;
            margin-bottom: 6px;
        }

        .module-desc {
            font-size: 13px;
            opacity: .92;
            margin: 0;
        }

        .module-icon-bg {
            position: absolute;
            right: 18px;
            top: 26px;
            font-size: 56px;
            color: rgba(0,0,0,.18);
            z-index: 1;
        }

        .module-footer {
            position: absolute;
            left: 0;
            right: 0;
            bottom: 0;
            height: 38px;
            background: rgba(0,0,0,.14);
            color: rgba(255,255,255,.95);
            font-size: 12px;
            font-weight: 700;
            text-decoration: none;
            z-index: 3;
        }

        .module-footer:hover {
            color: #ffffff;
            background: rgba(0,0,0,.24);
        }

        .export-panel,
        .summary-card,
        .panel {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 6px;
            box-shadow: 0 1px 3px rgba(0,0,0,.05);
        }

        .export-panel {
            padding: 18px 20px;
            margin-bottom: 26px;
        }

        .export-icon {
            width: 46px;
            height: 46px;
            border-radius: 8px;
            background: #ecfdf5;
            border: 1px solid #bbf7d0;
            color: #047857;
            font-size: 22px;
            flex-shrink: 0;
        }

        .export-title {
            font-size: 16px;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 3px;
        }

        .export-desc {
            font-size: 13px;
            color: var(--muted);
            margin: 0;
        }

        .btn-export-all {
            background: #047857;
            border: 1px solid #047857;
            color: #ffffff;
            border-radius: 7px;
            font-size: 13px;
            font-weight: 700;
            padding: 10px 15px;
            text-decoration: none;
            white-space: nowrap;
        }

        .btn-export-all:hover {
            background: #065f46;
            color: #ffffff;
            border-color: #065f46;
        }

        .summary-card,
        .panel {
            padding: 16px;
        }

        .summary-label {
            font-size: 12px;
            margin-bottom: 8px;
        }

        .summary-value {
            font-size: 27px;
            font-weight: 700;
            line-height: 1;
        }

        .summary-desc {
            font-size: 12px;
            margin-top: 10px;
            line-height: 1.5;
        }

        .panel-title {
            font-size: 14px;
            font-weight: 700;
            margin-bottom: 3px;
        }

        .panel-subtitle {
            font-size: 12px;
            margin-bottom: 14px;
        }

        .chart-box {
            position: relative;
            height: 235px;
        }

        .footer {
            text-align: center;
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
                font-size: 22px;
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

            .export-panel {
                align-items: stretch !important;
            }

            .btn-export-all {
                width: 100%;
                justify-content: center;
            }

            .chart-box {
                height: 250px;
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
    ];

    $modules = [
        [
            'class' => 'blue',
            'title' => 'Penduduk',
            'desc' => 'Pengelolaan data dasar penduduk desa.',
            'icon' => 'bi-people-fill',
            'url' => 'pkk/penduduk',
        ],
        [
            'class' => 'green',
            'title' => 'Kelahiran',
            'desc' => 'Pencatatan data kelahiran warga desa.',
            'icon' => 'bi-person-plus-fill',
            'url' => 'pkk/kelahiran',
        ],
        [
            'class' => 'red',
            'title' => 'Kematian',
            'desc' => 'Pencatatan data kematian warga desa.',
            'icon' => 'bi-file-earmark-medical-fill',
            'url' => 'pkk/kematian',
        ],
        [
            'class' => 'purple',
            'title' => 'Lansia',
            'desc' => 'Pemantauan data dan kondisi warga lansia.',
            'icon' => 'bi-person-standing',
            'url' => 'pkk/lansia',
        ],
    ];

    $summaries = [
        [
            'label' => 'Penduduk Laki-laki',
            'value' => $total_laki_laki ?? 0,
            'desc' => 'Jumlah warga laki-laki yang tercatat.',
        ],
        [
            'label' => 'Penduduk Perempuan',
            'value' => $total_perempuan ?? 0,
            'desc' => 'Jumlah warga perempuan yang tercatat.',
        ],
        [
            'label' => 'Lansia Produktif',
            'value' => $total_lansia_produktif ?? 0,
            'desc' => 'Lansia dengan status produktif.',
        ],
        [
            'label' => 'Lansia Nonproduktif',
            'value' => $total_lansia_nonproduktif ?? 0,
            'desc' => 'Lansia dengan status nonproduktif.',
        ],
    ];
?>

<div class="layout">

    <aside class="sidebar">
        <div class="brand d-flex flex-column align-items-center justify-content-center text-center">
            <div class="brand-logo d-flex align-items-center justify-content-center">
                <img src="/logo_pkk_transparan.png?v=3"
                     alt="Logo PKK"
                     onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                <div class="brand-fallback">
                    <i class="bi bi-flower1"></i>
                </div>
            </div>

            <div class="w-100">
                <div class="brand-title">PKK DESA</div>
                <div class="brand-sub">Sistem Data Wilayah</div>
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
                <h1>Sistem Informasi Data PKK <?= esc($nama_desa ?? 'Desa'); ?></h1>
                <p>Ringkasan data wilayah kerja Ketua PKK berdasarkan data yang telah tercatat dalam sistem.</p>
            </div>

            <div class="section-title">Menu Modul</div>

            <div class="row g-3 mb-3">
                <?php foreach ($modules as $module) : ?>
                    <div class="col-12 col-md-6 col-xl-3">
                        <div class="module-card <?= esc($module['class']); ?>">
                            <div class="module-main">
                                <div class="module-title"><?= esc($module['title']); ?></div>
                                <p class="module-desc"><?= esc($module['desc']); ?></p>
                            </div>

                            <i class="bi <?= esc($module['icon']); ?> module-icon-bg"></i>

                            <a href="<?= base_url($module['url']); ?>" class="module-footer d-flex align-items-center justify-content-center gap-1">
                                Selengkapnya <i class="bi bi-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="export-panel d-flex align-items-center justify-content-between gap-3 flex-column flex-md-row">
                <div class="d-flex align-items-center gap-3">
                    <div class="export-icon d-flex align-items-center justify-content-center">
                        <i class="bi bi-file-earmark-excel"></i>
                    </div>

                    <div>
                        <div class="export-title">Unduh Rekap Data Desa</div>
                        <p class="export-desc">
                            Mengunduh seluruh data penduduk, kelahiran, kematian, dan lansia dalam satu file Excel.
                        </p>
                    </div>
                </div>

                <a href="<?= base_url('pkk/export-all'); ?>" class="btn-export-all d-inline-flex align-items-center gap-2">
                    <i class="bi bi-download"></i>
                    Unduh Semua Data
                </a>
            </div>

            <div class="section-title">Ringkasan Statistik</div>

            <div class="row g-3 mb-4">
                <?php foreach ($summaries as $summary) : ?>
                    <div class="col-12 col-md-6 col-xl-3">
                        <div class="summary-card h-100">
                            <div class="summary-label"><?= esc($summary['label']); ?></div>
                            <div class="summary-value"><?= esc($summary['value']); ?></div>
                            <div class="summary-desc"><?= esc($summary['desc']); ?></div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="section-title">Visualisasi Statistik</div>

            <div class="row g-3 mb-3">
                <div class="col-12 col-lg-4">
                    <div class="panel h-100">
                        <div class="panel-title">Jenis Kelamin Penduduk</div>
                        <div class="panel-subtitle">Perbandingan laki-laki dan perempuan.</div>
                        <div class="chart-box">
                            <canvas id="genderChart"></canvas>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-lg-4">
                    <div class="panel h-100">
                        <div class="panel-title">Jenis Kelamin Kelahiran</div>
                        <div class="panel-subtitle">Distribusi bayi laki-laki dan perempuan.</div>
                        <div class="chart-box">
                            <canvas id="kelahiranChart"></canvas>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-lg-4">
                    <div class="panel h-100">
                        <div class="panel-title">Produktivitas Lansia</div>
                        <div class="panel-subtitle">Produktif dan nonproduktif.</div>
                        <div class="chart-box">
                            <canvas id="lansiaChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-3">
                <div class="col-12 col-xl-6">
                    <div class="panel h-100">
                        <div class="panel-title">Penduduk per RT</div>
                        <div class="panel-subtitle">Sebaran jumlah warga di setiap RT.</div>
                        <div class="chart-box">
                            <canvas id="rtChart"></canvas>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-xl-6">
                    <div class="panel h-100">
                        <div class="panel-title">Tingkat Pendidikan</div>
                        <div class="panel-subtitle">Komposisi pendidikan warga desa.</div>
                        <div class="chart-box">
                            <canvas id="pendidikanChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

        </main>

        <footer class="footer">
            &copy; <?= date('Y'); ?> Sistem PKK Desa. Data ditampilkan sesuai wilayah akun yang sedang login.
        </footer>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
const D = {
    gender: {
        labels: <?= json_encode($chart_gender['labels'] ?? ['Laki-laki', 'Perempuan']); ?>,
        data: <?= json_encode($chart_gender['data'] ?? [0, 0]); ?>
    },
    kelahiran: {
        labels: <?= json_encode($chart_kelahiran['labels'] ?? ['Laki-laki', 'Perempuan']); ?>,
        data: <?= json_encode($chart_kelahiran['data'] ?? [0, 0]); ?>
    },
    lansia: {
        labels: <?= json_encode($chart_lansia['labels'] ?? ['Produktif', 'Nonproduktif']); ?>,
        data: <?= json_encode($chart_lansia['data'] ?? [0, 0]); ?>
    },
    rt: {
        labels: <?= json_encode($chart_rt['labels'] ?? []); ?>,
        data: <?= json_encode($chart_rt['data'] ?? []); ?>
    },
    pendidikan: {
        labels: <?= json_encode($chart_pendidikan['labels'] ?? []); ?>,
        data: <?= json_encode($chart_pendidikan['data'] ?? []); ?>
    }
};

const formatNumber = value => new Intl.NumberFormat('id-ID').format(Number(value) || 0);

const totalData = data => {
    return Array.isArray(data)
        ? data.reduce((sum, value) => sum + (Number(value) || 0), 0)
        : 0;
};

const hasData = data => Array.isArray(data) && data.some(value => Number(value) > 0);

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

const CHART_NUMBER_PLUGIN = {
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
            const total = totalData(data);

            ctx.save();
            ctx.textAlign = 'center';
            ctx.textBaseline = 'middle';
            ctx.fillStyle = '#64748b';
            ctx.font = '700 12px Arial';
            ctx.fillText('Total', centerX, centerY - 10);

            ctx.fillStyle = '#0f172a';
            ctx.font = '800 20px Arial';
            ctx.fillText(formatNumber(total), centerX, centerY + 12);
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

Chart.register(CHART_NUMBER_PLUGIN);

function donut(id, dataset, colors) {
    const total = totalData(dataset.data);

    new Chart(document.getElementById(id), {
        type: 'doughnut',
        data: {
            labels: dataset.labels,
            datasets: [{
                data: dataset.data,
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
                        padding: 14,
                        color: '#64748b',
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
                                    text: label + ': ' + formatNumber(value) + ' (' + percentText(value, total) + ')',
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

function bar(id, dataset, color, bgColor) {
    new Chart(document.getElementById(id), {
        type: 'bar',
        data: {
            labels: dataset.labels,
            datasets: [{
                data: dataset.data,
                backgroundColor: bgColor,
                borderColor: color,
                borderWidth: 1.5,
                borderRadius: 6,
                borderSkipped: false,
                maxBarThickness: 38
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
                            return ' ' + formatNumber(ctx.raw) + ' warga';
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
                        color: '#64748b',
                        font: {
                            size: 11
                        }
                    }
                },
                y: {
                    beginAtZero: true,
                    suggestedMax: suggestedMax(dataset.data),
                    border: {
                        display: false
                    },
                    grid: {
                        color: 'rgba(148, 163, 184, 0.22)'
                    },
                    ticks: {
                        precision: 0,
                        color: '#64748b',
                        font: {
                            size: 11
                        }
                    }
                }
            }
        }
    });
}

donut('genderChart', D.gender, ['#2f9fb3', '#7655c7']);
donut('kelahiranChart', D.kelahiran, ['#36a852', '#f5bd38']);
donut('lansiaChart', D.lansia, ['#7655c7', '#94a3b8']);

bar('rtChart', D.rt, '#2f9fb3', 'rgba(47, 159, 179, .18)');
bar('pendidikanChart', D.pendidikan, '#36a852', 'rgba(54, 168, 82, .18)');
</script>

</body>
</html>