-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Oct 12, 2025 at 12:21 PM
-- Server version: 8.2.0
-- PHP Version: 8.2.13

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
-- Table structure for table `company`
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
-- Dumping data for table `company`
--

INSERT INTO `company` (`id`, `name`, `address`, `active`, `logo`, `printer`, `created_at`, `updated_at`) VALUES
(1, 'Puskesmas Kramat Jati', 'Kramat Jati', 1, NULL, NULL, '2025-10-12 12:03:33', '2025-10-12 12:21:00');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
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
-- Table structure for table `locket_call`
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
-- Table structure for table `locket_history_call`
--

DROP TABLE IF EXISTS `locket_history_call`;
CREATE TABLE IF NOT EXISTS `locket_history_call` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `locket_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `locket_number` int DEFAULT NULL,
  `locket_staff_id` int DEFAULT NULL,
  `locket_staff_name` text COLLATE utf8mb4_unicode_ci,
  `number_queue` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `process_time_queue_locket` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_locket_code_created` (`locket_code`,`created_at`),
  KEY `idx_staff_created` (`locket_staff_id`,`created_at`),
  KEY `idx_locket_number_created` (`locket_number`,`created_at`),
  KEY `idx_created_at_only` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `locket_queue`
--

DROP TABLE IF EXISTS `locket_queue`;
CREATE TABLE IF NOT EXISTS `locket_queue` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `locket_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `locket_staff_id` bigint UNSIGNED DEFAULT NULL,
  `number_queue` smallint UNSIGNED NOT NULL,
  `called` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_locket_queue_code_number_called` (`locket_code`,`number_queue`,`called`),
  KEY `locket_queue_locket_staff_id_foreign` (`locket_staff_id`),
  KEY `locket_queue_locket_code_called_created_at_index` (`locket_code`,`called`,`created_at`),
  KEY `locket_queue_locket_code_created_at_id_index` (`locket_code`,`created_at`,`id`),
  KEY `idx_locket_code_created_id` (`locket_code`,`created_at`,`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `locket_queue`
--

INSERT INTO `locket_queue` (`id`, `locket_code`, `locket_staff_id`, `number_queue`, `called`, `created_at`, `updated_at`) VALUES
(1, 'A', NULL, 1, 0, '2025-10-12 12:04:10', '2025-10-12 12:04:10'),
(2, 'D', NULL, 1, 0, '2025-10-12 12:04:10', '2025-10-12 12:04:10'),
(3, 'A', NULL, 2, 0, '2025-10-12 12:04:11', '2025-10-12 12:04:11'),
(4, 'D', NULL, 2, 0, '2025-10-12 12:04:11', '2025-10-12 12:04:11');

-- --------------------------------------------------------

--
-- Table structure for table `locket_staff`
--

DROP TABLE IF EXISTS `locket_staff`;
CREATE TABLE IF NOT EXISTS `locket_staff` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `staff_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `locket_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `allowed_codes` json DEFAULT NULL,
  `lantai` int NOT NULL DEFAULT '1',
  `last_called_queue_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `locket_staff`
--

INSERT INTO `locket_staff` (`id`, `staff_name`, `locket_number`, `allowed_codes`, `lantai`, `last_called_queue_id`, `created_at`, `updated_at`) VALUES
(1, 'Farmasi', NULL, '[\"D\"]', 1, NULL, '2025-10-12 12:03:50', '2025-10-12 12:03:50'),
(2, 'Loket', '1', '[\"A\", \"B\", \"C\"]', 1, NULL, '2025-10-12 12:03:58', '2025-10-12 12:04:03');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
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
(11, '2025_08_15_175230_create_locket_staff_table', 1),
(12, '2025_08_15_175344_create_locket_queue_table', 1),
(13, '2025_08_15_175347_create_locket_call_table', 1),
(14, '2025_08_15_175511_create_locket_history_call_table', 1),
(15, '2025_08_15_191152_create_stat_consoles_table', 1),
(16, '2025_08_18_235049_create_queue_callers_table', 1),
(17, '2025_10_09_231618_room_dependencies', 1);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
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
-- Table structure for table `model_has_roles`
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
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
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
-- Table structure for table `permissions`
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
-- Table structure for table `personal_access_tokens`
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
-- Table structure for table `queue_callers`
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
  `lantai` tinyint UNSIGNED NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_last_call_by_code` (`number_code`,`called`,`created_at`,`id`),
  KEY `idx_exist_pending_owner` (`owner_id`,`type`,`called`,`created_at`),
  KEY `idx_last_call_by_owner` (`owner_id`,`type`,`called`,`created_at`,`id`),
  KEY `idx_lantai_called_created` (`lantai`,`called`,`created_at`),
  KEY `idx_created_at` (`created_at`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `queue_callers`
--

INSERT INTO `queue_callers` (`id`, `owner_id`, `number_code`, `number_queue`, `initiator_name`, `called`, `called_to`, `type`, `lantai`, `created_at`, `updated_at`) VALUES
(1, 1, 'E', '001', '24 JAM', 1, '24 JAM', 'poli', 1, '2025-10-12 12:11:04', '2025-10-12 12:11:07'),
(2, 1, 'E', '001', '24 JAM', 1, '24 JAM', 'poli', 1, '2025-10-12 12:11:21', '2025-10-12 12:11:24'),
(3, 1, 'E', '002', '24 JAM', 1, '24 JAM', 'poli', 1, '2025-10-12 12:11:33', '2025-10-12 12:11:36'),
(4, 2, 'F', '001', 'RB', 1, 'RB', 'poli', 1, '2025-10-12 12:11:44', '2025-10-12 12:11:45'),
(5, 2, 'F', '001', 'RB', 1, 'RB', 'poli', 1, '2025-10-12 12:11:54', '2025-10-12 12:11:57'),
(6, 2, 'F', '002', 'RB', 1, 'RB', 'poli', 1, '2025-10-12 12:12:01', '2025-10-12 12:12:06'),
(7, 3, 'G', '001', 'IMS', 1, 'IMS', 'poli', 1, '2025-10-12 12:12:17', '2025-10-12 12:12:18'),
(8, 3, 'G', '002', 'IMS', 1, 'IMS', 'poli', 1, '2025-10-12 12:12:27', '2025-10-12 12:12:27'),
(9, 3, 'G', '002', 'IMS', 1, 'IMS', 'poli', 1, '2025-10-12 12:12:34', '2025-10-12 12:12:36'),
(10, 4, 'H', '001', 'PDP', 1, 'PDP', 'poli', 1, '2025-10-12 12:12:42', '2025-10-12 12:12:45'),
(11, 5, 'I', '001', 'TB', 1, 'TB', 'poli', 1, '2025-10-12 12:12:55', '2025-10-12 12:12:57'),
(12, 6, 'J', '001', 'UMUM', 1, 'UMUM', 'poli', 2, '2025-10-12 12:13:07', '2025-10-12 12:13:17'),
(13, 6, 'J', '002', 'UMUM', 1, 'UMUM', 'poli', 2, '2025-10-12 12:13:29', '2025-10-12 12:13:31'),
(14, 7, 'K', '001', 'Gigi', 1, 'Gigi', 'poli', 2, '2025-10-12 12:13:38', '2025-10-12 12:13:40'),
(15, 7, 'K', '002', 'Gigi', 1, 'Gigi', 'poli', 2, '2025-10-12 12:13:49', '2025-10-12 12:13:49'),
(16, 8, 'L', '001', 'Laborate', 1, 'Laborate', 'poli', 2, '2025-10-12 12:13:57', '2025-10-12 12:13:58'),
(17, 9, 'M', '001', 'Lansia', 1, 'Lansia', 'poli', 2, '2025-10-12 12:14:10', '2025-10-12 12:14:13'),
(18, 10, 'N', '001', 'UBM', 1, 'UBM', 'poli', 2, '2025-10-12 12:14:20', '2025-10-12 12:14:22'),
(19, 11, 'O', '001', 'CATIN', 1, 'CATIN', 'poli', 2, '2025-10-12 12:14:31', '2025-10-12 12:14:34'),
(20, 12, 'P', '001', 'Psikologi', 1, 'Psikologi', 'poli', 2, '2025-10-12 12:14:43', '2025-10-12 12:14:46'),
(21, 13, 'Q', '001', 'Haji', 1, 'Haji', 'poli', 2, '2025-10-12 12:14:56', '2025-10-12 12:14:58'),
(22, 14, 'R', '001', 'PTM', 1, 'PTM', 'poli', 2, '2025-10-12 12:15:05', '2025-10-12 12:15:07'),
(23, 15, 'S', '001', 'MTBS', 1, 'MTBS', 'poli', 2, '2025-10-12 12:15:12', '2025-10-12 12:15:16'),
(24, 16, 'T', '001', 'PKPR', 1, 'PKPR', 'poli', 2, '2025-10-12 12:15:25', '2025-10-12 12:15:28'),
(25, 17, 'U', '001', 'Jiwa', 1, 'Jiwa', 'poli', 2, '2025-10-12 12:15:39', '2025-10-12 12:15:40'),
(26, 18, 'V', '001', 'Gizi', 1, 'Gizi', 'poli', 2, '2025-10-12 12:15:47', '2025-10-12 12:15:49'),
(27, 19, 'W', '001', 'CKG', 1, 'CKG', 'poli', 2, '2025-10-12 12:15:57', '2025-10-12 12:15:58'),
(28, 20, 'X', '001', 'Nurse Station', 1, 'Nurse Station', 'poli', 2, '2025-10-12 12:16:13', '2025-10-12 12:16:16'),
(29, 20, 'X', '002', 'Nurse Station', 1, 'Nurse Station', 'poli', 2, '2025-10-12 12:16:37', '2025-10-12 12:16:40'),
(30, 20, 'X', '002', 'Nurse Station', 1, 'Nurse Station', 'poli', 2, '2025-10-12 12:16:49', '2025-10-12 12:16:52'),
(31, 20, 'G', '003', 'Nurse Station', 1, 'Nurse Station', 'poli', 2, '2025-10-12 12:17:38', '2025-10-12 12:17:44'),
(32, 20, 'G', '003', 'Nurse Station', 1, 'Nurse Station', 'poli', 2, '2025-10-12 12:17:55', '2025-10-12 12:17:58'),
(33, 3, 'G', '003', 'IMS', 1, 'IMS', 'poli', 1, '2025-10-12 12:18:11', '2025-10-12 12:18:12');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
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
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'web', '2025-10-12 12:03:26', '2025-10-12 12:03:26');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
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
-- Table structure for table `rooms`
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
  `last_room_queue_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `rooms_code_unique` (`code`),
  KEY `rooms_last_room_queue_id_index` (`last_room_queue_id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`id`, `code`, `name`, `current_queue`, `show`, `lantai`, `last_call_queue`, `last_call_time`, `last_room_queue_id`, `created_at`, `updated_at`) VALUES
(1, 'E', '24 JAM', '002', 1, 1, '002', '2025-10-12 19:11:33', 14, '2025-10-12 12:03:26', '2025-10-12 12:11:33'),
(2, 'F', 'RB', '003', 1, 1, '002', '2025-10-12 19:12:01', 15, '2025-10-12 12:03:26', '2025-10-12 12:12:01'),
(3, 'G', 'IMS', '003', 1, 1, '003', '2025-10-12 19:18:11', 42, '2025-10-12 12:03:26', '2025-10-12 12:18:11'),
(4, 'H', 'PDP', '002', 1, 1, '001', '2025-10-12 19:12:42', 4, '2025-10-12 12:03:26', '2025-10-12 12:12:42'),
(5, 'I', 'TB', '002', 1, 1, '001', '2025-10-12 19:12:55', 5, '2025-10-12 12:03:26', '2025-10-12 12:12:55'),
(6, 'J', 'UMUM', '002', 1, 2, '002', '2025-10-12 19:13:29', 20, '2025-10-12 12:03:26', '2025-10-12 12:13:29'),
(7, 'K', 'Gigi', '002', 1, 2, '002', '2025-10-12 19:13:49', 21, '2025-10-12 12:03:26', '2025-10-12 12:13:49'),
(8, 'L', 'Laborate', '002', 1, 2, '001', '2025-10-12 19:13:57', 8, '2025-10-12 12:03:26', '2025-10-12 12:13:57'),
(9, 'M', 'Lansia', '002', 1, 2, '001', '2025-10-12 19:14:10', 9, '2025-10-12 12:03:26', '2025-10-12 12:14:10'),
(10, 'N', 'UBM', '002', 1, 2, '001', '2025-10-12 19:14:20', 10, '2025-10-12 12:03:26', '2025-10-12 12:14:20'),
(11, 'O', 'CATIN', '002', 1, 2, '001', '2025-10-12 19:14:31', 11, '2025-10-12 12:03:26', '2025-10-12 12:14:31'),
(12, 'P', 'Psikologi', '002', 1, 2, '001', '2025-10-12 19:14:43', 12, '2025-10-12 12:03:26', '2025-10-12 12:14:43'),
(13, 'Q', 'Haji', '002', 1, 2, '001', '2025-10-12 19:14:56', 13, '2025-10-12 12:03:26', '2025-10-12 12:14:56'),
(14, 'R', 'PTM', '002', 1, 2, '001', '2025-10-12 19:15:05', 28, '2025-10-12 12:03:26', '2025-10-12 12:15:05'),
(15, 'S', 'MTBS', '002', 1, 2, '001', '2025-10-12 19:15:12', 30, '2025-10-12 12:03:26', '2025-10-12 12:15:12'),
(16, 'T', 'PKPR', '002', 1, 2, '001', '2025-10-12 19:15:25', 32, '2025-10-12 12:03:26', '2025-10-12 12:15:25'),
(17, 'U', 'Jiwa', '002', 1, 2, '001', '2025-10-12 19:15:39', 34, '2025-10-12 12:03:26', '2025-10-12 12:15:39'),
(18, 'V', 'Gizi', '002', 1, 2, '001', '2025-10-12 19:15:47', 36, '2025-10-12 12:03:26', '2025-10-12 12:15:47'),
(19, 'W', 'CKG', '002', 1, 2, '001', '2025-10-12 19:15:57', 38, '2025-10-12 12:03:26', '2025-10-12 12:15:57'),
(20, 'X', 'Nurse Station', '002', 1, 2, '003', '2025-10-12 19:17:38', 42, '2025-10-12 12:03:26', '2025-10-12 12:17:38');

-- --------------------------------------------------------

--
-- Table structure for table `room_dependencies`
--

DROP TABLE IF EXISTS `room_dependencies`;
CREATE TABLE IF NOT EXISTS `room_dependencies` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `room_id` bigint UNSIGNED NOT NULL,
  `required_room_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `room_dependencies_room_id_required_room_id_unique` (`room_id`,`required_room_id`),
  KEY `room_dependencies_required_room_id_foreign` (`required_room_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `room_dependencies`
--

INSERT INTO `room_dependencies` (`id`, `room_id`, `required_room_id`, `created_at`, `updated_at`) VALUES
(1, 3, 20, '2025-10-12 12:17:02', '2025-10-12 12:17:02');

-- --------------------------------------------------------

--
-- Table structure for table `room_queues`
--

DROP TABLE IF EXISTS `room_queues`;
CREATE TABLE IF NOT EXISTS `room_queues` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `room_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `number_queue` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `called` tinyint(1) NOT NULL DEFAULT '0',
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'waiting',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `room_queues_room_code_created_at_unique` (`room_code`,`created_at`),
  KEY `room_queues_called_created_at_index` (`called`,`created_at`),
  KEY `idx_room_code_created` (`room_code`,`created_at`),
  KEY `idx_room_code_called_status_created` (`room_code`,`called`,`status`,`created_at`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `room_queues`
--

INSERT INTO `room_queues` (`id`, `room_code`, `number_queue`, `called`, `status`, `created_at`, `updated_at`) VALUES
(1, 'E', '001', 1, 'completed', '2025-10-12 12:09:46', '2025-10-12 12:11:04'),
(2, 'F', '001', 1, 'completed', '2025-10-12 12:09:48', '2025-10-12 12:11:44'),
(3, 'G', '001', 1, 'completed', '2025-10-12 12:09:50', '2025-10-12 12:12:17'),
(4, 'H', '001', 1, 'completed', '2025-10-12 12:09:52', '2025-10-12 12:12:42'),
(5, 'I', '001', 1, 'completed', '2025-10-12 12:09:54', '2025-10-12 12:12:55'),
(6, 'J', '001', 1, 'completed', '2025-10-12 12:09:55', '2025-10-12 12:13:07'),
(7, 'K', '001', 1, 'completed', '2025-10-12 12:09:57', '2025-10-12 12:13:38'),
(8, 'L', '001', 1, 'completed', '2025-10-12 12:09:59', '2025-10-12 12:13:57'),
(9, 'M', '001', 1, 'completed', '2025-10-12 12:10:00', '2025-10-12 12:14:10'),
(10, 'N', '001', 1, 'completed', '2025-10-12 12:10:02', '2025-10-12 12:14:20'),
(11, 'O', '001', 1, 'completed', '2025-10-12 12:10:04', '2025-10-12 12:14:31'),
(12, 'P', '001', 1, 'completed', '2025-10-12 12:10:05', '2025-10-12 12:14:43'),
(13, 'Q', '001', 1, 'completed', '2025-10-12 12:10:07', '2025-10-12 12:14:56'),
(14, 'E', '002', 1, 'completed', '2025-10-12 12:10:09', '2025-10-12 12:11:33'),
(15, 'F', '002', 1, 'completed', '2025-10-12 12:10:10', '2025-10-12 12:12:01'),
(16, 'F', '003', 0, 'completed', '2025-10-12 12:10:12', '2025-10-12 12:10:12'),
(17, 'G', '002', 1, 'completed', '2025-10-12 12:10:13', '2025-10-12 12:12:27'),
(18, 'H', '002', 0, 'completed', '2025-10-12 12:10:15', '2025-10-12 12:10:15'),
(19, 'I', '002', 0, 'completed', '2025-10-12 12:10:16', '2025-10-12 12:10:16'),
(20, 'J', '002', 1, 'completed', '2025-10-12 12:10:18', '2025-10-12 12:13:29'),
(21, 'K', '002', 1, 'completed', '2025-10-12 12:10:20', '2025-10-12 12:13:49'),
(22, 'L', '002', 0, 'completed', '2025-10-12 12:10:21', '2025-10-12 12:10:21'),
(23, 'M', '002', 0, 'completed', '2025-10-12 12:10:23', '2025-10-12 12:10:23'),
(24, 'N', '002', 0, 'completed', '2025-10-12 12:10:24', '2025-10-12 12:10:24'),
(25, 'O', '002', 0, 'completed', '2025-10-12 12:10:26', '2025-10-12 12:10:26'),
(26, 'P', '002', 0, 'completed', '2025-10-12 12:10:27', '2025-10-12 12:10:27'),
(27, 'Q', '002', 0, 'completed', '2025-10-12 12:10:30', '2025-10-12 12:10:30'),
(28, 'R', '001', 1, 'completed', '2025-10-12 12:10:32', '2025-10-12 12:15:05'),
(29, 'R', '002', 0, 'completed', '2025-10-12 12:10:33', '2025-10-12 12:10:33'),
(30, 'S', '001', 1, 'completed', '2025-10-12 12:10:35', '2025-10-12 12:15:12'),
(31, 'S', '002', 0, 'completed', '2025-10-12 12:10:36', '2025-10-12 12:10:36'),
(32, 'T', '001', 1, 'completed', '2025-10-12 12:10:38', '2025-10-12 12:15:25'),
(33, 'T', '002', 0, 'completed', '2025-10-12 12:10:39', '2025-10-12 12:10:39'),
(34, 'U', '001', 1, 'completed', '2025-10-12 12:10:41', '2025-10-12 12:15:39'),
(35, 'U', '002', 0, 'completed', '2025-10-12 12:10:43', '2025-10-12 12:10:43'),
(36, 'V', '001', 1, 'completed', '2025-10-12 12:10:45', '2025-10-12 12:15:47'),
(37, 'V', '002', 0, 'completed', '2025-10-12 12:10:47', '2025-10-12 12:10:47'),
(38, 'W', '001', 1, 'completed', '2025-10-12 12:10:48', '2025-10-12 12:15:57'),
(39, 'W', '002', 0, 'completed', '2025-10-12 12:10:50', '2025-10-12 12:10:50'),
(40, 'X', '001', 1, 'completed', '2025-10-12 12:10:52', '2025-10-12 12:16:13'),
(41, 'X', '002', 1, 'completed', '2025-10-12 12:10:54', '2025-10-12 12:16:37'),
(42, 'G', '003', 1, 'completed', '2025-10-12 12:17:07', '2025-10-12 12:18:11');

-- --------------------------------------------------------

--
-- Table structure for table `room_queue_calls`
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
-- Table structure for table `room_queue_history_calls`
--

DROP TABLE IF EXISTS `room_queue_history_calls`;
CREATE TABLE IF NOT EXISTS `room_queue_history_calls` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `room_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `number_queue` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `number_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `process_time_queue_room` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `room_queue_history_calls`
--

INSERT INTO `room_queue_history_calls` (`id`, `room_code`, `number_queue`, `number_code`, `process_time_queue_room`, `created_at`, `updated_at`) VALUES
(1, 'E', '001', 'E', 29, '2025-10-12 12:11:33', '2025-10-12 12:11:33'),
(2, 'F', '001', 'F', 17, '2025-10-12 12:12:01', '2025-10-12 12:12:01'),
(3, 'G', '001', 'G', 10, '2025-10-12 12:12:27', '2025-10-12 12:12:27'),
(4, 'J', '001', 'J', 22, '2025-10-12 12:13:29', '2025-10-12 12:13:29'),
(5, 'K', '001', 'K', 11, '2025-10-12 12:13:49', '2025-10-12 12:13:49'),
(6, 'X', '001', 'X', 24, '2025-10-12 12:16:37', '2025-10-12 12:16:37'),
(7, 'X', '002', 'X', 61, '2025-10-12 12:17:38', '2025-10-12 12:17:38'),
(8, 'G', '002', 'G', 344, '2025-10-12 12:18:11', '2025-10-12 12:18:11');

-- --------------------------------------------------------

--
-- Table structure for table `stat_consoles`
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
-- Dumping data for table `stat_consoles`
--

INSERT INTO `stat_consoles` (`id`, `tanggal`, `Status`, `ActiveDate`, `created_at`, `updated_at`) VALUES
(1, '20251012', 'active', '20251012', '2025-10-12 12:03:33', '2025-10-12 12:03:33');

-- --------------------------------------------------------

--
-- Table structure for table `users`
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
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin@admin.com', NULL, '$2y$10$heP7WRUdVy2RUrTHt34U8O1uA5Ng25I0PYtzhFR4MWej7NgzC7sdO', NULL, '2025-10-12 12:03:26', '2025-10-12 12:03:26');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `locket_queue`
--
ALTER TABLE `locket_queue`
  ADD CONSTRAINT `locket_queue_locket_staff_id_foreign` FOREIGN KEY (`locket_staff_id`) REFERENCES `locket_staff` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `room_dependencies`
--
ALTER TABLE `room_dependencies`
  ADD CONSTRAINT `room_dependencies_required_room_id_foreign` FOREIGN KEY (`required_room_id`) REFERENCES `rooms` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `room_dependencies_room_id_foreign` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
