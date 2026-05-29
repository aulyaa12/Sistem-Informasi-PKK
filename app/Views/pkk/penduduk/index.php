<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Data Penduduk'); ?> | Sistem PKK Desa</title>

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
            --blue-dark: #278b9d;
            --green: #047857;
            --green-soft: #ecfdf5;
            --red: #dc2626;
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

        a {
            text-decoration: none;
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
            z-index: 1000;
        }

        /* Logo dibuat sama seperti tampilan dashboard */
        .brand {
            min-height: 185px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 22px 16px 18px;
            background: var(--sidebar-dark);
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
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
            color: rgba(255, 255, 255, .68);
            margin-top: 4px;
        }

        .profile {
            padding: 18px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
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
            color: rgba(255, 255, 255, .45);
            text-transform: uppercase;
            letter-spacing: .6px;
        }

        .menu {
            padding: 0 10px 18px;
        }

        .menu a {
            color: rgba(255, 255, 255, .78);
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
            background: rgba(255, 255, 255, .10);
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
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
        }

        .btn-main {
            background: var(--blue);
            border: 1px solid var(--blue);
            color: #ffffff;
        }

        .btn-main:hover {
            background: var(--blue-dark);
            border-color: var(--blue-dark);
            color: #ffffff;
        }

        .btn-export {
            background: var(--green-soft);
            border: 1px solid #bbf7d0;
            color: var(--green);
        }

        .btn-export:hover {
            background: var(--green);
            border-color: var(--green);
            color: #ffffff;
        }

        .filter-card,
        .table-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 6px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, .05);
        }

        .filter-card {
            padding: 16px;
            margin-bottom: 18px;
        }

        .filter-card label {
            font-size: 13px;
            font-weight: 800;
            color: #111827;
            margin-bottom: 6px;
        }

        .filter-card .form-control,
        .filter-card .form-select {
            border-radius: 6px;
            border: 1px solid var(--border);
            font-size: 14px;
            color: #111827;
            padding: 9px 11px;
        }

        .filter-card .form-control::placeholder {
            color: #6b7280;
        }

        .filter-card .form-control:focus,
        .filter-card .form-select:focus {
            border-color: var(--blue);
            box-shadow: 0 0 0 3px rgba(47, 159, 179, .12);
        }

        .btn-filter {
            border: 0;
            border-radius: 6px;
            background: var(--sidebar);
            color: #ffffff;
            font-size: 13px;
            font-weight: 700;
            padding: 10px 14px;
        }

        .btn-filter:hover {
            background: #111827;
            color: #ffffff;
        }

        .btn-reset {
            border-radius: 6px;
            background: #ffffff;
            border: 1px solid var(--border);
            color: #111827;
            font-size: 13px;
            font-weight: 700;
            padding: 10px 14px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn-reset:hover {
            color: #000000;
            border-color: #111827;
        }

        .table-card {
            overflow: hidden;
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

        .nik-cell {
            color: #000000;
            font-weight: 400;
            white-space: nowrap;
            font-size: 15px;
        }

        .text-muted-small {
            color: #000000;
            font-size: 14px;
            font-weight: 400;
        }

        .badge-laki,
        .badge-perempuan,
        .rt-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 6px;
            padding: 5px 9px;
            font-size: 13px;
            font-weight: 500;
            white-space: nowrap;
            min-width: 64px;
            color: #000000;
            background: #f8fafc;
            border: 1px solid #dfe5ec;
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
            border: 1px solid transparent;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .action-detail {
            background: #eff6ff;
            color: #2563eb;
            border-color: #bfdbfe;
        }

        .action-detail:hover {
            background: #2563eb;
            color: #ffffff;
        }

        .action-edit {
            background: #fffbeb;
            color: var(--orange);
            border-color: #fde68a;
        }

        .action-edit:hover {
            background: var(--orange);
            color: #ffffff;
        }

        .action-delete {
            background: #fff1f2;
            color: var(--red);
            border-color: #fecdd3;
        }

        .action-delete:hover {
            background: var(--red);
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

        .table-footer {
            padding: 12px 16px;
            border-top: 1px solid var(--border);
            background: #fafafa;
            display: flex;
            justify-content: flex-end;
        }

        .table-footer .pagination {
            margin: 0;
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

            .page-actions {
                width: 100%;
            }

            .btn-main,
            .btn-export {
                flex: 1;
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
                border-top: 1px solid rgba(255, 255, 255, 0.08);
            }

            .menu a {
                white-space: nowrap;
                flex-shrink: 0;
            }

            .table {
                font-size: 14px;
            }

            .table thead th,
            .table tbody td {
                font-size: 14px;
            }

            .table thead th:nth-child(2),
            .table tbody td:nth-child(2),
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
            <a href="<?= base_url('pkk/dashboard'); ?>">
                <i class="bi bi-speedometer2"></i>
                Dashboard
            </a>

            <a href="<?= base_url('pkk/penduduk'); ?>" class="active">
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
            <?php if (session()->getFlashdata('success')) : ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?= session()->getFlashdata('success'); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')) : ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?= session()->getFlashdata('error'); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <div class="page-title">
                <div>
                    <h1>Data Penduduk</h1>
                    <p>Kelola biodata warga desa berdasarkan wilayah akun yang sedang login.</p>
                </div>

                <div class="page-actions">
                    <a href="<?= base_url('pkk/penduduk/export'); ?>" class="btn-export">
                        <i class="bi bi-file-earmark-excel"></i>
                        Unduh Excel
                    </a>

                    <a href="<?= base_url('pkk/penduduk/create'); ?>" class="btn-main">
                        <i class="bi bi-plus-lg"></i>
                        Tambah Penduduk
                    </a>
                </div>
            </div>

            <div class="filter-card">
                <form action="<?= base_url('pkk/penduduk'); ?>" method="get">
                    <div class="row g-2 align-items-end">
                        <div class="col-12 col-md-4">
                            <label for="keyword" class="form-label">Kata Kunci</label>
                            <input type="text"
                                   id="keyword"
                                   name="keyword"
                                   class="form-control"
                                   placeholder="Cari nama, NIK, atau No. KK"
                                   value="<?= esc($keyword ?? ''); ?>">
                        </div>

                        <div class="col-6 col-md-2">
                            <label for="rt" class="form-label">RT</label>
                            <select id="rt" name="rt" class="form-select">
                                <option value="">Semua RT</option>
                                <?php for ($i = 1; $i <= 16; $i++) : ?>
                                    <option value="<?= $i; ?>" <?= (($rt_terpilih ?? '') == $i) ? 'selected' : ''; ?>>
                                        RT <?= $i; ?>
                                    </option>
                                <?php endfor; ?>
                            </select>
                        </div>

                        <div class="col-6 col-md-3">
                            <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                            <select id="jenis_kelamin" name="jenis_kelamin" class="form-select">
                                <option value="">Semua</option>
                                <option value="L" <?= (($jk_terpilih ?? '') == 'L') ? 'selected' : ''; ?>>Laki-laki</option>
                                <option value="P" <?= (($jk_terpilih ?? '') == 'P') ? 'selected' : ''; ?>>Perempuan</option>
                            </select>
                        </div>

                        <div class="col-12 col-md-3 d-flex gap-2">
                            <button type="submit" class="btn-filter w-100">
                                <i class="bi bi-search"></i>
                                Cari
                            </button>

                            <?php if (!empty($keyword) || !empty($rt_terpilih) || !empty($jk_terpilih)) : ?>
                                <a href="<?= base_url('pkk/penduduk'); ?>" class="btn-reset">
                                    Reset
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </form>
            </div>

            <div class="table-card">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>NIK</th>
                                <th>No. KK</th>
                                <th>Nama Lengkap</th>
                                <th>Kelamin</th>
                                <th>Usia</th>
                                <th class="hide-lg">Pekerjaan</th>
                                <th class="hide-lg">Status Nikah</th>
                                <th>RT</th>
                                <th class="text-center" style="width: 120px;">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php if (empty($penduduk)) : ?>
                                <tr>
                                    <td colspan="9">
                                        <div class="empty-state">
                                            <i class="bi bi-people"></i>
                                            <div class="empty-title">Belum ada data penduduk</div>
                                            <div>Tambahkan data penduduk pertama untuk desa ini.</div>
                                        </div>
                                    </td>
                                </tr>
                            <?php else : ?>
                                <?php foreach ($penduduk as $row) : ?>
                                    <?php
                                        $nik = $row['nik'] ?? '';
                                        $nama = $row['nama'] ?? '-';

                                        $umur = '-';
                                        if (!empty($row['tgl_lahir'])) {
                                            try {
                                                $tgl = new DateTime($row['tgl_lahir']);
                                                $today = new DateTime('today');
                                                $umur = $today->diff($tgl)->y;
                                            } catch (Throwable $e) {
                                                $umur = '-';
                                            }
                                        }
                                    ?>

                                    <tr>
                                        <td class="nik-cell"><?= esc($nik); ?></td>
                                        <td class="text-muted-small"><?= esc($row['no_kk'] ?? '-'); ?></td>
                                        <td><?= esc($nama); ?></td>
                                        <td>
                                            <?php if (($row['jenis_kelamin'] ?? '') === 'L') : ?>
                                                <span class="badge-laki">Laki-laki</span>
                                            <?php elseif (($row['jenis_kelamin'] ?? '') === 'P') : ?>
                                                <span class="badge-perempuan">Perempuan</span>
                                            <?php else : ?>
                                                <span class="text-muted-small">-</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if ($umur !== '-') : ?>
                                                <?= esc($umur); ?>
                                                <span class="text-muted-small">thn</span>
                                            <?php else : ?>
                                                <span class="text-muted-small">-</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="hide-lg"><?= esc($row['pekerjaan'] ?? '-'); ?></td>
                                        <td class="hide-lg">
                                            <?= esc(ucwords(str_replace('_', ' ', $row['status_pernikahan'] ?? '-'))); ?>
                                        </td>
                                        <td>
                                            <span class="rt-badge">RT <?= esc($row['RT'] ?? '-'); ?></span>
                                        </td>
                                        <td>
                                            <div class="action-group">
                                                <a href="<?= base_url('pkk/penduduk/detail/' . rawurlencode($nik)); ?>"
                                                   class="action-btn action-detail"
                                                   title="Detail">
                                                    <i class="bi bi-eye"></i>
                                                </a>

                                                <a href="<?= base_url('pkk/penduduk/edit/' . rawurlencode($nik)); ?>"
                                                   class="action-btn action-edit"
                                                   title="Edit">
                                                    <i class="bi bi-pencil-square"></i>
                                                </a>

                                                <a href="<?= base_url('pkk/penduduk/delete/' . rawurlencode($nik)); ?>"
                                                   class="action-btn action-delete"
                                                   title="Hapus"
                                                   onclick="return confirm('Hapus data <?= esc($nama); ?>?')">
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

                <?php if (!empty($penduduk) && isset($pager)) : ?>
                    <div class="table-footer">
                        <?= $pager->links('penduduk', 'default_full'); ?>
                    </div>
                <?php endif; ?>
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