-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 20, 2022 at 06:56 PM
-- Server version: 10.4.19-MariaDB
-- PHP Version: 8.0.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `stikesnh_absensi`
--

-- --------------------------------------------------------

--
-- Table structure for table `auth_activation_attempts`
--

CREATE TABLE `auth_activation_attempts` (
  `id` int(11) UNSIGNED NOT NULL,
  `ip_address` varchar(255) NOT NULL,
  `user_agent` varchar(255) NOT NULL,
  `token` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `auth_activation_attempts`
--

INSERT INTO `auth_activation_attempts` (`id`, `ip_address`, `user_agent`, `token`, `created_at`) VALUES
(1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36', '227be67c6c3cff38843f56ccfb6eab72', '2021-07-13 10:56:28'),
(2, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36', 'f08f164e558edc148159db4371ae7ada', '2021-07-13 11:11:59'),
(3, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36', 'cfedb4f47eeea35619291546faddd215', '2021-07-13 22:46:31'),
(4, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36', '9d39d3b7be05c8339b9474ba1e67771d', '2021-07-14 09:44:26');

-- --------------------------------------------------------

--
-- Table structure for table `auth_groups`
--

CREATE TABLE `auth_groups` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `auth_groups`
--

INSERT INTO `auth_groups` (`id`, `name`, `description`) VALUES
(1, 'superadmin', 'mengelola web'),
(2, 'admin', 'adminweb');

-- --------------------------------------------------------

--
-- Table structure for table `auth_groups_permissions`
--

CREATE TABLE `auth_groups_permissions` (
  `group_id` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `permission_id` int(11) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `auth_groups_permissions`
--

INSERT INTO `auth_groups_permissions` (`group_id`, `permission_id`) VALUES
(1, 1),
(1, 2),
(2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `auth_groups_users`
--

CREATE TABLE `auth_groups_users` (
  `group_id` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `user_id` int(11) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `auth_groups_users`
--

INSERT INTO `auth_groups_users` (`group_id`, `user_id`) VALUES
(1, 1),
(2, 5);

-- --------------------------------------------------------

--
-- Table structure for table `auth_logins`
--

CREATE TABLE `auth_logins` (
  `id` int(11) UNSIGNED NOT NULL,
  `ip_address` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `user_id` int(11) UNSIGNED DEFAULT NULL,
  `date` datetime NOT NULL,
  `success` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `auth_logins`
--

INSERT INTO `auth_logins` (`id`, `ip_address`, `email`, `user_id`, `date`, `success`) VALUES
(1, '::1', 'baginda.umam@gmail.com', 1, '2021-07-13 10:56:41', 1),
(2, '::1', 'baginda.umam@gmail.com', 1, '2021-07-13 10:56:50', 1),
(3, '::1', 'baginda.umam@gmail.com', 1, '2021-07-13 10:57:46', 1),
(4, '::1', 'baginda.umam@gmail.com', 1, '2021-07-13 11:07:54', 1),
(5, '::1', 'pkmpi.stikesnhm@gmail.com', 2, '2021-07-13 11:12:19', 1),
(6, '::1', 'baginda.umam@gmail.com', 1, '2021-07-13 11:12:37', 1),
(7, '::1', 'pkmpi.stikesnhm@gmail.com', 2, '2021-07-13 11:13:28', 1),
(8, '::1', 'pkmpi.stikesnhm@gmail.com', 2, '2021-07-13 11:13:39', 1),
(9, '::1', 'pkmpi.stikesnhm@gmail.com', 2, '2021-07-13 11:14:33', 1),
(10, '::1', 'pkmpi.stikesnhm@gmail.com', 2, '2021-07-13 11:15:15', 1),
(11, '::1', 'pkmpi.stikesnhm@gmail.com', 2, '2021-07-13 11:15:48', 1),
(12, '::1', 'pkmpi.stikesnhm@gmail.com', 2, '2021-07-13 21:48:08', 1),
(13, '::1', 'baginda.umam@gmail.com', 1, '2021-07-13 21:48:27', 1),
(14, '::1', 'baginda.umam@gmail.com', 1, '2021-07-13 22:45:07', 1),
(15, '::1', 'baginda.umam@gmail.com', 1, '2021-07-13 23:30:00', 1),
(16, '::1', 'bau.nhm@gmail.com', 3, '2021-07-13 23:30:13', 1),
(17, '::1', 'baginda.umam@gmail.com', 1, '2021-07-13 23:30:24', 1),
(18, '::1', 'bau.nhm@gmail.com', NULL, '2021-07-13 23:30:48', 0),
(19, '::1', 'bau.nhm@gmail.com', 3, '2021-07-13 23:30:54', 1),
(20, '::1', 'bau.nhm@gmail.com', 3, '2021-07-13 23:31:17', 1),
(21, '::1', 'baginda.umam@gmail.com', 1, '2021-07-13 23:35:55', 1),
(22, '::1', 'baginda.umam@gmail.com', 1, '2021-07-13 23:36:23', 1),
(23, '::1', 'baginda.umam@gmail.com', 1, '2021-07-13 23:36:59', 1),
(24, '::1', 'baginda.umam@gmail.com', 1, '2021-07-13 23:43:28', 1),
(25, '::1', 'pkmpi.stikesnhm@gmail.com', 2, '2021-07-14 00:05:13', 1),
(26, '::1', 'baginda.umam@gmail.com', 1, '2021-07-14 07:46:36', 1),
(27, '::1', 'bau.nhm@gmail.com', 4, '2021-07-14 09:44:45', 1),
(28, '::1', 'pkmpi.stikesnhm@gmail.com', 2, '2021-07-14 09:45:03', 1),
(29, '::1', 'baginda.umam@gmail.com', 1, '2021-07-14 10:58:02', 1),
(30, '::1', 'pkmpi.stikesnhm@gmail.com', 2, '2021-07-14 21:25:28', 1),
(31, '::1', 'pkmpi.stikesnhm@gmail.com', 2, '2021-07-14 22:38:47', 1),
(32, '::1', 'baginda.umam@gmail.com', 1, '2021-07-15 03:29:59', 1),
(33, '::1', 'pkmpi.stikesnhm@gmail.com', 2, '2021-07-15 07:24:46', 1),
(34, '::1', 'baginda.umam@gmail.com', NULL, '2021-07-17 08:47:15', 0),
(35, '::1', 'baginda.umam@gmail.com', 1, '2021-07-17 08:47:21', 1),
(36, '::1', 'pkmpi.stikesnhm@gmail.com', 2, '2021-07-20 21:33:32', 1),
(37, '::1', 'pkmpi.stikesnhm@gmail.com', 2, '2021-07-20 22:39:08', 1),
(38, '::1', 'pkmpi.stikesnhm@gmail.com', 2, '2021-07-21 08:00:32', 1),
(39, '::1', 'pkmpi.stikesnhm@gmail.com', 2, '2021-07-22 03:14:56', 1),
(40, '::1', 'pkmpi.stikesnhm@gmail.com', 2, '2021-07-22 03:19:12', 1),
(41, '::1', 'pkmpi.stikesnhm@gmail.com', 2, '2021-07-22 07:22:53', 1),
(42, '::1', 'pkmpi.stikesnhm@gmail.com', 2, '2021-07-24 08:19:02', 1),
(43, '::1', 'pkmpi.stikesnhm@gmail.com', 2, '2021-07-25 20:16:42', 1),
(44, '::1', 'pkmpi.stikesnhm@gmail.com', 2, '2021-07-29 08:06:02', 1),
(45, '::1', 'pkmpi.stikesnhm@gmail.com', 2, '2021-07-29 09:12:23', 1),
(46, '::1', 'pkmpi.stikesnhm@gmail.com', 2, '2021-07-29 09:59:01', 1),
(47, '::1', 'pkmpi.stikesnhm@gmail.com', 2, '2021-08-01 21:59:25', 1),
(48, '::1', 'pkmpi.stikesnhm@gmail.com', 2, '2021-08-03 07:42:05', 1),
(49, '::1', 'pkmpi.stikesnhm@gmail.com', 2, '2021-08-07 08:27:22', 1),
(50, '::1', 'pkmpi.stikesnhm@gmail.com', 2, '2021-08-07 21:49:09', 1),
(51, '::1', 'pkmpi.stikesnhm@gmail.com', 2, '2021-08-08 02:17:23', 1),
(52, '::1', 'pkmpi.stikesnhm@gmail.com', 2, '2021-08-09 01:55:16', 1),
(53, '::1', 'pkmpi.stikesnhm@gmail.com', 2, '2021-08-12 20:37:56', 1),
(54, '::1', 'pkmpi.stikesnhm@gmail.com', 2, '2021-08-13 02:29:38', 1),
(55, '::1', 'pkmpi.stikesnhm@gmail.com', NULL, '2021-08-13 22:02:20', 0),
(56, '::1', 'pkmpi.stikesnhm@gmail.com', 2, '2021-08-13 22:02:28', 1),
(57, '::1', 'pkmpi.stikesnhm@gmail.com', 2, '2021-08-14 08:14:17', 1),
(58, '::1', 'pkmpi.stikesnhm@gmail.com', 2, '2021-08-14 20:49:24', 1),
(59, '::1', 'pkmpi.stikesnhm@gmail.com', 2, '2021-08-15 01:27:43', 1),
(60, '::1', 'pkmpi.stikesnhm@gmail.com', 2, '2021-08-15 20:19:30', 1),
(61, '::1', 'pkmpi.stikesnhm@gmail.com', 2, '2021-08-17 00:10:53', 1),
(62, '::1', 'pkmpi.stikesnhm@gmail.com', 2, '2021-08-22 21:14:10', 1),
(63, '::1', 'pkmpi.stikesnhm@gmail.com', 2, '2021-08-23 08:30:15', 1),
(64, '::1', 'pkmpi.stikesnhm@gmail.com', 2, '2021-08-23 21:46:36', 1),
(65, '::1', 'pkmpi.stikesnhm@gmail.com', 2, '2021-08-24 03:05:17', 1),
(66, '::1', 'pkmpi.stikesnhm@gmail.com', 2, '2021-08-25 02:42:41', 1),
(67, '::1', 'pkmpi.stikesnhm@gmail.com', NULL, '2021-08-25 08:19:20', 0),
(68, '::1', 'pkmpi.stikesnhm@gmail.com', 2, '2021-08-25 08:19:26', 1),
(69, '::1', 'pkmpi.stikesnhm@gmail.com', NULL, '2021-08-25 22:49:31', 0),
(70, '::1', 'pkmpi.stikesnhm@gmail.com', 2, '2021-08-25 22:49:55', 1),
(71, '::1', 'pkmpi.stikesnhm@gmail.com', 2, '2021-08-26 01:48:32', 1),
(72, '::1', 'pkmpi.stikesnhm@gmail.com', 2, '2021-08-30 23:20:14', 1),
(73, '::1', 'baginda.umam@gmail.com', NULL, '2021-08-31 22:57:05', 0),
(74, '::1', 'pkmpi.stikesnhm@gmail.com', 2, '2021-08-31 22:57:13', 1),
(75, '::1', 'pkmpi.stikesnhm@gmail.com', 2, '2021-09-02 01:46:26', 1),
(76, '::1', 'baginda.umam@gmail.com', NULL, '2021-12-05 19:16:18', 0),
(77, '::1', 'baginda.umam@gmail.com', NULL, '2021-12-05 19:16:30', 0),
(78, '::1', 'baginda.umam@gmail.com', NULL, '2021-12-05 19:16:37', 0),
(79, '::1', 'baginda.umam@gmail.com', 1, '2021-12-05 19:16:44', 1),
(80, '::1', 'baginda.umam@gmail.com', NULL, '2021-12-06 20:12:24', 0),
(81, '::1', 'baginda.umam@gmail.com', NULL, '2021-12-06 20:12:36', 0),
(82, '::1', 'baginda.umam@gmail.com', 1, '2021-12-06 20:12:47', 1),
(83, '::1', 'baginda.umam@gmail.com', NULL, '2021-12-07 00:17:45', 0),
(84, '::1', 'baginda.umam@gmail.com', 1, '2021-12-07 00:17:54', 1),
(85, '::1', 'baginda.umam@gmail.com', NULL, '2021-12-07 22:36:38', 0),
(86, '::1', 'baginda.umam@gmail.com', 1, '2021-12-07 22:36:45', 1),
(87, '::1', 'baginda.umam@gmail.com', NULL, '2021-12-15 18:58:07', 0),
(88, '::1', 'baginda.umam@gmail.com', 1, '2021-12-15 18:58:17', 1),
(89, '::1', 'baginda.umam@gmail.com', 1, '2021-12-15 21:20:24', 1),
(90, '::1', 'baginda.umam@gmail.com', 1, '2021-12-19 19:25:35', 1),
(91, '::1', 'baginda.umam@gmail.com', 1, '2021-12-19 22:32:33', 1),
(92, '::1', 'baginda.umam@gmail.com', 1, '2021-12-22 18:31:50', 1),
(93, '::1', 'baginda.umam@gmail.com', 1, '2021-12-22 22:40:23', 1),
(94, '::1', 'baginda.umam@gmail.com', NULL, '2021-12-23 00:55:43', 0),
(95, '::1', 'baginda.umam@gmail.com', 1, '2021-12-23 00:55:54', 1),
(96, '::1', 'baginda.umam@gmail.com', 1, '2021-12-23 00:57:23', 1),
(97, '::1', 'kepegawaiannhm@gmail.com', 5, '2021-12-23 01:23:04', 1),
(98, '::1', 'kepegawaiannhm@gmail.com', 5, '2021-12-23 01:31:07', 1),
(99, '::1', 'baginda.umam@gmail.com', 1, '2021-12-27 18:32:34', 1),
(100, '::1', 'baginda.umam@gmail.com', 1, '2021-12-27 21:48:46', 1),
(101, '::1', 'baginda.umam@gmail.com', 1, '2021-12-29 20:05:57', 1),
(102, '::1', 'baginda.umam@gmail.com', NULL, '2022-07-26 19:30:31', 0),
(103, '::1', 'baginda.umam@gmail.com', NULL, '2022-07-26 19:30:40', 0),
(104, '::1', 'kepegawaiannhm@gmail.com', NULL, '2022-07-26 19:30:50', 0),
(105, '::1', 'kepegawaiannhm@gmail.com', 5, '2022-07-26 19:31:45', 1),
(106, '::1', 'kepegawaiannhm@gmail.com', 5, '2022-07-27 22:06:28', 1),
(107, '::1', 'kepegawaiannhm@gmail.com', 5, '2022-08-13 22:03:33', 1),
(108, '::1', 'kepegawaiannhm@gmail.com', 5, '2022-08-14 02:11:43', 1),
(109, '::1', 'kepegawaiannhm@gmail.com', NULL, '2022-08-20 08:58:10', 0),
(110, '::1', 'kepegawaiannhm@gmail.com', NULL, '2022-08-20 08:58:24', 0),
(111, '::1', 'kepegawaiannhm@gmail.com', 5, '2022-08-20 08:58:50', 1),
(112, '::1', '201931420020', NULL, '2022-08-20 09:06:46', 0),
(113, '::1', 'kepegawaiannhm@gmail.com', NULL, '2022-08-20 09:07:17', 0),
(114, '::1', 'kepegawaiannhm@gmail.com', NULL, '2022-08-20 09:07:36', 0),
(115, '::1', 'kepegawaiannhm@gmail.com', 5, '2022-08-20 09:07:51', 1),
(116, '::1', 'kepegawaiannhm@gmail.com', 5, '2022-08-20 11:20:56', 1),
(117, '::1', 'kepegawaiannhm@gmail.com', 5, '2022-08-20 11:36:40', 1);

-- --------------------------------------------------------

--
-- Table structure for table `auth_permissions`
--

CREATE TABLE `auth_permissions` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `auth_permissions`
--

INSERT INTO `auth_permissions` (`id`, `name`, `description`) VALUES
(1, 'manage-users', 'operator admin'),
(2, 'manage-profile', 'pengelola web');

-- --------------------------------------------------------

--
-- Table structure for table `auth_reset_attempts`
--

CREATE TABLE `auth_reset_attempts` (
  `id` int(11) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `ip_address` varchar(255) NOT NULL,
  `user_agent` varchar(255) NOT NULL,
  `token` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `auth_tokens`
--

CREATE TABLE `auth_tokens` (
  `id` int(11) UNSIGNED NOT NULL,
  `selector` varchar(255) NOT NULL,
  `hashedValidator` varchar(255) NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `expires` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `auth_users_permissions`
--

CREATE TABLE `auth_users_permissions` (
  `user_id` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `permission_id` int(11) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `batch` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
(1, '2017-11-20-223112', 'Myth\\Auth\\Database\\Migrations\\CreateAuthTables', 'default', 'Myth\\Auth', 1626191242, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tb_absensi`
--

CREATE TABLE `tb_absensi` (
  `id_absen` int(11) NOT NULL,
  `user_name` varchar(15) DEFAULT NULL,
  `tgl_masuk` varchar(255) DEFAULT NULL,
  `jam_masuk` time DEFAULT NULL,
  `tgl_pulang` varchar(255) DEFAULT NULL,
  `jam_pulang` time DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_absensi`
--

INSERT INTO `tb_absensi` (`id_absen`, `user_name`, `tgl_masuk`, `jam_masuk`, `tgl_pulang`, `jam_pulang`, `keterangan`) VALUES
(1, '201931420020', '30-Dec-2021', '11:01:50', NULL, NULL, 'Late'),
(2, '1987122240', '30-Dec-2021', '11:19:24', NULL, NULL, 'Late'),
(3, '1983050708', '30-Dec-2021', '11:59:04', NULL, NULL, 'Late'),
(4, '201931420020', '01-Jan-2022', '20:24:39', NULL, NULL, 'Late'),
(5, '201931420020', '03-Jan-2022', '07:17:09', NULL, NULL, 'ontime'),
(6, '1980052301', '03-Jan-2022', '10:06:51', NULL, NULL, 'Late'),
(8, '201931420020', '18-Jan-2022', '22:46:13', NULL, NULL, 'Late'),
(9, '1980052301', '30-Jul-2022', '22:00:02', NULL, NULL, 'Late');

-- --------------------------------------------------------

--
-- Table structure for table `tb_biodata`
--

CREATE TABLE `tb_biodata` (
  `user_name` varchar(15) NOT NULL,
  `tempat_lahir` varchar(25) DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `jenis_kelamin` varchar(10) DEFAULT NULL,
  `pendidikan_terakhir` varchar(20) DEFAULT NULL,
  `jabatan` varchar(25) DEFAULT NULL,
  `alamat_lengkap` text DEFAULT NULL,
  `file_ktp` varchar(565) DEFAULT NULL,
  `file_kk` varchar(565) DEFAULT NULL,
  `file_ijazah` varchar(565) DEFAULT NULL,
  `file_transkrip` varchar(565) DEFAULT NULL,
  `tgl_upload` varchar(30) DEFAULT NULL,
  `tgl_update` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_biodata`
--

INSERT INTO `tb_biodata` (`user_name`, `tempat_lahir`, `tanggal_lahir`, `jenis_kelamin`, `pendidikan_terakhir`, `jabatan`, `alamat_lengkap`, `file_ktp`, `file_kk`, `file_ijazah`, `file_transkrip`, `tgl_upload`, `tgl_update`) VALUES
('201931420020', 'Bangkalan', '2021-12-23', 'Laki-laki', 'SLTA', 'Divisi IT', 'DSN. Perrengan Desa Lantek Timur Galis Bangkalan', 'default.jpg', 'default.jpg', 'default.jpg', 'default.jpg', '23-Dec-2021:13:44:26pm', NULL),
('201931420021', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tb_gaji`
--

CREATE TABLE `tb_gaji` (
  `id_gaji` int(11) NOT NULL,
  `salary` varchar(50) DEFAULT NULL,
  `jabatan` varchar(255) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_gaji`
--

INSERT INTO `tb_gaji` (`id_gaji`, `salary`, `jabatan`, `keterangan`, `created_at`, `updated_at`) VALUES
(1, '100000', 'Ketua', 'Gaji Ketua Stikes', '2022-08-13 10:51:15', '2022-08-20 09:33:18'),
(4, '50000', 'Staf', 'gaji staf\r\n', '2022-08-20 10:19:12', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tb_kegiatan`
--

CREATE TABLE `tb_kegiatan` (
  `id_kegiatan` int(11) NOT NULL,
  `nama_kegiatan` varchar(100) DEFAULT NULL,
  `deskripsi_kegiatan` text DEFAULT NULL,
  `tgl_post` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_kegiatan`
--

INSERT INTO `tb_kegiatan` (`id_kegiatan`, `nama_kegiatan`, `deskripsi_kegiatan`, `tgl_post`) VALUES
(1, 'Diesnatalis 2022', 'Diesnatalis STIKES NHM Ke 13', '2022-07-26 09:20:52'),
(2, 'Diesnatalis 2023', 'diesnatalis ke 14', '2022-07-26 09:29:59');

-- --------------------------------------------------------

--
-- Table structure for table `tb_pekerjaan`
--

CREATE TABLE `tb_pekerjaan` (
  `id_pekerjaan` int(11) NOT NULL,
  `user_name` varchar(15) DEFAULT NULL,
  `pekerjaan` varchar(565) DEFAULT NULL,
  `tanggal` varchar(20) DEFAULT NULL,
  `jam_mulai` time DEFAULT NULL,
  `jam_selesai` time DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `created_at` varchar(255) DEFAULT NULL,
  `updated_at` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tb_proposal`
--

CREATE TABLE `tb_proposal` (
  `id_proposal` int(11) NOT NULL,
  `user_name` varchar(100) DEFAULT NULL,
  `id_waka` int(11) DEFAULT NULL,
  `judul_proposal` varchar(255) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `fileBerkas` varchar(565) DEFAULT NULL,
  `tgl_pos` varchar(50) DEFAULT NULL,
  `tgl_update` varchar(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_proposal`
--

INSERT INTO `tb_proposal` (`id_proposal`, `user_name`, `id_waka`, `judul_proposal`, `keterangan`, `status`, `fileBerkas`, `tgl_pos`, `tgl_update`) VALUES
(2, '201931420020', 3, 'PENGAJUAN SERVER VPS', 'Untuk Server Website', 1, NULL, '26-Jan-2022: 10:33:43.Wib', NULL),
(3, '201931420020', 3, 'PENGAJUAN GAJI BERKALA', 'Untuk Kenaikan Gaji Berkala', 0, NULL, '26-Jan-2022: 13:23:25.Wib', NULL),
(4, '201931420020', 2, 'PENGAJUAN SYSTEM ELEARNING', 'Untuk Kepentiangan Spada', 0, NULL, '26-Jan-2022: 13:24:05.Wib', NULL),
(5, '201931420020', 4, 'PENGAJUAN MOU', 'Untuk Kerjasama ', 0, NULL, '26-Jan-2022: 13:25:06.Wib', NULL),
(6, '201931420020', 3, 'PENGAJUAN SERVER VPS-2', 'REVISI', 0, NULL, '26-Jan-2022: 13:32:37.Wib', NULL),
(7, '201931420020', 3, 'PENGAJUAN SERVER VPS-', 'Keterangan ', 0, NULL, '26-Jan-2022: 13:36:09.Wib', NULL),
(8, '201931420020', 3, 'Perihal Coba', 'hhh', 0, '1643182416_aea5ea46fb74c564e0e9.pdf', '26-Jan-2022: 14:33:17.Wib', NULL),
(9, '201931420020', 3, 'Perihal', 'ggg', 0, '1643182648_dcc51d6a0d5072ec93cf.docx', '26-Jan-2022: 14:37:11.Wib', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tb_prsensi_kegiatan`
--

CREATE TABLE `tb_prsensi_kegiatan` (
  `id_presensi` int(11) NOT NULL,
  `id_kegiatan` int(11) DEFAULT NULL,
  `user_name` varchar(100) DEFAULT NULL,
  `status` varchar(30) DEFAULT NULL,
  `tgl_submite` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_prsensi_kegiatan`
--

INSERT INTO `tb_prsensi_kegiatan` (`id_presensi`, `id_kegiatan`, `user_name`, `status`, `tgl_submite`) VALUES
(2, 2, '201931420020', 'Hadir', '2022-07-28 11:55:11'),
(3, 1, '201931420021', 'Hadir', '2022-07-28 13:07:20');

-- --------------------------------------------------------

--
-- Table structure for table `tb_users`
--

CREATE TABLE `tb_users` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(100) DEFAULT NULL,
  `nama_lengkap` varchar(255) DEFAULT NULL,
  `user_email` varchar(100) DEFAULT NULL,
  `user_password` varchar(200) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `id_gaji` int(11) DEFAULT NULL,
  `user_created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_users`
--

INSERT INTO `tb_users` (`user_id`, `user_name`, `nama_lengkap`, `user_email`, `user_password`, `foto`, `id_gaji`, `user_created_at`) VALUES
(3, '201931420020', 'Khoirul Umam', 'baginda.umam@gmail.com', '$2y$10$nE.LgMm/fAnXSWmvRML1vePcesmOCQAlFyiVAvfKRZVA5KH9p2M4u', '1640241877_c2fef7e7145983586845.jpg', 4, '2021-12-23 04:41:48'),
(95, '1980052301', 'Dr. M. Hasinuddin, S.Kep.Ns.M.Kep.', 'kepegawaiannhm@gmail.com', '$2y$10$bF57Qo4H3m1JnXvCcV0BKeyHCJLUmirLGhnklYOhe1KlPTA3MtHdS', '1641179177_54123a8798394b224480.jpg', 1, '2021-12-27 04:32:43'),
(96, '1981111606', 'Ulva Noviana, S.Kep.,Ns., M.Kep', 'kepegawaiannhm@gmail.com', '$2y$10$StFe0UJGj2b58qvxegeTweI6leRdflsh9.Oi3lQ5N3NXnAm3/xFge', 'default.svg', 4, '2021-12-27 04:32:43'),
(97, '1983050708', 'Dr. Eny Susanti, M.Keb', 'kepegawaiannhm@gmail.com', '$2y$10$zZdG1ek1yvP/tf6c7GSfueajNSTM4xHj2W/ySLsuk9yXwZQzOwPSO', 'default.svg', 4, '2021-12-27 04:32:43'),
(98, '1987011112', 'Dian Januariwasti, S.SiT., M.Kes', 'kepegawaiannhm@gmail.com', '$2y$10$cUWEMhfXe3H3Wu1AlVyJm.ijYF8Oxj.DsE4BlEZN5wS.cmuLLTORO', 'default.svg', 4, '2021-12-27 04:32:43'),
(99, '1982060501', 'Tri Mulyani, SE', 'kepegawaiannhm@gmail.com', '$2y$10$6bHocwemb5hc7ZhyPvj7P.8tTUgyL13DjXPR77Aocj/dr/fWKw/dC', 'default.svg', 4, '2021-12-27 04:32:43'),
(100, '1987122240', 'Intan Sastradisurya, Amd', 'kepegawaiannhm@gmail.com', '$2y$10$8y.y92P26t2CvIm2vnVqFu..eLIPXQ/wlPLiCBo2b86qtGCA5ihyq', '1640838033_9f4e45cf4dfeb3b0e2c8.jpg', 4, '2021-12-27 04:32:43'),
(101, '1978120409', 'Dr. Zakkiyatus Zainiyah, M.Keb', 'kepegawaiannhm@gmail.com', '$2y$10$Qu7zJqePpdUMI6.HZFOdLekxdrPDD5pbpn3AdLvN4zlVgGfbajP3q', 'default.svg', 4, '2021-12-27 04:32:43'),
(102, '1987122169', 'Roni Sofyan Wijaya S.Pd', 'kepegawaiannhm@gmail.com', '$2y$10$Zwk5bRZcOlTe70GU6Wv7ouEnOf/hAXC8mwACOkVlnKqJH3CKqXADi', 'default.svg', 4, '2021-12-27 04:32:43'),
(103, '1984030320', 'Dr. M. Suhron, S.Kep.Ns., M.Kes', 'kepegawaiannhm@gmail.com', '$2y$10$AIQU4lgocT4389D4olF2N.QsxcHaoWyDVCvmU/gi78JoYKo4rsjvO', 'default.svg', 4, '2021-12-27 04:32:43'),
(104, '1989092830', 'Hj. Nailufar Firdaus, S.ST., M.AP', 'kepegawaiannhm@gmail.com', '$2y$10$Np52nwfhHG9Sh3fRj1qH4uHSZz7JPo5rFZitIy5GQ45.5KpFEG6S6', 'default.svg', 4, '2021-12-27 04:32:43'),
(105, '1989091529', 'Selvia Nurul Qomari, S.ST., M.Kes', 'kepegawaiannhm@gmail.com', '$2y$10$lHPe0dYK4a3vIrhp812Pu.V6hZ4ntc3aX9gwiZO8UsUwDTufnE.AG', 'default.svg', 4, '2021-12-27 04:32:43'),
(106, '1985011813', 'Mufarika, S.Kep.Ns., M.Kep', 'kepegawaiannhm@gmail.com', '$2y$10$NfwPQRaTq1BRrfm5W8Z47e8gpSVsn.ZBS5iCNVL9mIgMCx2uDwdFa', 'default.svg', 4, '2021-12-27 04:32:44'),
(107, '1986081828', 'Mulia Mayangsari, S.Kep..Ns., M.Kep. Sp.Kep.MB', 'kepegawaiannhm@gmail.com', '$2y$10$50RnQKGOak6p/V5OS0vC2OuQ89dJMKlAf5gGQofldqtm3Y5oKuVxK', 'default.svg', 4, '2021-12-27 04:32:44'),
(108, '1983013116', 'Merlyna Suryaningsih, S.Kep.Ns., M.Kep', 'kepegawaiannhm@gmail.com', '$2y$10$oxz5EfmsanxqItEfkyIVKO1kka3YjRAM/NWC5GnoA9fusuJ4pyCLG', 'default.svg', 4, '2021-12-27 04:32:44'),
(109, '1980080223', 'Zuryaty, S.Kep.Ns., M.Kes', 'kepegawaiannhm@gmail.com', '$2y$10$52d/zpyikG65pQzNzbMmwusk7GPN0sGciN3x8115Fi3Kpl1zy4PZa', 'default.svg', 4, '2021-12-27 04:32:44'),
(110, '1984091714', 'Nisfil Mufidah, S.Kep.,Ns., M.Kep', 'kepegawaiannhm@gmail.com', '$2y$10$ZmSlAQPlC3MgCb2773RJuuVRjyMLaF4mxF1yeKXChPi8x2gge284G', 'default.svg', 4, '2021-12-27 04:32:44'),
(111, '1984052624', 'Qurrotu Aini, S.Kep.Ns., M.Kes', 'kepegawaiannhm@gmail.com', '$2y$10$AQW4623eoCZ..pLeJSxs4uv7fokS.MZhHmVhM3y/okJzGoZxLvfqW', 'default.svg', 4, '2021-12-27 04:32:44'),
(112, '1990012533', 'Alvin Abdillah, S.Kep.,Ns., M.AP.,M.Kep', 'kepegawaiannhm@gmail.com', '$2y$10$1hf11x4KYfZeH3ZooiTx1evm1BjwRCjnUfMoQVX0oo9NZENA2Fi2y', 'default.svg', 4, '2021-12-27 04:32:44'),
(113, '1990082234', 'Soliha,S.Kep.,Ns., M.AP.,M.Kep', 'kepegawaiannhm@gmail.com', '$2y$10$yysKs1BjkO.dgQOF9JYg9eOEXMorfwoaV88FEaJVY4LR2g09Kjv4W', 'default.svg', 4, '2021-12-27 04:32:44'),
(114, '1990070537', 'Rahmad Wahyudi, S.Kep., Ns., M.AP.,M.Kep', 'kepegawaiannhm@gmail.com', '$2y$10$wo.6CDh2Xz/z/wvCiilpS.5LhdPPXFMKGHykTBB7wnTAP.oG/p8Fy', 'default.svg', 4, '2021-12-27 04:32:44'),
(115, '1990080638', 'Agus Priyanto, S.Kep., Ns., M.AP.,M.Kep', 'kepegawaiannhm@gmail.com', '$2y$10$iKAgG/DiTi5vAo5OUkZ4teO.4O1.QGLOBeVrFfv7v7WrzhMoxKTvW', 'default.svg', 4, '2021-12-27 04:32:44'),
(116, '1992012542', 'Luluk Fauziyah Januarti, S.Kep.Ns.,M.kep', 'kepegawaiannhm@gmail.com', '$2y$10$R/JM2jwOjBWSIIgiyhuQuezBoxJ4IZ4yzL/qkzqOEW43WSDbrGlVK', 'default.svg', 4, '2021-12-27 04:32:44'),
(117, '1989091844', 'Rahmad Septian Reza, S.Kep., Ns., M.Kep', 'kepegawaiannhm@gmail.com', '$2y$10$7bk8xsQkYjRA1ryg/cqBCOJ1SWIes9qkJ1Ba2OU92oOrOv6ncpMfS', 'default.svg', 4, '2021-12-27 04:32:44'),
(118, '1985101060', 'Ns, Heni Ekawati S.Kep.,M.Kep', 'kepegawaiannhm@gmail.com', '$2y$10$lv516jtqvurahxDh2ctpwONSSCvFWO9o4l6ljpbzTX1TP9T3WyoB2', 'default.svg', 4, '2021-12-27 04:32:44'),
(119, '1989011661', 'Achmad Masfi S.Kep.,M.Kep', 'kepegawaiannhm@gmail.com', '$2y$10$LhZvYxpzTdz4U.3qOTdiieiWoSILTsQgdO95ajorMIXABLLCo9ZHu', 'default.svg', 4, '2021-12-27 04:32:44'),
(120, '1991030743', 'Mohammad Lutfi, S.Kep.,NS.,M.Tr.Kep', 'kepegawaiannhm@gmail.com', '$2y$10$5jqC/pWr3OeHv8R.13Sr/eU1XF6WxUMygzLXKEZHwVWrHm1ObCqtK', 'default.svg', 4, '2021-12-27 04:32:45'),
(121, '1983120602', 'Hamimatus Zainiyah, S.ST., M.Pd., M.Keb', 'kepegawaiannhm@gmail.com', '$2y$10$aG/96G2FlxwQQxaEU9tBJu5y7ZUs54B6aZsDzx.O5/STmUxw/kZ62', 'default.svg', 4, '2021-12-27 04:32:45'),
(122, '1984112310', 'Siti Rochimatul Lailiyah, S.SiT., M.Kes', 'kepegawaiannhm@gmail.com', '$2y$10$W/Y1anf4uyPQ2rwD3HeC6O44xBHJ5tiP3ZtU1V8T16sY/bzQUeP4y', 'default.svg', 4, '2021-12-27 04:32:45'),
(123, '1985062911', 'Alis Nurdiana,S,ST.,M.Kes', 'kepegawaiannhm@gmail.com', '$2y$10$P6OxjIB73ssJjPe2RYIUmOHrIKWd56fYjBf4c5WP7Dx5QhvGjRrMm', 'default.svg', 4, '2021-12-27 04:32:45'),
(124, '1992072636', 'Vivin Wijiastuti, S.Tr.Keb., M.AP.,M.Keb', 'kepegawaiannhm@gmail.com', '$2y$10$PEYWKHQgfDk6pvUVMIn60ed0y/EsNEnjIDMDC1AW0LkobjzO7/8kW', 'default.svg', 4, '2021-12-27 04:32:45'),
(125, '1989101825', 'Rila Rindi Antika, S.ST., M.AP,M.Kes', 'kepegawaiannhm@gmail.com', '$2y$10$K9FV7AcHBrbwXg75/aRkfeDU88XkzUoW0NRC1vAkOYor6ZmFgNYRu', 'default.svg', 4, '2021-12-27 04:32:45'),
(126, '1984042905', 'Lelly Aprilia Vidayati, S.SiT., M.Kes', 'kepegawaiannhm@gmail.com', '$2y$10$Cz.WTey4fmnHIrn1nlLYyOYwuUIRk7/skLbyyrbOoU02b8Sb1L9Z.', 'default.svg', 4, '2021-12-27 04:32:45'),
(127, '1986101315', 'Iin Setiawati, S.Keb., Bd., M.AP', 'kepegawaiannhm@gmail.com', '$2y$10$fxGkTCBYXn958EPFFn3Ac.r1lUrWaizRUBe0ty6NqNkiDAdLqFFQW', 'default.svg', 4, '2021-12-27 04:32:45'),
(128, '1981052604', 'Novi Anggraeni, S.SiT, MPH', 'kepegawaiannhm@gmail.com', '$2y$10$YlioaaidPmhiIzVyG4.8sOE95JzC2oF9aOcETUbY3jwqOyNDAr3FW', 'default.svg', 4, '2021-12-27 04:32:45'),
(129, '1988112927', 'Novita Wulandari, S.ST., M.AP.,M.Keb', 'kepegawaiannhm@gmail.com', '$2y$10$.PsokoaTl689CnIK1GWTRe6LqMwv04kocBqMu4HaFjvAjF8b2K.lm', 'default.svg', 4, '2021-12-27 04:32:45'),
(130, '1990031334', 'Nor Indah Handayani,S.Tr.Keb.,M.Keb', 'kepegawaiannhm@gmail.com', '$2y$10$XqXxX7GzMrR17V7MeiQstOgkrJAcYUNQtxb7OL/ktLm2L4ilWpYDe', 'default.svg', 4, '2021-12-27 04:32:45'),
(131, '1986121631', 'Rohilatul Jannah, S.Kep., Ns., M.AP', 'kepegawaiannhm@gmail.com', '$2y$10$1mPRxrnRoZFXs69bzNiaPu2LnYgdAca8TtMrOawnkOiSjFKkkf/wm', 'default.svg', 4, '2021-12-27 04:32:45'),
(132, '1989021264', 'Nurun Nikmah, S.ST.,M.Kes', 'kepegawaiannhm@gmail.com', '$2y$10$TlgHTj70XoV/hn9B2b/rx.xKErkg0ItGAPZzxS4HoquUXh2Bf6ZCy', 'default.svg', 4, '2021-12-27 04:32:45'),
(133, '1984042703', 'Dwi Wahyuning Tiyas, S.SiT., MPH', 'kepegawaiannhm@gmail.com', '$2y$10$DCMPUWZ6oHJoKF0ypRkSxOrGJyVlf58xATxvKYEBAA6wXE4juVjRW', 'default.svg', 4, '2021-12-27 04:32:45'),
(134, '1995122669', 'Dana Daniati M.Keb', 'kepegawaiannhm@gmail.com', '$2y$10$KYWcw0bf3z7fcyOwv2ZPOusGHsAEK5hYHBFVl4rByZCedJzpCaBY6', 'default.svg', 4, '2021-12-27 04:32:46'),
(135, '1993121246', 'Angga Ferdianto S.ST.,M.K.M', 'kepegawaiannhm@gmail.com', '$2y$10$2GdVyVljIxLLgSW03rTfSuDuA8GISEx1tK0QP/6rHRXVlRmNnCqQW', 'default.svg', 4, '2021-12-27 04:32:46'),
(136, '1995070254', 'Rulisiana Widodo S.ST', 'kepegawaiannhm@gmail.com', '$2y$10$HOxcaTqbVpgZXdShxlV9RuOcepVHqAcpRX4BAyFJpHXbNy6G90MEq', 'default.svg', 4, '2021-12-27 04:32:46'),
(137, '1996012150', 'M. Afif Rijal Husni S.ST', 'kepegawaiannhm@gmail.com', '$2y$10$XB4C799NkU/IgCpcLNXwO.MyHIXsrau43GC5R8OmI6k8BlZ8VaZEq', 'default.svg', 4, '2021-12-27 04:32:46'),
(138, '1997040165', 'Rivaldi Indra Nugraha S.Tr.Kes', 'kepegawaiannhm@gmail.com', '$2y$10$uaMy/4i5iyoH.6abisvHSeOn.IRlAPsZTskW/GkE6/LTOAgfL4vra', 'default.svg', 4, '2021-12-27 04:32:46'),
(139, '1989020726', 'Enggal Sari Maduratna, S.ST., M.AP', 'kepegawaiannhm@gmail.com', '$2y$10$BmlFNcCIgQ6rkKq3CJ6ea.tyIxfnb/1z6GgmH2X2IlnI4VOdLNf7i', 'default.svg', 4, '2021-12-27 04:32:46'),
(140, '1985052267', 'Eka Suci Daniyanti,S.K.M.,M.PH', 'kepegawaiannhm@gmail.com', '$2y$10$BXxcxxgR0QIjBu7UvwqtaOML7SgVy1zF2nvYR6ec.cgqZKuIAc3Q6', 'default.svg', 4, '2021-12-27 04:32:46'),
(141, '1990063040', 'Riyadatus Sholehah, S.Farm.Apt., M.Si', 'kepegawaiannhm@gmail.com', '$2y$10$7Zj0mvsfpb3dpyHQYonqhuSawD6ZYaYGgFhmry7oS7fBpCtzOlF8a', 'default.svg', 4, '2021-12-27 04:32:46'),
(142, '1988031732', 'M. Sofwan Haris, S.Fam.Apt., M.AP', 'kepegawaiannhm@gmail.com', '$2y$10$cnV3gromUxA9of594gTN1.IE8JLbti2DNaR0rGpN7tlgpz5A6.HsW', 'default.svg', 4, '2021-12-27 04:32:46'),
(143, '1994030947', 'Norma Farizah Fahmi, S.ST', 'kepegawaiannhm@gmail.com', '$2y$10$.wxqsJ.v3hMNszkTFBGpt.ShfUdJKTFn6Klx5wrUofYl1zQloNoQa', 'default.svg', 4, '2021-12-27 04:32:46'),
(144, '1993062452', 'Yogi Khoirul A S.Tr.AK', 'kepegawaiannhm@gmail.com', '$2y$10$gQAR8J7ewO1dtlsR/Gb.HOvnKVyQsoY1VI9YATfId8cOZsAvqWKQK', 'default.svg', 4, '2021-12-27 04:32:46'),
(145, '1993082568', 'Devi Anggraini Putri, S.Si.,M.Si', 'kepegawaiannhm@gmail.com', '$2y$10$o9KRnw8Eld/3HSaQD14s9umZWdHvJ49n71n28WereddeIrnTv1RQm', 'default.svg', 4, '2021-12-27 04:32:46'),
(146, '1994021153', 'Dany Pramono Putra, S.Ft', 'kepegawaiannhm@gmail.com', '$2y$10$eNjko9scNpUWTi94jU1J0OH11QgpINeLkEFV5PIInXDDUEdmsrVvS', 'default.svg', 4, '2021-12-27 04:32:46'),
(147, '1992080462', 'Dhaniel Prasetyo Irianto M.Pd', 'kepegawaiannhm@gmail.com', '$2y$10$mJxeS91omSmL/O7Z.dwHzO86W4gGlnxXoZWNf2pmhPNczijMQ7mfu', 'default.svg', 4, '2021-12-27 04:32:46'),
(148, '1990051656', 'Nelly Atusaadah SE', 'kepegawaiannhm@gmail.com', '$2y$10$8bnvMZ66SIsBA/FwFjv3qulyY0vRwaHLwcGuIMxDEq3DWS.i/dpxy', 'default.svg', 4, '2021-12-27 04:32:47'),
(149, '1992062449', 'Masfufah', 'kepegawaiannhm@gmail.com', '$2y$10$doFdO48dxH5fLohcGSoBneoUUurF3tNEuUBirrVVFVhHHkT77TADG', 'default.svg', 4, '2021-12-27 04:32:47'),
(150, '1992061042', 'Nurul Solehah, S.AP', 'kepegawaiannhm@gmail.com', '$2y$10$pb15ZKFRf1W2i9NSD6kE9.TSwVQGNnYH8p0Aciumm63Qlw3UQRXZC', 'default.svg', 4, '2021-12-27 04:32:47'),
(151, '1984092603', 'Danny Achmad Rahardja', 'kepegawaiannhm@gmail.com', '$2y$10$MmA.GR/rL0butPfva23F9OxzlzHC8KSXuYG5atAprgxXW23npYYzG', 'default.svg', 4, '2021-12-27 04:32:47'),
(152, '1988131263', 'Basori', 'kepegawaiannhm@gmail.com', '$2y$10$r0g7Rjyrlb2e0dg.vofXTeTaCWrE6g66XD7MueZbqdcgOqHfHla46', 'default.svg', 4, '2021-12-27 04:32:47'),
(153, '1974111233', 'Abd. Azis Hamdiyanto', 'kepegawaiannhm@gmail.com', '$2y$10$PlygulLm70j1giXMP5Lv7OVdvPNNLioZHzb/d7igRUJeooeIov2M6', 'default.svg', 4, '2021-12-27 04:32:47'),
(154, '1988121037', 'Firman Ardiansyah, S.Kom', 'kepegawaiannhm@gmail.com', '$2y$10$MOnfAZz3CJM0SIwfZ1.GPODre4j5xu60svki8sRh78HAiVb5gQXEG', 'default.svg', 4, '2021-12-27 04:32:47'),
(155, '1990062126', 'Achmad Sohibul Izzar', 'kepegawaiannhm@gmail.com', '$2y$10$sGprUiHvxYkbijQvh4Vi2.62pvJ1ERVCOK0MImS/v7LI3RxIPtyKa', 'default.svg', 4, '2021-12-27 04:32:47'),
(156, '1991052070', 'Ribut', 'kepegawaiannhm@gmail.com', '$2y$10$8.4mQI512TXo328ZfRnSVejwYM9//GltIlpJrCjwWHNFn.8nRzKjq', 'default.svg', 4, '2021-12-27 04:32:47'),
(157, '1994120543', 'Aliyyul Akbar, S.AP', 'kepegawaiannhm@gmail.com', '$2y$10$wZoqhS4MPecgSrHkjV.LuehynPScjDvBKKNn2vf1MqYRq44pqCUWK', 'default.svg', 4, '2021-12-27 04:32:47'),
(158, '1996022072', 'Dhani Firtria Elysa S.IP', 'kepegawaiannhm@gmail.com', '$2y$10$NUWhNfMD9K4GM4Aazhdd4.5qeYSM/oneq15WSHKEWXAPQRVRTxQgi', 'default.svg', 4, '2021-12-27 04:32:47'),
(159, '1993082552', 'Sari Agustini., S.Pd', 'kepegawaiannhm@gmail.com', '$2y$10$fMekj3p.OBnO9HCL0SGdYOvwfiV0UsLsegB8EtY.H9YKzBq4roEau', 'default.svg', 4, '2021-12-27 04:32:47'),
(160, '1994080541', 'Galuh Agustina Suryaningtiyas,SE', 'kepegawaiannhm@gmail.com', '$2y$10$jABKLdFUKb.S1UHUet/HuuegCNg4rz6BCftBg/yBZNB3ao2diGO2K', 'default.svg', 4, '2021-12-27 04:32:47'),
(161, '1986012904', 'Ferdian Ari Sandi', 'kepegawaiannhm@gmail.com', '$2y$10$Ev2kuzay26TejwyKNOaIk.OfQ9lfyZG1zF5t4anX0XzqDCKP35PEm', 'default.svg', 4, '2021-12-27 04:32:47'),
(162, '1986080507', 'Muzayyaroh, SE', 'kepegawaiannhm@gmail.com', '$2y$10$07PSj3m.pCQJFTSa25rmLO8IfNOEuVnrV3c/VOTM7bKzys6JXNmVy', 'default.svg', 4, '2021-12-27 04:32:48'),
(163, '1977030902', 'Cheny Fre Marthalia, SE', 'kepegawaiannhm@gmail.com', '$2y$10$Nq/jgYJuhnucwka4FyOf9eXFgUb/xq9467DKZFIzgiPSA5c1.sJ7O', 'default.svg', 4, '2021-12-27 04:32:48'),
(164, '1990081838', 'Slamet Syaiful Bahri, SE', 'kepegawaiannhm@gmail.com', '$2y$10$C7GN5n1tPxhGjG/R0VlmdO5JL60ba1TBaqMnFaRqQL.RhmVZBJcuS', 'default.svg', 4, '2021-12-27 04:32:48'),
(165, '1989022828', 'Zulfia Listiani, S.Tr.Keb', 'kepegawaiannhm@gmail.com', '$2y$10$22Fc02arjiXiqgYA1YRDuuM1QqxdpMKUtYtcEymd2/hoSDZHpvsEy', 'default.svg', 4, '2021-12-27 04:32:48'),
(166, '1994102366', 'Apt. Rianur Oktavia.S.Farmasi', 'kepegawaiannhm@gmail.com', '$2y$10$PABYogXTyd2sqHWcuVnBz.7uJyDuOW8URfVXA6nE9EczGuh3NWaXS', 'default.svg', 4, '2021-12-27 04:32:48'),
(167, '1998200567', 'Dhimas Pramayoga Sinatra A.md', 'kepegawaiannhm@gmail.com', '$2y$10$d0saDiDyo9ZdLEzrhA0L7OxztOU4dWBOuw.9PItLYwMXX1uHtjSP2', 'default.svg', 4, '2021-12-27 04:32:48'),
(168, '1987060929', 'Dwi Ayu Pramitha,S.Kep.Ns', 'kepegawaiannhm@gmail.com', '$2y$10$uq6TnHWiEUEJ4pkqp3ieXuWjWu68K1FMubNP/lvCLueExxaKnYe5e', 'default.svg', 4, '2021-12-27 04:32:48'),
(169, '2000180268', 'imamatul cholinda, Amd.Kes', 'kepegawaiannhm@gmail.com', '$2y$10$6r8HyMwUYuznvJDnV9aS4.3rJN8OvblFnvOo5Lgwy1B9KeAhVf8Fq', 'default.svg', 4, '2021-12-27 04:32:48'),
(170, '1997160564', 'Amirza Setya Andiani, Amd.Kes', 'kepegawaiannhm@gmail.com', '$2y$10$3aHaGol7CKxTVEiXUfS28e3Q8VxALZgP2r3BBwgrAM2yhbyarcxrS', 'default.svg', 4, '2021-12-27 04:32:48'),
(171, '1974040627', 'Abd. Roni', 'kepegawaiannhm@gmail.com', '$2y$10$I5eC8r4QrOlKLrpgjV2Dx.z7SfHx9IsMSpMrsviqaYBU2oTgZS63S', 'default.svg', 4, '2021-12-27 04:32:48'),
(172, '1990080119', 'Abdul Malik Bakri', 'kepegawaiannhm@gmail.com', '$2y$10$FoB4j/aWYqyeuyDr4zb0vOKNCaQzXp0Nytbkosp46xx2VoKXV94x.', 'default.svg', 4, '2021-12-27 04:32:48'),
(173, '1989010120', 'Mas Ro\'i', 'kepegawaiannhm@gmail.com', '$2y$10$YgrBO80sdezS6QDGMbBcOO1XmcVcqG6GPs7xWk4v.zs8KvJfF15ve', 'default.svg', 4, '2021-12-27 04:32:48'),
(174, '1991071247', 'Sonata Malik Ibrahim', 'kepegawaiannhm@gmail.com', '$2y$10$YZ9I7sAmyLXtSx/vY3RX9./fRVqmbsgI63ayqQumrzVCnRJOWV68O', 'default.svg', 4, '2021-12-27 04:32:48'),
(175, '1994121244', 'Abdus Salam', 'kepegawaiannhm@gmail.com', '$2y$10$PIrQ5oM/MZpMb.HSGm2Qz.kidS7HfcwPcD6RK.SYWzQTGoN/8xt.e', 'default.svg', 4, '2021-12-27 04:32:48'),
(176, '1970071261', 'M. Fattah', 'kepegawaiannhm@gmail.com', '$2y$10$FNFazoEVXRsUn/7Ys5tMuuQo8bStuNOQL6tgvpCIVQVqeSJDT9e76', 'default.svg', 4, '2021-12-27 04:32:49'),
(177, '2000020854', 'Ach Muzzaki', 'kepegawaiannhm@gmail.com', '$2y$10$KlYndw8ilCwcAehMxdADDurCxFxGBiiqWvjjYXi6bKVdJwQ91V0MO', 'default.svg', 4, '2021-12-27 04:32:49'),
(178, '1995151060', 'Moh. Inoel Noradi', 'kepegawaiannhm@gmail.com', '$2y$10$usZ8kvD3g53loD25PaF7seOTxeM4JdaUWlaTQw7XOYK4aQFnYhbWu', 'default.svg', 4, '2021-12-27 04:32:49'),
(179, '1996140283', 'Fathur Rozak', 'kepegawaiannhm@gmail.com', '$2y$10$xRmClW9CVB0lPaWyCbBRU.GRZpvj63/xSWC24oPSt6Et73BsW.BT.', 'default.svg', 4, '2021-12-27 04:32:49'),
(180, '2000240884', 'Ainul Rofik', 'kepegawaiannhm@gmail.com', '$2y$10$TiKFID2TXrIvjM/VG7GDvuXNDOvD27v6/aRA/xlj87G0GpAHRb8cS', 'default.svg', 4, '2021-12-27 04:32:49'),
(181, '1971082065', 'Rudi Sanama', 'kepegawaiannhm@gmail.com', '$2y$10$jrjXBZQjT.jYpxG68KNB4ejpO0LmEMlvlSxzz9Q8J2THX3m.lKwMi', 'default.svg', 4, '2021-12-27 04:32:49'),
(182, '1964052025', 'Hariri Azis', 'kepegawaiannhm@gmail.com', '$2y$10$.ZKg1Yc/8BhI4y4Z3/wbmeZGLrj0VC4FOgG2hGv1hEe/YgC0qmOcy', 'default.svg', 4, '2021-12-27 04:32:49'),
(183, '1975062145', 'Moh. Hosen', 'kepegawaiannhm@gmail.com', '$2y$10$s27CfI8hHDo3do2Rb6S0h.3mEHu/J6fdVOdyLgWwVKJmnd433S8Li', 'default.svg', 4, '2021-12-27 04:32:49'),
(184, '19730917 58', 'Zaini', 'kepegawaiannhm@gmail.com', '$2y$10$E6kbN0DhCYEYdWl3TwQJG.1xaPzfbwYCihDEqoIYvSe.D2g9OhQvO', 'default.svg', 4, '2021-12-27 04:32:49');

-- --------------------------------------------------------

--
-- Table structure for table `tb_waka`
--

CREATE TABLE `tb_waka` (
  `id_waka` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `nama_waka` varchar(20) DEFAULT NULL,
  `keterangan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_waka`
--

INSERT INTO `tb_waka` (`id_waka`, `user_id`, `nama_waka`, `keterangan`) VALUES
(1, 1, 'KETUA STIKES', 'MANAGE ALL USERS'),
(2, 5, 'WAKIL KETUA 1', 'MANAGE AKADEMIK'),
(3, 5, 'WAKIL KETUA 2', 'MANAGE KEPEG DAN KEUANGAN'),
(4, 5, 'WAKIL KETUA 3', 'MANAGE MOU DAN KEMAHASISWAAN');

-- --------------------------------------------------------

--
-- Table structure for table `tb_waktu`
--

CREATE TABLE `tb_waktu` (
  `id_waktu` int(11) NOT NULL,
  `jam_masuk` time DEFAULT NULL,
  `jam_pulang` time DEFAULT NULL,
  `keterangan` varchar(50) DEFAULT NULL,
  `tgl_buat` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_waktu`
--

INSERT INTO `tb_waktu` (`id_waktu`, `jam_masuk`, `jam_pulang`, `keterangan`, `tgl_buat`) VALUES
(1, '07:30:00', '16:00:00', 'Available', '28-Dec-2021:11:06:54am');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(30) DEFAULT NULL,
  `fullname` varchar(255) DEFAULT NULL,
  `user_img` varchar(255) NOT NULL DEFAULT 'default..jpg',
  `no_wa` varchar(11) DEFAULT NULL,
  `password_hash` varchar(255) NOT NULL,
  `reset_hash` varchar(255) DEFAULT NULL,
  `reset_at` datetime DEFAULT NULL,
  `reset_expires` datetime DEFAULT NULL,
  `activate_hash` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `status_message` varchar(255) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 0,
  `force_pass_reset` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `username`, `fullname`, `user_img`, `no_wa`, `password_hash`, `reset_hash`, `reset_at`, `reset_expires`, `activate_hash`, `status`, `status_message`, `active`, `force_pass_reset`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'baginda.umam@gmail.com', 'umam123', 'KHOIRUL UMAM', '1626192110_e848fc08ebbae8bec526.jpg', '85258899409', '$2y$10$SyvWG7KhM489BpPGbEwzROYj2TCVP7oe8/.buIEwCWRkVcVmYfwGu', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2021-07-13 10:56:07', '2021-07-13 10:56:28', NULL),
(5, 'kepegawaiannhm@gmail.com', 'kepegawaiannhm', 'KEPEGAWAIAN-NHM', 'default..jpg', '81336677990', '$2y$10$W2g9bkgzJoBxXkVTakcQ8eex1rBvaNznN.j8U16KXJLzJhsjjIguW', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2021-12-23 01:22:30', '2021-12-23 01:22:30', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `auth_activation_attempts`
--
ALTER TABLE `auth_activation_attempts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `auth_groups`
--
ALTER TABLE `auth_groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `auth_groups_permissions`
--
ALTER TABLE `auth_groups_permissions`
  ADD KEY `auth_groups_permissions_permission_id_foreign` (`permission_id`),
  ADD KEY `group_id_permission_id` (`group_id`,`permission_id`);

--
-- Indexes for table `auth_groups_users`
--
ALTER TABLE `auth_groups_users`
  ADD KEY `auth_groups_users_user_id_foreign` (`user_id`),
  ADD KEY `group_id_user_id` (`group_id`,`user_id`);

--
-- Indexes for table `auth_logins`
--
ALTER TABLE `auth_logins`
  ADD PRIMARY KEY (`id`),
  ADD KEY `email` (`email`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `auth_permissions`
--
ALTER TABLE `auth_permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `auth_reset_attempts`
--
ALTER TABLE `auth_reset_attempts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `auth_tokens`
--
ALTER TABLE `auth_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `auth_tokens_user_id_foreign` (`user_id`),
  ADD KEY `selector` (`selector`);

--
-- Indexes for table `auth_users_permissions`
--
ALTER TABLE `auth_users_permissions`
  ADD KEY `auth_users_permissions_permission_id_foreign` (`permission_id`),
  ADD KEY `user_id_permission_id` (`user_id`,`permission_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_absensi`
--
ALTER TABLE `tb_absensi`
  ADD PRIMARY KEY (`id_absen`);

--
-- Indexes for table `tb_biodata`
--
ALTER TABLE `tb_biodata`
  ADD PRIMARY KEY (`user_name`);

--
-- Indexes for table `tb_gaji`
--
ALTER TABLE `tb_gaji`
  ADD PRIMARY KEY (`id_gaji`);

--
-- Indexes for table `tb_kegiatan`
--
ALTER TABLE `tb_kegiatan`
  ADD PRIMARY KEY (`id_kegiatan`);

--
-- Indexes for table `tb_pekerjaan`
--
ALTER TABLE `tb_pekerjaan`
  ADD PRIMARY KEY (`id_pekerjaan`);

--
-- Indexes for table `tb_proposal`
--
ALTER TABLE `tb_proposal`
  ADD PRIMARY KEY (`id_proposal`);

--
-- Indexes for table `tb_prsensi_kegiatan`
--
ALTER TABLE `tb_prsensi_kegiatan`
  ADD PRIMARY KEY (`id_presensi`);

--
-- Indexes for table `tb_users`
--
ALTER TABLE `tb_users`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `tb_waka`
--
ALTER TABLE `tb_waka`
  ADD PRIMARY KEY (`id_waka`);

--
-- Indexes for table `tb_waktu`
--
ALTER TABLE `tb_waktu`
  ADD PRIMARY KEY (`id_waktu`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `auth_activation_attempts`
--
ALTER TABLE `auth_activation_attempts`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `auth_groups`
--
ALTER TABLE `auth_groups`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `auth_logins`
--
ALTER TABLE `auth_logins`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=118;

--
-- AUTO_INCREMENT for table `auth_permissions`
--
ALTER TABLE `auth_permissions`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `auth_reset_attempts`
--
ALTER TABLE `auth_reset_attempts`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `auth_tokens`
--
ALTER TABLE `auth_tokens`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_absensi`
--
ALTER TABLE `tb_absensi`
  MODIFY `id_absen` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tb_gaji`
--
ALTER TABLE `tb_gaji`
  MODIFY `id_gaji` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tb_kegiatan`
--
ALTER TABLE `tb_kegiatan`
  MODIFY `id_kegiatan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tb_pekerjaan`
--
ALTER TABLE `tb_pekerjaan`
  MODIFY `id_pekerjaan` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_proposal`
--
ALTER TABLE `tb_proposal`
  MODIFY `id_proposal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tb_prsensi_kegiatan`
--
ALTER TABLE `tb_prsensi_kegiatan`
  MODIFY `id_presensi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tb_users`
--
ALTER TABLE `tb_users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=185;

--
-- AUTO_INCREMENT for table `tb_waka`
--
ALTER TABLE `tb_waka`
  MODIFY `id_waka` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tb_waktu`
--
ALTER TABLE `tb_waktu`
  MODIFY `id_waktu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `auth_groups_permissions`
--
ALTER TABLE `auth_groups_permissions`
  ADD CONSTRAINT `auth_groups_permissions_group_id_foreign` FOREIGN KEY (`group_id`) REFERENCES `auth_groups` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `auth_groups_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `auth_permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `auth_groups_users`
--
ALTER TABLE `auth_groups_users`
  ADD CONSTRAINT `auth_groups_users_group_id_foreign` FOREIGN KEY (`group_id`) REFERENCES `auth_groups` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `auth_groups_users_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `auth_tokens`
--
ALTER TABLE `auth_tokens`
  ADD CONSTRAINT `auth_tokens_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `auth_users_permissions`
--
ALTER TABLE `auth_users_permissions`
  ADD CONSTRAINT `auth_users_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `auth_permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `auth_users_permissions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
