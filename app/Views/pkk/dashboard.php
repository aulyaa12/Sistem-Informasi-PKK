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
            flex-shrink: 0;
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            overflow-y: auto;
        }

        .brand {
            min-height: 185px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 22px 16px 18px;
            background: var(--sidebar-dark);
            border-bottom: 1px solid rgba(255,255,255,0.08);
            text-align: center;
        }

        .brand-logo {
            width: 132px;
            height: 120px;
            border-radius: 0;
            background: transparent;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: visible;
            flex-shrink: 0;
            box-shadow: none;
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

        .brand-text {
            width: 100%;
            line-height: 1.25;
            margin-top: 2px;
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
            display: flex;
            align-items: center;
            gap: 11px;
        }

        .profile-avatar {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background: #3b82f6;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            flex-shrink: 0;
        }

        .profile-name {
            font-weight: 700;
            font-size: 13px;
        }

        .profile-role {
            display: inline-block;
            margin-top: 4px;
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

        .menu a {
            color: rgba(255,255,255,.78);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 11px 12px;
            border-radius: 6px;
            font-size: 13px;
            transition: .15s ease;
        }

        .menu a:hover,
        .menu a.active {
            background: rgba(255,255,255,.10);
            color: #ffffff;
        }

        .menu i {
            width: 18px;
            text-align: center;
            font-size: 15px;
        }

        .content {
            margin-left: 245px;
            width: calc(100% - 245px);
            min-height: 100vh;
        }

        .main {
            padding: 28px;
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

        .page-title p {
            margin: 0;
            color: var(--muted);
            font-size: 14px;
        }

        .section-title {
            margin: 10px 0 14px;
            font-size: 17px;
            font-weight: 700;
            color: var(--text);
        }

        .cards-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
            margin-bottom: 16px;
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
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            font-size: 12px;
            font-weight: 700;
            text-decoration: none;
            z-index: 3;
        }

        .module-footer:hover {
            color: #ffffff;
            background: rgba(0,0,0,.24);
        }

        .export-panel {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 6px;
            padding: 18px 20px;
            margin: 0 0 26px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 18px;
            box-shadow: 0 1px 3px rgba(0,0,0,.05);
        }

        .export-panel-left {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .export-icon {
            width: 46px;
            height: 46px;
            border-radius: 8px;
            background: #ecfdf5;
            border: 1px solid #bbf7d0;
            color: #047857;
            display: flex;
            align-items: center;
            justify-content: center;
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
            display: inline-flex;
            align-items: center;
            gap: 7px;
            white-space: nowrap;
        }

        .btn-export-all:hover {
            background: #065f46;
            color: #ffffff;
            border-color: #065f46;
        }

        .summary-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
            margin-bottom: 26px;
        }

        .summary-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 6px;
            padding: 16px;
            box-shadow: 0 1px 3px rgba(0,0,0,.05);
        }

        .summary-label {
            color: var(--muted);
            font-size: 12px;
            margin-bottom: 8px;
        }

        .summary-value {
            font-size: 27px;
            font-weight: 700;
            line-height: 1;
        }

        .summary-desc {
            color: var(--muted);
            font-size: 12px;
            margin-top: 10px;
            line-height: 1.5;
        }

        .chart-grid-top {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
            margin-bottom: 16px;
        }

        .chart-grid-bottom {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 16px;
            margin-bottom: 24px;
        }

        .panel {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 6px;
            padding: 16px;
            box-shadow: 0 1px 3px rgba(0,0,0,.05);
        }

        .panel-title {
            font-size: 14px;
            font-weight: 700;
            margin-bottom: 3px;
        }

        .panel-subtitle {
            color: var(--muted);
            font-size: 12px;
            margin-bottom: 14px;
        }

        .chart-box {
            position: relative;
            height: 235px;
        }

        .footer {
            text-align: center;
            color: var(--muted);
            font-size: 12px;
            padding: 20px;
        }

        @media (max-width: 1180px) {
            .cards-grid,
            .summary-grid,
            .chart-grid-top {
                grid-template-columns: repeat(2, 1fr);
            }
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

            .brand {
                min-height: 165px;
                gap: 7px;
                padding: 18px 16px 16px;
            }

            .brand-logo {
                width: 118px;
                height: 106px;
                border-radius: 0;
                background: transparent;
                border: none;
                box-shadow: none;
                overflow: visible;
            }

            .brand-logo img {
                width: 118px;
                height: 106px;
                transform: scale(1.05);
            }

            .content {
                margin-left: 0;
                width: 100%;
            }

            .main {
                padding: 16px;
            }

            .page-title h1 {
                font-size: 22px;
            }

            .cards-grid,
            .summary-grid,
            .chart-grid-top,
            .chart-grid-bottom {
                grid-template-columns: 1fr;
            }

            .export-panel {
                flex-direction: column;
                align-items: stretch;
            }

            .export-panel-left {
                align-items: flex-start;
            }

            .btn-export-all {
                width: 100%;
                justify-content: center;
            }

            .profile {
                display: none;
            }

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

            .menu a {
                white-space: nowrap;
                flex-shrink: 0;
            }

            .chart-box {
                height: 250px;
            }
        }
    </style>
</head>

<body>

<div class="layout">

    <aside class="sidebar">
        <div class="brand">
            <div class="brand-logo">
                <img src="/logo_pkk_transparan.png?v=3"
                     alt="Logo PKK"
                     onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                <div class="brand-fallback">
                    <i class="bi bi-flower1"></i>
                </div>
            </div>

            <div class="brand-text">
                <div class="brand-title">PKK DESA</div>
                <div class="brand-sub">Sistem Data Wilayah</div>
            </div>
        </div>

        <div class="profile">
            <div class="profile-avatar">
                <i class="bi bi-person-fill"></i>
            </div>
            <div>
                <div class="profile-name"><?= esc(session()->get('username') ?? 'Ketua PKK'); ?></div>
                <span class="profile-role">Ketua PKK</span>
            </div>
        </div>

        <div class="menu-label">Menu Utama</div>

        <nav class="menu">
            <a href="<?= base_url('pkk/dashboard'); ?>" class="active">
                <i class="bi bi-speedometer2"></i>
                Dashboard
            </a>

            <a href="<?= base_url('pkk/penduduk'); ?>">
                <i class="bi bi-people-fill"></i>
                Data Penduduk
            </a>

            <a href="<?= base_url('pkk/kelahiran'); ?>">
                <i class="bi bi-person-plus-fill"></i>
                Data Kelahiran
            </a>

            <a href="<?= base_url('pkk/kematian'); ?>">
                <i class="bi bi-file-earmark-medical-fill"></i>
                Data Kematian
            </a>

            <a href="<?= base_url('pkk/lansia'); ?>">
                <i class="bi bi-person-standing"></i>
                Data Lansia
            </a>
        </nav>

        <div class="menu-label">Akun</div>

        <nav class="menu">
            <a href="<?= base_url('logout'); ?>">
                <i class="bi bi-box-arrow-right"></i>
                Logout
            </a>
        </nav>
    </aside>

    <div class="content">
        <main class="main">

            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success">
                    <?= session()->getFlashdata('success'); ?>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger">
                    <?= session()->getFlashdata('error'); ?>
                </div>
            <?php endif; ?>

            <div class="page-title">
                <h1>Sistem Informasi Data PKK <?= esc($nama_desa ?? 'Desa'); ?></h1>
                <p>Ringkasan data wilayah kerja Ketua PKK berdasarkan data yang telah tercatat dalam sistem.</p>
            </div>

            <div class="section-title">Menu Modul</div>

            <div class="cards-grid">
                <div class="module-card blue">
                    <div class="module-main">
                        <div class="module-title">Penduduk</div>
                        <p class="module-desc">Pengelolaan data dasar penduduk desa.</p>
                    </div>
                    <i class="bi bi-people-fill module-icon-bg"></i>
                    <a href="<?= base_url('pkk/penduduk'); ?>" class="module-footer">
                        Selengkapnya <i class="bi bi-arrow-circle-right"></i>
                    </a>
                </div>

                <div class="module-card green">
                    <div class="module-main">
                        <div class="module-title">Kelahiran</div>
                        <p class="module-desc">Pencatatan data kelahiran warga desa.</p>
                    </div>
                    <i class="bi bi-person-plus-fill module-icon-bg"></i>
                    <a href="<?= base_url('pkk/kelahiran'); ?>" class="module-footer">
                        Selengkapnya <i class="bi bi-arrow-circle-right"></i>
                    </a>
                </div>

                <div class="module-card red">
                    <div class="module-main">
                        <div class="module-title">Kematian</div>
                        <p class="module-desc">Pencatatan data kematian warga desa.</p>
                    </div>
                    <i class="bi bi-file-earmark-medical-fill module-icon-bg"></i>
                    <a href="<?= base_url('pkk/kematian'); ?>" class="module-footer">
                        Selengkapnya <i class="bi bi-arrow-circle-right"></i>
                    </a>
                </div>

                <div class="module-card purple">
                    <div class="module-main">
                        <div class="module-title">Lansia</div>
                        <p class="module-desc">Pemantauan data dan kondisi warga lansia.</p>
                    </div>
                    <i class="bi bi-person-standing module-icon-bg"></i>
                    <a href="<?= base_url('pkk/lansia'); ?>" class="module-footer">
                        Selengkapnya <i class="bi bi-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            <div class="export-panel">
                <div class="export-panel-left">
                    <div class="export-icon">
                        <i class="bi bi-file-earmark-excel"></i>
                    </div>

                    <div>
                        <div class="export-title">Unduh Rekap Data Desa</div>
                        <p class="export-desc">
                            Mengunduh seluruh data penduduk, kelahiran, kematian, dan lansia dalam satu file Excel.
                        </p>
                    </div>
                </div>

                <a href="<?= base_url('pkk/export-all'); ?>" class="btn-export-all">
                    <i class="bi bi-download"></i>
                    Unduh Semua Data
                </a>
            </div>

            <div class="section-title">Ringkasan Statistik</div>

            <div class="summary-grid">
                <div class="summary-card">
                    <div class="summary-label">Penduduk Laki-laki</div>
                    <div class="summary-value"><?= esc($total_laki_laki ?? 0); ?></div>
                    <div class="summary-desc">Jumlah warga laki-laki yang tercatat.</div>
                </div>

                <div class="summary-card">
                    <div class="summary-label">Penduduk Perempuan</div>
                    <div class="summary-value"><?= esc($total_perempuan ?? 0); ?></div>
                    <div class="summary-desc">Jumlah warga perempuan yang tercatat.</div>
                </div>

                <div class="summary-card">
                    <div class="summary-label">Lansia Produktif</div>
                    <div class="summary-value"><?= esc($total_lansia_produktif ?? 0); ?></div>
                    <div class="summary-desc">Lansia dengan status produktif.</div>
                </div>

                <div class="summary-card">
                    <div class="summary-label">Lansia Nonproduktif</div>
                    <div class="summary-value"><?= esc($total_lansia_nonproduktif ?? 0); ?></div>
                    <div class="summary-desc">Lansia dengan status nonproduktif.</div>
                </div>
            </div>

            <div class="section-title">Visualisasi Statistik</div>

            <div class="chart-grid-top">
                <div class="panel">
                    <div class="panel-title">Jenis Kelamin Penduduk</div>
                    <div class="panel-subtitle">Perbandingan laki-laki dan perempuan.</div>
                    <div class="chart-box">
                        <canvas id="genderChart"></canvas>
                    </div>
                </div>

                <div class="panel">
                    <div class="panel-title">Jenis Kelamin Kelahiran</div>
                    <div class="panel-subtitle">Distribusi bayi laki-laki dan perempuan.</div>
                    <div class="chart-box">
                        <canvas id="kelahiranChart"></canvas>
                    </div>
                </div>

                <div class="panel">
                    <div class="panel-title">Produktivitas Lansia</div>
                    <div class="panel-subtitle">Produktif dan nonproduktif.</div>
                    <div class="chart-box">
                        <canvas id="lansiaChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="chart-grid-bottom">
                <div class="panel">
                    <div class="panel-title">Penduduk per RT</div>
                    <div class="panel-subtitle">Sebaran jumlah warga di setiap RT.</div>
                    <div class="chart-box">
                        <canvas id="rtChart"></canvas>
                    </div>
                </div>

                <div class="panel">
                    <div class="panel-title">Tingkat Pendidikan</div>
                    <div class="panel-subtitle">Komposisi pendidikan warga desa.</div>
                    <div class="chart-box">
                        <canvas id="pendidikanChart"></canvas>
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

const hasData = data => Array.isArray(data) && data.some(value => Number(value) > 0);

const EMPTY_PLUGIN = {
    id: 'emptyState',
    afterDraw(chart) {
        const data = chart.data.datasets[0]?.data || [];

        if (!hasData(data)) {
            const { ctx, width, height } = chart;

            ctx.save();
            ctx.textAlign = 'center';
            ctx.textBaseline = 'middle';
            ctx.fillStyle = '#94a3b8';
            ctx.font = '600 13px Arial';
            ctx.fillText('Belum ada data', width / 2, height / 2);
            ctx.restore();
        }
    }
};

Chart.register(EMPTY_PLUGIN);

function donut(id, dataset, colors) {
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
                        font: {
                            size: 11,
                            weight: 'bold'
                        },
                        color: '#64748b'
                    }
                },
                tooltip: {
                    callbacks: {
                        label: ctx => ' ' + ctx.label + ': ' + ctx.raw
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
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: ctx => ' ' + ctx.raw + ' warga'
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