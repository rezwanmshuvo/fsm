-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 20, 2021 at 06:29 PM
-- Server version: 5.7.24
-- PHP Version: 7.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nabiul-fsm`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `api_key_id` bigint(20) UNSIGNED DEFAULT NULL,
  `bank_name` varchar(125) COLLATE utf8mb4_unicode_ci NOT NULL,
  `account_name` varchar(125) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `account_number` varchar(125) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_branch` varchar(125) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `opening_balance` varchar(125) COLLATE utf8mb4_unicode_ci NOT NULL,
  `delete_status` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `user_id`, `api_key_id`, `bank_name`, `account_name`, `account_number`, `bank_branch`, `opening_balance`, `delete_status`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, 'Account Receivable (AR)', NULL, NULL, NULL, '0', '0', '2021-08-27 16:21:16', '2021-08-27 16:21:16'),
(2, 1, NULL, 'Account Payable (AP)', NULL, NULL, NULL, '0', '0', '2021-08-27 16:21:16', '2021-08-27 16:21:16');

-- --------------------------------------------------------

--
-- Table structure for table `api_keys`
--

CREATE TABLE `api_keys` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(125) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pos_url` varchar(125) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `system_key` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `pos_key` longtext COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `api_keys`
--

INSERT INTO `api_keys` (`id`, `name`, `pos_url`, `system_key`, `pos_key`, `created_at`, `updated_at`) VALUES
(1, 'Master Api', NULL, 'om59odgEwtkwczpXz5AdefIOy7NyidyE', NULL, '2021-08-27 16:21:16', '2021-08-27 16:21:16');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(125) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `api_key_id` bigint(20) UNSIGNED DEFAULT NULL,
  `location` varchar(125) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pos_customer_id` int(11) DEFAULT NULL,
  `phone` varchar(125) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(125) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(125) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(125) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_name` varchar(125) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `account_name` varchar(125) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `account_number` varchar(125) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_branch` varchar(125) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `current_balance` double(23,10) NOT NULL DEFAULT '0.0000000000',
  `delete_status` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `name`, `user_id`, `api_key_id`, `location`, `pos_customer_id`, `phone`, `email`, `image`, `address`, `bank_name`, `account_name`, `account_number`, `bank_branch`, `current_balance`, `delete_status`, `created_at`, `updated_at`) VALUES
(1, 'Walking Customer', 1, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.0000000000, '0', '2021-08-27 16:21:16', '2021-08-27 16:21:16'),
(2, 'Nabiul', 1, NULL, NULL, NULL, '01757290966', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.0000000000, '0', '2021-08-27 16:24:46', '2021-08-27 16:24:46'),
(3, 'Sarwar', 1, NULL, NULL, NULL, '01723099974', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.0000000000, '0', '2021-08-27 16:24:57', '2021-08-27 16:24:57'),
(4, 'Shuvo', 1, NULL, NULL, NULL, '01314447783', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.0000000000, '0', '2021-08-27 16:25:38', '2021-08-27 16:25:38');

-- --------------------------------------------------------

--
-- Table structure for table `deposits`
--

CREATE TABLE `deposits` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `account_id` bigint(20) UNSIGNED NOT NULL,
  `purpose_id` bigint(20) UNSIGNED NOT NULL,
  `sale_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `api_key_id` bigint(20) UNSIGNED DEFAULT NULL,
  `location` varchar(125) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pos_sale_id` int(11) DEFAULT NULL,
  `deposit_date` datetime NOT NULL,
  `note` varchar(125) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `voucher_number` varchar(125) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `money_receipt` varchar(125) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_amount` double(23,10) NOT NULL,
  `deposit_type` enum('menual','sales','transfer') COLLATE utf8mb4_unicode_ci NOT NULL,
  `delete_status` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `deposits`
--

INSERT INTO `deposits` (`id`, `customer_id`, `account_id`, `purpose_id`, `sale_id`, `user_id`, `api_key_id`, `location`, `pos_sale_id`, `deposit_date`, `note`, `voucher_number`, `money_receipt`, `total_amount`, `deposit_type`, `delete_status`, `created_at`, `updated_at`) VALUES
(1, 4, 1, 1, NULL, 3, NULL, NULL, NULL, '2021-05-02 23:07:17', 'Magni.', 't974bx93', NULL, 945709.0000000000, 'menual', '0', '2021-08-27 16:35:00', '2021-08-27 16:35:00'),
(2, 3, 1, 1, NULL, 2, NULL, NULL, NULL, '2021-06-05 10:12:29', 'Similique.', 'l564xb26', NULL, 563784.0000000000, 'menual', '0', '2021-08-27 16:35:00', '2021-08-27 16:35:00'),
(3, 4, 1, 1, NULL, 5, NULL, NULL, NULL, '2021-06-25 18:01:52', 'Deleniti.', 'n198yh60', NULL, 520684.0000000000, 'menual', '0', '2021-08-27 16:35:00', '2021-08-27 16:35:00'),
(4, 1, 1, 1, NULL, 2, NULL, NULL, NULL, '2021-06-23 22:10:03', 'Non possimus.', 't204oj76', NULL, 268023.0000000000, 'menual', '0', '2021-08-27 16:35:00', '2021-08-27 16:35:00'),
(5, 3, 1, 1, NULL, 2, NULL, NULL, NULL, '2021-06-03 12:42:16', 'Deleniti odio.', 'w214zl31', NULL, 715731.0000000000, 'menual', '0', '2021-08-27 16:35:00', '2021-08-27 16:35:00'),
(6, 3, 1, 1, NULL, 3, NULL, NULL, NULL, '2021-05-10 05:32:00', 'Qui enim aut.', 'u836di99', NULL, 965299.0000000000, 'menual', '0', '2021-08-27 16:35:00', '2021-08-27 16:35:00'),
(7, 4, 1, 1, NULL, 4, NULL, NULL, NULL, '2021-08-26 20:35:13', 'Ut quia.', 'd826ii76', NULL, 24859.0000000000, 'menual', '0', '2021-08-27 16:35:01', '2021-08-27 16:35:01'),
(8, 2, 1, 1, NULL, 4, NULL, NULL, NULL, '2021-06-27 00:22:34', 'Eaque amet.', 'd249ps59', NULL, 19215.0000000000, 'menual', '0', '2021-08-27 16:35:01', '2021-08-27 16:35:01'),
(9, 1, 1, 1, NULL, 4, NULL, NULL, NULL, '2021-08-16 23:20:28', 'Perferendis et.', 'l737hc67', NULL, 659112.0000000000, 'menual', '0', '2021-08-27 16:35:01', '2021-08-27 16:35:01'),
(10, 4, 1, 1, NULL, 2, NULL, NULL, NULL, '2021-06-04 14:02:52', 'Magnam sed.', 'r765vg65', NULL, 814754.0000000000, 'menual', '0', '2021-08-27 16:35:01', '2021-08-27 16:35:01'),
(11, 4, 1, 1, NULL, 5, NULL, NULL, NULL, '2021-05-14 14:14:25', 'Et tempore.', 'm878mh54', NULL, 3183.0000000000, 'menual', '0', '2021-08-27 16:35:01', '2021-08-27 16:35:01'),
(12, 3, 1, 1, NULL, 4, NULL, NULL, NULL, '2021-06-26 06:29:28', 'Et porro.', 'l607ty21', NULL, 216554.0000000000, 'menual', '0', '2021-08-27 16:35:01', '2021-08-27 16:35:01'),
(13, 1, 1, 1, NULL, 3, NULL, NULL, NULL, '2021-08-10 00:56:02', 'Optio eos.', 'o965wq51', NULL, 617756.0000000000, 'menual', '0', '2021-08-27 16:35:01', '2021-08-27 16:35:01'),
(14, 4, 1, 1, NULL, 5, NULL, NULL, NULL, '2021-06-02 21:46:56', 'Adipisci vitae.', 'v575dg61', NULL, 715396.0000000000, 'menual', '0', '2021-08-27 16:35:01', '2021-08-27 16:35:01'),
(15, 4, 1, 1, NULL, 3, NULL, NULL, NULL, '2021-05-21 09:12:37', 'Voluptate.', 'n635yc96', NULL, 688581.0000000000, 'menual', '0', '2021-08-27 16:35:01', '2021-08-27 16:35:01'),
(16, 4, 1, 1, NULL, 3, NULL, NULL, NULL, '2021-07-27 02:27:33', 'Libero non.', 'f300vh29', NULL, 583098.0000000000, 'menual', '0', '2021-08-27 16:35:01', '2021-08-27 16:35:01'),
(17, 4, 1, 1, NULL, 2, NULL, NULL, NULL, '2021-05-07 09:54:37', 'Blanditiis.', 'g595pc98', NULL, 718979.0000000000, 'menual', '0', '2021-08-27 16:35:01', '2021-08-27 16:35:01'),
(18, 3, 1, 1, NULL, 5, NULL, NULL, NULL, '2021-06-09 06:10:47', 'Dolorem.', 'f818oa08', NULL, 670101.0000000000, 'menual', '0', '2021-08-27 16:35:01', '2021-08-27 16:35:01'),
(19, 2, 1, 1, NULL, 3, NULL, NULL, NULL, '2021-05-01 11:52:47', 'Sit commodi.', 'q026lb64', NULL, 951240.0000000000, 'menual', '0', '2021-08-27 16:35:01', '2021-08-27 16:35:01'),
(20, 1, 1, 1, NULL, 2, NULL, NULL, NULL, '2021-08-03 20:36:04', 'Laboriosam.', 'c378ew72', NULL, 839581.0000000000, 'menual', '0', '2021-08-27 16:35:01', '2021-08-27 16:35:01'),
(21, 4, 1, 1, NULL, 4, NULL, NULL, NULL, '2021-06-15 21:32:00', 'Non.', 'q917lk64', NULL, 269872.0000000000, 'menual', '0', '2021-08-27 16:35:01', '2021-08-27 16:35:01'),
(22, 1, 1, 1, NULL, 5, NULL, NULL, NULL, '2021-06-26 23:39:56', 'Eaque.', 'o960ho18', NULL, 314538.0000000000, 'menual', '0', '2021-08-27 16:35:01', '2021-08-27 16:35:01'),
(23, 2, 1, 1, NULL, 4, NULL, NULL, NULL, '2021-07-23 00:18:10', 'Voluptates.', 'z653mx36', NULL, 708083.0000000000, 'menual', '0', '2021-08-27 16:35:01', '2021-08-27 16:35:01'),
(24, 1, 1, 1, NULL, 2, NULL, NULL, NULL, '2021-05-17 11:44:44', 'Aspernatur.', 'a726fs40', NULL, 806764.0000000000, 'menual', '0', '2021-08-27 16:35:01', '2021-08-27 16:35:01'),
(25, 2, 1, 1, NULL, 3, NULL, NULL, NULL, '2021-05-22 08:08:10', 'Qui et qui.', 't557qa25', NULL, 462302.0000000000, 'menual', '0', '2021-08-27 16:35:01', '2021-08-27 16:35:01'),
(26, 3, 1, 1, NULL, 4, NULL, NULL, NULL, '2021-07-27 19:47:23', 'Ex et.', 'k813db18', NULL, 737043.0000000000, 'menual', '0', '2021-08-27 16:35:01', '2021-08-27 16:35:01'),
(27, 1, 1, 1, NULL, 3, NULL, NULL, NULL, '2021-06-26 09:26:22', 'Sint id.', 'm025py25', NULL, 339085.0000000000, 'menual', '0', '2021-08-27 16:35:01', '2021-08-27 16:35:01'),
(28, 3, 1, 1, NULL, 3, NULL, NULL, NULL, '2021-08-06 02:13:37', 'Provident odit.', 'h405lr99', NULL, 17380.0000000000, 'menual', '0', '2021-08-27 16:35:01', '2021-08-27 16:35:01'),
(29, 3, 1, 1, NULL, 2, NULL, NULL, NULL, '2021-05-24 08:45:30', 'Est.', 'h604ti76', NULL, 1676.0000000000, 'menual', '0', '2021-08-27 16:35:01', '2021-08-27 16:35:01'),
(30, 4, 1, 1, NULL, 4, NULL, NULL, NULL, '2021-08-18 23:15:13', 'Voluptate esse.', 'q419xq24', NULL, 799694.0000000000, 'menual', '0', '2021-08-27 16:35:01', '2021-08-27 16:35:01'),
(31, 4, 1, 1, NULL, 3, NULL, NULL, NULL, '2021-05-12 20:38:50', 'Non deleniti.', 's042xl99', NULL, 190840.0000000000, 'menual', '0', '2021-08-27 16:35:01', '2021-08-27 16:35:01'),
(32, 2, 1, 1, NULL, 2, NULL, NULL, NULL, '2021-07-30 09:12:16', 'Voluptatem eum.', 'x697qj54', NULL, 332201.0000000000, 'menual', '0', '2021-08-27 16:35:01', '2021-08-27 16:35:01'),
(33, 1, 1, 1, NULL, 2, NULL, NULL, NULL, '2021-08-18 06:47:07', 'Quos magni eum.', 'o630kh55', NULL, 396820.0000000000, 'menual', '0', '2021-08-27 16:35:01', '2021-08-27 16:35:01'),
(34, 4, 1, 1, NULL, 2, NULL, NULL, NULL, '2021-06-15 21:52:11', 'Dolorum harum.', 'd357af18', NULL, 627818.0000000000, 'menual', '0', '2021-08-27 16:35:01', '2021-08-27 16:35:01'),
(35, 1, 1, 1, NULL, 2, NULL, NULL, NULL, '2021-07-27 19:07:25', 'Voluptatibus.', 'v082jm74', NULL, 975808.0000000000, 'menual', '0', '2021-08-27 16:35:01', '2021-08-27 16:35:01'),
(36, 1, 1, 1, NULL, 2, NULL, NULL, NULL, '2021-07-01 04:14:31', 'Aperiam.', 'r682ff08', NULL, 323295.0000000000, 'menual', '0', '2021-08-27 16:35:01', '2021-08-27 16:35:01'),
(37, 2, 1, 1, NULL, 2, NULL, NULL, NULL, '2021-06-01 01:10:08', 'Enim aut.', 'd009wi90', NULL, 388527.0000000000, 'menual', '0', '2021-08-27 16:35:01', '2021-08-27 16:35:01'),
(38, 3, 1, 1, NULL, 4, NULL, NULL, NULL, '2021-05-17 08:04:28', 'Aliquid.', 'w004xe13', NULL, 100008.0000000000, 'menual', '0', '2021-08-27 16:35:01', '2021-08-27 16:35:01'),
(39, 3, 1, 1, NULL, 3, NULL, NULL, NULL, '2021-07-10 23:46:39', 'Quidem qui ab.', 'l685ap60', NULL, 883409.0000000000, 'menual', '0', '2021-08-27 16:35:01', '2021-08-27 16:35:01'),
(40, 3, 1, 1, NULL, 3, NULL, NULL, NULL, '2021-07-01 23:21:44', 'Minima.', 'g967eq32', NULL, 853990.0000000000, 'menual', '0', '2021-08-27 16:35:01', '2021-08-27 16:35:01'),
(41, 3, 1, 1, NULL, 5, NULL, NULL, NULL, '2021-05-08 07:29:00', 'Eaque sit.', 'h036ch04', NULL, 237071.0000000000, 'menual', '0', '2021-08-27 16:35:01', '2021-08-27 16:35:01'),
(42, 1, 1, 1, NULL, 2, NULL, NULL, NULL, '2021-06-01 22:41:10', 'Voluptatum sed.', 't581po91', NULL, 581060.0000000000, 'menual', '0', '2021-08-27 16:35:02', '2021-08-27 16:35:02'),
(43, 2, 1, 1, NULL, 2, NULL, NULL, NULL, '2021-07-05 18:57:57', 'Non.', 'a654uf10', NULL, 174266.0000000000, 'menual', '0', '2021-08-27 16:35:02', '2021-08-27 16:35:02'),
(44, 1, 1, 1, NULL, 2, NULL, NULL, NULL, '2021-07-27 16:32:33', 'Recusandae ex.', 'l751gc03', NULL, 714803.0000000000, 'menual', '0', '2021-08-27 16:35:02', '2021-08-27 16:35:02'),
(45, 3, 1, 1, NULL, 2, NULL, NULL, NULL, '2021-07-05 10:25:11', 'Illo rerum.', 'l619lt94', NULL, 282127.0000000000, 'menual', '0', '2021-08-27 16:35:02', '2021-08-27 16:35:02'),
(46, 1, 1, 1, NULL, 5, NULL, NULL, NULL, '2021-07-11 16:14:22', 'Excepturi ea.', 'a055gr55', NULL, 59186.0000000000, 'menual', '0', '2021-08-27 16:35:02', '2021-08-27 16:35:02'),
(47, 1, 1, 1, NULL, 4, NULL, NULL, NULL, '2021-06-20 14:19:18', 'Illo sit.', 'x992gg53', NULL, 870817.0000000000, 'menual', '0', '2021-08-27 16:35:02', '2021-08-27 16:35:02'),
(48, 4, 1, 1, NULL, 4, NULL, NULL, NULL, '2021-08-10 18:56:34', 'Nulla amet.', 'e193cn65', NULL, 721941.0000000000, 'menual', '0', '2021-08-27 16:35:02', '2021-08-27 16:35:02'),
(49, 3, 1, 1, NULL, 4, NULL, NULL, NULL, '2021-05-18 13:04:40', 'Voluptas.', 'e351uz33', NULL, 645153.0000000000, 'menual', '0', '2021-08-27 16:35:02', '2021-08-27 16:35:02'),
(50, 4, 1, 1, NULL, 5, NULL, NULL, NULL, '2021-06-13 00:35:18', 'Dolores illo.', 'j886lb34', NULL, 308775.0000000000, 'menual', '0', '2021-08-27 16:35:02', '2021-08-27 16:35:02'),
(51, 2, 1, 1, NULL, 5, NULL, NULL, NULL, '2021-05-23 18:23:11', 'Atque.', 'h099jc62', NULL, 341423.0000000000, 'menual', '0', '2021-08-27 16:35:02', '2021-08-27 16:35:02'),
(52, 4, 1, 1, NULL, 4, NULL, NULL, NULL, '2021-06-19 05:53:25', 'In libero.', 'r770xr72', NULL, 366884.0000000000, 'menual', '0', '2021-08-27 16:35:02', '2021-08-27 16:35:02'),
(53, 3, 1, 1, NULL, 4, NULL, NULL, NULL, '2021-06-26 09:42:40', 'Aut ducimus.', 'b976jg03', NULL, 565183.0000000000, 'menual', '0', '2021-08-27 16:35:02', '2021-08-27 16:35:02'),
(54, 3, 1, 1, NULL, 4, NULL, NULL, NULL, '2021-05-21 02:36:41', 'Repellendus.', 'd139eh34', NULL, 289714.0000000000, 'menual', '0', '2021-08-27 16:35:02', '2021-08-27 16:35:02'),
(55, 3, 1, 1, NULL, 5, NULL, NULL, NULL, '2021-05-05 04:58:38', 'Mollitia.', 'f781rc75', NULL, 826329.0000000000, 'menual', '0', '2021-08-27 16:35:02', '2021-08-27 16:35:02'),
(56, 4, 1, 1, NULL, 3, NULL, NULL, NULL, '2021-06-05 04:41:20', 'Tenetur libero.', 'q950zl06', NULL, 173131.0000000000, 'menual', '0', '2021-08-27 16:35:02', '2021-08-27 16:35:02'),
(57, 1, 1, 1, NULL, 3, NULL, NULL, NULL, '2021-05-14 02:05:32', 'Sequi quia.', 's313bu54', NULL, 521021.0000000000, 'menual', '0', '2021-08-27 16:35:02', '2021-08-27 16:35:02'),
(58, 1, 1, 1, NULL, 2, NULL, NULL, NULL, '2021-06-29 10:08:22', 'Tempora.', 's829nm71', NULL, 573617.0000000000, 'menual', '0', '2021-08-27 16:35:02', '2021-08-27 16:35:02'),
(59, 4, 1, 1, NULL, 2, NULL, NULL, NULL, '2021-05-30 05:47:46', 'Eum ratione.', 'g877eq58', NULL, 660773.0000000000, 'menual', '0', '2021-08-27 16:35:02', '2021-08-27 16:35:02'),
(60, 3, 1, 1, NULL, 2, NULL, NULL, NULL, '2021-07-21 13:21:59', 'Iste dolorem.', 'i236sn90', NULL, 143468.0000000000, 'menual', '0', '2021-08-27 16:35:02', '2021-08-27 16:35:02'),
(61, 3, 1, 1, NULL, 2, NULL, NULL, NULL, '2021-08-12 15:30:34', 'Quo corporis.', 'c535hm30', NULL, 952796.0000000000, 'menual', '0', '2021-08-27 16:35:02', '2021-08-27 16:35:02'),
(62, 1, 1, 1, NULL, 4, NULL, NULL, NULL, '2021-05-02 07:01:36', 'Et laudantium.', 'g290hy95', NULL, 933292.0000000000, 'menual', '0', '2021-08-27 16:35:02', '2021-08-27 16:35:02'),
(63, 2, 1, 1, NULL, 5, NULL, NULL, NULL, '2021-05-10 05:08:45', 'Est omnis iure.', 'c183ak79', NULL, 682904.0000000000, 'menual', '0', '2021-08-27 16:35:02', '2021-08-27 16:35:02'),
(64, 4, 1, 1, NULL, 5, NULL, NULL, NULL, '2021-06-06 01:47:40', 'Id perferendis.', 'y742lu12', NULL, 172206.0000000000, 'menual', '0', '2021-08-27 16:35:02', '2021-08-27 16:35:02'),
(65, 4, 1, 1, NULL, 3, NULL, NULL, NULL, '2021-08-04 19:41:28', 'Corporis est.', 'v317jk30', NULL, 252133.0000000000, 'menual', '0', '2021-08-27 16:35:02', '2021-08-27 16:35:02'),
(66, 2, 1, 1, NULL, 5, NULL, NULL, NULL, '2021-05-28 21:51:26', 'Vitae et velit.', 'd142zr81', NULL, 506174.0000000000, 'menual', '0', '2021-08-27 16:35:02', '2021-08-27 16:35:02'),
(67, 4, 1, 1, NULL, 3, NULL, NULL, NULL, '2021-05-08 16:11:42', 'Rerum.', 'i170sg01', NULL, 625727.0000000000, 'menual', '0', '2021-08-27 16:35:02', '2021-08-27 16:35:02'),
(68, 2, 1, 1, NULL, 5, NULL, NULL, NULL, '2021-05-22 09:33:14', 'Alias illo.', 'r076qu75', NULL, 442671.0000000000, 'menual', '0', '2021-08-27 16:35:02', '2021-08-27 16:35:02'),
(69, 3, 1, 1, NULL, 2, NULL, NULL, NULL, '2021-05-17 16:06:26', 'Facilis aut.', 'r000xz30', NULL, 57982.0000000000, 'menual', '0', '2021-08-27 16:35:02', '2021-08-27 16:35:02'),
(70, 1, 1, 1, NULL, 2, NULL, NULL, NULL, '2021-05-16 05:21:07', 'Itaque est.', 'a401vd40', NULL, 199129.0000000000, 'menual', '0', '2021-08-27 16:35:02', '2021-08-27 16:35:02'),
(71, 1, 1, 1, NULL, 3, NULL, NULL, NULL, '2021-05-23 19:43:15', 'Ducimus et est.', 'z907la78', NULL, 80777.0000000000, 'menual', '0', '2021-08-27 16:35:02', '2021-08-27 16:35:02'),
(72, 2, 1, 1, NULL, 2, NULL, NULL, NULL, '2021-05-27 06:11:57', 'Ullam quod.', 't982or09', NULL, 565586.0000000000, 'menual', '0', '2021-08-27 16:35:02', '2021-08-27 16:35:02'),
(73, 4, 1, 1, NULL, 2, NULL, NULL, NULL, '2021-07-19 02:03:48', 'Eaque et ut.', 'k294fj00', NULL, 400675.0000000000, 'menual', '0', '2021-08-27 16:35:02', '2021-08-27 16:35:02'),
(74, 2, 1, 1, NULL, 5, NULL, NULL, NULL, '2021-07-23 15:07:37', 'Non nisi.', 'n307mp11', NULL, 763090.0000000000, 'menual', '0', '2021-08-27 16:35:02', '2021-08-27 16:35:02'),
(75, 4, 1, 1, NULL, 5, NULL, NULL, NULL, '2021-08-04 09:34:00', 'Consequatur.', 's687ec18', NULL, 150176.0000000000, 'menual', '0', '2021-08-27 16:35:02', '2021-08-27 16:35:02'),
(76, 1, 1, 1, NULL, 2, NULL, NULL, NULL, '2021-05-23 05:23:59', 'Rerum quia ea.', 'm207cs29', NULL, 240829.0000000000, 'menual', '0', '2021-08-27 16:35:03', '2021-08-27 16:35:03'),
(77, 4, 1, 1, NULL, 3, NULL, NULL, NULL, '2021-05-12 05:00:46', 'Minima ut.', 'l231ph51', NULL, 751927.0000000000, 'menual', '0', '2021-08-27 16:35:03', '2021-08-27 16:35:03'),
(78, 1, 1, 1, NULL, 2, NULL, NULL, NULL, '2021-06-11 21:01:41', 'Fuga eos ipsum.', 'x464ak48', NULL, 729630.0000000000, 'menual', '0', '2021-08-27 16:35:03', '2021-08-27 16:35:03'),
(79, 3, 1, 1, NULL, 4, NULL, NULL, NULL, '2021-05-11 22:45:28', 'Ad aut quidem.', 'x229ob47', NULL, 734963.0000000000, 'menual', '0', '2021-08-27 16:35:03', '2021-08-27 16:35:03'),
(80, 3, 1, 1, NULL, 3, NULL, NULL, NULL, '2021-08-13 08:51:46', 'Debitis.', 'g069du05', NULL, 643039.0000000000, 'menual', '0', '2021-08-27 16:35:03', '2021-08-27 16:35:03'),
(81, 2, 1, 1, NULL, 5, NULL, NULL, NULL, '2021-07-18 08:47:48', 'Eos explicabo.', 'b732yd72', NULL, 606360.0000000000, 'menual', '0', '2021-08-27 16:35:03', '2021-08-27 16:35:03'),
(82, 3, 1, 1, NULL, 2, NULL, NULL, NULL, '2021-08-11 10:51:58', 'Eius eum illum.', 'j961zc04', NULL, 131576.0000000000, 'menual', '0', '2021-08-27 16:35:03', '2021-08-27 16:35:03'),
(83, 1, 1, 1, NULL, 5, NULL, NULL, NULL, '2021-05-28 13:30:11', 'Et dignissimos.', 'r346aw39', NULL, 709616.0000000000, 'menual', '0', '2021-08-27 16:35:03', '2021-08-27 16:35:03'),
(84, 4, 1, 1, NULL, 4, NULL, NULL, NULL, '2021-05-17 03:07:17', 'Unde vel quo.', 'v287ee85', NULL, 212765.0000000000, 'menual', '0', '2021-08-27 16:35:03', '2021-08-27 16:35:03'),
(85, 2, 1, 1, NULL, 4, NULL, NULL, NULL, '2021-06-22 15:34:30', 'Fugiat rerum.', 'm189xy54', NULL, 579135.0000000000, 'menual', '0', '2021-08-27 16:35:03', '2021-08-27 16:35:03'),
(86, 4, 1, 1, NULL, 3, NULL, NULL, NULL, '2021-08-27 19:28:27', 'Asperiores.', 'b662lt91', NULL, 838483.0000000000, 'menual', '0', '2021-08-27 16:35:03', '2021-08-27 16:35:03'),
(87, 2, 1, 1, NULL, 3, NULL, NULL, NULL, '2021-05-29 14:00:30', 'Similique qui.', 'q535dj32', NULL, 491839.0000000000, 'menual', '0', '2021-08-27 16:35:03', '2021-08-27 16:35:03'),
(88, 3, 1, 1, NULL, 4, NULL, NULL, NULL, '2021-08-02 16:22:49', 'Ut tempore.', 'y408ba92', NULL, 809615.0000000000, 'menual', '0', '2021-08-27 16:35:03', '2021-08-27 16:35:03'),
(89, 2, 1, 1, NULL, 3, NULL, NULL, NULL, '2021-06-20 03:04:31', 'Nostrum.', 'k707jv39', NULL, 215559.0000000000, 'menual', '0', '2021-08-27 16:35:03', '2021-08-27 16:35:03'),
(90, 1, 1, 1, NULL, 2, NULL, NULL, NULL, '2021-07-25 13:33:51', 'Neque aut et.', 'j350ue92', NULL, 608245.0000000000, 'menual', '0', '2021-08-27 16:35:03', '2021-08-27 16:35:03'),
(91, 3, 1, 1, NULL, 2, NULL, NULL, NULL, '2021-05-03 07:16:36', 'Exercitationem.', 'c488dh15', NULL, 206510.0000000000, 'menual', '0', '2021-08-27 16:35:03', '2021-08-27 16:35:03'),
(92, 2, 1, 1, NULL, 5, NULL, NULL, NULL, '2021-07-21 14:23:44', 'Officia cumque.', 'y786rv77', NULL, 917134.0000000000, 'menual', '0', '2021-08-27 16:35:03', '2021-08-27 16:35:03'),
(93, 3, 1, 1, NULL, 2, NULL, NULL, NULL, '2021-07-26 09:20:26', 'Sed eum omnis.', 'y274xk59', NULL, 154132.0000000000, 'menual', '0', '2021-08-27 16:35:03', '2021-08-27 16:35:03'),
(94, 1, 1, 1, NULL, 3, NULL, NULL, NULL, '2021-07-26 00:30:13', 'Eos ipsam.', 'a183vm66', NULL, 664084.0000000000, 'menual', '0', '2021-08-27 16:35:03', '2021-08-27 16:35:03'),
(95, 3, 1, 1, NULL, 2, NULL, NULL, NULL, '2021-05-26 07:53:00', 'Cum eius.', 'l063ea64', NULL, 380234.0000000000, 'menual', '0', '2021-08-27 16:35:03', '2021-08-27 16:35:03'),
(96, 1, 1, 1, NULL, 3, NULL, NULL, NULL, '2021-05-18 23:01:40', 'Sed ullam.', 'g982kb29', NULL, 173330.0000000000, 'menual', '0', '2021-08-27 16:35:03', '2021-08-27 16:35:03'),
(97, 4, 1, 1, NULL, 4, NULL, NULL, NULL, '2021-06-11 03:44:06', 'Laudantium.', 'l872sq94', NULL, 348438.0000000000, 'menual', '0', '2021-08-27 16:35:03', '2021-08-27 16:35:03'),
(98, 4, 1, 1, NULL, 5, NULL, NULL, NULL, '2021-08-21 02:56:27', 'Nesciunt.', 'h231qr28', NULL, 10518.0000000000, 'menual', '0', '2021-08-27 16:35:03', '2021-08-27 16:35:03'),
(99, 1, 1, 1, NULL, 2, NULL, NULL, NULL, '2021-05-29 19:30:45', 'Quod minima.', 'x598ib00', NULL, 341367.0000000000, 'menual', '0', '2021-08-27 16:35:03', '2021-08-27 16:35:03'),
(100, 4, 1, 1, NULL, 5, NULL, NULL, NULL, '2021-05-28 06:36:42', 'Dicta quo.', 's930yp89', NULL, 739701.0000000000, 'menual', '0', '2021-08-27 16:35:03', '2021-08-27 16:35:03'),
(101, 1, 1, 2, NULL, 3, NULL, NULL, NULL, '2021-05-19 04:17:18', 'Eveniet.', 'o265bd63', NULL, -696595.0000000000, 'menual', '0', '2021-08-27 16:36:01', '2021-08-27 16:36:01'),
(102, 3, 1, 2, NULL, 2, NULL, NULL, NULL, '2021-06-01 02:04:51', 'Sint eos.', 'o881ik02', NULL, -97548.0000000000, 'menual', '0', '2021-08-27 16:36:01', '2021-08-27 16:36:01'),
(103, 1, 1, 2, NULL, 2, NULL, NULL, NULL, '2021-06-20 12:48:18', 'Perferendis.', 'a709nq66', NULL, -930819.0000000000, 'menual', '0', '2021-08-27 16:36:01', '2021-08-27 16:36:01'),
(104, 3, 1, 2, NULL, 3, NULL, NULL, NULL, '2021-07-05 11:20:09', 'Quia dolore.', 'o311kp06', NULL, -751146.0000000000, 'menual', '0', '2021-08-27 16:36:01', '2021-08-27 16:36:01'),
(105, 3, 1, 2, NULL, 4, NULL, NULL, NULL, '2021-06-27 01:32:20', 'Soluta.', 'b923kr87', NULL, -466168.0000000000, 'menual', '0', '2021-08-27 16:36:01', '2021-08-27 16:36:01'),
(106, 3, 1, 2, NULL, 4, NULL, NULL, NULL, '2021-08-05 11:21:27', 'Quo qui sunt.', 'y734xe24', NULL, -521083.0000000000, 'menual', '0', '2021-08-27 16:36:01', '2021-08-27 16:36:01'),
(107, 4, 1, 2, NULL, 5, NULL, NULL, NULL, '2021-07-18 02:16:36', 'Facere.', 'g721ia54', NULL, -906021.0000000000, 'menual', '0', '2021-08-27 16:36:01', '2021-08-27 16:36:01'),
(108, 2, 1, 2, NULL, 4, NULL, NULL, NULL, '2021-07-28 05:02:58', 'Ipsa vero quod.', 'p657bh85', NULL, -14473.0000000000, 'menual', '0', '2021-08-27 16:36:01', '2021-08-27 16:36:01'),
(109, 2, 1, 2, NULL, 3, NULL, NULL, NULL, '2021-07-12 17:03:51', 'Excepturi.', 'u459fs64', NULL, -616744.0000000000, 'menual', '0', '2021-08-27 16:36:01', '2021-08-27 16:36:01'),
(110, 1, 1, 2, NULL, 4, NULL, NULL, NULL, '2021-05-13 02:08:23', 'Aperiam fugit.', 'v626xe57', NULL, -692491.0000000000, 'menual', '0', '2021-08-27 16:36:01', '2021-08-27 16:36:01'),
(111, 1, 1, 2, NULL, 3, NULL, NULL, NULL, '2021-06-27 16:21:54', 'Culpa.', 'c464fp25', NULL, -623570.0000000000, 'menual', '0', '2021-08-27 16:36:01', '2021-08-27 16:36:01'),
(112, 4, 1, 2, NULL, 2, NULL, NULL, NULL, '2021-08-26 09:50:40', 'Quam molestias.', 'c812qu65', NULL, -425269.0000000000, 'menual', '0', '2021-08-27 16:36:01', '2021-08-27 16:36:01'),
(113, 1, 1, 2, NULL, 3, NULL, NULL, NULL, '2021-06-03 20:16:31', 'Commodi.', 'r573gs82', NULL, -6358.0000000000, 'menual', '0', '2021-08-27 16:36:01', '2021-08-27 16:36:01'),
(114, 4, 1, 2, NULL, 5, NULL, NULL, NULL, '2021-07-12 21:31:06', 'Fugiat sed et.', 'o551ul98', NULL, -316611.0000000000, 'menual', '0', '2021-08-27 16:36:01', '2021-08-27 16:36:01'),
(115, 1, 1, 2, NULL, 2, NULL, NULL, NULL, '2021-07-25 17:21:08', 'Id et quod.', 'v802xs63', NULL, -463619.0000000000, 'menual', '0', '2021-08-27 16:36:01', '2021-08-27 16:36:01'),
(116, 3, 1, 2, NULL, 5, NULL, NULL, NULL, '2021-05-31 09:03:02', 'Eos delectus.', 'e469ps02', NULL, -213935.0000000000, 'menual', '0', '2021-08-27 16:36:01', '2021-08-27 16:36:01'),
(117, 3, 1, 2, NULL, 5, NULL, NULL, NULL, '2021-05-04 19:32:57', 'Rerum.', 'g592qn79', NULL, -737031.0000000000, 'menual', '0', '2021-08-27 16:36:01', '2021-08-27 16:36:01'),
(118, 1, 1, 2, NULL, 2, NULL, NULL, NULL, '2021-07-03 16:30:02', 'Voluptatum.', 'y532pi37', NULL, -196440.0000000000, 'menual', '0', '2021-08-27 16:36:01', '2021-08-27 16:36:01'),
(119, 2, 1, 2, NULL, 4, NULL, NULL, NULL, '2021-07-25 12:07:08', 'Quam.', 'b930bz84', NULL, -296939.0000000000, 'menual', '0', '2021-08-27 16:36:01', '2021-08-27 16:36:01'),
(120, 1, 1, 2, NULL, 3, NULL, NULL, NULL, '2021-07-10 18:24:16', 'Inventore sit.', 'n050lm04', NULL, -393584.0000000000, 'menual', '0', '2021-08-27 16:36:01', '2021-08-27 16:36:01'),
(121, 2, 1, 2, NULL, 5, NULL, NULL, NULL, '2021-05-31 19:35:22', 'Quisquam.', 'w299hu19', NULL, -837127.0000000000, 'menual', '0', '2021-08-27 16:36:01', '2021-08-27 16:36:01'),
(122, 4, 1, 2, NULL, 2, NULL, NULL, NULL, '2021-06-20 17:50:31', 'Quo soluta.', 'b400bp24', NULL, -798006.0000000000, 'menual', '0', '2021-08-27 16:36:01', '2021-08-27 16:36:01'),
(123, 4, 1, 2, NULL, 3, NULL, NULL, NULL, '2021-06-16 17:26:01', 'Qui.', 'h713cj52', NULL, -400678.0000000000, 'menual', '0', '2021-08-27 16:36:01', '2021-08-27 16:36:01'),
(124, 2, 1, 2, NULL, 5, NULL, NULL, NULL, '2021-05-28 02:43:47', 'Dolores earum.', 'o516sk01', NULL, -859893.0000000000, 'menual', '0', '2021-08-27 16:36:02', '2021-08-27 16:36:02'),
(125, 2, 1, 2, NULL, 3, NULL, NULL, NULL, '2021-08-20 01:06:47', 'Ea non omnis.', 'f162ur14', NULL, -945768.0000000000, 'menual', '0', '2021-08-27 16:36:02', '2021-08-27 16:36:02'),
(126, 1, 1, 2, NULL, 3, NULL, NULL, NULL, '2021-08-13 01:42:35', 'Vel ad.', 'z096wx66', NULL, -289140.0000000000, 'menual', '0', '2021-08-27 16:36:02', '2021-08-27 16:36:02'),
(127, 4, 1, 2, NULL, 5, NULL, NULL, NULL, '2021-08-04 23:24:39', 'Quo.', 'j443av77', NULL, -738299.0000000000, 'menual', '0', '2021-08-27 16:36:02', '2021-08-27 16:36:02'),
(128, 3, 1, 2, NULL, 2, NULL, NULL, NULL, '2021-06-30 10:32:17', 'Tempore dolore.', 't110ib15', NULL, -929555.0000000000, 'menual', '0', '2021-08-27 16:36:02', '2021-08-27 16:36:02'),
(129, 2, 1, 2, NULL, 3, NULL, NULL, NULL, '2021-06-17 19:31:24', 'Velit quia.', 'z704dy11', NULL, -499799.0000000000, 'menual', '0', '2021-08-27 16:36:02', '2021-08-27 16:36:02'),
(130, 3, 1, 2, NULL, 5, NULL, NULL, NULL, '2021-08-16 23:59:53', 'Quia ratione.', 'p439tk46', NULL, -432890.0000000000, 'menual', '0', '2021-08-27 16:36:02', '2021-08-27 16:36:02'),
(131, 4, 1, 2, NULL, 4, NULL, NULL, NULL, '2021-06-29 09:05:55', 'Tenetur dolore.', 't138rm39', NULL, -832494.0000000000, 'menual', '0', '2021-08-27 16:36:02', '2021-08-27 16:36:02'),
(132, 4, 1, 2, NULL, 3, NULL, NULL, NULL, '2021-08-19 18:05:44', 'Eveniet ea.', 'q866ix95', NULL, -349376.0000000000, 'menual', '0', '2021-08-27 16:36:02', '2021-08-27 16:36:02'),
(133, 4, 1, 2, NULL, 3, NULL, NULL, NULL, '2021-06-27 00:00:24', 'Autem hic.', 'j039rb68', NULL, -923162.0000000000, 'menual', '0', '2021-08-27 16:36:02', '2021-08-27 16:36:02'),
(134, 4, 1, 2, NULL, 4, NULL, NULL, NULL, '2021-05-22 20:57:21', 'Aut laborum.', 'y440rq19', NULL, -352086.0000000000, 'menual', '0', '2021-08-27 16:36:02', '2021-08-27 16:36:02'),
(135, 3, 1, 2, NULL, 3, NULL, NULL, NULL, '2021-08-11 02:29:33', 'Ut repellendus.', 'm659ph63', NULL, -841300.0000000000, 'menual', '0', '2021-08-27 16:36:02', '2021-08-27 16:36:02'),
(136, 2, 1, 2, NULL, 4, NULL, NULL, NULL, '2021-07-21 22:57:47', 'Iusto saepe.', 'a132iy32', NULL, -337597.0000000000, 'menual', '0', '2021-08-27 16:36:02', '2021-08-27 16:36:02'),
(137, 1, 1, 2, NULL, 5, NULL, NULL, NULL, '2021-05-06 22:25:30', 'Omnis sed quia.', 'k745bl14', NULL, -967507.0000000000, 'menual', '0', '2021-08-27 16:36:02', '2021-08-27 16:36:02'),
(138, 3, 1, 2, NULL, 2, NULL, NULL, NULL, '2021-07-29 09:13:39', 'Tenetur qui ut.', 't821np08', NULL, -927717.0000000000, 'menual', '0', '2021-08-27 16:36:02', '2021-08-27 16:36:02'),
(139, 2, 1, 2, NULL, 2, NULL, NULL, NULL, '2021-07-04 19:40:17', 'Optio optio.', 'w217cn30', NULL, -137776.0000000000, 'menual', '0', '2021-08-27 16:36:02', '2021-08-27 16:36:02'),
(140, 1, 1, 2, NULL, 2, NULL, NULL, NULL, '2021-08-27 21:19:30', 'Quia occaecati.', 'r699qg46', NULL, -863151.0000000000, 'menual', '0', '2021-08-27 16:36:02', '2021-08-27 16:36:02'),
(141, 1, 1, 2, NULL, 3, NULL, NULL, NULL, '2021-07-07 02:45:15', 'Dolore.', 'a599ar17', NULL, -577013.0000000000, 'menual', '0', '2021-08-27 16:36:02', '2021-08-27 16:36:02'),
(142, 2, 1, 2, NULL, 5, NULL, NULL, NULL, '2021-05-14 13:56:16', 'Consequuntur.', 'k209aw20', NULL, -202952.0000000000, 'menual', '0', '2021-08-27 16:36:02', '2021-08-27 16:36:02'),
(143, 3, 1, 2, NULL, 3, NULL, NULL, NULL, '2021-06-05 17:38:40', 'Aut inventore.', 'g870ax11', NULL, -745388.0000000000, 'menual', '0', '2021-08-27 16:36:02', '2021-08-27 16:36:02'),
(144, 4, 1, 2, NULL, 2, NULL, NULL, NULL, '2021-05-18 09:06:58', 'Adipisci.', 'c644pt96', NULL, -71483.0000000000, 'menual', '0', '2021-08-27 16:36:02', '2021-08-27 16:36:02'),
(145, 1, 1, 2, NULL, 5, NULL, NULL, NULL, '2021-05-28 19:18:24', 'Sed et ut qui.', 'b385ls95', NULL, -408165.0000000000, 'menual', '0', '2021-08-27 16:36:02', '2021-08-27 16:36:02'),
(146, 2, 1, 2, NULL, 2, NULL, NULL, NULL, '2021-05-10 09:07:24', 'Perspiciatis.', 'o554fw59', NULL, -123049.0000000000, 'menual', '0', '2021-08-27 16:36:02', '2021-08-27 16:36:02'),
(147, 4, 1, 2, NULL, 2, NULL, NULL, NULL, '2021-08-24 17:57:22', 'Unde enim et.', 'q497sn11', NULL, -425886.0000000000, 'menual', '0', '2021-08-27 16:36:02', '2021-08-27 16:36:02'),
(148, 3, 1, 2, NULL, 5, NULL, NULL, NULL, '2021-05-21 09:00:20', 'Optio.', 'f764fg91', NULL, -856804.0000000000, 'menual', '0', '2021-08-27 16:36:02', '2021-08-27 16:36:02'),
(149, 4, 1, 2, NULL, 5, NULL, NULL, NULL, '2021-07-22 11:06:43', 'Ratione.', 'l484or59', NULL, -528414.0000000000, 'menual', '0', '2021-08-27 16:36:02', '2021-08-27 16:36:02'),
(150, 4, 1, 2, NULL, 2, NULL, NULL, NULL, '2021-08-09 15:37:59', 'Facere quasi.', 'y735wg93', NULL, -169757.0000000000, 'menual', '0', '2021-08-27 16:36:02', '2021-08-27 16:36:02'),
(151, 1, 1, 2, NULL, 4, NULL, NULL, NULL, '2021-08-14 17:19:53', 'Rerum velit.', 'e776zd35', NULL, -473068.0000000000, 'menual', '0', '2021-08-27 16:36:02', '2021-08-27 16:36:02'),
(152, 4, 1, 2, NULL, 3, NULL, NULL, NULL, '2021-07-03 12:37:16', 'Odio.', 'd444bt14', NULL, -129622.0000000000, 'menual', '0', '2021-08-27 16:36:02', '2021-08-27 16:36:02'),
(153, 2, 1, 2, NULL, 2, NULL, NULL, NULL, '2021-05-23 05:48:45', 'Quibusdam.', 'f231hn63', NULL, -151374.0000000000, 'menual', '0', '2021-08-27 16:36:02', '2021-08-27 16:36:02'),
(154, 4, 1, 2, NULL, 5, NULL, NULL, NULL, '2021-07-19 02:13:31', 'Et impedit.', 'f778ju57', NULL, -77217.0000000000, 'menual', '0', '2021-08-27 16:36:02', '2021-08-27 16:36:02'),
(155, 4, 1, 2, NULL, 5, NULL, NULL, NULL, '2021-05-06 12:42:59', 'Non optio.', 'c226mq25', NULL, -171219.0000000000, 'menual', '0', '2021-08-27 16:36:02', '2021-08-27 16:36:02'),
(156, 1, 1, 2, NULL, 3, NULL, NULL, NULL, '2021-07-08 04:51:43', 'Quos.', 'k144bz65', NULL, -222715.0000000000, 'menual', '0', '2021-08-27 16:36:03', '2021-08-27 16:36:03'),
(157, 3, 1, 2, NULL, 5, NULL, NULL, NULL, '2021-05-20 05:32:23', 'Tenetur dolore.', 'u987zq66', NULL, -250986.0000000000, 'menual', '0', '2021-08-27 16:36:03', '2021-08-27 16:36:03'),
(158, 2, 1, 2, NULL, 4, NULL, NULL, NULL, '2021-08-18 02:42:50', 'Ut nemo et qui.', 's486ne44', NULL, -618786.0000000000, 'menual', '0', '2021-08-27 16:36:03', '2021-08-27 16:36:03'),
(159, 2, 1, 2, NULL, 2, NULL, NULL, NULL, '2021-06-02 02:20:35', 'Consectetur.', 'u266nn52', NULL, -442066.0000000000, 'menual', '0', '2021-08-27 16:36:03', '2021-08-27 16:36:03'),
(160, 1, 1, 2, NULL, 2, NULL, NULL, NULL, '2021-06-06 12:16:34', 'Maxime ratione.', 'j333gg54', NULL, -637087.0000000000, 'menual', '0', '2021-08-27 16:36:03', '2021-08-27 16:36:03'),
(161, 2, 1, 2, NULL, 4, NULL, NULL, NULL, '2021-08-19 14:37:59', 'Voluptates et.', 'z095vh71', NULL, -588750.0000000000, 'menual', '0', '2021-08-27 16:36:03', '2021-08-27 16:36:03'),
(162, 2, 1, 2, NULL, 4, NULL, NULL, NULL, '2021-05-10 09:36:53', 'Officia et.', 'x025rd71', NULL, -244539.0000000000, 'menual', '0', '2021-08-27 16:36:03', '2021-08-27 16:36:03'),
(163, 3, 1, 2, NULL, 3, NULL, NULL, NULL, '2021-06-16 09:43:13', 'Non quo odio.', 'e682ri54', NULL, -671551.0000000000, 'menual', '0', '2021-08-27 16:36:03', '2021-08-27 16:36:03'),
(164, 2, 1, 2, NULL, 5, NULL, NULL, NULL, '2021-06-26 17:47:51', 'Omnis hic.', 'h809ls58', NULL, -817287.0000000000, 'menual', '0', '2021-08-27 16:36:03', '2021-08-27 16:36:03'),
(165, 2, 1, 2, NULL, 3, NULL, NULL, NULL, '2021-07-16 09:04:21', 'Quod et.', 'w749hz32', NULL, -830657.0000000000, 'menual', '0', '2021-08-27 16:36:03', '2021-08-27 16:36:03'),
(166, 1, 1, 2, NULL, 4, NULL, NULL, NULL, '2021-05-02 15:49:31', 'Voluptate.', 'd668nz82', NULL, -472352.0000000000, 'menual', '0', '2021-08-27 16:36:03', '2021-08-27 16:36:03'),
(167, 1, 1, 2, NULL, 2, NULL, NULL, NULL, '2021-07-23 15:09:16', 'Ut quaerat.', 'd095dk44', NULL, -323266.0000000000, 'menual', '0', '2021-08-27 16:36:03', '2021-08-27 16:36:03'),
(168, 3, 1, 2, NULL, 4, NULL, NULL, NULL, '2021-06-29 07:05:59', 'Qui veritatis.', 'u184nh83', NULL, -845257.0000000000, 'menual', '0', '2021-08-27 16:36:03', '2021-08-27 16:36:03'),
(169, 3, 1, 2, NULL, 3, NULL, NULL, NULL, '2021-08-18 14:31:57', 'Dolore.', 'p338dn39', NULL, -539824.0000000000, 'menual', '0', '2021-08-27 16:36:03', '2021-08-27 16:36:03'),
(170, 3, 1, 2, NULL, 5, NULL, NULL, NULL, '2021-08-19 02:08:30', 'Fuga quidem.', 'x549hk00', NULL, -831984.0000000000, 'menual', '0', '2021-08-27 16:36:03', '2021-08-27 16:36:03'),
(171, 2, 1, 2, NULL, 2, NULL, NULL, NULL, '2021-08-11 14:14:20', 'Facilis.', 'u449cq18', NULL, -560552.0000000000, 'menual', '0', '2021-08-27 16:36:03', '2021-08-27 16:36:03'),
(172, 1, 1, 2, NULL, 5, NULL, NULL, NULL, '2021-05-14 18:55:31', 'Et corporis.', 'e098sd13', NULL, -652196.0000000000, 'menual', '0', '2021-08-27 16:36:03', '2021-08-27 16:36:03'),
(173, 1, 1, 2, NULL, 3, NULL, NULL, NULL, '2021-08-18 07:48:28', 'Voluptas.', 'q625cp83', NULL, -42798.0000000000, 'menual', '0', '2021-08-27 16:36:03', '2021-08-27 16:36:03'),
(174, 3, 1, 2, NULL, 4, NULL, NULL, NULL, '2021-05-26 20:30:19', 'Modi culpa.', 'i956yn09', NULL, -789619.0000000000, 'menual', '0', '2021-08-27 16:36:03', '2021-08-27 16:36:03'),
(175, 1, 1, 2, NULL, 3, NULL, NULL, NULL, '2021-05-31 09:54:11', 'Fugiat est.', 't807hd17', NULL, -160351.0000000000, 'menual', '0', '2021-08-27 16:36:03', '2021-08-27 16:36:03'),
(176, 1, 1, 2, NULL, 4, NULL, NULL, NULL, '2021-06-08 19:23:28', 'Ut facilis.', 'r730ui57', NULL, -737373.0000000000, 'menual', '0', '2021-08-27 16:36:03', '2021-08-27 16:36:03'),
(177, 1, 1, 2, NULL, 4, NULL, NULL, NULL, '2021-05-30 11:37:45', 'Eius nostrum.', 'e375ou40', NULL, -535012.0000000000, 'menual', '0', '2021-08-27 16:36:03', '2021-08-27 16:36:03'),
(178, 2, 1, 2, NULL, 4, NULL, NULL, NULL, '2021-08-16 12:31:14', 'Ipsam fugit et.', 't556sd11', NULL, -825998.0000000000, 'menual', '0', '2021-08-27 16:36:03', '2021-08-27 16:36:03'),
(179, 1, 1, 2, NULL, 5, NULL, NULL, NULL, '2021-07-12 01:30:28', 'Voluptatem.', 'p652ji66', NULL, -959509.0000000000, 'menual', '0', '2021-08-27 16:36:03', '2021-08-27 16:36:03'),
(180, 4, 1, 2, NULL, 4, NULL, NULL, NULL, '2021-06-07 22:33:11', 'Itaque.', 'l250yb51', NULL, -140902.0000000000, 'menual', '0', '2021-08-27 16:36:03', '2021-08-27 16:36:03'),
(181, 4, 1, 2, NULL, 4, NULL, NULL, NULL, '2021-07-30 09:36:17', 'Magni est.', 'p920ns59', NULL, -72632.0000000000, 'menual', '0', '2021-08-27 16:36:03', '2021-08-27 16:36:03'),
(182, 4, 1, 2, NULL, 4, NULL, NULL, NULL, '2021-06-15 09:45:51', 'Dolorem.', 'y656bi75', NULL, -212114.0000000000, 'menual', '0', '2021-08-27 16:36:03', '2021-08-27 16:36:03'),
(183, 3, 1, 2, NULL, 3, NULL, NULL, NULL, '2021-08-17 09:02:11', 'Dolor ut nulla.', 'j362bq30', NULL, -320317.0000000000, 'menual', '0', '2021-08-27 16:36:03', '2021-08-27 16:36:03'),
(184, 2, 1, 2, NULL, 4, NULL, NULL, NULL, '2021-07-08 11:15:29', 'Aut quis sint.', 't758gs84', NULL, -331706.0000000000, 'menual', '0', '2021-08-27 16:36:03', '2021-08-27 16:36:03'),
(185, 2, 1, 2, NULL, 5, NULL, NULL, NULL, '2021-07-15 21:55:54', 'Nisi et.', 'a411zh55', NULL, -927671.0000000000, 'menual', '0', '2021-08-27 16:36:03', '2021-08-27 16:36:03'),
(186, 4, 1, 2, NULL, 5, NULL, NULL, NULL, '2021-05-31 18:39:02', 'Velit officiis.', 'e043dm95', NULL, -625392.0000000000, 'menual', '0', '2021-08-27 16:36:03', '2021-08-27 16:36:03'),
(187, 1, 1, 2, NULL, 2, NULL, NULL, NULL, '2021-06-14 01:01:32', 'Mollitia minus.', 'c019fy96', NULL, -631893.0000000000, 'menual', '0', '2021-08-27 16:36:03', '2021-08-27 16:36:03'),
(188, 3, 1, 2, NULL, 2, NULL, NULL, NULL, '2021-05-29 02:51:19', 'Nostrum at.', 't414ar57', NULL, -18095.0000000000, 'menual', '0', '2021-08-27 16:36:03', '2021-08-27 16:36:03'),
(189, 3, 1, 2, NULL, 4, NULL, NULL, NULL, '2021-07-03 13:23:53', 'Alias.', 'v309ml40', NULL, -739427.0000000000, 'menual', '0', '2021-08-27 16:36:04', '2021-08-27 16:36:04'),
(190, 4, 1, 2, NULL, 2, NULL, NULL, NULL, '2021-08-16 02:31:31', 'Natus illum.', 'm664ix97', NULL, -536268.0000000000, 'menual', '0', '2021-08-27 16:36:04', '2021-08-27 16:36:04'),
(191, 3, 1, 2, NULL, 3, NULL, NULL, NULL, '2021-06-27 02:47:34', 'Minima libero.', 'c231cg14', NULL, -484770.0000000000, 'menual', '0', '2021-08-27 16:36:04', '2021-08-27 16:36:04'),
(192, 1, 1, 2, NULL, 4, NULL, NULL, NULL, '2021-05-17 00:07:45', 'Tenetur.', 'l710bl05', NULL, -646908.0000000000, 'menual', '0', '2021-08-27 16:36:04', '2021-08-27 16:36:04'),
(193, 1, 1, 2, NULL, 3, NULL, NULL, NULL, '2021-06-28 23:22:34', 'Dolor.', 'e097dk14', NULL, -724578.0000000000, 'menual', '0', '2021-08-27 16:36:04', '2021-08-27 16:36:04'),
(194, 1, 1, 2, NULL, 4, NULL, NULL, NULL, '2021-08-15 07:31:01', 'Doloribus.', 'g244zx48', NULL, -244655.0000000000, 'menual', '0', '2021-08-27 16:36:04', '2021-08-27 16:36:04'),
(195, 1, 1, 2, NULL, 4, NULL, NULL, NULL, '2021-06-14 12:43:06', 'Ipsum pariatur.', 't084zp46', NULL, -593861.0000000000, 'menual', '0', '2021-08-27 16:36:04', '2021-08-27 16:36:04'),
(196, 2, 1, 2, NULL, 3, NULL, NULL, NULL, '2021-06-18 19:41:43', 'Neque.', 'j950or74', NULL, -468163.0000000000, 'menual', '0', '2021-08-27 16:36:04', '2021-08-27 16:36:04'),
(197, 2, 1, 2, NULL, 4, NULL, NULL, NULL, '2021-06-05 01:33:42', 'Eos blanditiis.', 'y093nf88', NULL, -597304.0000000000, 'menual', '0', '2021-08-27 16:36:04', '2021-08-27 16:36:04'),
(198, 4, 1, 2, NULL, 3, NULL, NULL, NULL, '2021-05-14 11:42:23', 'Incidunt.', 'z114zd24', NULL, -706939.0000000000, 'menual', '0', '2021-08-27 16:36:04', '2021-08-27 16:36:04'),
(199, 3, 1, 2, NULL, 2, NULL, NULL, NULL, '2021-05-05 11:31:34', 'Mollitia quasi.', 'j645ov10', NULL, -687595.0000000000, 'menual', '0', '2021-08-27 16:36:04', '2021-08-27 16:36:04'),
(200, 4, 1, 2, NULL, 4, NULL, NULL, NULL, '2021-08-12 06:54:40', 'Possimus et.', 'n251bv92', NULL, -992379.0000000000, 'menual', '0', '2021-08-27 16:36:04', '2021-08-27 16:36:04');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(125) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item_category_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `api_key_id` bigint(20) UNSIGNED DEFAULT NULL,
  `location` varchar(125) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pos_item_id` int(11) DEFAULT NULL,
  `category_name` varchar(125) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `delete_status` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `item_categories`
--

CREATE TABLE `item_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(125) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `api_key_id` bigint(20) UNSIGNED DEFAULT NULL,
  `pos_category_id` int(11) DEFAULT NULL,
  `delete_status` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `item_categories`
--

INSERT INTO `item_categories` (`id`, `name`, `parent_id`, `user_id`, `api_key_id`, `pos_category_id`, `delete_status`, `created_at`, `updated_at`) VALUES
(1, 'POS Category', NULL, 1, NULL, NULL, '0', '2021-08-27 16:21:16', '2021-08-27 16:21:16');

-- --------------------------------------------------------

--
-- Table structure for table `machines`
--

CREATE TABLE `machines` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `api_key_id` bigint(20) UNSIGNED DEFAULT NULL,
  `tank_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(125) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model` varchar(125) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_of_nozzle` varchar(125) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `serial_no` varchar(125) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `delete_status` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(125) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2021_03_23_113618_create_permission_tables', 1),
(5, '2021_03_23_121200_create_settings_table', 1),
(6, '2021_03_23_121201_create_api_keys_table', 1),
(7, '2021_03_23_122129_create_parties_table', 1),
(8, '2021_03_23_130236_create_customers_table', 1),
(9, '2021_03_23_131941_create_accounts_table', 1),
(10, '2021_03_23_133535_create_purposes_table', 1),
(11, '2021_03_24_113430_create_item_categories_table', 1),
(12, '2021_03_24_114340_create_items_table', 1),
(13, '2021_03_24_123657_create_purchases_table', 1),
(14, '2021_03_24_130801_create_purchase_items_table', 1),
(15, '2021_03_28_104342_create_sales_table', 1),
(16, '2021_03_28_110756_create_sale_items_table', 1),
(17, '2021_03_28_112557_create_deposits_table', 1),
(18, '2021_03_28_112558_create_withdraws_table', 1),
(19, '2021_05_07_065417_create_pages_table', 1),
(20, '2021_08_03_211649_add_api_key_id_and_pos_employee_id_to_users_table', 1),
(21, '2021_08_03_212428_add_location_to_users_table', 1),
(23, '2014_10_12_000001_add_shift_id_to_users', 3),
(26, '2014_10_11_000000_create_shifts_table', 4),
(27, '2021_09_21_000106_create_tanks_table', 4),
(28, '2021_09_21_000838_create_machines_table', 5),
(29, '2021_09_21_002216_create_nozzles_table', 5);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(125) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(125) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\User', 1),
(2, 'App\\User', 2),
(5, 'App\\User', 3),
(3, 'App\\User', 4),
(4, 'App\\User', 5);

-- --------------------------------------------------------

--
-- Table structure for table `nozzles`
--

CREATE TABLE `nozzles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `api_key_id` bigint(20) UNSIGNED DEFAULT NULL,
  `machine_id` bigint(20) UNSIGNED NOT NULL,
  `item_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(125) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_reading` double(23,10) NOT NULL,
  `delete_status` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(125) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `title`, `status`, `created_at`, `updated_at`) VALUES
(1, 'global', 'active', '2021-08-27 16:21:15', '2021-08-27 16:21:15'),
(2, 'role', 'active', '2021-08-27 16:21:15', '2021-08-27 16:21:15'),
(3, 'user', 'active', '2021-08-27 16:21:15', '2021-08-27 16:21:15');

-- --------------------------------------------------------

--
-- Table structure for table `parties`
--

CREATE TABLE `parties` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(125) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `api_key_id` bigint(20) UNSIGNED DEFAULT NULL,
  `location` varchar(125) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pos_supplier_id` int(11) DEFAULT NULL,
  `phone` varchar(125) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(125) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(125) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(125) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_name` varchar(125) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `account_name` varchar(125) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `account_number` varchar(125) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_branch` varchar(125) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `current_balance` double(23,10) NOT NULL DEFAULT '0.0000000000',
  `delete_status` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `parties`
--

INSERT INTO `parties` (`id`, `name`, `user_id`, `api_key_id`, `location`, `pos_supplier_id`, `phone`, `email`, `image`, `address`, `bank_name`, `account_name`, `account_number`, `bank_branch`, `current_balance`, `delete_status`, `created_at`, `updated_at`) VALUES
(1, 'Walking Supplier', 1, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.0000000000, '0', '2021-08-27 16:21:16', '2021-08-27 16:21:16');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(125) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(125) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(125) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(125) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'master', 'web', '2021-08-27 16:21:15', '2021-08-27 16:21:15'),
(2, 'global', 'web', '2021-08-27 16:21:15', '2021-08-27 16:21:15'),
(3, 'role view', 'web', '2021-08-27 16:21:15', '2021-08-27 16:21:15'),
(4, 'role create', 'web', '2021-08-27 16:21:15', '2021-08-27 16:21:15'),
(5, 'role edit', 'web', '2021-08-27 16:21:15', '2021-08-27 16:21:15'),
(6, 'role delete', 'web', '2021-08-27 16:21:15', '2021-08-27 16:21:15'),
(7, 'user view', 'web', '2021-08-27 16:21:15', '2021-08-27 16:21:15'),
(8, 'user create', 'web', '2021-08-27 16:21:15', '2021-08-27 16:21:15'),
(9, 'user edit', 'web', '2021-08-27 16:21:15', '2021-08-27 16:21:15'),
(10, 'user delete', 'web', '2021-08-27 16:21:15', '2021-08-27 16:21:15');

-- --------------------------------------------------------

--
-- Table structure for table `purchases`
--

CREATE TABLE `purchases` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `purchase_date` datetime NOT NULL,
  `party_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `api_key_id` bigint(20) UNSIGNED DEFAULT NULL,
  `location` varchar(125) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pos_receiving_id` int(11) DEFAULT NULL,
  `total_purchase_quantity` double(23,10) NOT NULL,
  `total_discount` double(23,10) NOT NULL DEFAULT '0.0000000000',
  `sub_total_amount` double(23,10) NOT NULL,
  `total_amount` double(23,10) NOT NULL,
  `delete_status` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_items`
--

CREATE TABLE `purchase_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `purchase_id` bigint(20) UNSIGNED NOT NULL,
  `item_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `api_key_id` bigint(20) UNSIGNED DEFAULT NULL,
  `location` varchar(125) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pos_receiving_item_id` int(11) DEFAULT NULL,
  `purchase_quantity` double(23,10) NOT NULL,
  `unit_price` double(23,10) NOT NULL,
  `discount` double(23,10) NOT NULL,
  `sub_total` double(23,10) NOT NULL,
  `total` double(23,10) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purposes`
--

CREATE TABLE `purposes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(125) COLLATE utf8mb4_unicode_ci NOT NULL,
  `purpose_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `api_key_id` bigint(20) UNSIGNED DEFAULT NULL,
  `pos_purpose_id` int(11) DEFAULT NULL,
  `purpose_type` enum('income','expanse') COLLATE utf8mb4_unicode_ci NOT NULL,
  `delete_status` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `purposes`
--

INSERT INTO `purposes` (`id`, `name`, `purpose_id`, `user_id`, `api_key_id`, `pos_purpose_id`, `purpose_type`, `delete_status`, `created_at`, `updated_at`) VALUES
(1, 'Sales Invoice', NULL, 1, NULL, NULL, 'income', '0', '2021-08-27 16:21:16', '2021-08-27 16:21:16'),
(2, 'Sales Payment', NULL, 1, NULL, NULL, 'income', '0', '2021-08-27 16:21:16', '2021-08-27 16:21:16'),
(3, 'Customer Store Account Manual Edit', NULL, 1, NULL, NULL, 'income', '0', '2021-08-27 16:21:16', '2021-08-27 16:21:16'),
(4, 'Purchase Invoice', NULL, 1, NULL, NULL, 'expanse', '0', '2021-08-27 16:21:16', '2021-08-27 16:21:16'),
(5, 'Purchase Payment', NULL, 1, NULL, NULL, 'expanse', '0', '2021-08-27 16:21:16', '2021-08-27 16:21:16'),
(6, 'Supplier Store Account Manual Edit', NULL, 1, NULL, NULL, 'expanse', '0', '2021-08-27 16:21:16', '2021-08-27 16:21:16'),
(7, 'Deposit Transfer', NULL, 1, NULL, NULL, 'income', '0', '2021-08-27 16:21:16', '2021-08-27 16:21:16'),
(8, 'Withdraw Transfer', NULL, 1, NULL, NULL, 'expanse', '0', '2021-08-27 16:21:16', '2021-08-27 16:21:16');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(125) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(125) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'developer', 'web', '2021-08-27 16:21:15', '2021-08-27 16:21:15'),
(2, 'super admin', 'web', '2021-08-27 16:21:15', '2021-08-27 16:21:15'),
(3, 'test admin', 'web', '2021-08-27 16:28:01', '2021-08-27 16:28:01'),
(4, 'test admin 2', 'web', '2021-08-27 16:28:11', '2021-08-27 16:28:11'),
(5, 'test admin 3', 'web', '2021-08-27 16:28:21', '2021-08-27 16:28:21');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(2, 2),
(2, 3),
(2, 4),
(2, 5);

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sale_date` datetime NOT NULL,
  `customer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `api_key_id` bigint(20) UNSIGNED DEFAULT NULL,
  `location` varchar(125) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pos_sale_id` int(11) DEFAULT NULL,
  `total_sale_quantity` double(23,10) NOT NULL,
  `total_discount` double(23,10) NOT NULL DEFAULT '0.0000000000',
  `sub_total_amount` double(23,10) NOT NULL,
  `total_amount` double(23,10) NOT NULL,
  `delete_status` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `hold_status` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sale_items`
--

CREATE TABLE `sale_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sale_id` bigint(20) UNSIGNED NOT NULL,
  `item_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `api_key_id` bigint(20) UNSIGNED DEFAULT NULL,
  `location` varchar(125) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pos_sale_item_id` int(11) DEFAULT NULL,
  `sale_quantity` double(23,10) NOT NULL,
  `unit_price` double(23,10) NOT NULL,
  `discount` double(23,10) NOT NULL,
  `sub_total` double(23,10) NOT NULL,
  `total` double(23,10) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `key` varchar(125) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` varchar(125) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `shifts`
--

CREATE TABLE `shifts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `api_key_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(125) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `delete_status` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tanks`
--

CREATE TABLE `tanks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `api_key_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(125) COLLATE utf8mb4_unicode_ci NOT NULL,
  `capacity` double(23,10) NOT NULL,
  `dip_min` double(23,10) NOT NULL,
  `dip_max` double(23,10) NOT NULL,
  `dip_in_mm` double(23,10) NOT NULL,
  `delete_status` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `shift_id` bigint(20) UNSIGNED DEFAULT NULL,
  `api_key_id` bigint(20) UNSIGNED DEFAULT NULL,
  `pos_employee_id` int(11) DEFAULT NULL,
  `location` varchar(125) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(125) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(125) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(125) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(125) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(125) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(125) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('active','inactve') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(125) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `shift_id`, `api_key_id`, `pos_employee_id`, `location`, `name`, `username`, `email`, `phone`, `address`, `image`, `status`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, NULL, NULL, NULL, NULL, 'Master Developer', 'developer', 'dev@email.com', NULL, NULL, NULL, 'active', NULL, '$2y$10$D6Rgf5dkeWUNklJNaAtnOulV8.bfWMHDSyMCNSv7isiumw9m9x8oa', NULL, '2021-08-27 16:21:16', '2021-08-27 16:21:16'),
(2, NULL, NULL, NULL, NULL, 'Master Super Admin', 'admin', 'admin@email.com', NULL, NULL, NULL, 'active', NULL, '$2y$10$W8VrQb1ZEle/g93c.bYyWOPw/FiobipIYJBDad4anujtWflgl.2bm', NULL, '2021-08-27 16:21:16', '2021-08-27 16:21:16'),
(3, NULL, NULL, NULL, NULL, 'test Admin', 'testadmin', NULL, NULL, NULL, NULL, 'active', NULL, '$2y$10$vyjTDa4yZHpnIKv5v3Zqs.ueo4prgOxNTQUkPSod7V3UxCziWzpKm', NULL, '2021-08-27 16:28:54', '2021-08-27 16:28:54'),
(4, NULL, NULL, NULL, NULL, 'Test Admin 1', 'testadmin1', NULL, NULL, NULL, NULL, 'active', NULL, '$2y$10$cWETVJHR49JqchgFgcSStOunBFsvpSmzNkaDLrQNOpGoLf5oGw7xa', NULL, '2021-08-27 16:29:35', '2021-08-27 16:29:35'),
(5, NULL, NULL, NULL, NULL, 'testadmin2', 'testadmin2', NULL, NULL, NULL, NULL, 'active', NULL, '$2y$10$K3o.4tLXn4Wm9sLmBJB3tekHlRUwSFh6SsbSKfJqUVuk.0e/efjdW', NULL, '2021-08-27 16:30:05', '2021-08-27 16:30:05');

-- --------------------------------------------------------

--
-- Table structure for table `withdraws`
--

CREATE TABLE `withdraws` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `party_id` bigint(20) UNSIGNED DEFAULT NULL,
  `account_id` bigint(20) UNSIGNED NOT NULL,
  `purpose_id` bigint(20) UNSIGNED NOT NULL,
  `purchase_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `api_key_id` bigint(20) UNSIGNED DEFAULT NULL,
  `location` varchar(125) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pos_receiving_id` int(11) DEFAULT NULL,
  `pos_expense_id` int(11) DEFAULT NULL,
  `withdraw_date` datetime NOT NULL,
  `note` varchar(125) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `voucher_number` varchar(125) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `money_receipt` varchar(125) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_amount` double(23,10) NOT NULL,
  `withdraw_type` enum('menual','purchase','expense','transfer') COLLATE utf8mb4_unicode_ci NOT NULL,
  `delete_status` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `accounts_user_id_foreign` (`user_id`),
  ADD KEY `accounts_api_key_id_foreign` (`api_key_id`);

--
-- Indexes for table `api_keys`
--
ALTER TABLE `api_keys`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customers_user_id_foreign` (`user_id`),
  ADD KEY `customers_api_key_id_foreign` (`api_key_id`);

--
-- Indexes for table `deposits`
--
ALTER TABLE `deposits`
  ADD PRIMARY KEY (`id`),
  ADD KEY `deposits_customer_id_foreign` (`customer_id`),
  ADD KEY `deposits_account_id_foreign` (`account_id`),
  ADD KEY `deposits_purpose_id_foreign` (`purpose_id`),
  ADD KEY `deposits_sale_id_foreign` (`sale_id`),
  ADD KEY `deposits_user_id_foreign` (`user_id`),
  ADD KEY `deposits_api_key_id_foreign` (`api_key_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `items_item_category_id_foreign` (`item_category_id`),
  ADD KEY `items_user_id_foreign` (`user_id`),
  ADD KEY `items_api_key_id_foreign` (`api_key_id`);

--
-- Indexes for table `item_categories`
--
ALTER TABLE `item_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `item_categories_user_id_foreign` (`user_id`),
  ADD KEY `item_categories_api_key_id_foreign` (`api_key_id`);

--
-- Indexes for table `machines`
--
ALTER TABLE `machines`
  ADD PRIMARY KEY (`id`),
  ADD KEY `machines_api_key_id_foreign` (`api_key_id`),
  ADD KEY `machines_tank_id_foreign` (`tank_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `nozzles`
--
ALTER TABLE `nozzles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nozzles_api_key_id_foreign` (`api_key_id`),
  ADD KEY `nozzles_machine_id_foreign` (`machine_id`),
  ADD KEY `nozzles_item_id_foreign` (`item_id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pages_title_unique` (`title`);

--
-- Indexes for table `parties`
--
ALTER TABLE `parties`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parties_user_id_foreign` (`user_id`),
  ADD KEY `parties_api_key_id_foreign` (`api_key_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `purchases`
--
ALTER TABLE `purchases`
  ADD PRIMARY KEY (`id`),
  ADD KEY `purchases_party_id_foreign` (`party_id`),
  ADD KEY `purchases_user_id_foreign` (`user_id`),
  ADD KEY `purchases_api_key_id_foreign` (`api_key_id`);

--
-- Indexes for table `purchase_items`
--
ALTER TABLE `purchase_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `purchase_items_purchase_id_foreign` (`purchase_id`),
  ADD KEY `purchase_items_item_id_foreign` (`item_id`),
  ADD KEY `purchase_items_user_id_foreign` (`user_id`),
  ADD KEY `purchase_items_api_key_id_foreign` (`api_key_id`);

--
-- Indexes for table `purposes`
--
ALTER TABLE `purposes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `purposes_purpose_id_foreign` (`purpose_id`),
  ADD KEY `purposes_user_id_foreign` (`user_id`),
  ADD KEY `purposes_api_key_id_foreign` (`api_key_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sales_customer_id_foreign` (`customer_id`),
  ADD KEY `sales_user_id_foreign` (`user_id`),
  ADD KEY `sales_api_key_id_foreign` (`api_key_id`);

--
-- Indexes for table `sale_items`
--
ALTER TABLE `sale_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sale_items_sale_id_foreign` (`sale_id`),
  ADD KEY `sale_items_item_id_foreign` (`item_id`),
  ADD KEY `sale_items_user_id_foreign` (`user_id`),
  ADD KEY `sale_items_api_key_id_foreign` (`api_key_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `settings_key_unique` (`key`);

--
-- Indexes for table `shifts`
--
ALTER TABLE `shifts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `shifts_api_key_id_foreign` (`api_key_id`);

--
-- Indexes for table `tanks`
--
ALTER TABLE `tanks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tanks_api_key_id_foreign` (`api_key_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD KEY `users_api_key_id_foreign` (`api_key_id`),
  ADD KEY `users_shift_id_foreign` (`shift_id`);

--
-- Indexes for table `withdraws`
--
ALTER TABLE `withdraws`
  ADD PRIMARY KEY (`id`),
  ADD KEY `withdraws_party_id_foreign` (`party_id`),
  ADD KEY `withdraws_account_id_foreign` (`account_id`),
  ADD KEY `withdraws_purpose_id_foreign` (`purpose_id`),
  ADD KEY `withdraws_purchase_id_foreign` (`purchase_id`),
  ADD KEY `withdraws_user_id_foreign` (`user_id`),
  ADD KEY `withdraws_api_key_id_foreign` (`api_key_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `api_keys`
--
ALTER TABLE `api_keys`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `deposits`
--
ALTER TABLE `deposits`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=201;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `item_categories`
--
ALTER TABLE `item_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `machines`
--
ALTER TABLE `machines`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `nozzles`
--
ALTER TABLE `nozzles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `parties`
--
ALTER TABLE `parties`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `purchases`
--
ALTER TABLE `purchases`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchase_items`
--
ALTER TABLE `purchase_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purposes`
--
ALTER TABLE `purposes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sale_items`
--
ALTER TABLE `sale_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `shifts`
--
ALTER TABLE `shifts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tanks`
--
ALTER TABLE `tanks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `withdraws`
--
ALTER TABLE `withdraws`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `accounts`
--
ALTER TABLE `accounts`
  ADD CONSTRAINT `accounts_api_key_id_foreign` FOREIGN KEY (`api_key_id`) REFERENCES `api_keys` (`id`),
  ADD CONSTRAINT `accounts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `customers`
--
ALTER TABLE `customers`
  ADD CONSTRAINT `customers_api_key_id_foreign` FOREIGN KEY (`api_key_id`) REFERENCES `api_keys` (`id`),
  ADD CONSTRAINT `customers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `deposits`
--
ALTER TABLE `deposits`
  ADD CONSTRAINT `deposits_account_id_foreign` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`),
  ADD CONSTRAINT `deposits_api_key_id_foreign` FOREIGN KEY (`api_key_id`) REFERENCES `api_keys` (`id`),
  ADD CONSTRAINT `deposits_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`),
  ADD CONSTRAINT `deposits_purpose_id_foreign` FOREIGN KEY (`purpose_id`) REFERENCES `purposes` (`id`),
  ADD CONSTRAINT `deposits_sale_id_foreign` FOREIGN KEY (`sale_id`) REFERENCES `sales` (`id`),
  ADD CONSTRAINT `deposits_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `items_api_key_id_foreign` FOREIGN KEY (`api_key_id`) REFERENCES `api_keys` (`id`),
  ADD CONSTRAINT `items_item_category_id_foreign` FOREIGN KEY (`item_category_id`) REFERENCES `item_categories` (`id`),
  ADD CONSTRAINT `items_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `item_categories`
--
ALTER TABLE `item_categories`
  ADD CONSTRAINT `item_categories_api_key_id_foreign` FOREIGN KEY (`api_key_id`) REFERENCES `api_keys` (`id`),
  ADD CONSTRAINT `item_categories_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `machines`
--
ALTER TABLE `machines`
  ADD CONSTRAINT `machines_api_key_id_foreign` FOREIGN KEY (`api_key_id`) REFERENCES `api_keys` (`id`),
  ADD CONSTRAINT `machines_tank_id_foreign` FOREIGN KEY (`tank_id`) REFERENCES `tanks` (`id`);

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
-- Constraints for table `nozzles`
--
ALTER TABLE `nozzles`
  ADD CONSTRAINT `nozzles_api_key_id_foreign` FOREIGN KEY (`api_key_id`) REFERENCES `api_keys` (`id`),
  ADD CONSTRAINT `nozzles_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`),
  ADD CONSTRAINT `nozzles_machine_id_foreign` FOREIGN KEY (`machine_id`) REFERENCES `machines` (`id`);

--
-- Constraints for table `parties`
--
ALTER TABLE `parties`
  ADD CONSTRAINT `parties_api_key_id_foreign` FOREIGN KEY (`api_key_id`) REFERENCES `api_keys` (`id`),
  ADD CONSTRAINT `parties_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `purchases`
--
ALTER TABLE `purchases`
  ADD CONSTRAINT `purchases_api_key_id_foreign` FOREIGN KEY (`api_key_id`) REFERENCES `api_keys` (`id`),
  ADD CONSTRAINT `purchases_party_id_foreign` FOREIGN KEY (`party_id`) REFERENCES `parties` (`id`),
  ADD CONSTRAINT `purchases_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `purchase_items`
--
ALTER TABLE `purchase_items`
  ADD CONSTRAINT `purchase_items_api_key_id_foreign` FOREIGN KEY (`api_key_id`) REFERENCES `api_keys` (`id`),
  ADD CONSTRAINT `purchase_items_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`),
  ADD CONSTRAINT `purchase_items_purchase_id_foreign` FOREIGN KEY (`purchase_id`) REFERENCES `purchases` (`id`),
  ADD CONSTRAINT `purchase_items_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `purposes`
--
ALTER TABLE `purposes`
  ADD CONSTRAINT `purposes_api_key_id_foreign` FOREIGN KEY (`api_key_id`) REFERENCES `api_keys` (`id`),
  ADD CONSTRAINT `purposes_purpose_id_foreign` FOREIGN KEY (`purpose_id`) REFERENCES `purposes` (`id`),
  ADD CONSTRAINT `purposes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sales`
--
ALTER TABLE `sales`
  ADD CONSTRAINT `sales_api_key_id_foreign` FOREIGN KEY (`api_key_id`) REFERENCES `api_keys` (`id`),
  ADD CONSTRAINT `sales_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`),
  ADD CONSTRAINT `sales_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `sale_items`
--
ALTER TABLE `sale_items`
  ADD CONSTRAINT `sale_items_api_key_id_foreign` FOREIGN KEY (`api_key_id`) REFERENCES `api_keys` (`id`),
  ADD CONSTRAINT `sale_items_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`),
  ADD CONSTRAINT `sale_items_sale_id_foreign` FOREIGN KEY (`sale_id`) REFERENCES `sales` (`id`),
  ADD CONSTRAINT `sale_items_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `shifts`
--
ALTER TABLE `shifts`
  ADD CONSTRAINT `shifts_api_key_id_foreign` FOREIGN KEY (`api_key_id`) REFERENCES `api_keys` (`id`);

--
-- Constraints for table `tanks`
--
ALTER TABLE `tanks`
  ADD CONSTRAINT `tanks_api_key_id_foreign` FOREIGN KEY (`api_key_id`) REFERENCES `api_keys` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_api_key_id_foreign` FOREIGN KEY (`api_key_id`) REFERENCES `api_keys` (`id`),
  ADD CONSTRAINT `users_shift_id_foreign` FOREIGN KEY (`shift_id`) REFERENCES `shifts` (`id`);

--
-- Constraints for table `withdraws`
--
ALTER TABLE `withdraws`
  ADD CONSTRAINT `withdraws_account_id_foreign` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`),
  ADD CONSTRAINT `withdraws_api_key_id_foreign` FOREIGN KEY (`api_key_id`) REFERENCES `api_keys` (`id`),
  ADD CONSTRAINT `withdraws_party_id_foreign` FOREIGN KEY (`party_id`) REFERENCES `parties` (`id`),
  ADD CONSTRAINT `withdraws_purchase_id_foreign` FOREIGN KEY (`purchase_id`) REFERENCES `purchases` (`id`),
  ADD CONSTRAINT `withdraws_purpose_id_foreign` FOREIGN KEY (`purpose_id`) REFERENCES `purposes` (`id`),
  ADD CONSTRAINT `withdraws_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
