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
            background:
                radial-gradient(circle at 10% 15%, rgba(47, 159, 179, .08), transparent 28%),
                radial-gradient(circle at 90% 55%, rgba(118, 85, 199, .07), transparent 30%),
                var(--bg);
            color: var(--text);
            font-family: Arial, Helvetica, sans-serif;
            font-size: 15px;
        }

        main {
            flex: 1;
            overflow: hidden;
        }

        a {
            text-decoration: none;
        }

        .navbar {
            background: rgba(255, 255, 255, .94);
            border-bottom: 1px solid var(--border);
            backdrop-filter: blur(10px);
        }

        .navbar .container {
            padding-top: 6px;
            padding-bottom: 6px;
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
            width: 44px;
            height: 44px;
            object-fit: contain;
            filter: drop-shadow(0 4px 10px rgba(15, 23, 42, .12));
        }

        .nav-link {
            color: #334155;
            font-size: 14px;
            font-weight: 700;
            padding: 8px 12px !important;
            border-radius: 9px;
            transition: .18s ease;
        }

        .nav-link:hover {
            color: var(--blue-dark);
            background: #f1f5f9;
        }

        .btn-login {
            background: linear-gradient(135deg, var(--sidebar), var(--sidebar-dark));
            border: 1px solid var(--sidebar);
            color: #ffffff;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 800;
            padding: 10px 16px;
            box-shadow: 0 8px 18px rgba(38, 49, 60, .18);
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: .18s ease;
        }

        .btn-login:hover {
            background: linear-gradient(135deg, var(--sidebar-dark), #17202a);
            border-color: var(--sidebar-dark);
            color: #ffffff;
            transform: translateY(-1px);
        }

        .hero {
            position: relative;
            background:
                radial-gradient(circle at 18% 20%, rgba(47, 159, 179, .34), transparent 28%),
                radial-gradient(circle at 86% 16%, rgba(255, 255, 255, .11), transparent 24%),
                linear-gradient(135deg, #26313c 0%, #202932 52%, #17202a 100%);
            color: #ffffff;
            padding: 72px 0 66px;
            overflow: hidden;
        }

        .hero::before {
            content: "";
            position: absolute;
            top: 48%;
            right: 5%;
            width: 520px;
            height: 520px;
            background-image: url("<?= base_url('logo_pkk_transparan.png'); ?>");
            background-repeat: no-repeat;
            background-size: contain;
            background-position: center;
            opacity: .035;
            transform: translateY(-50%) rotate(-8deg);
            pointer-events: none;
        }

        .hero::after {
            content: "";
            position: absolute;
            left: -130px;
            bottom: -180px;
            width: 380px;
            height: 380px;
            background-image: url("<?= base_url('logo_pkk_transparan.png'); ?>");
            background-repeat: no-repeat;
            background-size: contain;
            background-position: center;
            opacity: .025;
            pointer-events: none;
        }

        .hero .container {
            position: relative;
            z-index: 2;
        }

        .hero-label {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 8px 12px;
            margin-bottom: 18px;
            border-radius: 999px;
            background: rgba(255,255,255,.12);
            border: 1px solid rgba(255,255,255,.20);
            color: rgba(255,255,255,.94);
            font-size: 12px;
            font-weight: 800;
            box-shadow: 0 10px 22px rgba(0,0,0,.08);
        }

        .hero h1 {
            margin: 0 0 14px;
            font-size: 44px;
            font-weight: 900;
            line-height: 1.12;
            letter-spacing: -.7px;
        }

        .hero p {
            max-width: 620px;
            margin: 0 0 24px;
            color: rgba(255,255,255,.84);
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
            border-radius: 12px;
            font-size: 14px;
            font-weight: 800;
            padding: 12px 18px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: .18s ease;
        }

        .btn-hero-primary {
            background: #ffffff;
            color: #202932;
            border: 1px solid #ffffff;
            box-shadow: 0 12px 24px rgba(0,0,0,.16);
        }

        .btn-hero-primary:hover {
            background: #eef2f6;
            color: #202932;
            border-color: #eef2f6;
            transform: translateY(-2px);
        }

        .btn-hero-outline {
            background: rgba(255,255,255,.06);
            color: #ffffff;
            border: 1px solid rgba(255,255,255,.42);
        }

        .btn-hero-outline:hover {
            background: rgba(255,255,255,.13);
            color: #ffffff;
            border-color: rgba(255,255,255,.74);
            transform: translateY(-2px);
        }

        .hero-image-wrap {
            position: relative;
        }

        .hero-image-card {
            background: rgba(255,255,255,.12);
            border: 1px solid rgba(255,255,255,.18);
            border-radius: 24px;
            padding: 12px;
            box-shadow: 0 24px 60px rgba(0,0,0,.24);
            backdrop-filter: blur(10px);
        }

        .hero-img {
            width: 100%;
            max-height: 390px;
            object-fit: cover;
            border-radius: 18px;
            display: block;
            background: #ffffff;
        }

        .hero-mini-card {
            position: absolute;
            left: -12px;
            bottom: 18px;
            width: 210px;
            background: rgba(255,255,255,.96);
            color: #111827;
            border-radius: 16px;
            padding: 13px;
            border: 1px solid var(--border);
            box-shadow: 0 18px 38px rgba(15, 23, 42, .22);
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

        .section {
            padding: 48px 0;
            position: relative;
        }

        .row.g-4 {
            --bs-gutter-x: 14px;
            --bs-gutter-y: 14px;
        }

        .section-title {
            max-width: 760px;
            margin: 0 auto 24px;
            text-align: center;
        }

        .section-title h2 {
            margin: 0 0 10px;
            font-size: 30px;
            font-weight: 900;
            color: #071426;
            letter-spacing: -.4px;
        }

        .section-title p {
            margin: 0;
            color: #475569;
            font-size: 14px;
            line-height: 1.6;
        }

        .section-white {
            background: #ffffff;
            position: relative;
            overflow: visible;
            z-index: 1;
        }

        .section-white::before {
            content: "";
            position: absolute;
            left: 50%;
            top: 50%;
            width: 880px;
            height: 880px;
            background-image: url("<?= base_url('logo_pkk_transparan.png'); ?>");
            background-repeat: no-repeat;
            background-size: contain;
            background-position: center;
            opacity: .028;
            transform: translate(-50%, -50%);
            pointer-events: none;
            z-index: 0;
        }

        .section-white .container {
            position: relative;
            z-index: 2;
        }

        .feature-card,
        .step-card,
        .benefit-card {
            height: 100%;
            background: rgba(255,255,255,.96);
            border: 1px solid var(--border);
            border-radius: 16px;
            box-shadow: 0 5px 16px rgba(15, 23, 42, .055);
            transition: .2s ease;
        }

        .feature-card:hover,
        .step-card:hover,
        .benefit-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 16px 32px rgba(15, 23, 42, .12);
            border-color: rgba(47, 159, 179, .28);
        }

        .feature-card {
            padding: 18px;
        }

        .feature-icon {
            width: 48px;
            height: 48px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 12px;
            font-size: 22px;
            box-shadow: inset 0 0 0 1px rgba(255,255,255,.45);
        }

        .feature-icon.blue {
            background: linear-gradient(135deg, #eff6ff, #dbeafe);
            color: #2563eb;
            border: 1px solid #bfdbfe;
        }

        .feature-icon.green {
            background: linear-gradient(135deg, #ecfdf5, #d1fae5);
            color: #047857;
            border: 1px solid #bbf7d0;
        }

        .feature-icon.red {
            background: linear-gradient(135deg, #fff1f2, #ffe4e6);
            color: #dc2626;
            border: 1px solid #fecdd3;
        }

        .feature-icon.purple {
            background: linear-gradient(135deg, #f5f3ff, #ede9fe);
            color: #7655c7;
            border: 1px solid #ddd6fe;
        }

        .feature-card h5,
        .benefit-card h5,
        .step-card h5 {
            margin: 0 0 7px;
            font-weight: 900;
            color: #111827;
        }

        .feature-card h5,
        .step-card h5 {
            font-size: 17px;
        }

        .benefit-card h5 {
            font-size: 16px;
        }

        .feature-card p,
        .benefit-card p,
        .step-card p {
            margin: 0;
            color: #475569;
            font-size: 13px;
            line-height: 1.5;
        }

        .benefit-card {
            padding: 18px;
            position: relative;
            overflow: hidden;
        }

        .benefit-card::after {
            content: "";
            position: absolute;
            right: -28px;
            top: -28px;
            width: 82px;
            height: 82px;
            border-radius: 50%;
            background: rgba(47, 159, 179, .08);
        }

        .benefit-card i {
            position: relative;
            z-index: 2;
            width: 42px;
            height: 42px;
            border-radius: 13px;
            background: #effafd;
            color: var(--blue-dark);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 21px;
            margin-bottom: 10px;
            border: 1px solid #ccecf2;
        }

        .step-card {
            padding: 20px;
            text-align: center;
        }

        .step-number {
            width: 44px;
            height: 44px;
            margin: 0 auto 12px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--sidebar), var(--blue-dark));
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 900;
            box-shadow: 0 10px 22px rgba(38, 49, 60, .20);
        }

        .cta {
            position: relative;
            overflow: hidden;
            background:
                radial-gradient(circle at top right, rgba(47, 159, 179, .28), transparent 35%),
                linear-gradient(135deg, #26313c, #202932);
            color: #ffffff;
            padding: 56px 0;
        }

        .cta::before {
            content: "";
            position: absolute;
            left: 50%;
            top: 50%;
            width: 500px;
            height: 500px;
            background-image: url("<?= base_url('logo_pkk_transparan.png'); ?>");
            background-repeat: no-repeat;
            background-size: contain;
            background-position: center;
            opacity: .028;
            transform: translate(-50%, -50%);
            pointer-events: none;
        }

        .cta .container {
            position: relative;
            z-index: 2;
        }

        .cta h2 {
            margin: 0 0 10px;
            font-size: 30px;
            font-weight: 900;
            letter-spacing: -.3px;
        }

        .cta p {
            max-width: 650px;
            margin: 0 auto 24px;
            color: rgba(255,255,255,.82);
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

            .navbar-brand img {
                width: 40px;
                height: 40px;
            }

            .hero {
                padding: 52px 0;
            }

            .hero::before {
                width: 340px;
                height: 340px;
                right: -90px;
                opacity: .025;
            }

            .hero::after {
                display: none;
            }

            .hero h1 {
                font-size: 32px;
            }

            .hero p {
                font-size: 14px;
            }

            .hero-actions a {
                width: 100%;
            }

            .hero-image-wrap {
                margin-top: 28px;
            }

            .hero-mini-card {
                position: static;
                width: 100%;
                margin-top: 12px;
            }

            .section {
                padding: 40px 0;
            }

            .row.g-4 {
                --bs-gutter-x: 12px;
                --bs-gutter-y: 12px;
            }

            .section-title {
                margin-bottom: 20px;
            }

            .section-title h2 {
                font-size: 24px;
            }

            .section-white::before {
                width: 520px;
                height: 520px;
                opacity: .026;
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

    <section id="fitur" class="section">
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

    <section id="alur" class="section">
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