-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versi server:                 8.0.30 - MySQL Community Server - GPL
-- OS Server:                    Win64
-- HeidiSQL Versi:               12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Membuang struktur basisdata untuk sim_ukk
CREATE DATABASE IF NOT EXISTS `sim_ukk` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `sim_ukk`;

-- membuang struktur untuk table sim_ukk.aspirasis
CREATE TABLE IF NOT EXISTS `aspirasis` (
  `id_pelaporan` bigint unsigned NOT NULL AUTO_INCREMENT,
  `status` enum('menunggu','proses','selesai') NOT NULL,
  `feedback` text,
  `tanggal_feedback` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_pelaporan`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Membuang data untuk tabel sim_ukk.aspirasis: ~2 rows (lebih kurang)
INSERT INTO `aspirasis` (`id_pelaporan`, `status`, `feedback`, `tanggal_feedback`, `created_at`, `updated_at`) VALUES
	(1, 'menunggu', NULL, NULL, '2026-01-27 00:45:54', '2026-01-27 00:45:54'),
	(2, 'proses', 'sabar woyyyyyyyyyyyyyyyyyyyyyyyy', '2026-01-27 18:21:44', '2026-01-27 00:46:02', '2026-01-27 18:21:44');

-- membuang struktur untuk table sim_ukk.cache
CREATE TABLE IF NOT EXISTS `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Membuang data untuk tabel sim_ukk.cache: ~0 rows (lebih kurang)

-- membuang struktur untuk table sim_ukk.cache_locks
CREATE TABLE IF NOT EXISTS `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Membuang data untuk tabel sim_ukk.cache_locks: ~0 rows (lebih kurang)

-- membuang struktur untuk table sim_ukk.failed_jobs
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Membuang data untuk tabel sim_ukk.failed_jobs: ~0 rows (lebih kurang)

-- membuang struktur untuk table sim_ukk.inputaspirasis
CREATE TABLE IF NOT EXISTS `inputaspirasis` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `id_pelaporan` bigint unsigned NOT NULL,
  `kategoris_id` bigint unsigned NOT NULL,
  `id_siswas` bigint unsigned NOT NULL,
  `lokasi` varchar(50) NOT NULL,
  `ket` text NOT NULL,
  `tanggal_lapor` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `inputaspirasis_id_pelaporan_foreign` (`id_pelaporan`),
  KEY `inputaspirasis_kategoris_id_foreign` (`kategoris_id`),
  KEY `inputaspirasis_id_siswas_foreign` (`id_siswas`),
  CONSTRAINT `inputaspirasis_id_pelaporan_foreign` FOREIGN KEY (`id_pelaporan`) REFERENCES `aspirasis` (`id_pelaporan`),
  CONSTRAINT `inputaspirasis_id_siswas_foreign` FOREIGN KEY (`id_siswas`) REFERENCES `siswas` (`id`),
  CONSTRAINT `inputaspirasis_kategoris_id_foreign` FOREIGN KEY (`kategoris_id`) REFERENCES `kategoris` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Membuang data untuk tabel sim_ukk.inputaspirasis: ~2 rows (lebih kurang)
INSERT INTO `inputaspirasis` (`id`, `id_pelaporan`, `kategoris_id`, `id_siswas`, `lokasi`, `ket`, `tanggal_lapor`, `created_at`, `updated_at`) VALUES
	(1, 1, 4, 1, 'pustaka', 'banyak buku yang rusak ac gak dingin', '2026-01-27 07:45:54', '2026-01-27 00:45:54', '2026-01-27 00:45:54'),
	(2, 2, 4, 1, 'pustaka', 'banyak buku yang rusak ac gak dingin', '2026-01-27 07:46:02', '2026-01-27 00:46:02', '2026-01-27 00:46:02');

-- membuang struktur untuk table sim_ukk.jobs
CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Membuang data untuk tabel sim_ukk.jobs: ~0 rows (lebih kurang)

-- membuang struktur untuk table sim_ukk.job_batches
CREATE TABLE IF NOT EXISTS `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Membuang data untuk tabel sim_ukk.job_batches: ~0 rows (lebih kurang)

-- membuang struktur untuk table sim_ukk.kategoris
CREATE TABLE IF NOT EXISTS `kategoris` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `ket_kategoris` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Membuang data untuk tabel sim_ukk.kategoris: ~5 rows (lebih kurang)
INSERT INTO `kategoris` (`id`, `ket_kategoris`, `created_at`, `updated_at`) VALUES
	(1, 'Ruang Kelas', '2026-01-27 00:40:21', '2026-01-27 00:40:21'),
	(2, 'Toilet', '2026-01-27 00:40:31', '2026-01-27 00:40:31'),
	(3, 'Listrik', '2026-01-27 00:40:40', '2026-01-27 00:40:40'),
	(4, 'Pustaka', '2026-01-27 00:40:47', '2026-01-27 00:40:47'),
	(5, 'Lab/Bengkel', '2026-01-27 00:40:58', '2026-01-27 00:40:58');

-- membuang struktur untuk table sim_ukk.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Membuang data untuk tabel sim_ukk.migrations: ~7 rows (lebih kurang)
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '0001_01_01_000000_create_users_table', 1),
	(2, '0001_01_01_000001_create_cache_table', 1),
	(3, '0001_01_01_000002_create_jobs_table', 1),
	(4, '2026_01_27_010020_create_siswas_table', 1),
	(5, '2026_01_27_010403_create_kategoris_table', 1),
	(6, '2026_01_27_011931_create_aspirasis_table', 1),
	(7, '2026_01_27_012025_create_inputaspirasis_table', 1);

-- membuang struktur untuk table sim_ukk.password_reset_tokens
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Membuang data untuk tabel sim_ukk.password_reset_tokens: ~0 rows (lebih kurang)

-- membuang struktur untuk table sim_ukk.sessions
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text,
  `payload` longtext NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Membuang data untuk tabel sim_ukk.sessions: ~5 rows (lebih kurang)
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
	('f8bDpgeWjpNn7vUuYLHsxwzoTK3395BHQEdvMZEO', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiaGhKZm40VjZjZGhnZnNjekdHbGtYbnZXSFlQRldBUGVZZmtaOXRXbCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzU6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9sYXBvcmFuIjt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9', 1769582028),
	('kvoMWSgcNYb3oMLFfNZAMrdktkZHoSrC1cYXuwBE', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiT01nTmFEdExrYzV0Z2trRE10QldnV05ERlNpTm1uS0JVTGNDdE8xcCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1769567111),
	('lTbvbC8nkbDqPbAmGtf2475aPbW44UPLyaPWAobX', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36 Edg/144.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiQjhOSGFzekp4cVU3ekNHNDFrU0VIdkFxZnF5STR1MFdXcm1mOXdUWiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9kYXNoYm9hcmQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=', 1769560634),
	('n8up6NiwrnYjDgDcbT4VatVgc7wqpY49Plz0gNl4', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoidVZTU0VyRHZtdWc4OVJuNlNtV3M0RHU3bGQ4M2R6SVVHemNscVo1cyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzU6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9zaXN3YS9oaXN0b3JpIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6Mjt9', 1769563627),
	('tJiHSFIxXur0TgXtrSqXzak4821kYOm7tEkiXekb', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiRXBiWllwcEZick5pYXhuME5CTUtIbGw5TGpRcnJVMnFiSlh5RldVeCI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czozMjoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL3Npc3dhL2J1YXQiO31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czoyNzoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2xvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1769582041);

-- membuang struktur untuk table sim_ukk.siswas
CREATE TABLE IF NOT EXISTS `siswas` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nisn` varchar(10) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `kelas` varchar(20) NOT NULL,
  `jurusan` varchar(50) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `siswas_nisn_unique` (`nisn`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Membuang data untuk tabel sim_ukk.siswas: ~1 rows (lebih kurang)
INSERT INTO `siswas` (`id`, `nisn`, `password`, `nama`, `kelas`, `jurusan`, `created_at`, `updated_at`) VALUES
	(1, '12042008', '$2y$12$nllIH8SGuYcLCjQ8o0TSnOccQfVns4FoeHXNZNsGRSHTwIs2U92L2', 'Raja', 'XII', 'RPL', '2026-01-26 19:59:36', '2026-01-26 19:59:36');

-- membuang struktur untuk table sim_ukk.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Membuang data untuk tabel sim_ukk.users: ~2 rows (lebih kurang)
INSERT INTO `users` (`id`, `username`, `password`, `created_at`, `updated_at`) VALUES
	(1, 'admin', '$2y$12$ulgpIxL0ICNnAMBuf6cWIeZSuz2MTleIZy0mKXrbezjaYYMP9PrGm', '2026-01-26 19:59:37', '2026-01-26 19:59:37'),
	(2, '12042008', '$2y$12$7GimPd.dALr9VuOA0VG.MudOfN7puRkARt6RQ3vcf6ZQgaa4Ox9Oa', '2026-01-26 19:59:37', '2026-01-26 19:59:37');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
