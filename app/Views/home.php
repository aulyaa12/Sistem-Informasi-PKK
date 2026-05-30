<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Informasi PKK</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">

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
            --blue-dark: #247e91;
            --green: #36a852;
            --green-dark: #2b8b43;
            --red: #dc3f4f;
            --purple: #7655c7;
            --yellow: #f5bd38;
        }

        * {
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            min-height: 100vh;
            margin: 0;
            display: flex;
            flex-direction: column;
            background: var(--bg);
            color: var(--text);
            font-family: Arial, Helvetica, sans-serif;
            font-size: 15px;
        }

        main {
            flex: 1;
        }

        a {
            text-decoration: none;
        }

        .navbar {
            background: #ffffff;
            border-bottom: 1px solid var(--border);
        }

        .navbar-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 15px;
            font-weight: 800;
            color: #111827;
            letter-spacing: .2px;
        }

        .navbar-brand:hover {
            color: #111827;
        }

        .navbar-brand img {
            width: 42px;
            height: 42px;
            object-fit: contain;
        }

        .nav-link {
            color: #334155;
            font-size: 14px;
            font-weight: 700;
            padding: 8px 12px !important;
        }

        .nav-link:hover {
            color: var(--blue);
        }

        .btn-login {
            background: var(--sidebar);
            border: 1px solid var(--sidebar);
            color: #ffffff;
            border-radius: 9px;
            font-size: 13px;
            font-weight: 800;
            padding: 9px 15px;
        }

        .btn-login:hover {
            background: var(--sidebar-dark);
            border-color: var(--sidebar-dark);
            color: #ffffff;
        }

        .hero {
            position: relative;
            background:
                radial-gradient(circle at top left, rgba(47, 159, 179, .22), transparent 35%),
                linear-gradient(135deg, #26313c, #202932);
            color: #ffffff;
            padding: 76px 0;
            overflow: hidden;
        }

        .hero .container {
            position: relative;
            z-index: 2;
        }

        .hero-label {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 7px 11px;
            margin-bottom: 18px;
            border-radius: 999px;
            background: rgba(255,255,255,.10);
            border: 1px solid rgba(255,255,255,.18);
            color: rgba(255,255,255,.92);
            font-size: 12px;
            font-weight: 800;
        }

        .hero h1 {
            margin: 0 0 14px;
            font-size: 42px;
            font-weight: 800;
            line-height: 1.15;
            letter-spacing: -.5px;
        }

        .hero p {
            max-width: 620px;
            margin: 0 0 24px;
            color: rgba(255,255,255,.82);
            font-size: 16px;
            line-height: 1.65;
        }

        .hero-actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .btn-hero-primary,
        .btn-hero-outline {
            border-radius: 10px;
            font-size: 14px;
            font-weight: 800;
            padding: 12px 17px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-hero-primary {
            background: #ffffff;
            color: #202932;
            border: 1px solid #ffffff;
        }

        .btn-hero-primary:hover {
            background: #eef2f6;
            color: #202932;
            border-color: #eef2f6;
        }

        .btn-hero-outline {
            background: transparent;
            color: #ffffff;
            border: 1px solid rgba(255,255,255,.45);
        }

        .btn-hero-outline:hover {
            background: rgba(255,255,255,.10);
            color: #ffffff;
            border-color: rgba(255,255,255,.72);
        }

        .hero-image-wrap {
            position: relative;
        }

        .hero-image-card {
            background: rgba(255,255,255,.10);
            border: 1px solid rgba(255,255,255,.16);
            border-radius: 22px;
            padding: 14px;
            box-shadow: 0 24px 60px rgba(0,0,0,.22);
        }

        .hero-img {
            width: 100%;
            max-height: 390px;
            object-fit: cover;
            border-radius: 16px;
            display: block;
            background: #ffffff;
        }

        .hero-mini-card {
            position: absolute;
            left: -14px;
            bottom: 20px;
            width: 210px;
            background: #ffffff;
            color: #111827;
            border-radius: 14px;
            padding: 13px;
            border: 1px solid var(--border);
            box-shadow: 0 16px 35px rgba(15, 23, 42, .20);
        }

        .hero-mini-card-title {
            font-size: 13px;
            font-weight: 800;
            margin-bottom: 4px;
        }

        .hero-mini-card-text {
            font-size: 12px;
            color: #475569;
            line-height: 1.45;
        }

        .white-logo-area {
            position: relative;
            background: #ffffff;
            overflow: hidden;
        }

        .white-logo-area::before {
            content: "";
            position: absolute;
            left: 50%;
            top: 50%;
            width: 780px;
            height: 780px;
            background-image: url("<?= base_url('logo_pkk_transparan.png'); ?>");
            background-repeat: no-repeat;
            background-size: contain;
            background-position: center;
            opacity: .025;
            transform: translate(-50%, -50%);
            pointer-events: none;
        }

        .white-logo-area .container {
            position: relative;
            z-index: 2;
        }

        .section {
            padding: 62px 0;
            position: relative;
        }

        .section-white {
            background: transparent;
        }

        .section-title {
            max-width: 760px;
            margin: 0 auto 32px;
            text-align: center;
        }

        .section-title h2 {
            margin: 0 0 10px;
            font-size: 30px;
            font-weight: 800;
            color: #071426;
            letter-spacing: -.3px;
        }

        .section-title p {
            margin: 0;
            color: #475569;
            font-size: 14px;
            line-height: 1.6;
        }

        .feature-card,
        .step-card,
        .benefit-card {
            height: 100%;
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 14px;
            box-shadow: 0 2px 8px rgba(15, 23, 42, .045);
            transition: .18s ease;
        }

        .feature-card:hover,
        .step-card:hover,
        .benefit-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 22px rgba(15, 23, 42, .10);
        }

        .feature-card {
            padding: 20px;
        }

        .feature-icon {
            width: 46px;
            height: 46px;
            border-radius: 12x;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 14px;
            font-size: 22px;
        }

        .feature-icon.blue {
            background: #eff6ff;
            color: #2563eb;
            border: 1px solid #bfdbfe;
        }

        .feature-icon.green {
            background: #ecfdf5;
            color: #047857;
            border: 1px solid #bbf7d0;
        }

        .feature-icon.red {
            background: #fff1f2;
            color: #dc2626;
            border: 1px solid #fecdd3;
        }

        .feature-icon.purple {
            background: #f5f3ff;
            color: #7655c7;
            border: 1px solid #ddd6fe;
        }

        .feature-card h5 {
            margin: 0 0 8px;
            font-size: 17px;
            font-weight: 800;
            color: #111827;
        }

        .feature-card p {
            margin: 0;
            color: #475569;
            font-size: 13px;
            line-height: 1.55;
        }

        .benefit-card {
            padding: 18px;
        }

        .benefit-card i {
            color: var(--blue);
            font-size: 22px;
            margin-bottom: 10px;
        }

        .benefit-card h5 {
            margin: 0 0 7px;
            font-size: 16px;
            font-weight: 800;
            color: #111827;
        }

        .benefit-card p {
            margin: 0;
            color: #475569;
            font-size: 13px;
            line-height: 1.55;
        }

        .step-card {
            padding: 22px;
            text-align: center;
        }

        .step-number {
            width: 42px;
            height: 42px;
            margin: 0 auto 14px;
            border-radius: 50%;
            background: var(--sidebar);
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
        }

        .step-card h5 {
            margin: 0 0 8px;
            font-size: 17px;
            font-weight: 800;
            color: #111827;
        }

        .step-card p {
            margin: 0;
            color: #475569;
            font-size: 13px;
            line-height: 1.55;
        }

        .cta {
            background:
                radial-gradient(circle at top right, rgba(47, 159, 179, .22), transparent 35%),
                linear-gradient(135deg, #26313c, #202932);
            color: #ffffff;
            padding: 58px 0;
        }

        .cta h2 {
            margin: 0 0 10px;
            font-size: 30px;
            font-weight: 800;
            letter-spacing: -.3px;
        }

        .cta p {
            max-width: 650px;
            margin: 0 auto 24px;
            color: rgba(255,255,255,.80);
            font-size: 15px;
            line-height: 1.6;
        }

        .footer {
            background: #202932;
            color: rgba(255,255,255,.82);
            padding: 18px 0;
            font-size: 13px;
        }

        .footer a {
            color: rgba(255,255,255,.92);
            font-weight: 700;
        }

        .footer a:hover {
            color: #ffffff;
        }

        @media (max-width: 780px) {
            .navbar-brand {
                font-size: 13px;
            }

            .hero {
                padding: 54px 0;
            }

            .hero h1 {
                font-size: 31px;
            }

            .hero p {
                font-size: 14px;
            }

            .hero-actions a {
                width: 100%;
            }

            .hero-image-wrap {
                margin-top: 30px;
            }

            .hero-mini-card {
                position: static;
                width: 100%;
                margin-top: 12px;
            }

            .white-logo-area::before {
                width: 430px;
                height: 430px;
                opacity: .045;
            }

            .section {
                padding: 46px 0;
            }

            .section-title h2 {
                font-size: 24px;
            }

            .cta h2 {
                font-size: 24px;
            }
        }
    </style>
</head>

<body>

<nav class="navbar navbar-expand-lg sticky-top shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="<?= base_url('/'); ?>">
            <img src="<?= base_url('logo_pkk_transparan.png'); ?>" alt="Logo PKK">
            <span>Sistem Informasi PKK</span>
        </a>

        <button class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarNav"
                aria-controls="navbarNav"
                aria-expanded="false"
                aria-label="Buka menu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse mt-3 mt-lg-0" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-1">
                <li class="nav-item">
                    <a class="nav-link" href="#fitur">Fitur</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#manfaat">Manfaat</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#alur">Alur Kerja</a>
                </li>
                <li class="nav-item mt-2 mt-lg-0 ms-lg-2">
                    <a class="btn-login" href="<?= base_url('login'); ?>">
                        <i class="bi bi-box-arrow-in-right"></i>
                        Masuk
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<main>

    <header class="hero">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-6">
                    <div class="hero-label">
                        <i class="bi bi-flower1"></i>
                        Pendataan PKK Desa
                    </div>

                    <h1>Sistem Informasi PKK</h1>

                    <p>
                        Kelola data penduduk, kelahiran, kematian, dan lansia dalam satu sistem yang rapi,
                        mudah digunakan, dan siap direkap kapan saja.
                    </p>

                    <div class="hero-actions">
                        <a href="<?= base_url('register'); ?>" class="btn-hero-primary">
                            <i class="bi bi-person-plus"></i>
                            Daftar Akun PKK
                        </a>

                        <a href="#fitur" class="btn-hero-outline">
                            <i class="bi bi-grid-3x3-gap"></i>
                            Lihat Fitur
                        </a>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="hero-image-wrap">
                        <div class="hero-image-card">
                            <img src="<?= base_url('gambarpkk.png'); ?>"
                                 alt="Ilustrasi PKK Desa"
                                 class="hero-img">
                        </div>

                        <div class="hero-mini-card">
                            <div class="hero-mini-card-title">
                                <i class="bi bi-check-circle-fill text-success me-1"></i>
                                Data lebih tertata
                            </div>
                            <div class="hero-mini-card-text">
                                Rekap data desa dapat diunduh dan dipantau melalui dashboard.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div class="white-logo-area">

        <section id="fitur" class="section section-white">
            <div class="container">
                <div class="section-title">
                    <h2>Modul Utama Sistem Informasi PKK</h2>
                    <p>
                        Empat modul utama disiapkan untuk membantu pengelolaan data warga desa secara lebih terstruktur.
                    </p>
                </div>

                <div class="row g-4">
                    <div class="col-12 col-md-6 col-xl-3">
                        <div class="feature-card">
                            <div class="feature-icon blue">
                                <i class="bi bi-people-fill"></i>
                            </div>
                            <h5>Data Penduduk</h5>
                            <p>
                                Mengelola biodata warga, NIK, No. KK, RT, pendidikan, pekerjaan, dan status pernikahan.
                            </p>
                        </div>
                    </div>

                    <div class="col-12 col-md-6 col-xl-3">
                        <div class="feature-card">
                            <div class="feature-icon green">
                                <i class="bi bi-person-plus-fill"></i>
                            </div>
                            <h5>Data Kelahiran</h5>
                            <p>
                                Mencatat data kelahiran anak, nama ibu, tempat lahir, tanggal lahir, dan usia bayi.
                            </p>
                        </div>
                    </div>

                    <div class="col-12 col-md-6 col-xl-3">
                        <div class="feature-card">
                            <div class="feature-icon red">
                                <i class="bi bi-file-earmark-medical-fill"></i>
                            </div>
                            <h5>Data Kematian</h5>
                            <p>
                                Mengelola laporan kematian warga, tanggal wafat, tempat wafat, dan keterangan pendukung.
                            </p>
                        </div>
                    </div>

                    <div class="col-12 col-md-6 col-xl-3">
                        <div class="feature-card">
                            <div class="feature-icon purple">
                                <i class="bi bi-person-standing"></i>
                            </div>
                            <h5>Data Lansia</h5>
                            <p>
                                Memantau data lansia, umur, hobi, produktivitas, dan catatan pemantauan warga lansia.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="manfaat" class="section section-white">
            <div class="container">
                <div class="section-title">
                    <h2>Manfaat untuk Pengelolaan Data PKK</h2>
                    <p>
                        Sistem ini membantu data PKK lebih mudah dicatat, dicari, direkap, dan digunakan untuk kebutuhan laporan.
                    </p>
                </div>

                <div class="row g-4">
                    <div class="col-12 col-md-4">
                        <div class="benefit-card">
                            <i class="bi bi-folder-check"></i>
                            <h5>Data Lebih Rapi</h5>
                            <p>
                                Setiap data tersimpan berdasarkan modul sehingga lebih mudah ditemukan dan diperbarui.
                            </p>
                        </div>
                    </div>

                    <div class="col-12 col-md-4">
                        <div class="benefit-card">
                            <i class="bi bi-bar-chart-line"></i>
                            <h5>Ringkasan Mudah Dibaca</h5>
                            <p>
                                Dashboard menampilkan ringkasan data utama agar kondisi wilayah cepat dipantau.
                            </p>
                        </div>
                    </div>

                    <div class="col-12 col-md-4">
                        <div class="benefit-card">
                            <i class="bi bi-file-earmark-excel"></i>
                            <h5>Siap Direkap</h5>
                            <p>
                                Data dapat diunduh dalam format Excel untuk kebutuhan arsip dan pelaporan.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="alur" class="section section-white">
            <div class="container">
                <div class="section-title">
                    <h2>Tiga Langkah Mulai Mengelola Data</h2>
                    <p>
                        Pengguna dapat membuat akun, menunggu verifikasi, lalu mulai mengelola data sesuai wilayah.
                    </p>
                </div>

                <div class="row g-4">
                    <div class="col-12 col-md-4">
                        <div class="step-card">
                            <div class="step-number">1</div>
                            <h5>Daftar Akun PKK</h5>
                            <p>
                                Isi data akun dan pilih wilayah desa untuk mengajukan akses ke sistem.
                            </p>
                        </div>
                    </div>

                    <div class="col-12 col-md-4">
                        <div class="step-card">
                            <div class="step-number">2</div>
                            <h5>Verifikasi Admin</h5>
                            <p>
                                Admin memeriksa akun yang diajukan sebelum pengguna dapat mengakses sistem.
                            </p>
                        </div>
                    </div>

                    <div class="col-12 col-md-4">
                        <div class="step-card">
                            <div class="step-number">3</div>
                            <h5>Kelola Data PKK</h5>
                            <p>
                                Pengguna dapat mengelola data, melihat dashboard, dan mengunduh rekap Excel.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>

    <section class="cta text-center">
        <div class="container">
            <h2>Mulai Kelola Data PKK Secara Lebih Tertata</h2>
            <p>
                Gunakan Sistem Informasi PKK untuk membantu pencatatan data warga, kelahiran, kematian,
                lansia, dan laporan desa dalam satu tempat.
            </p>

            <div class="d-flex flex-column flex-md-row justify-content-center gap-2">
                <a href="<?= base_url('register'); ?>" class="btn-hero-primary">
                    <i class="bi bi-person-plus"></i>
                    Daftar Akun PKK
                </a>

                <a href="<?= base_url('login'); ?>" class="btn-hero-outline">
                    <i class="bi bi-box-arrow-in-right"></i>
                    Sudah Punya Akun
                </a>
            </div>
        </div>
    </section>

</main>

<footer class="footer mt-auto">
    <div class="container d-flex flex-column flex-md-row justify-content-between align-items-center gap-2">
        <span>&copy; <?= date('Y'); ?> Sistem Informasi PKK. Hak cipta dilindungi.</span>
        <a href="<?= base_url('admin/login'); ?>">Admin</a>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>