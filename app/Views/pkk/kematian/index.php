<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Data Kematian'); ?> | Sistem PKK Desa</title>

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
            --muted: #6b7280;

            --blue: #2f9fb3;
            --green: #36a852;
            --red: #dc3f4f;
            --orange: #d97706;
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
            min-height: 104px;
            display: flex;
            align-items: center;
            gap: 20px;
            padding: 16px 18px;
            background: var(--sidebar-dark);
            border-bottom: 1px solid rgba(255,255,255,0.08);
        }

        .brand-logo {
            width: 58px;
            height: 58px;
            border-radius: 8px;
            background: #000000;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: visible;
            flex-shrink: 0;
        }

        .brand-logo img {
            width: 86px;
            height: 86px;
            object-fit: contain;
            display: block;
            max-width: none;
        }

        .brand-fallback {
            width: 58px;
            height: 58px;
            display: none;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            font-size: 32px;
        }

        .brand-title {
            font-size: 15px;
            font-weight: 700;
            line-height: 1.25;
        }

        .brand-sub {
            font-size: 11px;
            color: rgba(255,255,255,.65);
            margin-top: 3px;
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
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 18px;
            margin-bottom: 20px;
            flex-wrap: wrap;
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

        .page-actions {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .btn-main,
        .btn-export {
            border-radius: 7px;
            font-size: 13px;
            font-weight: 700;
            padding: 9px 14px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 7px;
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
            color: var(--muted);
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
            }

            .brand {
                min-height: 88px;
                gap: 18px;
            }

            .brand-logo {
                width: 52px;
                height: 52px;
            }

            .brand-logo img {
                width: 76px;
                height: 76px;
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

            .page-actions {
                width: 100%;
            }

            .btn-main,
            .btn-export {
                flex: 1;
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

<div class="layout">

    <aside class="sidebar">
        <div class="brand">
            <div class="brand-logo">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQW1UaLjSzyJHXgFrBM7F6BfRZnA0MLAz7Lsg&s"
                     alt="Logo PKK"
                     referrerpolicy="no-referrer"
                     onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                <div class="brand-fallback">
                    <i class="bi bi-flower1"></i>
                </div>
            </div>

            <div>
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
            <a href="<?= base_url('pkk/dashboard'); ?>">
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

            <a href="<?= base_url('pkk/kematian'); ?>" class="active">
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
                    <p>Kelola laporan kematian warga berdasarkan wilayah akun yang sedang login.</p>
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
            &copy; <?= date('Y'); ?> Sistem PKK Desa. Data ditampilkan sesuai wilayah akun yang sedang login.
        </footer>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>