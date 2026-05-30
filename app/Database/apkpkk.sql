-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 30 Bulan Mei 2026 pada 08.52
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
('7401052004', 'KURAA', '2026-05-28 11:49:42', '2026-05-28 11:49:42'),
('DESA001', 'Desa Sukamaju', '2026-05-24 16:04:42', '2026-05-24 16:04:42');

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
(4, 'DESA001', '3200000000000002', 'Nabila', 'P', 'Kuraa', '2026-01-10', 4, NULL, '2026-05-26 01:46:49', '2026-05-26 02:04:31'),
(5, 'DESA001', '3200000000000004', 'Angga Narus', 'L', 'Matanauwe', '2025-02-11', 15, NULL, '2026-05-26 04:47:16', '2026-05-26 04:47:16'),
(6, 'DESA001', '3200000000000002', 'Aulia Putri', 'P', 'Semarang', '2025-05-12', 12, 'Lahir sehat', '2026-05-29 18:16:37', '2026-05-29 18:16:37');

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
(1, 'DESA001', '3200000000000003', 'Yudi', 'Rumah kediaman', '2026-11-10', 'sakit', '2026-05-26 04:38:15', '2026-05-26 04:52:52');

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
(2, 'DESA001', '3200000000000001', 'Budi Santoso', 0, 'produktif', 'Membaca', NULL, '-', '2026-05-26 05:20:05', '2026-05-26 05:57:43'),
(3, 'DESA001', '3200000000000002', 'Ayu Lestari', 23, 'non-produktif', 'Membaca', NULL, '-', '2026-05-26 05:53:32', '2026-05-26 05:53:32');

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
('3200000000000001', 'DESA001', '3210000000000001', 'Budi Santoso', 'L', 'Kuraa', '1972-11-10', 53, 'Jln. Poros Pasarwajo lasalimu, desa kuraa kecamatan siotapina', 1, 'PNS', 'kawin', 'S1', '2026-05-24 08:44:40', '2026-05-26 00:14:58'),
('3200000000000002', 'DESA001', '3210000000000001', 'Ayu Lestari', 'P', 'Kuraa', '2002-12-11', 23, 'Jln pros pasarwajo lasalimu', 1, 'PNS', 'belum_kawin', 'S1', '2026-05-24 09:55:03', '2026-05-26 00:28:40'),
('3200000000000003', 'DESA001', '3273010101010009', 'Yudi', 'L', 'Kuraa', '2000-12-12', 25, 'Jln. mulyono', 6, 'Wiraswasta', 'belum_kawin', 'SMA', '2026-05-26 00:32:38', '2026-05-26 00:32:38'),
('3200000000000004', 'DESA001', '3273010101010002', 'Anisa Herman', 'P', 'Matanauwe', '2000-12-12', 25, 'dusun kuraa makmur', 3, 'Ibu Rumah Tangga', 'kawin', 'SMA', '2026-05-26 04:46:17', '2026-05-26 04:46:17');

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
(2, NULL, 'pkk_sukamaju', 'pkk.sukamaju@gmail.com', '$2y$10$.t6b50PNPNYvyEgeCxkrUujn6Axa7Iavhz262Z28mzgdrE.fXis3m', NULL, NULL, NULL, 'ketua_pkk', 'approved', NULL, NULL, NULL, NULL, 'DESA001', NULL, NULL, '2026-05-24 16:04:42', '2026-05-28 08:57:06'),
(7, 'asinta', 'f1g124003', 'ayuliar380@gmail.com', '$2y$10$iqyZrsOlBJLIw9R2swV2O.uLoDGx2ux2h6uZYWN2rQpnjWJTxpE1G', '081247309723', 'pkk nelam', 'jfhusi', 'ketua_pkk', 'approved', 'REG-20260528-7B287E8C', 1, '2026-05-28 05:52:01', NULL, '5272011009', '5272011009', 'SANTI', '2026-05-28 04:21:40', '2026-05-28 05:52:01'),
(8, 'Muslima Wabula', 'pkk_kuraa', 'fnnyadigital28@gmail.com', '$2y$10$S7WNVYvktLAH3YRBXXrzkOWFXTNPyOYpzMbor3fhuUHDD6TK0aGR6', '081247309711', 'Ketua PKK Desa Kuraa', '-', 'ketua_pkk', 'approved', 'REG-20260528-AB84CB16', 1, '2026-05-28 09:14:21', NULL, '7401052004', '7401052004', 'KURAA', '2026-05-28 08:14:49', '2026-05-28 09:14:21'),
(9, 'Amir Robi', 'pkk123', 'robi@gmail.com', '$2y$10$l6N45OipCr/NHLXTSbkVluQCIVniPlx0hetic9Jk2hrUhtuoQjzOe', '081247309723', '34', '23', 'ketua_pkk', 'approved', 'REG-20260528-407B5B5F', 1, '2026-05-28 09:57:58', NULL, '3101010001', '3101010001', 'PULAU TIDUNG', '2026-05-28 09:56:47', '2026-05-28 09:57:58'),
(10, 'Elizabet', 'pkk_pkk', 'elizabet@gmail.com', '$2y$10$bSOGE8nXv60m/8nXoct6HeCYvnxvwusc5O5C56lKa.byNbtvh0a9.', '081246309768', 'Ketua PKK', '--', 'ketua_pkk', 'pending', 'REG-20260530-6D7B2B53', NULL, NULL, NULL, NULL, '3401080004', 'KALIREJO', '2026-05-30 06:35:28', '2026-05-30 06:35:28');

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
  MODIFY `id_kelahiran` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `kematian`
--
ALTER TABLE `kematian`
  MODIFY `id_kematian` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `lansia`
--
ALTER TABLE `lansia`
  MODIFY `id_lansia` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

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
