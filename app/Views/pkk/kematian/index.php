<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Data Kematian'); ?> | Sistem Informasi PKK</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

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
            --orange: #d97706;
        }

        * {
            box-sizing: border-box;
        }

        html,
        body {
            min-height: 100%;
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
            height: 100vh;
            background: var(--sidebar);
            color: #ffffff;
            position: fixed;
            inset: 0 auto 0 0;
            overflow-y: auto;
            overflow-x: hidden;
            flex-shrink: 0;
            z-index: 1000;
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
            text-align: center;
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
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 18px;
            margin-bottom: 22px;
            flex-wrap: wrap;
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
            margin: 0;
            color: #334155;
            font-size: 14px;
            line-height: 1.55;
            max-width: 720px;
        }

        .page-actions {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .btn-main,
        .btn-export {
            border-radius: 8px;
            font-size: 13px;
            font-weight: 800;
            padding: 10px 14px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            white-space: nowrap;
        }

        .btn-main {
            background: var(--red);
            border: 1px solid var(--red);
            color: #ffffff;
        }

        .btn-main:hover {
            background: #be2f3e;
            color: #ffffff;
        }

        .btn-export {
            background: #ecfdf5;
            border: 1px solid #bbf7d0;
            color: #047857;
        }

        .btn-export:hover {
            background: #047857;
            color: #ffffff;
            border-color: #047857;
        }

        .table-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 6px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0,0,0,.05);
        }

        .table {
            margin: 0;
            font-size: 15px;
        }

        .table thead th {
            background: #f8fafc;
            color: #000000;
            font-size: 13px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: .35px;
            padding: 14px 13px;
            border-bottom: 1px solid var(--border);
            white-space: nowrap;
        }

        .table tbody td {
            padding: 14px 13px;
            vertical-align: middle;
            border-bottom: 1px solid #eef2f6;
            color: #000000;
            font-size: 15px;
            font-weight: 400;
            line-height: 1.45;
        }

        .table tbody tr:hover {
            background: #f8fafc;
        }

        .nama-almarhum {
            color: #000000;
            font-weight: 500;
        }

        .nik-cell {
            color: #000000;
            font-weight: 400;
            white-space: nowrap;
            font-size: 15px;
        }

        .tanggal-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 6px;
            padding: 5px 9px;
            font-size: 13px;
            font-weight: 500;
            white-space: nowrap;
            color: #000000;
            background: #f8fafc;
            border: 1px solid #dfe5ec;
        }

        .keterangan-cell {
            max-width: 360px;
            white-space: normal;
        }

        .action-group {
            display: flex;
            gap: 5px;
            justify-content: center;
            align-items: center;
            flex-wrap: nowrap;
        }

        .action-btn {
            width: 31px;
            height: 31px;
            padding: 0;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 700;
            text-decoration: none;
            border: 1px solid transparent;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .action-btn i {
            margin: 0;
            line-height: 1;
        }

        .action-edit {
            background: #fffbeb;
            color: #d97706;
            border-color: #fde68a;
        }

        .action-edit:hover {
            background: #d97706;
            color: #ffffff;
        }

        .action-delete {
            background: #fff1f2;
            color: #dc2626;
            border-color: #fecdd3;
        }

        .action-delete:hover {
            background: #dc2626;
            color: #ffffff;
        }

        .empty-state {
            padding: 54px 16px;
            text-align: center;
            color: #000000;
        }

        .empty-state i {
            font-size: 34px;
            margin-bottom: 10px;
            color: #6b7280;
        }

        .empty-title {
            font-weight: 700;
            color: #000000;
            margin-bottom: 4px;
        }

        .footer {
            text-align: center;
            color: #475569;
            font-size: 12px;
            padding: 20px;
        }

        @media (max-width: 1180px) {
            .hide-lg {
                display: none;
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
                overflow: visible;
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

            .page-actions {
                width: 100%;
            }

            .btn-main,
            .btn-export {
                flex: 1;
                justify-content: center;
            }

            .table {
                font-size: 14px;
            }

            .table thead th {
                font-size: 12px;
            }

            .table tbody td {
                font-size: 14px;
            }

            .table thead th:nth-child(4),
            .table tbody td:nth-child(4),
            .table thead th:nth-child(5),
            .table tbody td:nth-child(5),
            .hide-mobile {
                display: none;
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
        ['url' => 'pkk/kematian', 'icon' => 'bi-file-earmark-medical-fill', 'label' => 'Data Kematian', 'active' => true],
        ['url' => 'pkk/lansia', 'icon' => 'bi-person-standing', 'label' => 'Data Lansia', 'active' => false],
        ['url' => 'pkk/laporan', 'icon' => 'bi-clipboard-data-fill', 'label' => 'Laporan Bulanan', 'active' => false],
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
                <div>
                    <h1>Data Kematian</h1>
                    <p>Kelola laporan kematian warga berdasarkan wilayah akun yang sedang digunakan.</p>
                </div>

                <div class="page-actions">
                    <a href="<?= base_url('pkk/kematian/export'); ?>" class="btn-export">
                        <i class="bi bi-file-earmark-excel"></i>
                        Unduh Excel
                    </a>

                    <a href="<?= base_url('pkk/kematian/create'); ?>" class="btn-main">
                        <i class="bi bi-plus-lg"></i>
                        Laporkan Kematian
                    </a>
                </div>
            </div>

            <div class="table-card">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>Nama Almarhum/ah</th>
                                <th>NIK</th>
                                <th>Tanggal Wafat</th>
                                <th>Tempat Wafat</th>
                                <th>Penyebab / Keterangan</th>
                                <th class="text-center" style="width: 90px;">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php if (empty($kematian)) : ?>
                                <tr>
                                    <td colspan="6">
                                        <div class="empty-state">
                                            <i class="bi bi-file-earmark-medical"></i>
                                            <div class="empty-title">Belum ada data kematian</div>
                                            <div>Tambahkan laporan kematian pertama untuk desa ini.</div>
                                        </div>
                                    </td>
                                </tr>
                            <?php else : ?>
                                <?php foreach ($kematian as $row) : ?>
                                    <?php
                                        $idKematian = $row['id_kematian'] ?? '';
                                        $namaAlmarhum = $row['nama_almarhum'] ?? '-';
                                        $nik = $row['nik'] ?? '-';
                                        $tempatKematian = $row['tempat_kematian'] ?? '-';
                                        $keterangan = !empty($row['keterangan']) ? $row['keterangan'] : '-';

                                        $tanggalKematian = '-';
                                        if (!empty($row['tgl_kematian'])) {
                                            $tanggalKematian = date('d-m-Y', strtotime($row['tgl_kematian']));
                                        }
                                    ?>

                                    <tr>
                                        <td class="nama-almarhum"><?= esc($namaAlmarhum); ?></td>
                                        <td class="nik-cell"><?= esc($nik); ?></td>
                                        <td>
                                            <span class="tanggal-badge"><?= esc($tanggalKematian); ?></span>
                                        </td>
                                        <td><?= esc($tempatKematian); ?></td>
                                        <td class="keterangan-cell"><?= esc($keterangan); ?></td>
                                        <td>
                                            <div class="action-group">
                                                <a href="<?= base_url('pkk/kematian/edit/' . rawurlencode((string) $idKematian)); ?>"
                                                   class="action-btn action-edit"
                                                   title="Edit">
                                                    <i class="bi bi-pencil-square"></i>
                                                </a>

                                                <a href="<?= base_url('pkk/kematian/delete/' . rawurlencode((string) $idKematian)); ?>"
                                                   class="action-btn action-delete"
                                                   title="Hapus"
                                                   onclick="return confirm('Hapus laporan kematian ini?')">
                                                    <i class="bi bi-trash"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </main>

        <footer class="footer">
            &copy; <?= date('Y'); ?> Sistem Informasi PKK. Data ditampilkan sesuai wilayah akun yang sedang login.
        </footer>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>