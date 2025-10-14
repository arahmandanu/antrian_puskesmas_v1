-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Oct 14, 2025 at 07:10 PM
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
(1, 'Puskesmas Kramat Jati', 'Kramat Jati', 1, NULL, NULL, '2025-10-14 19:10:47', '2025-10-14 19:10:47');

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
  `locket_queue_id` bigint UNSIGNED DEFAULT NULL,
  `locket_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `locket_number` int DEFAULT NULL,
  `locket_staff_id` int DEFAULT NULL,
  `locket_staff_name` text COLLATE utf8mb4_unicode_ci,
  `number_queue` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `process_time_queue_locket` int DEFAULT NULL,
  `called_at` timestamp NULL DEFAULT NULL,
  `awaiting_called_duration` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_locket_code_created` (`locket_code`,`created_at`),
  KEY `idx_locket_queue_id_created` (`locket_queue_id`,`created_at`),
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(2, 'App\\Models\\User', 1);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'web', '2025-10-14 19:10:23', '2025-10-14 19:10:23'),
(2, 'super admin', 'web', '2025-10-14 19:10:23', '2025-10-14 19:10:23');

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
(1, 'E', '24 JAM', NULL, 1, 1, NULL, NULL, NULL, '2025-10-14 19:10:23', '2025-10-14 19:10:23'),
(2, 'F', 'RB', NULL, 1, 1, NULL, NULL, NULL, '2025-10-14 19:10:23', '2025-10-14 19:10:23'),
(3, 'G', 'IMS', NULL, 1, 1, NULL, NULL, NULL, '2025-10-14 19:10:23', '2025-10-14 19:10:23'),
(4, 'H', 'PDP', NULL, 1, 1, NULL, NULL, NULL, '2025-10-14 19:10:23', '2025-10-14 19:10:23'),
(5, 'I', 'TB', NULL, 1, 1, NULL, NULL, NULL, '2025-10-14 19:10:23', '2025-10-14 19:10:23'),
(6, 'J', 'UMUM', NULL, 1, 2, NULL, NULL, NULL, '2025-10-14 19:10:23', '2025-10-14 19:10:23'),
(7, 'K', 'Gigi', NULL, 1, 2, NULL, NULL, NULL, '2025-10-14 19:10:23', '2025-10-14 19:10:23'),
(8, 'L', 'Laborate', NULL, 1, 2, NULL, NULL, NULL, '2025-10-14 19:10:23', '2025-10-14 19:10:23'),
(9, 'M', 'Lansia', NULL, 1, 2, NULL, NULL, NULL, '2025-10-14 19:10:23', '2025-10-14 19:10:23'),
(10, 'N', 'UBM', NULL, 1, 2, NULL, NULL, NULL, '2025-10-14 19:10:23', '2025-10-14 19:10:23'),
(11, 'O', 'CATIN', NULL, 1, 2, NULL, NULL, NULL, '2025-10-14 19:10:23', '2025-10-14 19:10:23'),
(12, 'P', 'Psikologi', NULL, 1, 2, NULL, NULL, NULL, '2025-10-14 19:10:23', '2025-10-14 19:10:23'),
(13, 'Q', 'Haji', NULL, 1, 2, NULL, NULL, NULL, '2025-10-14 19:10:23', '2025-10-14 19:10:23'),
(14, 'R', 'PTM', NULL, 1, 2, NULL, NULL, NULL, '2025-10-14 19:10:23', '2025-10-14 19:10:23'),
(15, 'S', 'MTBS', NULL, 1, 2, NULL, NULL, NULL, '2025-10-14 19:10:23', '2025-10-14 19:10:23'),
(16, 'T', 'PKPR', NULL, 1, 2, NULL, NULL, NULL, '2025-10-14 19:10:23', '2025-10-14 19:10:23'),
(17, 'U', 'Jiwa', NULL, 1, 2, NULL, NULL, NULL, '2025-10-14 19:10:23', '2025-10-14 19:10:23'),
(18, 'V', 'Gizi', NULL, 1, 2, NULL, NULL, NULL, '2025-10-14 19:10:23', '2025-10-14 19:10:23'),
(19, 'W', 'CKG', NULL, 1, 2, NULL, NULL, NULL, '2025-10-14 19:10:23', '2025-10-14 19:10:23'),
(20, 'X', 'Nurse Station', NULL, 1, 2, NULL, NULL, NULL, '2025-10-14 19:10:23', '2025-10-14 19:10:23');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  `room_id` bigint UNSIGNED DEFAULT NULL,
  `room_queue_id` bigint UNSIGNED DEFAULT NULL,
  `room_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `number_queue` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `number_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `process_time_queue_room` int DEFAULT NULL,
  `called_at` timestamp NULL DEFAULT NULL,
  `awaiting_called_duration` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_room_code_created` (`room_code`,`created_at`),
  KEY `idx_room_queue_id_created` (`room_queue_id`,`created_at`),
  KEY `idx_room_id_created` (`room_id`,`created_at`),
  KEY `idx_room_id_avg_process` (`room_id`,`created_at`,`process_time_queue_room`),
  KEY `idx_room_id_avg_await` (`room_id`,`created_at`,`awaiting_called_duration`),
  KEY `idx_created_at_only` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stat_consoles`
--

INSERT INTO `stat_consoles` (`id`, `tanggal`, `Status`, `ActiveDate`, `created_at`, `updated_at`) VALUES
(1, '20251015', 'active', '20251015', '2025-10-14 19:10:47', '2025-10-14 19:10:47'),
(2, '20251015', 'active', '20251015', '2025-10-14 19:10:47', '2025-10-14 19:10:47'),
(3, '20251015', 'active', '20251015', '2025-10-14 19:10:47', '2025-10-14 19:10:47'),
(4, '20251015', 'active', '20251015', '2025-10-14 19:10:47', '2025-10-14 19:10:47');

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
(1, 'Admin', 'admin@admin.com', NULL, '$2y$10$S6spwhzc.AOqPhZKqwG0D.yOJBvL1IaNkU5FWHU8rJSoHrGjR/fuS', NULL, '2025-10-14 19:10:23', '2025-10-14 19:10:23');

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
