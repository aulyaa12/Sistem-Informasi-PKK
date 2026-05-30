-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 30 Bulan Mei 2026 pada 17.37
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `apkpkk`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `api_requests`
--

CREATE TABLE `api_requests` (
  `id` int(11) UNSIGNED NOT NULL,
  `nama_instansi` varchar(150) NOT NULL,
  `keperluan` text NOT NULL,
  `api_token` varchar(64) DEFAULT NULL,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `desa`
--

CREATE TABLE `desa` (
  `id_desa` varchar(50) NOT NULL,
  `nama_desa` varchar(100) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `desa`
--

INSERT INTO `desa` (`id_desa`, `nama_desa`, `created_at`, `updated_at`) VALUES
('3101010001', 'PULAU TIDUNG', '2026-05-28 17:57:58', '2026-05-28 17:57:58'),
('3401010002', 'SINDUTAN', '2026-05-28 11:59:13', '2026-05-28 11:59:13'),
('5272011009', 'SANTI', '2026-05-28 13:52:01', '2026-05-28 13:52:01'),
('740221', 'KURAA', '2026-05-28 11:49:42', '2026-05-30 19:28:10'),
('7403142006', 'AMENDETE', '2026-05-30 17:24:02', '2026-05-30 17:24:02');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kelahiran`
--

CREATE TABLE `kelahiran` (
  `id_kelahiran` int(11) UNSIGNED NOT NULL,
  `id_desa` varchar(50) NOT NULL,
  `nik_ibu` char(16) NOT NULL,
  `nama_bayi` varchar(100) NOT NULL,
  `jenis_kelamin` enum('L','P') NOT NULL,
  `tempat_lahir` varchar(100) NOT NULL,
  `tgl_lahir` date NOT NULL,
  `umur_bulan` int(11) NOT NULL DEFAULT 0,
  `keterangan` varchar(500) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kelahiran`
--

INSERT INTO `kelahiran` (`id_kelahiran`, `id_desa`, `nik_ibu`, `nama_bayi`, `jenis_kelamin`, `tempat_lahir`, `tgl_lahir`, `umur_bulan`, `keterangan`, `created_at`, `updated_at`) VALUES
(239, '740221', '7402210202910037', 'Muhammad Al-Fatih', 'L', 'Kuraa', '2026-03-12', 2, 'Lahir Hidup', '2026-05-30 20:11:19', '2026-05-30 20:11:19'),
(240, '740221', '7402210202920027', 'Aliando', 'L', 'Kuraa', '2026-02-05', 3, 'Lahir Hidup', '2026-05-30 20:11:19', '2026-05-30 20:11:19'),
(241, '740221', '7402210202980039', 'Bagas', 'L', 'Kuraa', '2026-01-23', 4, 'Lahir Hidup', '2026-05-30 20:11:19', '2026-05-30 20:11:19'),
(242, '740221', '7402210202850036', 'Siti Fatimah', 'P', 'Kuraa', '2026-01-08', 4, 'Lahir Hidup', '2026-05-30 20:11:19', '2026-05-30 20:11:19'),
(243, '740221', '7402210202890031', 'Aliando', 'L', 'Kuraa', '2026-03-01', 2, 'Lahir Hidup', '2026-05-30 20:11:19', '2026-05-30 20:11:19'),
(244, '740221', '7402210202970025', 'Bagas', 'L', 'Kuraa', '2026-02-20', 3, 'Lahir Hidup', '2026-05-30 20:11:19', '2026-05-30 20:11:19'),
(245, '740221', '7402210202000024', 'Putri Kirana', 'P', 'Kuraa', '2026-04-25', 1, 'Lahir Hidup', '2026-05-30 20:11:19', '2026-05-30 20:11:19'),
(246, '740221', '7402210202860022', 'Siti Fatimah', 'P', 'Kuraa', '2026-02-10', 3, 'Lahir Hidup', '2026-05-30 20:11:19', '2026-05-30 20:11:19'),
(247, '740221', '7402210202050040', 'Amira Zhafira', 'P', 'Kuraa', '2026-03-13', 2, 'Lahir Hidup', '2026-05-30 20:11:19', '2026-05-30 20:11:19'),
(248, '740221', '7402210202000034', 'Aliando', 'L', 'Kuraa', '2026-03-28', 2, 'Lahir Hidup', '2026-05-30 20:11:19', '2026-05-30 20:11:19'),
(249, '740221', '7402210202020023', 'Ahmad Rizky', 'L', 'Kuraa', '2026-04-08', 1, 'Lahir Hidup', '2026-05-30 20:11:19', '2026-05-30 20:11:19'),
(250, '740221', '7402210202960035', 'Fathir', 'L', 'Kuraa', '2026-03-30', 2, 'Lahir Hidup', '2026-05-30 20:11:19', '2026-05-30 20:11:19'),
(251, '740221', '7402210202990028', 'Siti Fatimah', 'P', 'Kuraa', '2026-04-28', 1, 'Lahir Hidup', '2026-05-30 20:11:19', '2026-05-30 20:11:19'),
(252, '740221', '7402210202810026', 'Rendra', 'L', 'Kuraa', '2026-01-21', 4, 'Lahir Hidup', '2026-05-30 20:11:19', '2026-05-30 20:11:19'),
(253, '740221', '7402210202940021', 'Clarissa', 'P', 'Kuraa', '2026-04-03', 1, 'Lahir Hidup', '2026-05-30 20:11:19', '2026-05-30 20:11:19'),
(254, '740221', '7402210202910037', 'Muhammad Al-Fatih', 'L', 'Kuraa', '2026-03-12', 2, 'Lahir Hidup', '2026-05-30 20:11:35', '2026-05-30 20:11:35'),
(255, '740221', '7402210202920027', 'Aliando', 'L', 'Kuraa', '2026-02-05', 3, 'Lahir Hidup', '2026-05-30 20:11:35', '2026-05-30 20:11:35'),
(256, '740221', '7402210202980039', 'Bagas', 'L', 'Kuraa', '2026-01-23', 4, 'Lahir Hidup', '2026-05-30 20:11:35', '2026-05-30 20:11:35'),
(257, '740221', '7402210202850036', 'Siti Fatimah', 'P', 'Kuraa', '2026-01-08', 4, 'Lahir Hidup', '2026-05-30 20:11:35', '2026-05-30 20:11:35'),
(258, '740221', '7402210202890031', 'Aliando', 'L', 'Kuraa', '2026-03-01', 2, 'Lahir Hidup', '2026-05-30 20:11:35', '2026-05-30 20:11:35'),
(259, '740221', '7402210202970025', 'Bagas', 'L', 'Kuraa', '2026-02-20', 3, 'Lahir Hidup', '2026-05-30 20:11:35', '2026-05-30 20:11:35'),
(260, '740221', '7402210202000024', 'Putri Kirana', 'P', 'Kuraa', '2026-04-25', 1, 'Lahir Hidup', '2026-05-30 20:11:35', '2026-05-30 20:11:35'),
(261, '740221', '7402210202860022', 'Siti Fatimah', 'P', 'Kuraa', '2026-02-10', 3, 'Lahir Hidup', '2026-05-30 20:11:35', '2026-05-30 20:11:35'),
(262, '740221', '7402210202050040', 'Amira Zhafira', 'P', 'Kuraa', '2026-03-13', 2, 'Lahir Hidup', '2026-05-30 20:11:35', '2026-05-30 20:11:35'),
(263, '740221', '7402210202000034', 'Aliando', 'L', 'Kuraa', '2026-03-28', 2, 'Lahir Hidup', '2026-05-30 20:11:35', '2026-05-30 20:11:35'),
(264, '740221', '7402210202020023', 'Ahmad Rizky', 'L', 'Kuraa', '2026-04-08', 1, 'Lahir Hidup', '2026-05-30 20:11:35', '2026-05-30 20:11:35'),
(265, '740221', '7402210202960035', 'Fathir', 'L', 'Kuraa', '2026-03-30', 2, 'Lahir Hidup', '2026-05-30 20:11:35', '2026-05-30 20:11:35'),
(266, '740221', '7402210202990028', 'Siti Fatimah', 'P', 'Kuraa', '2026-04-28', 1, 'Lahir Hidup', '2026-05-30 20:11:35', '2026-05-30 20:11:35'),
(267, '740221', '7402210202810026', 'Rendra', 'L', 'Kuraa', '2026-01-21', 4, 'Lahir Hidup', '2026-05-30 20:11:35', '2026-05-30 20:11:35'),
(268, '740221', '7402210202940021', 'Clarissa', 'P', 'Kuraa', '2026-04-03', 1, 'Lahir Hidup', '2026-05-30 20:11:35', '2026-05-30 20:11:35');

--
-- Trigger `kelahiran`
--
DELIMITER $$
CREATE TRIGGER `sebelum_tambah_kelahiran` BEFORE INSERT ON `kelahiran` FOR EACH ROW SET NEW.umur_bulan = TIMESTAMPDIFF(MONTH, NEW.tgl_lahir, CURDATE())
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `sebelum_ubah_kelahiran` BEFORE UPDATE ON `kelahiran` FOR EACH ROW SET NEW.umur_bulan = TIMESTAMPDIFF(MONTH, NEW.tgl_lahir, CURDATE())
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `kematian`
--

CREATE TABLE `kematian` (
  `id_kematian` int(11) UNSIGNED NOT NULL,
  `id_desa` varchar(50) NOT NULL,
  `nik` char(16) NOT NULL,
  `nama_almarhum` varchar(100) NOT NULL,
  `tempat_kematian` varchar(100) NOT NULL,
  `tgl_kematian` date NOT NULL,
  `keterangan` varchar(500) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kematian`
--

INSERT INTO `kematian` (`id_kematian`, `id_desa`, `nik`, `nama_almarhum`, `tempat_kematian`, `tgl_kematian`, `keterangan`, `created_at`, `updated_at`) VALUES
(2, '740221', '7402210202630064', 'Wa Ode Mariam', 'Kuraa', '2026-01-11', 'Sakit', '2026-05-30 20:29:10', '2026-05-30 20:29:10'),
(3, '740221', '7402210101580069', 'Baharuddin', 'Kuraa', '2026-05-25', 'Sakit', '2026-05-30 20:29:10', '2026-05-30 20:29:10'),
(4, '740221', '7402210101660061', 'La Ode Idris', 'Kuraa', '2026-02-18', 'Sakit', '2026-05-30 20:29:10', '2026-05-30 20:29:10'),
(5, '740221', '7402210101520075', 'La Ode Yakub', 'Kuraa', '2026-01-10', 'Sakit', '2026-05-30 20:29:10', '2026-05-30 20:29:10'),
(6, '740221', '7402210101900013', 'La Ode Yusran', 'Kuraa', '2026-04-02', 'Sakit', '2026-05-30 20:29:10', '2026-05-30 20:29:10'),
(7, '740221', '7402210202560045', 'Aminah', 'Kuraa', '2026-04-05', 'Sakit', '2026-05-30 20:29:10', '2026-05-30 20:29:10'),
(8, '740221', '7402210101630046', 'La Ode Rahman', 'Kuraa', '2026-03-04', 'Sakit', '2026-05-30 20:29:10', '2026-05-30 20:29:10'),
(9, '740221', '7402210101760010', 'Saharuddin', 'Kuraa', '2026-01-08', 'Sakit', '2026-05-30 20:29:10', '2026-05-30 20:29:10'),
(10, '740221', '7402210101980002', 'Ruslan', 'Kuraa', '2026-04-17', 'Sakit', '2026-05-30 20:29:10', '2026-05-30 20:29:10'),
(11, '740221', '7402210202040029', 'Indah Permata', 'Kuraa', '2026-03-04', 'Sakit', '2026-05-30 20:29:10', '2026-05-30 20:29:10');

-- --------------------------------------------------------

--
-- Struktur dari tabel `lansia`
--

CREATE TABLE `lansia` (
  `id_lansia` int(11) UNSIGNED NOT NULL,
  `id_desa` varchar(50) NOT NULL,
  `nik` char(16) NOT NULL,
  `nama_lansia` varchar(100) NOT NULL,
  `umur_lansia` int(3) NOT NULL,
  `produktifitas` enum('produktif','non-produktif') NOT NULL,
  `hobi` varchar(200) DEFAULT NULL,
  `keterampilan` varchar(200) DEFAULT NULL,
  `keterangan` varchar(500) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `lansia`
--

INSERT INTO `lansia` (`id_lansia`, `id_desa`, `nik`, `nama_lansia`, `umur_lansia`, `produktifitas`, `hobi`, `keterampilan`, `keterangan`, `created_at`, `updated_at`) VALUES
(24, '740221', '7402210101660061', 'La Ode Idris', 60, '', 'Berkebun', 'Anyaman', 'Sehat', '2026-05-30 20:22:34', '2026-05-30 20:22:34'),
(25, '740221', '7402210202650062', 'Wa Ode Aminah', 60, '', 'Membaca', 'Memasak', 'Perlu Perawatan', '2026-05-30 20:22:34', '2026-05-30 20:22:34'),
(26, '740221', '7402210101640063', 'Syarifuddin', 61, 'produktif', 'Memancing', 'Pertukangan', 'Sehat', '2026-05-30 20:22:34', '2026-05-30 20:22:34'),
(27, '740221', '7402210202630064', 'Wa Ode Mariam', 63, 'produktif', 'Menjahit', 'Menjahit', 'Sehat', '2026-05-30 20:22:34', '2026-05-30 20:22:34'),
(28, '740221', '7402210101620065', 'La Ode Yunus', 63, '', 'Berjalan', 'Tidak Ada', 'Perlu Perawatan', '2026-05-30 20:22:34', '2026-05-30 20:22:34'),
(29, '740221', '7402210202610066', 'Khadijah', 65, 'produktif', 'Mengaji', 'Memasak', 'Sehat', '2026-05-30 20:22:34', '2026-05-30 20:22:34'),
(30, '740221', '7402210101600067', 'La Ode Harun', 65, 'produktif', 'Berkebun', 'Pertukangan', 'Sehat', '2026-05-30 20:22:34', '2026-05-30 20:22:34'),
(31, '740221', '7402210202590068', 'Wa Ode Fatima', 66, '', 'Membaca', 'Tidak Ada', 'Sakit', '2026-05-30 20:22:34', '2026-05-30 20:22:34'),
(32, '740221', '7402210101580069', 'Baharuddin', 68, 'produktif', 'Memancing', 'Jala Ikan', 'Sehat', '2026-05-30 20:22:34', '2026-05-30 20:22:34'),
(33, '740221', '7402210202570070', 'Wa Ode Sitti', 69, 'produktif', 'Menjahit', 'Menjahit', 'Sehat', '2026-05-30 20:22:34', '2026-05-30 20:22:34'),
(34, '740221', '7402210101560071', 'La Ode Mansur', 69, 'produktif', 'Berkebun', 'Pertukangan', 'Sehat', '2026-05-30 20:22:34', '2026-05-30 20:22:34'),
(35, '740221', '7402210202550072', 'Aisyah', 71, '', 'Mengaji', 'Tidak Ada', 'Perlu Perawatan', '2026-05-30 20:22:34', '2026-05-30 20:22:34'),
(36, '740221', '7402210101540073', 'La Ode Said', 71, 'produktif', 'Berjalan', 'Anyaman', 'Sehat', '2026-05-30 20:22:34', '2026-05-30 20:22:34'),
(37, '740221', '7402210202530074', 'Wa Ode Asma', 72, 'produktif', 'Memasak', 'Memasak', 'Sehat', '2026-05-30 20:22:34', '2026-05-30 20:22:34'),
(38, '740221', '7402210101520075', 'La Ode Yakub', 74, '', 'Berjalan', 'Tidak Ada', 'Sakit', '2026-05-30 20:22:34', '2026-05-30 20:22:34'),
(39, '740221', '7402210202510076', 'Wa Ode Rohani', 74, 'produktif', 'Menjahit', 'Anyaman', 'Sehat', '2026-05-30 20:22:34', '2026-05-30 20:22:34'),
(40, '740221', '7402210101490077', 'La Ode Mahmud', 77, 'produktif', 'Berkebun', 'Pertukangan', 'Sehat', '2026-05-30 20:22:34', '2026-05-30 20:22:34'),
(41, '740221', '7402210202480078', 'Zainab', 77, '', 'Mengaji', 'Tidak Ada', 'Perlu Perawatan', '2026-05-30 20:22:34', '2026-05-30 20:22:34'),
(42, '740221', '7402210101460079', 'La Ode Usman', 80, 'produktif', 'Memancing', 'Jala Ikan', 'Sehat', '2026-05-30 20:22:34', '2026-05-30 20:22:34'),
(43, '740221', '7402210202450080', 'Wa Ode Hapsah', 80, '', 'Berjalan', 'Tidak Ada', 'Sakit', '2026-05-30 20:22:34', '2026-05-30 20:22:34');

-- --------------------------------------------------------

--
-- Struktur dari tabel `master_wilayah`
--

CREATE TABLE `master_wilayah` (
  `id_wilayah` varchar(20) NOT NULL,
  `provinsi` varchar(100) NOT NULL,
  `kabupaten` varchar(100) NOT NULL,
  `kecamatan` varchar(100) NOT NULL,
  `nama_desa` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `batch` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
(1, '2026-05-24-070946', 'App\\Database\\Migrations\\CreateDesaTable', 'default', 'App', 1779607067, 1),
(2, '2026-05-24-071124', 'App\\Database\\Migrations\\CreateUsersTable', 'default', 'App', 1779607067, 1),
(3, '2026-05-24-071201', 'App\\Database\\Migrations\\CreatePendudukDesaTable', 'default', 'App', 1779607543, 2),
(4, '2026-05-24-071224', 'App\\Database\\Migrations\\CreateKelahiranTable', 'default', 'App', 1779607543, 2),
(5, '2026-05-24-071243', 'App\\Database\\Migrations\\CreateKematianTable', 'default', 'App', 1779607543, 2),
(6, '2026-05-24-071300', 'App\\Database\\Migrations\\CreateLansiaTable', 'default', 'App', 1779607543, 2),
(7, '2026-05-24-071320', 'App\\Database\\Migrations\\CreateApiRequestsTable', 'default', 'App', 1779607543, 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pendudukdesa`
--

CREATE TABLE `pendudukdesa` (
  `nik` char(16) NOT NULL,
  `id_desa` varchar(50) NOT NULL,
  `no_kk` varchar(16) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `jenis_kelamin` enum('L','P') NOT NULL,
  `tempat_lahir` varchar(100) NOT NULL,
  `tgl_lahir` date NOT NULL,
  `usia` tinyint(3) NOT NULL DEFAULT 0,
  `alamat` varchar(300) NOT NULL,
  `RT` int(11) NOT NULL,
  `pekerjaan` varchar(200) NOT NULL,
  `status_pernikahan` enum('belum_kawin','kawin','cerai_mati','cerai_hidup') NOT NULL,
  `pendidikan` varchar(200) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pendudukdesa`
--

INSERT INTO `pendudukdesa` (`nik`, `id_desa`, `no_kk`, `nama`, `jenis_kelamin`, `tempat_lahir`, `tgl_lahir`, `usia`, `alamat`, `RT`, `pekerjaan`, `status_pernikahan`, `pendidikan`, `created_at`, `updated_at`) VALUES
('7402210101000014', '740221', '7402210101260014', 'Dani', 'L', 'Kuraa', '2000-08-11', 25, 'Dusun Kuraa Makmur', 5, 'Wiraswasta', 'belum_kawin', 'SMA', '2026-05-30 19:38:06', '2026-05-30 19:38:06'),
('7402210101000020', '740221', '7402210101260020', 'Yudi', 'L', 'Kuraa', '2000-12-12', 25, 'Jln. Mulyono, Desa Kuraa', 6, 'Wiraswasta', 'belum_kawin', 'SMA', '2026-05-30 19:38:06', '2026-05-30 19:38:06'),
('7402210101020004', '740221', '7402210101260004', 'Fajar Shidiq', 'L', 'Kuraa', '2002-11-05', 23, 'Jln. Pendidikan, Desa Kuraa', 3, 'Wiraswasta', 'belum_kawin', 'SMA', '2026-05-30 19:38:06', '2026-05-30 19:38:06'),
('7402210101040007', '740221', '7402210101260007', 'Muhamad Aldi', 'L', 'Kuraa', '2004-02-18', 22, 'Dusun Kuraa Makmur', 5, 'Belum Bekerja', 'belum_kawin', 'SMA', '2026-05-30 19:38:06', '2026-05-30 19:38:06'),
('7402210101460048', '740221', '7402210101260048', 'Ibrahim', 'L', 'Kuraa', '1946-02-10', 80, 'Dusun Kuraa Makmur', 5, 'Petani', 'kawin', 'Tidak Sekolah', '2026-05-30 19:38:06', '2026-05-30 19:38:06'),
('7402210101460079', '740221', '7402210101260079', 'La Ode Usman', 'L', 'Kuraa', '1946-03-14', 80, 'Jln. Poros Pasarwajo, Desa Kuraa', 4, 'Petani', 'kawin', 'Tidak Sekolah', '2026-05-30 19:46:26', '2026-05-30 19:46:26'),
('7402210101490077', '740221', '7402210101260077', 'La Ode Mahmud', 'L', 'Kuraa', '1949-01-20', 77, 'Jln. Pendidikan, Desa Kuraa', 6, 'Petani', 'kawin', 'Tidak Sekolah', '2026-05-30 19:46:26', '2026-05-30 19:46:26'),
('7402210101520075', '740221', '7402210101260075', 'La Ode Yakub', 'L', 'Kuraa', '1952-04-01', 74, 'Jln. Mulyono, Desa Kuraa', 2, 'Petani', 'kawin', 'Tidak Sekolah', '2026-05-30 19:46:26', '2026-05-30 19:46:26'),
('7402210101540043', '740221', '7402210101260043', 'Kasim', 'L', 'Kuraa', '1954-09-18', 71, 'Jln. Poros Pasarwajo, Desa Kuraa', 1, 'Petani', 'kawin', 'SD', '2026-05-30 19:38:06', '2026-05-30 19:38:06'),
('7402210101540073', '740221', '7402210101260073', 'La Ode Said', 'L', 'Kuraa', '1954-07-07', 71, 'Jln. Poros Pasarwajo, Desa Kuraa', 1, 'Petani', 'kawin', 'Tidak Sekolah', '2026-05-30 19:46:26', '2026-05-30 19:46:26'),
('7402210101550053', '740221', '7402210101260053', 'Sukardi', 'L', 'Kuraa', '1955-06-05', 70, 'Jln. Melati, Desa Kuraa', 10, 'Petani', 'kawin', 'SD', '2026-05-30 19:38:06', '2026-05-30 19:38:06'),
('7402210101560071', '740221', '7402210101260071', 'La Ode Mansur', 'L', 'Kuraa', '1956-10-26', 69, 'Jln. Pendidikan, Desa Kuraa', 3, 'Petani', 'kawin', 'SD', '2026-05-30 19:46:26', '2026-05-30 19:46:26'),
('7402210101580044', '740221', '7402210101260044', 'Hasan', 'L', 'Kuraa', '1958-11-05', 67, 'Jln. Mulyono, Desa Kuraa', 2, 'Petani', 'kawin', 'SMP', '2026-05-30 19:38:06', '2026-05-30 19:38:06'),
('7402210101580069', '740221', '7402210101260069', 'Baharuddin', 'L', 'Kuraa', '1958-03-22', 68, 'Jln. Mulyono, Desa Kuraa', 6, 'Petani', 'kawin', 'SD', '2026-05-30 19:46:26', '2026-05-30 19:46:26'),
('7402210101590041', '740221', '7402210101260041', 'La Ode Muhammad', 'L', 'Kuraa', '1959-03-03', 67, 'Dusun Kuraa Utama', 8, 'Pensiunan', 'kawin', 'S1', '2026-05-30 19:38:06', '2026-05-30 19:38:06'),
('7402210101600049', '740221', '7402210101260049', 'Yusuf', 'L', 'Kuraa', '1960-12-01', 65, 'Jln. Poros Pasarwajo, Desa Kuraa', 6, 'Petani', 'kawin', 'SMP', '2026-05-30 19:38:06', '2026-05-30 19:38:06'),
('7402210101600067', '740221', '7402210101260067', 'La Ode Harun', 'L', 'Kuraa', '1960-09-10', 65, 'Jln. Poros Pasarwajo, Desa Kuraa', 6, 'Wiraswasta', 'kawin', 'SMA', '2026-05-30 19:46:26', '2026-05-30 19:46:26'),
('7402210101620051', '740221', '7402210101260051', 'La Ode Madi', 'L', 'Kuraa', '1962-03-22', 64, 'Dusun Kuraa Utama', 7, 'Wiraswasta', 'kawin', 'SMA', '2026-05-30 19:38:06', '2026-05-30 19:38:06'),
('7402210101620065', '740221', '7402210101260065', 'La Ode Yunus', 'L', 'Kuraa', '1962-07-30', 63, 'Dusun Kuraa Makmur', 5, 'Petani', 'kawin', 'SMP', '2026-05-30 19:46:26', '2026-05-30 19:46:26'),
('7402210101630046', '740221', '7402210101260046', 'La Ode Rahman', 'L', 'Kuraa', '1963-07-14', 62, 'Jln. Melati, Desa Kuraa', 4, 'Pensiunan', 'kawin', 'SMA', '2026-05-30 19:38:06', '2026-05-30 19:38:06'),
('7402210101640055', '740221', '7402210101260055', 'Ali', 'L', 'Kuraa', '1964-09-01', 61, 'Dusun Kuraa Makmur', 5, 'Wiraswasta', 'kawin', 'SMA', '2026-05-30 19:38:06', '2026-05-30 19:38:06'),
('7402210101640063', '740221', '7402210101260063', 'Syarifuddin', 'L', 'Kuraa', '1964-11-05', 61, 'Jln. Mulyono, Desa Kuraa', 2, 'Wiraswasta', 'kawin', 'SMA', '2026-05-30 19:46:26', '2026-05-30 19:46:26'),
('7402210101660061', '740221', '7402210101260061', 'La Ode Idris', 'L', 'Kuraa', '1966-02-12', 60, 'Jln. Poros Pasarwajo, Desa Kuraa', 1, 'Petani', 'kawin', 'SMP', '2026-05-30 19:46:26', '2026-05-30 19:46:26'),
('7402210101760010', '740221', '7402210101260010', 'Saharuddin', 'L', 'Kuraa', '1976-04-12', 50, 'Dusun Kuraa Utama', 7, 'Petani', 'kawin', 'SD', '2026-05-30 19:38:06', '2026-05-30 19:38:06'),
('7402210101790006', '740221', '7402210101260006', 'La Ode Hasrin', 'L', 'Kuraa', '1979-09-30', 46, 'Jln. Poros Pasarwajo, Desa Kuraa', 1, 'PNS', 'kawin', 'S1', '2026-05-30 19:38:06', '2026-05-30 19:38:06'),
('7402210101810015', '740221', '7402210101260015', 'Rizal', 'L', 'Kuraa', '1981-01-25', 45, 'Dusun Kuraa Utama', 7, 'Petani', 'kawin', 'SMP', '2026-05-30 19:38:06', '2026-05-30 19:38:06'),
('7402210101830016', '740221', '7402210101260016', 'Anwar', 'L', 'Kuraa', '1983-04-04', 43, 'Jln. Mulyono, Desa Kuraa', 3, 'Wiraswasta', 'kawin', 'SMA', '2026-05-30 19:38:06', '2026-05-30 19:38:06'),
('7402210101840003', '740221', '7402210101260003', 'Agus Setiawan', 'L', 'Kuraa', '1984-01-10', 42, 'Jln. Mulyono, Desa Kuraa', 2, 'Buruh', 'kawin', 'SMP', '2026-05-30 19:38:06', '2026-05-30 19:38:06'),
('7402210101860012', '740221', '7402210101260012', 'Aris', 'L', 'Kuraa', '1986-03-14', 40, 'Jln. Melati, Desa Kuraa', 4, 'Wiraswasta', 'kawin', 'SMP', '2026-05-30 19:38:06', '2026-05-30 19:38:06'),
('7402210101870019', '740221', '7402210101260019', 'Kamaruddin', 'L', 'Kuraa', '1987-07-01', 38, 'Jln. Pendidikan, Desa Kuraa', 6, 'Buruh', 'kawin', 'SMA', '2026-05-30 19:38:06', '2026-05-30 19:38:06'),
('7402210101880008', '740221', '7402210101260008', 'Hendra', 'L', 'Kuraa', '1988-06-25', 37, 'Jln. Mulyono, Desa Kuraa', 2, 'Buruh', 'kawin', 'SMP', '2026-05-30 19:38:06', '2026-05-30 19:38:06'),
('7402210101900013', '740221', '7402210101260013', 'La Ode Yusran', 'L', 'Kuraa', '1990-05-20', 36, 'Jln. Poros Pasarwajo, Desa Kuraa', 6, 'PNS', 'kawin', 'S1', '2026-05-30 19:38:06', '2026-05-30 19:38:06'),
('7402210101900018', '740221', '7402210101260018', 'Firman', 'L', 'Kuraa', '1990-02-02', 36, 'Jln. Melati, Desa Kuraa', 10, 'Buruh', 'kawin', 'SMP', '2026-05-30 19:38:06', '2026-05-30 19:38:06'),
('7402210101910001', '740221', '7402210101260001', 'La Ode Abdul', 'L', 'Kuraa', '1991-03-15', 35, 'Jln. Poros Pasarwajo, Desa Kuraa', 1, 'PNS', 'kawin', 'S1', '2026-05-30 19:38:06', '2026-05-30 19:38:06'),
('7402210101910017', '740221', '7402210101260017', 'Jufri', 'L', 'Kuraa', '1991-05-05', 35, 'Jln. Poros Pasarwajo, Desa Kuraa', 4, 'Wiraswasta', 'kawin', 'S1', '2026-05-30 19:38:06', '2026-05-30 19:38:06'),
('7402210101930009', '740221', '7402210101260009', 'Andi Wijaya', 'L', 'Kuraa', '1993-10-05', 32, 'Jln. Poros Pasarwajo, Desa Kuraa', 6, 'Wiraswasta', 'kawin', 'S1', '2026-05-30 19:38:06', '2026-05-30 19:38:06'),
('7402210101950005', '740221', '7402210101260005', 'Ridwan', 'L', 'Kuraa', '1995-05-14', 31, 'Jln. Melati, Desa Kuraa', 4, 'Buruh', 'kawin', 'SMA', '2026-05-30 19:38:06', '2026-05-30 19:38:06'),
('7402210101970011', '740221', '7402210101260011', 'Lukman', 'L', 'Kuraa', '1997-12-01', 28, 'Jln. Pendidikan, Desa Kuraa', 3, 'Buruh', 'belum_kawin', 'SMA', '2026-05-30 19:38:06', '2026-05-30 19:38:06'),
('7402210101980002', '740221', '7402210101260002', 'Ruslan', 'L', 'Kuraa', '1998-07-22', 27, 'Jln. Poros Pasarwajo, Desa Kuraa', 1, 'Wiraswasta', 'belum_kawin', 'SMA', '2026-05-30 19:38:06', '2026-05-30 19:38:06'),
('7402210202000024', '740221', '7402210101260020', 'Anisa Herman', 'P', 'Matanauwe', '2000-12-12', 25, 'Dusun Kuraa Makmur', 3, 'Ibu Rumah Tangga', 'kawin', 'SMA', '2026-05-30 19:38:06', '2026-05-30 19:38:06'),
('7402210202000034', '740221', '7402210101260034', 'Asma', 'P', 'Kuraa', '2000-03-15', 26, 'Jln. Poros Pasarwajo, Desa Kuraa', 8, 'Wiraswasta', 'belum_kawin', 'S1', '2026-05-30 19:38:06', '2026-05-30 19:38:06'),
('7402210202020023', '740221', '7402210101260002', 'Ayu Lestari', 'P', 'Kuraa', '2002-12-11', 23, 'Jln. Poros Pasarwajo, Desa Kuraa', 1, 'PNS', 'belum_kawin', 'S1', '2026-05-30 19:38:06', '2026-05-30 19:38:06'),
('7402210202020038', '740221', '7402210101260038', 'Ranti', 'P', 'Kuraa', '2002-05-18', 24, 'Dusun Kuraa Makmur', 5, 'Belum Bekerja', 'belum_kawin', 'SMA', '2026-05-30 19:38:06', '2026-05-30 19:38:06'),
('7402210202040029', '740221', '7402210101260029', 'Indah Permata', 'P', 'Kuraa', '2004-06-14', 21, 'Jln. Poros Pasarwajo, Desa Kuraa', 6, 'Belum Bekerja', 'belum_kawin', 'SMA', '2026-05-30 19:38:06', '2026-05-30 19:38:06'),
('7402210202050040', '740221', '7402210101260019', 'Putri', 'P', 'Kuraa', '2005-01-15', 21, 'Jln. Pendidikan, Desa Kuraa', 6, 'Belum Bekerja', 'belum_kawin', 'SMA', '2026-05-30 19:38:06', '2026-05-30 19:38:06'),
('7402210202450080', '740221', '7402210101260080', 'Wa Ode Hapsah', 'P', 'Kuraa', '1945-12-25', 80, 'Dusun Kuraa Utama', 8, 'Ibu Rumah Tangga', 'cerai_mati', 'Tidak Sekolah', '2026-05-30 19:46:26', '2026-05-30 19:46:26'),
('7402210202480078', '740221', '7402210101260078', 'Zainab', 'P', 'Kuraa', '1948-09-05', 77, 'Jln. Melati, Desa Kuraa', 10, 'Ibu Rumah Tangga', 'cerai_mati', 'Tidak Sekolah', '2026-05-30 19:46:26', '2026-05-30 19:46:26'),
('7402210202490054', '740221', '7402210101260054', 'Zainab', 'P', 'Kuraa', '1949-04-18', 77, 'Jln. Pendidikan, Desa Kuraa', 6, 'Ibu Rumah Tangga', 'cerai_mati', 'Tidak Sekolah', '2026-05-30 19:38:06', '2026-05-30 19:38:06'),
('7402210202510047', '740221', '7402210101260047', 'Wa Ode Hana', 'P', 'Kuraa', '1951-05-30', 75, 'Jln. Pendidikan, Desa Kuraa', 3, 'Ibu Rumah Tangga', 'cerai_mati', 'SD', '2026-05-30 19:38:06', '2026-05-30 19:38:06'),
('7402210202510076', '740221', '7402210101260076', 'Wa Ode Rohani', 'P', 'Kuraa', '1951-06-15', 74, 'Dusun Kuraa Makmur', 5, 'Ibu Rumah Tangga', 'cerai_mati', 'SD', '2026-05-30 19:46:26', '2026-05-30 19:46:26'),
('7402210202520050', '740221', '7402210101260049', 'Fatimah', 'P', 'Kuraa', '1952-08-15', 73, 'Jln. Poros Pasarwajo, Desa Kuraa', 6, 'Ibu Rumah Tangga', 'kawin', 'SD', '2026-05-30 19:38:06', '2026-05-30 19:38:06'),
('7402210202530074', '740221', '7402210101260074', 'Wa Ode Asma', 'P', 'Kuraa', '1953-11-12', 72, 'Dusun Kuraa Utama', 7, 'Ibu Rumah Tangga', 'kawin', 'SD', '2026-05-30 19:46:26', '2026-05-30 19:46:26'),
('7402210202550072', '740221', '7402210101260072', 'Aisyah', 'P', 'Kuraa', '1955-02-18', 71, 'Jln. Melati, Desa Kuraa', 10, 'Ibu Rumah Tangga', 'cerai_mati', 'SD', '2026-05-30 19:46:26', '2026-05-30 19:46:26'),
('7402210202560045', '740221', '7402210101260044', 'Aminah', 'P', 'Kuraa', '1956-01-25', 70, 'Jln. Mulyono, Desa Kuraa', 2, 'Ibu Rumah Tangga', 'kawin', 'SD', '2026-05-30 19:38:06', '2026-05-30 19:38:06'),
('7402210202570052', '740221', '7402210101260051', 'Wa Ode Saria', 'P', 'Kuraa', '1957-10-10', 68, 'Dusun Kuraa Utama', 7, 'Ibu Rumah Tangga', 'kawin', 'SMP', '2026-05-30 19:38:06', '2026-05-30 19:38:06'),
('7402210202570070', '740221', '7402210101260070', 'Wa Ode Sitti', 'P', 'Kuraa', '1957-05-14', 69, 'Dusun Kuraa Makmur', 5, 'Ibu Rumah Tangga', 'kawin', 'SMP', '2026-05-30 19:46:26', '2026-05-30 19:46:26'),
('7402210202590068', '740221', '7402210101260068', 'Wa Ode Fatima', 'P', 'Kuraa', '1959-12-05', 66, 'Dusun Kuraa Utama', 8, 'Ibu Rumah Tangga', 'kawin', 'SMP', '2026-05-30 19:46:26', '2026-05-30 19:46:26'),
('7402210202610042', '740221', '7402210101260041', 'Wa Ode Sitti Aminah', 'P', 'Kuraa', '1961-04-12', 65, 'Dusun Kuraa Utama', 8, 'Ibu Rumah Tangga', 'kawin', 'SMA', '2026-05-30 19:38:06', '2026-05-30 19:38:06'),
('7402210202610066', '740221', '7402210101260066', 'Khadijah', 'P', 'Kuraa', '1961-01-15', 65, 'Jln. Melati, Desa Kuraa', 4, 'Ibu Rumah Tangga', 'kawin', 'SD', '2026-05-30 19:46:26', '2026-05-30 19:46:26'),
('7402210202630064', '740221', '7402210101260064', 'Wa Ode Mariam', 'P', 'Kuraa', '1963-04-19', 63, 'Jln. Pendidikan, Desa Kuraa', 3, 'Ibu Rumah Tangga', 'kawin', 'SD', '2026-05-30 19:46:26', '2026-05-30 19:46:26'),
('7402210202650062', '740221', '7402210101260062', 'Wa Ode Aminah', 'P', 'Kuraa', '1965-08-24', 60, 'Dusun Kuraa Utama', 7, 'Ibu Rumah Tangga', 'kawin', 'SD', '2026-05-30 19:46:26', '2026-05-30 19:46:26'),
('7402210202740033', '740221', '7402210101260015', 'Kartini', 'P', 'Kuraa', '1974-04-21', 52, 'Dusun Kuraa Utama', 7, 'Ibu Rumah Tangga', 'kawin', 'SMP', '2026-05-30 19:38:06', '2026-05-30 19:38:06'),
('7402210202780030', '740221', '7402210101260010', 'Megawati', 'P', 'Kuraa', '1978-07-07', 47, 'Dusun Kuraa Utama', 7, 'Ibu Rumah Tangga', 'kawin', 'SD', '2026-05-30 19:38:06', '2026-05-30 19:38:06'),
('7402210202810026', '740221', '7402210101260006', 'Wa Ode Sitti', 'P', 'Kuraa', '1981-03-19', 45, 'Jln. Poros Pasarwajo, Desa Kuraa', 1, 'Ibu Rumah Tangga', 'kawin', 'SMP', '2026-05-30 19:38:06', '2026-05-30 19:38:06'),
('7402210202850036', '740221', '7402210101260013', 'Wa Ode Erna', 'P', 'Kuraa', '1985-02-28', 41, 'Jln. Poros Pasarwajo, Desa Kuraa', 6, 'Ibu Rumah Tangga', 'kawin', 'SMA', '2026-05-30 19:38:06', '2026-05-30 19:38:06'),
('7402210202860022', '740221', '7402210101260003', 'Siti Aminah', 'P', 'Kuraa', '1986-05-15', 40, 'Jln. Mulyono, Desa Kuraa', 2, 'Ibu Rumah Tangga', 'kawin', 'SMA', '2026-05-30 19:38:06', '2026-05-30 19:38:06'),
('7402210202890031', '740221', '7402210101260012', 'Nurlina', 'P', 'Kuraa', '1989-10-12', 36, 'Jln. Melati, Desa Kuraa', 4, 'Ibu Rumah Tangga', 'kawin', 'SMP', '2026-05-30 19:38:06', '2026-05-30 19:38:06'),
('7402210202910037', '740221', '7402210101260017', 'Marlina', 'P', 'Kuraa', '1991-07-14', 34, 'Jln. Poros Pasarwajo, Desa Kuraa', 4, 'Ibu Rumah Tangga', 'kawin', 'SMA', '2026-05-30 19:38:06', '2026-05-30 19:38:06'),
('7402210202920027', '740221', '7402210101260027', 'Dewi Sartika', 'P', 'Kuraa', '1992-11-02', 33, 'Dusun Kuraa Makmur', 5, 'PNS', 'kawin', 'S1', '2026-05-30 19:38:06', '2026-05-30 19:38:06'),
('7402210202940021', '740221', '7402210101260001', 'Wa Ode Ratna', 'P', 'Kuraa', '1994-02-10', 32, 'Jln. Poros Pasarwajo, Desa Kuraa', 1, 'Ibu Rumah Tangga', 'kawin', 'S1', '2026-05-30 19:38:06', '2026-05-30 19:38:06'),
('7402210202950032', '740221', '7402210101260032', 'Sri Wahyuni', 'P', 'Kuraa', '1995-09-05', 30, 'Jln. Pendidikan, Desa Kuraa', 3, 'Wiraswasta', 'kawin', 'SMA', '2026-05-30 19:38:06', '2026-05-30 19:38:06'),
('7402210202960035', '740221', '7402210101260009', 'Diana', 'P', 'Kuraa', '1996-11-20', 29, 'Jln. Poros Pasarwajo, Desa Kuraa', 6, 'Ibu Rumah Tangga', 'kawin', 'SMA', '2026-05-30 19:38:06', '2026-05-30 19:38:06'),
('7402210202970025', '740221', '7402210101260025', 'Rahmawati', 'P', 'Kuraa', '1997-08-24', 28, 'Jln. Melati, Desa Kuraa', 4, 'Wiraswasta', 'belum_kawin', 'SMA', '2026-05-30 19:38:06', '2026-05-30 19:38:06'),
('7402210202980039', '740221', '7402210101260018', 'Siska', 'P', 'Kuraa', '1998-10-01', 27, 'Jln. Melati, Desa Kuraa', 10, 'Ibu Rumah Tangga', 'kawin', 'SMP', '2026-05-30 19:38:06', '2026-05-30 19:38:06'),
('7402210202990028', '740221', '7402210101260028', 'Fitriani', 'P', 'Kuraa', '1999-01-30', 27, 'Jln. Mulyono, Desa Kuraa', 2, 'Belum Bekerja', 'belum_kawin', 'SMA', '2026-05-30 19:38:06', '2026-05-30 19:38:06');

--
-- Trigger `pendudukdesa`
--
DELIMITER $$
CREATE TRIGGER `sebelum_tambah_penduduk` BEFORE INSERT ON `pendudukdesa` FOR EACH ROW SET NEW.usia = TIMESTAMPDIFF(YEAR, NEW.tgl_lahir, CURDATE())
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `sebelum_ubah_penduduk` BEFORE UPDATE ON `pendudukdesa` FOR EACH ROW SET NEW.usia = TIMESTAMPDIFF(YEAR, NEW.tgl_lahir, CURDATE())
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id_user` int(11) UNSIGNED NOT NULL,
  `nama_lengkap` varchar(150) DEFAULT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `no_hp` varchar(30) DEFAULT NULL,
  `jabatan` varchar(100) DEFAULT NULL,
  `alasan_pengajuan` text DEFAULT NULL,
  `role` enum('admin','ketua_pkk') NOT NULL,
  `status` enum('pending','approved','rejected','inactive') NOT NULL DEFAULT 'pending',
  `registration_code` varchar(50) DEFAULT NULL,
  `approved_by` int(11) UNSIGNED DEFAULT NULL,
  `approved_at` datetime DEFAULT NULL,
  `rejected_reason` text DEFAULT NULL,
  `id_desa` varchar(50) DEFAULT NULL,
  `requested_id_desa` varchar(50) DEFAULT NULL,
  `requested_nama_desa` varchar(150) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id_user`, `nama_lengkap`, `username`, `email`, `password`, `no_hp`, `jabatan`, `alasan_pengajuan`, `role`, `status`, `registration_code`, `approved_by`, `approved_at`, `rejected_reason`, `id_desa`, `requested_id_desa`, `requested_nama_desa`, `created_at`, `updated_at`) VALUES
(1, NULL, 'admin', 'admin@gmail.com', '$2y$10$CDyGhcLmFRtyEqiNIW1zju6ZKkWzvJoUAabK004d.HOmRm26C/6fa', NULL, NULL, NULL, 'admin', 'approved', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-05-24 16:04:42', '2026-05-28 08:57:06'),
(2, NULL, 'pkk_sukamaju', 'pkk.sukamaju@gmail.com', '$2y$10$.t6b50PNPNYvyEgeCxkrUujn6Axa7Iavhz262Z28mzgdrE.fXis3m', NULL, NULL, NULL, 'ketua_pkk', 'approved', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-05-24 16:04:42', '2026-05-28 08:57:06'),
(7, 'asinta', 'f1g124003', 'ayuliar380@gmail.com', '$2y$10$iqyZrsOlBJLIw9R2swV2O.uLoDGx2ux2h6uZYWN2rQpnjWJTxpE1G', '081247309723', 'pkk nelam', 'jfhusi', 'ketua_pkk', 'approved', 'REG-20260528-7B287E8C', 1, '2026-05-28 05:52:01', NULL, '5272011009', '5272011009', 'SANTI', '2026-05-28 04:21:40', '2026-05-28 05:52:01'),
(9, 'Amir Robi', 'pkk123', 'robi@gmail.com', '$2y$10$l6N45OipCr/NHLXTSbkVluQCIVniPlx0hetic9Jk2hrUhtuoQjzOe', '081247309723', '34', '23', 'ketua_pkk', 'approved', 'REG-20260528-407B5B5F', 1, '2026-05-28 09:57:58', NULL, '3101010001', '3101010001', 'PULAU TIDUNG', '2026-05-28 09:56:47', '2026-05-28 09:57:58'),
(10, 'Elizabet', 'pkk_pkk', 'elizabet@gmail.com', '$2y$10$bSOGE8nXv60m/8nXoct6HeCYvnxvwusc5O5C56lKa.byNbtvh0a9.', '081246309768', 'Ketua PKK', '--', 'ketua_pkk', 'pending', 'REG-20260530-6D7B2B53', NULL, NULL, NULL, NULL, '3401080004', 'KALIREJO', '2026-05-30 06:35:28', '2026-05-30 06:35:28'),
(13, 'Rafi Ardia Refaldi', 'Pkk_desa_Kuraa', 'rafiardia1@gmail.com', '$2y$10$7NG9pnGYnhjt2pagXtla8uVlBTlvdVnVbDJm8n/pKT7D1CZTXeaq6', '081356275611', 'Ketua pkk Kuraa', 'Untuk mengelola data kependudukan', 'ketua_pkk', 'approved', 'REG-20260530-9A3E56CA', 1, '2026-05-30 11:28:31', NULL, '740221', '7401052004', 'KURAA', '2026-05-30 11:27:55', '2026-05-30 11:28:31');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `api_requests`
--
ALTER TABLE `api_requests`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `api_token` (`api_token`);

--
-- Indeks untuk tabel `desa`
--
ALTER TABLE `desa`
  ADD PRIMARY KEY (`id_desa`);

--
-- Indeks untuk tabel `kelahiran`
--
ALTER TABLE `kelahiran`
  ADD PRIMARY KEY (`id_kelahiran`),
  ADD KEY `Kelahiran_id_desa_foreign` (`id_desa`),
  ADD KEY `Kelahiran_nik_ibu_foreign` (`nik_ibu`);

--
-- Indeks untuk tabel `kematian`
--
ALTER TABLE `kematian`
  ADD PRIMARY KEY (`id_kematian`),
  ADD KEY `Kematian_id_desa_foreign` (`id_desa`),
  ADD KEY `Kematian_nik_foreign` (`nik`);

--
-- Indeks untuk tabel `lansia`
--
ALTER TABLE `lansia`
  ADD PRIMARY KEY (`id_lansia`),
  ADD KEY `Lansia_id_desa_foreign` (`id_desa`),
  ADD KEY `Lansia_nik_foreign` (`nik`);

--
-- Indeks untuk tabel `master_wilayah`
--
ALTER TABLE `master_wilayah`
  ADD PRIMARY KEY (`id_wilayah`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pendudukdesa`
--
ALTER TABLE `pendudukdesa`
  ADD PRIMARY KEY (`nik`),
  ADD KEY `PendudukDesa_id_desa_foreign` (`id_desa`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `users_registration_code_unique` (`registration_code`),
  ADD KEY `users_id_desa_foreign` (`id_desa`),
  ADD KEY `users_status_index` (`status`),
  ADD KEY `users_approved_by_index` (`approved_by`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `api_requests`
--
ALTER TABLE `api_requests`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `kelahiran`
--
ALTER TABLE `kelahiran`
  MODIFY `id_kelahiran` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=269;

--
-- AUTO_INCREMENT untuk tabel `kematian`
--
ALTER TABLE `kematian`
  MODIFY `id_kematian` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `lansia`
--
ALTER TABLE `lansia`
  MODIFY `id_lansia` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `kelahiran`
--
ALTER TABLE `kelahiran`
  ADD CONSTRAINT `Kelahiran_id_desa_foreign` FOREIGN KEY (`id_desa`) REFERENCES `desa` (`id_desa`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Kelahiran_nik_ibu_foreign` FOREIGN KEY (`nik_ibu`) REFERENCES `pendudukdesa` (`nik`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `kematian`
--
ALTER TABLE `kematian`
  ADD CONSTRAINT `Kematian_id_desa_foreign` FOREIGN KEY (`id_desa`) REFERENCES `desa` (`id_desa`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Kematian_nik_foreign` FOREIGN KEY (`nik`) REFERENCES `pendudukdesa` (`nik`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `lansia`
--
ALTER TABLE `lansia`
  ADD CONSTRAINT `Lansia_id_desa_foreign` FOREIGN KEY (`id_desa`) REFERENCES `desa` (`id_desa`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Lansia_nik_foreign` FOREIGN KEY (`nik`) REFERENCES `pendudukdesa` (`nik`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pendudukdesa`
--
ALTER TABLE `pendudukdesa`
  ADD CONSTRAINT `PendudukDesa_id_desa_foreign` FOREIGN KEY (`id_desa`) REFERENCES `desa` (`id_desa`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_approved_by_foreign` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id_user`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `users_id_desa_foreign` FOREIGN KEY (`id_desa`) REFERENCES `desa` (`id_desa`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
