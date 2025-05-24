-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 24 Bulan Mei 2025 pada 18.22
-- Versi server: 10.4.27-MariaDB
-- Versi PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `persuratan-app`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `disposisi`
--

CREATE TABLE `disposisi` (
  `id_disposisi` bigint(20) UNSIGNED NOT NULL,
  `id_surat_masuk` bigint(20) UNSIGNED NOT NULL,
  `pendispo` varchar(255) NOT NULL,
  `penerimadispo` varchar(255) NOT NULL,
  `status_pegawai` varchar(255) DEFAULT NULL,
  `notulensi` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `disposisi`
--

INSERT INTO `disposisi` (`id_disposisi`, `id_surat_masuk`, `pendispo`, `penerimadispo`, `status_pegawai`, `notulensi`, `created_at`, `updated_at`) VALUES
(4, 2, 'Beni Supartono Putro, S.STP., M.Si.', 'Bagus Oki Wijaya Nugroho', 'Aktif', 'Rapat Sudah Selesai', '2024-07-01 05:23:46', '2024-07-01 05:26:15'),
(5, 2, 'Beni Supartono Putro, S.STP., M.Si.', 'Beni Supartono Putro, S.STP., M.Si.', 'Aktif', NULL, '2024-07-17 03:47:48', '2024-07-17 03:47:48');

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
-- Struktur dari tabel `jabatan`
--

CREATE TABLE `jabatan` (
  `id_jabatan` bigint(20) UNSIGNED NOT NULL,
  `nama_jabatan` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `id_tier` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `jabatan`
--

INSERT INTO `jabatan` (`id_jabatan`, `nama_jabatan`, `created_at`, `updated_at`, `id_tier`) VALUES
(9, 'Camat', '2024-05-07 22:54:39', '2024-06-25 08:39:06', 1),
(10, 'Sekretaris Kecamatan', '2024-05-07 22:55:29', '2024-06-10 20:30:50', 2),
(11, 'Kepala Seksi Pelayanan Publik', '2024-05-07 22:55:41', '2024-06-25 00:41:00', 4),
(12, 'Kepala Seksi Pembangunan', '2024-05-07 22:55:50', '2024-06-25 00:41:09', 4),
(13, 'Kepala Subbagian Perencanaan dan Keuangan', '2024-05-07 22:55:55', '2024-06-11 00:51:30', 3),
(14, 'Kepala Subbagian Administrasi Kepegawaian dan Organisasi', '2024-05-07 22:56:00', '2024-06-11 00:51:22', 3),
(15, 'Pengadministrasi Kependudukan', '2024-05-07 22:56:04', '2024-06-25 00:42:23', 5),
(16, 'Pranata Komputer Mahir', '2024-05-07 22:56:10', '2024-06-25 00:43:02', 5),
(17, 'Kepala Seksi Pemberdayaan Masyarakat', '2024-05-07 22:56:15', '2024-06-25 00:41:40', 4),
(20, 'Kepala Seksi Pemerintahan dan Ketertiban Umum', '2024-06-11 00:49:07', '2024-06-25 00:41:49', 4),
(21, 'Pengelola Gaji', '2024-06-11 00:49:44', '2024-06-25 00:42:29', 5),
(22, 'Pengelola Kepegawaian', '2024-06-11 00:50:02', '2024-06-25 00:42:35', 5),
(23, 'Staff', '2024-06-11 00:56:53', '2024-06-11 00:56:53', 5),
(25, 'Lurah Banjarsari', '2024-07-01 03:23:58', '2024-07-01 03:24:22', 4);

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategori_perihal`
--

CREATE TABLE `kategori_perihal` (
  `id_kp` bigint(20) UNSIGNED NOT NULL,
  `perihal` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `kategori_perihal`
--

INSERT INTO `kategori_perihal` (`id_kp`, `perihal`, `created_at`, `updated_at`) VALUES
(1, 'Undangan', NULL, '2024-05-05 23:24:17'),
(2, 'Permohonan', '2024-05-05 23:35:26', '2024-05-05 23:35:26');

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Struktur dari tabel `pegawai`
--

CREATE TABLE `pegawai` (
  `id_pegawai` bigint(20) UNSIGNED NOT NULL,
  `id_jabatan` bigint(20) UNSIGNED NOT NULL,
  `nama_pegawai` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `nip` int(24) NOT NULL,
  `file_foto` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `pegawai`
--

INSERT INTO `pegawai` (`id_pegawai`, `id_jabatan`, `nama_pegawai`, `email`, `nip`, `file_foto`, `created_at`, `updated_at`) VALUES
(4, 23, 'Bagus Oki Wijaya Nugroho', 'okik@gmail.com', 15, '1721186965_casual-life-3d-profile-picture-of-person-in-glasses-and-orange-shirt.png', '2024-05-07 22:58:02', '2024-07-17 03:29:25'),
(13, 9, 'Beni Supartono Putro, S.STP., M.Si.', 'beni@gmail.com', 1, '1718092834_pp.jpg', '2024-06-11 01:00:34', '2024-06-11 01:03:09'),
(14, 10, 'Saryanti, S.Sos., M.Si.', 'saryanti@gmail.com', 2, '1718092878_pp.jpg', '2024-06-11 01:01:18', '2024-06-11 01:03:20'),
(15, 11, 'Erna Widijastoeti, S.E., MM.', 'erna@gmail.com', 3, '1718092975_pp.jpg', '2024-06-11 01:02:55', '2024-06-11 01:07:15'),
(16, 17, 'Drs. Muhammad Nasrullah, MPA.', 'nasrulllah@gmail.com', 4, '1718093146_pp.jpg', '2024-06-11 01:05:46', '2024-06-11 01:05:46'),
(17, 20, 'Susilo, S.Sos.', 'susilo@gmail.com', 5, '1718093181_pp.jpg', '2024-06-11 01:06:21', '2024-06-11 01:06:21'),
(18, 12, 'Endang Pratiwi, S.Sos, MM.', 'endang@gmail.com', 6, '1718093226_pp.jpg', '2024-06-11 01:07:06', '2024-06-11 01:07:06'),
(19, 13, 'Meastika Dianeta, S.Si., MPA.', 'meastika@gmail.com', 7, '1718093281_pp.jpg', '2024-06-11 01:08:01', '2024-06-11 01:08:01'),
(20, 14, 'Deny Wismoyo, S.STP.', 'deny@gmail.com', 8, '1718093314_pp.jpg', '2024-06-11 01:08:34', '2024-06-11 01:08:34'),
(21, 15, 'Samsuri', 'samsuri@gmail.com', 9, '1718093344_pp.jpg', '2024-06-11 01:09:04', '2024-06-11 01:09:04'),
(22, 16, 'Andi Irfan Kholidaka, A.Md.', 'andi@gmail.com', 10, '1718093397_pp.jpg', '2024-06-11 01:09:57', '2024-06-11 01:09:57'),
(23, 21, 'Nurul Fatimah, S.E.', 'nurul@gmail.com', 11, '1718093429_pp.jpg', '2024-06-11 01:10:29', '2024-06-11 01:10:29'),
(24, 22, 'Etik Erliana, S.H.', 'etik@gmail.com', 12, '1718093501_pp.jpg', '2024-06-11 01:11:41', '2024-06-11 01:11:41'),
(25, 15, 'Eko Yulianto', 'eko@gmail.com', 13, '1718093533_pp.jpg', '2024-06-11 01:12:13', '2024-06-11 01:12:13'),
(30, 23, 'iku', 'bagusoki@student.uns.ac.id', 15, '1719603359_cute.jpg', '2024-06-28 19:35:59', '2024-06-28 19:35:59'),
(32, 23, 'bagus', 'bagusoki@gmail.com', 15, '1719811369_casual-life-3d-profile-picture-of-person-in-glasses-and-orange-shirt.png', '2024-07-01 05:22:50', '2024-07-01 05:22:50');

-- --------------------------------------------------------

--
-- Struktur dari tabel `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` varchar(255) DEFAULT NULL,
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
(141, 'App\\Models\\User', '9c2a36d7-96be-4108-a8b1-2b9d1d31d304', 'ApiToken', '87a7aad83740062e8f84046cf7046ddb35cbadce0e52ee453e51c51a70bb17b3', '{\"role\":\"admin\"}', NULL, NULL, '2024-05-30 00:14:45', '2024-05-30 00:14:45'),
(144, 'App\\Models\\User', '9c2a36d7-96be-4108-a8b1-2b9d1d31d304', 'ApiToken', 'c6a3b7c8d5d7ff6ffac8713a2c62ec520b02a96cd84db7d3839bb1355bfb5945', '{\"role\":\"admin\"}', '2024-05-30 00:23:28', NULL, '2024-05-30 00:23:14', '2024-05-30 00:23:28'),
(151, 'App\\Models\\User', '9c2a36d7-96be-4108-a8b1-2b9d1d31d304', 'ApiToken', 'c39d39e062f430fd6dd2c3ec31d2a016398ae23f04bc1e80f6643472d3253eb2', '{\"role\":\"admin\"}', '2024-05-30 02:19:07', NULL, '2024-05-30 01:28:40', '2024-05-30 02:19:07'),
(152, 'App\\Models\\User', '9c2a36ee-3667-4d56-926b-f73a7602d925', 'ApiToken', '729b3bc6f4a116b28a7f58315c4d66f055fc4da9963b4dd05ad4ffbf7881a67f', '{\"role\":\"admin\"}', '2024-05-30 02:26:37', NULL, '2024-05-30 02:20:06', '2024-05-30 02:26:37'),
(153, 'App\\Models\\User', '9c2a36d7-96be-4108-a8b1-2b9d1d31d304', 'ApiToken', 'b47686a09485311d929c6341a88e7ada1b8455a3b9175276fc75b2fc14cae3e3', '{\"role\":\"admin\"}', '2024-05-30 02:33:22', NULL, '2024-05-30 02:26:51', '2024-05-30 02:33:22'),
(154, 'App\\Models\\User', '9c2a36d7-96be-4108-a8b1-2b9d1d31d304', 'ApiToken', '375758e3bd909e2847bfcdb0a57c63cf1bb9eeb06d3ff761e6a268db0c7c2e90', '{\"role\":\"admin\"}', '2024-06-03 22:27:55', NULL, '2024-06-02 20:58:49', '2024-06-03 22:27:55'),
(156, 'App\\Models\\User', '9c2a36ee-3667-4d56-926b-f73a7602d925', 'ApiToken', 'b304b6cf03875f1b5d4fec7ffc01aabc99eb1999c07f75a6382a84110c6f2a10', '{\"role\":\"admin\"}', '2024-06-07 05:07:19', NULL, '2024-06-02 21:52:35', '2024-06-07 05:07:19'),
(163, 'App\\Models\\User', '9c2a36ee-3667-4d56-926b-f73a7602d925', 'ApiToken', 'b58fde453681b9f00645dc2bf2daa0c9f6f40207a5a66972cefbe847bfbdc336', '{\"role\":\"admin\"}', '2024-06-03 21:47:08', NULL, '2024-06-03 21:44:48', '2024-06-03 21:47:08'),
(164, 'App\\Models\\User', '9c2a36ee-3667-4d56-926b-f73a7602d925', 'ApiToken', '43ac29f320b3af05a4c38f9cc93762defbbf9567aec142e3f4a91fa6b42d77f3', '{\"role\":\"admin\"}', '2024-06-03 21:51:20', NULL, '2024-06-03 21:47:31', '2024-06-03 21:51:20'),
(165, 'App\\Models\\User', '9c2a36ee-3667-4d56-926b-f73a7602d925', 'ApiToken', '2dfc2c564c7cbebfc82c21a9c0149d2dc1550377cef5ea25ca10650871f0b9a3', '{\"role\":\"admin\"}', '2024-06-07 04:02:46', NULL, '2024-06-03 21:51:34', '2024-06-07 04:02:46'),
(166, 'App\\Models\\User', '9c07b778-2e27-4d7d-8fc9-58b633a84276', 'ApiToken', '7e3cf8563cc0ef0370338c3481837cfc8720049cf144387df7df17e4b1f107a4', '{\"role\":\"superadmin\"}', NULL, NULL, '2024-06-04 00:17:36', '2024-06-04 00:17:36'),
(182, 'App\\Models\\User', '9c2a36ee-3667-4d56-926b-f73a7602d925', 'ApiToken', 'b3516eb552b08e755ba03fa6963b581c0989e25acd9b887a9ff919b653f5a8ec', '{\"role\":\"admin\"}', '2024-06-07 03:12:21', NULL, '2024-06-05 00:02:53', '2024-06-07 03:12:21'),
(196, 'App\\Models\\User', '9c2a36ee-3667-4d56-926b-f73a7602d925', 'ApiToken', '9f17e8ba167cf35587c3695204c9d04aa66b40163741f4ce383502a34b596a20', '{\"role\":\"admin\"}', '2024-06-07 05:10:56', NULL, '2024-06-07 01:28:05', '2024-06-07 05:10:56'),
(204, 'App\\Models\\User', '9c2a36d7-96be-4108-a8b1-2b9d1d31d304', 'ApiToken', 'c4e1308716ceb659750359e421a40d1b7014d783eb40168ed7a7434610c7cc31', '{\"role\":\"camat\"}', '2024-06-09 19:31:34', NULL, '2024-06-09 19:31:31', '2024-06-09 19:31:34'),
(212, 'App\\Models\\User', '9c07b640-9676-4e08-b549-f3eace1b094d', 'ApiToken', 'c7d46248c3c1e1b073ced53f622e24b52ca023534efd48891b84e5884d2d44ec', '{\"role\":\"superadmin\"}', NULL, NULL, '2024-06-10 00:22:32', '2024-06-10 00:22:32'),
(229, 'App\\Models\\User', '9c410aa1-c765-4996-8bc4-449e02d649ed', 'ApiToken', '36e2c8da98a34d9c220ea11c3b34b4d25fea1c157691b220383ea4a72f740fa0', '{\"role\":\"admin\"}', '2024-06-10 20:59:08', NULL, '2024-06-10 08:22:43', '2024-06-10 20:59:08'),
(276, 'App\\Models\\User', '9c07b640-9676-4e08-b549-f3eace1b094d', 'ApiToken', '1f87c175918eb9a0015c04881ae43a42d16c2ef438cb8585fc260feb4cdb2fa0', '{\"role\":\"superadmin\"}', '2024-06-11 18:14:48', NULL, '2024-06-11 18:14:38', '2024-06-11 18:14:48'),
(281, 'App\\Models\\User', '9c427f43-825c-4cde-b199-c8fd3a362567', 'ApiToken', '18dfe96aea8f77e91bfba27e519fc6bcf7ddcb9180aeadb9ceeaff342bc8812b', '{\"role\":\"camat\"}', '2024-06-15 03:29:40', NULL, '2024-06-12 21:21:56', '2024-06-15 03:29:40'),
(289, 'App\\Models\\User', '9c427f43-825c-4cde-b199-c8fd3a362567', 'ApiToken', '4ac8a7c58e729406e4c1902356b814cfd5455ddbc33e3634f06a9e12cccc8a59', '{\"role\":\"camat\"}', '2024-06-20 10:14:32', NULL, '2024-06-20 09:40:36', '2024-06-20 10:14:32'),
(291, 'App\\Models\\User', '9c427f43-825c-4cde-b199-c8fd3a362567', 'ApiToken', '7db9dfe1c397ee606694368095cf9e8ff06c48c514ca15c65368b37328264d88', '{\"role\":\"camat\"}', '2024-06-20 20:18:48', NULL, '2024-06-20 19:52:04', '2024-06-20 20:18:48'),
(298, 'App\\Models\\User', '9c427f43-825c-4cde-b199-c8fd3a362567', 'ApiToken', 'd1b5b6f3ae84999f0778af0c35f591c185d611c84bcc5823c63dd2df102452bf', '{\"role\":\"camat\"}', '2024-06-21 00:37:41', NULL, '2024-06-21 00:35:36', '2024-06-21 00:37:41'),
(301, 'App\\Models\\User', '9c427f73-2e32-4ab1-b706-48676f021b25', 'ApiToken', 'e7ad8635369c8a29736d8d9cfd3c96f96cb516e72d64bb1f0fea5b99e10b0793', '{\"role\":\"admin\"}', '2024-06-24 19:54:18', NULL, '2024-06-24 19:47:10', '2024-06-24 19:54:18'),
(302, 'App\\Models\\User', '9c427f73-2e32-4ab1-b706-48676f021b25', 'ApiToken', 'a9249d8770aa43d00d8db2a6c2cf766c8203e6646993b93e07e5a3f0f22923c4', '{\"role\":\"admin\"}', '2024-06-24 23:47:26', NULL, '2024-06-24 20:57:33', '2024-06-24 23:47:26'),
(307, 'App\\Models\\User', '9c5e9c24-52a6-4494-b317-64e5b4aca1ab', 'ApiToken', '18cfc967164ddf0f4ddfdde88ea2bf7fe625a360cf4ec26a282ad684bed1a7d9', '{\"role\":\"admin\"}', '2024-06-25 02:24:43', NULL, '2024-06-25 01:18:41', '2024-06-25 02:24:43'),
(309, 'App\\Models\\User', '9c07b640-9676-4e08-b549-f3eace1b094d', 'ApiToken', '7ff267e3d0ded318178885a3ce7feac40579bb05d30ab8f2035feba142339cea', '{\"role\":\"superadmin\"}', '2024-06-25 23:53:43', NULL, '2024-06-25 19:02:50', '2024-06-25 23:53:43'),
(311, 'App\\Models\\User', '9c07b640-9676-4e08-b549-f3eace1b094d', 'ApiToken', '6d6b59a1148ba2dcbc5a3afb182b931c90438468f46e748922e4fe2d0eb3d6ab', '{\"role\":\"superadmin\"}', NULL, '2024-06-29 09:49:31', '2024-06-28 13:49:31', '2024-06-28 13:49:31'),
(312, 'App\\Models\\User', '9c07b640-9676-4e08-b549-f3eace1b094d', 'ApiToken', 'b68e86ade23be07a4d30bee057f5345e6fe29ed36951a5f0b724008167b00ead', '{\"role\":\"superadmin\"}', NULL, '2024-06-29 09:49:32', '2024-06-28 13:49:32', '2024-06-28 13:49:32'),
(313, 'App\\Models\\User', '9c07b640-9676-4e08-b549-f3eace1b094d', 'ApiToken', 'c3552eb02ebf5735101bd9af9b274421b2887d1011e2ad6ac188875deb65fa84', '{\"role\":\"superadmin\"}', NULL, '2024-06-29 09:49:33', '2024-06-28 13:49:33', '2024-06-28 13:49:33'),
(314, 'App\\Models\\User', '9c07b640-9676-4e08-b549-f3eace1b094d', 'ApiToken', '64f3e18ebec3463c4e45c75e4344a5b54474b08e3e5a3aa6e5eeae2fb01dc2a7', '{\"role\":\"superadmin\"}', NULL, '2024-06-29 09:49:34', '2024-06-28 13:49:34', '2024-06-28 13:49:34'),
(315, 'App\\Models\\User', '9c07b640-9676-4e08-b549-f3eace1b094d', 'ApiToken', '974e9f1cd5ccddc9bc221869298bde0f51116b7a8d51ce1ed2af31fe3e1eb5d3', '{\"role\":\"superadmin\"}', NULL, '2024-06-29 09:49:34', '2024-06-28 13:49:34', '2024-06-28 13:49:34'),
(316, 'App\\Models\\User', '9c07b640-9676-4e08-b549-f3eace1b094d', 'ApiToken', '01b858e8721c0683c5db9ab74f4830b6dfe74a4d99a824a3ea6b197729d56768', '{\"role\":\"superadmin\"}', NULL, '2024-06-29 09:49:35', '2024-06-28 13:49:35', '2024-06-28 13:49:35'),
(317, 'App\\Models\\User', '9c07b640-9676-4e08-b549-f3eace1b094d', 'ApiToken', '2f173f207623511dd496b93427d40e8fd303dd7a0520e99c94d0c26495503932', '{\"role\":\"superadmin\"}', '2024-06-28 18:36:35', '2024-06-29 09:49:41', '2024-06-28 13:49:41', '2024-06-28 18:36:35'),
(318, 'App\\Models\\User', '9c07b640-9676-4e08-b549-f3eace1b094d', 'ApiToken', '46027e652c2a7e02ebb333b319bbf806216a04f238bf45ae87c4ee9d85731c91', '{\"role\":\"superadmin\"}', NULL, '2024-06-29 15:28:02', '2024-06-28 19:28:02', '2024-06-28 19:28:02'),
(319, 'App\\Models\\User', '9c427f43-825c-4cde-b199-c8fd3a362567', 'ApiToken', '7802d026e92fdd9b3ceb2f0a68e7731f693300df154a637d9c4d220f68d74959', '{\"role\":\"camat\"}', '2024-06-28 19:51:04', '2024-06-29 15:46:02', '2024-06-28 19:46:02', '2024-06-28 19:51:04'),
(320, 'App\\Models\\User', '9c65a8b5-d425-421f-a95f-4d265ef49642', 'ApiToken', '6283ec18238f385a5b7eb57132b35e1338f751b6ee9c892d25292cbc597f3e4b', '{\"role\":\"admin\"}', NULL, '2024-06-29 15:53:06', '2024-06-28 19:53:06', '2024-06-28 19:53:06'),
(321, 'App\\Models\\User', '9c65a8b5-d425-421f-a95f-4d265ef49642', 'ApiToken', 'bc2d7c355a5282dc1216df8df67db9a809af023a6750d2973e8a700bb5f5f752', '{\"role\":\"camat\"}', '2024-06-28 19:57:38', '2024-06-29 15:53:44', '2024-06-28 19:53:44', '2024-06-28 19:57:38'),
(322, 'App\\Models\\User', '9c427f43-825c-4cde-b199-c8fd3a362567', 'ApiToken', '624e2c410c4503acde181c728b6850fabbd70247a200f5271560243c4b01867a', '{\"role\":\"camat\"}', '2024-06-29 16:33:06', '2024-06-30 12:32:36', '2024-06-29 16:32:36', '2024-06-29 16:33:06'),
(325, 'App\\Models\\User', '9c07b640-9676-4e08-b549-f3eace1b094d', 'ApiToken', '75e5dfa14ee5da4452d40449081064e82be2f9ee475b657e419f982e0f392deb', '{\"role\":\"superadmin\"}', '2024-06-30 11:41:30', '2024-07-01 07:25:30', '2024-06-30 11:25:30', '2024-06-30 11:41:30'),
(328, 'App\\Models\\User', '9c07b640-9676-4e08-b549-f3eace1b094d', 'ApiToken', 'e01ff8cd1b9ea2aa26c398cd971f8bd76bad38e5e27df650d8802ecd858ba6c0', '{\"role\":\"superadmin\"}', '2024-06-30 22:01:00', '2024-07-01 09:29:25', '2024-06-30 13:29:25', '2024-06-30 22:01:00'),
(329, 'App\\Models\\User', '9c07b640-9676-4e08-b549-f3eace1b094d', 'ApiToken', 'db7421ef44feabec11c299420f0a189012729aef2b44819e7518ee80ebd69371', '{\"role\":\"superadmin\"}', NULL, '2024-07-01 18:00:54', '2024-06-30 22:00:54', '2024-06-30 22:00:54'),
(330, 'App\\Models\\User', '9c07b640-9676-4e08-b549-f3eace1b094d', 'ApiToken', '49e5910353a2131f20dde3620b3cb87b05510bbe1ef5bc660677d9d5280af94f', '{\"role\":\"superadmin\"}', NULL, '2024-07-01 18:00:55', '2024-06-30 22:00:55', '2024-06-30 22:00:55'),
(331, 'App\\Models\\User', '9c07b640-9676-4e08-b549-f3eace1b094d', 'ApiToken', '3191d2010d0f29fc21e01bdfe4fb67413c0bc89b29c59ec517eb70372c31701e', '{\"role\":\"superadmin\"}', NULL, '2024-07-01 18:00:56', '2024-06-30 22:00:56', '2024-06-30 22:00:56'),
(332, 'App\\Models\\User', '9c07b640-9676-4e08-b549-f3eace1b094d', 'ApiToken', 'af82c63d4429be95e8482c7583bd31f744a299b58d5440cd95c0482a9ea15305', '{\"role\":\"superadmin\"}', NULL, '2024-07-01 18:00:57', '2024-06-30 22:00:57', '2024-06-30 22:00:57'),
(333, 'App\\Models\\User', '9c07b640-9676-4e08-b549-f3eace1b094d', 'ApiToken', '7daaeba332f7e8f03bedaff23ee0334fb13280ddf0c20790acec8e5a2e7ad23f', '{\"role\":\"superadmin\"}', NULL, '2024-07-01 18:00:58', '2024-06-30 22:00:58', '2024-06-30 22:00:58'),
(334, 'App\\Models\\User', '9c07b640-9676-4e08-b549-f3eace1b094d', 'ApiToken', 'd3227d7b146ee3d036cbb4236c686dab43d29bc9ed7808f59dd1e269b442f606', '{\"role\":\"superadmin\"}', NULL, '2024-07-01 18:00:58', '2024-06-30 22:00:58', '2024-06-30 22:00:59'),
(335, 'App\\Models\\User', '9c07b640-9676-4e08-b549-f3eace1b094d', 'ApiToken', '5a3b38caa3f6a27aab81c3669dffdcb36aee1e46fed0634c8512ef4bebc1dca9', '{\"role\":\"superadmin\"}', '2024-07-01 03:10:28', '2024-07-01 18:01:01', '2024-06-30 22:01:01', '2024-07-01 03:10:28'),
(336, 'App\\Models\\User', '9c07b640-9676-4e08-b549-f3eace1b094d', 'ApiToken', 'a2b22800957b0f9b6e603f47908c65c801ec67d3f957561aed236ab2b241a978', '{\"role\":\"superadmin\"}', '2024-07-01 03:10:40', '2024-07-01 23:10:31', '2024-07-01 03:10:31', '2024-07-01 03:10:40'),
(350, 'App\\Models\\User', '9c6a796e-0029-4447-bfda-659fd9dd1b7c', 'ApiToken', 'acc52ae0a72e8a468b54725d722f9222c324e1d1c0f6a8554dd9010880f6e42f', '{\"role\":\"admin\"}', '2024-07-01 05:26:22', '2024-07-02 01:25:36', '2024-07-01 05:25:36', '2024-07-01 05:26:22'),
(357, 'App\\Models\\User', '9c07b640-9676-4e08-b549-f3eace1b094d', 'ApiToken', 'dd674aceb02712925cbc7b2d86b7c12e0a4611b39cf92654b8a30ec6af92a826', '{\"role\":\"superadmin\"}', '2024-07-17 03:49:02', '2024-07-17 23:48:17', '2024-07-17 03:48:17', '2024-07-17 03:49:02'),
(358, 'App\\Models\\User', '9c07b640-9676-4e08-b549-f3eace1b094d', 'ApiToken', '77f214759c7b53c62dfd84e1276c465cf02297873b49149d7decdf2dba32e83c', '{\"role\":\"superadmin\"}', '2025-05-24 11:21:51', '2025-05-25 07:21:45', '2025-05-24 11:21:45', '2025-05-24 11:21:51');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pesan`
--

CREATE TABLE `pesan` (
  `id_pesan` bigint(20) UNSIGNED NOT NULL,
  `id_surat_masuk` bigint(20) UNSIGNED NOT NULL,
  `perintah_dispo` varchar(255) NOT NULL,
  `pendispo` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pesan`
--

INSERT INTO `pesan` (`id_pesan`, `id_surat_masuk`, `perintah_dispo`, `pendispo`, `created_at`, `updated_at`) VALUES
(3, 2, 'Saya akan menghadiri undangan', 'Beni Supartono Putro, S.STP., M.Si.', '2024-07-01 05:11:56', '2024-07-01 05:11:56'),
(4, 2, 'Hadiri Undangan', 'Beni Supartono Putro, S.STP., M.Si.', '2024-07-01 05:12:34', '2024-07-01 05:12:34'),
(5, 2, 'Hadiri', 'Beni Supartono Putro, S.STP., M.Si.', '2024-07-01 05:23:47', '2024-07-01 05:23:47'),
(6, 2, 'Hadiri', 'Beni Supartono Putro, S.STP., M.Si.', '2024-07-17 03:47:48', '2024-07-17 03:47:48');

-- --------------------------------------------------------

--
-- Struktur dari tabel `surat_keluar`
--

CREATE TABLE `surat_keluar` (
  `id_surat_keluar` bigint(20) UNSIGNED NOT NULL,
  `perihal` varchar(255) NOT NULL,
  `no_surat` varchar(255) DEFAULT NULL,
  `tipe_surat` varchar(255) NOT NULL DEFAULT 'Surat Keluar',
  `tanggal_keluar` date NOT NULL,
  `tempat_agenda` varchar(255) DEFAULT NULL,
  `tanggal_agenda` datetime DEFAULT NULL,
  `tertuju_kepada` varchar(255) NOT NULL,
  `isi_ringkas` varchar(255) NOT NULL,
  `file_surat` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `surat_keluar`
--

INSERT INTO `surat_keluar` (`id_surat_keluar`, `perihal`, `no_surat`, `tipe_surat`, `tanggal_keluar`, `tempat_agenda`, `tanggal_agenda`, `tertuju_kepada`, `isi_ringkas`, `file_surat`, `created_at`, `updated_at`) VALUES
(1, 'Undangan', 'SU/1278671/24', 'Surat Keluar', '2024-07-01', 'Pendopo Kecamatan', '2024-07-04 10:00:00', 'Dinas Kesehatan', 'Lintas Sektoral', '1719803707_CamScanner 07-01-2024 09.53.pdf', '2024-07-01 03:15:07', '2024-07-01 03:16:33'),
(2, 'Permohonan', '421.2/309/SDN63/VI/2024', 'Surat Keluar', '2024-07-01', 'Solo', '2024-07-01 10:17:00', 'Kabupaten Sukoharjo', 'Rapat', '1719803872_CamScanner 07-01-2024 09.53.pdf', '2024-07-01 03:17:52', '2024-07-01 03:17:52');

-- --------------------------------------------------------

--
-- Struktur dari tabel `surat_masuk`
--

CREATE TABLE `surat_masuk` (
  `id_surat_masuk` bigint(20) UNSIGNED NOT NULL,
  `perihal` varchar(255) DEFAULT NULL,
  `tipe_surat` varchar(255) NOT NULL DEFAULT 'Surat Masuk',
  `kode` varchar(255) DEFAULT NULL,
  `sifat_surat` varchar(255) DEFAULT NULL,
  `no_agenda` bigint(20) DEFAULT NULL,
  `no_surat` varchar(255) DEFAULT NULL,
  `tanggal_diterima` date NOT NULL,
  `tanggal_agenda` datetime DEFAULT NULL,
  `tempat_agenda` varchar(255) DEFAULT NULL,
  `pengirim` varchar(255) NOT NULL,
  `isi_ringkas` varchar(255) NOT NULL,
  `file_surat` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `surat_masuk`
--

INSERT INTO `surat_masuk` (`id_surat_masuk`, `perihal`, `tipe_surat`, `kode`, `sifat_surat`, `no_agenda`, `no_surat`, `tanggal_diterima`, `tanggal_agenda`, `tempat_agenda`, `pengirim`, `isi_ringkas`, `file_surat`, `created_at`, `updated_at`) VALUES
(2, 'Undangan', 'Surat Masuk', '-', 'Penting', 1, '421.2/309/SDN63/VI/2024', '2024-07-17', '2024-07-17 11:40:00', 'SDN Mangkubumen Wetan', 'SDN Mangkubumen Wetan', 'Undangan menghadiri perayaan gelar karya', '1719808937.Surat Undangan SDN Mangkubumen Wetan.pdf', '2024-07-01 04:42:17', '2024-07-17 03:40:48'),
(3, 'Undangan', 'Surat Masuk', NULL, NULL, NULL, NULL, '2024-07-17', NULL, NULL, 'SDN Mangkubumen Wetan', 'Hadiri', '1721188136.Surat Undangan SDN Mangkubumen Wetan.pdf', '2024-07-17 03:48:56', '2024-07-17 03:48:56');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tiers`
--

CREATE TABLE `tiers` (
  `id_tier` int(11) NOT NULL,
  `tier_name` varchar(255) DEFAULT NULL,
  `tier_level` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tiers`
--

INSERT INTO `tiers` (`id_tier`, `tier_name`, `tier_level`) VALUES
(1, 'Eselon III A', 1),
(2, 'Eselon III B', 2),
(3, 'Eselon IV B', 3),
(4, 'Eselon IV A', 4),
(5, 'Staff', 5);

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` char(36) NOT NULL,
  `id_pegawai` bigint(20) UNSIGNED NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'admin',
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `id_pegawai`, `role`, `username`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
('9c07b640-9676-4e08-b549-f3eace1b094d', 4, 'superadmin', 'okik', '$2y$10$Lt2EOCJ4t7eCg8HvuoaLJeyqfRboWUDD8NpPtntiAwEWp2MLy/uTm', NULL, '2024-05-12 20:02:44', '2024-05-12 20:02:44'),
('9c427f43-825c-4cde-b199-c8fd3a362567', 13, 'camat', 'camat', '$2y$10$o9ejuNsqdlt7hyhUNZ4wsuGsBi//9m9SF50y5A.Oa.QauCpusxn8W', NULL, '2024-06-11 01:22:49', '2024-06-11 01:22:49'),
('9c6a796e-0029-4447-bfda-659fd9dd1b7c', 4, 'admin', 'bagus', '$2y$10$E3bMFiHqqiXerkFcodc/j.D820T6JIHVBhAOQTAugfWAp8sEaz2FW', NULL, '2024-07-01 05:19:37', '2024-07-01 05:19:37');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `disposisi`
--
ALTER TABLE `disposisi`
  ADD PRIMARY KEY (`id_disposisi`),
  ADD KEY `fk_id_surat` (`id_surat_masuk`),
  ADD KEY `penerimadispo` (`penerimadispo`),
  ADD KEY `status_pegawai` (`status_pegawai`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `jabatan`
--
ALTER TABLE `jabatan`
  ADD PRIMARY KEY (`id_jabatan`),
  ADD KEY `id_tier` (`id_tier`);

--
-- Indeks untuk tabel `kategori_perihal`
--
ALTER TABLE `kategori_perihal`
  ADD PRIMARY KEY (`id_kp`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indeks untuk tabel `pegawai`
--
ALTER TABLE `pegawai`
  ADD PRIMARY KEY (`id_pegawai`),
  ADD KEY `id_jabatan` (`id_jabatan`);

--
-- Indeks untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indeks untuk tabel `pesan`
--
ALTER TABLE `pesan`
  ADD PRIMARY KEY (`id_pesan`),
  ADD KEY `id_disposisi` (`id_surat_masuk`);

--
-- Indeks untuk tabel `surat_keluar`
--
ALTER TABLE `surat_keluar`
  ADD PRIMARY KEY (`id_surat_keluar`);

--
-- Indeks untuk tabel `surat_masuk`
--
ALTER TABLE `surat_masuk`
  ADD PRIMARY KEY (`id_surat_masuk`);

--
-- Indeks untuk tabel `tiers`
--
ALTER TABLE `tiers`
  ADD PRIMARY KEY (`id_tier`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD KEY `id_pegawai` (`id_pegawai`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `disposisi`
--
ALTER TABLE `disposisi`
  MODIFY `id_disposisi` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `jabatan`
--
ALTER TABLE `jabatan`
  MODIFY `id_jabatan` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT untuk tabel `kategori_perihal`
--
ALTER TABLE `kategori_perihal`
  MODIFY `id_kp` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `pegawai`
--
ALTER TABLE `pegawai`
  MODIFY `id_pegawai` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=359;

--
-- AUTO_INCREMENT untuk tabel `pesan`
--
ALTER TABLE `pesan`
  MODIFY `id_pesan` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `surat_keluar`
--
ALTER TABLE `surat_keluar`
  MODIFY `id_surat_keluar` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `surat_masuk`
--
ALTER TABLE `surat_masuk`
  MODIFY `id_surat_masuk` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `tiers`
--
ALTER TABLE `tiers`
  MODIFY `id_tier` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `disposisi`
--
ALTER TABLE `disposisi`
  ADD CONSTRAINT `fk_id_surat` FOREIGN KEY (`id_surat_masuk`) REFERENCES `surat_masuk` (`id_surat_masuk`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `jabatan`
--
ALTER TABLE `jabatan`
  ADD CONSTRAINT `fk_id_tier` FOREIGN KEY (`id_tier`) REFERENCES `tiers` (`id_tier`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `pegawai`
--
ALTER TABLE `pegawai`
  ADD CONSTRAINT `pegawai_ibfk_1` FOREIGN KEY (`id_jabatan`) REFERENCES `jabatan` (`id_jabatan`) ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pesan`
--
ALTER TABLE `pesan`
  ADD CONSTRAINT `fk_id_surat_masuk` FOREIGN KEY (`id_surat_masuk`) REFERENCES `surat_masuk` (`id_surat_masuk`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`id_pegawai`) REFERENCES `pegawai` (`id_pegawai`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
