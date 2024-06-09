-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 09 Jun 2024 pada 00.58
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
-- Database: `db_lms`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `pembelajarans`
--

CREATE TABLE `pembelajarans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tahunpelajaran_id` int(5) NOT NULL,
  `rombonganbelajar_id` int(11) NOT NULL,
  `matapelajaran` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `pembelajarans`
--

INSERT INTO `pembelajarans` (`id`, `tahunpelajaran_id`, `rombonganbelajar_id`, `matapelajaran`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 1, 75, 'Platform Komputasi Awan', 84, '2024-03-16 22:14:22', '2024-03-16 22:14:22'),
(2, 1, 1, 'Matematika', 84, '2024-03-16 22:20:51', '2024-03-16 22:20:51'),
(3, 1, 2, 'Matematika', 84, '2024-03-16 22:22:49', '2024-03-16 22:22:49'),
(4, 1, 3, 'Matematika', 84, '2024-03-16 22:22:49', '2024-03-16 22:22:49'),
(5, 1, 76, 'Platform Komputasi Awan', 84, '2024-03-17 05:41:32', '2024-03-17 05:41:32'),
(6, 1, 1, 'Projek Kreatif dan Kewirausahaan', 1, '2024-03-17 06:27:22', '2024-03-17 06:27:22'),
(7, 1, 1, 'Matematika', 1, '2024-03-17 06:27:22', '2024-03-17 06:27:22'),
(8, 1, 1, 'Bahasa Indonesia', 1, '2024-03-17 06:27:22', '2024-03-17 06:27:22'),
(9, 1, 1, 'Bahasa Inggris', 1, '2024-03-17 06:27:22', '2024-03-17 06:27:22'),
(10, 1, 1, 'Pendidikan Pancasila', 1, '2024-03-17 06:27:22', '2024-03-17 06:27:22'),
(11, 1, 1, 'Pendidikan Agama Islam dan Budi Pekerti', 1, '2024-03-17 06:27:22', '2024-03-17 06:27:22'),
(12, 1, 1, 'Pendidikan Jasmani dan Olahraga', 1, '2024-03-17 06:27:22', '2024-03-17 06:27:22'),
(13, 1, 1, 'Sejarah', 1, '2024-03-17 06:27:22', '2024-03-17 06:27:22'),
(14, 1, 1, 'Muatan Lokal Bahasa Sunda', 1, '2024-03-17 06:27:22', '2024-03-17 06:27:22'),
(15, 1, 1, 'Muatan Lokal Bahasa Korea', 1, '2024-03-17 06:27:22', '2024-03-17 06:27:22'),
(16, 1, 1, 'Muatan Lokal Bahasa Jerman', 1, '2024-03-17 06:27:22', '2024-03-17 06:27:22'),
(17, 1, 1, 'Informatika', 1, '2024-03-17 06:27:22', '2024-03-17 06:27:22'),
(18, 1, 1, 'Projek Ilmu Pengetahuan Alam dan Sosial', 1, '2024-03-17 06:27:22', '2024-03-17 06:27:22'),
(19, 1, 1, 'Dasar – dasar Program Keahlian', 1, '2024-03-17 06:27:22', '2024-03-17 06:27:22'),
(20, 1, 1, 'Muatan Konsentrasi Keahlian', 1, '2024-03-17 06:27:22', '2024-03-17 06:27:22'),
(21, 1, 1, 'Mata Pelajaran Pilihan', 1, '2024-03-17 06:27:22', '2024-03-17 06:27:22'),
(22, 1, 1, 'Seni Budaya', 1, '2024-03-17 06:27:22', '2024-03-17 06:27:22');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `pembelajarans`
--
ALTER TABLE `pembelajarans`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `pembelajarans`
--
ALTER TABLE `pembelajarans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
