-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Waktu pembuatan: 09 Sep 2025 pada 06.57
-- Versi server: 8.2.0
-- Versi PHP: 8.2.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `antrian_puskesmas_v1`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `company`
--

DROP TABLE IF EXISTS `company`;
CREATE TABLE IF NOT EXISTS `company` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `logo` text COLLATE utf8mb4_unicode_ci,
  `printer` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `company_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `company`
--

INSERT INTO `company` (`id`, `name`, `address`, `active`, `logo`, `printer`, `created_at`, `updated_at`) VALUES
(1, 'KCP Ciawi', '1437', 1, NULL, NULL, '2025-09-09 06:22:43', '2025-09-09 06:22:43');

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `locket_call`
--

DROP TABLE IF EXISTS `locket_call`;
CREATE TABLE IF NOT EXISTS `locket_call` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `number_queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `locket_code` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `locket_number` int DEFAULT NULL,
  `called` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `locket_history_call`
--

DROP TABLE IF EXISTS `locket_history_call`;
CREATE TABLE IF NOT EXISTS `locket_history_call` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `locket_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `locket_number` int DEFAULT NULL,
  `locket_staff_name` text COLLATE utf8mb4_unicode_ci,
  `number_queue` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `process_time_queue_locket` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `locket_history_call`
--

INSERT INTO `locket_history_call` (`id`, `locket_code`, `locket_number`, `locket_staff_name`, `number_queue`, `process_time_queue_locket`, `created_at`, `updated_at`) VALUES
(1, 'A', 1, 'Staff 1', '001', 28, '2025-09-09 06:24:48', '2025-09-09 06:24:48'),
(2, 'A', 1, 'Staff 1', '002', 1643, '2025-09-09 06:51:48', '2025-09-09 06:51:48'),
(3, 'A', 1, 'Staff 1', '003', 48, '2025-09-09 06:52:34', '2025-09-09 06:52:34'),
(4, 'C', 1, 'Staff 1', '001', 1733, '2025-09-09 06:53:15', '2025-09-09 06:53:15'),
(5, 'B', 1, 'Staff 1', '001', 1746, '2025-09-09 06:53:30', '2025-09-09 06:53:30');

-- --------------------------------------------------------

--
-- Struktur dari tabel `locket_queue`
--

DROP TABLE IF EXISTS `locket_queue`;
CREATE TABLE IF NOT EXISTS `locket_queue` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `locket_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `locket_number` int DEFAULT NULL,
  `number_queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `called` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `locket_queue_locket_code_created_at_unique` (`locket_code`,`created_at`),
  KEY `locket_queue_called_created_at_index` (`called`,`created_at`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `locket_queue`
--

INSERT INTO `locket_queue` (`id`, `locket_code`, `locket_number`, `number_queue`, `called`, `created_at`, `updated_at`) VALUES
(1, 'A', 1, '001', 1, '2025-09-09 06:24:20', '2025-09-09 06:24:48'),
(2, 'C', 1, '001', 1, '2025-09-09 06:24:22', '2025-09-09 06:53:15'),
(3, 'B', 1, '001', 1, '2025-09-09 06:24:24', '2025-09-09 06:53:30'),
(4, 'A', 1, '002', 1, '2025-09-09 06:24:25', '2025-09-09 06:51:48'),
(5, 'A', 1, '003', 1, '2025-09-09 06:51:46', '2025-09-09 06:52:34');

-- --------------------------------------------------------

--
-- Struktur dari tabel `locket_staff`
--

DROP TABLE IF EXISTS `locket_staff`;
CREATE TABLE IF NOT EXISTS `locket_staff` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `staff_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `locket_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lantai` int NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `locket_staff`
--

INSERT INTO `locket_staff` (`id`, `staff_name`, `locket_number`, `lantai`, `created_at`, `updated_at`) VALUES
(1, 'Staff 1', '1', 1, '2025-09-09 06:23:35', '2025-09-09 06:23:35'),
(2, 'Staff 2', '2', 1, '2025-09-09 06:23:42', '2025-09-09 06:23:42');

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2025_08_15_055021_create_permission_tables', 1),
(6, '2025_08_15_073847_create_rooms_table', 1),
(7, '2025_08_15_090517_create_company_table', 1),
(8, '2025_08_15_174052_create_room_queues_table', 1),
(9, '2025_08_15_174314_create_room_queue_calls_table', 1),
(10, '2025_08_15_174613_create_room_queue_history_calls_table', 1),
(11, '2025_08_15_175044_create_locket_queue_table', 1),
(12, '2025_08_15_175230_create_locket_staff_table', 1),
(13, '2025_08_15_175347_create_locket_call_table', 1),
(14, '2025_08_15_175511_create_locket_history_call_table', 1),
(15, '2025_08_15_191152_create_stat_consoles_table', 1),
(16, '2025_08_18_235049_create_queue_callers_table', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `model_has_permissions`
--

DROP TABLE IF EXISTS `model_has_permissions`;
CREATE TABLE IF NOT EXISTS `model_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `model_has_roles`
--

DROP TABLE IF EXISTS `model_has_roles`;
CREATE TABLE IF NOT EXISTS `model_has_roles` (
  `role_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `permissions`
--

DROP TABLE IF EXISTS `permissions`;
CREATE TABLE IF NOT EXISTS `permissions` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `queue_callers`
--

DROP TABLE IF EXISTS `queue_callers`;
CREATE TABLE IF NOT EXISTS `queue_callers` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `owner_id` int NOT NULL,
  `number_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `number_queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `initiator_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `called` tinyint(1) NOT NULL DEFAULT '0',
  `called_to` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lantai` int NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `queue_callers_number_code_created_at_unique` (`number_code`,`created_at`),
  KEY `queue_callers_called_created_at_index` (`called`,`created_at`),
  KEY `queue_callers_owner_id_type_called_created_at_index` (`owner_id`,`type`,`called`,`created_at`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `queue_callers`
--

INSERT INTO `queue_callers` (`id`, `owner_id`, `number_code`, `number_queue`, `initiator_name`, `called`, `called_to`, `type`, `lantai`, `created_at`, `updated_at`) VALUES
(1, 1, 'A', '001', 'PENDAFTARAN', 1, 'loket 1', 'locket', 1, '2025-09-09 06:24:48', '2025-09-09 06:24:49'),
(2, 1, 'D', '001', 'Poli', 1, 'TB', 'poli', 2, '2025-09-09 06:25:26', '2025-09-09 06:25:27'),
(3, 1, 'D', '001', 'Poli', 1, 'TB', 'poli', 2, '2025-09-09 06:25:41', '2025-09-09 06:25:41'),
(4, 1, 'D', '001', 'Poli', 1, 'TB', 'poli', 2, '2025-09-09 06:29:53', '2025-09-09 06:29:54'),
(5, 1, 'D', '001', 'Poli', 1, 'TB', 'poli', 2, '2025-09-09 06:31:12', '2025-09-09 06:31:14'),
(6, 1, 'D', '001', 'Poli', 1, 'TB', 'poli', 2, '2025-09-09 06:35:40', '2025-09-09 06:35:41'),
(7, 2, 'E', '001', 'Poli', 1, 'IMS', 'poli', 2, '2025-09-09 06:36:43', '2025-09-09 06:36:45'),
(8, 2, 'E', '001', 'Poli', 1, 'IMS', 'poli', 2, '2025-09-09 06:36:55', '2025-09-09 06:36:57'),
(9, 2, 'E', '001', 'Poli', 1, 'IMS', 'poli', 2, '2025-09-09 06:37:19', '2025-09-09 06:37:21'),
(10, 2, 'E', '001', 'Poli', 1, 'IMS', 'poli', 2, '2025-09-09 06:37:32', '2025-09-09 06:37:34'),
(11, 3, 'F', '001', 'Poli', 1, 'FARMASI', 'poli', 2, '2025-09-09 06:37:45', '2025-09-09 06:37:46'),
(12, 4, 'G', '001', 'Poli', 1, 'SURVEILANS', 'poli', 2, '2025-09-09 06:37:58', '2025-09-09 06:38:01'),
(13, 5, 'H', '001', 'Poli', 1, 'BPU', 'poli', 2, '2025-09-09 06:38:12', '2025-09-09 06:38:13'),
(14, 6, 'I', '001', 'Poli', 1, 'GIGI', 'poli', 2, '2025-09-09 06:38:24', '2025-09-09 06:38:25'),
(15, 7, 'J', '001', 'Poli', 1, 'LAB', 'poli', 2, '2025-09-09 06:38:35', '2025-09-09 06:38:37'),
(16, 8, 'K', '001', 'Poli', 1, 'LANSIA', 'poli', 2, '2025-09-09 06:38:52', '2025-09-09 06:38:55'),
(17, 9, 'L', '001', 'Poli', 1, 'CATEN', 'poli', 2, '2025-09-09 06:39:00', '2025-09-09 06:39:01'),
(18, 9, 'L', '001', 'Poli', 1, 'CATEN', 'poli', 2, '2025-09-09 06:39:58', '2025-09-09 06:39:58'),
(19, 8, 'K', '001', 'Poli', 1, 'LANSIA', 'poli', 2, '2025-09-09 06:40:01', '2025-09-09 06:40:04'),
(20, 7, 'J', '001', 'Poli', 1, 'LAB', 'poli', 2, '2025-09-09 06:40:03', '2025-09-09 06:40:07'),
(21, 6, 'I', '001', 'Poli', 1, 'GIGI', 'poli', 2, '2025-09-09 06:40:41', '2025-09-09 06:40:43'),
(22, 7, 'J', '001', 'Poli', 1, 'LAB', 'poli', 2, '2025-09-09 06:40:44', '2025-09-09 06:40:49'),
(23, 8, 'K', '001', 'Poli', 1, 'LANSIA', 'poli', 2, '2025-09-09 06:40:46', '2025-09-09 06:40:52'),
(24, 9, 'L', '001', 'Poli', 1, 'CATEN', 'poli', 2, '2025-09-09 06:40:49', '2025-09-09 06:40:55'),
(25, 10, 'M', '001', 'Poli', 1, 'PSIKOLOG', 'poli', 2, '2025-09-09 06:40:53', '2025-09-09 06:40:58'),
(26, 10, 'M', '001', 'Poli', 1, 'PSIKOLOG', 'poli', 2, '2025-09-09 06:43:36', '2025-09-09 06:43:37'),
(27, 11, 'N', '001', 'Poli', 1, 'HAJI', 'poli', 2, '2025-09-09 06:43:40', '2025-09-09 06:43:52'),
(28, 12, 'O', '001', 'Poli', 1, 'AKUPRESUR', 'poli', 2, '2025-09-09 06:43:42', '2025-09-09 06:44:07'),
(29, 13, 'P', '001', 'Poli', 1, 'PTM', 'poli', 2, '2025-09-09 06:43:44', '2025-09-09 06:44:22'),
(30, 15, 'R', '001', 'Poli', 1, 'PKPR', 'poli', 2, '2025-09-09 06:43:49', '2025-09-09 06:44:34'),
(31, 13, 'P', '001', 'Poli', 1, 'PTM', 'poli', 2, '2025-09-09 06:44:49', '2025-09-09 06:44:52'),
(32, 13, 'P', '001', 'Poli', 1, 'PTM', 'poli', 2, '2025-09-09 06:46:14', '2025-09-09 06:46:16'),
(33, 14, 'Q', '001', 'Poli', 1, 'MTBS', 'poli', 2, '2025-09-09 06:46:29', '2025-09-09 06:46:31'),
(34, 15, 'R', '001', 'Poli', 1, 'PKPR', 'poli', 2, '2025-09-09 06:46:49', '2025-09-09 06:46:49'),
(35, 16, 'S', '001', 'Poli', 1, 'JIWA GIZI', 'poli', 2, '2025-09-09 06:46:52', '2025-09-09 06:47:04'),
(36, 1, 'A', '002', 'PENDAFTARAN', 1, 'loket 1', 'locket', 1, '2025-09-09 06:51:48', '2025-09-09 06:51:52'),
(37, 1, 'A', '003', 'PENDAFTARAN', 1, 'loket 1', 'locket', 1, '2025-09-09 06:52:34', '2025-09-09 06:52:34'),
(38, 1, 'A', '003', 'PENDAFTARAN', 1, 'loket 1', 'locket', 1, '2025-09-09 06:52:46', '2025-09-09 06:52:47'),
(39, 1, 'C', '001', 'LABORATE', 1, 'loket 1', 'locket', 1, '2025-09-09 06:53:15', '2025-09-09 06:53:18'),
(40, 1, 'B', '001', 'LANSIA', 1, 'loket 1', 'locket', 1, '2025-09-09 06:53:30', '2025-09-09 06:53:33');

-- --------------------------------------------------------

--
-- Struktur dari tabel `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'web', '2025-09-09 06:22:40', '2025-09-09 06:22:40');

-- --------------------------------------------------------

--
-- Struktur dari tabel `role_has_permissions`
--

DROP TABLE IF EXISTS `role_has_permissions`;
CREATE TABLE IF NOT EXISTS `role_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `role_id` bigint UNSIGNED NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `rooms`
--

DROP TABLE IF EXISTS `rooms`;
CREATE TABLE IF NOT EXISTS `rooms` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `current_queue` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `show` tinyint(1) NOT NULL DEFAULT '1',
  `lantai` int NOT NULL DEFAULT '1',
  `last_call_queue` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_call_time` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `rooms_code_unique` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `rooms`
--

INSERT INTO `rooms` (`id`, `code`, `name`, `current_queue`, `show`, `lantai`, `last_call_queue`, `last_call_time`, `created_at`, `updated_at`) VALUES
(1, 'D', 'TB', '001', 1, 2, '001', '2025-09-09 13:25:26', '2025-09-09 06:22:40', '2025-09-09 06:25:26'),
(2, 'E', 'IMS', '001', 1, 2, '001', '2025-09-09 13:36:43', '2025-09-09 06:22:40', '2025-09-09 06:36:43'),
(3, 'F', 'FARMASI', '001', 1, 2, '001', '2025-09-09 13:37:45', '2025-09-09 06:22:40', '2025-09-09 06:37:45'),
(4, 'G', 'SURVEILANS', '001', 1, 2, '001', '2025-09-09 13:37:58', '2025-09-09 06:22:40', '2025-09-09 06:37:58'),
(5, 'H', 'BPU', '001', 1, 2, '001', '2025-09-09 13:38:12', '2025-09-09 06:22:40', '2025-09-09 06:38:12'),
(6, 'I', 'GIGI', '001', 1, 2, '001', '2025-09-09 13:38:24', '2025-09-09 06:22:40', '2025-09-09 06:38:24'),
(7, 'J', 'LAB', '001', 1, 2, '001', '2025-09-09 13:38:35', '2025-09-09 06:22:40', '2025-09-09 06:38:35'),
(8, 'K', 'LANSIA', '001', 1, 2, '001', '2025-09-09 13:38:52', '2025-09-09 06:22:40', '2025-09-09 06:38:52'),
(9, 'L', 'CATEN', '001', 1, 2, '001', '2025-09-09 13:39:00', '2025-09-09 06:22:40', '2025-09-09 06:39:00'),
(10, 'M', 'PSIKOLOG', '001', 1, 2, '001', '2025-09-09 13:40:53', '2025-09-09 06:22:40', '2025-09-09 06:40:53'),
(11, 'N', 'HAJI', '001', 1, 2, '001', '2025-09-09 13:43:40', '2025-09-09 06:22:40', '2025-09-09 06:43:40'),
(12, 'O', 'AKUPRESUR', '001', 1, 2, '001', '2025-09-09 13:43:42', '2025-09-09 06:22:40', '2025-09-09 06:43:42'),
(13, 'P', 'PTM', '001', 1, 2, '001', '2025-09-09 13:43:44', '2025-09-09 06:22:40', '2025-09-09 06:43:44'),
(14, 'Q', 'MTBS', '001', 1, 2, '001', '2025-09-09 13:46:29', '2025-09-09 06:22:40', '2025-09-09 06:46:29'),
(15, 'R', 'PKPR', '001', 1, 2, '001', '2025-09-09 13:43:49', '2025-09-09 06:22:40', '2025-09-09 06:43:49'),
(16, 'S', 'JIWA GIZI', '001', 1, 2, '001', '2025-09-09 13:46:52', '2025-09-09 06:22:40', '2025-09-09 06:46:52');

-- --------------------------------------------------------

--
-- Struktur dari tabel `room_queues`
--

DROP TABLE IF EXISTS `room_queues`;
CREATE TABLE IF NOT EXISTS `room_queues` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `room_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `number_queue` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `called` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `room_queues_room_code_created_at_unique` (`room_code`,`created_at`),
  KEY `room_queues_called_created_at_index` (`called`,`created_at`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `room_queues`
--

INSERT INTO `room_queues` (`id`, `room_code`, `number_queue`, `called`, `created_at`, `updated_at`) VALUES
(1, 'D', '001', 1, '2025-09-09 06:25:17', '2025-09-09 06:25:26'),
(2, 'E', '001', 1, '2025-09-09 06:25:20', '2025-09-09 06:36:43'),
(3, 'F', '001', 1, '2025-09-09 06:36:12', '2025-09-09 06:37:45'),
(4, 'G', '001', 1, '2025-09-09 06:36:15', '2025-09-09 06:37:58'),
(5, 'H', '001', 1, '2025-09-09 06:36:17', '2025-09-09 06:38:12'),
(6, 'I', '001', 1, '2025-09-09 06:36:18', '2025-09-09 06:38:24'),
(7, 'J', '001', 1, '2025-09-09 06:36:20', '2025-09-09 06:38:35'),
(8, 'K', '001', 1, '2025-09-09 06:36:22', '2025-09-09 06:38:52'),
(9, 'L', '001', 1, '2025-09-09 06:36:24', '2025-09-09 06:39:00'),
(10, 'M', '001', 1, '2025-09-09 06:36:25', '2025-09-09 06:40:53'),
(11, 'N', '001', 1, '2025-09-09 06:36:27', '2025-09-09 06:43:40'),
(12, 'O', '001', 1, '2025-09-09 06:36:29', '2025-09-09 06:43:42'),
(13, 'P', '001', 1, '2025-09-09 06:36:31', '2025-09-09 06:43:44'),
(14, 'Q', '001', 1, '2025-09-09 06:36:33', '2025-09-09 06:46:29'),
(15, 'R', '001', 1, '2025-09-09 06:36:35', '2025-09-09 06:43:49'),
(16, 'S', '001', 1, '2025-09-09 06:36:37', '2025-09-09 06:46:52');

-- --------------------------------------------------------

--
-- Struktur dari tabel `room_queue_calls`
--

DROP TABLE IF EXISTS `room_queue_calls`;
CREATE TABLE IF NOT EXISTS `room_queue_calls` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `room_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `number_queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `called` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `room_queue_history_calls`
--

DROP TABLE IF EXISTS `room_queue_history_calls`;
CREATE TABLE IF NOT EXISTS `room_queue_history_calls` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `room_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `number_queue` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `process_time_queue_room` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `room_queue_history_calls`
--

INSERT INTO `room_queue_history_calls` (`id`, `room_code`, `number_queue`, `process_time_queue_room`, `created_at`, `updated_at`) VALUES
(1, 'D', NULL, 0, '2025-09-09 06:25:26', '2025-09-09 06:25:26'),
(2, 'E', NULL, 0, '2025-09-09 06:36:43', '2025-09-09 06:36:43'),
(3, 'F', NULL, 0, '2025-09-09 06:37:45', '2025-09-09 06:37:45'),
(4, 'G', NULL, 0, '2025-09-09 06:37:58', '2025-09-09 06:37:58'),
(5, 'H', NULL, 0, '2025-09-09 06:38:12', '2025-09-09 06:38:12'),
(6, 'I', NULL, 0, '2025-09-09 06:38:24', '2025-09-09 06:38:24'),
(7, 'J', NULL, 0, '2025-09-09 06:38:35', '2025-09-09 06:38:35'),
(8, 'K', NULL, 0, '2025-09-09 06:38:52', '2025-09-09 06:38:52'),
(9, 'L', NULL, 0, '2025-09-09 06:39:00', '2025-09-09 06:39:00'),
(10, 'M', NULL, 0, '2025-09-09 06:40:53', '2025-09-09 06:40:53'),
(11, 'N', NULL, 0, '2025-09-09 06:43:40', '2025-09-09 06:43:40'),
(12, 'O', NULL, 0, '2025-09-09 06:43:42', '2025-09-09 06:43:42'),
(13, 'P', NULL, 0, '2025-09-09 06:43:44', '2025-09-09 06:43:44'),
(14, 'R', NULL, 0, '2025-09-09 06:43:49', '2025-09-09 06:43:49'),
(15, 'Q', NULL, 0, '2025-09-09 06:46:29', '2025-09-09 06:46:29'),
(16, 'S', NULL, 0, '2025-09-09 06:46:52', '2025-09-09 06:46:52');

-- --------------------------------------------------------

--
-- Struktur dari tabel `stat_consoles`
--

DROP TABLE IF EXISTS `stat_consoles`;
CREATE TABLE IF NOT EXISTS `stat_consoles` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `tanggal` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ActiveDate` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `stat_consoles`
--

INSERT INTO `stat_consoles` (`id`, `tanggal`, `Status`, `ActiveDate`, `created_at`, `updated_at`) VALUES
(1, '20250909', 'active', '20250909', '2025-09-09 06:22:43', '2025-09-09 06:22:43');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin@admin.com', NULL, '$2y$10$rIXgr1irfcZ0yKpc1u0ubeiK86h0BoT7OBLoIiUjep7nXLSgnZxWG', NULL, '2025-09-09 06:22:40', '2025-09-09 06:22:40');

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
