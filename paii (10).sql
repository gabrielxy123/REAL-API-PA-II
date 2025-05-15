-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 15 Bulan Mei 2025 pada 08.42
-- Versi server: 10.4.28-MariaDB
-- Versi PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `paii`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
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
-- Struktur dari tabel `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategoris`
--

CREATE TABLE `kategoris` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kategori` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `kategoris`
--

INSERT INTO `kategoris` (`id`, `kategori`, `created_at`, `updated_at`) VALUES
(1, 'Satuan', NULL, NULL),
(2, 'Kiloan', NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `layanans`
--

CREATE TABLE `layanans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `harga` decimal(10,0) NOT NULL,
  `id_user` bigint(20) UNSIGNED NOT NULL,
  `id_toko` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `layanans`
--

INSERT INTO `layanans` (`id`, `nama`, `harga`, `id_user`, `id_toko`, `created_at`, `updated_at`) VALUES
(1, 'Laundry Express', 5000, 1, 1, '2025-05-07 18:09:44', '2025-05-07 18:09:44'),
(2, 'Express', 5000, 1, 1, '2025-05-07 19:20:13', '2025-05-07 19:20:13'),
(3, 'Setrika', 5000, 1, 1, '2025-05-07 20:32:10', '2025-05-07 20:32:10'),
(4, 'Pewangi', 2000, 1, 1, '2025-05-07 21:54:48', '2025-05-07 21:54:48');

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_03_04_060319_create_personal_access_tokens_table', 1),
(6, '2025_03_04_065341_create_person_table', 2),
(7, '2025_03_18_070253_add_profile_image_to_users_table', 2),
(8, '2025_04_11_023138_add_role_to_users_table', 3),
(10, '2025_04_11_030320_create_tokos_table', 4),
(11, '2025_04_29_031717_create_kategoris_table', 5),
(12, '2025_04_28_023648_create_produks_table', 6),
(13, '2025_05_07_155419_create_pesanan_table', 7),
(14, '2025_05_08_005646_layanan', 8),
(15, '2025_05_08_064001_add_catatan_to_pesanans_table', 9),
(16, '2025_05_08_070648_add_timestamps_to_table', 10),
(17, '2025_05_08_075813_add_quantity_to_pesanans_table', 11),
(18, '2025_05_08_082041_add_subtotal_to_pesanans_table', 12),
(19, '2025_05_08_090853_add_kode_transaksi_to_pesanans_table', 13),
(20, '2025_05_09_030625_add_layanan_tambahan_to_pesanans_table', 14),
(21, '2025_05_09_034830_create_pesanan_layanan_tambahan_table', 15),
(22, '2025_05_13_034550_create_pesanan_kiloan_table', 16),
(23, '2025_05_13_034605_create_pesanan_kiloan_table', 16),
(24, '2025_05_13_034622_create_pesanan_kiloan_table', 17),
(25, '2025_05_13_040919_add_quantity_to_pesanan_kiloan_details_table', 18);

-- --------------------------------------------------------

--
-- Struktur dari tabel `notifikasis`
--

CREATE TABLE `notifikasis` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`data`)),
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `notifikasis`
--

INSERT INTO `notifikasis` (`id`, `user_id`, `title`, `body`, `data`, `is_read`, `created_at`, `updated_at`) VALUES
(1, 1, 'Toko Disetujui', 'Selamat! Toko Anda telah disetujui oleh admin.', '[]', 0, '2025-05-14 00:42:28', '2025-05-14 00:42:28'),
(2, 27, 'Toko Disetujui', 'Selamat! Toko Anda telah disetujui oleh admin.', '[]', 0, '2025-05-14 07:58:27', '2025-05-14 07:58:27');

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `person`
--

CREATE TABLE `person` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `personal_access_tokens`
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

--
-- Dumping data untuk tabel `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\User', 1, 'auth_token', 'a337f8648d5e7052b6db3de353721b5b75393db9af7865656b6bf990866f17a0', '[\"*\"]', NULL, NULL, '2025-03-04 06:06:53', '2025-03-04 06:06:53'),
(2, 'App\\Models\\User', 2, 'auth_token', '789ff6299c4714b1e8988da36d5003202347ba7f07857572829196f3dad7c373', '[\"*\"]', NULL, NULL, '2025-03-04 06:29:34', '2025-03-04 06:29:34'),
(3, 'App\\Models\\User', 2, 'auth_token', '73dee7d3346ddb084cb0d218abb3ab48329ab3d2da627c7b6ac440505fe57cd0', '[\"*\"]', NULL, NULL, '2025-03-04 06:31:55', '2025-03-04 06:31:55'),
(4, 'App\\Models\\User', 2, 'auth_token', '73ba4d1fecf2f34c41d8ea52bfb96002861a9b63bf80b1f5d34e37823ab88c8d', '[\"*\"]', NULL, NULL, '2025-03-04 09:01:46', '2025-03-04 09:01:46'),
(5, 'App\\Models\\User', 5, 'auth_token', '09e86323f90887cdebebc2b733391c00482d5efc66a5f360d14846a918cba6ac', '[\"*\"]', NULL, NULL, '2025-03-04 09:33:40', '2025-03-04 09:33:40'),
(6, 'App\\Models\\User', 5, 'auth_token', '32b7bd7ef11b11147dcd56e0609846e65b1c92df63a93327b4f8856580ef30f2', '[\"*\"]', NULL, NULL, '2025-03-04 09:43:45', '2025-03-04 09:43:45'),
(7, 'App\\Models\\User', 5, 'auth_token', '168146f52f8a7909cc74dc951be58fb1ec44678d071098c40e43fb20af0bfe2e', '[\"*\"]', NULL, NULL, '2025-03-04 09:44:23', '2025-03-04 09:44:23'),
(8, 'App\\Models\\User', 5, 'auth_token', '79ae21f4ba30d0e8060518ecf68d8eec42deeb76d41b213d2958dc26f40801d0', '[\"*\"]', NULL, NULL, '2025-03-04 09:44:25', '2025-03-04 09:44:25'),
(9, 'App\\Models\\User', 5, 'auth_token', '1fc4282d7d966dc6317a2c64f2dee66c2e41f93cacc3c2f4ab97043479852e9a', '[\"*\"]', NULL, NULL, '2025-03-04 09:45:18', '2025-03-04 09:45:18'),
(10, 'App\\Models\\User', 5, 'auth_token', 'a78e13ff30dd4787833f5dbf069113eb7e7aca1afaa3f5bbb60cecc620cf9de1', '[\"*\"]', NULL, NULL, '2025-03-04 09:46:02', '2025-03-04 09:46:02'),
(11, 'App\\Models\\User', 5, 'auth_token', 'dd34487a1f6fbef2e3775a5d5b14d7c521e6775ffe85d7ac524accc9d33f5f30', '[\"*\"]', NULL, NULL, '2025-03-04 09:52:55', '2025-03-04 09:52:55'),
(12, 'App\\Models\\User', 5, 'auth_token', 'cf9ea91ba6bd4c11c814c0e5a92930ba5cef3163de225468681a808c65f58704', '[\"*\"]', NULL, NULL, '2025-03-04 09:53:54', '2025-03-04 09:53:54'),
(13, 'App\\Models\\User', 5, 'auth_token', 'f037c75b7fd31434029b9debf286c4c40b4d202286df761fa18b4817edf997e1', '[\"*\"]', NULL, NULL, '2025-03-04 10:04:22', '2025-03-04 10:04:22'),
(14, 'App\\Models\\User', 5, 'auth_token', 'd7f5ba6866cab42406e226d75f00eeb7a043ac096a953141712d704b7c9a8efa', '[\"*\"]', NULL, NULL, '2025-03-04 10:04:42', '2025-03-04 10:04:42'),
(15, 'App\\Models\\User', 5, 'auth_token', '5f3f2d6d390e3d4c75ffdb345bed00efc07700c5871d0442e83d959c8f6e66e3', '[\"*\"]', NULL, NULL, '2025-03-04 10:05:48', '2025-03-04 10:05:48'),
(16, 'App\\Models\\User', 5, 'auth_token', '75295c8e17ecf58d15d2d0c90483f22246b319c669493ae3ebd327412a5e1a18', '[\"*\"]', NULL, NULL, '2025-03-04 10:09:08', '2025-03-04 10:09:08'),
(17, 'App\\Models\\User', 5, 'auth_token', '9bcffe1b67e93fa2337e88e65c8fc8f3656bc240b98107d22e40d057b910f8ba', '[\"*\"]', NULL, NULL, '2025-03-04 10:11:09', '2025-03-04 10:11:09'),
(18, 'App\\Models\\User', 5, 'auth_token', '8f24098ff044765ffe1e10c7c39416511a3a26a3d5295b5c22747ffb1e2f91c5', '[\"*\"]', NULL, NULL, '2025-03-04 10:14:44', '2025-03-04 10:14:44'),
(19, 'App\\Models\\User', 5, 'auth_token', '2d10c27c5a9a8edc5a6207d73dabc16c558152c0f018652120b3626d981dad6b', '[\"*\"]', NULL, NULL, '2025-03-04 10:16:37', '2025-03-04 10:16:37'),
(20, 'App\\Models\\User', 5, 'auth_token', 'e68347acb933cba3b53cde77ce9ed5c05589d974ad95dcd004ed6de634d2cee4', '[\"*\"]', NULL, NULL, '2025-03-04 10:34:13', '2025-03-04 10:34:13'),
(21, 'App\\Models\\User', 5, 'auth_token', '8e39446a9cee594738e7be4cfbf59cd533d74c44740c76eb4e169eee1f2d130e', '[\"*\"]', NULL, NULL, '2025-03-05 23:13:41', '2025-03-05 23:13:41'),
(22, 'App\\Models\\User', 5, 'auth_token', 'd710f0656af11a51a761763a8b50078d5a0bf910fe429125a6094776591102ff', '[\"*\"]', NULL, NULL, '2025-03-05 23:13:42', '2025-03-05 23:13:42'),
(23, 'App\\Models\\User', 7, 'auth_token', '77180c3351fc5b1d680f929e898f34999367e75327b7f4c1b574d6452bea2950', '[\"*\"]', NULL, NULL, '2025-03-05 23:16:14', '2025-03-05 23:16:14'),
(24, 'App\\Models\\User', 7, 'auth_token', 'bb51415a0dd56333663bffdf52f0a0f2074a29b2b4c8a4d9d4e18561f6c11555', '[\"*\"]', NULL, NULL, '2025-03-05 23:20:52', '2025-03-05 23:20:52'),
(25, 'App\\Models\\User', 5, 'auth_token', '7071141a436757939d25ae84480eea1a9536762bc66c75e7e6ed6ad32648a329', '[\"*\"]', NULL, NULL, '2025-03-05 23:33:28', '2025-03-05 23:33:28'),
(26, 'App\\Models\\User', 5, 'auth_token', 'd75cfc8817dbf6f87981736764479fe38d7388034a067f1112addbdde7e46b5c', '[\"*\"]', NULL, NULL, '2025-03-06 00:20:44', '2025-03-06 00:20:44'),
(27, 'App\\Models\\User', 5, 'auth_token', 'e3871d8a545ad8c4dfa67719b6a57d73024bbf0adc2ae2a97a8416252580e204', '[\"*\"]', NULL, NULL, '2025-03-06 00:49:31', '2025-03-06 00:49:31'),
(28, 'App\\Models\\User', 5, 'auth_token', '86393893a834dbb4320e10f93402769bfe658e4d0f96bbb5a3d1b62cf75169ad', '[\"*\"]', NULL, NULL, '2025-03-06 01:08:55', '2025-03-06 01:08:55'),
(29, 'App\\Models\\User', 5, 'auth_token', '520fd67521bbd9dc34e9d9a6bc8b6146601db049180fd8a4a7184a89fe9ee2a7', '[\"*\"]', NULL, NULL, '2025-03-09 08:03:37', '2025-03-09 08:03:37'),
(30, 'App\\Models\\User', 5, 'auth_token', '49ea038161cb788de8fc5e7dc4f2e06f8e6c3a119546f03a2ab21168da9d548e', '[\"*\"]', NULL, NULL, '2025-03-09 08:03:46', '2025-03-09 08:03:46'),
(31, 'App\\Models\\User', 5, 'auth_token', '18beef28e60c81d019668e557c7c518472f5a8e688970607bf9297bde25662e0', '[\"*\"]', NULL, NULL, '2025-03-09 08:06:45', '2025-03-09 08:06:45'),
(32, 'App\\Models\\User', 5, 'auth_token', '1019743cc1cf1ab99c2a913d5c21b6fcfa58757f296b4c5708ef25dc44251cd6', '[\"*\"]', NULL, NULL, '2025-03-09 08:10:30', '2025-03-09 08:10:30'),
(33, 'App\\Models\\User', 5, 'auth_token', '1470887395895e9798858da8311f90c30703ba2ff335f90462f19c0c96ac87f2', '[\"*\"]', NULL, NULL, '2025-03-09 08:45:00', '2025-03-09 08:45:00'),
(34, 'App\\Models\\User', 5, 'auth_token', 'bc419a5d3b3d8e3447c0322f36759d8b40526a6c01188d90a6a1208e96019fe4', '[\"*\"]', NULL, NULL, '2025-03-09 08:46:59', '2025-03-09 08:46:59'),
(35, 'App\\Models\\User', 5, 'auth_token', '0f65b21f4c73fffeab1bceeb1e582aaf709039378af7f2ed312c766e65ed7728', '[\"*\"]', NULL, NULL, '2025-03-09 09:15:34', '2025-03-09 09:15:34'),
(36, 'App\\Models\\User', 5, 'auth_token', 'a2b500384e63c0a14be3b2ff58e34ebcf74c95e0205e4aa25e3f6235d7130d2f', '[\"*\"]', NULL, NULL, '2025-03-09 09:17:10', '2025-03-09 09:17:10'),
(37, 'App\\Models\\User', 5, 'auth_token', '3198589e5b3c15cb71d2a9172a01dbc9fdb4084bda20480af2667120ae1826ea', '[\"*\"]', NULL, NULL, '2025-03-09 09:18:05', '2025-03-09 09:18:05'),
(38, 'App\\Models\\User', 5, 'auth_token', 'c776b0ff20e015f2c5081984f6dc34c736fc47fb4d510bb9489cc52f000ef415', '[\"*\"]', NULL, NULL, '2025-03-09 09:24:37', '2025-03-09 09:24:37'),
(39, 'App\\Models\\User', 5, 'auth_token', 'fedf05bfb777d1069acb411acb6ee872f290f0b88c5b8b6e1673b2b4fd790220', '[\"*\"]', NULL, NULL, '2025-03-09 09:25:38', '2025-03-09 09:25:38'),
(40, 'App\\Models\\User', 5, 'auth_token', '246261499d5b92a2c93e333cb4827d63965efdd5d82181fe112028d4d94427e1', '[\"*\"]', NULL, NULL, '2025-03-09 09:26:25', '2025-03-09 09:26:25'),
(41, 'App\\Models\\User', 5, 'auth_token', '07f1b1bc399f49cc3403bdcb6a2c079d858de583a5fcb74698bcdc3fcdcc468f', '[\"*\"]', NULL, NULL, '2025-03-09 09:39:32', '2025-03-09 09:39:32'),
(42, 'App\\Models\\User', 5, 'auth_token', '637ccc7ae611bc471767311efafd6e1c21b33d6420ff56a4678d19c39d749998', '[\"*\"]', NULL, NULL, '2025-03-09 09:41:00', '2025-03-09 09:41:00'),
(43, 'App\\Models\\User', 5, 'auth_token', 'f9575a34b23648a79a18e59d39c76a2721f810e4b92412525245add1c6e91e4d', '[\"*\"]', NULL, NULL, '2025-03-09 09:58:20', '2025-03-09 09:58:20'),
(44, 'App\\Models\\User', 5, 'auth_token', 'e8121d2602cb45872c93d1d6774fdbb147c5fee7c1ca0ca7df94e89d97f60cd0', '[\"*\"]', NULL, NULL, '2025-03-09 10:01:47', '2025-03-09 10:01:47'),
(45, 'App\\Models\\User', 5, 'auth_token', 'b89f52e92c81958448b47d61b1d39da1237f7b67ca069d686d97d4c5fc69bf16', '[\"*\"]', NULL, NULL, '2025-03-09 19:45:12', '2025-03-09 19:45:12'),
(46, 'App\\Models\\User', 9, 'auth_token', '561874e44ff997e683ff9bd9aa8f757d4f694610622aaf3a3414a491d67a8410', '[\"*\"]', NULL, NULL, '2025-03-09 19:45:49', '2025-03-09 19:45:49'),
(47, 'App\\Models\\User', 8, 'auth_token', 'fb81b77cb891d415496a2e84824c42a832538192af2290fcd303282ad8954efc', '[\"*\"]', NULL, NULL, '2025-03-09 20:09:21', '2025-03-09 20:09:21'),
(48, 'App\\Models\\User', 5, 'auth_token', '15017cf6e9de13ccf79edce96c8f4498f93603468834edbc101756306badcaee', '[\"*\"]', NULL, NULL, '2025-03-17 20:15:42', '2025-03-17 20:15:42'),
(49, 'App\\Models\\User', 5, 'auth_token', 'fd0d3c089ff9e69a6747fc8f41b66507ad79191b60c4a45ef9bf8035bff09fb6', '[\"*\"]', NULL, NULL, '2025-03-17 20:15:44', '2025-03-17 20:15:44'),
(50, 'App\\Models\\User', 5, 'auth_token', '50362d55565003d415e22e2280bc4ec3dd78c19f2c99cef83737fd8976371219', '[\"*\"]', NULL, NULL, '2025-03-17 20:15:45', '2025-03-17 20:15:45'),
(51, 'App\\Models\\User', 5, 'auth_token', '9249ce8a8f3d9cb4cab14cf5e092ef02ace228a5bb5a9d9283a7f74eb48dc93f', '[\"*\"]', NULL, NULL, '2025-03-17 20:15:46', '2025-03-17 20:15:46'),
(52, 'App\\Models\\User', 5, 'auth_token', '76b1e0edb8c97d97e59d7c9573300aeccd4a2b5e023e4961ca2cceb6d0bb229d', '[\"*\"]', NULL, NULL, '2025-03-17 20:15:46', '2025-03-17 20:15:46'),
(53, 'App\\Models\\User', 5, 'auth_token', '243f4d66178e64c9a7d18bdeda9f49e26eddde17b30b17267ef2212b3b94d1ee', '[\"*\"]', NULL, NULL, '2025-03-17 20:15:47', '2025-03-17 20:15:47'),
(54, 'App\\Models\\User', 5, 'auth_token', 'fcb3d94ad2e10094aa9beb20ef80881a5f022dae99ef5db51a04c93a9ea51c08', '[\"*\"]', NULL, NULL, '2025-03-17 20:15:47', '2025-03-17 20:15:47'),
(55, 'App\\Models\\User', 5, 'auth_token', '1aae28608539f2f7ee8f9f03644f46ad808f41c375b520a3b812d5cef1450ab7', '[\"*\"]', NULL, NULL, '2025-03-17 20:15:48', '2025-03-17 20:15:48'),
(56, 'App\\Models\\User', 5, 'auth_token', 'ac8a3130e39d08407d5c9b1882c311d0885122b7d29c602a7486464643f2e1bb', '[\"*\"]', NULL, NULL, '2025-03-17 20:15:48', '2025-03-17 20:15:48'),
(57, 'App\\Models\\User', 5, 'auth_token', '3926f8ac57b0f815dcb8569675b819d20291ce6d46a5a01c2108ef83c63d602e', '[\"*\"]', NULL, NULL, '2025-03-17 20:15:49', '2025-03-17 20:15:49'),
(58, 'App\\Models\\User', 5, 'auth_token', '9a98a20afc59f5cb12489c7ecf6313c14451467545339f2c9e969b4e4a10e0f6', '[\"*\"]', NULL, NULL, '2025-03-17 20:15:50', '2025-03-17 20:15:50'),
(59, 'App\\Models\\User', 5, 'auth_token', '0c65fb94c24afab1bda415bc9e485a4266fd56e7eb452d7e18a9edb96cf77e35', '[\"*\"]', NULL, NULL, '2025-03-17 20:15:50', '2025-03-17 20:15:50'),
(60, 'App\\Models\\User', 5, 'auth_token', '98c0ecfd286bd98a19623d750dcc1892fc322c215839bc0b94c728518b1105e3', '[\"*\"]', NULL, NULL, '2025-03-17 20:17:48', '2025-03-17 20:17:48'),
(61, 'App\\Models\\User', 5, 'auth_token', 'ae04fe3d9ad88286643fd1afdd782d75509528ef35668b6d378391151287fed4', '[\"*\"]', NULL, NULL, '2025-03-17 20:30:39', '2025-03-17 20:30:39'),
(62, 'App\\Models\\User', 5, 'auth_token', 'cee3da2d95bcb161bcc6d1183f8eed91c1eb41d1c99d4f4319b01fbbeed21173', '[\"*\"]', NULL, NULL, '2025-03-17 20:31:16', '2025-03-17 20:31:16'),
(63, 'App\\Models\\User', 8, 'auth_token', '789e33aed8010e0bcc76fab599557d7ed4d28d0868c6f06996ba261e0c8ffe6b', '[\"*\"]', NULL, NULL, '2025-03-17 20:32:51', '2025-03-17 20:32:51'),
(64, 'App\\Models\\User', 8, 'auth_token', '0345bcded5945be5397f8f97d278edc550866386ba89148f0570d87f871b56f0', '[\"*\"]', NULL, NULL, '2025-03-17 20:32:52', '2025-03-17 20:32:52'),
(65, 'App\\Models\\User', 8, 'auth_token', '64c0d73f46c10b7210cb73ac119afaf880a3a742f82259ebe0107d126b3c8520', '[\"*\"]', NULL, NULL, '2025-03-17 20:32:52', '2025-03-17 20:32:52'),
(66, 'App\\Models\\User', 8, 'auth_token', '5365533a944b0c3e03804eff67dd579eaa9701d3b0e5774fa0e15a389eb2ee17', '[\"*\"]', NULL, NULL, '2025-03-17 20:32:53', '2025-03-17 20:32:53'),
(67, 'App\\Models\\User', 11, 'auth_token', 'b9cba80981d164b3d75b15684df111ea812ca3ed8aac448b80cdaf9553024b7b', '[\"*\"]', NULL, NULL, '2025-03-17 20:36:02', '2025-03-17 20:36:02'),
(68, 'App\\Models\\User', 11, 'auth_token', '8aecdcb7213bc762087c41c90df8f59d38165511a4d937589541ed3fe8cc18dc', '[\"*\"]', NULL, NULL, '2025-03-17 20:36:03', '2025-03-17 20:36:03'),
(69, 'App\\Models\\User', 5, 'auth_token', 'cbf854609c1d2d4083188bf879d4ff969549d8c54421cec64e1be358c3a9fb81', '[\"*\"]', NULL, NULL, '2025-03-17 23:50:19', '2025-03-17 23:50:19'),
(70, 'App\\Models\\User', 5, 'auth_token', 'f82f06675fc7231ef0fcbea1eb789488cb1bd46ae3100cfe8a9272c872031e40', '[\"*\"]', NULL, NULL, '2025-03-17 23:50:37', '2025-03-17 23:50:37'),
(71, 'App\\Models\\User', 5, 'auth_token', '05a5e6ae751a0fefc97c64299da4fd2f9e7591ec80bad3a4ff74b3860836f3b9', '[\"*\"]', NULL, NULL, '2025-03-17 23:57:26', '2025-03-17 23:57:26'),
(72, 'App\\Models\\User', 11, 'auth_token', 'd75596590b592b3d4b77085834b7abe779df4c3b3350625360f6e5decc2483fa', '[\"*\"]', NULL, NULL, '2025-03-18 00:55:06', '2025-03-18 00:55:06'),
(73, 'App\\Models\\User', 5, 'auth_token', '8933b2668e2edaaf20a1e07fd4a607eb17dff014d71ed473c61676140bf75849', '[\"*\"]', NULL, NULL, '2025-03-18 01:32:48', '2025-03-18 01:32:48'),
(74, 'App\\Models\\User', 12, 'auth_token', 'ba0f742b8da7ce33a178b1d4fe9131daf6734c5d0a9c7c57eabfa0f6a9b3f2d6', '[\"*\"]', '2025-03-18 01:39:22', NULL, '2025-03-18 01:34:29', '2025-03-18 01:39:22'),
(75, 'App\\Models\\User', 5, 'auth_token', '853e91e3ff2a9959608b45dc85c808cd7193335e3164be9a83afcf763a98486d', '[\"*\"]', '2025-03-18 01:38:55', NULL, '2025-03-18 01:37:51', '2025-03-18 01:38:55'),
(76, 'App\\Models\\User', 12, 'auth_token', '8bfd82fd815ff50e8da08c43340310ab38ce102cf0268bbe462cde5c1087942e', '[\"*\"]', NULL, NULL, '2025-03-18 01:46:49', '2025-03-18 01:46:49'),
(77, 'App\\Models\\User', 12, 'auth_token', '4baa7998b29ebc056193202d4be4ba531b968e2416c3a6bb233ab0676edfe8f9', '[\"*\"]', NULL, NULL, '2025-03-18 01:57:36', '2025-03-18 01:57:36'),
(78, 'App\\Models\\User', 12, 'auth_token', 'f966b87b920ed14ce005c2414a0a860b7deda6d112dd8d40465e6898f0f600e9', '[\"*\"]', '2025-03-18 02:27:42', NULL, '2025-03-18 02:17:25', '2025-03-18 02:27:42'),
(79, 'App\\Models\\User', 12, 'auth_token', 'e70bd99fa6bf27c15be17f10b15fb446531410e7bb972b31036f4511f7e89d86', '[\"*\"]', '2025-03-18 02:29:49', NULL, '2025-03-18 02:29:45', '2025-03-18 02:29:49'),
(80, 'App\\Models\\User', 1, 'auth_token', 'b6f5f4e0d2dd63db7bd6e3931e41912de21722895b306d940a0adfaab5d26696', '[\"*\"]', '2025-03-20 10:27:31', NULL, '2025-03-20 10:27:30', '2025-03-20 10:27:31'),
(81, 'App\\Models\\User', 1, 'auth_token', '690407570a0c2acaad3e5294a98bdc072801002897d39f03ab2022453a21e82a', '[\"*\"]', '2025-03-20 10:30:13', NULL, '2025-03-20 10:30:13', '2025-03-20 10:30:13'),
(82, 'App\\Models\\User', 12, 'auth_token', '53a2d773f0ffdb82bc5009b4ce23d15207ee801bc45818824967dfe9d5db43b9', '[\"*\"]', '2025-03-20 10:33:21', NULL, '2025-03-20 10:33:20', '2025-03-20 10:33:21'),
(83, 'App\\Models\\User', 12, 'auth_token', 'b6d4d244e6716c95e07876d754715ac4d66205a86ea03ee24a8d4a6dedc68119', '[\"*\"]', '2025-03-20 18:27:20', NULL, '2025-03-20 10:36:54', '2025-03-20 18:27:20'),
(84, 'App\\Models\\User', 1, 'auth_token', '4dfaaeb914999ca456ee4723f82466362a68dd385fa22f2cf4e1250aa7282d01', '[\"*\"]', '2025-03-20 18:31:57', NULL, '2025-03-20 18:31:33', '2025-03-20 18:31:57'),
(85, 'App\\Models\\User', 1, 'auth_token', '94f6bc8647fd718e782cbefa485bec4f5af9518d0981c7c08c5f7e98ead2f522', '[\"*\"]', '2025-03-20 18:33:05', NULL, '2025-03-20 18:32:45', '2025-03-20 18:33:05'),
(86, 'App\\Models\\User', 12, 'auth_token', 'efb036447b8a343c95c6c1e74a6b9ed222181d14ca6248b183717209d3ba7aa2', '[\"*\"]', '2025-03-20 18:56:33', NULL, '2025-03-20 18:34:21', '2025-03-20 18:56:33'),
(87, 'App\\Models\\User', 1, 'auth_token', '362c8c88292dafb088d58aa8874d5fadd8f4b8331f6ad0721357f95ec692806a', '[\"*\"]', '2025-03-20 20:42:07', NULL, '2025-03-20 20:42:05', '2025-03-20 20:42:07'),
(88, 'App\\Models\\User', 12, 'auth_token', 'b52e43a5188645d610651ba39f82223e816b75e7bded90faa3b20c13996ad2e0', '[\"*\"]', '2025-03-20 20:49:12', NULL, '2025-03-20 20:49:11', '2025-03-20 20:49:12'),
(89, 'App\\Models\\User', 1, 'auth_token', '4800c260b7be0be65f4acf35fc361bc1be568f652bfe9a1b0c465332ae2e4a1c', '[\"*\"]', '2025-03-20 20:49:56', NULL, '2025-03-20 20:49:25', '2025-03-20 20:49:56'),
(90, 'App\\Models\\User', 1, 'auth_token', '5c2012d730b7e76d271c19b72bed7b98a5f42ed242b9f7966c0f88e57e0f6553', '[\"*\"]', '2025-03-20 21:01:47', NULL, '2025-03-20 20:58:56', '2025-03-20 21:01:47'),
(91, 'App\\Models\\User', 1, 'auth_token', '6e9cde809271f95a03ff172d28f60ad1bef665d35d86cbb4c517dcaaee0aada4', '[\"*\"]', '2025-03-20 21:22:03', NULL, '2025-03-20 21:22:01', '2025-03-20 21:22:03'),
(92, 'App\\Models\\User', 1, 'auth_token', 'c2f86c5da97bf6967b44f981def1a39b68f2b2ac896ee2d92d4decea2507ce2c', '[\"*\"]', '2025-03-20 21:34:30', NULL, '2025-03-20 21:22:34', '2025-03-20 21:34:30'),
(93, 'App\\Models\\User', 1, 'auth_token', '53803d9aeb99bfb549ed0832dcedc2fb025fbb52c274eb8da0320738a85d6afc', '[\"*\"]', '2025-03-26 19:43:33', NULL, '2025-03-26 19:43:30', '2025-03-26 19:43:33'),
(94, 'App\\Models\\User', 1, 'auth_token', 'bf42f529b60d3395fbaedf50f81c0ef9e99fd5cb4d07b91cda11e837478e4a6e', '[\"*\"]', '2025-03-26 19:57:16', NULL, '2025-03-26 19:56:09', '2025-03-26 19:57:16'),
(95, 'App\\Models\\User', 1, 'auth_token', 'bc8c0ba37edaf4e8cfda339b241c88b34e87b6b73fa6365ca0207b008320f54a', '[\"*\"]', '2025-03-26 19:58:49', NULL, '2025-03-26 19:57:41', '2025-03-26 19:58:49'),
(96, 'App\\Models\\User', 1, 'auth_token', '7ab515c631b1e3c9854d29924caa43780b317ca923d6a4be1119679a390f08b9', '[\"*\"]', '2025-03-26 20:01:20', NULL, '2025-03-26 19:59:16', '2025-03-26 20:01:20'),
(97, 'App\\Models\\User', 1, 'auth_token', 'bc1ab19282ba61f485fc04adb82dfd34cd82870c28f0b2c05fb7e065909f749f', '[\"*\"]', '2025-03-26 20:30:23', NULL, '2025-03-26 20:01:55', '2025-03-26 20:30:23'),
(98, 'App\\Models\\User', 1, 'auth_token', '96ab9e0c16afa1c185b754751265deeaeaf796c5b02a413b37c1a0b44f104a4b', '[\"*\"]', '2025-03-26 20:47:43', NULL, '2025-03-26 20:38:22', '2025-03-26 20:47:43'),
(99, 'App\\Models\\User', 1, 'auth_token', '50576bfc8719767b7ade229176cd159ee1529a182d0ee395b8278cd8721607c6', '[\"*\"]', '2025-03-26 20:49:01', NULL, '2025-03-26 20:48:11', '2025-03-26 20:49:01'),
(100, 'App\\Models\\User', 1, 'auth_token', '18ec4eb524e0e1bf70fb1720714d533e19b027f6f7d81bdce7c468fc63ac280a', '[\"*\"]', '2025-03-26 21:41:25', NULL, '2025-03-26 21:36:46', '2025-03-26 21:41:25'),
(101, 'App\\Models\\User', 1, 'auth_token', '98f7210e5b71e88c67af3925a4e9b1e67ade8e90198fe99c58462a812918afcf', '[\"*\"]', '2025-03-26 21:42:40', NULL, '2025-03-26 21:41:39', '2025-03-26 21:42:40'),
(102, 'App\\Models\\User', 1, 'auth_token', '556880bd8f5ac5cf496becc86e1ac9167903d67f7a262a34accad678dd0b21d3', '[\"*\"]', '2025-03-26 21:54:20', NULL, '2025-03-26 21:42:56', '2025-03-26 21:54:20'),
(103, 'App\\Models\\User', 1, 'auth_token', 'f7e7ba1024add3e94c23ae57c0880e3738409ab68583a6c5e67e30537fb157f6', '[\"*\"]', '2025-03-26 21:55:07', NULL, '2025-03-26 21:54:37', '2025-03-26 21:55:07'),
(104, 'App\\Models\\User', 1, 'auth_token', 'f8e15261ecb75d7f9f31108a78a51994bf0532a9e48ca91f2fdb785c9d72d979', '[\"*\"]', '2025-03-26 21:58:59', NULL, '2025-03-26 21:55:51', '2025-03-26 21:58:59'),
(105, 'App\\Models\\User', 1, 'auth_token', 'b78defa7b98b0cd30d564645b15944a9ef029762959527ddc071f0ccb66b067a', '[\"*\"]', '2025-04-08 00:57:39', NULL, '2025-03-26 21:59:32', '2025-04-08 00:57:39'),
(106, 'App\\Models\\User', 1, 'auth_token', 'cb095e98f76db55698e09bc3785b1fa3929942cca5e4f3663151c412077bd9bb', '[\"*\"]', NULL, NULL, '2025-04-07 19:17:02', '2025-04-07 19:17:02'),
(107, 'App\\Models\\User', 1, 'auth_token', '962afb730e6f5a705ebeb595cc0cb42a499edfa07d46119bc96aeb39d1c5635d', '[\"*\"]', NULL, NULL, '2025-04-07 19:17:28', '2025-04-07 19:17:28'),
(108, 'App\\Models\\User', 14, 'auth_token', 'bf014a6eb4503bc8d12712d90c22e39e9cde10a2a2dda51c8ea131bbfa829550', '[\"*\"]', NULL, NULL, '2025-04-07 19:19:33', '2025-04-07 19:19:33'),
(109, 'App\\Models\\User', 1, 'auth_token', '3725673b1464777143583ef5afc35b0f75dba431fde115884ea1e31d02ce948c', '[\"*\"]', '2025-04-08 01:04:25', NULL, '2025-04-08 01:01:46', '2025-04-08 01:04:25'),
(110, 'App\\Models\\User', 1, 'auth_token', 'fa00ed035b7dfdd1cc9ecd7e355a5aaadd02ae963421129e369a180d74777296', '[\"*\"]', '2025-04-08 01:08:14', NULL, '2025-04-08 01:04:52', '2025-04-08 01:08:14'),
(111, 'App\\Models\\User', 1, 'auth_token', '0ccbaed04c6e4d2dfd29e6dd98f71bd239491118275497dc329ee506702c1ae0', '[\"*\"]', '2025-04-08 01:11:29', NULL, '2025-04-08 01:08:29', '2025-04-08 01:11:29'),
(112, 'App\\Models\\User', 1, 'auth_token', '2c3d4da311fedddff07243dae953ca20ddb402d361fcfe995f20e1f2673c9b23', '[\"*\"]', '2025-04-08 01:34:19', NULL, '2025-04-08 01:24:47', '2025-04-08 01:34:19'),
(113, 'App\\Models\\User', 1, 'auth_token', '82a830e4b216b37f84a5c218fba1441d5f8f193484284f0b1d4e5a20c57fc0a5', '[\"*\"]', '2025-04-08 01:37:28', NULL, '2025-04-08 01:36:21', '2025-04-08 01:37:28'),
(114, 'App\\Models\\User', 1, 'auth_token', '775ee5a01d79084986ee814e70cff3031922bd969f1326fe1cb0ff4b7a15ef48', '[\"*\"]', '2025-04-08 01:38:40', NULL, '2025-04-08 01:37:44', '2025-04-08 01:38:40'),
(115, 'App\\Models\\User', 1, 'auth_token', 'cbb4803bd064d19d63398227281eb3fc050a5b07576a7d624f5ad81448e6f710', '[\"*\"]', '2025-04-08 01:38:55', NULL, '2025-04-08 01:38:47', '2025-04-08 01:38:55'),
(116, 'App\\Models\\User', 1, 'auth_token', '6f75f0876e3951805ddfdb95e2bd2762586ec2dcb4ae8e4e03922a9b28317b43', '[\"*\"]', '2025-04-08 01:53:57', NULL, '2025-04-08 01:51:19', '2025-04-08 01:53:57'),
(117, 'App\\Models\\User', 14, 'auth_token', '10c310719ac9649940437252689827521615936eff14a97876567d6e955061a4', '[\"*\"]', '2025-04-08 02:09:58', NULL, '2025-04-08 02:02:52', '2025-04-08 02:09:58'),
(118, 'App\\Models\\User', 14, 'auth_token', '3aa546d3419d285b3a8084cfe3aa7676e8a4da4d6d48d1288557cb3449178dac', '[\"*\"]', '2025-04-08 02:15:43', NULL, '2025-04-08 02:15:24', '2025-04-08 02:15:43'),
(119, 'App\\Models\\User', 1, 'auth_token', 'c369480b6b5fa87b6dcca87553c6f4625d448e91aaf5969c24972176458891fb', '[\"*\"]', '2025-04-08 02:27:34', NULL, '2025-04-08 02:27:12', '2025-04-08 02:27:34'),
(120, 'App\\Models\\User', 1, 'auth_token', '288751f3eaedfcb8c91d0ae720638766b325c30fd5649de6891b296dd8737a66', '[\"*\"]', '2025-04-08 02:31:57', NULL, '2025-04-08 02:31:56', '2025-04-08 02:31:57'),
(121, 'App\\Models\\User', 1, 'auth_token', 'd9ea12e273c67abbf98fea1d939ff241cfba063fa196454daa8abe75fc4adbc9', '[\"*\"]', '2025-04-08 02:37:44', NULL, '2025-04-08 02:33:43', '2025-04-08 02:37:44'),
(122, 'App\\Models\\User', 1, 'auth_token', '3548b78386434e2e527fe5b0ba9ef13ff97aa6bc4a2a11c88d9f8f65d9a284cf', '[\"*\"]', '2025-04-08 02:39:03', NULL, '2025-04-08 02:38:25', '2025-04-08 02:39:03'),
(123, 'App\\Models\\User', 1, 'auth_token', '41c46324fc2cb94ebd624bb89645097890b12ec49cb48c9abccf54fd986af8a2', '[\"*\"]', '2025-04-08 02:39:59', NULL, '2025-04-08 02:39:26', '2025-04-08 02:39:59'),
(124, 'App\\Models\\User', 14, 'auth_token', '48b48445903147bca8b11eb3e9c7112567822f47dc52e22b27b0bc7cf9817879', '[\"*\"]', '2025-04-08 02:45:52', NULL, '2025-04-08 02:40:25', '2025-04-08 02:45:52'),
(125, 'App\\Models\\User', 14, 'auth_token', '2b272d3defb1fa0ad27f4fd3d02badd9fcf2e23655a7adf94be5394ab4b1d435', '[\"*\"]', '2025-04-08 02:46:27', NULL, '2025-04-08 02:46:09', '2025-04-08 02:46:27'),
(126, 'App\\Models\\User', 1, 'auth_token', 'bbdc0c4234601151060c26f97a727f77b1ec4b0276748f9d83253985e9491ba2', '[\"*\"]', '2025-04-15 01:32:22', NULL, '2025-04-08 19:39:26', '2025-04-15 01:32:22'),
(127, 'App\\Models\\User', 1, 'auth_token', '04c4079c84c1857d2249009a579a3033ac05a9889a5b5300b5d2fceb65ba8216', '[\"*\"]', '2025-04-09 01:44:07', NULL, '2025-04-09 01:38:38', '2025-04-09 01:44:07'),
(128, 'App\\Models\\User', 1, 'auth_token', '75e43ebc98b6ecf9f8031330aa3fd6303ca08fc1feb31f92bfc18c81ab530110', '[\"*\"]', '2025-04-09 02:25:40', NULL, '2025-04-09 01:44:44', '2025-04-09 02:25:40'),
(129, 'App\\Models\\User', 1, 'auth_token', '9a1c3dfd81a746e0cd84260fd2f0fb264e0ee8e152c4c64532c641597137708b', '[\"*\"]', '2025-04-09 02:47:16', NULL, '2025-04-09 02:47:15', '2025-04-09 02:47:16'),
(130, 'App\\Models\\User', 1, 'auth_token', '0cbb6dcfff6e7973c66ba1c2cc92a6735e7d32b0f6e6c6d28d2836f493bc720f', '[\"*\"]', NULL, NULL, '2025-04-09 19:24:29', '2025-04-09 19:24:29'),
(131, 'App\\Models\\User', 1, 'auth_token', '934e48b3d0080eaeea8aa51d2a560391b96b6c08b649fc7f596215cbbe254e93', '[\"*\"]', '2025-04-09 20:03:34', NULL, '2025-04-09 19:55:01', '2025-04-09 20:03:34'),
(132, 'App\\Models\\User', 15, 'auth_token', '06d11913d81fa3ccc7f3d25ccdf32be99c26df64456503346df754df3c562622', '[\"*\"]', '2025-04-10 00:09:03', NULL, '2025-04-10 00:01:01', '2025-04-10 00:09:03'),
(133, 'App\\Models\\User', 1, 'auth_token', '1a84e6ec086d0ebd3495b9f78574a0ee7341fbdf740addcd67d76a05344fee49', '[\"*\"]', '2025-04-10 00:19:49', NULL, '2025-04-10 00:19:07', '2025-04-10 00:19:49'),
(134, 'App\\Models\\User', 1, 'auth_token', 'a3617d02a67c0a51c0cd620020a7bd263a78f05882688665d7a8fbf2fb100c87', '[\"*\"]', '2025-04-10 00:47:04', NULL, '2025-04-10 00:46:27', '2025-04-10 00:47:04'),
(135, 'App\\Models\\User', 1, 'auth_token', '95007e0e830593abf971f4d3df47b00f9c0f315662b0097c510a2f3b351182bb', '[\"*\"]', '2025-04-10 00:52:47', NULL, '2025-04-10 00:48:43', '2025-04-10 00:52:47'),
(136, 'App\\Models\\User', 1, 'auth_token', '1be34abfcda49151e2b30836100692cdf71b30ef0617576d3b6a3e5ef29fa3c9', '[\"*\"]', '2025-04-10 01:43:17', NULL, '2025-04-10 01:40:42', '2025-04-10 01:43:17'),
(137, 'App\\Models\\User', 1, 'auth_token', 'df3d29e7bfd4de1f59f9df5171c1f450d412978f1f4eb96c7096b20265ca9624', '[\"*\"]', '2025-04-10 01:50:29', NULL, '2025-04-10 01:43:48', '2025-04-10 01:50:29'),
(138, 'App\\Models\\User', 1, 'auth_token', '536d2c99f979547130c192a9e7e9698dc172278e3a92dbd6f1959f50b822784d', '[\"*\"]', '2025-04-10 02:34:33', NULL, '2025-04-10 02:33:27', '2025-04-10 02:34:33'),
(139, 'App\\Models\\User', 1, 'auth_token', 'e4e5f774e8c5d5f0b93d2e9eb6f5db7d827b79486a4c591068ad1d0450909971', '[\"*\"]', '2025-04-10 02:45:42', NULL, '2025-04-10 02:34:51', '2025-04-10 02:45:42'),
(140, 'App\\Models\\User', 1, 'auth_token', 'd9a87ef83998713730ea391995e838548155f88bc94a31c912200b21078aeffb', '[\"*\"]', '2025-04-10 02:50:33', NULL, '2025-04-10 02:45:59', '2025-04-10 02:50:33'),
(141, 'App\\Models\\User', 1, 'auth_token', 'c7bcde2997cf8e14e4d3c49eefd27bf326cfbe086e9c392a06225f71c6b934fa', '[\"*\"]', '2025-04-10 02:52:27', NULL, '2025-04-10 02:50:46', '2025-04-10 02:52:27'),
(142, 'App\\Models\\User', 1, 'auth_token', '74ba42d02c040ca97af7f6915b8d038db00ff601f1e009ec268eff0bd2c4b47e', '[\"*\"]', '2025-04-14 19:12:36', NULL, '2025-04-10 02:52:39', '2025-04-14 19:12:36'),
(143, 'App\\Models\\User', 17, 'auth_token', '9fabbf872e14cc129b60fb4f8b1edb7c4fbdaacc686798b73304e335fbd812ff', '[\"*\"]', NULL, NULL, '2025-04-10 19:50:40', '2025-04-10 19:50:40'),
(144, 'App\\Models\\User', 1, 'auth_token', '961d3aa7f174c0216ae24d44353e9b5e8531e2e42bbb811da5fcae6cb6018179', '[\"*\"]', '2025-04-14 00:32:57', NULL, '2025-04-14 00:18:24', '2025-04-14 00:32:57'),
(145, 'App\\Models\\User', 1, 'auth_token', '50351ae1e22b6803e2ab1c4c2f3d387429363fe3ea5b0132d99173e8b96b09d0', '[\"*\"]', '2025-04-14 20:48:19', NULL, '2025-04-14 19:12:50', '2025-04-14 20:48:19'),
(146, 'App\\Models\\User', 1, 'auth_token', 'fdb83f7e08b2413f26b0a2d1a050ce90a1d7900df174af1db015b85fb92d8c18', '[\"*\"]', '2025-04-14 20:52:49', NULL, '2025-04-14 20:48:40', '2025-04-14 20:52:49'),
(147, 'App\\Models\\User', 1, 'auth_token', '7c355fae4188f3493d298a7556b88f051a16d2c565adf490aeb5c9a7429b6ed6', '[\"*\"]', '2025-04-15 02:36:38', NULL, '2025-04-15 02:12:27', '2025-04-15 02:36:38'),
(148, 'App\\Models\\User', 1, 'auth_token', '2edd07f8b511435be90a39d1e6152c633ebe6f4c94cb6420d4a452758000090a', '[\"*\"]', '2025-04-15 02:55:12', NULL, '2025-04-15 02:36:54', '2025-04-15 02:55:12'),
(149, 'App\\Models\\User', 1, 'auth_token', '0b5ba1940efcae6f1527e92da323c1f01f2d39361e7ce8d5c1ff8186dbd3c766', '[\"*\"]', '2025-04-15 02:55:36', NULL, '2025-04-15 02:55:29', '2025-04-15 02:55:36'),
(150, 'App\\Models\\User', 1, 'auth_token', '6391105b29852f248d1bee3202a5219a7744c034e4b54e7de8081684ca4306b5', '[\"*\"]', '2025-04-15 02:57:33', NULL, '2025-04-15 02:55:46', '2025-04-15 02:57:33'),
(151, 'App\\Models\\User', 1, 'auth_token', '02c524881728e3c95f646edfebaa64e0048b59fc2c05efd712bcd2ed413ab861', '[\"*\"]', '2025-04-15 02:57:55', NULL, '2025-04-15 02:57:44', '2025-04-15 02:57:55'),
(152, 'App\\Models\\User', 1, 'auth_token', '4287930dd2f98353469985e955804117eafc1199447fe118804b5aa63b51504b', '[\"*\"]', '2025-04-16 01:56:20', NULL, '2025-04-16 01:51:14', '2025-04-16 01:56:20'),
(153, 'App\\Models\\User', 1, 'auth_token', '688348bc7dd9a83c924c467ae41790f1ee188f888b782de6e188e2335fb6fae0', '[\"*\"]', '2025-04-16 02:00:26', NULL, '2025-04-16 01:57:17', '2025-04-16 02:00:26'),
(154, 'App\\Models\\User', 1, 'auth_token', '75dc69b227a9388b8f3cf51a307a61e06699ca4e37dd45ac320ccc59c4ae85a5', '[\"*\"]', '2025-04-16 02:01:59', NULL, '2025-04-16 02:00:54', '2025-04-16 02:01:59'),
(155, 'App\\Models\\User', 1, 'auth_token', '6c7546e97ae7f9e8ba613d1e22dd7e5a727a3a1a8cf1a4b9a45dd12fdb9169b2', '[\"*\"]', '2025-04-16 02:08:13', NULL, '2025-04-16 02:02:15', '2025-04-16 02:08:13'),
(156, 'App\\Models\\User', 1, 'auth_token', '301026e2b7c7303545bee7814e9a16e89576cd92730443ea428a4452cbc28701', '[\"*\"]', '2025-04-16 02:39:31', NULL, '2025-04-16 02:28:14', '2025-04-16 02:39:31'),
(157, 'App\\Models\\User', 1, 'auth_token', '96cf8348e2d64aed7df51e67a3b29d3c0a64242bac6c1dabb531aa67d30fc486', '[\"*\"]', '2025-04-16 02:51:02', NULL, '2025-04-16 02:42:26', '2025-04-16 02:51:02'),
(158, 'App\\Models\\User', 1, 'auth_token', '5a40ae90d3d1576c09a04271ff2893b05601d463f75667472b0d8ec8ca845f6d', '[\"*\"]', '2025-04-16 08:27:59', NULL, '2025-04-16 02:53:32', '2025-04-16 08:27:59'),
(159, 'App\\Models\\User', 18, 'auth_token', 'cea15f74496424a3a35650375f21ae876b74dd8d729a3f2c0a0c9f8e0a9cf4b1', '[\"*\"]', '2025-04-16 07:16:31', NULL, '2025-04-16 07:15:04', '2025-04-16 07:16:31'),
(160, 'App\\Models\\User', 18, 'auth_token', 'da3a12c19651c98813d60a42a9e8a1ca382f75c142b349edba53f50e96776eae', '[\"*\"]', '2025-04-16 08:30:29', NULL, '2025-04-16 08:29:36', '2025-04-16 08:30:29'),
(161, 'App\\Models\\User', 19, 'auth_token', '6dec39f132d808133553fb7bf404db51bcc3983b8ee70ff0991b9339248f20bf', '[\"*\"]', '2025-04-16 08:44:46', NULL, '2025-04-16 08:32:38', '2025-04-16 08:44:46'),
(162, 'App\\Models\\User', 1, 'auth_token', '0194991b03dd70ba60a6289b9f137f670922dd74c2c125e4f88473b5ffb41bd2', '[\"*\"]', '2025-04-16 18:59:34', NULL, '2025-04-16 18:43:40', '2025-04-16 18:59:34'),
(163, 'App\\Models\\User', 18, 'auth_token', 'b6083726b197eb453239fbf544956bd00b5249eb717f1531dfdd68adea9c41ee', '[\"*\"]', '2025-04-16 19:02:08', NULL, '2025-04-16 19:00:36', '2025-04-16 19:02:08'),
(164, 'App\\Models\\User', 17, 'auth_token', 'e015eb15994ce7211a486575ddaf283d72ac545c692706c6b7fa8054ee186e7e', '[\"*\"]', '2025-04-16 19:12:12', NULL, '2025-04-16 19:11:46', '2025-04-16 19:12:12'),
(165, 'App\\Models\\User', 17, 'auth_token', '06a01963c3f92f6c2568b74514c10f26a0786a8ca839d3929dac8090823eb5ac', '[\"*\"]', '2025-04-16 19:20:16', NULL, '2025-04-16 19:12:31', '2025-04-16 19:20:16'),
(166, 'App\\Models\\User', 20, 'auth_token', 'eb7b3292f3fad01aec745c02ae1fd05b13b3400f31bf4e08bb492efaa1d1afb0', '[\"*\"]', '2025-04-16 19:23:28', NULL, '2025-04-16 19:22:03', '2025-04-16 19:23:28'),
(167, 'App\\Models\\User', 17, 'auth_token', '1d3a74b2567745df3ba426fc97c8a6a173e5a82b1e4e153fddf696e72bb59b14', '[\"*\"]', '2025-04-16 19:36:51', NULL, '2025-04-16 19:23:47', '2025-04-16 19:36:51'),
(168, 'App\\Models\\User', 18, 'auth_token', 'cf49a823b34566adfe2f51a4298d03a8a26396c7e42f3fb1fd4a4b032c779b31', '[\"*\"]', '2025-04-16 19:36:14', NULL, '2025-04-16 19:35:47', '2025-04-16 19:36:14'),
(169, 'App\\Models\\User', 17, 'auth_token', '91f5c169e02a9a31d16914095a35189f662b3f2fa20beec3f1c244441338a3e6', '[\"*\"]', '2025-04-16 19:47:23', NULL, '2025-04-16 19:38:43', '2025-04-16 19:47:23'),
(170, 'App\\Models\\User', 17, 'auth_token', '8cf8da67452bd233f468aa2f33ac3c5b1ab4be24eacb5a88f7e3502ecca48f79', '[\"*\"]', '2025-04-16 20:14:48', NULL, '2025-04-16 19:47:52', '2025-04-16 20:14:48'),
(171, 'App\\Models\\User', 17, 'auth_token', '52653d2326cc09682ba7616e4a42fbc751cef118365a9aebc22970f6fdef6ec1', '[\"*\"]', '2025-04-16 20:20:38', NULL, '2025-04-16 20:20:37', '2025-04-16 20:20:38'),
(172, 'App\\Models\\User', 1, 'auth_token', 'f52c1fd564001acf78847b8b4fc35d38664f727d47d6123af139e0a7c8ea6b8d', '[\"*\"]', '2025-04-16 23:46:08', NULL, '2025-04-16 23:46:02', '2025-04-16 23:46:08'),
(173, 'App\\Models\\User', 21, 'auth_token', '85043162285f0d3dd0b23ea9f79bdcf64cbf5d36e5bb98aee016139e0c6c0a9f', '[\"*\"]', '2025-04-17 00:17:28', NULL, '2025-04-16 23:46:37', '2025-04-17 00:17:28'),
(174, 'App\\Models\\User', 1, 'auth_token', '8a663417ac3185dc23e46fd437c328061b0d2f30fc65bcda679f7a86745b1d06', '[\"*\"]', '2025-04-17 00:52:30', NULL, '2025-04-17 00:52:26', '2025-04-17 00:52:30'),
(175, 'App\\Models\\User', 21, 'auth_token', '65faa6fc92001b96cdc5d88f20124d86618493c20f69253f72e63f238e12a414', '[\"*\"]', '2025-04-17 02:24:43', NULL, '2025-04-17 00:54:22', '2025-04-17 02:24:43'),
(176, 'App\\Models\\User', 22, 'auth_token', '5d3a19b04d5913076d1584890c398e5c6aafd5493aa2d4bd4d2be81fbc5c8630', '[\"*\"]', '2025-04-27 06:32:20', NULL, '2025-04-21 20:41:28', '2025-04-27 06:32:20'),
(177, 'App\\Models\\User', 22, 'auth_token', '2f465826fa9a4f2896e1a5d86e5be375185f10eb2eff9ee7bc5bebe5e5b16160', '[\"*\"]', '2025-04-27 06:57:46', NULL, '2025-04-27 06:34:26', '2025-04-27 06:57:46'),
(178, 'App\\Models\\User', 22, 'auth_token', 'e0e3ad94356d1d4992a041e0c0cc7c238936cc509638a53dbc9b56be4475fc44', '[\"*\"]', '2025-04-28 20:13:37', NULL, '2025-04-27 07:03:46', '2025-04-28 20:13:37'),
(179, 'App\\Models\\User', 22, 'auth_token', 'c0693cdd418c0c7a0c55e9cf8b86ad172e768825070d03809bc14384bc38959d', '[\"*\"]', '2025-04-28 01:25:40', NULL, '2025-04-28 01:21:05', '2025-04-28 01:25:40'),
(180, 'App\\Models\\User', 1, 'auth_token', 'e3b642354877088329515bfeef77c79235e4a11bdb946e3dd66a2521beced3f4', '[\"*\"]', '2025-04-28 21:44:47', NULL, '2025-04-28 20:46:15', '2025-04-28 21:44:47'),
(181, 'App\\Models\\User', 17, 'auth_token', '376b35a06355477bb0504492828a16308dc30746b934487cc6332dfd1270a4e5', '[\"*\"]', '2025-04-28 21:01:30', NULL, '2025-04-28 21:01:13', '2025-04-28 21:01:30'),
(182, 'App\\Models\\User', 1, 'auth_token', '6e0f20be16ece1625c1c102b60cde200b91eb5a69d027234232be7f965b58d10', '[\"*\"]', '2025-04-28 21:51:23', NULL, '2025-04-28 21:51:15', '2025-04-28 21:51:23'),
(183, 'App\\Models\\User', 1, 'auth_token', '3992ca0c31ec492383ef361b8d03f0c9af9c08332fd49e3190023202b1d324e4', '[\"*\"]', '2025-04-29 02:05:31', NULL, '2025-04-28 23:45:23', '2025-04-29 02:05:31'),
(184, 'App\\Models\\User', 1, 'auth_token', 'f9cc03f82d75ef18c8dd9b694dfe078dc108f0bed2ff7b13fd71d21a93f1862c', '[\"*\"]', '2025-04-29 01:24:24', NULL, '2025-04-29 00:22:08', '2025-04-29 01:24:24'),
(185, 'App\\Models\\User', 1, 'auth_token', 'f6322d8478c9c1fba918d59b309e949af769970844d11cbd5b24133935164be0', '[\"*\"]', '2025-04-29 01:27:00', NULL, '2025-04-29 01:26:50', '2025-04-29 01:27:00'),
(186, 'App\\Models\\User', 21, 'auth_token', '2aa3579873d15acfca352729c6f05a97daff95eca79537fd96e37e294c2d7a62', '[\"*\"]', '2025-04-29 01:34:13', NULL, '2025-04-29 01:34:11', '2025-04-29 01:34:13'),
(187, 'App\\Models\\User', 1, 'auth_token', 'b4a9c1090291be3109ddabde9352efc64e68384bd7ea21d3af48401a0be24ce7', '[\"*\"]', '2025-04-29 01:39:37', NULL, '2025-04-29 01:39:31', '2025-04-29 01:39:37'),
(188, 'App\\Models\\User', 23, 'auth_token', 'fad35f70c0fecb3843878a43fa2b9002b48762c78c09e009bc454a44bd8db9bd', '[\"*\"]', '2025-04-29 02:16:15', NULL, '2025-04-29 01:47:23', '2025-04-29 02:16:15'),
(189, 'App\\Models\\User', 17, 'auth_token', '7265fcd3cca33c9ab753fc9bdcf25ad0d19ccfe28a89ac077b0fd13ba95e2de1', '[\"*\"]', '2025-04-29 01:54:25', NULL, '2025-04-29 01:54:07', '2025-04-29 01:54:25'),
(190, 'App\\Models\\User', 23, 'auth_token', '3b288f042b27b3c5f7ca59685ca57b2519ebd9dc38569fa7234f0818bf6724b0', '[\"*\"]', '2025-04-29 01:55:13', NULL, '2025-04-29 01:55:09', '2025-04-29 01:55:13'),
(191, 'App\\Models\\User', 1, 'auth_token', '2a1665b283a35dea2633aab67c144742c5c1375236bcb9a8f68f78b6a7fb2384', '[\"*\"]', '2025-04-29 02:21:17', NULL, '2025-04-29 02:17:04', '2025-04-29 02:21:17'),
(192, 'App\\Models\\User', 23, 'auth_token', 'ee8b0980d9bc49fd657bc2fe944d82beadd29ff0bcb24a30a9ef66dee3046a2d', '[\"*\"]', '2025-04-29 02:27:00', NULL, '2025-04-29 02:17:46', '2025-04-29 02:27:00'),
(193, 'App\\Models\\User', 1, 'auth_token', '77abb1403dc576aefa69494a8ac12b22bad0eb647a6633a425c337e8ee5401ee', '[\"*\"]', '2025-04-29 02:31:53', NULL, '2025-04-29 02:30:46', '2025-04-29 02:31:53'),
(195, 'App\\Models\\User', 1, 'auth_token', 'b7e2ebc07ea1bb9f0be221429b9fb009de9e37947c0b50e2542b84331317ee78', '[\"*\"]', '2025-05-02 19:50:35', NULL, '2025-05-02 19:50:01', '2025-05-02 19:50:35'),
(196, 'App\\Models\\User', 1, 'auth_token', '97d2c55687a53a3bd88f13eab9205fdae06d92c52dd34db92ec1812a1998099e', '[\"*\"]', '2025-05-02 21:58:08', NULL, '2025-05-02 21:57:59', '2025-05-02 21:58:08'),
(197, 'App\\Models\\User', 1, 'auth_token', '2530b5a4a4a25ebb9886862c1c8ce363c8fdd3b756f81431b9806792db9c5489', '[\"*\"]', '2025-05-03 00:01:15', NULL, '2025-05-03 00:00:23', '2025-05-03 00:01:15'),
(198, 'App\\Models\\User', 1, 'auth_token', '4e78a6674567e4a7432f482c2ad1785ec2e7f4fffaa0d7da3826f8a150ca80af', '[\"*\"]', '2025-05-04 20:09:54', NULL, '2025-05-04 20:05:47', '2025-05-04 20:09:54'),
(199, 'App\\Models\\User', 1, 'auth_token', '086ed9cdb732097fa7c5587e2ecfd17679ccc4dadefdd4977e7a83aac9a672ed', '[\"*\"]', '2025-05-06 00:12:22', NULL, '2025-05-06 00:04:39', '2025-05-06 00:12:22'),
(200, 'App\\Models\\User', 1, 'auth_token', '999709eb3d2deddfca7dda8585bd8412c47f30593f03aefb822b941706536807', '[\"*\"]', '2025-05-06 00:24:08', NULL, '2025-05-06 00:24:07', '2025-05-06 00:24:08'),
(201, 'App\\Models\\User', 24, 'auth_token', '999a9823ac2ac8877b20cb0fdf99e8bf09214d6290e914d63605e170a16ea6f8', '[\"*\"]', '2025-05-06 00:32:14', NULL, '2025-05-06 00:30:59', '2025-05-06 00:32:14'),
(202, 'App\\Models\\User', 25, 'auth_token', '22b08d13aa7cbead241678cf839302775a3797971518c26ebde84801714e93ba', '[\"*\"]', '2025-05-06 01:00:40', NULL, '2025-05-06 00:58:39', '2025-05-06 01:00:40'),
(203, 'App\\Models\\User', 17, 'auth_token', '64fe1330201d50623f9b5c879c154cee58c495a1dd1cca0614c7ea25ae9d0f69', '[\"*\"]', '2025-05-06 01:01:14', NULL, '2025-05-06 01:00:58', '2025-05-06 01:01:14'),
(204, 'App\\Models\\User', 1, 'auth_token', 'e2a2247e524d083483db3e64b516b6ff796606366d4bc1ad42ac65cfae66a000', '[\"*\"]', '2025-05-06 01:21:17', NULL, '2025-05-06 01:16:24', '2025-05-06 01:21:17'),
(205, 'App\\Models\\User', 1, 'auth_token', '16e8dd2c1a341a724307dd655f8f191561d463f7f838b2a27a37948857a6b10e', '[\"*\"]', '2025-05-06 01:25:43', NULL, '2025-05-06 01:25:41', '2025-05-06 01:25:43'),
(206, 'App\\Models\\User', 24, 'auth_token', '007b3469312664ad14c937e241f8406f9f71562c6051fff06d042f6cdcbc9641', '[\"*\"]', '2025-05-06 01:54:13', NULL, '2025-05-06 01:37:43', '2025-05-06 01:54:13'),
(207, 'App\\Models\\User', 1, 'auth_token', 'a18fe17eb11f3e9e6de80a4e38f8f0f0a53c0d7aba5e662237f83931c3a16e8e', '[\"*\"]', '2025-05-06 01:54:42', NULL, '2025-05-06 01:54:37', '2025-05-06 01:54:42'),
(208, 'App\\Models\\User', 1, 'auth_token', '915a6397a2b32a35dfe5aca69fe586de4e1936de6c78fb9898882e4a319b7d53', '[\"*\"]', '2025-05-06 02:39:31', NULL, '2025-05-06 02:34:44', '2025-05-06 02:39:31'),
(209, 'App\\Models\\User', 1, 'auth_token', '3fcb9dd9c0c37c14719ff15dc364649f7248e85335f29497a859000321098577', '[\"*\"]', '2025-05-07 18:11:54', NULL, '2025-05-07 18:06:41', '2025-05-07 18:11:54'),
(210, 'App\\Models\\User', 1, 'auth_token', '6e442846d8e9b7dddfe1948ab1bd7e57e837166a78ca42ea50cd22c48b5790d5', '[\"*\"]', '2025-05-07 18:34:55', NULL, '2025-05-07 18:28:09', '2025-05-07 18:34:55'),
(211, 'App\\Models\\User', 1, 'auth_token', '0c18d238b6acb9afc596a940537e26615178bfc1a169db271053aa06fba353c5', '[\"*\"]', '2025-05-07 19:00:41', NULL, '2025-05-07 19:00:36', '2025-05-07 19:00:41'),
(212, 'App\\Models\\User', 1, 'auth_token', '966b8a21c57b14bcff5ac5c77acd71699ef6f78146af3a8c0d50edd66fafb408', '[\"*\"]', '2025-05-07 19:27:46', NULL, '2025-05-07 19:15:10', '2025-05-07 19:27:46'),
(213, 'App\\Models\\User', 21, 'auth_token', '4adb445eadffc00a0da7f2e1a2c59e9dff97632dff2957f0360bc2894c276466', '[\"*\"]', '2025-05-07 19:47:18', NULL, '2025-05-07 19:47:15', '2025-05-07 19:47:18'),
(214, 'App\\Models\\User', 1, 'auth_token', 'ab3ec729013aa62dd1d13779f04cbeeecf67f301eb0324eb2f12ab4e6b49c0ae', '[\"*\"]', '2025-05-07 19:50:39', NULL, '2025-05-07 19:50:34', '2025-05-07 19:50:39'),
(215, 'App\\Models\\User', 1, 'auth_token', 'd160b88049989e5e71553bc7fb994587f6a1c11179b4aacde8f907a440e01266', '[\"*\"]', '2025-05-07 20:34:39', NULL, '2025-05-07 20:08:32', '2025-05-07 20:34:39'),
(216, 'App\\Models\\User', 1, 'auth_token', '489c504aefc28941d6546e325e10ee4b72e19794a1047a971c7c533da770f780', '[\"*\"]', '2025-05-07 21:44:46', NULL, '2025-05-07 21:26:41', '2025-05-07 21:44:46'),
(217, 'App\\Models\\User', 1, 'auth_token', '50c5dcc0534f1b5dc74602d1c93df37239c7b5a74099224b76b826f0460677a9', '[\"*\"]', '2025-05-07 21:54:49', NULL, '2025-05-07 21:50:07', '2025-05-07 21:54:49'),
(218, 'App\\Models\\User', 1, 'auth_token', '3b177448f0b15b28f7c6e0c5cba270f59a09fa9539d71a14843b1f69311f424a', '[\"*\"]', '2025-05-07 23:24:25', NULL, '2025-05-07 23:14:32', '2025-05-07 23:24:25'),
(219, 'App\\Models\\User', 1, 'auth_token', 'f53fead34be863b05f17b9c5169f03aed17b97f89788e6402398363d35c928b2', '[\"*\"]', '2025-05-07 23:39:41', NULL, '2025-05-07 23:32:31', '2025-05-07 23:39:41'),
(220, 'App\\Models\\User', 21, 'auth_token', '9d8927b5d5f6915c84558564cf54f9b270924c3b3ae0bf8000427fc970ef16cc', '[\"*\"]', '2025-05-08 00:21:05', NULL, '2025-05-08 00:05:27', '2025-05-08 00:21:05'),
(221, 'App\\Models\\User', 1, 'auth_token', 'a94b0d305da4a59563a5491afa4ee433692a589fb53b1291e344af6380d04027', '[\"*\"]', '2025-05-08 00:40:52', NULL, '2025-05-08 00:23:29', '2025-05-08 00:40:52'),
(222, 'App\\Models\\User', 21, 'auth_token', 'f73fee34ff1c2cd63b5a5c17409b7fa9f9f3cec034de3486ec21fab66bbcea45', '[\"*\"]', '2025-05-08 01:07:58', NULL, '2025-05-08 00:41:16', '2025-05-08 01:07:58'),
(223, 'App\\Models\\User', 21, 'auth_token', '5d25219cea08cb97987e59235b59e6c29743347499d2888bd878a8c9656142da', '[\"*\"]', '2025-05-08 01:47:26', NULL, '2025-05-08 01:11:10', '2025-05-08 01:47:26'),
(224, 'App\\Models\\User', 1, 'auth_token', '23064abe3a08e674e08869fde6f7e47f6602644084c3346f6b0eb6c4c591ac3c', '[\"*\"]', '2025-05-08 01:48:32', NULL, '2025-05-08 01:48:31', '2025-05-08 01:48:32'),
(225, 'App\\Models\\User', 22, 'auth_token', 'e13c2c8a22be5e04014c2066dac6b9ad3962d3ea1d0919a34379efd603200cad', '[\"*\"]', '2025-05-08 02:52:02', NULL, '2025-05-08 02:04:46', '2025-05-08 02:52:02'),
(226, 'App\\Models\\User', 22, 'auth_token', '9007dc28deb38e9d053b1bbb095c92a31c9dbfff17d564460765c365cfa6ad17', '[\"*\"]', '2025-05-12 06:57:07', NULL, '2025-05-08 02:26:38', '2025-05-12 06:57:07'),
(227, 'App\\Models\\User', 22, 'auth_token', 'fde18f3bb377ffaf508c27d0a149e8087a771d583fac4eec5b6e180513deb85f', '[\"*\"]', '2025-05-13 19:48:25', NULL, '2025-05-08 19:53:44', '2025-05-13 19:48:25'),
(228, 'App\\Models\\User', 22, 'auth_token', '813a8a943912f7e5c3f33c21bf4eca5a4f5055104046d0098e6595d56bede38b', '[\"*\"]', '2025-05-13 20:02:02', NULL, '2025-05-12 06:57:38', '2025-05-13 20:02:02'),
(229, 'App\\Models\\User', 21, 'auth_token', '684af928333dba74924864866f12dc83e4d194d8a40d22ad91b639687108730c', '[\"*\"]', '2025-05-13 20:11:59', NULL, '2025-05-13 19:50:27', '2025-05-13 20:11:59'),
(230, 'App\\Models\\User', 21, 'auth_token', '5a5e93fa28530a005f5edd171b65fad24dda8834b8a2d5e5c173375ba5166ec2', '[\"*\"]', '2025-05-14 01:58:48', NULL, '2025-05-13 20:01:08', '2025-05-14 01:58:48'),
(231, 'App\\Models\\User', 22, 'auth_token', '5b76d69f9b873549bed8d3bbce84d00e890fe24934c7ae2b5ea2d91600a51abd', '[\"*\"]', '2025-05-13 20:14:41', NULL, '2025-05-13 20:12:15', '2025-05-13 20:14:41'),
(232, 'App\\Models\\User', 21, 'auth_token', '0e2b97578e34b4394a53a46d5efc58ea739dceabe2542ed664e1d6f466d85bbc', '[\"*\"]', '2025-05-13 20:45:19', NULL, '2025-05-13 20:15:06', '2025-05-13 20:45:19'),
(233, 'App\\Models\\User', 22, 'auth_token', 'df9fa20bc9b3e1cb5f9c9523d266bdd2599359a3ba87b6c841e34d58790e08aa', '[\"*\"]', '2025-05-13 20:55:21', NULL, '2025-05-13 20:45:39', '2025-05-13 20:55:21'),
(234, 'App\\Models\\User', 22, 'auth_token', '8c68e139dcc828270e7754910bb03fb1c770421548cfd903bb7f82618ac201d3', '[\"*\"]', '2025-05-13 21:48:10', NULL, '2025-05-13 21:27:13', '2025-05-13 21:48:10'),
(235, 'App\\Models\\User', 22, 'auth_token', '1743f216601ec6f7c32bd9339a6df3c7ea1741cdf0e00b93e69162448c03c1ae', '[\"*\"]', '2025-05-14 03:33:13', NULL, '2025-05-14 01:57:43', '2025-05-14 03:33:13'),
(236, 'App\\Models\\User', 22, 'auth_token', 'd88cee7379942028452462687d70078270048d7d1ca8ae4be40c6361c37625ac', '[\"*\"]', '2025-05-14 02:51:55', NULL, '2025-05-14 01:59:20', '2025-05-14 02:51:55'),
(237, 'App\\Models\\User', 22, 'auth_token', '98590c8338f8608d0c0449ca879286dabbfb94e04d134e8cb70501422ad2e157', '[\"*\"]', '2025-05-14 08:11:55', NULL, '2025-05-14 08:06:28', '2025-05-14 08:11:55');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pesanan`
--

CREATE TABLE `pesanan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kode_transaksi` varchar(255) NOT NULL,
  `id_produk` bigint(20) UNSIGNED NOT NULL,
  `id_user` bigint(20) UNSIGNED NOT NULL,
  `id_toko` bigint(20) UNSIGNED NOT NULL,
  `id_pesanan_kiloan` bigint(20) UNSIGNED DEFAULT NULL,
  `nama_produk` varchar(255) NOT NULL,
  `harga` decimal(8,2) DEFAULT NULL,
  `subtotal` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `kategori` varchar(255) NOT NULL,
  `status` enum('Menunggu','Diproses','Selesai','Ditolak') NOT NULL DEFAULT 'Menunggu',
  `catatan` text DEFAULT NULL,
  `layanan_tambahan` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `pesanan`
--

INSERT INTO `pesanan` (`id`, `kode_transaksi`, `id_produk`, `id_user`, `id_toko`, `id_pesanan_kiloan`, `nama_produk`, `harga`, `subtotal`, `quantity`, `kategori`, `status`, `catatan`, `layanan_tambahan`, `created_at`, `updated_at`) VALUES
(104, 'TRX-68237417E2BFA', 3, 22, 1, 11, 'Bed Cover', 30000.00, 30000, 1, 'Satuan', 'Diproses', NULL, NULL, '2025-05-13 09:32:23', '2025-05-13 09:35:34'),
(105, 'TRX-68237417E2BFA', 7, 22, 1, 11, 'Gorden', 15000.00, 30000, 2, 'Satuan', 'Diproses', NULL, NULL, '2025-05-13 09:32:23', '2025-05-13 09:35:34'),
(106, 'TRX-68237417E2BFA', 18, 22, 1, 11, 'Karpet', 40000.00, 40000, 1, 'Satuan', 'Diproses', NULL, NULL, '2025-05-13 09:32:23', '2025-05-13 09:35:34'),
(107, 'TRX-68237A38B1C3E', 5, 22, 1, 12, 'Jas', 30000.00, 30000, 1, 'Satuan', 'Diproses', NULL, NULL, '2025-05-13 09:58:32', '2025-05-13 10:29:48'),
(108, 'TRX-68237A38B1C3E', 16, 22, 1, 12, 'Dress', 15000.00, 60000, 4, 'Satuan', 'Diproses', NULL, NULL, '2025-05-13 09:58:32', '2025-05-13 10:29:48'),
(109, 'TRX-682404625F532', 3, 22, 1, NULL, 'Bed Cover', 30000.00, 30000, 1, 'Satuan', 'Diproses', NULL, NULL, '2025-05-13 19:48:02', '2025-05-14 02:57:41'),
(110, 'TRX-682404625F532', 17, 22, 1, NULL, 'Sepatu', 15000.00, 30000, 2, 'Satuan', 'Diproses', NULL, NULL, '2025-05-13 19:48:02', '2025-05-14 02:57:41'),
(111, 'TRX-6824053848E63', 3, 21, 1, 13, 'Bed Cover', 30000.00, 30000, 1, 'Satuan', 'Ditolak', NULL, NULL, '2025-05-13 19:51:36', '2025-05-13 20:14:33'),
(112, 'TRX-6824053848E63', 16, 21, 1, 13, 'Dress', 15000.00, 30000, 2, 'Satuan', 'Ditolak', NULL, NULL, '2025-05-13 19:51:36', '2025-05-13 20:14:33'),
(113, 'TRX-682411F43906D', 5, 22, 1, 14, 'Jas', 30000.00, 60000, 2, 'Satuan', 'Ditolak', NULL, NULL, '2025-05-13 20:45:56', '2025-05-14 02:56:57'),
(114, 'TRX-682411F43906D', 7, 22, 1, 14, 'Gorden', 15000.00, 15000, 1, 'Satuan', 'Ditolak', NULL, NULL, '2025-05-13 20:45:56', '2025-05-14 02:56:57'),
(115, 'TRX-682411F43906D', 16, 22, 1, 14, 'Dress', 15000.00, 15000, 1, 'Satuan', 'Ditolak', NULL, NULL, '2025-05-13 20:45:56', '2025-05-14 02:56:57');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pesanan_kiloan`
--

CREATE TABLE `pesanan_kiloan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `jumlah_kiloan` decimal(8,2) DEFAULT NULL,
  `harga_kiloan` decimal(10,0) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `pesanan_kiloan`
--

INSERT INTO `pesanan_kiloan` (`id`, `jumlah_kiloan`, `harga_kiloan`, `created_at`, `updated_at`) VALUES
(11, NULL, NULL, '2025-05-13 09:32:23', '2025-05-13 09:32:23'),
(12, 2.00, 14000, '2025-05-13 09:58:32', '2025-05-13 10:29:33'),
(13, 1.00, 7000, '2025-05-13 19:51:36', '2025-05-13 20:14:25'),
(14, NULL, NULL, '2025-05-13 20:45:56', '2025-05-13 20:45:56');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pesanan_kiloan_details`
--

CREATE TABLE `pesanan_kiloan_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_pesanan_kiloan` bigint(20) UNSIGNED NOT NULL,
  `id_produk` bigint(20) UNSIGNED DEFAULT NULL,
  `nama_barang` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `pesanan_kiloan_details`
--

INSERT INTO `pesanan_kiloan_details` (`id`, `id_pesanan_kiloan`, `id_produk`, `nama_barang`, `created_at`, `updated_at`, `quantity`) VALUES
(10, 11, 19, 'Baju', '2025-05-13 09:32:23', '2025-05-13 09:32:23', 4),
(11, 12, 19, 'Baju', '2025-05-13 09:58:32', '2025-05-13 09:58:32', 2),
(12, 13, 19, 'Baju', '2025-05-13 19:51:36', '2025-05-13 19:51:36', 5),
(13, 14, 19, 'Baju', '2025-05-13 20:45:56', '2025-05-13 20:45:56', 3);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pesanan_layanan_tambahan`
--

CREATE TABLE `pesanan_layanan_tambahan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_pesanan` bigint(20) UNSIGNED NOT NULL,
  `id_layanan` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `produks`
--

CREATE TABLE `produks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `harga` decimal(10,0) DEFAULT NULL,
  `id_user` bigint(20) UNSIGNED NOT NULL,
  `id_toko` bigint(20) UNSIGNED NOT NULL,
  `id_kategori` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `produks`
--

INSERT INTO `produks` (`id`, `nama`, `harga`, `id_user`, `id_toko`, `id_kategori`, `created_at`, `updated_at`) VALUES
(3, 'Bed Cover', 30000, 1, 1, 1, '2025-04-28 21:44:47', '2025-04-28 21:44:47'),
(5, 'Jas', 30000, 1, 1, 1, '2025-04-29 00:23:01', '2025-04-29 00:23:01'),
(7, 'Gorden', 15000, 1, 1, 1, '2025-04-29 00:37:30', '2025-04-29 00:37:30'),
(9, 'Training Pack', 10000, 1, 1, 1, '2025-04-29 00:49:06', '2025-04-29 00:49:06'),
(16, 'Dress', 15000, 1, 1, 1, '2025-05-03 00:01:15', '2025-05-03 00:01:15'),
(17, 'Sepatu', 15000, 1, 1, 1, '2025-05-06 01:16:54', '2025-05-06 01:16:54'),
(18, 'Karpet', 40000, 1, 1, 1, '2025-05-07 21:44:25', '2025-05-07 21:44:25'),
(19, 'Baju', NULL, 1, 1, 2, '2025-05-08 00:40:52', '2025-05-08 00:40:52');

-- --------------------------------------------------------

--
-- Struktur dari tabel `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('0ciTkM0LMOj0OP4VC0OjnrinhlI028jchu4sQ2Vt', NULL, '127.0.0.1', 'PostmanRuntime/7.43.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiQlYxMTJ6Y3MyU0FpaDlNZWRmSlhaYWxHdUw0anMzZjFmUm4wb0JGdSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9zYW5jdHVtL2NzcmYtY29va2llIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1741072279),
('FSnpN33z9pXO1BReKfPawmboUd5H5r3XL5FPHt7k', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiN1hvTVV1dHNkSkJRQ1oxdFdMWkoybWNVYkhvVXIzSlIxYVVaTUU4cCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1742866663),
('MtB6H0rDNlHPl4EuqMmGoHxF4PpWqwVDOS8a6KTt', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiT09kOGV6TE5SM1Z0S2t5TUNOOVNkYjQzckdaS3pVajFMY0p5eG1qTCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1741071122),
('srPjsQBKeS7iwfVo2QtsHIC3ilKK06opma2JGSrK', NULL, '127.0.0.1', 'PostmanRuntime/7.43.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoidHI4bnNXcFJVdnB1dUxCS0owYWdrWTBQczRrc2JtZWpOYkFKajhLMCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9zYW5jdHVtL2NzcmYtY29va2llIjt9fQ==', 1741069721),
('Xggl5PTpsQUPSuWHqq2RbdPxVCvDi52BTUdLdqQI', NULL, '127.0.0.1', 'PostmanRuntime/7.43.0', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiaklDaTA1OUY5cHNqakExS3VaOERZVTE4NlhSWkxvTlZNWVV2bUo1byI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1741092826);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tokos`
--

CREATE TABLE `tokos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `userID` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `noTelp` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `deskripsi` text NOT NULL,
  `jalan` varchar(255) NOT NULL,
  `kecamatan` varchar(255) NOT NULL,
  `kabupaten` varchar(255) NOT NULL,
  `provinsi` varchar(255) NOT NULL,
  `waktuBuka` time NOT NULL,
  `waktuTutup` time NOT NULL,
  `buktiBayar` varchar(255) DEFAULT NULL,
  `status` enum('Belum Bayar','Menunggu','Diterima','Ditolak') NOT NULL DEFAULT 'Belum Bayar',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `tokos`
--

INSERT INTO `tokos` (`id`, `userID`, `nama`, `noTelp`, `email`, `deskripsi`, `jalan`, `kecamatan`, `kabupaten`, `provinsi`, `waktuBuka`, `waktuTutup`, `buktiBayar`, `status`, `created_at`, `updated_at`) VALUES
(1, 22, 'Gabriel', '082163525576', 'gabrielsiregar758@gmail.com', 'Toko Laundry terdekat pilihanmu', 'Jl.PI Del', 'Laguboti', 'Toba', 'Sumatera Utara', '08:00:00', '19:00:00', '', 'Diterima', '2025-04-14 00:30:29', '2025-04-22 06:55:35'),
(12, 21, 'Joy Laundry', '085236907412', 'joylaundry@gmail.com', 'Shehehwhw', 'NB', 'Balige', 'Toba', 'Sumatera Utara', '07:00:00', '20:00:00', 'http://192.168.233.197:8000/storage/bukti_pembayaran/1744881550_LX4ouc981q.jpg', 'Ditolak', '2025-04-17 02:18:36', '2025-04-28 21:01:30'),
(14, 23, 'Natasya Laundry', '082233116644', 'natasyalaundry@gmail.com', 'Natasya laundry hadir', 'Jl.Laguboti', 'Laguboti', 'Toba', 'Sumatera Utara', '08:00:00', '15:00:00', 'http://192.168.7.197:8000/storage/bukti_pembayaran/1745916818_7d0uaBwUmx.jpg', 'Diterima', '2025-04-29 01:49:58', '2025-04-29 01:54:25'),
(15, 25, 'Noel Laundry', '08523164970855', 'noellaundry@gmail.com', 'Oke', 'Jl.Tangsi', 'TARUTUNG', 'KABUPATEN TAPANULI UTARA', 'SUMATERA UTARA', '07:00:00', '20:00:00', 'http://192.168.7.197:8000/storage/bukti_pembayaran/1746518437_vEL34k4JiN.jpg', 'Diterima', '2025-05-06 01:00:19', '2025-05-06 01:01:14'),
(16, 18, 'NoelNoe', '018233823838', 'apalah@gmail.com', 'yap', 'Jl. Sisimangaraja', 'TARUTUNG', 'KABUPATEN TAPANULI UTARA', 'SUMATERA UTARA', '12:00:00', '15:15:00', 'http://192.168.84.200:8000/storage/bukti_pembayaran/1747058594_Ro4UiGMiWY.jpg', 'Diterima', '2025-05-12 07:03:05', '2025-05-12 07:03:15');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `noTelp` varchar(14) NOT NULL,
  `profile_image` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'user',
  `fcm_token` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `noTelp`, `profile_image`, `email_verified_at`, `password`, `role`, `fcm_token`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Gabriel', 'Gabriel@gmail.com', '082163525576', 'http://192.168.7.197:8000/storage/profile_images/1745914823_Hov8t1D245.jpg', NULL, '$2y$12$1oDPa9Jc5NkPclri3EGyQO7jHpMzcLUJ2MAUYd7nRYhtpS1F5obAG', 'user', NULL, NULL, '2025-03-04 06:06:52', '2025-04-29 01:20:24'),
(2, 'Gabriel', 'oke@gmail.com', '0', NULL, NULL, '$2y$12$ltbeZxPVKvTkrg.hvS4/Y.06wpa4JpQMj0mK2FCq5cVt5C50xopsa', 'user', NULL, NULL, '2025-03-04 06:08:49', '2025-03-04 06:08:49'),
(7, 'Gabriel', 'gabriel123@gmail.com', '0', NULL, NULL, '$2y$12$rGNVkrTiZma4SGc9nV0uTe8sUx7/8Ay7kzBDpCkhE6gufGOMgDIHG', 'user', NULL, NULL, '2025-03-05 23:16:02', '2025-03-05 23:16:02'),
(17, 'ADMIN LAUNDRY', 'carilaundry@gmail.com', '082211245678', NULL, NULL, '$2y$12$giJ8MVerdHZtrzsA2GU4D.JIwqR2fEk0D429SXIu1SPnQc9WuGKP6', 'admin', NULL, NULL, '2025-04-10 19:49:42', '2025-04-10 19:49:42'),
(18, 'restu', 'restu@gmail.com', '082163321234', NULL, NULL, '$2y$12$ImetIZbDYlLGXlMCtEarQ.DDFrdee7a9hY8ebnBkp68NMrm8d40lO', 'user', NULL, NULL, '2025-04-16 07:14:46', '2025-04-16 07:14:46'),
(19, 'Airin Sitompul', 'Airin@gmail.com', '089465321748', 'http://192.168.233.197:8000/storage/profile_images/1744817706_hAfFJVrZoW.jpg', NULL, '$2y$12$lODFjBUpHwnf3NMJ1VFNo.jeuQOOqj7jqApxIZEkN9gm6ZOy2ohHa', 'user', NULL, NULL, '2025-04-16 08:32:02', '2025-04-16 08:35:08'),
(20, 'Jappy', 'jappy@gmail.com', '089764312580', NULL, NULL, '$2y$12$2GxnvrOZiSk.r4c7W9lg6Odb4FAMzu.89ZdHBU0yyWD0.R1XgeD/2', 'user', NULL, NULL, '2025-04-16 19:21:56', '2025-04-16 19:21:56'),
(21, 'Joy Sihombing', 'joy@gmail.com', '085214703690', NULL, NULL, '$2y$12$iOCYz2Kg6BL3E3LLYlOTOu7oHkN2lMm.92wfS5f.tWGKaIgfL0pN.', 'user', NULL, NULL, '2025-04-16 23:46:30', '2025-04-17 01:25:27'),
(22, 'Noel', 'a@a.com', '123456789111', NULL, NULL, '$2y$12$JaM3FwJaPQ3TfeGqWVl.q..VUbnezJsoOU3RSHSLDWVcG2fXH0I3i', 'user', 'cZKXEdHGRwyXlSDWzUbuf7:APA91bEXXjhPrs8fKrduzKjZAxuep-3bhwSInggr5OFK1CvsfE7XMJJHFuu6NXaYfWzp4gaX-Cn8oKUVykWPMO-si05N2V9lAwJnGSUbodLTMEK0jOk23_s', NULL, '2025-04-21 20:41:21', '2025-05-14 08:06:28'),
(23, 'Natasya Hutapea', 'natasya@gmail.com', '0845321645879', NULL, NULL, '$2y$12$C2AnmP1zoDKl1icO6IY6l.IUtD2F8SWUzETrgsn2/4Hn1V9YLJG8W', 'user', NULL, NULL, '2025-04-29 01:47:14', '2025-04-29 01:47:14'),
(24, 'Odelia', 'juntakodelia@gmail.com', '081264299315', NULL, NULL, '$2y$12$gnzy6F.umKyLinrIiOQWIu6eWr6Rt0pxj8xSlNpGI9Q8P2hwkMeFO', 'user', NULL, NULL, '2025-05-06 00:30:46', '2025-05-06 00:31:44'),
(25, 'Noel Tamba', 'noel123@gmail.com', '087946132580', NULL, NULL, '$2y$12$TGdHclRfvWrWcJ.JwV/5zOIWVQ0sUflTg9u2RQoSQR8XNnLtziXE.', 'user', NULL, NULL, '2025-05-06 00:58:29', '2025-05-06 00:58:29'),
(26, 'Joy Sihombing', 'joy123@gmail.com', '085236907412', NULL, NULL, '$2y$12$jB6zcsoZHi2f1zmYbBaxBOWTTLJ22x4bnGWLsjD7FDxw0ADXhU3NK', 'user', NULL, NULL, '2025-05-07 19:47:06', '2025-05-07 19:47:06');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indeks untuk tabel `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indeks untuk tabel `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `kategoris`
--
ALTER TABLE `kategoris`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `layanans`
--
ALTER TABLE `layanans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `layanans_id_user_foreign` (`id_user`),
  ADD KEY `layanans_id_toko_foreign` (`id_toko`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `notifikasis`
--
ALTER TABLE `notifikasis`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_user_id_foreign` (`user_id`);

--
-- Indeks untuk tabel `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indeks untuk tabel `person`
--
ALTER TABLE `person`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indeks untuk tabel `pesanan`
--
ALTER TABLE `pesanan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pesanan_id_produk_foreign` (`id_produk`),
  ADD KEY `pesanan_id_user_foreign` (`id_user`),
  ADD KEY `pesanan_id_toko_foreign` (`id_toko`),
  ADD KEY `pesanan_layanan_tambahan_foreign` (`layanan_tambahan`),
  ADD KEY `pesanan_id_pesanan_kiloan_foreign` (`id_pesanan_kiloan`);

--
-- Indeks untuk tabel `pesanan_kiloan`
--
ALTER TABLE `pesanan_kiloan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pesanan_kiloan_details`
--
ALTER TABLE `pesanan_kiloan_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pesanan_kiloan_details_id_pesanan_kiloan_foreign` (`id_pesanan_kiloan`),
  ADD KEY `pesanan_kiloan_details_id_produk_foreign` (`id_produk`);

--
-- Indeks untuk tabel `pesanan_layanan_tambahan`
--
ALTER TABLE `pesanan_layanan_tambahan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pesanan_layanan_tambahan_id_pesanan_foreign` (`id_pesanan`),
  ADD KEY `pesanan_layanan_tambahan_id_layanan_foreign` (`id_layanan`);

--
-- Indeks untuk tabel `produks`
--
ALTER TABLE `produks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `produks_id_user_foreign` (`id_user`),
  ADD KEY `produks_id_toko_foreign` (`id_toko`),
  ADD KEY `produks_id_kategori_foreign` (`id_kategori`);

--
-- Indeks untuk tabel `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indeks untuk tabel `tokos`
--
ALTER TABLE `tokos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tokos_user_id_unique` (`userID`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `kategoris`
--
ALTER TABLE `kategoris`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `layanans`
--
ALTER TABLE `layanans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT untuk tabel `notifikasis`
--
ALTER TABLE `notifikasis`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `person`
--
ALTER TABLE `person`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=238;

--
-- AUTO_INCREMENT untuk tabel `pesanan`
--
ALTER TABLE `pesanan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=116;

--
-- AUTO_INCREMENT untuk tabel `pesanan_kiloan`
--
ALTER TABLE `pesanan_kiloan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT untuk tabel `pesanan_kiloan_details`
--
ALTER TABLE `pesanan_kiloan_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `pesanan_layanan_tambahan`
--
ALTER TABLE `pesanan_layanan_tambahan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT untuk tabel `produks`
--
ALTER TABLE `produks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT untuk tabel `tokos`
--
ALTER TABLE `tokos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `layanans`
--
ALTER TABLE `layanans`
  ADD CONSTRAINT `layanans_id_toko_foreign` FOREIGN KEY (`id_toko`) REFERENCES `tokos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `layanans_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pesanan`
--
ALTER TABLE `pesanan`
  ADD CONSTRAINT `pesanan_id_pesanan_kiloan_foreign` FOREIGN KEY (`id_pesanan_kiloan`) REFERENCES `pesanan_kiloan` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `pesanan_id_produk_foreign` FOREIGN KEY (`id_produk`) REFERENCES `produks` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pesanan_id_toko_foreign` FOREIGN KEY (`id_toko`) REFERENCES `tokos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pesanan_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pesanan_layanan_tambahan_foreign` FOREIGN KEY (`layanan_tambahan`) REFERENCES `layanans` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `pesanan_kiloan_details`
--
ALTER TABLE `pesanan_kiloan_details`
  ADD CONSTRAINT `pesanan_kiloan_details_id_pesanan_kiloan_foreign` FOREIGN KEY (`id_pesanan_kiloan`) REFERENCES `pesanan_kiloan` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pesanan_kiloan_details_id_produk_foreign` FOREIGN KEY (`id_produk`) REFERENCES `produks` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `pesanan_layanan_tambahan`
--
ALTER TABLE `pesanan_layanan_tambahan`
  ADD CONSTRAINT `pesanan_layanan_tambahan_id_layanan_foreign` FOREIGN KEY (`id_layanan`) REFERENCES `layanans` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pesanan_layanan_tambahan_id_pesanan_foreign` FOREIGN KEY (`id_pesanan`) REFERENCES `pesanan` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `produks`
--
ALTER TABLE `produks`
  ADD CONSTRAINT `produks_id_kategori_foreign` FOREIGN KEY (`id_kategori`) REFERENCES `kategoris` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `produks_id_toko_foreign` FOREIGN KEY (`id_toko`) REFERENCES `tokos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `produks_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tokos`
--
ALTER TABLE `tokos`
  ADD CONSTRAINT `tokos_user_id_foreign` FOREIGN KEY (`userID`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
