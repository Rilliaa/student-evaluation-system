-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 10, 2025 at 04:32 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dbbaru`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_logs`
--

CREATE TABLE `activity_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `actor_id` bigint(20) UNSIGNED NOT NULL,
  `actor_type` varchar(255) NOT NULL,
  `action` varchar(255) NOT NULL,
  `object_type` varchar(255) NOT NULL,
  `object_id` bigint(20) UNSIGNED NOT NULL,
  `description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `time_stamp` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `activity_logs`
--

INSERT INTO `activity_logs` (`id`, `actor_id`, `actor_type`, `action`, `object_type`, `object_id`, `description`, `created_at`, `updated_at`, `time_stamp`) VALUES
(18, 11, 'App\\Models\\User', 'update', 'App\\Models\\Murid', 24, 'Memperbarui data murid: Budi Santosooo', '2024-12-15 04:48:59', '2024-12-15 04:48:59', '11:48:59'),
(19, 11, 'App\\Models\\User', 'create', 'App\\Models\\Murid', 53, 'Menambahkan data murid baru: Imelda', '2024-12-15 04:49:19', '2024-12-15 04:49:19', '11:49:19'),
(20, 11, 'App\\Models\\User', 'delete', 'App\\Models\\Murid', 53, 'Menghapus data murid: Imelda', '2024-12-15 04:49:24', '2024-12-15 04:49:24', '11:49:24'),
(21, 1, 'App\\Models\\User', 'update', 'App\\Models\\Murid', 11, 'Memperbarui data murid: Fathurr Rahman', '2024-12-15 05:30:04', '2024-12-15 05:30:04', '12:30:04'),
(22, 1, 'App\\Models\\User', 'update', 'App\\Models\\Murid', 11, 'Memperbarui data murid: FathurrRahman', '2024-12-15 05:30:29', '2024-12-15 05:30:29', '12:30:29'),
(24, 1, 'App\\Models\\User', 'create', 'App\\Models\\Guru', 31, 'Menambahkan data murid baru: Ihwanul Akbar S.Kom', '2024-12-15 06:02:15', '2024-12-15 06:02:15', '13:02:15'),
(25, 1, 'App\\Models\\User', 'create', 'App\\Models\\Guru', 32, 'Menambahkan data guru baru: Ihwanul Akbar S.Kom', '2024-12-15 06:03:08', '2024-12-15 06:03:08', '13:03:08'),
(26, 1, 'App\\Models\\User', 'update', 'App\\Models\\Guru', 32, 'Memperbarui data guru: Ihwanul Akbar S.Kom', '2024-12-15 06:05:54', '2024-12-15 06:05:54', '13:05:54'),
(27, 1, 'App\\Models\\User', 'delete', 'App\\Models\\Guru', 32, 'Menghapus data guru: Ihwanul Akbar S.Kom', '2024-12-15 23:11:11', '2024-12-15 23:11:11', '06:11:11'),
(28, 1, 'App\\Models\\User', 'update', 'App\\Models\\Ortu', 32, 'Memperbarui data guru: Cak Lontong', '2024-12-15 23:23:47', '2024-12-15 23:23:47', '06:23:47'),
(29, 1, 'App\\Models\\User', 'update', 'App\\Models\\Ortu', 32, 'Memperbarui data guru: Calon Nama Wali', '2024-12-15 23:24:54', '2024-12-15 23:24:54', '06:24:54'),
(30, 1, 'App\\Models\\User', 'update', 'App\\Models\\Ortu', 32, 'Memperbarui data guru: Wali Murid', '2024-12-15 23:29:21', '2024-12-15 23:29:21', '06:29:21'),
(31, 1, 'App\\Models\\User', 'create', 'App\\Models\\Ortu', 47, 'Menambahkan data wali murid baru: Siregar Budiartiss', '2024-12-15 23:30:06', '2024-12-15 23:30:06', '06:30:06'),
(32, 1, 'App\\Models\\User', 'delete', 'App\\Models\\Ortu', 47, 'Menghapus data wali: Siregar Budiartiss', '2024-12-15 23:30:21', '2024-12-15 23:30:21', '06:30:21'),
(33, 1, 'App\\Models\\User', 'create', 'App\\Models\\TahunAjaran', 12, 'Menambahkan data Tahun Ajaran baru: 2027/1', '2024-12-15 23:59:40', '2024-12-15 23:59:40', '06:59:40'),
(34, 1, 'App\\Models\\User', 'update', 'App\\Models\\TahunAjaran', 12, 'Memperbarui Tahun Ajaran: 2027/1', '2024-12-16 00:00:22', '2024-12-16 00:00:22', '07:00:22'),
(36, 1, 'App\\Models\\User', 'create', 'App\\Models\\TahunAjaran', 13, 'Menambahkan data Tahun Ajaran baru: 2028/1', '2024-12-16 00:17:58', '2024-12-16 00:17:58', '07:17:58'),
(37, 1, 'App\\Models\\User', 'delete', 'App\\Models\\TahunAjaran', 13, 'Menghapus data tahun ajaran: 2028/1', '2024-12-16 00:18:05', '2024-12-16 00:18:05', '07:18:05'),
(41, 1, 'App\\Models\\User', 'update', 'App\\Models\\Kelas', 117, 'Memperbarui Data Kelas: TKJ 13 Tahun Ajaran : 2026/2', '2024-12-16 00:45:21', '2024-12-16 00:45:21', '07:45:21'),
(43, 1, 'App\\Models\\User', 'create', 'App\\Models\\Kelas', 118, 'Menambahkan data kelas baru: TKJ 11111 Tahun Ajaran : 2026/2', '2024-12-16 01:15:03', '2024-12-16 01:15:03', '08:15:03'),
(44, 1, 'App\\Models\\User', 'delete', 'App\\Models\\Kelas', 118, 'Menghapus Data Kelas: TKJ 11111 Tahun Ajaran : 2026/2', '2024-12-16 01:15:24', '2024-12-16 01:15:24', '08:15:24'),
(45, 1, 'App\\Models\\User', 'create', 'App\\Models\\Mapel', 59, 'Menambahkan Data Mapel baru: Investasi', '2024-12-16 06:43:27', '2024-12-16 06:43:27', '13:43:27'),
(46, 1, 'App\\Models\\User', 'update', 'App\\Models\\Mapel', 59, 'Memperbarui Data Mapel: Investasi', '2024-12-16 06:44:56', '2024-12-16 06:44:56', '13:44:56'),
(47, 1, 'App\\Models\\User', 'update', 'App\\Models\\Mapel', 59, 'Memperbarui Data Mapel: Investasi', '2024-12-16 06:45:30', '2024-12-16 06:45:30', '13:45:30'),
(48, 1, 'App\\Models\\User', 'delete', 'App\\Models\\Mapel', 59, 'Menghapus Data Mapel: Investasi Bisnis', '2024-12-16 06:45:54', '2024-12-16 06:45:54', '13:45:54'),
(55, 1, 'App\\Models\\User', 'delete', 'App\\Models\\JamPelajaran', 308, 'Menghapus Data Jam : ( Sabtu jam ke-6)', '2024-12-16 23:37:22', '2024-12-16 23:37:22', '06:37:22'),
(56, 1, 'App\\Models\\User', 'create', 'App\\Models\\JamPelajaran', 309, 'Menambahkan Data Jam Baru: ( Sabtu jam ke -6 )', '2024-12-16 23:37:32', '2024-12-16 23:37:32', '06:37:32'),
(57, 1, 'App\\Models\\User', 'update', 'App\\Models\\JamPelajaran', 309, 'Memperbarui Data Jam: ( Sabtu jam ke -6 )', '2024-12-16 23:37:42', '2024-12-16 23:37:42', '06:37:42'),
(58, 1, 'App\\Models\\User', 'delete', 'App\\Models\\JamPelajaran', 309, 'Menghapus Data Jam : ( Sabtu jam ke-6)', '2024-12-16 23:38:13', '2024-12-16 23:38:13', '06:38:13'),
(62, 1, 'App\\Models\\User', 'create', 'App\\Models\\Sesi', 90, 'Menambahkan Sesi Baru: 2024-12-17', '2024-12-16 23:59:45', '2024-12-16 23:59:45', '06:59:45'),
(63, 1, 'App\\Models\\User', 'update', 'App\\Models\\Sesi', 90, 'Memperbarui Data Sesi: 2024-12-17', '2024-12-16 23:59:50', '2024-12-16 23:59:50', '06:59:50'),
(64, 1, 'App\\Models\\User', 'delete', 'App\\Models\\Sesi', 90, 'Menghapus Data Sesi: 2024-12-17', '2024-12-16 23:59:53', '2024-12-16 23:59:53', '06:59:53'),
(65, 1, 'App\\Models\\User', 'create', 'App\\Models\\Pelanggaran', 25, 'Menambahkan Data Pelanggaran Baru: Membawa Sajam', '2024-12-17 00:12:03', '2024-12-17 00:12:03', '07:12:03'),
(66, 1, 'App\\Models\\User', 'update', 'App\\Models\\Pelanggaran', 25, 'Memperbarui Data Pelanggaran: Membawa Sajam', '2024-12-17 00:12:24', '2024-12-17 00:12:24', '07:12:24'),
(68, 1, 'App\\Models\\User', 'create', 'App\\Models\\Pelanggaran', 26, 'Menambahkan Data Pelanggaran Baru: Bolos', '2024-12-17 00:13:52', '2024-12-17 00:13:52', '07:13:52'),
(69, 1, 'App\\Models\\User', 'delete', 'App\\Models\\Pelanggaran', 26, 'Menghapus Data Pelanggaran: Bolos', '2024-12-17 00:13:58', '2024-12-17 00:13:58', '07:13:58'),
(71, 1, 'App\\Models\\User', 'update', 'App\\Models\\Prestasi', 7, 'Memperbarui Data Prestasi: Lomba Cerdas Cermat', '2024-12-17 02:58:42', '2024-12-17 02:58:42', '09:58:42'),
(72, 1, 'App\\Models\\User', 'delete', 'App\\Models\\Prestasi', 7, 'Menghapus Data Prestasi: Juara 1 Cerdas Cermat', '2024-12-17 02:58:50', '2024-12-17 02:58:50', '09:58:50'),
(73, 1, 'App\\Models\\User', 'create', 'App\\Models\\Prestasi', 8, 'Menambahkan Data Prestasi Baru: Cerdas Cermat', '2024-12-17 02:59:58', '2024-12-17 02:59:58', '09:59:58'),
(76, 1, 'App\\Models\\User', 'create', 'App\\Models\\PelanggaranSiswa', 72, 'Menambahkan Data Murid Melanggar: Asep Setaiwan ( Bully )', '2024-12-17 03:08:24', '2024-12-17 03:08:24', '10:08:24'),
(79, 1, 'App\\Models\\User', 'create', 'App\\Models\\PelanggaranSiswa', 73, 'Menambahkan Data Murid Melanggar: Budi Santoso ( Kekerasan )', '2024-12-17 03:19:15', '2024-12-17 03:19:15', '10:19:15'),
(80, 1, 'App\\Models\\User', 'update', 'App\\Models\\PelanggaranSiswa', 73, 'Memperbarui Data Pelanggaran Murid: Budi Santoso, Pelanggaran Sebelumnya: Kekerasan', '2024-12-17 03:19:33', '2024-12-17 03:19:33', '10:19:33'),
(81, 1, 'App\\Models\\User', 'delete', 'App\\Models\\PelanggaranSiswa', 73, 'Menghapus Data Pelanggaran Murid: Budi Santoso, Pelanggaran: Bully', '2024-12-17 03:19:52', '2024-12-17 03:19:52', '10:19:52'),
(85, 1, 'App\\Models\\User', 'create', 'App\\Models\\PrestasiSiswa', 24, 'Menambahkan Data Murid Berprestasi: Rizky Maulana ( Cerdas Cermat )', '2024-12-17 03:31:20', '2024-12-17 03:31:20', '10:31:20'),
(86, 1, 'App\\Models\\User', 'update', 'App\\Models\\PrestasiSiswa', 24, 'Memperbarui Data Murid Berprestasi: Rizky Maulana, Prestasi Sebelumnya: Cerdas Cermat', '2024-12-17 03:31:44', '2024-12-17 03:31:44', '10:31:44'),
(87, 1, 'App\\Models\\User', 'delete', 'App\\Models\\PrestasiSiswa', 24, 'Menghapus Data Murid Berprestasi: Rizky Maulana, Prestasi: Juara Umum', '2024-12-17 03:32:24', '2024-12-17 03:32:24', '10:32:24'),
(94, 1, 'App\\Models\\User', 'create', 'App\\Models\\Nilai', 134, 'Menambahkan Nilai Baru ke: Ahmad Pratama, Mapel : Sistem Cerdas, Kode TA : 2025/2', '2024-12-17 07:17:33', '2024-12-17 07:17:33', '14:17:33'),
(95, 13, 'App\\Models\\Guru', 'create', 'App\\Models\\Nilai', 137, 'Menambahkan Nilai Baru ke: Candikiawan Kurina, Mapel : Kewirausahaan, Kode TA : 2026/2', '2024-12-17 07:24:43', '2024-12-17 07:24:43', '14:24:43'),
(96, 13, 'App\\Models\\Guru', 'create', 'App\\Models\\Nilai', 138, 'Menambahkan Nilai Baru ke: Candikiawan Kurina, Mapel: Kewirausahaan, Kode TA: 2026/2', '2024-12-17 07:29:16', '2024-12-17 07:29:16', '14:29:16'),
(99, 1, 'App\\Models\\User', 'update', 'App\\Models\\Nilai', 134, 'Memperbarui Nilai: Dari 70.00 ke 99 untuk Murid: Ahmad Pratama, Mapel: Sistem Cerdas, Kode TA: 2025/2', '2024-12-17 07:40:12', '2024-12-17 07:40:12', '14:40:12'),
(100, 13, 'App\\Models\\Guru', 'update', 'App\\Models\\Nilai', 138, 'Memperbarui Nilai: Dari 99.00 ke 70 untuk Murid: Candikiawan Kurina, Mapel: Kewirausahaan, Kode TA: 2026/2', '2024-12-17 07:40:35', '2024-12-17 07:40:35', '14:40:35'),
(102, 1, 'App\\Models\\User', 'create', 'App\\Models\\Nilai', 139, 'Menambahkan Nilai Baru ke: Ahmad Pratama, Mapel: Sistem Cerdas, Kode TA: 2025/2', '2024-12-17 07:45:18', '2024-12-17 07:45:18', '14:45:18'),
(103, 1, 'App\\Models\\User', 'delete', 'App\\Models\\Nilai', 139, 'Menghapus Nilai: 77.00 untuk Murid: Ahmad Pratama, Mapel: Sistem Cerdas, Kode TA: 2025/2', '2024-12-17 07:45:23', '2024-12-17 07:45:23', '14:45:23'),
(105, 1, 'App\\Models\\User', 'delete', 'App\\Models\\Nilai', 140, 'Menghapus Nilai: 99.00 untuk Murid: Ahmad Pratama, Mapel: Sistem Cerdas, Kode TA: 2025/2', '2024-12-17 07:47:21', '2024-12-17 07:47:21', '14:47:21'),
(106, 1, 'App\\Models\\User', 'create', 'App\\Models\\Nilai', 141, 'Menambahkan Nilai Baru (77) ke: Ahmad Pratama, Mapel: Sistem Cerdas, Kode TA: 2025/2', '2024-12-17 07:47:30', '2024-12-17 07:47:30', '14:47:30'),
(107, 13, 'App\\Models\\Guru', 'update', 'App\\Models\\Nilai', 121, 'Memperbarui Nilai: Dari 0.00 ke 100 untuk Murid: Ahmad Pratama, Mapel: Kewirausahaan, Kode TA: 2026/2', '2024-12-17 07:47:55', '2024-12-17 07:47:55', '14:47:55'),
(108, 13, 'App\\Models\\Guru', 'create', 'App\\Models\\Nilai', 142, 'Menambahkan Nilai Baru (77) ke: Dimas Saputra, Mapel: Kewirausahaan, Kode TA: 2026/2', '2024-12-17 07:48:13', '2024-12-17 07:48:13', '14:48:13'),
(113, 1, 'App\\Models\\User', 'create', 'App\\Models\\JadwalPelajaran', 255, 'Menambahkan Data Jadwal Baru ke kelas XII MIA 1 (2025/2), Mapel: Kerja Praktik, untuk hari: Rabu', '2024-12-18 23:37:23', '2024-12-18 23:37:23', '06:37:23'),
(114, 1, 'App\\Models\\User', 'update', 'App\\Models\\JadwalPelajaran', 255, 'Memperbarui Data Jadwal: \r\n- Mapel: Kerja Praktik -> KKN\r\n- Hari: Rabu -> Rabu\r\n- Kelas: XII MIA 1 (2025/2) -> XII MIA 1 (2025/2)', '2024-12-18 23:42:01', '2024-12-18 23:42:01', '06:42:01'),
(115, 1, 'App\\Models\\User', 'delete', 'App\\Models\\JadwalPelajaran', 255, 'Menghapus Data Jadwal: \r\n- Mapel: KKN\r\n- Hari: Rabu\r\n- Kelas: XII MIA 1 (2025/2)', '2024-12-18 23:44:32', '2024-12-18 23:44:32', '06:44:32'),
(119, 1, 'App\\Models\\User', 'create', 'App\\Models\\JamPelajaran', 310, 'Menambahkan Data Jam Baru: ( Kamis jam ke -7 )', '2024-12-19 00:02:52', '2024-12-19 00:02:52', '07:02:52'),
(120, 1, 'App\\Models\\User', 'create', 'App\\Models\\JadwalPelajaran', 256, 'Menambahkan Data Jadwal Baru ke kelas MIA 1 (2026/2), Mapel: Kewirausahaan, untuk hari: Kamis', '2024-12-19 00:03:18', '2024-12-19 00:03:18', '07:03:18'),
(121, 1, 'App\\Models\\User', 'create', 'App\\Models\\Sesi', 91, 'Menambahkan Sesi Baru: 2024-12-19', '2024-12-19 00:04:20', '2024-12-19 00:04:20', '07:04:20'),
(156, 1, 'App\\Models\\User', 'create', 'App\\Models\\Kehadiran', 104, 'Menambahkan Data Kehadiran Untuk Kelas : MIA 2 tanggal : 2024-12-19', '2024-12-19 01:15:12', '2024-12-19 01:15:12', '08:15:12'),
(157, 13, 'App\\Models\\Guru', 'create', 'App\\Models\\Kehadiran', 103, 'Menambahkan Data Kehadiran Untuk Kelas : MIA 1 tanggal : 2024-12-19', '2024-12-19 01:15:22', '2024-12-19 01:15:22', '08:15:22'),
(158, 1, 'App\\Models\\User', 'update', 'App\\Models\\Kehadiran', 394, 'Memperbarui Data Kehadiran dari Hadir ke-Mangkir untuk murid Kuuhaku', '2024-12-19 01:15:37', '2024-12-19 01:15:37', '08:15:37'),
(159, 13, 'App\\Models\\Guru', 'update', 'App\\Models\\Kehadiran', 403, 'Memperbarui Data Kehadiran dari Hadir ke-Izin untuk murid Ahmad Pratama', '2024-12-19 01:15:59', '2024-12-19 01:15:59', '08:15:59'),
(160, 1, 'App\\Models\\User', 'create', 'App\\Models\\TahunAjaran', 14, 'Menambahkan Data Tahun Ajaran Baru: 2027/1', '2024-12-19 01:17:57', '2024-12-19 01:17:57', '08:17:57'),
(161, 1, 'App\\Models\\User', 'create', 'App\\Models\\Kelas', 119, 'Menambahkan Data Kelas Baru: TKJ 1 Tahun Ajaran : 2027/1', '2024-12-19 01:29:51', '2024-12-19 01:29:51', '08:29:51'),
(162, 1, 'App\\Models\\User', 'create', 'App\\Models\\Kelas', 120, 'Menambahkan Data Kelas Baru: TKJ 2 Tahun Ajaran : 2027/1', '2024-12-19 01:29:58', '2024-12-19 01:29:58', '08:29:58'),
(163, 1, 'App\\Models\\User', 'create', 'App\\Models\\Kelas', 121, 'Menambahkan Data Kelas Baru: TKJ 3 Tahun Ajaran : 2027/1', '2024-12-19 01:30:08', '2024-12-19 01:30:08', '08:30:08'),
(164, 1, 'App\\Models\\User', 'create', 'App\\Models\\Kelas', 122, 'Menambahkan Data Kelas Baru: TKJ 4 Tahun Ajaran : 2027/1', '2024-12-19 01:30:17', '2024-12-19 01:30:17', '08:30:17'),
(165, 1, 'App\\Models\\User', 'create', 'App\\Models\\Kelas', 123, 'Menambahkan Data Kelas Baru: TKJ 5 Tahun Ajaran : 2027/1', '2024-12-19 01:30:26', '2024-12-19 01:30:26', '08:30:26'),
(166, 1, 'App\\Models\\User', 'create', 'App\\Models\\Kelas', 124, 'Menambahkan Data Kelas Baru: TKJ 6 Tahun Ajaran : 2027/1', '2024-12-19 01:30:35', '2024-12-19 01:30:35', '08:30:35'),
(167, 1, 'App\\Models\\User', 'create', 'App\\Models\\Kelas', 125, 'Menambahkan Data Kelas Baru: TKJ 7 Tahun Ajaran : 2027/1', '2024-12-19 01:30:48', '2024-12-19 01:30:48', '08:30:48'),
(168, 1, 'App\\Models\\User', 'create', 'App\\Models\\Kelas', 126, 'Menambahkan Data Kelas Baru: TKJ 8 Tahun Ajaran : 2027/1', '2024-12-19 01:31:00', '2024-12-19 01:31:00', '08:31:00'),
(169, 1, 'App\\Models\\User', 'create', 'App\\Models\\Kelas', 127, 'Menambahkan Data Kelas Baru: TKJ 9 Tahun Ajaran : 2027/1', '2024-12-19 01:31:13', '2024-12-19 01:31:13', '08:31:13'),
(170, 1, 'App\\Models\\User', 'create', 'App\\Models\\Kelas', 128, 'Menambahkan Data Kelas Baru: TKJ 10 Tahun Ajaran : 2027/1', '2024-12-19 01:31:24', '2024-12-19 01:31:24', '08:31:24'),
(171, 1, 'App\\Models\\User', 'transisi', 'App\\Models\\TahunAjaran', 10, 'Melakukan Transisi Tahun Ajaran dari 2026/2 -> 2027/1', '2024-12-19 01:32:19', '2024-12-19 01:32:19', '08:32:19'),
(172, 1, 'App\\Models\\User', 'create', 'App\\Models\\JadwalPelajaran', 257, 'Menambahkan Data Jadwal Baru ke kelas TKJ 1 (2027/1), Mapel: Bahasa Indonesia, untuk hari: Senin', '2025-01-08 19:45:51', '2025-01-08 19:45:51', '02:45:51'),
(173, 1, 'App\\Models\\User', 'create', 'App\\Models\\JadwalPelajaran', 258, 'Menambahkan Data Jadwal Baru ke kelas TKJ 1 (2027/1), Mapel: Bisnis Digital, untuk hari: Senin', '2025-01-08 19:46:01', '2025-01-08 19:46:01', '02:46:01'),
(174, 1, 'App\\Models\\User', 'create', 'App\\Models\\JadwalPelajaran', 259, 'Menambahkan Data Jadwal Baru ke kelas TKJ 1 (2027/1), Mapel: Database, untuk hari: Senin', '2025-01-08 19:46:12', '2025-01-08 19:46:12', '02:46:12');

-- --------------------------------------------------------

--
-- Table structure for table `arsip`
--

CREATE TABLE `arsip` (
  `id_arsip` bigint(20) UNSIGNED NOT NULL,
  `id_murid` bigint(20) UNSIGNED NOT NULL,
  `id_ta` bigint(20) UNSIGNED NOT NULL,
  `id_kelas` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `arsip`
--

INSERT INTO `arsip` (`id_arsip`, `id_murid`, `id_ta`, `id_kelas`, `created_at`, `updated_at`) VALUES
(1, 7, 4, 8, '2024-09-18 01:14:13', '2024-09-18 01:14:13'),
(2, 8, 4, 8, '2024-09-18 01:14:13', '2024-09-18 01:14:13'),
(3, 9, 4, 8, '2024-09-18 01:14:13', '2024-09-18 01:14:13'),
(4, 11, 4, 8, '2024-09-18 01:14:13', '2024-09-18 01:14:13'),
(5, 24, 4, 8, '2024-09-18 01:14:13', '2024-09-18 01:14:13'),
(7, 32, 4, 8, '2024-09-18 01:14:13', '2024-09-18 01:14:13'),
(8, 33, 4, 8, '2024-09-18 01:14:13', '2024-09-18 01:14:13'),
(9, 34, 4, 8, '2024-09-18 01:14:13', '2024-09-18 01:14:13'),
(10, 37, 4, 8, '2024-09-18 01:14:13', '2024-09-18 01:14:13'),
(12, 19, 4, 9, '2024-09-18 01:14:13', '2024-09-18 01:14:13'),
(13, 26, 4, 9, '2024-09-18 01:14:13', '2024-09-18 01:14:13'),
(14, 21, 4, 10, '2024-09-18 01:14:13', '2024-09-18 01:14:13'),
(15, 12, 4, 11, '2024-09-18 01:14:13', '2024-09-18 01:14:13'),
(16, 22, 4, 11, '2024-09-18 01:14:13', '2024-09-18 01:14:13'),
(17, 27, 4, 15, '2024-09-18 01:14:13', '2024-09-18 01:14:13'),
(18, 23, 4, 16, '2024-09-18 01:14:13', '2024-09-18 01:14:13'),
(19, 7, 9, 86, '2024-09-18 02:47:54', '2024-09-18 02:47:54'),
(20, 8, 9, 86, '2024-09-18 02:47:54', '2024-09-18 02:47:54'),
(21, 9, 9, 86, '2024-09-18 02:47:54', '2024-09-18 02:47:54'),
(22, 11, 9, 86, '2024-09-18 02:47:54', '2024-09-18 02:47:54'),
(23, 24, 9, 86, '2024-09-18 02:47:54', '2024-09-18 02:47:54'),
(25, 32, 9, 86, '2024-09-18 02:47:54', '2024-09-18 02:47:54'),
(26, 33, 9, 86, '2024-09-18 02:47:54', '2024-09-18 02:47:54'),
(27, 34, 9, 86, '2024-09-18 02:47:54', '2024-09-18 02:47:54'),
(28, 37, 9, 86, '2024-09-18 02:47:54', '2024-09-18 02:47:54'),
(30, 19, 9, 87, '2024-09-18 02:47:54', '2024-09-18 02:47:54'),
(31, 26, 9, 87, '2024-09-18 02:47:54', '2024-09-18 02:47:54'),
(32, 21, 9, 88, '2024-09-18 02:47:54', '2024-09-18 02:47:54'),
(33, 12, 9, 89, '2024-09-18 02:47:54', '2024-09-18 02:47:54'),
(34, 22, 9, 89, '2024-09-18 02:47:54', '2024-09-18 02:47:54'),
(35, 27, 9, 91, '2024-09-18 02:47:54', '2024-09-18 02:47:54'),
(36, 23, 9, 92, '2024-09-18 02:47:54', '2024-09-18 02:47:54'),
(55, 7, 9, 86, '2024-09-22 06:32:34', '2024-09-22 06:32:34'),
(56, 8, 9, 86, '2024-09-22 06:32:34', '2024-09-22 06:32:34'),
(57, 9, 9, 86, '2024-09-22 06:32:34', '2024-09-22 06:32:34'),
(58, 11, 9, 86, '2024-09-22 06:32:34', '2024-09-22 06:32:34'),
(59, 24, 9, 86, '2024-09-22 06:32:34', '2024-09-22 06:32:34'),
(61, 32, 9, 86, '2024-09-22 06:32:34', '2024-09-22 06:32:34'),
(62, 33, 9, 86, '2024-09-22 06:32:34', '2024-09-22 06:32:34'),
(63, 34, 9, 86, '2024-09-22 06:32:34', '2024-09-22 06:32:34'),
(64, 37, 9, 86, '2024-09-22 06:32:34', '2024-09-22 06:32:34'),
(66, 19, 9, 87, '2024-09-22 06:32:34', '2024-09-22 06:32:34'),
(67, 26, 9, 87, '2024-09-22 06:32:34', '2024-09-22 06:32:34'),
(68, 21, 9, 88, '2024-09-22 06:32:34', '2024-09-22 06:32:34'),
(69, 12, 9, 89, '2024-09-22 06:32:34', '2024-09-22 06:32:34'),
(70, 22, 9, 89, '2024-09-22 06:32:34', '2024-09-22 06:32:34'),
(71, 27, 9, 91, '2024-09-22 06:32:34', '2024-09-22 06:32:34'),
(72, 23, 9, 92, '2024-09-22 06:32:34', '2024-09-22 06:32:34'),
(73, 7, 10, 103, '2024-09-22 06:35:28', '2024-09-22 06:35:28'),
(74, 8, 10, 103, '2024-09-22 06:35:28', '2024-09-22 06:35:28'),
(75, 9, 10, 103, '2024-09-22 06:35:28', '2024-09-22 06:35:28'),
(76, 11, 10, 103, '2024-09-22 06:35:28', '2024-09-22 06:35:28'),
(77, 24, 10, 103, '2024-09-22 06:35:28', '2024-09-22 06:35:28'),
(79, 32, 10, 103, '2024-09-22 06:35:28', '2024-09-22 06:35:28'),
(80, 33, 10, 103, '2024-09-22 06:35:28', '2024-09-22 06:35:28'),
(81, 34, 10, 103, '2024-09-22 06:35:28', '2024-09-22 06:35:28'),
(82, 37, 10, 103, '2024-09-22 06:35:28', '2024-09-22 06:35:28'),
(84, 19, 10, 104, '2024-09-22 06:35:28', '2024-09-22 06:35:28'),
(85, 26, 10, 104, '2024-09-22 06:35:28', '2024-09-22 06:35:28'),
(86, 21, 10, 105, '2024-09-22 06:35:28', '2024-09-22 06:35:28'),
(87, 12, 10, 106, '2024-09-22 06:35:28', '2024-09-22 06:35:28'),
(88, 22, 10, 106, '2024-09-22 06:35:28', '2024-09-22 06:35:28'),
(89, 27, 10, 108, '2024-09-22 06:35:28', '2024-09-22 06:35:28'),
(90, 23, 10, 109, '2024-09-22 06:35:28', '2024-09-22 06:35:28'),
(91, 7, 9, 86, '2024-09-22 07:02:07', '2024-09-22 07:02:07'),
(92, 8, 9, 86, '2024-09-22 07:02:07', '2024-09-22 07:02:07'),
(93, 9, 9, 86, '2024-09-22 07:02:07', '2024-09-22 07:02:07'),
(94, 11, 9, 86, '2024-09-22 07:02:07', '2024-09-22 07:02:07'),
(95, 24, 9, 86, '2024-09-22 07:02:07', '2024-09-22 07:02:07'),
(97, 32, 9, 86, '2024-09-22 07:02:07', '2024-09-22 07:02:07'),
(98, 33, 9, 86, '2024-09-22 07:02:07', '2024-09-22 07:02:07'),
(99, 34, 9, 86, '2024-09-22 07:02:07', '2024-09-22 07:02:07'),
(100, 37, 9, 86, '2024-09-22 07:02:07', '2024-09-22 07:02:07'),
(102, 19, 9, 87, '2024-09-22 07:02:07', '2024-09-22 07:02:07'),
(103, 26, 9, 87, '2024-09-22 07:02:07', '2024-09-22 07:02:07'),
(104, 21, 9, 88, '2024-09-22 07:02:07', '2024-09-22 07:02:07'),
(105, 12, 9, 89, '2024-09-22 07:02:07', '2024-09-22 07:02:07'),
(106, 22, 9, 89, '2024-09-22 07:02:07', '2024-09-22 07:02:07'),
(107, 27, 9, 91, '2024-09-22 07:02:07', '2024-09-22 07:02:07'),
(108, 23, 9, 92, '2024-09-22 07:02:07', '2024-09-22 07:02:07'),
(112, 27, 10, 103, '2024-11-15 07:47:13', '2024-11-15 07:47:13'),
(113, 7, 10, 103, '2024-12-19 01:32:19', '2024-12-19 01:32:19'),
(114, 8, 10, 103, '2024-12-19 01:32:19', '2024-12-19 01:32:19'),
(115, 9, 10, 103, '2024-12-19 01:32:19', '2024-12-19 01:32:19'),
(116, 11, 10, 103, '2024-12-19 01:32:19', '2024-12-19 01:32:19'),
(117, 24, 10, 103, '2024-12-19 01:32:19', '2024-12-19 01:32:19'),
(118, 27, 10, 103, '2024-12-19 01:32:19', '2024-12-19 01:32:19'),
(119, 32, 10, 103, '2024-12-19 01:32:19', '2024-12-19 01:32:19'),
(120, 33, 10, 103, '2024-12-19 01:32:19', '2024-12-19 01:32:19'),
(121, 34, 10, 103, '2024-12-19 01:32:19', '2024-12-19 01:32:19'),
(122, 37, 10, 103, '2024-12-19 01:32:19', '2024-12-19 01:32:19'),
(123, 19, 10, 104, '2024-12-19 01:32:19', '2024-12-19 01:32:19'),
(124, 26, 10, 104, '2024-12-19 01:32:19', '2024-12-19 01:32:19'),
(125, 21, 10, 105, '2024-12-19 01:32:19', '2024-12-19 01:32:19'),
(126, 12, 10, 106, '2024-12-19 01:32:19', '2024-12-19 01:32:19'),
(127, 22, 10, 106, '2024-12-19 01:32:19', '2024-12-19 01:32:19'),
(128, 23, 10, 109, '2024-12-19 01:32:19', '2024-12-19 01:32:19');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gurus`
--

CREATE TABLE `gurus` (
  `id_guru` bigint(20) UNSIGNED NOT NULL,
  `nip` varchar(255) NOT NULL,
  `nama_guru` varchar(255) NOT NULL,
  `id_mapel` bigint(20) UNSIGNED DEFAULT NULL,
  `alamat` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `role` bigint(20) UNSIGNED NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gurus`
--

INSERT INTO `gurus` (`id_guru`, `nip`, `nama_guru`, `id_mapel`, `alamat`, `email`, `role`, `password`, `created_at`, `updated_at`) VALUES
(12, '89789789', 'Ayunda Riska Azizah, S.T., M.T.', NULL, 'Jl Paus', 'ayundariska@gmail.com', 5, '$2y$12$oGi7e3zIBXxsDR0x56r/7.8Zb/iLtTMqVK18c0bbylTdlu.JpOPEO', '2024-03-12 00:03:32', '2024-11-13 02:12:00'),
(13, '199802032017021002', 'Drs. Ahmad Suryadi, M.Pd.', NULL, 'Jl Ahmad Yani', 'ahmad0302@gmail.com', 5, '$2y$12$.gkEgLtS884jampZOpnhr.0sQuLqtPdgo3ZU.ov.B6Dm76uIMbyQK', '2024-03-12 03:07:16', '2024-11-13 02:04:25'),
(14, '0402606', 'Drs. Fahmi Kurniawan, S.Kom.', NULL, 'Jl Teratai', 'fhmikrnwan@gmail.com', 5, '$2y$12$uhTdYnafnXqSN682MntFaeOm0KgaW74T1JteykiByka8Tyj93QQ1O', '2024-03-12 03:09:58', '2024-11-13 02:07:43'),
(15, '0503122', 'Yuliarti, M.Pd', NULL, 'Jl Sumatra', 'Yuliarti@gmail.com', 5, '$2y$12$QVoccsNpDxxm93yrvhXtw.2a7YnD0Oa8TmgYb/ufXTxQxATqg/sgm', '2024-03-12 03:10:53', '2024-11-13 06:43:31'),
(16, '0402803', 'Muhammad Setiawan , S.Kom.', NULL, 'Jl. Jendral', 'msetiawan290892@gmail.com', 5, '$2y$12$rW0Kq59u91ublPmML23b.OtOfxLPj8n8M0ukX98SN8Jz7K5fE9Mc6', '2024-03-12 03:11:38', '2024-11-13 06:43:08'),
(17, '0402607', 'Setiawan Anggara, M.Kom', NULL, 'Jl. M. Yamin', 'wawananggara123321@gmail.com', 5, '$2y$12$gQYE1SS/ncCG29XodK/mGekNPexAej0/p6s8F6txgSb4CSm2QUAaG', '2024-03-12 03:12:17', '2024-11-28 03:29:25'),
(18, '0402602', 'Sulaiman Ilyas, S.T', NULL, 'Jl. Dalia', 'sulaiman0902ilyas@gmail.com', 5, '$2y$12$aO2oYq0mtEemIdtnLnqyDOFyeTebzNoBn/f8B1CH/jDePR1Izfyq.', '2024-03-12 03:12:43', '2024-11-13 06:42:49'),
(19, '0402605', 'Muhammad Gilang Angguna, S.Kom., M.Kom', NULL, 'Jl Melati', 'gilangangguna220198@gmail.com', 5, '$2y$12$cCQYM1E8YyacSEQyV0AXjuNkJhrEnT4xyJGtEnp3T3uxhw.tGVhdi', '2024-03-12 03:13:09', '2024-11-13 02:10:52'),
(20, '0402708', 'Bambang Prasetyo, S.Pd., M.T.', NULL, 'Jl Paus', 'bambangg2203@gmail.com', 5, '$2y$12$pP.fxmFpmEjYGuxmN5u28.yKY2UjAYz//ySkknB.ra09Q4J0U8cJ.', '2024-03-12 03:13:54', '2024-11-13 06:43:52'),
(21, '0402503', 'Evi Susanti, S.Pd., M.Pd.', NULL, 'Jl Sudirman', 'evisusanti1992@gmail.com', 5, '$2y$12$2dzbqYMvOmqD6QYTJesSVecK1ZGp91gYvv8eyEi0OJNfbXZwdQFpm', '2024-03-12 03:14:24', '2024-11-13 02:08:32'),
(22, '0402504', 'Muhammad Fathra , SH., MH', NULL, 'Jl. Kenanga', 'mfathra@gmail.com', 5, '$2y$12$9c.N1b.8EDQqcgf9iGytBeNpLW9wrnd.YhprNOCJo4jGr5WrM1zTm', '2024-03-12 03:15:34', '2024-11-13 02:09:48'),
(23, '2102', 'Rahmadian Syah, S.T', NULL, 'Jl Sumatra', 'dianrahma@gmail.com', 5, '$2y$12$S/.ihZxw0jNkpWNdLerqweYE/ESfd0gHtkbz7J8TrsBagmjL2V9BO', '2024-03-12 03:48:24', '2024-11-13 06:42:07'),
(24, '876', 'Nafsiah, S.Ag', NULL, 'Jl Sumatra', 'Naf@gmail.com', 5, '$2y$12$foUYTrw4sby9Zw3GC1vYd.hvcdjh3lu6upab4pfEOxFNNlKi9Ffv.', '2024-03-12 04:10:42', '2024-03-12 04:10:42');

-- --------------------------------------------------------

--
-- Table structure for table `jadwal_pelajarans`
--

CREATE TABLE `jadwal_pelajarans` (
  `id_jadwal` bigint(20) UNSIGNED NOT NULL,
  `id_kelas` bigint(20) UNSIGNED NOT NULL,
  `id_jam` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `id_mapel` bigint(20) UNSIGNED NOT NULL,
  `id_guru` bigint(20) UNSIGNED NOT NULL,
  `id_ta` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jadwal_pelajarans`
--

INSERT INTO `jadwal_pelajarans` (`id_jadwal`, `id_kelas`, `id_jam`, `created_at`, `updated_at`, `id_mapel`, `id_guru`, `id_ta`) VALUES
(129, 8, 215, '2024-06-21 00:25:09', '2024-06-21 00:25:09', 49, 23, 4),
(130, 8, 292, '2024-06-21 00:25:15', '2024-06-21 00:25:15', 49, 23, 4),
(131, 8, 293, '2024-06-21 00:25:22', '2024-06-21 00:25:22', 29, 20, 4),
(164, 8, 221, '2024-08-15 02:23:42', '2024-08-15 02:23:57', 25, 21, 4),
(167, 8, 289, '2024-09-13 11:37:28', '2024-09-13 11:37:28', 28, 16, 4),
(168, 86, 208, '2024-09-18 01:21:58', '2024-09-18 01:21:58', 53, 20, 9),
(181, 86, 209, '2024-09-22 23:28:14', '2024-09-22 23:28:14', 52, 15, 9),
(182, 86, 210, '2024-09-22 23:28:21', '2024-09-22 23:28:21', 49, 23, 9),
(183, 86, 214, '2024-09-22 23:28:29', '2024-09-22 23:28:29', 28, 16, 9),
(184, 103, 208, '2024-09-22 23:35:24', '2024-09-22 23:35:24', 52, 15, 10),
(185, 103, 209, '2024-09-22 23:35:43', '2024-09-22 23:35:43', 23, 12, 10),
(186, 103, 210, '2024-09-22 23:35:51', '2024-11-23 00:00:31', 28, 16, 10),
(187, 103, 214, '2024-09-22 23:35:58', '2024-11-21 05:53:59', 53, 20, 10),
(189, 104, 208, '2024-09-27 06:03:20', '2024-09-27 06:03:20', 31, 13, 10),
(190, 104, 209, '2024-09-27 06:03:30', '2024-09-27 06:03:30', 31, 13, 10),
(191, 104, 221, '2024-09-27 06:33:42', '2024-09-27 06:33:42', 31, 13, 10),
(192, 104, 223, '2024-09-27 06:33:53', '2024-09-27 06:33:53', 31, 13, 10),
(193, 8, 287, '2024-09-27 20:30:06', '2024-09-27 20:30:06', 23, 12, 4),
(194, 8, 286, '2024-09-27 20:30:27', '2024-09-27 20:30:27', 48, 12, 4),
(195, 8, 241, '2024-09-27 20:33:53', '2024-09-27 20:33:53', 23, 12, 4),
(196, 8, 279, '2024-09-27 20:34:05', '2024-09-27 20:34:05', 23, 12, 4),
(197, 8, 232, '2024-09-27 20:34:27', '2024-09-27 20:34:27', 23, 12, 4),
(198, 8, 225, '2024-09-27 20:34:39', '2024-09-27 20:34:39', 23, 12, 4),
(202, 8, 222, '2024-09-27 20:35:55', '2024-09-27 20:35:55', 48, 12, 4),
(203, 8, 226, '2024-09-27 20:36:05', '2024-09-27 20:36:05', 48, 12, 4),
(206, 8, 230, '2024-09-28 21:50:29', '2024-09-28 21:50:29', 48, 12, 4),
(207, 8, 229, '2024-09-28 21:51:02', '2024-09-28 21:51:02', 23, 12, 4),
(208, 8, 208, '2024-09-28 21:56:31', '2024-09-28 21:56:31', 23, 12, 4),
(209, 8, 209, '2024-09-28 21:56:39', '2024-09-28 21:56:39', 48, 12, 4),
(210, 8, 210, '2024-09-28 21:56:55', '2024-09-28 21:56:55', 23, 12, 4),
(223, 86, 297, '2024-10-01 01:02:37', '2024-10-01 01:02:37', 49, 23, 9),
(224, 86, 298, '2024-10-01 02:57:47', '2024-10-01 02:57:47', 49, 23, 9),
(225, 86, 221, '2024-10-01 02:58:02', '2024-10-01 02:58:02', 49, 23, 9),
(226, 103, 299, '2024-10-01 23:29:29', '2024-10-01 23:29:29', 31, 13, 10),
(230, 103, 288, '2024-10-15 00:22:26', '2024-10-15 00:22:26', 30, 13, 10),
(231, 103, 300, '2024-11-06 00:04:53', '2024-11-06 00:04:53', 53, 20, 10),
(234, 104, 290, '2024-11-14 23:41:28', '2024-11-14 23:41:28', 30, 13, 10),
(235, 104, 242, '2024-11-14 23:41:43', '2024-11-14 23:41:43', 31, 13, 10),
(236, 107, 247, '2024-11-14 23:42:09', '2024-11-14 23:42:09', 31, 13, 10),
(237, 111, 248, '2024-11-14 23:42:28', '2024-11-14 23:42:28', 30, 13, 10),
(240, 103, 292, '2024-11-23 01:03:03', '2024-11-23 01:03:03', 49, 23, 10),
(247, 108, 208, '2024-12-08 17:04:27', '2024-12-08 17:05:18', 32, 17, 10),
(250, 103, 225, '2024-12-09 21:47:41', '2024-12-09 21:47:41', 30, 13, 10),
(253, 103, 304, '2024-12-18 23:32:02', '2024-12-18 23:32:02', 51, 24, 10),
(256, 103, 310, '2024-12-19 00:03:18', '2024-12-19 00:03:18', 30, 13, 10),
(257, 119, 208, '2025-01-08 19:45:51', '2025-01-08 19:45:51', 52, 15, 14),
(258, 119, 209, '2025-01-08 19:46:01', '2025-01-08 19:46:01', 39, 19, 14),
(259, 119, 210, '2025-01-08 19:46:12', '2025-01-08 19:46:12', 49, 23, 14);

-- --------------------------------------------------------

--
-- Table structure for table `jam_pelajarans`
--

CREATE TABLE `jam_pelajarans` (
  `id_jam` bigint(20) UNSIGNED NOT NULL,
  `jam_ke` int(255) NOT NULL,
  `jam_mulai` time NOT NULL,
  `jam_selesai` time NOT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `id_jadwal` bigint(20) UNSIGNED DEFAULT NULL,
  `hari` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jam_pelajarans`
--

INSERT INTO `jam_pelajarans` (`id_jam`, `jam_ke`, `jam_mulai`, `jam_selesai`, `keterangan`, `created_at`, `updated_at`, `id_jadwal`, `hari`) VALUES
(208, 1, '07:00:00', '08:00:00', 'Jam Pertama', '2024-04-20 01:26:47', '2024-04-20 01:26:47', NULL, 'Senin'),
(209, 2, '08:00:00', '09:00:00', NULL, '2024-04-20 01:27:07', '2024-06-09 23:56:54', NULL, 'Senin'),
(210, 3, '09:00:00', '10:00:00', NULL, '2024-04-20 01:27:26', '2024-04-20 01:27:26', NULL, 'Senin'),
(214, 4, '10:00:00', '11:00:00', 'Istirahat', '2024-04-20 02:56:52', '2024-04-20 02:56:52', NULL, 'Senin'),
(215, 5, '11:00:00', '12:00:00', 'Jam Terakhir', '2024-04-20 03:16:18', '2024-04-20 03:16:18', NULL, 'Senin'),
(221, 1, '07:00:00', '08:00:00', 'Selasa Jam Pertama', '2024-04-20 21:54:35', '2024-04-20 21:55:27', NULL, 'Selasa'),
(222, 2, '08:00:00', '09:00:00', NULL, '2024-04-20 22:02:13', '2024-04-20 22:02:13', NULL, 'Selasa'),
(223, 3, '09:00:00', '10:00:00', NULL, '2024-04-20 22:03:27', '2024-04-20 22:03:27', NULL, 'Selasa'),
(224, 4, '10:00:00', '11:00:00', 'Waktu Istirahat', '2024-04-20 22:04:15', '2024-04-20 22:04:15', NULL, 'Selasa'),
(225, 5, '11:00:00', '13:00:00', 'Selasa Jam Terakhir', '2024-04-20 22:05:06', '2024-12-09 21:47:07', NULL, 'Selasa'),
(226, 1, '07:00:00', '08:00:00', NULL, '2024-04-20 22:43:34', '2024-04-21 04:11:36', NULL, 'Rabu'),
(229, 2, '08:00:00', '09:00:00', NULL, '2024-04-21 04:12:09', '2024-04-21 04:12:09', NULL, 'Rabu'),
(230, 3, '09:00:00', '10:00:00', NULL, '2024-04-21 04:12:24', '2024-04-21 04:12:24', NULL, 'Rabu'),
(231, 4, '10:00:00', '11:00:00', 'Istirahat', '2024-04-21 04:12:40', '2024-04-21 04:12:40', NULL, 'Rabu'),
(232, 5, '11:00:00', '12:00:00', 'Rabu Jam Terakhir', '2024-04-21 04:13:20', '2024-04-21 23:39:04', NULL, 'Rabu'),
(234, 1, '07:00:00', '08:00:00', 'Kamis Jam Pertama', '2024-04-21 23:42:37', '2024-04-21 23:42:37', NULL, 'Kamis'),
(235, 2, '08:00:00', '09:00:00', NULL, '2024-04-21 23:43:00', '2024-04-21 23:43:00', NULL, 'Kamis'),
(236, 3, '09:00:00', '10:00:00', NULL, '2024-04-21 23:43:10', '2024-04-21 23:43:10', NULL, 'Kamis'),
(237, 4, '10:00:00', '11:00:00', 'Istirahat', '2024-04-21 23:43:25', '2024-04-21 23:43:25', NULL, 'Kamis'),
(238, 5, '11:00:00', '12:00:00', 'Jam Terakhir', '2024-04-21 23:43:43', '2024-04-21 23:43:43', NULL, 'Kamis'),
(241, 1, '07:00:00', '08:00:00', 'Imtaq', '2024-04-22 01:23:45', '2024-05-29 03:21:45', NULL, 'Jumat'),
(242, 2, '08:00:00', '09:00:00', 'tes', '2024-04-23 23:46:36', '2024-06-02 07:44:50', NULL, 'Jumat'),
(247, 3, '09:00:00', '10:00:00', NULL, '2024-04-24 00:23:56', '2024-04-24 00:23:56', NULL, 'Jumat'),
(248, 4, '10:00:00', '11:00:00', 'Istirahat', '2024-04-24 00:51:16', '2024-05-30 01:04:18', NULL, 'Jumat'),
(279, 6, '12:00:00', '13:00:00', 'Keterangan', '2024-06-10 00:15:27', '2024-06-10 01:17:49', NULL, 'Kamis'),
(285, 1, '07:00:00', '08:00:00', 'Masuk', '2024-06-10 01:38:51', '2024-06-10 01:41:51', NULL, 'Sabtu'),
(286, 2, '08:00:00', '09:00:00', NULL, '2024-06-10 01:40:20', '2024-06-10 01:40:51', NULL, 'Sabtu'),
(287, 3, '09:00:00', '10:00:00', NULL, '2024-06-10 01:41:10', '2024-06-10 01:41:10', NULL, 'Sabtu'),
(288, 4, '10:00:00', '11:00:00', 'Istirahat', '2024-06-10 01:41:28', '2024-06-10 01:42:00', NULL, 'Sabtu'),
(289, 5, '11:00:00', '12:00:00', NULL, '2024-06-10 01:41:43', '2024-06-10 01:41:43', NULL, 'Sabtu'),
(290, 6, '12:00:00', '18:00:00', 'Tutup Sekolah', '2024-06-10 01:42:18', '2024-11-14 23:41:00', NULL, 'Jumat'),
(292, 6, '12:00:00', '13:00:00', NULL, '2024-06-12 21:09:56', '2024-06-12 21:09:56', NULL, 'Senin'),
(293, 7, '13:00:00', '14:00:00', 'Pulang sekolah', '2024-06-12 21:10:12', '2024-06-12 21:26:27', NULL, 'Senin'),
(297, 6, '15:00:00', '17:00:00', NULL, '2024-10-01 01:02:02', '2024-10-01 01:02:02', NULL, 'Selasa'),
(298, 7, '17:00:00', '21:00:00', NULL, '2024-10-01 02:56:42', '2024-10-01 02:56:42', NULL, 'Selasa'),
(299, 6, '13:00:00', '20:00:00', NULL, '2024-10-01 23:29:04', '2024-10-01 23:29:04', NULL, 'Rabu'),
(300, 7, '14:00:00', '15:00:00', NULL, '2024-11-06 00:04:40', '2024-11-06 00:04:40', NULL, 'Rabu'),
(304, 8, '14:00:00', '15:00:00', 'Jam Terakhir', '2024-12-09 21:29:56', '2024-12-09 21:29:56', NULL, 'Senin'),
(310, 7, '14:00:00', '18:00:00', NULL, '2024-12-19 00:02:52', '2024-12-19 00:02:52', NULL, 'Kamis');

-- --------------------------------------------------------

--
-- Table structure for table `kehadirans`
--

CREATE TABLE `kehadirans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_murid` bigint(20) UNSIGNED DEFAULT NULL,
  `id_kelas` bigint(20) UNSIGNED DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `id_sesi` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kehadirans`
--

INSERT INTO `kehadirans` (`id`, `id_murid`, `id_kelas`, `status`, `keterangan`, `created_at`, `updated_at`, `id_sesi`) VALUES
(94, 7, 8, 'Hadir', NULL, '2024-09-10 00:48:47', '2024-09-10 00:48:47', 69),
(95, 8, 8, 'Hadir', NULL, '2024-09-10 00:48:47', '2024-09-10 00:48:47', 69),
(96, 9, 8, 'Hadir', NULL, '2024-09-10 00:48:47', '2024-09-10 00:48:47', 69),
(97, 11, 8, 'Hadir', NULL, '2024-09-10 00:48:47', '2024-09-10 00:48:47', 69),
(98, 24, 8, 'Hadir', NULL, '2024-09-10 00:48:47', '2024-09-10 00:48:47', 69),
(100, 32, 8, 'Hadir', NULL, '2024-09-10 00:48:47', '2024-09-10 00:48:47', 69),
(102, 34, 8, 'Hadir', NULL, '2024-09-10 00:48:47', '2024-09-10 00:48:47', 69),
(103, 37, 8, 'Hadir', NULL, '2024-09-10 00:48:47', '2024-09-10 00:48:47', 69),
(105, 19, 9, 'Hadir', NULL, '2024-09-10 00:49:24', '2024-09-10 00:49:24', 69),
(106, 26, 9, 'Hadir', NULL, '2024-09-10 00:49:24', '2024-09-10 00:49:24', 69),
(108, 19, 9, 'Izin', NULL, '2024-09-10 00:49:38', '2024-09-10 00:49:45', 68),
(109, 26, 9, 'Hadir', NULL, '2024-09-10 00:49:38', '2024-09-10 00:49:38', 68),
(111, 19, 9, 'Hadir', NULL, '2024-09-10 00:50:11', '2024-09-10 00:50:11', 70),
(112, 26, 9, 'Hadir', NULL, '2024-09-10 00:50:11', '2024-09-10 00:50:11', 70),
(114, 19, 9, 'Hadir', NULL, '2024-09-10 00:50:16', '2024-09-10 00:50:16', 71),
(115, 26, 9, 'Hadir', NULL, '2024-09-10 00:50:16', '2024-09-10 00:50:16', 71),
(116, 7, 8, 'Hadir', NULL, '2024-09-10 00:50:41', '2024-09-10 00:50:41', 68),
(117, 8, 8, 'Hadir', NULL, '2024-09-10 00:50:41', '2024-09-10 00:50:41', 68),
(118, 9, 8, 'Mangkir', NULL, '2024-09-10 00:50:41', '2024-09-13 03:44:19', 68),
(119, 11, 8, 'Hadir', NULL, '2024-09-10 00:50:41', '2024-09-10 00:50:41', 68),
(120, 24, 8, 'Hadir', NULL, '2024-09-10 00:50:41', '2024-09-10 00:50:41', 68),
(122, 32, 8, 'Mangkir', 'Sakit', '2024-09-10 00:50:41', '2024-09-11 01:57:29', 68),
(124, 34, 8, 'Hadir', NULL, '2024-09-10 00:50:41', '2024-09-10 00:50:41', 68),
(125, 37, 8, 'Hadir', NULL, '2024-09-10 00:50:41', '2024-09-10 00:50:41', 68),
(126, 7, 8, 'Hadir', NULL, '2024-09-10 00:50:46', '2024-09-10 00:50:46', 71),
(127, 8, 8, 'Hadir', NULL, '2024-09-10 00:50:46', '2024-09-10 00:50:46', 71),
(128, 9, 8, 'Izin', NULL, '2024-09-10 00:50:46', '2024-09-13 03:45:17', 71),
(129, 11, 8, 'Hadir', NULL, '2024-09-10 00:50:46', '2024-09-10 00:50:46', 71),
(130, 24, 8, 'Hadir', NULL, '2024-09-10 00:50:46', '2024-09-10 00:50:46', 71),
(132, 32, 8, 'Hadir', NULL, '2024-09-10 00:50:46', '2024-09-10 00:50:46', 71),
(134, 34, 8, 'Hadir', NULL, '2024-09-10 00:50:46', '2024-09-10 00:50:46', 71),
(135, 37, 8, 'Hadir', NULL, '2024-09-10 00:50:46', '2024-09-10 00:50:46', 71),
(137, 33, 8, 'Izin', 'Sakit', '2024-09-10 00:54:06', '2024-09-10 00:54:15', 69),
(138, 7, 8, 'Hadir', NULL, '2024-09-10 01:12:38', '2024-09-10 01:12:38', 70),
(139, 8, 8, 'Hadir', NULL, '2024-09-10 01:12:38', '2024-09-10 01:12:38', 70),
(140, 9, 8, 'Hadir', NULL, '2024-09-10 01:12:38', '2024-09-10 01:12:38', 70),
(141, 11, 8, 'Hadir', NULL, '2024-09-10 01:12:38', '2024-09-10 01:12:38', 70),
(142, 24, 8, 'Hadir', NULL, '2024-09-10 01:12:38', '2024-09-10 01:12:38', 70),
(144, 32, 8, 'Hadir', NULL, '2024-09-10 01:12:38', '2024-09-10 01:12:38', 70),
(145, 33, 8, 'Mangkir', NULL, '2024-09-10 01:12:38', '2024-09-11 23:43:20', 70),
(146, 34, 8, 'Hadir', NULL, '2024-09-10 01:12:38', '2024-09-10 01:12:38', 70),
(147, 37, 8, 'Hadir', NULL, '2024-09-10 01:12:38', '2024-09-10 01:12:38', 70),
(148, 33, 8, 'Hadir', NULL, '2024-09-10 01:12:47', '2024-09-10 01:12:47', 71),
(149, 7, 8, 'Hadir', NULL, '2024-09-10 01:15:20', '2024-09-10 01:15:20', 72),
(150, 8, 8, 'Hadir', NULL, '2024-09-10 01:15:20', '2024-09-10 01:15:20', 72),
(151, 9, 8, 'Hadir', NULL, '2024-09-10 01:15:20', '2024-09-10 01:15:20', 72),
(152, 11, 8, 'Hadir', NULL, '2024-09-10 01:15:20', '2024-09-10 01:15:20', 72),
(153, 24, 8, 'Hadir', NULL, '2024-09-10 01:15:20', '2024-09-10 01:15:20', 72),
(155, 32, 8, 'Hadir', NULL, '2024-09-10 01:15:20', '2024-09-10 01:15:20', 72),
(156, 33, 8, 'Hadir', NULL, '2024-09-10 01:15:20', '2024-09-10 01:16:35', 72),
(157, 34, 8, 'Hadir', NULL, '2024-09-10 01:15:20', '2024-09-10 01:15:20', 72),
(158, 37, 8, 'Hadir', NULL, '2024-09-10 01:15:20', '2024-09-10 01:15:20', 72),
(159, 33, 8, 'Mangkir', NULL, '2024-09-11 01:57:58', '2024-09-11 23:43:06', 68),
(160, 7, 8, 'Hadir', NULL, '2024-09-13 00:23:12', '2024-09-13 00:23:12', 73),
(161, 8, 8, 'Hadir', NULL, '2024-09-13 00:23:12', '2024-09-13 00:23:12', 73),
(162, 9, 8, 'Hadir', NULL, '2024-09-13 00:23:12', '2024-09-13 00:23:12', 73),
(163, 11, 8, 'Hadir', NULL, '2024-09-13 00:23:12', '2024-09-13 00:23:12', 73),
(164, 24, 8, 'Hadir', NULL, '2024-09-13 00:23:12', '2024-09-13 00:23:12', 73),
(166, 32, 8, 'Hadir', NULL, '2024-09-13 00:23:12', '2024-09-13 00:23:12', 73),
(167, 33, 8, 'Mangkir', NULL, '2024-09-13 00:23:12', '2024-09-13 00:23:19', 73),
(168, 34, 8, 'Hadir', NULL, '2024-09-13 00:23:12', '2024-09-13 00:23:12', 73),
(169, 37, 8, 'Hadir', NULL, '2024-09-13 00:23:12', '2024-09-13 00:23:12', 73),
(170, 7, 8, 'Hadir', NULL, '2024-09-13 00:23:27', '2024-09-13 00:23:27', 74),
(171, 8, 8, 'Hadir', NULL, '2024-09-13 00:23:27', '2024-09-13 00:23:27', 74),
(172, 9, 8, 'Hadir', NULL, '2024-09-13 00:23:27', '2024-09-13 00:23:27', 74),
(173, 11, 8, 'Hadir', NULL, '2024-09-13 00:23:27', '2024-09-13 00:23:27', 74),
(174, 24, 8, 'Hadir', NULL, '2024-09-13 00:23:27', '2024-09-13 00:23:27', 74),
(176, 32, 8, 'Hadir', NULL, '2024-09-13 00:23:27', '2024-09-13 00:23:27', 74),
(177, 33, 8, 'Izin', NULL, '2024-09-13 00:23:27', '2024-09-13 00:23:32', 74),
(178, 34, 8, 'Hadir', NULL, '2024-09-13 00:23:27', '2024-09-13 00:23:27', 74),
(179, 37, 8, 'Hadir', NULL, '2024-09-13 00:23:27', '2024-09-13 00:23:27', 74),
(180, 7, 8, 'Hadir', NULL, '2024-09-13 00:23:47', '2024-09-13 00:23:47', 75),
(181, 8, 8, 'Hadir', NULL, '2024-09-13 00:23:47', '2024-09-13 00:23:47', 75),
(182, 9, 8, 'Hadir', NULL, '2024-09-13 00:23:47', '2024-09-13 00:23:47', 75),
(183, 11, 8, 'Hadir', NULL, '2024-09-13 00:23:47', '2024-09-13 00:23:47', 75),
(184, 24, 8, 'Hadir', NULL, '2024-09-13 00:23:47', '2024-09-13 00:23:47', 75),
(186, 32, 8, 'Hadir', NULL, '2024-09-13 00:23:47', '2024-09-13 00:23:47', 75),
(187, 33, 8, 'Izin', NULL, '2024-09-13 00:23:47', '2024-09-13 00:23:52', 75),
(188, 34, 8, 'Hadir', NULL, '2024-09-13 00:23:47', '2024-09-13 00:23:47', 75),
(189, 37, 8, 'Hadir', NULL, '2024-09-13 00:23:47', '2024-09-13 00:23:47', 75),
(190, 7, 8, 'Hadir', NULL, '2024-09-13 00:24:01', '2024-09-13 00:24:01', 76),
(191, 8, 8, 'Hadir', NULL, '2024-09-13 00:24:01', '2024-09-13 00:24:01', 76),
(192, 9, 8, 'Hadir', NULL, '2024-09-13 00:24:01', '2024-09-13 00:24:01', 76),
(193, 11, 8, 'Hadir', NULL, '2024-09-13 00:24:01', '2024-09-13 00:24:01', 76),
(194, 24, 8, 'Hadir', NULL, '2024-09-13 00:24:01', '2024-09-13 00:24:01', 76),
(196, 32, 8, 'Hadir', NULL, '2024-09-13 00:24:01', '2024-09-13 00:24:01', 76),
(197, 33, 8, 'Izin', NULL, '2024-09-13 00:24:01', '2024-09-13 00:24:07', 76),
(198, 34, 8, 'Hadir', NULL, '2024-09-13 00:24:01', '2024-09-13 00:24:01', 76),
(199, 37, 8, 'Hadir', NULL, '2024-09-13 00:24:01', '2024-09-13 00:24:01', 76),
(200, 7, 8, 'Hadir', NULL, '2024-09-13 00:24:14', '2024-09-13 00:24:14', 77),
(201, 8, 8, 'Hadir', NULL, '2024-09-13 00:24:14', '2024-09-13 00:24:14', 77),
(202, 9, 8, 'Hadir', NULL, '2024-09-13 00:24:14', '2024-09-13 00:24:14', 77),
(203, 11, 8, 'Hadir', NULL, '2024-09-13 00:24:14', '2024-09-13 00:24:14', 77),
(204, 24, 8, 'Hadir', NULL, '2024-09-13 00:24:14', '2024-09-13 00:24:14', 77),
(206, 32, 8, 'Hadir', NULL, '2024-09-13 00:24:14', '2024-09-13 00:24:14', 77),
(207, 33, 8, 'Hadir', NULL, '2024-09-13 00:24:14', '2024-09-13 00:24:14', 77),
(208, 34, 8, 'Hadir', NULL, '2024-09-13 00:24:14', '2024-09-13 00:24:14', 77),
(209, 37, 8, 'Hadir', NULL, '2024-09-13 00:24:14', '2024-09-13 00:24:14', 77),
(231, 7, 8, 'Hadir', NULL, '2024-09-16 00:42:32', '2024-09-16 00:42:32', 80),
(232, 8, 8, 'Hadir', NULL, '2024-09-16 00:42:32', '2024-09-16 00:42:32', 80),
(233, 9, 8, 'Hadir', NULL, '2024-09-16 00:42:32', '2024-09-16 00:42:32', 80),
(234, 11, 8, 'Hadir', NULL, '2024-09-16 00:42:32', '2024-09-16 00:42:32', 80),
(235, 24, 8, 'Hadir', NULL, '2024-09-16 00:42:32', '2024-09-16 00:42:32', 80),
(237, 32, 8, 'Hadir', NULL, '2024-09-16 00:42:32', '2024-09-16 00:42:32', 80),
(238, 33, 8, 'Hadir', NULL, '2024-09-16 00:42:32', '2024-09-16 00:42:32', 80),
(239, 34, 8, 'Hadir', NULL, '2024-09-16 00:42:32', '2024-09-16 00:42:32', 80),
(240, 37, 8, 'Hadir', NULL, '2024-09-16 00:42:32', '2024-09-16 00:42:32', 80),
(241, 7, 8, 'Hadir', NULL, '2024-09-16 00:42:38', '2024-09-16 00:42:38', 81),
(242, 8, 8, 'Hadir', NULL, '2024-09-16 00:42:38', '2024-09-16 00:42:38', 81),
(243, 9, 8, 'Hadir', NULL, '2024-09-16 00:42:38', '2024-09-16 00:42:38', 81),
(244, 11, 8, 'Hadir', NULL, '2024-09-16 00:42:38', '2024-09-16 00:42:38', 81),
(245, 24, 8, 'Hadir', NULL, '2024-09-16 00:42:38', '2024-09-16 00:42:38', 81),
(247, 32, 8, 'Hadir', NULL, '2024-09-16 00:42:38', '2024-09-16 00:42:38', 81),
(248, 33, 8, 'Hadir', NULL, '2024-09-16 00:42:38', '2024-09-16 00:53:17', 81),
(249, 34, 8, 'Hadir', NULL, '2024-09-16 00:42:38', '2024-09-16 00:42:38', 81),
(250, 37, 8, 'Hadir', NULL, '2024-09-16 00:42:38', '2024-09-16 00:42:38', 81),
(252, 19, 87, 'Hadir', NULL, '2024-09-20 06:18:25', '2024-09-20 06:18:25', 81),
(253, 26, 87, 'Hadir', NULL, '2024-09-20 06:18:25', '2024-09-20 06:18:25', 81),
(254, 7, 103, 'Hadir', NULL, '2024-10-01 07:04:35', '2024-10-01 07:04:35', 82),
(255, 8, 103, 'Hadir', NULL, '2024-10-01 07:04:35', '2024-10-01 07:04:35', 82),
(256, 9, 103, 'Hadir', NULL, '2024-10-01 07:04:35', '2024-10-01 07:04:35', 82),
(257, 11, 103, 'Hadir', NULL, '2024-10-01 07:04:35', '2024-10-01 07:04:35', 82),
(258, 24, 103, 'Mangkir', NULL, '2024-10-01 07:04:35', '2024-11-14 03:10:03', 82),
(260, 32, 103, 'Hadir', NULL, '2024-10-01 07:04:35', '2024-10-01 07:04:35', 82),
(261, 33, 103, 'Izin', 'Sakit', '2024-10-01 07:04:36', '2024-11-14 03:09:40', 82),
(262, 34, 103, 'Hadir', NULL, '2024-10-01 07:04:36', '2024-10-01 07:04:36', 82),
(263, 37, 103, 'Hadir', NULL, '2024-10-01 07:04:36', '2024-10-01 07:04:36', 82),
(264, 7, 103, 'Hadir', NULL, '2024-10-01 23:50:33', '2024-10-01 23:50:33', 83),
(265, 8, 103, 'Hadir', NULL, '2024-10-01 23:50:33', '2024-10-01 23:50:33', 83),
(266, 9, 103, 'Mangkir', 'asdasdasda', '2024-10-01 23:50:33', '2024-10-02 00:49:04', 83),
(267, 11, 103, 'Hadir', NULL, '2024-10-01 23:50:33', '2024-10-01 23:50:33', 83),
(268, 24, 103, 'Hadir', NULL, '2024-10-01 23:50:33', '2024-10-01 23:50:33', 83),
(270, 32, 103, 'Hadir', NULL, '2024-10-01 23:50:33', '2024-10-01 23:50:33', 83),
(271, 33, 103, 'Hadir', 'asdadasdadadasd', '2024-10-01 23:50:33', '2024-10-02 00:48:50', 83),
(272, 34, 103, 'Hadir', NULL, '2024-10-01 23:50:33', '2024-10-01 23:50:33', 83),
(273, 37, 103, 'Hadir', NULL, '2024-10-01 23:50:33', '2024-10-01 23:50:33', 83),
(274, 7, 103, 'Hadir', NULL, '2024-11-06 00:05:51', '2024-11-06 00:05:51', 84),
(275, 8, 103, 'Hadir', NULL, '2024-11-06 00:05:51', '2024-11-06 00:05:51', 84),
(276, 9, 103, 'Hadir', NULL, '2024-11-06 00:05:51', '2024-11-06 00:05:51', 84),
(277, 11, 103, 'Hadir', NULL, '2024-11-06 00:05:51', '2024-11-06 00:05:51', 84),
(278, 24, 103, 'Hadir', NULL, '2024-11-06 00:05:51', '2024-11-06 00:05:51', 84),
(280, 32, 103, 'Hadir', NULL, '2024-11-06 00:05:51', '2024-11-06 00:05:51', 84),
(281, 33, 103, 'Mangkir', NULL, '2024-11-06 00:05:51', '2024-11-06 00:07:27', 84),
(282, 34, 103, 'Hadir', NULL, '2024-11-06 00:05:51', '2024-11-06 00:05:51', 84),
(283, 37, 103, 'Hadir', NULL, '2024-11-06 00:05:51', '2024-11-06 00:05:51', 84),
(285, 27, 103, 'Hadir', NULL, '2024-11-14 03:08:56', '2024-11-14 03:08:56', 82),
(287, 27, 103, 'Hadir', NULL, '2024-11-14 03:09:11', '2024-11-14 03:09:11', 83),
(292, 7, 103, 'Hadir', NULL, '2024-11-15 04:22:55', '2024-11-15 04:22:55', 85),
(293, 8, 103, 'Hadir', NULL, '2024-11-15 04:22:55', '2024-11-15 04:22:55', 85),
(294, 9, 103, 'Hadir', NULL, '2024-11-15 04:22:55', '2024-11-15 04:22:55', 85),
(295, 11, 103, 'Hadir', NULL, '2024-11-15 04:22:55', '2024-11-15 04:22:55', 85),
(296, 24, 103, 'Hadir', NULL, '2024-11-15 04:22:55', '2024-11-15 04:22:55', 85),
(297, 27, 103, 'Hadir', NULL, '2024-11-15 04:22:55', '2024-11-15 04:22:55', 85),
(298, 32, 103, 'Hadir', NULL, '2024-11-15 04:22:55', '2024-11-15 04:22:55', 85),
(299, 33, 103, 'Hadir', NULL, '2024-11-15 04:22:55', '2024-11-15 04:22:55', 85),
(300, 34, 103, 'Hadir', NULL, '2024-11-15 04:22:55', '2024-11-15 04:22:55', 85),
(301, 37, 103, 'Hadir', NULL, '2024-11-15 04:22:55', '2024-11-15 04:22:55', 85),
(306, 7, 103, 'Hadir', NULL, '2024-12-09 21:34:25', '2024-12-09 21:34:25', 87),
(307, 8, 103, 'Hadir', NULL, '2024-12-09 21:34:25', '2024-12-09 21:34:25', 87),
(308, 9, 103, 'Hadir', NULL, '2024-12-09 21:34:25', '2024-12-09 21:34:25', 87),
(310, 11, 103, 'Hadir', NULL, '2024-12-09 21:34:25', '2024-12-09 21:34:25', 87),
(311, 24, 103, 'Hadir', NULL, '2024-12-09 21:34:25', '2024-12-09 21:34:25', 87),
(312, 27, 103, 'Hadir', NULL, '2024-12-09 21:34:25', '2024-12-09 21:34:25', 87),
(313, 32, 103, 'Hadir', NULL, '2024-12-09 21:34:25', '2024-12-09 21:34:25', 87),
(314, 33, 103, 'Izin', NULL, '2024-12-09 21:34:25', '2024-12-09 21:51:09', 87),
(315, 34, 103, 'Hadir', NULL, '2024-12-09 21:34:25', '2024-12-09 21:34:25', 87),
(316, 37, 103, 'Hadir', NULL, '2024-12-09 21:34:25', '2024-12-09 21:34:25', 87),
(394, 19, 104, 'Mangkir', NULL, '2024-12-19 01:15:12', '2024-12-19 01:15:37', 91),
(395, 26, 104, 'Hadir', NULL, '2024-12-19 01:15:12', '2024-12-19 01:15:12', 91),
(396, 7, 103, 'Hadir', NULL, '2024-12-19 01:15:22', '2024-12-19 01:15:22', 91),
(397, 8, 103, 'Hadir', NULL, '2024-12-19 01:15:22', '2024-12-19 01:15:22', 91),
(398, 9, 103, 'Hadir', NULL, '2024-12-19 01:15:22', '2024-12-19 01:15:22', 91),
(399, 11, 103, 'Hadir', NULL, '2024-12-19 01:15:22', '2024-12-19 01:15:22', 91),
(400, 24, 103, 'Hadir', NULL, '2024-12-19 01:15:22', '2024-12-19 01:15:22', 91),
(401, 27, 103, 'Hadir', NULL, '2024-12-19 01:15:22', '2024-12-19 01:15:22', 91),
(402, 32, 103, 'Hadir', NULL, '2024-12-19 01:15:22', '2024-12-19 01:15:22', 91),
(403, 33, 103, 'Izin', NULL, '2024-12-19 01:15:22', '2024-12-19 01:15:59', 91),
(404, 34, 103, 'Hadir', NULL, '2024-12-19 01:15:22', '2024-12-19 01:15:22', 91),
(405, 37, 103, 'Hadir', NULL, '2024-12-19 01:15:22', '2024-12-19 01:15:22', 91);

-- --------------------------------------------------------

--
-- Table structure for table `kelas`
--

CREATE TABLE `kelas` (
  `id_kelas` bigint(20) UNSIGNED NOT NULL,
  `nama_kelas` varchar(255) NOT NULL,
  `id_guru` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `id_ta` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kelas`
--

INSERT INTO `kelas` (`id_kelas`, `nama_kelas`, `id_guru`, `created_at`, `updated_at`, `id_ta`) VALUES
(8, 'XII MIA 1', 23, '2024-03-11 23:58:12', '2024-04-23 03:05:13', 4),
(9, 'XII MIA 2', 13, '2024-03-12 03:45:23', '2024-03-12 03:45:39', 4),
(10, 'XII MIA 3', 17, '2024-03-12 03:47:34', '2024-03-12 03:54:02', 4),
(11, 'XII MIA 4', 18, '2024-03-12 03:47:41', '2024-03-12 03:47:41', 4),
(12, 'XII MIA 5', 16, '2024-03-12 03:55:53', '2024-03-12 03:55:53', 4),
(15, 'XII IIS 1', 24, '2024-04-02 02:32:50', '2024-04-02 02:32:50', 4),
(16, 'XII IIS 2', 21, '2024-04-02 02:33:05', '2024-04-02 02:33:12', 4),
(17, 'XII IIS 3', 14, '2024-04-02 05:13:58', '2024-04-02 05:13:58', 4),
(19, 'XII IIS 4', 22, '2024-06-16 03:46:37', '2024-06-16 03:46:37', 4),
(24, 'XII IIS 5', 20, '2024-06-16 22:16:39', '2024-06-16 22:16:39', 4),
(86, 'IPA 1', 14, '2024-09-16 23:50:14', '2024-09-16 23:50:14', 9),
(87, 'IPA 2', 20, '2024-09-16 23:50:25', '2024-09-16 23:50:25', 9),
(88, 'IPA 3', 18, '2024-09-17 02:48:58', '2024-09-17 02:48:58', 9),
(89, 'IPA 4', 15, '2024-09-17 02:49:14', '2024-09-17 02:49:14', 9),
(90, 'IPA 5', 23, '2024-09-17 02:49:28', '2024-09-17 02:49:28', 9),
(91, 'IPA 6', 13, '2024-09-17 02:49:44', '2024-09-17 02:49:44', 9),
(92, 'IPA 7', 17, '2024-09-17 02:50:02', '2024-09-17 02:50:02', 9),
(93, 'IPA 8', 21, '2024-09-17 02:50:22', '2024-09-17 02:50:22', 9),
(94, 'IPA 9', 16, '2024-09-17 02:50:39', '2024-09-17 02:50:39', 9),
(95, 'IPA 10', 12, '2024-09-17 02:50:56', '2024-12-08 16:20:43', 9),
(103, 'MIA 1', 13, '2024-09-22 06:29:39', '2024-09-22 06:29:39', 10),
(104, 'MIA 2', 20, '2024-09-22 06:29:51', '2024-09-22 06:29:51', 10),
(105, 'MIA 3', 17, '2024-09-22 06:30:37', '2024-09-22 06:30:37', 10),
(106, 'MIA 4', 21, '2024-09-22 06:30:45', '2024-09-22 06:30:45', 10),
(107, 'MIA 5', 23, '2024-09-22 06:30:53', '2024-09-22 06:30:53', 10),
(108, 'MIA 6', 15, '2024-09-22 06:31:01', '2024-09-22 06:31:01', 10),
(109, 'MIA 7', 24, '2024-09-22 06:31:18', '2024-09-22 06:31:18', 10),
(110, 'MIA 8', 22, '2024-09-22 06:31:28', '2024-09-22 06:31:28', 10),
(111, 'MIA 9', 12, '2024-09-22 06:31:39', '2024-09-22 06:31:39', 10),
(112, 'MIA 10', 19, '2024-09-22 06:31:51', '2024-09-22 06:31:51', 10),
(119, 'TKJ 1', 12, '2024-12-19 01:29:51', '2024-12-19 01:29:51', 14),
(120, 'TKJ 2', 14, '2024-12-19 01:29:58', '2024-12-19 01:29:58', 14),
(121, 'TKJ 3', 21, '2024-12-19 01:30:08', '2024-12-19 01:30:08', 14),
(122, 'TKJ 4', 22, '2024-12-19 01:30:17', '2024-12-19 01:30:17', 14),
(123, 'TKJ 5', 24, '2024-12-19 01:30:26', '2024-12-19 01:30:26', 14),
(124, 'TKJ 6', 15, '2024-12-19 01:30:35', '2024-12-19 01:30:35', 14),
(125, 'TKJ 7', 13, '2024-12-19 01:30:48', '2024-12-19 01:30:48', 14),
(126, 'TKJ 8', 23, '2024-12-19 01:31:00', '2024-12-19 01:31:00', 14),
(127, 'TKJ 9', 19, '2024-12-19 01:31:13', '2024-12-19 01:31:13', 14),
(128, 'TKJ 10', 18, '2024-12-19 01:31:24', '2024-12-19 01:31:24', 14);

-- --------------------------------------------------------

--
-- Table structure for table `mapels`
--

CREATE TABLE `mapels` (
  `id_mapel` bigint(20) UNSIGNED NOT NULL,
  `kode_mapel` varchar(255) NOT NULL,
  `nama_mapel` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `id_guru` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mapels`
--

INSERT INTO `mapels` (`id_mapel`, `kode_mapel`, `nama_mapel`, `created_at`, `updated_at`, `id_guru`) VALUES
(23, '2708', 'Sistem Cerdas', '2024-03-12 03:15:58', '2024-03-12 03:15:58', 12),
(24, '2501', 'Kecerdasan Bisnis', '2024-03-12 03:16:16', '2024-03-12 03:16:16', 17),
(25, '2503', 'Statistik Terapan', '2024-03-12 03:16:30', '2024-03-12 03:16:30', 21),
(26, '0402', 'Pancasila', '2024-03-12 03:16:46', '2024-03-12 03:16:46', 22),
(27, '2504', 'Manajemen Investasi TI', '2024-03-12 03:17:03', '2024-03-12 03:17:03', 19),
(28, '2707', 'Manajemen Rantai Pasok', '2024-03-12 03:17:17', '2024-03-12 03:24:38', 16),
(29, '2702', 'Keamanan Komputer', '2024-03-12 03:17:45', '2024-03-12 03:17:45', 20),
(30, '0401', 'Kewirausahaan', '2024-03-12 03:18:07', '2024-03-12 03:18:07', 13),
(31, '2802', 'Teknologi Terbaru', '2024-03-12 03:18:30', '2024-03-12 03:18:30', 13),
(32, '2606', 'Kerja Praktik', '2024-03-12 03:18:47', '2024-03-12 03:18:47', 17),
(35, '0409', 'Kewarganegaraan', '2024-03-12 03:21:15', '2024-03-12 03:21:15', 14),
(36, '2803', 'Manajemen Keberlangsungan Bisnis', '2024-03-12 03:21:49', '2024-03-12 03:25:03', 16),
(37, '02607', 'Metode Riset Sistem Informasi', '2024-03-12 03:22:08', '2024-03-12 03:22:08', 17),
(38, '02602', 'Manajemen dan Penilaian TI', '2024-03-12 03:22:29', '2024-03-12 03:24:53', 18),
(39, '2605', 'Bisnis Digital', '2024-03-12 03:22:49', '2024-03-12 03:22:49', 19),
(40, '0260', 'KKN', '2024-03-12 03:23:17', '2024-03-12 03:23:17', 17),
(42, '0280', 'Bahasa Indonesia', '2024-03-12 03:24:08', '2024-04-10 04:48:06', 24),
(48, '2799', 'IPA', '2024-03-12 03:39:55', '2024-03-12 03:39:55', 12),
(49, '3122', 'Database', '2024-03-12 03:48:45', '2024-03-12 03:48:45', 23),
(50, '3212', 'Manajemen', '2024-03-12 03:56:08', '2024-03-12 03:56:08', 21),
(51, '666777', 'PAI', '2024-03-12 23:52:12', '2024-06-20 21:46:58', 24),
(52, '2211', 'Bahasa Indonesia', '2024-06-14 00:25:52', '2024-10-14 00:47:07', 15),
(53, '9989', 'Cyber Security', '2024-09-17 21:09:48', '2024-09-17 21:09:48', 20),
(55, '2223332', 'Tes Mapel BaruSSSSSS', '2024-10-31 03:00:13', '2024-10-31 03:00:13', 13);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2014_10_12_100000_create_password_resets_table', 1),
(4, '2019_08_19_000000_create_failed_jobs_table', 1),
(5, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(6, '2024_03_01_0000001_roles', 1),
(7, '2024_03_01_0000002_mapels', 1),
(8, '2024_03_01_0000003_gurus', 1),
(9, '2024_03_01_0000004_kelas', 1),
(10, '2024_03_01_0000005_murids', 1),
(11, '2024_03_01_0000006_nilais', 1),
(12, '2024_03_01_0000007_kehadirans', 1),
(13, '2024_03_01_0000009_ortus', 1),
(14, '2024_03_01_0000010_p_kelas_murids', 1),
(15, '2024_03_01_090912_users', 1),
(16, '2024_03_10_0000011_guru_mapel', 1),
(17, '2024_04_11_0000012_add_foreign_key_to_mapels_table', 1),
(18, '2024_05_13_065741_add_nohp_into_ortus', 2),
(19, '2024_03_13_082037_drop_kolom_idkelas_di_ortus', 3),
(22, '2024_06_13_090416_add_idortu_to_murid', 4),
(23, '2024_07_13_082244_drop_kolom_idkelas_di_ortus', 5),
(24, '2024_08_21_082910_add__id_nilai_on__murids', 6),
(25, '2024_03_22_073733_jam_pelajarans', 7),
(26, '2024_03_23_073726_jadwal_pelajarans', 7),
(27, '2024_03_24_074730_add__id__jadwal_into__jam', 8),
(28, '2024_03_22_121714_add_hari_to_jam', 9),
(29, '2024_09_23_105430_refresh', 10),
(30, '2024_04_02_075152_rincians', 11),
(31, '2024_10_08_091452_add_idmapel_into_jadwal', 12),
(32, '2024_11_08_153733_pivot__guru_mapel', 13),
(33, '2024_12_09_145848_remove_idguru_hari_from_jadwal', 14),
(34, '2025_01_09_153355_hadeh', 15),
(38, '2025_02_16_092850_add_id_jadwal_into_mapel', 16),
(40, '2025_03_25_080639_add__hari_into__kehadirans', 17),
(41, '2025_04_27_163155_add_idkehadiran_into_murids', 18),
(42, '2025_04_28_141013_create_sesi_table', 19),
(43, '2025_04_28_141737_add_id_sesi_into__kehadirans', 20),
(44, '2025_05_28_144416_add__hari__into__s_e_s_i', 21),
(45, '2025_04_28_144416_add__hari__into__s_e_s_i', 22),
(46, '2025_04_29_080858_drop__coloumn__hari_from_kehadiran', 22),
(47, '2025_04_29_105239_add_id_sesi_into_kelas', 23),
(49, '2025_04_29_110253_drop_id_sesi_from_kelas', 24),
(50, '2025_04_29_152032_add__idkelas_into__sesi', 24),
(51, '2025_05_09_063918_pelanggaran', 25),
(53, '2025_05_09_064319_dropPelanggaran', 26),
(54, '2025_05_10_095139_drop__table__rincians', 26),
(55, '2025_05_10_100017_pelanggaran__siswa', 27),
(56, '2025_05_10_100851_prestasi', 28),
(57, '2025_05_10_102210_prestasi__siswa', 29),
(58, '2025_05_28_074257_tahun_ajaran', 30),
(59, '2025_05_28_075018_add_id_ta', 31),
(60, '2025_05_28_075059_add_id_ta_into_sesi', 32),
(61, '2025_05_28_075141_add_id_ta_into_jadwal', 32),
(62, '2025_05_28_075148_add_id_ta_into_nilai', 33),
(63, '2025_05_28_075646_add_id_ta_into_jadwal', 34),
(64, '2025_05_28_080008_add_ta_tomurids', 35),
(65, '2025_06_13_071352_drop_tahunajaran_from_murids', 36),
(66, '2025_06_15_082014_add_lokasi_and_tanggal_into_prestasi_siswa', 37),
(67, '2025_06_15_091915_add_lokasi_and_tanggal_into_pelanggaran_siswa', 38),
(68, '2025_06_16_035559_add_id_ta_into__kelas', 39),
(69, '2024_06_19_142842_tes_users', 40),
(70, '2024_06_19_143700_delete_table_tesusers', 41),
(71, '2025_06_30_102956_add_password_to_gurus_table', 42),
(72, '2025_07_01_080012_add_password_to_murids_table', 43),
(73, '2025_07_01_093123_drop_ids_to_murids_table', 44),
(74, '2024_07_04_073648_add_noho_into_user_tables', 45),
(75, '2025_07_04_075836_add_id_role_into_users', 46),
(76, '2025_07_06_074114_drop_id_kehadiran_from_sesi', 47),
(77, '2025_09_17_032244_tabel_arsip', 48),
(78, '2025_09_18_080913_drop_foreign_arsip', 49),
(79, '2025_09_18_081138_add_foreign_into_arsip', 50),
(80, '2025_09_24_091825_add_username_password_into_ortus', 51),
(81, '2025_10_13_130713_drop_table_kelasmuirds', 52),
(82, '2025_10_13_131022_drop_guru_mapel', 53),
(84, '2025_12_15_075103_create_activity_logs_table', 54),
(85, '2025_12_15_083814_add_timestamp', 55);

-- --------------------------------------------------------

--
-- Table structure for table `murids`
--

CREATE TABLE `murids` (
  `id_murid` bigint(20) UNSIGNED NOT NULL,
  `nisn` varchar(255) NOT NULL,
  `nama_murid` varchar(255) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `jenis_kelamin` varchar(255) NOT NULL,
  `id_kelas` bigint(20) UNSIGNED NOT NULL,
  `role` bigint(20) UNSIGNED NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `id_ta` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `murids`
--

INSERT INTO `murids` (`id_murid`, `nisn`, `nama_murid`, `tanggal_lahir`, `jenis_kelamin`, `id_kelas`, `role`, `password`, `created_at`, `updated_at`, `id_ta`) VALUES
(7, '210402012', 'Rina Kartika', '2008-03-20', 'Perempuan', 119, 7, '$2y$12$OXUMCrOopLxVcWCLa/PwUOF1CpgXABNTbABUxZY7OYFQD2oXg6HPO', '2024-03-12 03:46:43', '2024-12-19 01:32:19', 14),
(8, '210402074', 'Siti Nurhaliza', '2008-07-17', 'Laki-Laki', 119, 7, '$2y$12$rizQIrA0.vYgsZs9XDfUGerVL1c2MRSVronx7IzLPKIydI51HnnYK', '2024-03-12 03:47:25', '2024-12-19 01:32:19', 14),
(9, '210402013', 'Fitri Susanti', '2008-12-30', 'Perempuan', 119, 7, '$2y$12$hIds1Xr.cUZ4ypCB/PBZqev0UQyIrmQCTnBM53.zun7.0rM1/rqx2', '2024-03-12 03:50:17', '2024-12-19 01:32:19', 14),
(11, '12313', 'Fathur Rahman', '2007-02-17', 'Laki-Laki', 119, 7, '$2y$12$GxUfeu0T.0GkXJDx2ly6Se6fHZ.FLFNQ0Y6Fz7WJkuEgESjLcrnFm', '2024-03-12 03:52:30', '2024-12-19 01:32:19', 14),
(12, '9231', 'Angelyn', '2003-02-08', 'Perempuan', 122, 7, '$2y$12$UeBuhId0y8nKvo..2d6b6.M2mdbJWaZwcioEQWYUGNGNj5op1ag.6', '2024-03-12 03:53:10', '2024-12-19 01:32:19', 14),
(19, '123213', 'Kuuhaku', '2024-03-16', 'Laki-Laki', 120, 7, '$2y$12$fwScoCTVlnoFb/3dug6/fe6KxxtOsMdH9COFHdM6N16SLLbhh.bTG', '2024-03-15 05:11:09', '2024-12-19 01:32:19', 14),
(21, '1231231', 'Imelda Sandra', '2024-03-22', 'Laki-Laki', 121, 7, '$2y$12$PRfymxn3J3tpP.jsMIiSI.ThpKsX3jbnnoBrHDyBKbfY/O/y0hdZC', '2024-03-19 05:40:25', '2024-12-19 01:32:19', 14),
(22, '213221', 'Agung Setiawan', '2000-12-21', 'Laki-Laki', 122, 7, '$2y$12$YCH5/n18xH.GbwfEIAflruiFBxTX7pw5UeYfXlxFay6PhpuX55Sum', '2024-03-20 03:21:49', '2024-12-19 01:32:19', 14),
(23, '1231231232131', 'Asep Setaiwan', '2001-02-23', 'Laki-Laki', 125, 7, '$2y$12$ejiMEVa.Z1viM4hzZLTLIeVx7r6WhX7qXPFaBVf5CQtfCKnRkdC8a', '2024-04-02 02:47:26', '2024-12-19 01:32:19', 14),
(24, '210402011', 'Budi Santoso', '2007-02-01', 'Laki-Laki', 119, 7, '$2y$12$L.17T6Ll2CaOVMBZ8a50FO30rH0Ty8vDamuDFhGIEj8v7ModQSsC6', '2024-04-03 01:27:01', '2024-12-19 01:32:19', 14),
(26, '123455', 'Pekora', '2003-02-20', 'Perempuan', 120, 7, '$2y$12$CuW7idm0gW2DTEyCLkmHzOLDwzthO/0WF/Iz.zstCNJRXgHjqRTR6', '2024-05-07 07:10:30', '2024-12-19 01:32:19', 14),
(27, '991192', 'Candikiawan Kurina', '2001-02-03', 'Laki-Laki', 119, 7, '$2y$12$pX7WdlamjscT/J0kYkA8U.hOUJYyLbqXwZdILqIFFdQz8eXOgqMZW', '2024-05-13 05:36:37', '2024-12-19 01:32:19', 14),
(32, '123322', 'Rizky Maulana', '2008-06-21', 'Perempuan', 119, 7, '$2y$12$X8cXtKhDA2H3vOgfvwCqHegCPTTU1D/LvoWCCbgElBOdvgiEmRIDK', '2024-06-21 00:30:05', '2024-12-19 01:32:19', 14),
(33, '33333', 'Ahmad Pratama', '2008-06-11', 'Laki-Laki', 119, 7, '$2y$12$h7enJUbrd011Kcfi8nvTuuFr8NYo6csZY2iRsKOa7p3IdeldjMVuW', '2024-06-22 01:49:17', '2024-12-19 01:32:19', 14),
(34, '99999', 'Ria Anggeri', '2003-03-20', 'Laki-Laki', 119, 7, '$2y$12$oJSy4bQ48RjUmqRlIF6ZFeGaDmREdnM.CTMcLyy/nQrf96Dl140dG', '2024-07-01 01:29:03', '2024-12-19 01:32:19', 14),
(37, '210402075', 'Dimas Saputra', '2009-07-03', 'Laki-Laki', 119, 7, '$2y$12$4z2SbssqflSQ7R037vJOweJKhi4kq5wIQWwuWS9lh.HWxc5/vcK5S', '2024-08-21 01:32:00', '2024-12-19 01:32:19', 14);

-- --------------------------------------------------------

--
-- Table structure for table `nilais`
--

CREATE TABLE `nilais` (
  `id_nilai` bigint(20) UNSIGNED NOT NULL,
  `id_murid` bigint(20) UNSIGNED NOT NULL,
  `id_mapel` bigint(20) UNSIGNED NOT NULL,
  `nilai` decimal(5,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `id_ta` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `nilais`
--

INSERT INTO `nilais` (`id_nilai`, `id_murid`, `id_mapel`, `nilai`, `created_at`, `updated_at`, `id_ta`) VALUES
(75, 33, 28, 99.00, '2024-09-19 20:48:48', '2024-09-19 20:48:48', 4),
(76, 33, 25, 86.00, '2024-09-19 20:49:51', '2024-09-19 20:49:51', 4),
(77, 33, 53, 98.00, '2024-09-22 00:31:47', '2024-09-22 00:31:47', 9),
(78, 33, 31, 99.00, '2024-09-22 00:31:53', '2024-09-22 00:31:53', 9),
(79, 33, 51, 88.00, '2024-09-22 00:32:03', '2024-09-22 00:32:03', 9),
(84, 33, 49, 86.00, '2024-09-22 03:12:39', '2024-09-22 03:12:39', 4),
(85, 33, 29, 70.00, '2024-09-22 03:12:50', '2024-09-22 03:12:50', 4),
(86, 33, 26, 90.00, '2024-09-22 03:13:26', '2024-09-22 03:13:26', 9),
(87, 33, 52, 88.00, '2024-09-22 23:33:28', '2024-09-22 23:33:28', 9),
(88, 33, 49, 89.00, '2024-09-22 23:33:37', '2024-09-22 23:33:37', 9),
(89, 33, 28, 92.00, '2024-09-22 23:33:45', '2024-09-22 23:33:45', 9),
(91, 33, 23, 77.00, '2024-09-22 23:36:17', '2024-09-22 23:36:17', 10),
(92, 33, 25, 89.00, '2024-09-22 23:36:23', '2024-09-22 23:36:23', 10),
(93, 33, 31, 99.00, '2024-09-22 23:36:29', '2024-10-15 01:35:30', 10),
(95, 7, 49, 99.00, '2024-09-29 21:31:43', '2024-09-29 21:31:43', 4),
(96, 7, 29, 99.00, '2024-09-29 21:31:59', '2024-09-29 21:31:59', 4),
(97, 7, 25, 87.00, '2024-09-30 00:43:57', '2024-09-30 02:33:49', 10),
(100, 7, 52, 30.00, '2024-09-30 02:17:37', '2024-09-30 02:17:37', 10),
(101, 7, 25, 88.00, '2024-09-30 02:34:45', '2024-09-30 02:34:53', 10),
(102, 7, 25, 80.00, '2024-09-30 02:42:36', '2024-09-30 02:42:44', 10),
(103, 7, 25, 88.00, '2024-09-30 02:43:35', '2024-09-30 02:43:43', 10),
(104, 7, 25, 66.00, '2024-09-30 02:51:32', '2024-09-30 02:53:16', 10),
(105, 7, 28, 1.00, '2024-09-30 02:51:43', '2024-09-30 02:52:31', 10),
(106, 7, 25, 99.00, '2024-09-30 02:53:39', '2024-09-30 02:53:45', 10),
(107, 7, 25, 66.00, '2024-09-30 02:54:54', '2024-09-30 02:54:59', 10),
(108, 7, 25, 99.00, '2024-09-30 02:55:19', '2024-09-30 02:55:26', 10),
(109, 7, 25, 89.00, '2024-09-30 03:04:34', '2024-09-30 03:04:44', 10),
(110, 7, 25, 89.00, '2024-09-30 03:06:35', '2024-09-30 03:07:55', 4),
(112, 8, 31, 77.00, '2024-10-22 05:45:32', '2024-10-22 05:45:32', 10),
(113, 7, 31, 88.00, '2024-10-23 21:20:31', '2024-10-23 21:20:31', 10),
(121, 33, 30, 100.00, '2024-12-09 21:52:14', '2024-12-17 07:47:55', 10),
(136, 24, 30, 99.00, '2024-12-17 07:21:19', '2024-12-17 07:21:19', 10),
(138, 27, 30, 70.00, '2024-12-17 07:29:16', '2024-12-17 07:40:35', 10),
(141, 33, 23, 77.00, '2024-12-17 07:47:30', '2024-12-17 07:47:30', 4),
(142, 37, 30, 77.00, '2024-12-17 07:48:13', '2024-12-17 07:48:13', 10);

-- --------------------------------------------------------

--
-- Table structure for table `ortus`
--

CREATE TABLE `ortus` (
  `id_ortu` bigint(20) UNSIGNED NOT NULL,
  `nama_ortu` varchar(255) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `jenis_kelamin` varchar(255) NOT NULL,
  `id_murid` bigint(20) UNSIGNED NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `role` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `no_hp` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ortus`
--

INSERT INTO `ortus` (`id_ortu`, `nama_ortu`, `tanggal_lahir`, `jenis_kelamin`, `id_murid`, `alamat`, `email`, `role`, `created_at`, `updated_at`, `no_hp`, `password`, `username`) VALUES
(32, 'Ini nama Wali Murid', '2024-03-23', 'Laki-Laki', 34, 'Jl. Soekarno', 'riangger@gmail.com', 6, '2024-03-15 05:12:08', '2024-12-15 23:29:21', '1231230000', '$2y$12$9H3/Ox2IdnUtdr7s5/DCy.pbn5YTmx1UykPSpTpKASALsocfUKiJW', '99999'),
(37, 'Siregar', '1992-09-19', 'Laki-Laki', 37, 'Jl Sumatra', 'siregar@gmail.com', 6, '2024-04-02 03:19:16', '2024-11-14 06:39:56', '12312', '$2y$12$ef2ylIyja5cA1La6zDibGOvxswdDLUbdvDtpMrOVxPbPuRhfln/Ke', '210402075'),
(38, 'Agung set', '1981-02-02', 'Laki-Laki', 9, 'Jl Paus', 'Agung@gmail.com', 6, '2024-04-03 01:28:27', '2024-09-24 02:54:24', '82285', '$2y$12$EjdbCBH7/SXmReiri0iis.OmkowPsOQC3rTK57TjkJnw0wsbGa.aa', '210402013'),
(43, 'Budiono Siregar', '2024-09-20', 'Laki-Laki', 33, 'JL. TERATAI GG BUNGA TANJUNG NO.1A', '210402013@student.umri.ac.id', 6, '2024-09-07 02:08:59', '2024-12-12 05:32:06', '85265200000', '$2y$12$TYGPXJ0Lt3RXC20VusQCtepfdbeHt1R9Mbf360XCVfFKaQwY28ODm', '33333');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pelanggaran`
--

CREATE TABLE `pelanggaran` (
  `id_pelanggaran` bigint(20) UNSIGNED NOT NULL,
  `nama_pelanggaran` varchar(255) NOT NULL,
  `poin` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pelanggaran`
--

INSERT INTO `pelanggaran` (`id_pelanggaran`, `nama_pelanggaran`, `poin`, `created_at`, `updated_at`) VALUES
(2, 'Merokok', 800, '2024-05-09 01:11:01', '2024-11-14 03:37:50'),
(9, 'Mencuri', 500, '2024-05-11 03:56:42', '2024-11-14 03:37:36'),
(10, 'Kriminal', 1000, '2024-05-11 05:22:04', '2024-11-28 03:39:19'),
(11, 'Kekerasan', 500, '2024-05-11 05:25:35', '2024-05-12 23:36:02'),
(13, 'Bully', 1000, '2024-05-16 07:08:09', '2024-05-16 07:08:09'),
(15, 'Pencabulan', 1000, '2024-09-12 03:28:41', '2024-11-14 03:37:11'),
(16, 'Telat', 100, '2024-11-14 03:39:15', '2024-11-14 03:39:15'),
(24, 'Tawuran', 1000, '2024-12-08 17:27:10', '2024-12-08 17:27:10'),
(25, 'Membawa Sajam', 900, '2024-12-17 00:12:03', '2024-12-17 00:12:24');

-- --------------------------------------------------------

--
-- Table structure for table `pelanggaran_siswa`
--

CREATE TABLE `pelanggaran_siswa` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_murid` bigint(20) UNSIGNED NOT NULL,
  `id_pelanggaran` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `lokasi_pelanggaran` varchar(255) DEFAULT NULL,
  `tanggal_pelanggaran` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pelanggaran_siswa`
--

INSERT INTO `pelanggaran_siswa` (`id`, `id_murid`, `id_pelanggaran`, `created_at`, `updated_at`, `lokasi_pelanggaran`, `tanggal_pelanggaran`) VALUES
(61, 33, 11, '2024-09-12 02:48:41', '2024-10-13 23:28:10', 'Sekolah sebelah', '2024-09-13'),
(62, 33, 2, '2024-09-12 03:28:00', '2024-11-14 03:38:51', 'Sekolah saat ujian', '2024-09-13'),
(63, 33, 15, '2024-09-12 03:29:03', '2024-09-12 03:29:03', 'Kamar Mandi', '2024-09-13'),
(64, 37, 13, '2024-10-08 23:19:49', '2024-10-08 23:19:49', 'Sekolah', '2024-10-09'),
(67, 22, 24, '2024-12-08 17:33:15', '2024-12-08 17:33:15', 'Sekolah sebelah', '2024-12-09'),
(68, 22, 13, '2024-12-09 21:36:13', '2024-12-09 21:36:13', 'Sekolah', '2024-12-10'),
(69, 37, 2, '2024-12-13 00:29:58', '2024-12-13 00:29:58', 'Sekolah sebelah', '2024-12-27');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `prestasi`
--

CREATE TABLE `prestasi` (
  `id_prestasi` bigint(20) UNSIGNED NOT NULL,
  `nama_prestasi` varchar(255) NOT NULL,
  `poin` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `prestasi`
--

INSERT INTO `prestasi` (`id_prestasi`, `nama_prestasi`, `poin`, `created_at`, `updated_at`) VALUES
(1, 'Juara 1 Kelas', 800, '2024-05-29 07:37:42', '2024-11-14 04:00:58'),
(2, 'Juara 2 Kelas', 600, '2024-05-29 07:37:53', '2024-11-14 04:01:07'),
(5, 'Juara 3 Kelas', 400, '2024-05-29 21:01:01', '2024-11-14 04:01:12'),
(6, 'Juara Umum', 1000, '2024-11-28 03:40:33', '2024-11-28 03:40:33'),
(8, 'Cerdas Cermat', 100, '2024-12-17 02:59:58', '2024-12-17 02:59:58');

-- --------------------------------------------------------

--
-- Table structure for table `prestasi_siswa`
--

CREATE TABLE `prestasi_siswa` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_murid` bigint(20) UNSIGNED NOT NULL,
  `id_prestasi` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `lokasi_prestasi` varchar(255) DEFAULT NULL,
  `tanggal_prestasi` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `prestasi_siswa`
--

INSERT INTO `prestasi_siswa` (`id`, `id_murid`, `id_prestasi`, `created_at`, `updated_at`, `lokasi_prestasi`, `tanggal_prestasi`) VALUES
(14, 12, 1, '2024-06-15 01:28:25', '2024-06-15 01:40:25', 'Sekolah', '2024-06-15'),
(15, 9, 1, '2024-06-15 07:22:42', '2024-10-13 23:32:34', 'sssssssssss', '2024-06-30'),
(17, 9, 1, '2024-06-15 07:23:18', '2024-06-15 07:23:18', NULL, '2024-06-30'),
(18, 33, 2, '2024-09-23 02:02:26', '2024-09-23 02:02:26', NULL, '2024-09-23'),
(19, 33, 1, '2024-09-23 02:02:51', '2024-11-14 06:22:05', 'SMK MULTI MEKANIK MASMUR', '2024-09-28');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id_roles` bigint(20) UNSIGNED NOT NULL,
  `nama_roles` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id_roles`, `nama_roles`, `created_at`, `updated_at`) VALUES
(4, 'Admin', '2024-03-11 03:31:48', '2024-05-23 00:38:57'),
(5, 'Guru', '2024-03-11 03:31:53', '2024-03-11 03:31:53'),
(6, 'Wali Murid', '2024-03-11 03:31:58', '2024-03-11 03:31:58'),
(7, 'Murid', '2024-03-11 03:32:02', '2024-03-11 03:32:02');

-- --------------------------------------------------------

--
-- Table structure for table `sesi`
--

CREATE TABLE `sesi` (
  `id_sesi` bigint(20) UNSIGNED NOT NULL,
  `tanggal` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `hari` varchar(255) DEFAULT NULL,
  `id_ta` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sesi`
--

INSERT INTO `sesi` (`id_sesi`, `tanggal`, `created_at`, `updated_at`, `hari`, `id_ta`) VALUES
(68, '2024-09-09', '2024-09-08 00:02:22', '2024-09-11 23:45:03', 'Senin', 4),
(69, '2024-09-08', '2024-09-08 00:02:33', '2024-09-11 23:45:08', 'Minggu', 4),
(70, '2024-09-10', '2024-09-08 05:26:30', '2024-09-11 23:44:55', 'Selasa', 4),
(71, '2024-09-11', '2024-09-09 23:54:53', '2024-09-11 23:44:06', 'Rabu', 4),
(72, '2024-09-12', '2024-09-10 01:15:03', '2024-09-11 23:43:49', 'Kamis', 4),
(73, '2024-09-13', '2024-09-13 00:21:59', '2024-09-13 00:21:59', 'Jumat', 3),
(74, '2024-09-14', '2024-09-13 00:22:06', '2024-09-13 00:22:06', 'Sabtu', 3),
(75, '2024-09-15', '2024-09-13 00:22:13', '2024-09-13 00:22:13', 'Minggu', 3),
(76, '2024-09-16', '2024-09-13 00:22:21', '2024-09-13 00:22:21', 'Senin', 3),
(77, '2024-09-17', '2024-09-13 00:22:30', '2024-09-13 00:22:30', 'Selasa', 3),
(80, '2024-09-29', '2024-09-16 00:42:15', '2024-09-16 00:42:15', 'Minggu', 9),
(81, '2024-09-30', '2024-09-16 00:42:21', '2024-09-16 00:42:21', 'Senin', 9),
(82, '2024-10-01', '2024-10-01 00:57:55', '2024-10-01 00:57:55', 'Selasa', 10),
(83, '2024-10-02', '2024-10-01 23:47:55', '2024-10-01 23:47:55', 'Rabu', 10),
(84, '2024-11-06', '2024-11-06 00:03:21', '2024-11-06 00:03:21', 'Rabu', 10),
(85, '2024-11-15', '2024-11-14 23:40:29', '2024-11-14 23:40:29', 'Jumat', 10),
(87, '2024-12-10', '2024-12-09 21:33:43', '2024-12-09 21:33:43', 'Selasa', 10),
(88, '2024-12-13', '2024-12-12 18:56:58', '2024-12-12 18:56:58', 'Jumat', 10),
(91, '2024-12-19', '2024-12-19 00:04:20', '2024-12-19 00:04:20', 'Kamis', 10);

-- --------------------------------------------------------

--
-- Table structure for table `tahun_ajaran`
--

CREATE TABLE `tahun_ajaran` (
  `id_ta` bigint(20) UNSIGNED NOT NULL,
  `tahun_mulai` int(11) NOT NULL,
  `tahun_selesai` int(11) NOT NULL,
  `kode_ta` varchar(200) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tahun_ajaran`
--

INSERT INTO `tahun_ajaran` (`id_ta`, `tahun_mulai`, `tahun_selesai`, `kode_ta`, `created_at`, `updated_at`) VALUES
(3, 2025, 2026, '2025/1', '2024-05-29 00:06:45', '2024-06-09 23:54:48'),
(4, 2025, 2026, '2025/2', '2024-05-29 00:06:59', '2024-06-09 23:55:07'),
(9, 2026, 2027, '2026/1', '2024-09-14 02:57:30', '2024-09-14 02:57:30'),
(10, 2026, 2027, '2026/2', '2024-09-22 06:14:53', '2024-09-22 06:14:53'),
(14, 2027, 2028, '2027/1', '2024-12-19 01:17:57', '2024-12-19 01:17:57');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `no_hp` varchar(20) DEFAULT NULL,
  `id_role` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `no_hp`, `id_role`) VALUES
(1, 'Rio Liando Anggeri', 'rioliandoa@gmail.com', NULL, '$2y$12$lQnrUzMPMhsp94CcN3Rxfuw8yB.wGLU/D0M97Cteh1xl3ajFnFvae', 'R6sSr0DQPDTiOudlLKK81xDxLCTIWDvnAc3QeUaUQ7t6V86lXmcH2gUYsX0n', '2024-03-11 02:23:27', '2024-11-20 01:21:24', '085265201781', 4),
(11, 'Nama Admin', 'admin@gmail.com', NULL, '$2y$12$OcQDsAPE42dt29F2/mnYO.modGpMxBBvjpoBRXAJUpx07ePKUZoQC', NULL, '2024-12-15 01:12:02', '2024-12-15 04:24:33', '0085265200', 4);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `arsip`
--
ALTER TABLE `arsip`
  ADD PRIMARY KEY (`id_arsip`),
  ADD KEY `arsip_id_murid_foreign` (`id_murid`),
  ADD KEY `arsip_id_ta_foreign` (`id_ta`),
  ADD KEY `arsip_id_kelas_foreign` (`id_kelas`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `gurus`
--
ALTER TABLE `gurus`
  ADD PRIMARY KEY (`id_guru`),
  ADD UNIQUE KEY `gurus_nip_unique` (`nip`),
  ADD KEY `gurus_role_foreign` (`role`),
  ADD KEY `gurus_id_mapel_foreign` (`id_mapel`);

--
-- Indexes for table `jadwal_pelajarans`
--
ALTER TABLE `jadwal_pelajarans`
  ADD PRIMARY KEY (`id_jadwal`),
  ADD KEY `jadwal_pelajarans_id_kelas_foreign` (`id_kelas`),
  ADD KEY `jadwal_pelajarans_id_jam_foreign` (`id_jam`),
  ADD KEY `jadwal_pelajarans_id_mapel_foreign` (`id_mapel`),
  ADD KEY `jadwal_pelajarans_id_guru_foreign` (`id_guru`),
  ADD KEY `jadwal_pelajarans_id_ta_foreign` (`id_ta`);

--
-- Indexes for table `jam_pelajarans`
--
ALTER TABLE `jam_pelajarans`
  ADD PRIMARY KEY (`id_jam`),
  ADD KEY `jam_pelajarans_id_jadwal_foreign` (`id_jadwal`);

--
-- Indexes for table `kehadirans`
--
ALTER TABLE `kehadirans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kehadirans_id_murid_foreign` (`id_murid`),
  ADD KEY `kehadirans_id_kelas_foreign` (`id_kelas`),
  ADD KEY `kehadirans_id_sesi_foreign` (`id_sesi`);

--
-- Indexes for table `kelas`
--
ALTER TABLE `kelas`
  ADD PRIMARY KEY (`id_kelas`),
  ADD KEY `kelas_id_guru_foreign` (`id_guru`),
  ADD KEY `kelas_id_ta_foreign` (`id_ta`);

--
-- Indexes for table `mapels`
--
ALTER TABLE `mapels`
  ADD PRIMARY KEY (`id_mapel`),
  ADD UNIQUE KEY `mapels_kode_mapel_unique` (`kode_mapel`),
  ADD KEY `mapels_id_guru_foreign` (`id_guru`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `murids`
--
ALTER TABLE `murids`
  ADD PRIMARY KEY (`id_murid`),
  ADD UNIQUE KEY `murids_nisn_unique` (`nisn`),
  ADD KEY `murids_role_foreign` (`role`),
  ADD KEY `murids_id_kelas_foreign` (`id_kelas`),
  ADD KEY `murids_id_ta_foreign` (`id_ta`);

--
-- Indexes for table `nilais`
--
ALTER TABLE `nilais`
  ADD PRIMARY KEY (`id_nilai`),
  ADD KEY `nilais_id_murid_foreign` (`id_murid`),
  ADD KEY `nilais_id_mapel_foreign` (`id_mapel`),
  ADD KEY `nilais_id_ta_foreign` (`id_ta`);

--
-- Indexes for table `ortus`
--
ALTER TABLE `ortus`
  ADD PRIMARY KEY (`id_ortu`),
  ADD KEY `ortus_role_foreign` (`role`),
  ADD KEY `ortus_id_murid_foreign` (`id_murid`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `pelanggaran`
--
ALTER TABLE `pelanggaran`
  ADD PRIMARY KEY (`id_pelanggaran`);

--
-- Indexes for table `pelanggaran_siswa`
--
ALTER TABLE `pelanggaran_siswa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pelanggaran_siswa_id_murid_foreign` (`id_murid`),
  ADD KEY `pelanggaran_siswa_id_pelanggaran_foreign` (`id_pelanggaran`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `prestasi`
--
ALTER TABLE `prestasi`
  ADD PRIMARY KEY (`id_prestasi`);

--
-- Indexes for table `prestasi_siswa`
--
ALTER TABLE `prestasi_siswa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `prestasi_siswa_id_murid_foreign` (`id_murid`),
  ADD KEY `prestasi_siswa_id_prestasi_foreign` (`id_prestasi`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id_roles`),
  ADD UNIQUE KEY `roles_nama_roles_unique` (`nama_roles`);

--
-- Indexes for table `sesi`
--
ALTER TABLE `sesi`
  ADD PRIMARY KEY (`id_sesi`),
  ADD KEY `sesi_id_ta_foreign` (`id_ta`);

--
-- Indexes for table `tahun_ajaran`
--
ALTER TABLE `tahun_ajaran`
  ADD PRIMARY KEY (`id_ta`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_id_role_foreign` (`id_role`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_logs`
--
ALTER TABLE `activity_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=175;

--
-- AUTO_INCREMENT for table `arsip`
--
ALTER TABLE `arsip`
  MODIFY `id_arsip` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=129;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gurus`
--
ALTER TABLE `gurus`
  MODIFY `id_guru` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `jadwal_pelajarans`
--
ALTER TABLE `jadwal_pelajarans`
  MODIFY `id_jadwal` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=260;

--
-- AUTO_INCREMENT for table `jam_pelajarans`
--
ALTER TABLE `jam_pelajarans`
  MODIFY `id_jam` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=311;

--
-- AUTO_INCREMENT for table `kehadirans`
--
ALTER TABLE `kehadirans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=406;

--
-- AUTO_INCREMENT for table `kelas`
--
ALTER TABLE `kelas`
  MODIFY `id_kelas` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=129;

--
-- AUTO_INCREMENT for table `mapels`
--
ALTER TABLE `mapels`
  MODIFY `id_mapel` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

--
-- AUTO_INCREMENT for table `murids`
--
ALTER TABLE `murids`
  MODIFY `id_murid` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `nilais`
--
ALTER TABLE `nilais`
  MODIFY `id_nilai` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=143;

--
-- AUTO_INCREMENT for table `ortus`
--
ALTER TABLE `ortus`
  MODIFY `id_ortu` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `pelanggaran`
--
ALTER TABLE `pelanggaran`
  MODIFY `id_pelanggaran` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `pelanggaran_siswa`
--
ALTER TABLE `pelanggaran_siswa`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prestasi`
--
ALTER TABLE `prestasi`
  MODIFY `id_prestasi` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `prestasi_siswa`
--
ALTER TABLE `prestasi_siswa`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id_roles` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `sesi`
--
ALTER TABLE `sesi`
  MODIFY `id_sesi` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92;

--
-- AUTO_INCREMENT for table `tahun_ajaran`
--
ALTER TABLE `tahun_ajaran`
  MODIFY `id_ta` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `arsip`
--
ALTER TABLE `arsip`
  ADD CONSTRAINT `arsip_id_kelas_foreign` FOREIGN KEY (`id_kelas`) REFERENCES `kelas` (`id_kelas`),
  ADD CONSTRAINT `arsip_id_murid_foreign` FOREIGN KEY (`id_murid`) REFERENCES `murids` (`id_murid`),
  ADD CONSTRAINT `arsip_id_ta_foreign` FOREIGN KEY (`id_ta`) REFERENCES `tahun_ajaran` (`id_ta`);

--
-- Constraints for table `gurus`
--
ALTER TABLE `gurus`
  ADD CONSTRAINT `gurus_id_mapel_foreign` FOREIGN KEY (`id_mapel`) REFERENCES `mapels` (`id_mapel`) ON DELETE CASCADE,
  ADD CONSTRAINT `gurus_role_foreign` FOREIGN KEY (`role`) REFERENCES `roles` (`id_roles`) ON DELETE CASCADE;

--
-- Constraints for table `jadwal_pelajarans`
--
ALTER TABLE `jadwal_pelajarans`
  ADD CONSTRAINT `jadwal_pelajarans_id_guru_foreign` FOREIGN KEY (`id_guru`) REFERENCES `gurus` (`id_guru`),
  ADD CONSTRAINT `jadwal_pelajarans_id_jam_foreign` FOREIGN KEY (`id_jam`) REFERENCES `jam_pelajarans` (`id_jam`) ON DELETE CASCADE,
  ADD CONSTRAINT `jadwal_pelajarans_id_kelas_foreign` FOREIGN KEY (`id_kelas`) REFERENCES `kelas` (`id_kelas`) ON DELETE CASCADE,
  ADD CONSTRAINT `jadwal_pelajarans_id_mapel_foreign` FOREIGN KEY (`id_mapel`) REFERENCES `mapels` (`id_mapel`),
  ADD CONSTRAINT `jadwal_pelajarans_id_ta_foreign` FOREIGN KEY (`id_ta`) REFERENCES `tahun_ajaran` (`id_ta`);

--
-- Constraints for table `jam_pelajarans`
--
ALTER TABLE `jam_pelajarans`
  ADD CONSTRAINT `jam_pelajarans_id_jadwal_foreign` FOREIGN KEY (`id_jadwal`) REFERENCES `jadwal_pelajarans` (`id_jadwal`) ON DELETE CASCADE;

--
-- Constraints for table `kehadirans`
--
ALTER TABLE `kehadirans`
  ADD CONSTRAINT `kehadirans_id_kelas_foreign` FOREIGN KEY (`id_kelas`) REFERENCES `kelas` (`id_kelas`),
  ADD CONSTRAINT `kehadirans_id_murid_foreign` FOREIGN KEY (`id_murid`) REFERENCES `murids` (`id_murid`),
  ADD CONSTRAINT `kehadirans_id_sesi_foreign` FOREIGN KEY (`id_sesi`) REFERENCES `sesi` (`id_sesi`);

--
-- Constraints for table `kelas`
--
ALTER TABLE `kelas`
  ADD CONSTRAINT `kelas_id_guru_foreign` FOREIGN KEY (`id_guru`) REFERENCES `gurus` (`id_guru`) ON DELETE CASCADE,
  ADD CONSTRAINT `kelas_id_ta_foreign` FOREIGN KEY (`id_ta`) REFERENCES `tahun_ajaran` (`id_ta`);

--
-- Constraints for table `mapels`
--
ALTER TABLE `mapels`
  ADD CONSTRAINT `mapels_id_guru_foreign` FOREIGN KEY (`id_guru`) REFERENCES `gurus` (`id_guru`) ON DELETE CASCADE;

--
-- Constraints for table `murids`
--
ALTER TABLE `murids`
  ADD CONSTRAINT `murids_id_kelas_foreign` FOREIGN KEY (`id_kelas`) REFERENCES `kelas` (`id_kelas`) ON DELETE CASCADE,
  ADD CONSTRAINT `murids_id_ta_foreign` FOREIGN KEY (`id_ta`) REFERENCES `tahun_ajaran` (`id_ta`),
  ADD CONSTRAINT `murids_role_foreign` FOREIGN KEY (`role`) REFERENCES `roles` (`id_roles`) ON DELETE CASCADE;

--
-- Constraints for table `nilais`
--
ALTER TABLE `nilais`
  ADD CONSTRAINT `nilais_id_mapel_foreign` FOREIGN KEY (`id_mapel`) REFERENCES `mapels` (`id_mapel`) ON DELETE CASCADE,
  ADD CONSTRAINT `nilais_id_murid_foreign` FOREIGN KEY (`id_murid`) REFERENCES `murids` (`id_murid`) ON DELETE CASCADE,
  ADD CONSTRAINT `nilais_id_ta_foreign` FOREIGN KEY (`id_ta`) REFERENCES `tahun_ajaran` (`id_ta`);

--
-- Constraints for table `ortus`
--
ALTER TABLE `ortus`
  ADD CONSTRAINT `ortus_id_murid_foreign` FOREIGN KEY (`id_murid`) REFERENCES `murids` (`id_murid`) ON DELETE CASCADE,
  ADD CONSTRAINT `ortus_role_foreign` FOREIGN KEY (`role`) REFERENCES `roles` (`id_roles`) ON DELETE CASCADE;

--
-- Constraints for table `pelanggaran_siswa`
--
ALTER TABLE `pelanggaran_siswa`
  ADD CONSTRAINT `pelanggaran_siswa_id_murid_foreign` FOREIGN KEY (`id_murid`) REFERENCES `murids` (`id_murid`),
  ADD CONSTRAINT `pelanggaran_siswa_id_pelanggaran_foreign` FOREIGN KEY (`id_pelanggaran`) REFERENCES `pelanggaran` (`id_pelanggaran`);

--
-- Constraints for table `prestasi_siswa`
--
ALTER TABLE `prestasi_siswa`
  ADD CONSTRAINT `prestasi_siswa_id_murid_foreign` FOREIGN KEY (`id_murid`) REFERENCES `murids` (`id_murid`),
  ADD CONSTRAINT `prestasi_siswa_id_prestasi_foreign` FOREIGN KEY (`id_prestasi`) REFERENCES `prestasi` (`id_prestasi`);

--
-- Constraints for table `sesi`
--
ALTER TABLE `sesi`
  ADD CONSTRAINT `sesi_id_ta_foreign` FOREIGN KEY (`id_ta`) REFERENCES `tahun_ajaran` (`id_ta`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_id_role_foreign` FOREIGN KEY (`id_role`) REFERENCES `roles` (`id_roles`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
