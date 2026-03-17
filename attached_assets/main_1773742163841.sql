-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 15, 2026 at 07:02 PM
-- Server version: 9.3.0
-- PHP Version: 8.2.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `main`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_logs`
--

CREATE TABLE `activity_logs` (
  `id` int UNSIGNED NOT NULL,
  `uid` int UNSIGNED NOT NULL,
  `ip` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `activity` text COLLATE utf8mb4_unicode_ci,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `activity_logs`
--

INSERT INTO `activity_logs` (`id`, `uid`, `ip`, `activity`, `created_at`) VALUES
(80, 372, '37.111.232.6', 'Signin', '2025-07-01 17:34:22'),
(81, 372, '37.111.232.6', 'Signin', '2025-07-01 22:04:59'),
(82, 372, '37.111.232.204', 'Signin', '2025-07-02 18:53:07'),
(83, 372, '37.111.232.161', 'Signin', '2025-07-02 23:28:14'),
(84, 372, '37.111.232.171', 'Signin', '2025-07-05 16:00:56'),
(85, 372, '37.111.232.171', 'Signin', '2025-07-05 16:02:43'),
(86, 372, '160.187.109.68', 'Signin', '2025-07-05 16:10:53'),
(87, 372, '160.187.109.68', 'Signin', '2025-07-05 16:19:07'),
(88, 372, '37.111.232.171', 'Signin', '2025-07-05 16:31:15'),
(89, 372, '37.111.232.35', 'Signin', '2025-07-07 16:54:15'),
(90, 372, '37.111.232.96', 'Signin', '2025-07-08 12:16:35'),
(91, 372, '182.48.70.86', 'Signin', '2025-07-08 12:51:13'),
(92, 372, '37.111.232.93', 'Signin', '2025-07-08 23:17:23'),
(93, 1, '::1', 'Signin', '2026-03-01 12:38:17'),
(94, 1, '::1', 'Signin', '2026-03-01 12:48:45');

-- --------------------------------------------------------

--
-- Table structure for table `addons`
--

CREATE TABLE `addons` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `unique_identifier` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `version` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` decimal(10,3) NOT NULL DEFAULT '0.000',
  `status` int NOT NULL DEFAULT '1',
  `image` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `admin_activity_logs`
--

CREATE TABLE `admin_activity_logs` (
  `id` int UNSIGNED NOT NULL,
  `uid` int UNSIGNED NOT NULL,
  `ip` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `activity` text COLLATE utf8mb4_unicode_ci,
  `created_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admin_activity_logs`
--

INSERT INTO `admin_activity_logs` (`id`, `uid`, `ip`, `activity`, `created_at`, `deleted_at`) VALUES
(99, 2, '103.150.254.102', 'Login', '2025-06-30 05:57:05', NULL),
(100, 2, '37.111.232.8', 'Logout', '2025-06-30 06:31:37', NULL),
(101, 1, '37.111.232.8', 'Login', '2025-06-30 06:32:03', NULL),
(102, 1, '103.150.254.102', 'User Status changed', '2025-06-30 07:22:34', NULL),
(103, 1, '103.150.254.102', 'User deleted', '2025-06-30 07:22:40', NULL),
(104, 1, '103.150.254.102', 'User deleted', '2025-06-30 07:22:43', NULL),
(105, 1, '37.111.232.6', 'Login', '2025-07-01 17:10:10', NULL),
(106, 1, '37.111.232.6', 'Login', '2025-07-01 17:33:42', NULL),
(107, 1, '37.111.232.6', 'User Status changed', '2025-07-01 17:34:02', NULL),
(108, 1, '37.111.217.50', 'Login', '2025-07-03 12:44:02', NULL),
(109, 1, '37.111.232.195', 'Login', '2025-07-04 13:47:06', NULL),
(110, 1, '37.111.232.171', 'Login', '2025-07-05 16:03:14', NULL),
(111, 1, '37.111.232.93', 'Login', '2025-07-08 23:21:33', NULL),
(112, 1, '::1', 'Login', '2026-03-01 19:24:06', NULL),
(113, 1, '::1', 'Login', '2026-03-07 02:46:53', NULL),
(114, 1, '::1', 'Login', '2026-03-12 23:35:38', NULL),
(115, 1, '::1', 'Login', '2026-03-14 02:47:19', NULL),
(116, 1, '::1', 'Login', '2026-03-14 22:52:53', NULL),
(117, 1, '::1', 'Login', '2026-03-15 02:43:46', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `affiliates`
--

CREATE TABLE `affiliates` (
  `id` int UNSIGNED NOT NULL,
  `uid` int UNSIGNED NOT NULL,
  `ref_id` int UNSIGNED NOT NULL,
  `amount` decimal(10,3) NOT NULL DEFAULT '0.000',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bank_transaction_logs`
--

CREATE TABLE `bank_transaction_logs` (
  `id` int UNSIGNED NOT NULL,
  `ids` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `uid` int UNSIGNED NOT NULL,
  `brand_id` int DEFAULT NULL,
  `files` text COLLATE utf8mb4_unicode_ci,
  `type` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0=pending,1=initiated,2=success,3=cancel',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `blogs`
--

CREATE TABLE `blogs` (
  `id` int UNSIGNED NOT NULL,
  `ids` text COLLATE utf8mb4_unicode_ci,
  `thumbnail` text COLLATE utf8mb4_unicode_ci,
  `uri` text COLLATE utf8mb4_unicode_ci,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `status` int NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` int UNSIGNED NOT NULL,
  `uid` int UNSIGNED NOT NULL,
  `domain` text COLLATE utf8mb4_unicode_ci,
  `ip` text COLLATE utf8mb4_unicode_ci,
  `brand_name` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `brand_key` text COLLATE utf8mb4_unicode_ci,
  `brand_logo` text COLLATE utf8mb4_unicode_ci,
  `meta` text COLLATE utf8mb4_unicode_ci,
  `fees` decimal(10,3) NOT NULL DEFAULT '0.000',
  `fees_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0=flat,1=percent',
  `currency` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0=inactive,1=active',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`id`, `uid`, `domain`, `ip`, `brand_name`, `brand_key`, `brand_logo`, `meta`, `fees`, `fees_type`, `currency`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(8, 1, 'demopay.xyz', '103.159.37.122', 'BD Better Pay', '8QFIJJNzDGGw1qmhdCJcK5xcvuh8PwRXviUfDlLatVhgkjXlZv', 'public/uploads/user/356a192b7913b04c54574d18c28d46e6395428ab/1734967288_00c5211fea2e14b14555.jpg', '{\"mobile_number\":\"01711991935\",\"whatsapp_number\":\"01711991935\",\"support_mail\":\"tuktakpay@gmail.com\"}', 0.000, 0, NULL, 1, '2024-12-07 11:20:51', '2025-03-11 00:04:26', '2026-03-07 02:54:41'),
(22, 372, 'demo.co.', '37.111.232.6', 'Demo', 'ttcKL8eq9V1B5R10xbjXDUU4u9qYFS0pkVP6na1M7avrVCvcCQ', 'public/uploads/user/6d93f2a0e5f0fe2cc3a6e9e3ade964b43b07f897/1751385968_1d66a6e43bb8eea7b3c8.jpg', '{\"mobile_number\":\"01444444444\",\"whatsapp_number\":\"8801444444444\",\"support_mail\":\"support@demo.com\"}', 2.000, 1, NULL, 1, '2025-07-01 22:06:11', '2025-07-05 16:22:42', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `coupons`
--

CREATE TABLE `coupons` (
  `id` int UNSIGNED NOT NULL,
  `code` varchar(191) NOT NULL,
  `type` tinyint NOT NULL,
  `price` double NOT NULL,
  `times` varchar(191) DEFAULT NULL,
  `used` int UNSIGNED NOT NULL DEFAULT '0',
  `param` text NOT NULL,
  `description` text,
  `status` tinyint NOT NULL DEFAULT '1',
  `start_date` date NOT NULL,
  `end_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `devices`
--

CREATE TABLE `devices` (
  `id` int UNSIGNED NOT NULL,
  `uid` int UNSIGNED NOT NULL,
  `user_email` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `device_name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `device_key` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `device_ip` text COLLATE utf8mb4_unicode_ci,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `devices`
--

INSERT INTO `devices` (`id`, `uid`, `user_email`, `device_name`, `device_key`, `device_ip`, `created_at`, `updated_at`, `deleted_at`) VALUES
(14, 1, 'admin@gmail.com', 'Relme8', 'fVSARTobNKvglddV9QhKlPFTsFcLUD884mmh1wjg', NULL, '2025-03-11 20:15:22', NULL, NULL),
(17, 372, 'demo@gmail.com', 'phone', 'NVIAnnTz6ClJsMusy3G2ngVMpHQJnLEIw7ss9VsE', NULL, '2025-07-05 16:23:19', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `faqs`
--

CREATE TABLE `faqs` (
  `id` int UNSIGNED NOT NULL,
  `question` text,
  `answer` longtext,
  `sort` int DEFAULT NULL,
  `status` int NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `faqs`
--

INSERT INTO `faqs` (`id`, `question`, `answer`, `sort`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'What is Demo Pay', 'Demo Pay: Transforming Transactions through Technology Demo Pay is a powerful yet easy to utilize digital solution created to streamline business exchanges. Leveraging individual accounts as gateways, it guarantees adaptability, protection, and simplicity of use. Here are the ways Demo Pay can change your operations: Effortless Customer Settlements: With Demo Pay, enterprises can effortlessly approve installments specifically through their sites, improving client benefit. Its configurable settings support diverse payment options including recurring payments and subscriptions. Programmatic Integration for Productivity: Incorporate Demo Pay\\\\\\\\\\\\\\\'s strong API into your framework for smooth exchange administration. Its flexible design interfaces seamlessly with a wide range of platforms to automate workflows and reconcile funds with minimal human intervention. Security You Can Depend On: Each exchange is encrypted and checked to give a sheltered condition, guaranteeing client trust and information honesty. Multi-factor authentication and automatic fraud detection further fortify the protection of sensitive consumer data. For Organizations of All Sizes: Whether you\\\\\\\\\\\\\\\'re a small new company or a large association, Demo Pay changes as indicated by your needs, empowering development and making monetary cycles intuitive. Begin your excursion with Demo Pay and redesign how your business deals with installments.', 1, 1, '2025-06-30 06:45:56', '2025-06-30 06:45:56', '2026-03-14 23:04:04'),
(2, 'Is Demo Pay a Safe Option for Businesses ?', 'Demo Pay: The Safe and Reliable Payment Option! Demo Pay ensures every transaction is secured and reliable &mdash; making it a great choice for businesses needing the best financial protection. Here\\\\\\\\\\\\\\\'s why you can trust it : Advanced Encryption Protocols Demo Pay employs military-grade encryption to protect sensitive transactional data, maintaining the privacy of your customers. Fraud Detection Systems Scalable with integrated fraud detection, Demo Pay identifies and blocks suspicious activities for the peace of mind of the business. International standard compliance Demo Pay complies with international security frameworks, including PCI DSS, to ensure its compliance with industry standards for secure payment processing. Integration without compromise with strong security Demo Pay is user-friendly and easy to integrate, yet it still never sacrifices safety, helping businesses of all sizes. Demo Pay caters the necessities of startups and enterprise businesses with an emphasis on security, efficiency, and reliability.', 2, 1, '2025-06-30 06:47:19', '2025-06-30 06:47:19', '2026-03-14 23:04:10');

-- --------------------------------------------------------

--
-- Table structure for table `file_managers`
--

CREATE TABLE `file_managers` (
  `id` int NOT NULL,
  `uid` int DEFAULT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_url` varchar(255) NOT NULL,
  `file_type` varchar(100) NOT NULL,
  `file_size` int NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `file_managers`
--

INSERT INTO `file_managers` (`id`, `uid`, `file_name`, `file_url`, `file_type`, `file_size`, `created_at`) VALUES
(2, 88, '1728398628_942e8c07e19cebba1673.jpg', 'public/uploads/user/b37f6ddcefad7e8657837d3177f9ef2462f98acf/1728398628_942e8c07e19cebba1673.jpg', 'image/jpeg', 103221, '2024-10-08 20:43:48'),
(3, 88, '1728398658_5e037cadedaa9ddc5395.jpg', 'public/uploads/user/b37f6ddcefad7e8657837d3177f9ef2462f98acf/1728398658_5e037cadedaa9ddc5395.jpg', 'image/jpeg', 10263, '2024-10-08 20:44:18'),
(4, 0, '1728399479_b7d73f35726d9e4310b5.png', 'public/uploads/admin/356a192b7913b04c54574d18c28d46e6395428ab/1728399479_b7d73f35726d9e4310b5.png', 'image/png', 80596, '2024-10-08 20:57:59'),
(5, 0, '1728399488_b64c3407b15836b97fd5.png', 'public/uploads/admin/356a192b7913b04c54574d18c28d46e6395428ab/1728399488_b64c3407b15836b97fd5.png', 'image/png', 102502, '2024-10-08 20:58:08'),
(6, 0, '1728399559_9cd8914214b745521876.png', 'public/uploads/admin/356a192b7913b04c54574d18c28d46e6395428ab/1728399559_9cd8914214b745521876.png', 'image/png', 80596, '2024-10-08 20:59:19'),
(7, 0, '1728399564_a0c7c02fd5a00d7ad426.png', 'public/uploads/admin/356a192b7913b04c54574d18c28d46e6395428ab/1728399564_a0c7c02fd5a00d7ad426.png', 'image/png', 80596, '2024-10-08 20:59:24'),
(8, 6, '1728400816_efcb28e5a8242c8caa78.png', 'public/uploads/user/c1dfd96eea8cc2b62785275bca38ac261256e278/1728400816_efcb28e5a8242c8caa78.png', 'image/png', 80596, '2024-10-08 21:20:16'),
(9, 1, '1728403939_dfba68933fe40076ad85.jpg', 'public/uploads/user/356a192b7913b04c54574d18c28d46e6395428ab/1728403939_dfba68933fe40076ad85.jpg', 'image/jpeg', 14158, '2024-10-08 22:12:19'),
(10, 0, '1728409631_b500be3dd669fbf6579e.png', 'public/uploads/admin/356a192b7913b04c54574d18c28d46e6395428ab/1728409631_b500be3dd669fbf6579e.png', 'image/png', 80596, '2024-10-08 23:47:11'),
(11, 0, '1728410037_9239d6c1bae86f22c973.png', 'public/uploads/admin/356a192b7913b04c54574d18c28d46e6395428ab/1728410037_9239d6c1bae86f22c973.png', 'image/png', 80596, '2024-10-08 23:53:57'),
(12, 6, '1728459782_00c5b6202549db3b7ba4.jpg', 'public/uploads/user/c1dfd96eea8cc2b62785275bca38ac261256e278/1728459782_00c5b6202549db3b7ba4.jpg', 'image/jpeg', 39655, '2024-10-09 13:43:02'),
(13, 179, '1728478783_ac6316caf55f369ce3ca.jpeg', 'public/uploads/user/9e44d2771c052d44058245eda6cb334689ca78cc/1728478783_ac6316caf55f369ce3ca.jpeg', 'image/jpeg', 7603, '2024-10-09 18:59:43'),
(14, 185, '1728496161_d0d07ad08a7d6af8a376.jpg', 'public/uploads/user/cfa2ed2aac6d61f44ca9cba73e1e8946b7cd7d22/1728496161_d0d07ad08a7d6af8a376.jpg', 'image/jpeg', 46179, '2024-10-09 23:49:21'),
(15, 185, '1728496198_3630522c5e47f2c5d0ae.png', 'public/uploads/user/cfa2ed2aac6d61f44ca9cba73e1e8946b7cd7d22/1728496198_3630522c5e47f2c5d0ae.png', 'image/png', 12578, '2024-10-09 23:49:58'),
(16, 185, '1728496406_66492203136fe6c36375.jpg', 'public/uploads/user/cfa2ed2aac6d61f44ca9cba73e1e8946b7cd7d22/1728496406_66492203136fe6c36375.jpg', 'image/jpeg', 17945, '2024-10-09 23:53:26'),
(17, 88, '1728625532_c736bb50a36ff775b6b3.jpg', 'public/uploads/user/b37f6ddcefad7e8657837d3177f9ef2462f98acf/1728625532_c736bb50a36ff775b6b3.jpg', 'image/jpeg', 9848, '2024-10-11 11:45:32'),
(18, 294, '1728912198_9b860d2f3c72bd2ba023.png', 'public/uploads/user/3a085d1bc5fa41313c4e0910e7341af761b0f7db/1728912198_9b860d2f3c72bd2ba023.png', 'image/png', 14217, '2024-10-14 19:23:18'),
(19, 294, '1728912321_ca1ae7710241735b3281.png', 'public/uploads/user/3a085d1bc5fa41313c4e0910e7341af761b0f7db/1728912321_ca1ae7710241735b3281.png', 'image/png', 14217, '2024-10-14 19:25:21'),
(20, 88, '1729093736_5fc766c9b99212298c52.png', 'public/uploads/user/b37f6ddcefad7e8657837d3177f9ef2462f98acf/1729093736_5fc766c9b99212298c52.png', 'image/png', 14217, '2024-10-16 21:48:56'),
(21, 88, '1729093831_fa933efbff64b7e36225.png', 'public/uploads/user/b37f6ddcefad7e8657837d3177f9ef2462f98acf/1729093831_fa933efbff64b7e36225.png', 'image/png', 14217, '2024-10-16 21:50:31'),
(22, 295, '1729094239_8e2d65a6eb177299cf19.png', 'public/uploads/user/a02b857f2eff73e8e188f35529dd91f8144b23b9/1729094239_8e2d65a6eb177299cf19.png', 'image/png', 353311, '2024-10-16 21:57:19'),
(23, 295, '1729094469_32a8993e4621be4b1de4.png', 'public/uploads/user/a02b857f2eff73e8e188f35529dd91f8144b23b9/1729094469_32a8993e4621be4b1de4.png', 'image/png', 14217, '2024-10-16 22:01:09'),
(24, 298, '1729386388_9d7da5a470559431441d.jpg', 'public/uploads/user/eb65e208b715d3b42fc535aebcd8d3e7fb5f2c94/1729386388_9d7da5a470559431441d.jpg', 'image/jpeg', 125565, '2024-10-20 07:06:28'),
(25, 300, '1729618566_ebbbf94a1463ae0457c8.png', 'public/uploads/user/e26973e6ee8ab9cd8cb3f207d1b90f00d2669eff/1729618566_ebbbf94a1463ae0457c8.png', 'image/png', 405464, '2024-10-22 23:36:06'),
(26, 0, '1730479999_b87e7dfe94351beeb59e.jpg', 'public/uploads/admin/356a192b7913b04c54574d18c28d46e6395428ab/1730479999_b87e7dfe94351beeb59e.jpg', 'image/jpeg', 14158, '2024-11-01 22:53:19'),
(27, 0, '1730480029_aa524a469f5d2c7b0c86.jpg', 'public/uploads/admin/356a192b7913b04c54574d18c28d46e6395428ab/1730480029_aa524a469f5d2c7b0c86.jpg', 'image/jpeg', 14158, '2024-11-01 22:53:49'),
(28, 1, '1730595824_0af2130ffb3c7e904904.png', 'public/uploads/user/356a192b7913b04c54574d18c28d46e6395428ab/1730595824_0af2130ffb3c7e904904.png', 'image/png', 80596, '2024-11-03 07:03:44'),
(29, 0, '1732982962_ab1f3d84fa63112c3ca6.png', 'public/uploads/admin/356a192b7913b04c54574d18c28d46e6395428ab/1732982962_ab1f3d84fa63112c3ca6.png', 'image/png', 5774, '2024-11-30 22:09:22'),
(30, 0, '1732982998_9ce2a923f99cd8fc2195.png', 'public/uploads/admin/356a192b7913b04c54574d18c28d46e6395428ab/1732982998_9ce2a923f99cd8fc2195.png', 'image/png', 5774, '2024-11-30 22:09:58'),
(31, 0, '1733031584_41825073b1b771dca6c4.png', 'public/uploads/admin/356a192b7913b04c54574d18c28d46e6395428ab/1733031584_41825073b1b771dca6c4.png', 'image/png', 9299, '2024-12-01 11:39:44'),
(32, 0, '1733031830_6e41fa51d1d9b0bcd847.png', 'public/uploads/admin/356a192b7913b04c54574d18c28d46e6395428ab/1733031830_6e41fa51d1d9b0bcd847.png', 'image/png', 76912, '2024-12-01 11:43:50'),
(33, 0, '1733031856_50b153c4d9ae66b5a156.png', 'public/uploads/admin/356a192b7913b04c54574d18c28d46e6395428ab/1733031856_50b153c4d9ae66b5a156.png', 'image/png', 76912, '2024-12-01 11:44:16'),
(34, 0, '1733031863_d0f67e662a5079f004eb.png', 'public/uploads/admin/356a192b7913b04c54574d18c28d46e6395428ab/1733031863_d0f67e662a5079f004eb.png', 'image/png', 9299, '2024-12-01 11:44:23'),
(35, 0, '1733114332_81e7abc3de6e2f6ae2b0.png', 'public/uploads/admin/356a192b7913b04c54574d18c28d46e6395428ab/1733114332_81e7abc3de6e2f6ae2b0.png', 'image/png', 34218, '2024-12-02 10:38:52'),
(36, 1, '1733208458_d74f2aea85f7ca40742d.png', 'public/uploads/user/356a192b7913b04c54574d18c28d46e6395428ab/1733208458_d74f2aea85f7ca40742d.png', 'image/png', 34218, '2024-12-03 12:47:38'),
(37, 305, '1733548847_ac6a1016655add94c3fa.png', 'public/uploads/user/9a3d6127374af09c22015bf3ede3ac00a36e3ec6/1733548847_ac6a1016655add94c3fa.png', 'image/png', 76912, '2024-12-07 11:20:47'),
(38, 1, '1734176170_0f063d499294a3f1e5ac.png', 'public/uploads/user/356a192b7913b04c54574d18c28d46e6395428ab/1734176170_0f063d499294a3f1e5ac.png', 'image/png', 4190, '2024-12-14 17:36:10'),
(39, 1, '1734176397_89fe00dfab5b71abc250.png', 'public/uploads/user/356a192b7913b04c54574d18c28d46e6395428ab/1734176397_89fe00dfab5b71abc250.png', 'image/png', 6974, '2024-12-14 17:39:57'),
(40, 0, '1734517490_3e85a09031251cde25cc.jpg', 'public/uploads/admin/356a192b7913b04c54574d18c28d46e6395428ab/1734517490_3e85a09031251cde25cc.jpg', 'image/jpeg', 11813, '2024-12-18 16:24:50'),
(41, 0, '1734517520_ce360fd376246a408ee2.jpg', 'public/uploads/admin/356a192b7913b04c54574d18c28d46e6395428ab/1734517520_ce360fd376246a408ee2.jpg', 'image/jpeg', 11813, '2024-12-18 16:25:20'),
(42, 0, '1734518091_54e0507c3f49114cec5c.jpg', 'public/uploads/admin/356a192b7913b04c54574d18c28d46e6395428ab/1734518091_54e0507c3f49114cec5c.jpg', 'image/jpeg', 22993, '2024-12-18 16:34:51'),
(43, 0, '1734518168_ace641b4ec9c9209f648.png', 'public/uploads/admin/356a192b7913b04c54574d18c28d46e6395428ab/1734518168_ace641b4ec9c9209f648.png', 'image/png', 47608, '2024-12-18 16:36:08'),
(44, 0, '1734518179_cd2492593a529e11a746.jpg', 'public/uploads/admin/356a192b7913b04c54574d18c28d46e6395428ab/1734518179_cd2492593a529e11a746.jpg', 'image/jpeg', 17921, '2024-12-18 16:36:19'),
(45, 0, '1734519128_69d5a090b9b3df244e02.jpg', 'public/uploads/admin/356a192b7913b04c54574d18c28d46e6395428ab/1734519128_69d5a090b9b3df244e02.jpg', 'image/jpeg', 17921, '2024-12-18 16:52:08'),
(46, 0, '1734519891_d9639631de1634bf18bc.png', 'public/uploads/admin/356a192b7913b04c54574d18c28d46e6395428ab/1734519891_d9639631de1634bf18bc.png', 'image/png', 47608, '2024-12-18 17:04:51'),
(47, 340, '1734542607_1ab17fcc7244e31abc31.jpg', 'public/uploads/user/3e6bf6c89ba8a8b8b189f85975b0fab42bdc6d4a/1734542607_1ab17fcc7244e31abc31.jpg', 'image/jpeg', 69631, '2024-12-18 23:23:27'),
(48, 340, '1734542972_2d014fde6f86d13e69b0.png', 'public/uploads/user/3e6bf6c89ba8a8b8b189f85975b0fab42bdc6d4a/1734542972_2d014fde6f86d13e69b0.png', 'image/png', 315707, '2024-12-18 23:29:33'),
(49, 0, '1734614289_262d9fd2c01e2ebc4719.jpg', 'public/uploads/admin/356a192b7913b04c54574d18c28d46e6395428ab/1734614289_262d9fd2c01e2ebc4719.jpg', 'image/jpeg', 17433, '2024-12-19 19:18:09'),
(50, 0, '1734614395_c0c3762ef72a251de9e6.png', 'public/uploads/admin/356a192b7913b04c54574d18c28d46e6395428ab/1734614395_c0c3762ef72a251de9e6.png', 'image/png', 53445, '2024-12-19 19:19:55'),
(51, 340, '1734937992_329284fb1bf938ea2987.png', 'public/uploads/user/3e6bf6c89ba8a8b8b189f85975b0fab42bdc6d4a/1734937992_329284fb1bf938ea2987.png', 'image/png', 18841, '2024-12-23 13:13:12'),
(52, 340, '1734938769_a6de23117d04d5c4f0ec.png', 'public/uploads/user/3e6bf6c89ba8a8b8b189f85975b0fab42bdc6d4a/1734938769_a6de23117d04d5c4f0ec.png', 'image/png', 18841, '2024-12-23 13:26:09'),
(53, 0, '1734947867_4e920b1c6db0a27cf27a.png', 'public/uploads/admin/356a192b7913b04c54574d18c28d46e6395428ab/1734947867_4e920b1c6db0a27cf27a.png', 'image/png', 121805, '2024-12-23 15:57:47'),
(54, 1, '1734967288_00c5211fea2e14b14555.jpg', 'public/uploads/user/356a192b7913b04c54574d18c28d46e6395428ab/1734967288_00c5211fea2e14b14555.jpg', 'image/jpeg', 11375, '2024-12-23 21:21:28'),
(55, 1, '1734967698_8eb8fbaa63941124dc8e.jpg', 'public/uploads/user/356a192b7913b04c54574d18c28d46e6395428ab/1734967698_8eb8fbaa63941124dc8e.jpg', 'image/jpeg', 55107, '2024-12-23 21:28:18'),
(56, 341, '1735011486_4801ce974c04db55cb75.jpg', 'public/uploads/user/8da4dabfaeb4a44681c9777c85db39140e3e12e6/1735011486_4801ce974c04db55cb75.jpg', 'image/jpeg', 15878, '2024-12-24 09:38:06'),
(57, 343, '1735013786_0cc23734a29f647625ba.jpg', 'public/uploads/user/25a5e3012854728e0c6ab97fdcbb65c3a00c0965/1735013786_0cc23734a29f647625ba.jpg', 'image/jpeg', 68916, '2024-12-24 10:16:26'),
(58, 343, '1735034795_4e4dddbf25a737e06538.jpg', 'public/uploads/user/25a5e3012854728e0c6ab97fdcbb65c3a00c0965/1735034795_4e4dddbf25a737e06538.jpg', 'image/jpeg', 55107, '2024-12-24 16:06:35'),
(59, 344, '1735091568_9970f2d6c58fe5ba9c4e.jpg', 'public/uploads/user/640bacfb48aefac1f91028c01603e5c78d4f63ca/1735091568_9970f2d6c58fe5ba9c4e.jpg', 'image/jpeg', 64520, '2024-12-25 07:52:48'),
(60, 345, '1735100654_556d77316b63cdccf145.jpg', 'public/uploads/user/35139ef894b28b73bea022755166a23933c7d9cb/1735100654_556d77316b63cdccf145.jpg', 'image/jpeg', 55107, '2024-12-25 10:24:14'),
(61, 344, '1735120914_d1a3a6585c0af53167e9.jpg', 'public/uploads/user/640bacfb48aefac1f91028c01603e5c78d4f63ca/1735120914_d1a3a6585c0af53167e9.jpg', 'image/jpeg', 64520, '2024-12-25 16:01:54'),
(62, 344, '1735121112_56db2aed8e2e08edfe31.jpg', 'public/uploads/user/640bacfb48aefac1f91028c01603e5c78d4f63ca/1735121112_56db2aed8e2e08edfe31.jpg', 'image/jpeg', 64520, '2024-12-25 16:05:12'),
(63, 309, '1735189800_9eb8731cad43175badc8.jpg', 'public/uploads/user/ed2efc1c05342a60c2198a5e96773a237008956b/1735189800_9eb8731cad43175badc8.jpg', 'image/jpeg', 149719, '2024-12-26 11:10:00'),
(64, 351, '1735458685_c0889c215fe1b81901a9.png', 'public/uploads/user/0026476a20bfbd08714155bb66f0b4feb2d25c1c/1735458685_c0889c215fe1b81901a9.png', 'image/png', 53269, '2024-12-29 13:51:25'),
(65, 352, '1735568726_c731b945f81cc65167a0.png', 'public/uploads/user/efbc0848b836a9de4b0c18c93ec052d87647fb06/1735568726_c731b945f81cc65167a0.png', 'image/png', 19341, '2024-12-30 20:25:26'),
(66, 309, '1735835221_52dd0ee3e1252e277692.jpg', 'public/uploads/user/ed2efc1c05342a60c2198a5e96773a237008956b/1735835221_52dd0ee3e1252e277692.jpg', 'image/jpeg', 68306, '2025-01-02 22:27:01'),
(67, 358, '1741702704_8bb04122ef73501a7879.png', 'public/uploads/user/abf749051d8b000946c71a2e216e55eeb49cf414/1741702704_8bb04122ef73501a7879.png', 'image/png', 390361, '2025-03-11 20:18:25'),
(68, 1, '1746806013_f5bd82cfd5cec3190852.png', 'public/uploads/user/356a192b7913b04c54574d18c28d46e6395428ab/1746806013_f5bd82cfd5cec3190852.png', 'image/png', 8337, '2025-05-09 21:53:33'),
(69, 0, '1746806453_631eb05aa9d55be8506e.png', 'public/uploads/admin/356a192b7913b04c54574d18c28d46e6395428ab/1746806453_631eb05aa9d55be8506e.png', 'image/png', 8337, '2025-05-09 22:00:53'),
(70, 0, '1746806477_ff79c3408aab1c2f22f0.png', 'public/uploads/admin/356a192b7913b04c54574d18c28d46e6395428ab/1746806477_ff79c3408aab1c2f22f0.png', 'image/png', 8337, '2025-05-09 22:01:17'),
(71, 364, '1750688991_115cf69d62c56087cb75.jpg', 'public/uploads/user/56e43ae4ca9369ef504ed49d4a92f42eddff81c5/1750688991_115cf69d62c56087cb75.jpg', 'image/jpeg', 318809, '2025-06-23 20:29:51'),
(72, 364, '1750699011_dcb3da826b3d684999dd.jpg', 'public/uploads/user/56e43ae4ca9369ef504ed49d4a92f42eddff81c5/1750699011_dcb3da826b3d684999dd.jpg', 'image/jpeg', 46475, '2025-06-23 23:16:51'),
(73, 0, '1751242004_2cb2a5bfadc8793f1ccd.png', 'public/uploads/admin/da4b9237bacccdf19c0760cab7aec4a8359010b0/1751242004_2cb2a5bfadc8793f1ccd.png', 'image/png', 9099, '2025-06-30 06:06:44'),
(74, 371, '1751246697_5cefcdef23eab13eb215.png', 'public/uploads/user/3554dce55f341edd431fc711f6816673f081452d/1751246697_5cefcdef23eab13eb215.png', 'image/png', 9099, '2025-06-30 07:24:57'),
(75, 0, '1751369973_57d5b943f3e17f94a03f.jpg', 'public/uploads/admin/356a192b7913b04c54574d18c28d46e6395428ab/1751369973_57d5b943f3e17f94a03f.jpg', 'image/jpeg', 177301, '2025-07-01 17:39:33'),
(76, 372, '1751385968_1d66a6e43bb8eea7b3c8.jpg', 'public/uploads/user/6d93f2a0e5f0fe2cc3a6e9e3ade964b43b07f897/1751385968_1d66a6e43bb8eea7b3c8.jpg', 'image/jpeg', 177301, '2025-07-01 22:06:08');

-- --------------------------------------------------------

--
-- Table structure for table `invoice`
--

CREATE TABLE `invoice` (
  `id` int UNSIGNED NOT NULL,
  `ids` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `uid` int UNSIGNED NOT NULL,
  `customer_name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_number` text COLLATE utf8mb4_unicode_ci,
  `customer_amount` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_email` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_description` text COLLATE utf8mb4_unicode_ci,
  `status` int NOT NULL,
  `pay_status` int NOT NULL,
  `brand_id` text COLLATE utf8mb4_unicode_ci,
  `transaction_id` text COLLATE utf8mb4_unicode_ci,
  `extras` text COLLATE utf8mb4_unicode_ci,
  `created_at` text COLLATE utf8mb4_unicode_ci,
  `deleted_at` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `invoice`
--

INSERT INTO `invoice` (`id`, `ids`, `uid`, `customer_name`, `customer_number`, `customer_amount`, `customer_email`, `customer_address`, `customer_description`, `status`, `pay_status`, `brand_id`, `transaction_id`, `extras`, `created_at`, `deleted_at`) VALUES
(19, 'b85992305627636df85646b222e37e52', 372, 'Demo', '01444444444', '2000', 'demo@gmail.com', 'Demo Address', 'Demo Description', 1, 0, '22', NULL, NULL, '2025-07-01 22:12:19', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `kyc`
--

CREATE TABLE `kyc` (
  `id` int UNSIGNED NOT NULL,
  `ids` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `uid` int UNSIGNED NOT NULL,
  `params` text COLLATE utf8mb4_unicode_ci,
  `status` int NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` bigint UNSIGNED NOT NULL,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int NOT NULL,
  `batch` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
(1, '2023-12-23-055313', 'Modules\\Blocks\\Database\\Migrations\\Queue', 'default', 'Blocks', 1733164861, 1),
(2, '2023-12-23-055313', 'Modules\\Home\\Database\\Migrations\\Settings', 'default', 'Home', 1733164862, 2),
(3, '2023-12-26-040632', 'Modules\\Home\\Database\\Migrations\\FileManager', 'default', 'Home', 1733164862, 2),
(4, '2023-12-27-012628', 'Modules\\Home\\Database\\Migrations\\Payments', 'default', 'Home', 1733164862, 2),
(5, '2024-04-30-042916', 'Modules\\Home\\Database\\Migrations\\Blogs', 'default', 'Home', 1733164862, 2),
(6, '2024-05-15-153103', 'Modules\\Home\\Database\\Migrations\\Addons', 'default', 'Home', 1733164862, 2);

-- --------------------------------------------------------

--
-- Table structure for table `module_data`
--

CREATE TABLE `module_data` (
  `id` int UNSIGNED NOT NULL,
  `tmp_id` text COLLATE utf8mb4_unicode_ci,
  `uid` int UNSIGNED NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci,
  `address` text COLLATE utf8mb4_unicode_ci,
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0=pending,1=success',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int UNSIGNED NOT NULL,
  `uid` int UNSIGNED NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT '0',
  `admin_status` tinyint(1) NOT NULL DEFAULT '1',
  `is_admin_read` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `options`
--

CREATE TABLE `options` (
  `id` int NOT NULL,
  `name` text,
  `value` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `options`
--

INSERT INTO `options` (`id`, `name`, `value`) VALUES
(1, 'is_maintenance_mode', '0'),
(2, 'site_title', 'QPay | Ultimate Payment Gateway For Every Business'),
(3, 'site_description', 'QPay is your one-stop platform for seamless and secure payment automation. We specialise in streamlining payment processes for businesses and individuals, offering features like recurring billing, real-time transaction tracking, and integration with multiple payment gateways. With a focus on efficiency and user-friendliness, Auto Pay Solution ensures your payments are handled effortlessly, giving you more time to focus on growth. Experience the convenience of automated payments with our cutting-edge technology and reliable customer support.'),
(4, 'site_keywords', 'cloudman, Qpay, payment gateway in bd'),
(5, 'site_icon', 'public/uploads/admin/356a192b7913b04c54574d18c28d46e6395428ab/1751369973_57d5b943f3e17f94a03f.jpg'),
(6, 'site_name', 'QPay'),
(7, 'default_limit_per_page', '100'),
(8, 'currency_decimal', '2'),
(9, 'currency_decimal_separator', 'dot'),
(10, 'currency_thousand_separator', 'comma'),
(11, 'currency_symbol', '৳'),
(12, 'maintenance_mode_time', '2025-07-06T00:00'),
(13, 'enable_https', '1'),
(14, 'optimize', '1'),
(15, 'address', 'Dhaka, Bangladesh '),
(16, 'social_github_link', '#'),
(17, 'social_facebook_link', 'https://www.facebook.com/'),
(18, 'social_instagram_link', '#'),
(19, 'social_pinterest_link', '#'),
(20, 'social_twitter_link', '#'),
(21, 'social_tumblr_link', ''),
(22, 'social_youtube_link', '#'),
(23, 'contact_tel', '01540203662'),
(24, 'contact_email', 'qpay@cloudman.one'),
(25, 'contact_work_hour', 'Sat-Thu 09 am - 10 pm'),
(26, 'copy_right_content', 'All Right Preserved by QPay'),
(27, 'update_file', '1'),
(28, 'honeypot', ''),
(29, 'site_logo', 'public/uploads/admin/356a192b7913b04c54574d18c28d46e6395428ab/demopay.png'),
(30, 'is_clear_ticket', '0'),
(31, 'default_clear_ticket_days', '30'),
(32, 'default_pending_ticket_per_user', '0'),
(33, 'enable_notification_popup', '0'),
(34, 'notification_popup_content', ''),
(35, 'enable_panel_notification_popup', '0'),
(36, 'notification_popup_panel_content', ''),
(37, 'is_verification_new_account', '1'),
(38, 'is_welcome_email', '1'),
(39, 'is_new_user_email', '1'),
(40, 'email_welcome_email_subject', 'Welcome To Our site'),
(41, 'enable_notification', '1'),
(42, 'email_from', 'info@anihost.top'),
(43, 'email_name', 'AniPay'),
(44, 'email_protocol_type', 'smtp'),
(45, 'is_addfund_bonus', '0'),
(46, 'is_plan_bonus', '0'),
(47, 'is_signup_bonus', '0'),
(48, 'signup_bonus_amount', '0'),
(49, 'affiliate_bonus_type', '0'),
(50, 'affiliate_bonus', '0'),
(51, 'min_affiliate_amount', '0'),
(52, 'max_affiliate_time', '0'),
(53, 'currency_code', 'BDT'),
(54, 'auto_rounding_x_decimal_places', '2'),
(55, 'is_auto_currency_convert', '0'),
(56, 'new_currecry_rate', '1'),
(57, 'policy_content', ''),
(58, 'embed_head_javascript', ''),
(59, 'embed_javascript', ''),
(60, 'is_payment_notice_email', '1'),
(61, 'is_ticket_notice_email', '1'),
(62, 'is_ticket_notice_email_admin', '1'),
(63, 'is_order_notice_email', '1'),
(64, 'smtp_server', ''),
(65, 'smtp_port', '587'),
(66, 'smtp_encryption', 'tls'),
(67, 'smtp_username', ''),
(68, 'smtp_password', ''),
(69, 'limit_per_page', '10'),
(70, 'terms_content', ''),
(71, 'enable_all_user', '1'),
(72, 'enable_database_cache', '1'),
(73, 'enable_tickets', '1'),
(74, 'affiliate_level', '4'),
(75, 'verification_email_subject', '{{website_name}} - Please validate your account'),
(76, 'verification_email_content', '<p><strong>Welcome to {{website_name}}!&nbsp;</strong></p>\r\n<p>Hello <strong>{{first_name}}</strong>!</p>\r\n<p>&nbsp;Thank you for joining! We\'re glad to have you as community member, and we\'re stocked for you to start exploring our service. &nbsp;If you don\'t verify your address, you won\'t be able to create a&nbsp;User Account.</p>\r\n<p>&nbsp;&nbsp;All you need to do is activate your account&nbsp;by click this link:&nbsp;<br />&nbsp; {{activation_link}}&nbsp;</p>\r\n<p>Thanks and Best Regards!</p>'),
(77, 'email_welcome_email_content', '<p><strong>Welcome to {{website_name}}!&nbsp;</strong></p>\r\n<p>Hello <strong>{{first_name}}</strong>!</p>\r\n<p>Congratulations!&nbsp;<br />You have successfully signed up for our service - {{website_name}}&nbsp;with follow data</p>\r\n<ul>\r\n<li>Firstname: {{first_name}}</li>\r\n<li>Lastname: {{last_name}}</li>\r\n<li>Email: {{email}}</li>\r\n<li>Timezone: {{user_timezone}}</li>\r\n</ul>\r\n<p>We want to exceed your expectations, so please do not&nbsp;hesitate to reach out at any time if you have any questions or concerns. We look to working with you.</p>\r\n<p>Best Regards,</p>'),
(78, 'email_new_registration_subject', '{{website_name}} - New Registration'),
(79, 'email_new_registration_content', '<p>Hi Admin!</p>\r\n<p>Someone signed up in <strong>{{website_name}}</strong> with follow data</p>\r\n<ul>\r\n<li>Firstname {{first_name}}</li>\r\n<li>Lastname: {{last_name}}</li>\r\n<li>Email: {{email}}</li>\r\n<li>Timezone: {{user_timezone}}</li>\r\n</ul>'),
(80, 'email_password_recovery_subject', '{{website_name}} - Password Recovery'),
(81, 'email_password_recovery_content', '<p>Hi<strong> {{first_name}}!&nbsp;</strong></p>\r\n<p>Somebody (hopefully you) requested a new password for your account.&nbsp;</p>\r\n<p>No changes have been made to your account yet.&nbsp;<br />You can reset your password by click this link:&nbsp;<br />{{recovery_password_link}}</p>\r\n<p>If you did not request a password reset, no further action is required.&nbsp;</p>\r\n<p>Thanks and Best Regards!</p>'),
(82, 'admin_email_password_recovery_subject', '{{website_name}} - Password Recovery'),
(83, 'admin_email_password_recovery_content', '<p>Hi<strong> {{first_name}}!&nbsp;</strong></p>\r\n<p>Somebody (hopefully you) requested a new password for your account.&nbsp;</p>\r\n<p>No changes have been made to your account yet.&nbsp;<br />You can reset your password by click this link:&nbsp;<br />{{admin_recovery_password_link}}</p>\r\n<p>If you did not request a password reset, no further action is required.&nbsp;</p>\r\n<p>Thanks and Best Regards!</p>'),
(84, 'email_payment_notice_subject', '{{website_name}} -  Thank You! Deposit Payment Received'),
(85, 'email_payment_notice_content', '<p>Hi<strong> {{first_name}}!&nbsp;</strong></p>\r\n<p>We\'ve just received your final remittance and would like to thank you. We appreciate your diligence in adding funds to your balance in our service.</p>\r\n<p>It has been a pleasure doing business with you. We wish you the best of luck.</p>\r\n<p>Thanks and Best Regards!</p>'),
(86, 'business_name', ''),
(87, 'is_cookie_policy_page', '0'),
(88, 'cookies_policy_page', ''),
(89, 'embed_footee_javascript', ''),
(90, 'home_page', '1'),
(91, 'homepage_code', '\n<section id=\"hero\" class=\"hero d-flex align-items-center\">\n\n    <div class=\"container\">\n        <div class=\"row\">\n            <div class=\"col-lg-6 d-flex flex-column justify-content-center\">\n                <h1 data-aos=\"fade-up\">Automate Your Payments Seamlessly</h1>\n                <h2 data-aos=\"fade-up\" data-aos-delay=\"400\">Join us to experience efficient and secure payment solutions for your business</h2>\n                <div data-aos=\"fade-up\" data-aos-delay=\"600\">\n                    <div class=\"text-center text-lg-start\">\n                        <a href=\"/sign-up\" class=\"btn-get-started scrollto d-inline-flex align-items-center justify-content-center align-self-center\">\n                            <span>Get Started</span>\n                            <i class=\"bi bi-arrow-right\"></i>\n                        </a>\n                    </div>\n                </div>\n            </div>\n            <div class=\"col-lg-6 order-1 order-lg-2 hero-img\" data-aos=\"zoom-out\">\n            \n            <img src=\"<?= base_url(\'public/assets/plat\') ?>/123123-1.png\" class=\"img-fluid animated\" alt=\"\">\n          </div> \n            \n        </div>\n    </div>\n\n</section><!-- End Hero -->\n\n<main id=\"main\">\n\n<section id=\"about\" class=\"values\">\n    <div class=\"container\" data-aos=\"fade-up\">\n        <header class=\"section-header\">\n            <h2>We Offer</h2>\n            <p>Our guiding principles that empower seamless payment solutions</p>\n        </header>\n\n        <div class=\"row\">\n            <div class=\"col-lg-4\" data-aos=\"fade-up\" data-aos-delay=\"200\">\n                <div class=\"box\">\n                    <img src=\"<?= base_url(\'public/assets/plat\') ?>/tt.png\" class=\"img-fluid\" alt=\"\">\n                    <h3>Save Time</h3>\n                    <p>Simplify your payment processes and save valuable time with our integrated MFS API, ensuring fast and efficient transactions.</p>\n                </div>\n            </div>\n\n            <div class=\"col-lg-4 mt-4 mt-lg-0\" data-aos=\"fade-up\" data-aos-delay=\"400\">\n                <div class=\"box\">\n                    <img src=\"<?= base_url(\'public/assets/plat\') ?>/nh.png\" class=\"img-fluid\" alt=\"\">\n                    <h3>Seamless Integration</h3>\n                    <p>Easily connect and integrate with our system. Automate workflows, link applications, and manage data sources effortlessly.</p>\n                </div>\n            </div>\n\n            <div class=\"col-lg-4 mt-4 mt-lg-0\" data-aos=\"fade-up\" data-aos-delay=\"600\">\n                <div class=\"box\">\n                    <img src=\"<?= base_url(\'public/assets/plat\') ?>/mm.png\" class=\"img-fluid\" alt=\"\">\n                    <h3>Automate Personal Accounts</h3>\n                    <p>Streamline your payment reception with NagorikPay\'s automation. Direct payments to your personal account without manual intervention.</p>\n                </div>\n            </div>\n\n            <div class=\"col-lg-4 mt-4 mt-lg-0\" data-aos=\"fade-up\" data-aos-delay=\"800\">\n                <div class=\"box\">\n                    <img src=\"<?= base_url(\'public/assets/plat\') ?>/5644447.png\" class=\"img-fluid\" alt=\"\">\n                    <h3>Invoice Generator</h3>\n                    <p>Create and send personalized payment links via email for quick and easy payments, eliminating the need for a website or online store.</p>\n                </div>\n            </div>\n\n            <div class=\"col-lg-4 mt-4 mt-lg-0\" data-aos=\"fade-up\" data-aos-delay=\"1000\">\n                <div class=\"box\">\n                    <img src=\"<?= base_url(\'public/assets/plat\') ?>/6221918.png\" class=\"img-fluid\" alt=\"\">\n                    <h3>Billing Management</h3>\n                    <p>Simplify billing with NagorikPay\'s automated system. Monitor transactions, generate invoices, and streamline your billing process efficiently.</p>\n                </div>\n            </div>\n\n            <div class=\"col-lg-4 mt-4 mt-lg-0\" data-aos=\"fade-up\" data-aos-delay=\"1200\">\n                <div class=\"box\">\n                    <img src=\"<?= base_url(\'public/assets/plat\') ?>/2903544.png\" class=\"img-fluid\" alt=\"\">\n                    <h3>Multiple Payment Options</h3>\n                    <p>Offer your customers various payment methods, including Mobile Banking and Bank Transfers, through NagorikPay\'s versatile platform.</p>\n                </div>\n            </div>\n\n            \n        </div>\n    </div>\n</section><!-- End Values Section -->\n\n\n\n    <section id=\"counts\" class=\"counts\">\n    <div class=\"container\" data-aos=\"fade-up\">\n\n        <div class=\"row gy-4\">\n\n            <div class=\"col-lg-3 col-md-6\">\n                <div class=\"count-box\">\n                    <!-- Updated icon -->\n                    <i class=\"bi bi-people-fill\"></i>\n                    <div>\n                        <span data-purecounter-start=\"0\" data-purecounter-end=\"1963\" data-purecounter-duration=\"1\" class=\"purecounter\"></span>\n                        <p>Happy Clients</p>\n                    </div>\n                </div>\n            </div>\n\n            <div class=\"col-lg-3 col-md-6\">\n                <div class=\"count-box\">\n                    <!-- Updated icon -->\n                    <i class=\"bi bi-book-half\" style=\"color: #ee6c20;\"></i>\n                    <div>\n                        <span data-purecounter-start=\"0\" data-purecounter-end=\"6\" data-purecounter-duration=\"1\" class=\"purecounter\"></span>\n                        <p>Plans</p>\n                    </div>\n                </div>\n            </div>\n\n            <div class=\"col-lg-3 col-md-6\">\n                <div class=\"count-box\">\n                    <!-- Updated icon -->\n                    <i class=\"bi bi-graph-up\" style=\"color: #15be56;\"></i>\n                    <div>\n                        <span data-purecounter-start=\"0\" data-purecounter-end=\"3287490\" data-purecounter-duration=\"1\" class=\"purecounter\"></span>\n                        <p>Total Amount Transactions</p>\n                    </div>\n                </div>\n            </div>\n\n            <div class=\"col-lg-3 col-md-6\">\n                <div class=\"count-box\">\n                    <!-- Updated icon -->\n                    <i class=\"bi bi-credit-card\" style=\"color: #bb0852;\"></i>\n                    <div>\n                        <span data-purecounter-start=\"0\" data-purecounter-end=\"12\" data-purecounter-duration=\"1\" class=\"purecounter\"></span>\n                        <p>Supported Payment Methods</p>\n                    </div>\n                </div>\n            </div>\n\n        </div>\n\n    </div>\n</section>\n\n    <section id=\"features\" class=\"features\">\n\n    <div class=\"container\" data-aos=\"fade-up\">\n\n        <header class=\"section-header\">\n            <h2>Features</h2>\n            <p>Advanced capabilities for streamlined payments</p>\n        </header>\n\n        <div class=\"row\">\n\n              <div class=\"col-xl-6\" data-aos=\"zoom-out\" data-aos-delay=\"100\">\n            \n            <img src=\"<?= base_url(\'public/assets/plat\') ?>/13429923.jpg\" class=\"img-fluid\" alt=\"\">\n          </div> \n                \n\n            <div class=\"col-lg-6 mt-5 mt-lg-0 d-flex\">\n                <div class=\"row align-self-center gy-4\">\n\n                    <div class=\"col-md-6\" data-aos=\"zoom-out\" data-aos-delay=\"200\">\n                        <div class=\"feature-box d-flex align-items-center\">\n                            <i class=\"bi bi-speedometer2\"></i>\n                            <h3>Real-Time Processing</h3>\n                        </div>\n                    </div>\n\n                    <div class=\"col-md-6\" data-aos=\"zoom-out\" data-aos-delay=\"300\">\n                        <div class=\"feature-box d-flex align-items-center\">\n                            <i class=\"bi bi-shield-lock\"></i>\n                            <h3>High Security</h3>\n                        </div>\n                    </div>\n\n                    <div class=\"col-md-6\" data-aos=\"zoom-out\" data-aos-delay=\"400\">\n                        <div class=\"feature-box d-flex align-items-center\">\n                            <i class=\"bi bi-arrows-expand\"></i>\n                            <h3>Scalability</h3>\n                        </div>\n                    </div>\n\n                  \n\n                    <div class=\"col-md-6\" data-aos=\"zoom-out\" data-aos-delay=\"600\">\n                        <div class=\"feature-box d-flex align-items-center\">\n                            <i class=\"bi bi-link\"></i>\n                            <h3>Seamless Integration</h3>\n                        </div>\n                    </div>\n\n                    <div class=\"col-md-6\" data-aos=\"zoom-out\" data-aos-delay=\"700\">\n                        <div class=\"feature-box d-flex align-items-center\">\n                            <i class=\"bi bi-graph-up\"></i>\n                            <h3>Comprehensive Reporting</h3>\n                        </div>\n                    </div>\n\n                    <div class=\"col-md-6\" data-aos=\"zoom-out\" data-aos-delay=\"800\">\n                        <div class=\"feature-box d-flex align-items-center\">\n                            <i class=\"bi bi-check-circle\"></i>\n                            <h3>Automatic Payment Verification</h3>\n                        </div>\n                    </div>\n\n                    <div class=\"col-md-6\" data-aos=\"zoom-out\" data-aos-delay=\"900\">\n                        <div class=\"feature-box d-flex align-items-center\">\n                            <i class=\"bi bi-cash\"></i>\n                            <h3>No Transaction Fees</h3>\n                        </div>\n                    </div>\n\n                </div>\n            </div>\n\n        </div> <!-- / row -->\n\n    </div>\n\n</section><!-- End Features Section -->\n<section id=\"services\" class=\"services\">\n\n    <div class=\"container\" data-aos=\"fade-up\">\n\n        <header class=\"section-header\">\n            <h2>Services</h2>\n            <p>Explore our range of services</p>\n        </header>\n\n        <div class=\"row mt-5\">\n\n            <div class=\"col-lg-4 col-md-6\" data-aos=\"fade-up\" data-aos-delay=\"200\">\n                <div class=\"service-box blue\">\n                    <i class=\"bi bi-lightning-charge-fill icon\"></i>\n                    <h3>Instant Payment</h3>\n                    <p>After the customer makes the payment through NAGORIKPAY, it will be instantly added to account with automatic verification.</p>\n                      </div>\n            </div>\n\n            <div class=\"col-lg-4 col-md-6\" data-aos=\"fade-up\" data-aos-delay=\"300\">\n                <div class=\"service-box orange\">\n                    <i class=\"bi bi-arrow-repeat icon\"></i>\n                    <h3>Lifetime Updates</h3>\n                    <p>Enjoy free lifetime updates with the desired service.</p>\n                        </div>\n            </div>\n\n            <div class=\"col-lg-4 col-md-6\" data-aos=\"fade-up\" data-aos-delay=\"400\">\n                <div class=\"service-box green\">\n                    <i class=\"bi bi-wallet icon\"></i>\n                    <h3>Unlimited Transactions</h3>\n                    <p>Receive unlimited payments with Nagorikpay without any fees.</p>\n                     </div>\n            </div>\n\n            <div class=\"col-lg-4 col-md-6\" data-aos=\"fade-up\" data-aos-delay=\"500\">\n                <div class=\"service-box red\">\n                    <i class=\"bi bi-chat-dots icon\"></i>\n                    <h3>24/7 Support</h3>\n                    <p>Our support team is available 24/7 to solve any issues, including NagorikPay setup and usage.</p>\n                     </div>\n            </div>\n\n            <div class=\"col-lg-4 col-md-6\" data-aos=\"fade-up\" data-aos-delay=\"600\">\n                <div class=\"service-box purple\">\n                    <i class=\"bi bi-credit-card icon\"></i>\n                    <h3>Payment Processing</h3>\n                    <p>Efficient and secure processing for all your payment needs, ensuring seamless transactions every time.</p>\n                     </div>\n            </div>\n\n            <div class=\"col-lg-4 col-md-6\" data-aos=\"fade-up\" data-aos-delay=\"700\">\n                <div class=\"service-box pink\">\n                    <i class=\"bi bi-shield-check icon\"></i>\n                    <h3>Fraud Prevention</h3>\n                    <p>Advanced fraud prevention measures to protect your business and customers from unauthorized activities.</p>\n                      </div>\n            </div>\n\n        </div>\n\n    </div>\n\n</section><!-- End Services Section -->\n\n</main>\n\n\n\n    <!-- ======= Pricing Section ======= -->\n    <section id=\"pricing\" class=\"pricing\">\n\n        <div class=\"container\" data-aos=\"fade-up\">\n\n            <header class=\"section-header\">\n                <h2>Pricing</h2>\n                <p>Check our Pricing</p>\n            </header>\n\n            <div class=\"row gy-4\" data-aos=\"fade-left\">\n\n                <?php if (!empty($plans)) : foreach ($plans as $plan) :  ?>\n                        <div class=\"col-lg-3 col-md-6\" data-aos=\"zoom-in\" data-aos-delay=\"100\">\n                            <div class=\"box\">\n                                <h3 style=\"color: #07d5c0;\"><?= $plan[\'name\'] ?></h3>\n                                <div class=\"price\"><sup></sup><?= currency_format($plan[\'final_price\']) ?><span> / <?= duration_type($plan[\'name\'], $plan[\'duration_type\'], $plan[\'duration\'], false) ?></span></div>\n                                <p class=\"text-center\"><?= $plan[\'description\'] ?></p>\n\n                                <ul>\n                                    \n                                    <li><?= plan_message(\'brand\', $plan[\'brand\']) ?></li>\n                                    <li><?= plan_message(\'device\', $plan[\'device\']) ?></li>\n                                    <li><?= plan_message(\'transaction\', $plan[\'transaction\']) ?></li>\n                                </ul>\n                                <a href=\"<?= user_url(\'plans\') ?>\" class=\"btn-buy\">Buy Now</a>\n                            </div>\n                        </div>\n                <?php endforeach;\n                endif; ?>\n\n\n\n            </div>\n\n        </div>\n\n        </div>\n\n    </section><!-- End Pricing Section -->\n    \n    <!-- ======= Platform Section ======= -->\n    <section id=\"\" class=\"clients\">\n\n      <div class=\"container\" data-aos=\"fade-up\">\n\n        <header class=\"section-header\">\n          <p>Supported Platforms</p>\n        </header>\n\n        <div class=\"clients-slider swiper\">\n          <div class=\"swiper-wrapper align-items-center\">\n          <div class=\"swiper-slide\"><img src=\"public/assets/plat/smm.png\" class=\"img-fluid\" alt=\"\"></div>\n            <div class=\"swiper-slide\"><img src=\"public/assets/plat/php.png\" class=\"img-fluid\" alt=\"\"></div>\n            <div class=\"swiper-slide\"><img src=\"public/assets/plat/javascript.png\" class=\"img-fluid\" alt=\"\"></div>\n            <div class=\"swiper-slide\"><img src=\"public/assets/plat/jquery.png\" class=\"img-fluid\" alt=\"\"></div>\n            <div class=\"swiper-slide\"><img src=\"public/assets/plat/nodejs.png\" class=\"img-fluid\" alt=\"\"></div>\n            <div class=\"swiper-slide\"><img src=\"public/assets/plat/whmcs-logo.png\" class=\"img-fluid\" alt=\"\"></div>\n            <div class=\"swiper-slide\"><img src=\"public/assets/plat/woocommerce-logo-transparent.png\" class=\"img-fluid\" alt=\"\"></div>\n            <div class=\"swiper-slide\"><img src=\"public/assets/plat/wordpress-logo-stacked-rgb.png\" class=\"img-fluid\" alt=\"\"></div>\n          </div>\n          <div class=\"swiper-pagination\"></div>\n        </div>\n      </div>\n\n    </section><!-- End Section -->\n    \n    \n    <!-- ======= F.A.Q Section ======= -->\n    <section id=\"faq\" class=\"faq\">\n\n        <div class=\"container\" data-aos=\"fade-up\">\n\n            <header class=\"section-header\">\n                <h2>F.A.Q</h2>\n                <p>Frequently Asked Questions</p>\n            </header>\n            <?php if (!empty($items)) : ?>\n                <div class=\"row\">\n                    <div class=\"col-lg-6\">\n                        <!-- F.A.Q List 1-->\n                        <div class=\"accordion accordion-flush\" id=\"faqlist1\">\n                            <?php\n                            // Split items for the first column\n                            $firstColumnItems = array_slice($items, 0, ceil(count($items) / 2));\n                            foreach ($firstColumnItems as $key => $item) : ?>\n                                <div class=\"accordion-item wow fadeInUp\" data-wow-delay=\"0.1s\">\n                                    <h2 class=\"accordion-header\" id=\"m<?= $item[\'id\'] ?>\">\n                                        <button class=\"accordion-button <?= $key == 0 ? \'\' : \'collapsed\' ?>\" type=\"button\" data-bs-toggle=\"collapse\" data-bs-target=\"#kkk<?= $item[\'id\'] ?>\" aria-expanded=\"<?= $key == 0 ? \'true\' : \'false\' ?>\" aria-controls=\"kkk<?= $item[\'id\'] ?>\">\n                                            <?= $item[\'question\'] ?>\n                                        </button>\n                                    </h2>\n                                    <div id=\"kkk<?= $item[\'id\'] ?>\" class=\"accordion-collapse collapse <?= $key == 0 ? \'show\' : \'\' ?>\" aria-labelledby=\"m<?= $item[\'id\'] ?>\" data-bs-parent=\"#faqlist1\">\n                                        <div class=\"accordion-body\">\n                                            <?= $item[\'answer\'] ?>\n                                        </div>\n                                    </div>\n                                </div>\n                            <?php endforeach; ?>\n                        </div>\n                    </div>\n\n                    <div class=\"col-lg-6\">\n                        <!-- F.A.Q List 2-->\n                        <div class=\"accordion accordion-flush\" id=\"faqlist2\">\n                            <?php\n                            // Split items for the second column\n                            $secondColumnItems = array_slice($items, ceil(count($items) / 2));\n                            foreach ($secondColumnItems as $key => $item) : ?>\n                                <div class=\"accordion-item wow fadeInUp\" data-wow-delay=\"0.1s\">\n                                    <h2 class=\"accordion-header\" id=\"m<?= $item[\'id\'] ?>\">\n                                        <button class=\"accordion-button collapsed\" type=\"button\" data-bs-toggle=\"collapse\" data-bs-target=\"#kkk<?= $item[\'id\'] ?>\" aria-expanded=\"false\" aria-controls=\"kkk<?= $item[\'id\'] ?>\">\n                                            <?= $item[\'question\'] ?>\n                                        </button>\n                                    </h2>\n                                    <div id=\"kkk<?= $item[\'id\'] ?>\" class=\"accordion-collapse collapse\" aria-labelledby=\"m<?= $item[\'id\'] ?>\" data-bs-parent=\"#faqlist2\">\n                                        <div class=\"accordion-body\">\n                                            <?= $item[\'answer\'] ?>\n                                        </div>\n                                    </div>\n                                </div>\n                            <?php endforeach; ?>\n                        </div>\n                    </div>\n                </div>\n            <?php endif; ?>\n\n\n        </div>\n\n    </section><!-- End F.A.Q Section -->\n\n    <section id=\"clients\" class=\"clients\">\n\n        <div class=\"container\" data-aos=\"fade-up\">\n\n            <header class=\"section-header\">\n                <p>Supported Gateways</p>\n            </header>\n\n            <div class=\"clients-slider swiper\">\n                <div class=\"swiper-wrapper align-items-center\">\n                    <?php if (!empty($payments)) : foreach ($payments as $payment) : ?>\n                            <div class=\"swiper-slide\"><img src=\"<?= base_url() . @get_value(get_value($payment[\'params\'], \'option\'), \'logo\'); ?>\" class=\"img-fluid\" alt=\"\"></div>\n                    <?php endforeach;\n                    endif; ?>\n                </div>\n                <div class=\"swiper-pagination\"></div>\n            </div>\n        </div>\n\n    </section><!-- End Clients Section -->\n    \n<section id=\"contact\" class=\"contact\">\n\n      <div class=\"container\" data-aos=\"fade-up\">\n\n        <header class=\"section-header\">\n          <p>Contact US</p>\n        </header>\n\n        <div class=\"row gy-4\">\n\n          <div class=\"col-lg-6\">\n\n            <div class=\"row gy-4\">\n              <div class=\"col-md-6\">\n                <div class=\"info-box\">\n                  <i class=\"bi bi-geo-alt\"></i>\n                  <h3>Address</h3>\n                  <p><?= site_config(\'address\') ?></p>\n                </div>\n              </div>\n              <div class=\"col-md-6\">\n                <div class=\"info-box\">\n                  <i class=\"bi bi-telephone\"></i>\n                  <h3>Call Us</h3>\n                  <p><?= site_config(\'contact_tel\') ?></p>\n                </div>\n              </div>\n              <div class=\"col-md-6\">\n                <div class=\"info-box\">\n                  <i class=\"bi bi-envelope\"></i>\n                  <h3>Email Us</h3>\n                  <p><?= site_config(\'contact_email\') ?></p>\n                </div>\n              </div>\n              <div class=\"col-md-6\">\n                <div class=\"info-box\">\n                  <i class=\"bi bi-clock\"></i>\n                  <h3>Open Hours</h3>\n                  <p><?= site_config(\'contact_work_hour\') ?></p>\n                </div>\n              </div>\n            </div>\n\n          </div>\n\n          \n\n        </div>\n\n      </div>\n\n    </section><!-- End Contact Section -->\n\n\n\n</main><!-- End #main -->'),
(92, 'google_login', '0'),
(93, 'google_auth_clientId', 'Google Auth Client Id'),
(94, 'google_auth_clientSecret', 'Google Auth ClientSecret'),
(95, 'enable_google_recaptcha', '0'),
(96, 'google_capcha_site_key', ''),
(97, 'google_capcha_secret_key', ''),
(98, 'enable_kyc', '0'),
(99, 'preloader', '0'),
(100, 'enable_google_translator', '0'),
(101, 'enable_goolge_translator', '0'),
(102, 'preoloader', '1'),
(103, 'enable_goolge_recapcha', '0'),
(104, 'enable_google_recapcha', '1'),
(105, 'sms_api_char_length', ''),
(106, 'sms_api_o_char_length', ''),
(107, 'sms_api_cost', ''),
(108, 'sms_api_header_data', ''),
(109, 'sms_api_params', ''),
(110, 'sms_api_formdata', 'h'),
(111, 'sms_api_success_key', 'response_code'),
(112, 'sms_api_success_value', '202'),
(113, 'is_user_trx_sms', '0'),
(114, 'is_user_customer_trx_sms', '0'),
(115, 'is_user_plan_sms', '0'),
(116, 'is_user_addon_sms', '0'),
(117, 'sms_api_method', 'POST'),
(118, 'sms_api_url', 'https://rest.nexmo.com/sms/json'),
(119, 'theme', 'custom'),
(120, 'user_plan_sms', 'Hi<strong> {{first_name}}!</strong>A plan of {{pay_amount}} tk has been added to your account successfully!</p>'),
(124, 'site_paymentform', 'V2'),
(125, 'website_name', 'Your Site'),
(126, 'website_favicon', 'https://trustpaybd.com/assets/images/favicon.png'),
(127, 'website_logo', ''),
(128, 'site_form', 'V4');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int UNSIGNED NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(225) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sort` int DEFAULT NULL,
  `status` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT '1=on, 0=off',
  `params` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `type`, `name`, `sort`, `status`, `params`) VALUES
(13, 'bkash', 'Bkash', 2, '1', '{\"type\":\"bkash\",\"option\":{\"logo\":\"public\\/uploads\\/admin\\/356a192b7913b04c54574d18c28d46e6395428ab\\/1720001734_bed271b1089aa12b9887.png\"},\"name\":\"Bkash\",\"status\":\"1\"}'),
(20, 'nagad', 'Nagad', 3, '1', '{\"type\":\"nagad\",\"option\":{\"logo\":\"public\\/uploads\\/admin\\/356a192b7913b04c54574d18c28d46e6395428ab\\/1717231942_d63fe41b5e42176d4936.png\"},\"name\":\"Nagad\",\"status\":\"1\"}'),
(21, 'rocket', 'Rocket', 4, '1', '{\"type\":\"rocket\",\"option\":{\"logo\":\"public\\/uploads\\/admin\\/356a192b7913b04c54574d18c28d46e6395428ab\\/1717239532_10348cc78dc0b990a8e5.png\"},\"name\":\"Rocket\",\"status\":\"1\"}'),
(22, 'upay', 'Upay', 5, '1', '{\"type\":\"upay\",\"option\":{\"logo\":\"public\\/uploads\\/admin\\/356a192b7913b04c54574d18c28d46e6395428ab\\/1717239551_f0b3a097df92d481e17f.png\"},\"name\":\"Upay\",\"status\":\"1\"}'),
(23, 'cellfin', 'Cellfin', 6, '1', '{\"type\":\"cellfin\",\"option\":{\"logo\":\"public\\/uploads\\/admin\\/356a192b7913b04c54574d18c28d46e6395428ab\\/1717239575_607da191972f326bb061.png\"},\"name\":\"Cellfin\",\"status\":\"1\"}'),
(24, 'ibl', 'Islamic Bank', 8, '1', '{\"type\":\"ibl\",\"option\":{\"logo\":\"public\\/uploads\\/admin\\/356a192b7913b04c54574d18c28d46e6395428ab\\/1719310270_cf7aa34e989a1c87b73b.png\"},\"name\":\"Islamic Bank\",\"status\":\"1\"}'),
(25, 'bbrac', 'Brac Bank', 15, '1', '{\"type\":\"bbrac\",\"option\":{\"logo\":\"public\\/uploads\\/admin\\/356a192b7913b04c54574d18c28d46e6395428ab\\/1717513007_a36d41cb85a2daa5c0d7.png\"},\"name\":\"Brac Bank\",\"status\":\"1\"}'),
(26, 'basia', 'Bank Asia', 16, '1', '{\"type\":\"basia\",\"option\":{\"logo\":\"public\\/uploads\\/admin\\/356a192b7913b04c54574d18c28d46e6395428ab\\/1717513044_27c3590d4bdfcf8e000f.png\"},\"name\":\"Bank Asia\",\"status\":\"1\"}'),
(27, 'dbbl', 'DBBL Bank', 12, '1', '{\"type\":\"dbbl\",\"option\":{\"logo\":\"public\\/uploads\\/admin\\/356a192b7913b04c54574d18c28d46e6395428ab\\/1719309653_65205cb7a54698f09f34.png\"},\"name\":\"DBBL Bank\",\"status\":\"1\"}'),
(28, 'agrani', 'Agrani Bank', 17, '1', '{\"type\":\"agrani\",\"option\":{\"logo\":\"public\\/uploads\\/admin\\/356a192b7913b04c54574d18c28d46e6395428ab\\/1719309709_13101fe233cfc95bb28b.png\"},\"name\":\"Agrani Bank\",\"status\":\"1\"}'),
(29, 'ebl', 'EBL Bank', 14, '1', '{\"type\":\"ebl\",\"option\":{\"logo\":\"public\\/uploads\\/admin\\/356a192b7913b04c54574d18c28d46e6395428ab\\/1719310018_5321255676af2e28a190.png\"},\"name\":\"EBL Bank\",\"status\":\"1\"}'),
(30, 'basic', 'Basic Bank', 13, '1', '{\"type\":\"basic\",\"option\":{\"logo\":\"public\\/uploads\\/admin\\/356a192b7913b04c54574d18c28d46e6395428ab\\/1719309961_62ead36f575ac147ac18.png\"},\"name\":\"Basic Bank\",\"status\":\"1\"}'),
(31, 'jamuna', 'Jamuna Bank', 18, '1', '{\"type\":\"jamuna\",\"option\":{\"logo\":\"public\\/uploads\\/admin\\/356a192b7913b04c54574d18c28d46e6395428ab\\/1719309764_ecf6e5b30fb0d31dd0f2.png\"},\"name\":\"Jamuna Bank\",\"status\":\"1\"}'),
(32, 'ific', 'IFIC Bank', 19, '1', '{\"type\":\"ific\",\"option\":{\"logo\":\"public\\/uploads\\/admin\\/356a192b7913b04c54574d18c28d46e6395428ab\\/1719309900_b9fed4d4912f17f8f310.png\"},\"name\":\"IFIC Bank\",\"status\":\"1\"}'),
(33, 'sonali', 'Sonali Bank', 11, '1', '{\"type\":\"sonali\",\"option\":{\"logo\":\"public\\/uploads\\/admin\\/356a192b7913b04c54574d18c28d46e6395428ab\\/1717512472_49287598d04a98036bd3.png\"},\"name\":\"Sonali Bank\",\"status\":\"1\"}'),
(34, 'Ipay', 'Ipay', 24, '1', '{\"type\":\"Ipay\",\"option\":{\"logo\":\"public\\/uploads\\/admin\\/356a192b7913b04c54574d18c28d46e6395428ab\\/1720105981_89786069962c9b386204.webp\"},\"name\":\"Ipay\",\"status\":\"1\"}'),
(35, 'tap', 'tap', 7, '1', '{\"type\":\"tap\",\"option\":{\"logo\":\"public\\/uploads\\/admin\\/356a192b7913b04c54574d18c28d46e6395428ab\\/1717239652_9e61829d743ec04049e5.png\"},\"name\":\"tap\",\"status\":\"1\"}'),
(36, 'paypal', 'Paypal', 25, '0', '{\"type\":\"paypal\",\"option\":{\"logo\":\"public\\/uploads\\/admin\\/356a192b7913b04c54574d18c28d46e6395428ab\\/1717513660_56a478dea2bf98f3e022.png\"},\"name\":\"Paypal\",\"status\":\"0\"}'),
(37, '2checkout', '2checkout', 26, '0', '{\"type\":\"2checkout\",\"option\":{\"logo\":\"public\\/uploads\\/admin\\/356a192b7913b04c54574d18c28d46e6395428ab\\/1720100844_1656c9ab1694ae2459f7.png\"},\"name\":\"2checkout\",\"status\":\"1\"}'),
(39, 'binance', 'Binance', 20, '1', '{\"type\":\"binance\",\"option\":{\"logo\":\"public\\/uploads\\/admin\\/356a192b7913b04c54574d18c28d46e6395428ab\\/1717513584_d7ff0294bf6b6c98db7b.png\"},\"name\":\"Binance\",\"status\":\"1\"}'),
(40, 'abbank', 'AB Bank', 9, '1', '{\"type\":\"abbank\",\"option\":{\"logo\":\"public\\/uploads\\/admin\\/356a192b7913b04c54574d18c28d46e6395428ab\\/1719309599_b6aac1ea1fb6fa57ffb2.png\"},\"name\":\"AB Bank\",\"status\":\"1\"}'),
(41, 'citybank', 'City Bank', 10, '1', '{\"type\":\"citybank\",\"option\":{\"logo\":\"public\\/uploads\\/admin\\/356a192b7913b04c54574d18c28d46e6395428ab\\/1717512423_12782dab3a9f260e0c5d.png\"},\"name\":\"City Bank\",\"status\":\"1\"}'),
(42, 'mastercard', 'Mastercard', 23, '0', '{\"type\":\"mastercard\",\"option\":{\"logo\":\"public\\/uploads\\/admin\\/356a192b7913b04c54574d18c28d46e6395428ab\\/1720100801_cffe430721df95dae74b.png\"},\"name\":\"Mastercard\",\"status\":\"1\"}'),
(43, 'coinbase', 'Coinbase', 22, '0', '{\"type\":\"coinbase\",\"option\":{\"logo\":\"public\\/uploads\\/admin\\/356a192b7913b04c54574d18c28d46e6395428ab\\/1719311214_11838c32962f35810b58.png\"},\"name\":\"Coinbase\",\"status\":\"1\"}'),
(44, 'payeer', 'Payeer', 21, '1', '{\"type\":\"payeer\",\"option\":{\"logo\":\"public\\/uploads\\/admin\\/356a192b7913b04c54574d18c28d46e6395428ab\\/1717513731_81f4435ab5365e24f0b6.png\"},\"name\":\"Payeer\",\"status\":\"0\"}'),
(45, 'surecash', 'Sure Cash', 31, '1', '{\"type\":\"surecash\",\"option\":{\"logo\":\"public\\/uploads\\/admin\\/356a192b7913b04c54574d18c28d46e6395428ab\\/1719306582_f4ec8dc3e2a7da47151a.png\"},\"name\":\"Sure Cash\",\"status\":\"1\"}'),
(46, 'okwallet', 'Ok Wallet', 29, '1', '{\"type\":\"okwallet\",\"option\":{\"logo\":\"public\\/uploads\\/admin\\/356a192b7913b04c54574d18c28d46e6395428ab\\/1719306339_29c6b8d2a1d36349a356.png\"},\"name\":\"Ok Wallet\",\"status\":\"1\"}'),
(47, 'perfectmoney', 'Perfect Money', 34, '0', '{\"type\":\"perfectmoney\",\"option\":{\"logo\":\"public\\/uploads\\/admin\\/356a192b7913b04c54574d18c28d46e6395428ab\\/1719311265_24bcdf2b9be294a3c28b.png\"},\"name\":\"Perfect Money\",\"status\":\"1\"}'),
(48, 'coinpayments', 'Coinpayments', 30, '0', '{\"type\":\"coinpayments\",\"option\":{\"logo\":\"public\\/uploads\\/admin\\/356a192b7913b04c54574d18c28d46e6395428ab\\/1720100760_f9e19f2550433c2aa06a.png\"},\"name\":\"Coinpayments\",\"status\":\"1\"}'),
(49, 'mcash', 'MCash', 44, '1', '{\"type\":\"mcash\",\"option\":{\"logo\":\"public\\/uploads\\/admin\\/356a192b7913b04c54574d18c28d46e6395428ab\\/1720096138_9c15f75876952675f8a0.webp\"},\"name\":\"MCash\",\"status\":\"1\"}'),
(51, 'easypaisa', 'Easy Paisa', 45, '0', '{\"type\":\"easypaisa\",\"option\":{\"logo\":\"public\\/uploads\\/admin\\/356a192b7913b04c54574d18c28d46e6395428ab\\/1720096060_9cb999b4a54c789d3cea.png\"},\"name\":\"Easy Paisa\",\"status\":\"1\"}'),
(52, 'mycash', 'myCash', 46, '1', '{\"type\":\"mycash\",\"option\":{\"logo\":\"public\\/uploads\\/admin\\/356a192b7913b04c54574d18c28d46e6395428ab\\/1720097170_0d54ea45149671627510.jpeg\"},\"name\":\"myCash\",\"status\":\"1\"}');

-- --------------------------------------------------------

--
-- Table structure for table `plans`
--

CREATE TABLE `plans` (
  `id` int UNSIGNED NOT NULL,
  `ids` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `brand` int NOT NULL,
  `device` int NOT NULL,
  `transaction` int NOT NULL,
  `price` decimal(10,3) NOT NULL DEFAULT '0.000',
  `final_price` decimal(10,3) NOT NULL DEFAULT '0.000',
  `duration` int NOT NULL COMMENT 'number of unit -1 for lifetime',
  `duration_type` int NOT NULL COMMENT '1=day,2=month, 3=year',
  `sort` int NOT NULL,
  `status` int NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `plans`
--

INSERT INTO `plans` (`id`, `ids`, `name`, `description`, `brand`, `device`, `transaction`, `price`, `final_price`, `duration`, `duration_type`, `sort`, `status`, `created_at`, `deleted_at`) VALUES
(13, '2c7130a39b77eecb03d96e8db85a84b4', '15 Days', '15 Days', 1, 1, -1, 50.000, 10.000, 15, 1, 2, 0, '2024-12-18 17:48:41', '2026-03-14 23:04:57'),
(14, '52cfbba9fbd2eb03b6896fa6604b04f9', 'Free', 'Free', 5, 5, -1, 0.000, 0.000, 365, 1, 1, 1, '2024-12-18 17:56:35', '2026-03-14 23:04:57'),
(15, 'd9733681d4a03e8a645c84f83e24434a', '30 Days', '২টি ওয়েবসাইট ও ২টি ডিভাইসে ব্যবহার করুন', 2, 2, -1, 150.000, 20.000, 1, 2, 3, 0, '2024-12-18 18:24:30', '2026-03-14 23:04:57'),
(17, '4a77b6ef1822b0ec677b524abea2356c', '6 Months', '২টি ওয়েবসাইট ও ২টি ডিভাইসে ব্যবহার করুন', 3, 3, -1, 499.000, 120.000, 6, 2, 4, 0, '2024-12-18 21:07:22', '2026-03-14 23:04:57'),
(19, 'd0ae1261dd32af22894975a51fb860c3', '12 Months', '২টি ওয়েবসাইট ও ৪টি ডিভাইসে ব্যবহার করুন', 4, 10, -1, 799.000, 210.000, 1, 3, 5, 0, '2024-12-18 21:23:07', '2026-03-14 23:04:57');

-- --------------------------------------------------------

--
-- Table structure for table `queue`
--

CREATE TABLE `queue` (
  `id` int NOT NULL,
  `task_type` text,
  `task_data` text,
  `status` varchar(16) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `staffs`
--

CREATE TABLE `staffs` (
  `id` int UNSIGNED NOT NULL,
  `ids` varchar(50) NOT NULL,
  `role_id` int DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `first_name` text,
  `last_name` text,
  `balance` decimal(10,3) NOT NULL DEFAULT '0.000',
  `more_information` text,
  `avatar` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `activation_key` varchar(50) DEFAULT NULL,
  `reset_key` varchar(50) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `staffs`
--

INSERT INTO `staffs` (`id`, `ids`, `role_id`, `email`, `first_name`, `last_name`, `balance`, `more_information`, `avatar`, `password`, `status`, `activation_key`, `reset_key`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'admin', 1, 'admin@cloudman.one', 'Admin', '', 0.000, '', 'public/uploads/admin/356a192b7913b04c54574d18c28d46e6395428ab/1734519891_d9639631de1634bf18bc.png', '$2y$10$JI7d/9kAM6NvOtTLERHUTuYL6TDCuXL5y/29w3ZyuodhnoLda4VRC', 1, '8RXWHBUAXXB3b7VwW8DOHHgdK', 'WyeHchQIEDfKRBloGMsAh4e1r7NT4A8F', '2024-06-01 14:33:05', NULL, NULL),
(2, '0fac80be8e979415ae45159e0dd6e7f6', 2, 'admin@gmail.com', 'System', 'Admin', 9999999.999, NULL, NULL, '$2y$10$/fZGD8pRA.1Cddigi9qkZe1QTAsQHcxxQssigkKk1Y.epL5ZEbPli', 1, 'kkuMjDHZW4djE1Y1TAHtSVQYR', 'jNumrvBzsT5uSGLFC6gMIsjyNz1Woaqa', '2025-06-23 20:20:36', '2025-06-23 20:20:36', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `templates`
--

CREATE TABLE `templates` (
  `id` int UNSIGNED NOT NULL,
  `uid` int DEFAULT NULL,
  `template_key` varchar(120) DEFAULT NULL,
  `email_from` varchar(191) NOT NULL DEFAULT 'support@example.com',
  `name` varchar(191) NOT NULL,
  `subject` varchar(191) NOT NULL,
  `template` text,
  `sms_body` text,
  `mail_status` tinyint(1) NOT NULL DEFAULT '0',
  `sms_status` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `temp_transactions`
--

CREATE TABLE `temp_transactions` (
  `id` int UNSIGNED NOT NULL,
  `ids` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `uid` int UNSIGNED NOT NULL,
  `brand_id` int UNSIGNED NOT NULL,
  `params` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `meta` text COLLATE utf8mb4_unicode_ci,
  `amount` decimal(10,3) NOT NULL DEFAULT '0.000',
  `currency` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'BDT',
  `request` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'GET' COMMENT 'GET or POST',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0=pending,1=initiated,2=success,3=cancel',
  `transaction_id` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `temp_transactions`
--

INSERT INTO `temp_transactions` (`id`, `ids`, `uid`, `brand_id`, `params`, `meta`, `amount`, `currency`, `request`, `status`, `transaction_id`, `created_at`, `updated_at`) VALUES
(172, '6089597754e3856a3bc188afa5af7b0e', 1, 8, '{\"cus_name\":\"MD LeonIslam\",\"cus_email\":\"bdbosstv@gmail.com\",\"success_url\":\"https:\\/\\/dev.bdbetterpay.com\\/user\\/add_funds\\/complete\\/success\",\"cancel_url\":\"https:\\/\\/dev.bdbetterpay.com\\/user\\/add_funds\\/complete\\/unsuccess\",\"webhook_url\":\"https:\\/\\/dev.bdbetterpay.com\\/user\\/add_funds\\/complete\\/validate\"}', '{\"phone\":\"01710604946\",\"uid\":\"358\"}', 222.000, 'BDT', 'GET', 0, '3BLHNR162921', '2025-03-17 04:08:41', NULL),
(175, 'b10eadbe682154fd5643bf6ea025ca9c', 1, 8, '{\"cus_name\":\"SwadhinKhan\",\"cus_email\":\"khan.swadhin@gmail.com\",\"success_url\":\"https:\\/\\/dev.bdbetterpay.com\\/user\\/add_funds\\/complete\\/success\",\"cancel_url\":\"https:\\/\\/dev.bdbetterpay.com\\/user\\/add_funds\\/complete\\/unsuccess\",\"webhook_url\":\"https:\\/\\/dev.bdbetterpay.com\\/user\\/add_funds\\/complete\\/validate\"}', '{\"phone\":\"01823662233\",\"uid\":\"360\"}', 99999.000, 'BDT', 'GET', 0, 'N54763248720', '2025-03-18 03:58:40', NULL),
(176, 'a96f7c58b9b556f237174a034631b78f', 1, 8, '{\"cus_name\":\"MD LeonIslam\",\"cus_email\":\"bdbosstv@gmail.com\",\"success_url\":\"https:\\/\\/dev.bdbetterpay.com\\/user\\/add_funds\\/complete\\/success\",\"cancel_url\":\"https:\\/\\/dev.bdbetterpay.com\\/user\\/add_funds\\/complete\\/unsuccess\",\"webhook_url\":\"https:\\/\\/dev.bdbetterpay.com\\/user\\/add_funds\\/complete\\/validate\"}', '{\"phone\":\"01710604946\",\"uid\":\"358\"}', 777.000, 'BDT', 'GET', 0, 'Q9LLD6254806', '2025-03-18 05:40:06', NULL),
(180, '9b07f59a7ce6f9922a9a8148ffce9f87', 1, 8, '{\"cus_name\":\"Md RakibulIslam\",\"cus_email\":\"md0942479@gmail.com\",\"success_url\":\"https:\\/\\/egpay.io\\/user\\/add_funds\\/complete\\/success\",\"cancel_url\":\"https:\\/\\/egpay.io\\/user\\/add_funds\\/complete\\/unsuccess\",\"webhook_url\":\"https:\\/\\/egpay.io\\/user\\/add_funds\\/complete\\/validate\"}', '{\"phone\":\"01825607861\",\"uid\":\"362\"}', 50.000, 'BDT', 'GET', 0, 'IMG3AJ805661', '2025-05-09 21:47:41', NULL),
(181, 'da1d72115347c3f5fc4bcb6ea6ef27d7', 1, 8, '{\"cus_name\":\"Md RakibulIslam\",\"cus_email\":\"md0942479@gmail.com\",\"success_url\":\"https:\\/\\/egpay.io\\/user\\/add_funds\\/complete\\/success\",\"cancel_url\":\"https:\\/\\/egpay.io\\/user\\/add_funds\\/complete\\/unsuccess\",\"webhook_url\":\"https:\\/\\/egpay.io\\/user\\/add_funds\\/complete\\/validate\"}', '{\"phone\":\"01825607861\",\"uid\":\"362\"}', 50.000, 'BDT', 'GET', 0, '0YP0EK805793', '2025-05-09 21:49:53', NULL),
(182, '6ad4d6b8b345765cca5586b7e9b78315', 1, 8, '{\"cus_name\":\"R Lab BDDigital\",\"cus_email\":\"admin@gmail.com\",\"success_url\":\"https:\\/\\/egpay.io\\/user\\/add_funds\\/complete\\/success\",\"cancel_url\":\"https:\\/\\/egpay.io\\/user\\/add_funds\\/complete\\/unsuccess\",\"webhook_url\":\"https:\\/\\/egpay.io\\/user\\/add_funds\\/complete\\/validate\"}', '{\"phone\":\"01889298798\",\"uid\":\"1\"}', 50.000, 'BDT', 'GET', 0, 'P9X4NC806304', '2025-05-09 21:58:24', NULL),
(183, 'd2b384c3c5cd595d708ba81509134f78', 1, 8, '{\"cus_name\":\"Md RakibulIslam\",\"cus_email\":\"md0942479@gmail.com\",\"success_url\":\"https:\\/\\/anipay.anihost.top\\/user\\/add_funds\\/complete\\/success\",\"cancel_url\":\"https:\\/\\/anipay.anihost.top\\/user\\/add_funds\\/complete\\/unsuccess\",\"webhook_url\":\"https:\\/\\/anipay.anihost.top\\/user\\/add_funds\\/complete\\/validate\"}', '{\"phone\":\"01825607861\",\"uid\":\"362\"}', 10.000, 'BDT', 'GET', 0, '92ZHQD683223', '2025-06-23 18:53:43', NULL),
(184, '1b85c28ab874358a4493365cbfd33d0e', 1, 8, '{\"cus_name\":\"Md RakibulIslam\",\"cus_email\":\"md0942479@gmail.com\",\"success_url\":\"https:\\/\\/anipay.anihost.top\\/user\\/add_funds\\/complete\\/success\",\"cancel_url\":\"https:\\/\\/anipay.anihost.top\\/user\\/add_funds\\/complete\\/unsuccess\",\"webhook_url\":\"https:\\/\\/anipay.anihost.top\\/user\\/add_funds\\/complete\\/validate\"}', '{\"phone\":\"01825607861\",\"uid\":\"362\"}', 50.000, 'BDT', 'GET', 0, 'FOGXJM684064', '2025-06-23 19:07:44', NULL),
(185, 'fa9c17164a7eb815fc8f0195fc2a9087', 1, 8, '{\"cus_name\":\"AniOtaku\",\"cus_email\":\"mimraji3497@gmail.com\",\"success_url\":\"https:\\/\\/anipay.anihost.top\\/user\\/add_funds\\/complete\\/success\",\"cancel_url\":\"https:\\/\\/anipay.anihost.top\\/user\\/add_funds\\/complete\\/unsuccess\",\"webhook_url\":\"https:\\/\\/anipay.anihost.top\\/user\\/add_funds\\/complete\\/validate\"}', '{\"phone\":\"01989008444\",\"uid\":\"364\"}', 200.000, 'BDT', 'GET', 0, 'OOM0RD794878', '2025-06-25 01:54:38', NULL),
(186, 'ee17fb1e1bbe7325a41b2755af1a9193', 1, 8, '{\"cus_name\":\"DemoUser\",\"cus_email\":\"demo@gmail.com\",\"success_url\":\"https:\\/\\/demopay.xyz\\/user\\/add_funds\\/complete\\/success\",\"cancel_url\":\"https:\\/\\/demopay.xyz\\/user\\/add_funds\\/complete\\/unsuccess\",\"webhook_url\":\"https:\\/\\/demopay.xyz\\/user\\/add_funds\\/complete\\/validate\"}', '{\"phone\":\"01444444444\",\"uid\":\"371\"}', 600.000, 'BDT', 'GET', 0, '330SPE246593', '2025-06-30 07:23:13', NULL),
(188, '238eb6d766f5be30c72ac4aa7ef114be', 1, 8, '{\"cus_name\":\"DemoUser\",\"cus_email\":\"demo@gmail.com\",\"success_url\":\"https:\\/\\/demopay.xyz\\/user\\/add_funds\\/complete\\/success\",\"cancel_url\":\"https:\\/\\/demopay.xyz\\/user\\/add_funds\\/complete\\/unsuccess\",\"webhook_url\":\"https:\\/\\/demopay.xyz\\/user\\/add_funds\\/complete\\/validate\"}', '{\"phone\":\"01444444444\",\"uid\":\"371\"}', 200.000, 'BDT', 'GET', 0, '5FPJJU368261', '2025-07-01 17:11:01', NULL),
(189, '9c27eb37fd2b171483b2e4b199f78997', 1, 8, '{\"cus_name\":\"DemoUser\",\"cus_email\":\"demo@gmail.com\",\"success_url\":\"https:\\/\\/demopay.xyz\\/user\\/add_funds\\/complete\\/success\",\"cancel_url\":\"https:\\/\\/demopay.xyz\\/user\\/add_funds\\/complete\\/unsuccess\",\"webhook_url\":\"https:\\/\\/demopay.xyz\\/user\\/add_funds\\/complete\\/validate\"}', '{\"phone\":\"01444444444\",\"uid\":\"372\"}', 200.000, 'BDT', 'GET', 0, '6GI6NS369675', '2025-07-01 17:34:35', NULL),
(190, '8905138e249f9ac436734ac69b4c2773', 1, 8, '{\"cus_name\":\"DemoUser\",\"cus_email\":\"demo@gmail.com\",\"success_url\":\"https:\\/\\/demopay.xyz\\/user\\/add_funds\\/complete\\/success\",\"cancel_url\":\"https:\\/\\/demopay.xyz\\/user\\/add_funds\\/complete\\/unsuccess\",\"webhook_url\":\"https:\\/\\/demopay.xyz\\/user\\/add_funds\\/complete\\/validate\"}', '{\"phone\":\"01444444444\",\"uid\":\"372\"}', 200.000, 'BDT', 'GET', 0, 'FTD094369751', '2025-07-01 17:35:51', NULL),
(191, '60dd44d100135ad81ce1c872eca27b25', 1, 8, '{\"cus_name\":\"DemoUser\",\"cus_email\":\"demo@gmail.com\",\"success_url\":\"https:\\/\\/demopay.xyz\\/user\\/add_funds\\/complete\\/success\",\"cancel_url\":\"https:\\/\\/demopay.xyz\\/user\\/add_funds\\/complete\\/unsuccess\",\"webhook_url\":\"https:\\/\\/demopay.xyz\\/user\\/add_funds\\/complete\\/validate\"}', '{\"phone\":\"01444444444\",\"uid\":\"372\"}', 200.000, 'BDT', 'GET', 0, 'LTFLWG386271', '2025-07-01 22:11:11', NULL),
(192, 'efd0aa5dcce27f3df8b36f23b5d03ec8', 372, 22, '{\"cus_name\":\"Demo\",\"cus_email\":\"demo@gmail.com\",\"success_url\":\"https:\\/\\/demopay.xyz\\/invoice\\/b85992305627636df85646b222e37e52\",\"cancel_url\":\"https:\\/\\/demopay.xyz\\/invoice\\/b85992305627636df85646b222e37e52\",\"webhook_url\":\"https:\\/\\/demopay.xyz\\/invoice\\/b85992305627636df85646b222e37e52?complete=b85992305627636df85646b222e37e52\"}', '[]', 2000.000, 'BDT', 'GET', 0, 'XAH53M386359', '2025-07-01 22:12:39', NULL),
(193, '0fccc9823448dd22de9cacf2b3528c19', 372, 22, '{\"cus_name\":\"Demo\",\"cus_email\":\"demo@gmail.com\",\"success_url\":\"https:\\/\\/demopay.xyz\\/invoice\\/b85992305627636df85646b222e37e52\",\"cancel_url\":\"https:\\/\\/demopay.xyz\\/invoice\\/b85992305627636df85646b222e37e52\",\"webhook_url\":\"https:\\/\\/demopay.xyz\\/invoice\\/b85992305627636df85646b222e37e52?complete=b85992305627636df85646b222e37e52\"}', '[]', 2000.000, 'BDT', 'GET', 0, '41BRJQ461071', '2025-07-02 18:57:51', NULL),
(194, '67f96a88c5fca572459de1914c00894a', 372, 22, '{\"cus_name\":\"Demo\",\"cus_email\":\"demo@gmail.com\",\"success_url\":\"https:\\/\\/demopay.xyz\\/invoice\\/b85992305627636df85646b222e37e52\",\"cancel_url\":\"https:\\/\\/demopay.xyz\\/invoice\\/b85992305627636df85646b222e37e52\",\"webhook_url\":\"https:\\/\\/demopay.xyz\\/invoice\\/b85992305627636df85646b222e37e52?complete=b85992305627636df85646b222e37e52\"}', '[]', 2000.000, 'BDT', 'GET', 0, 'L6H72S711516', '2025-07-05 16:31:56', NULL),
(195, '26fe8ead8658a07a4b203dc0fdd5bad1', 372, 22, '{\"cus_name\":\"Demo\",\"cus_email\":\"demo@gmail.com\",\"success_url\":\"https:\\/\\/demopay.xyz\\/invoice\\/b85992305627636df85646b222e37e52\",\"cancel_url\":\"https:\\/\\/demopay.xyz\\/invoice\\/b85992305627636df85646b222e37e52\",\"webhook_url\":\"https:\\/\\/demopay.xyz\\/invoice\\/b85992305627636df85646b222e37e52?complete=b85992305627636df85646b222e37e52\"}', '[]', 2000.000, 'BDT', 'GET', 0, 'WAJCUI885686', '2025-07-07 16:54:46', NULL),
(196, '22a28d2f0ea6a11f01d55b338dd27991', 372, 22, '{\"cus_name\":\"Demo\",\"cus_email\":\"demo@gmail.com\",\"success_url\":\"https:\\/\\/demopay.xyz\\/invoice\\/b85992305627636df85646b222e37e52\",\"cancel_url\":\"https:\\/\\/demopay.xyz\\/invoice\\/b85992305627636df85646b222e37e52\",\"webhook_url\":\"https:\\/\\/demopay.xyz\\/invoice\\/b85992305627636df85646b222e37e52?complete=b85992305627636df85646b222e37e52\"}', '[]', 2000.000, 'BDT', 'GET', 0, '8YAL38955822', '2025-07-08 12:23:42', NULL),
(197, '86f73609ef2dc2aebc542fb8eee6a53e', 372, 22, '{\"cus_name\":\"Demo\",\"cus_email\":\"demo@gmail.com\",\"success_url\":\"https:\\/\\/demopay.xyz\\/invoice\\/b85992305627636df85646b222e37e52\",\"cancel_url\":\"https:\\/\\/demopay.xyz\\/invoice\\/b85992305627636df85646b222e37e52\",\"webhook_url\":\"https:\\/\\/demopay.xyz\\/invoice\\/b85992305627636df85646b222e37e52?complete=b85992305627636df85646b222e37e52\"}', '[]', 2000.000, 'BDT', 'GET', 0, '9UEZ98955991', '2025-07-08 12:26:31', NULL),
(198, 'e268351e6ede1a896227578af884ac2a', 1, 8, '{\"cus_name\":\"DemoUser\",\"cus_email\":\"demo@gmail.com\",\"success_url\":\"https:\\/\\/demopay.xyz\\/user\\/add_funds\\/complete\\/success\",\"cancel_url\":\"https:\\/\\/demopay.xyz\\/user\\/add_funds\\/complete\\/unsuccess\",\"webhook_url\":\"https:\\/\\/demopay.xyz\\/user\\/add_funds\\/complete\\/validate\"}', '{\"phone\":\"01444444444\",\"uid\":\"372\"}', 50.000, 'BDT', 'GET', 0, '3I48T5957497', '2025-07-08 12:51:37', NULL),
(199, '974cc6026a33ddc6d4370ec49e55d5cf', 372, 22, '{\"cus_name\":\"Demo\",\"cus_email\":\"demo@gmail.com\",\"success_url\":\"https:\\/\\/demopay.xyz\\/invoice\\/b85992305627636df85646b222e37e52\",\"cancel_url\":\"https:\\/\\/demopay.xyz\\/invoice\\/b85992305627636df85646b222e37e52\",\"webhook_url\":\"https:\\/\\/demopay.xyz\\/invoice\\/b85992305627636df85646b222e37e52?complete=b85992305627636df85646b222e37e52\"}', '[]', 2000.000, 'BDT', 'GET', 0, '8BGRF1957539', '2025-07-08 12:52:19', NULL),
(200, '021e0f113cef05482bfefaf8dd246be2', 372, 22, '{\"cus_name\":\"Demo\",\"cus_email\":\"demo@gmail.com\",\"success_url\":\"https:\\/\\/demopay.xyz\\/invoice\\/b85992305627636df85646b222e37e52\",\"cancel_url\":\"https:\\/\\/demopay.xyz\\/invoice\\/b85992305627636df85646b222e37e52\",\"webhook_url\":\"https:\\/\\/demopay.xyz\\/invoice\\/b85992305627636df85646b222e37e52?complete=b85992305627636df85646b222e37e52\"}', '[]', 2000.000, 'BDT', 'GET', 0, 'GXY2QS957629', '2025-07-08 12:53:49', NULL),
(201, '40c18c8ede6ca9248b258afb38a20327', 372, 22, '{\"cus_name\":\"Demo\",\"cus_email\":\"demo@gmail.com\",\"success_url\":\"https:\\/\\/demopay.xyz\\/invoice\\/b85992305627636df85646b222e37e52\",\"cancel_url\":\"https:\\/\\/demopay.xyz\\/invoice\\/b85992305627636df85646b222e37e52\",\"webhook_url\":\"https:\\/\\/demopay.xyz\\/invoice\\/b85992305627636df85646b222e37e52?complete=b85992305627636df85646b222e37e52\"}', '[]', 2000.000, 'BDT', 'GET', 0, 'OTFUX1995069', '2025-07-08 23:17:49', NULL),
(202, '70549c57c203be23e4abb9b7b56ead44', 372, 22, '{\"cus_name\":\"Demo\",\"cus_email\":\"demo@gmail.com\",\"success_url\":\"https:\\/\\/demopay.xyz\\/invoice\\/b85992305627636df85646b222e37e52\",\"cancel_url\":\"https:\\/\\/demopay.xyz\\/invoice\\/b85992305627636df85646b222e37e52\",\"webhook_url\":\"https:\\/\\/demopay.xyz\\/invoice\\/b85992305627636df85646b222e37e52?complete=b85992305627636df85646b222e37e52\"}', '[]', 2000.000, 'BDT', 'GET', 0, '87Y7YF995156', '2025-07-08 23:19:16', NULL),
(203, 'd86c3903d7cf94c1038e2d42e13218ab', 372, 22, '{\"cus_name\":\"Demo\",\"cus_email\":\"demo@gmail.com\",\"success_url\":\"https:\\/\\/demopay.xyz\\/invoice\\/b85992305627636df85646b222e37e52\",\"cancel_url\":\"https:\\/\\/demopay.xyz\\/invoice\\/b85992305627636df85646b222e37e52\",\"webhook_url\":\"https:\\/\\/demopay.xyz\\/invoice\\/b85992305627636df85646b222e37e52?complete=b85992305627636df85646b222e37e52\"}', '[]', 2000.000, 'BDT', 'GET', 0, 'XW1QWC048379', '2025-07-09 14:06:19', NULL),
(204, '26bb06881c7ffa70880a05fdd33ee343', 372, 22, '{\"cus_name\":\"Demo\",\"cus_email\":\"demo@gmail.com\",\"success_url\":\"https:\\/\\/demopay.xyz\\/invoice\\/b85992305627636df85646b222e37e52\",\"cancel_url\":\"https:\\/\\/demopay.xyz\\/invoice\\/b85992305627636df85646b222e37e52\",\"webhook_url\":\"https:\\/\\/demopay.xyz\\/invoice\\/b85992305627636df85646b222e37e52?complete=b85992305627636df85646b222e37e52\"}', '[]', 2000.000, 'BDT', 'GET', 0, '0J7UNX048576', '2025-07-09 14:09:36', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `id` int UNSIGNED NOT NULL,
  `ids` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `uid` int UNSIGNED NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `is_user_read` tinyint(1) NOT NULL DEFAULT '0',
  `is_admin_read` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ticket_messages`
--

CREATE TABLE `ticket_messages` (
  `id` int UNSIGNED NOT NULL,
  `ids` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `ticket_id` int UNSIGNED NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `author` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `support` tinyint NOT NULL COMMENT '1=support, 0=client',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int UNSIGNED NOT NULL,
  `ids` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `uid` int UNSIGNED NOT NULL,
  `brand_id` int DEFAULT NULL,
  `message` text COLLATE utf8mb4_unicode_ci,
  `type` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` decimal(10,3) NOT NULL DEFAULT '0.000',
  `currency` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0=pending,1=initiated,2=success,3=cancel',
  `transaction_id` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int UNSIGNED NOT NULL,
  `ids` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `first_name` text,
  `last_name` text,
  `phone` varchar(20) NOT NULL,
  `balance` decimal(10,3) NOT NULL DEFAULT '0.000',
  `more_information` text,
  `avatar` varchar(255) DEFAULT NULL,
  `api_credentials` text,
  `timezone` text,
  `ref_id` int NOT NULL,
  `ref_key` text,
  `addons` text,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `activation_key` varchar(50) DEFAULT NULL,
  `reset_key` varchar(50) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `ids`, `email`, `password`, `first_name`, `last_name`, `phone`, `balance`, `more_information`, `avatar`, `api_credentials`, `timezone`, `ref_id`, `ref_key`, `addons`, `status`, `activation_key`, `reset_key`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '1d8b34f05b1f18ef7c00f290cdfd199a', 'admin@cloudman.one', '$2y$10$l/2q34XIGHRZr0ojAl8yGOj28S8X6a9Be2KFEmiSFYLvcDd/pcwUC', 'R Lab BD', 'Digital', '01889298798', 8500.000, 'Admin', 'public/uploads/user/356a192b7913b04c54574d18c28d46e6395428ab/1746806013_f5bd82cfd5cec3190852.png', NULL, NULL, 0, 'bdfae46efb101d38f5f9d1bc7a9c2fca', NULL, 1, 'K1xKf110lm6H3XT7pnJtuPsjC', 'lUNRut1mQxzFQUKOeV5yaYVzTaic6jMx', '2024-12-07 11:12:50', '2024-12-07 11:15:58', NULL),
(372, 'd6e9f7a598ca6541a8ce28fe07ff8e9e', 'demo@gmail.com', '$2y$10$EyCw9yyWapgkMwdK8hjYqOG1whamWajehf31IB23nnZAD3Ho7LKZG', 'Demo', 'User', '01444444444', 0.000, NULL, NULL, NULL, NULL, 0, '3f64b86886030d8d4d0bcd4ea8c3ea7e', NULL, 1, 'Hhiz7p6nYg4rfhpq9qeVWWIrC', 'd47IQXuf18V4A7vq6RNkwNcfCfucsONy', '2025-07-01 17:32:53', '2025-07-01 17:32:53', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_coupons`
--

CREATE TABLE `user_coupons` (
  `id` int UNSIGNED NOT NULL,
  `uid` int UNSIGNED NOT NULL,
  `coupon_id` int DEFAULT NULL,
  `plan_id` int DEFAULT NULL,
  `price` decimal(10,3) NOT NULL DEFAULT '0.000',
  `discount` decimal(10,3) NOT NULL DEFAULT '0.000',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `user_notifier`
--

CREATE TABLE `user_notifier` (
  `id` int UNSIGNED NOT NULL,
  `uid` int UNSIGNED NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci,
  `response` text COLLATE utf8mb4_unicode_ci,
  `type` tinyint NOT NULL DEFAULT '1' COMMENT '0=>mail, 1=>sms',
  `medium` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Mobile number or email',
  `status` tinyint DEFAULT NULL,
  `charge` float DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `deleted_at` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_payment_settings`
--

CREATE TABLE `user_payment_settings` (
  `id` int UNSIGNED NOT NULL,
  `uid` int UNSIGNED NOT NULL,
  `brand_id` int NOT NULL,
  `g_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `t_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int NOT NULL DEFAULT '0',
  `params` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` text COLLATE utf8mb4_unicode_ci,
  `deleted_at` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_payment_settings`
--

INSERT INTO `user_payment_settings` (`id`, `uid`, `brand_id`, `g_type`, `t_type`, `status`, `params`, `created_at`, `deleted_at`) VALUES
(21, 1, 8, 'bkash', 'mobile', 1, '{\"status\":\"1\",\"brand_id\":\"8\",\"active_payments\":{\"personal\":\"0\",\"agent\":\"0\",\"merchant\":\"0\",\"payment\":\"0\"},\"personal_number\":\"\",\"payment_number\":\"\",\"agent_number\":\"\",\"sandbox\":\"0\",\"logs\":\"0\",\"username\":\"\",\"password\":\"\",\"app_key\":\"\",\"app_secret\":\"\"}', '2024-12-07 11:37:06', NULL),
(22, 1, 8, 'nagad', 'mobile', 1, '{\"status\":\"1\",\"brand_id\":\"8\",\"active_payments\":{\"personal\":\"0\",\"agent\":\"0\",\"merchant\":\"0\"},\"personal_number\":\"\",\"agent_number\":\"\",\"nagad_mode\":\"live\",\"merchant_id\":\"\",\"private_key\":\"\",\"public_key\":\"\"}', '2024-12-07 11:37:17', NULL),
(23, 1, 8, 'rocket', 'mobile', 1, '{\"status\":\"1\",\"brand_id\":\"8\",\"active_payments\":{\"personal\":\"0\",\"agent\":\"0\"},\"personal_number\":\"\",\"agent_number\":\"\",\"merchant_url\":\"\"}', '2024-12-07 11:37:25', NULL),
(24, 1, 8, 'upay', 'mobile', 1, '{\"status\":\"1\",\"brand_id\":\"8\",\"active_payments\":{\"personal\":\"0\",\"agent\":\"0\",\"merchant\":\"0\"},\"personal_number\":\"\",\"agent_number\":\"\",\"merchant_id\":\"\",\"merchant_key\":\"\",\"merchant_code\":\"\",\"merchant_name\":\"\"}', '2024-12-07 11:37:34', NULL),
(46, 372, 22, 'bkash', 'mobile', 1, '{\"status\":\"1\",\"brand_id\":\"22\",\"active_payments\":{\"personal\":\"1\",\"agent\":\"0\",\"merchant\":\"0\",\"payment\":\"0\"},\"personal_number\":\"01444444444\",\"payment_number\":\"01444444444\",\"agent_number\":\"01444444444\",\"sandbox\":\"0\",\"logs\":\"0\",\"username\":\"\",\"password\":\"\",\"app_key\":\"\",\"app_secret\":\"\"}', '2025-07-01 22:09:59', NULL),
(47, 372, 22, 'nagad', 'mobile', 1, '{\"status\":\"1\",\"brand_id\":\"22\",\"active_payments\":{\"personal\":\"1\",\"agent\":\"0\",\"merchant\":\"0\"},\"personal_number\":\"01444444444\",\"agent_number\":\"01444444444\",\"nagad_mode\":\"live\",\"merchant_id\":\"\",\"private_key\":\"\",\"public_key\":\"\"}', '2025-07-01 22:10:22', NULL),
(48, 372, 22, 'rocket', 'mobile', 1, '{\"status\":\"1\",\"brand_id\":\"22\",\"active_payments\":{\"personal\":\"1\",\"agent\":\"0\"},\"personal_number\":\"01444444444\",\"agent_number\":\"01444444444\",\"merchant_url\":\"\"}', '2025-07-01 22:10:56', NULL),
(49, 372, 22, 'ebl', 'bank', 1, '{\"status\":\"1\",\"bank_account_name\":\"Demo Account\",\"bank_account_number\":\"214577657458656\",\"bank_account_branch_name\":\"Demo Beanch\",\"bank_account_routing_number\":\"12345678\",\"brand_id\":\"22\"}', '2025-07-01 22:14:23', NULL),
(50, 372, 22, 'upay', 'mobile', 1, '{\"status\":\"1\",\"brand_id\":\"22\",\"active_payments\":{\"personal\":\"1\",\"agent\":\"0\",\"merchant\":\"0\"},\"personal_number\":\"01444444444\",\"agent_number\":\"\",\"merchant_id\":\"\",\"merchant_key\":\"\",\"merchant_code\":\"\",\"merchant_name\":\"\"}', '2025-07-08 12:25:04', NULL),
(51, 372, 22, 'cellfin', 'mobile', 1, '{\"status\":\"1\",\"brand_id\":\"22\",\"active_payments\":{\"personal\":\"1\"},\"personal_number\":\"01444444444\",\"agent_number\":\"\",\"merchant_url\":\"\"}', '2025-07-08 12:25:19', NULL),
(52, 372, 22, 'tap', 'mobile', 1, '{\"status\":\"1\",\"brand_id\":\"22\",\"active_payments\":{\"personal\":\"1\",\"agent\":\"0\"},\"personal_number\":\"01444444444\",\"agent_number\":\"\",\"merchant_url\":\"\"}', '2025-07-08 12:25:31', NULL),
(53, 372, 22, 'Ipay', 'mobile', 1, '{\"status\":\"1\",\"brand_id\":\"22\",\"active_payments\":{\"personal\":\"1\"},\"personal_number\":\"01444444444\",\"merchant_url\":\"\"}', '2025-07-08 12:26:10', NULL),
(54, 372, 22, 'okwallet', 'mobile', 1, '{\"status\":\"1\",\"brand_id\":\"22\",\"active_payments\":{\"personal\":\"1\",\"agent\":\"0\"},\"personal_number\":\"01444444444\",\"agent_number\":\"\",\"merchant_url\":\"\"}', '2025-07-08 12:26:19', NULL),
(55, 372, 22, 'surecash', 'mobile', 1, '{\"status\":\"1\",\"brand_id\":\"22\",\"active_payments\":{\"personal\":\"1\",\"agent\":\"0\"},\"personal_number\":\"01444444444\",\"agent_number\":\"\",\"merchant_url\":\"\"}', '2025-07-08 12:26:43', NULL),
(56, 372, 22, 'mcash', 'mobile', 1, '{\"status\":\"1\",\"brand_id\":\"22\",\"active_payments\":{\"personal\":\"1\"},\"personal_number\":\"01444444444\"}', '2025-07-08 12:26:53', NULL),
(57, 372, 22, 'mycash', 'mobile', 1, '{\"status\":\"1\",\"brand_id\":\"22\",\"active_payments\":{\"personal\":\"1\"},\"personal_number\":\"01444444444\"}', '2025-07-08 12:27:02', NULL),
(58, 372, 22, 'ibl', 'bank', 1, '{\"status\":\"1\",\"bank_account_name\":\"Demo\",\"bank_account_number\":\"214576545656\",\"bank_account_branch_name\":\"Demo\",\"bank_account_routing_number\":\"12345678\",\"brand_id\":\"22\"}', '2025-07-08 12:27:30', NULL),
(59, 372, 22, 'citybank', 'bank', 1, '{\"status\":\"1\",\"bank_account_name\":\"Demo\",\"bank_account_number\":\"214576545656\",\"bank_account_branch_name\":\"Demo\",\"bank_account_routing_number\":\"12345678\",\"brand_id\":\"22\"}', '2025-07-08 12:28:35', NULL),
(60, 372, 22, 'binance', 'int_b', 1, '{\"status\":\"1\",\"api_url\":\"https:\\/\\/bpay.binanceapi.com\\/binancepay\\/openapi\\/\",\"api_key\":\"\",\"secret_key\":\"\",\"dollar_rate\":\"128\",\"brand_id\":\"22\",\"active_payments\":{\"personal\":\"1\"}}', '2025-07-08 23:18:54', NULL),
(61, 372, 22, 'payeer', 'int_b', 1, '{\"status\":\"1\",\"enc_key\":\"\",\"account\":\"\",\"client_secret\":\"\",\"user_id\":\"\",\"user_pass\":\"\",\"m_shop\":\"\",\"dollar_rate\":\"128\",\"brand_id\":\"22\",\"active_payments\":{\"personal\":\"1\"}}', '2025-07-08 23:19:04', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_payouts`
--

CREATE TABLE `user_payouts` (
  `id` int UNSIGNED NOT NULL,
  `ids` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `uid` int UNSIGNED NOT NULL,
  `g_type` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `params` text COLLATE utf8mb4_unicode_ci,
  `amount` decimal(10,3) NOT NULL DEFAULT '0.000',
  `charge` decimal(10,3) NOT NULL DEFAULT '0.000',
  `net_amount` decimal(10,3) NOT NULL DEFAULT '0.000',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0=pending,1=initiated,2=success,3=cancel',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_plans`
--

CREATE TABLE `user_plans` (
  `id` int UNSIGNED NOT NULL,
  `uid` int UNSIGNED NOT NULL,
  `plan_id` int NOT NULL,
  `price` decimal(10,3) NOT NULL DEFAULT '0.000',
  `brand` int NOT NULL,
  `device` int NOT NULL,
  `transaction` int NOT NULL,
  `key` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expire` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_plans`
--

INSERT INTO `user_plans` (`id`, `uid`, `plan_id`, `price`, `brand`, `device`, `transaction`, `key`, `expire`, `created_at`, `updated_at`, `deleted_at`) VALUES
(20, 1, 7, 1500.000, 10, 15, -1, '', '2025-12-07 11:17:25', '2024-12-07 11:17:25', '2024-12-07 11:17:25', NULL),
(37, 372, 14, 0.000, 5, 5, -1, '', '2026-07-01 22:05:28', '2025-07-01 22:05:28', '2025-07-01 22:05:28', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_roles`
--

CREATE TABLE `user_roles` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `permissions` text,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `user_roles`
--

INSERT INTO `user_roles` (`id`, `name`, `permissions`, `created_at`) VALUES
(1, 'Admin', '{\"id\":\"14\",\"name\":\"Admin\",\"dashboard_statistics\":\"on\",\"dashboard_bar_chart\":\"on\",\"dashboard_latest_transactions\":\"on\",\"user_access_user\":\"on\",\"user_add_user\":\"on\",\"user_edit_user\":\"on\",\"user_add_fund_user\":\"on\",\"user_send_mail_user\":\"on\",\"user_detail_user\":\"on\",\"user_access_transaction\":\"on\",\"invoice_access_invoice\":\"on\",\"invoice_view_invoice\":\"on\",\"invoice_add_invoice\":\"on\",\"invoice_edit_invoice\":\"on\",\"domain_access_domain\":\"on\",\"domain_edit_domain\":\"on\",\"device_access_device\":\"on\",\"device_edit_device\":\"on\",\"plan_access_plan\":\"on\",\"plan_access_user_plan\":\"on\",\"plan_add_plan\":\"on\",\"plan_edit_plan\":\"on\",\"setting_access_setting\":\"on\",\"setting_access_payment_setting\":\"on\",\"setting_access_faq\":\"on\",\"setting_access_coupon\":\"on\",\"setting_add_coupon\":\"on\",\"setting_edit_coupon\":\"on\",\"setting_access_blog\":\"on\",\"setting_developer\":\"on\",\"setting_access_tickets\":\"on\",\"setting_databackup\":\"on\"}', NULL),
(2, 'Owner', '{\"id\":\"\",\"name\":\"Owner\",\"dashboard_statistics\":\"on\",\"dashboard_bar_chart\":\"on\",\"dashboard_latest_transactions\":\"on\",\"user_access_user\":\"on\",\"user_add_user\":\"on\",\"user_edit_user\":\"on\",\"user_delete_user\":\"on\",\"user_view_user\":\"on\",\"user_add_fund_user\":\"on\",\"user_send_mail_user\":\"on\",\"user_set_password_user\":\"on\",\"user_detail_user\":\"on\",\"user_access_transaction\":\"on\",\"invoice_access_invoice\":\"on\",\"invoice_view_invoice\":\"on\",\"invoice_add_invoice\":\"on\",\"invoice_edit_invoice\":\"on\",\"invoice_delete_invoice\":\"on\",\"domain_access_domain\":\"on\",\"domain_edit_domain\":\"on\",\"domain_delete_domain\":\"on\",\"device_access_device\":\"on\",\"device_edit_device\":\"on\",\"device_delete_device\":\"on\",\"plan_access_plan\":\"on\",\"plan_access_user_plan\":\"on\",\"plan_add_plan\":\"on\",\"plan_edit_plan\":\"on\",\"plan_delete_plan\":\"on\",\"setting_access_setting\":\"on\",\"setting_access_payment_setting\":\"on\",\"setting_access_staff\":\"on\",\"setting_access_role\":\"on\",\"setting_acess_activity\":\"on\",\"setting_access_faq\":\"on\",\"setting_access_coupon\":\"on\",\"setting_add_coupon\":\"on\",\"setting_edit_coupon\":\"on\",\"setting_delete_coupon\":\"on\",\"setting_access_blog\":\"on\",\"setting_developer\":\"on\",\"setting_access_tickets\":\"on\",\"setting_databackup\":\"on\"}', NULL),
(3, 'Support Operator', '{\"id\":\"17\",\"name\":\"Support Operator\",\"user_access_user\":\"on\",\"user_add_user\":\"on\",\"user_add_fund_user\":\"on\",\"invoice_access_invoice\":\"on\",\"invoice_view_invoice\":\"on\",\"invoice_add_invoice\":\"on\",\"domain_access_domain\":\"on\",\"domain_edit_domain\":\"on\",\"device_access_device\":\"on\",\"plan_access_user_plan\":\"on\"}', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_transactions`
--

CREATE TABLE `user_transactions` (
  `id` int UNSIGNED NOT NULL,
  `ids` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `uid` int UNSIGNED NOT NULL,
  `information` text COLLATE utf8mb4_unicode_ci,
  `type` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` decimal(10,3) NOT NULL DEFAULT '0.000',
  `currency` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0=pending,1=initiated,2=success,3=cancel',
  `transaction_id` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_transactions`
--

INSERT INTO `user_transactions` (`id`, `ids`, `uid`, `information`, `type`, `amount`, `currency`, `status`, `transaction_id`, `created_at`, `updated_at`) VALUES
(44, '4712bfd8fba492a0379d6ddea908cf67', 372, '{\"message\":\"Your purchase of plan Free for\\u09f30.00 taka with a discount of \\u09f30.00 is successful\"}', 'plan', 0.000, 'BDT', 2, 'OZ5V3W385928', '2025-07-01 22:05:28', '2025-07-01 22:05:28');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `activity_logs_uid_foreign` (`uid`);

--
-- Indexes for table `addons`
--
ALTER TABLE `addons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_activity_logs`
--
ALTER TABLE `admin_activity_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `admin_activity_logs_uid_foreign` (`uid`);

--
-- Indexes for table `affiliates`
--
ALTER TABLE `affiliates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `affiliates_uid_foreign` (`uid`),
  ADD KEY `affiliates_ref_id_foreign` (`ref_id`);

--
-- Indexes for table `bank_transaction_logs`
--
ALTER TABLE `bank_transaction_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bank_transaction_logs_uid_foreign` (`uid`);

--
-- Indexes for table `blogs`
--
ALTER TABLE `blogs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`),
  ADD KEY `brands_uid_foreign` (`uid`);

--
-- Indexes for table `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `devices`
--
ALTER TABLE `devices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `devices_uid_foreign` (`uid`);

--
-- Indexes for table `faqs`
--
ALTER TABLE `faqs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `file_managers`
--
ALTER TABLE `file_managers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invoice`
--
ALTER TABLE `invoice`
  ADD PRIMARY KEY (`id`),
  ADD KEY `invoice_uid_foreign` (`uid`);

--
-- Indexes for table `kyc`
--
ALTER TABLE `kyc`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kyc_uid_foreign` (`uid`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `module_data`
--
ALTER TABLE `module_data`
  ADD PRIMARY KEY (`id`),
  ADD KEY `module_data_uid_foreign` (`uid`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_uid_foreign` (`uid`);

--
-- Indexes for table `options`
--
ALTER TABLE `options`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `plans`
--
ALTER TABLE `plans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `queue`
--
ALTER TABLE `queue`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `staffs`
--
ALTER TABLE `staffs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ids` (`ids`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `templates`
--
ALTER TABLE `templates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `temp_transactions`
--
ALTER TABLE `temp_transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `temp_transactions_uid_foreign` (`uid`);

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tickets_uid_foreign` (`uid`);

--
-- Indexes for table `ticket_messages`
--
ALTER TABLE `ticket_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transactions_uid_foreign` (`uid`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ids` (`ids`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `phone` (`phone`);

--
-- Indexes for table `user_coupons`
--
ALTER TABLE `user_coupons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_notifier`
--
ALTER TABLE `user_notifier`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_notifier_uid_foreign` (`uid`);

--
-- Indexes for table `user_payment_settings`
--
ALTER TABLE `user_payment_settings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_payment_settings_uid_foreign` (`uid`);

--
-- Indexes for table `user_payouts`
--
ALTER TABLE `user_payouts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_payouts_uid_foreign` (`uid`);

--
-- Indexes for table `user_plans`
--
ALTER TABLE `user_plans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_plans_uid_foreign` (`uid`);

--
-- Indexes for table `user_roles`
--
ALTER TABLE `user_roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_transactions`
--
ALTER TABLE `user_transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_transactions_uid_foreign` (`uid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_logs`
--
ALTER TABLE `activity_logs`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=95;

--
-- AUTO_INCREMENT for table `addons`
--
ALTER TABLE `addons`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `admin_activity_logs`
--
ALTER TABLE `admin_activity_logs`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=118;

--
-- AUTO_INCREMENT for table `affiliates`
--
ALTER TABLE `affiliates`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bank_transaction_logs`
--
ALTER TABLE `bank_transaction_logs`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `blogs`
--
ALTER TABLE `blogs`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `devices`
--
ALTER TABLE `devices`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `faqs`
--
ALTER TABLE `faqs`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `file_managers`
--
ALTER TABLE `file_managers`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT for table `invoice`
--
ALTER TABLE `invoice`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `kyc`
--
ALTER TABLE `kyc`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `module_data`
--
ALTER TABLE `module_data`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `options`
--
ALTER TABLE `options`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=129;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `plans`
--
ALTER TABLE `plans`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `queue`
--
ALTER TABLE `queue`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `staffs`
--
ALTER TABLE `staffs`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `templates`
--
ALTER TABLE `templates`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `temp_transactions`
--
ALTER TABLE `temp_transactions`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=205;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ticket_messages`
--
ALTER TABLE `ticket_messages`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=378;

--
-- AUTO_INCREMENT for table `user_coupons`
--
ALTER TABLE `user_coupons`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_notifier`
--
ALTER TABLE `user_notifier`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_payment_settings`
--
ALTER TABLE `user_payment_settings`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `user_payouts`
--
ALTER TABLE `user_payouts`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_plans`
--
ALTER TABLE `user_plans`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `user_roles`
--
ALTER TABLE `user_roles`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user_transactions`
--
ALTER TABLE `user_transactions`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD CONSTRAINT `activity_logs_uid_foreign` FOREIGN KEY (`uid`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `admin_activity_logs`
--
ALTER TABLE `admin_activity_logs`
  ADD CONSTRAINT `admin_activity_logs_uid_foreign` FOREIGN KEY (`uid`) REFERENCES `staffs` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `affiliates`
--
ALTER TABLE `affiliates`
  ADD CONSTRAINT `affiliates_ref_id_foreign` FOREIGN KEY (`ref_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `affiliates_uid_foreign` FOREIGN KEY (`uid`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `bank_transaction_logs`
--
ALTER TABLE `bank_transaction_logs`
  ADD CONSTRAINT `bank_transaction_logs_uid_foreign` FOREIGN KEY (`uid`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `brands`
--
ALTER TABLE `brands`
  ADD CONSTRAINT `brands_uid_foreign` FOREIGN KEY (`uid`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `devices`
--
ALTER TABLE `devices`
  ADD CONSTRAINT `devices_uid_foreign` FOREIGN KEY (`uid`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `invoice`
--
ALTER TABLE `invoice`
  ADD CONSTRAINT `invoice_uid_foreign` FOREIGN KEY (`uid`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `kyc`
--
ALTER TABLE `kyc`
  ADD CONSTRAINT `kyc_uid_foreign` FOREIGN KEY (`uid`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `module_data`
--
ALTER TABLE `module_data`
  ADD CONSTRAINT `module_data_uid_foreign` FOREIGN KEY (`uid`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_uid_foreign` FOREIGN KEY (`uid`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `temp_transactions`
--
ALTER TABLE `temp_transactions`
  ADD CONSTRAINT `temp_transactions_uid_foreign` FOREIGN KEY (`uid`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tickets`
--
ALTER TABLE `tickets`
  ADD CONSTRAINT `tickets_uid_foreign` FOREIGN KEY (`uid`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_uid_foreign` FOREIGN KEY (`uid`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_notifier`
--
ALTER TABLE `user_notifier`
  ADD CONSTRAINT `user_notifier_uid_foreign` FOREIGN KEY (`uid`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_payment_settings`
--
ALTER TABLE `user_payment_settings`
  ADD CONSTRAINT `user_payment_settings_uid_foreign` FOREIGN KEY (`uid`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_payouts`
--
ALTER TABLE `user_payouts`
  ADD CONSTRAINT `user_payouts_uid_foreign` FOREIGN KEY (`uid`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_plans`
--
ALTER TABLE `user_plans`
  ADD CONSTRAINT `user_plans_uid_foreign` FOREIGN KEY (`uid`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_transactions`
--
ALTER TABLE `user_transactions`
  ADD CONSTRAINT `user_transactions_uid_foreign` FOREIGN KEY (`uid`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
