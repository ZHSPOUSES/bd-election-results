-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: sql111.infinityfree.com
-- Generation Time: Feb 15, 2026 at 01:19 PM
-- Server version: 11.4.10-MariaDB
-- PHP Version: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `if0_38014675_app`
--

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `id` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `content` text DEFAULT NULL,
  `excerpt` text DEFAULT NULL,
  `category` varchar(50) DEFAULT NULL,
  `tags` text DEFAULT NULL,
  `status` enum('published','draft') DEFAULT 'draft',
  `views` int(11) DEFAULT 0,
  `published_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `parties`
--

CREATE TABLE `parties` (
  `id` int(11) NOT NULL,
  `party_name` varchar(100) NOT NULL,
  `symbol` varchar(50) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `parties`
--

INSERT INTO `parties` (`id`, `party_name`, `symbol`, `created_at`) VALUES
(1, 'ধানের শীষ', '🌾', '2026-02-12 13:48:52'),
(2, 'দাড়ি পাল্লা', '🧔⚖️', '2026-02-12 13:48:52');

-- --------------------------------------------------------

--
-- Table structure for table `portfolio`
--

CREATE TABLE `portfolio` (
  `id` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `description` text DEFAULT NULL,
  `category` varchar(50) DEFAULT NULL,
  `client_name` varchar(100) DEFAULT NULL,
  `completion_date` date DEFAULT NULL,
  `project_url` varchar(255) DEFAULT NULL,
  `featured_image` varchar(255) DEFAULT NULL,
  `technologies` text DEFAULT NULL,
  `status` enum('active','draft') DEFAULT 'active',
  `sort_order` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `description` text DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `status` enum('planning','in_progress','completed') DEFAULT 'planning',
  `progress` int(11) DEFAULT 0,
  `priority` enum('low','medium','high') DEFAULT 'medium',
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `seats`
--

CREATE TABLE `seats` (
  `id` int(11) NOT NULL,
  `seat_name` varchar(100) NOT NULL,
  `district` varchar(100) NOT NULL,
  `seat_number` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `seats`
--

INSERT INTO `seats` (`id`, `seat_name`, `district`, `seat_number`, `created_at`) VALUES
(6, 'দিনাজপুর-৬', 'দিনাজপুর', 6, '2026-02-12 13:48:52');

-- --------------------------------------------------------

--
-- Table structure for table `team`
--

CREATE TABLE `team` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `position` varchar(100) DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `department` varchar(50) DEFAULT NULL,
  `skills` text DEFAULT NULL,
  `join_date` date DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `full_name` varchar(100) DEFAULT NULL,
  `role` enum('admin','editor') DEFAULT 'admin',
  `last_login` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `full_name`, `role`, `last_login`, `created_at`) VALUES
(1, 'admin', '$2y$10$vllS5Edoau0s.EBxOh/p1.Wvi61yfNgiv.L4Z5p8HPTR5XsK70fBm', 'admin@zhsoftware.com', 'Administrator', 'admin', NULL, '2026-02-12 14:39:12');

-- --------------------------------------------------------

--
-- Table structure for table `vote_results`
--

CREATE TABLE `vote_results` (
  `id` int(11) NOT NULL,
  `seat_id` int(11) NOT NULL,
  `area_name` varchar(255) NOT NULL,
  `area_type` varchar(50) DEFAULT 'উপজেলা',
  `party1_id` int(11) NOT NULL,
  `party1_votes` int(11) DEFAULT 0,
  `party2_id` int(11) NOT NULL,
  `party2_votes` int(11) DEFAULT 0,
  `entry_date` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vote_results`
--

INSERT INTO `vote_results` (`id`, `seat_id`, `area_name`, `area_type`, `party1_id`, `party1_votes`, `party2_id`, `party2_votes`, `entry_date`) VALUES
(65, 6, 'ঘোড়ার ঘাট স ক', 'সরকারি কলেজ', 1, 875, 2, 844, '2026-02-12 14:26:08'),
(66, 6, 'চতুরপুর দা মা', 'দাখিল মাদ্রাসা', 1, 831, 2, 654, '2026-02-12 14:26:08'),
(67, 6, 'হিলি চকচকা', 'গ্রাম', 1, 700, 2, 1101, '2026-02-12 14:26:08'),
(68, 6, 'রতনপুর স প্রা', 'সরকারি প্রাথমিক বিদ্যালয়', 1, 713, 2, 387, '2026-02-12 14:26:08'),
(69, 6, 'দেবীপুর', 'গ্রাম', 1, 1260, 2, 970, '2026-02-12 14:26:08'),
(70, 6, 'বিজুল মা', 'মাদ্রাসা', 1, 665, 2, 942, '2026-02-12 14:26:08'),
(71, 6, 'কাটলা (দাউদপুর)', 'গ্রাম', 1, 1279, 2, 1215, '2026-02-12 14:26:08'),
(72, 6, 'হিলি (বাশমুড়ি উ চ)', 'উচ্চ বিদ্যালয়', 1, 477, 2, 876, '2026-02-12 14:26:08'),
(73, 6, 'নবাবগঞ্জ গরিবপাড়া', 'গ্রাম', 1, 1481, 2, 2121, '2026-02-12 14:26:08'),
(74, 6, 'বিরামপুর পৌরসভা ওয়ার্ড ৩', 'পৌরসভা', 1, 1927, 2, 1791, '2026-02-12 14:26:08'),
(75, 6, 'মহিহারা বাজার', 'বাজার', 1, 3000, 2, 600, '2026-02-12 14:26:09'),
(76, 6, 'হরিহরপুর (নবাবগঞ্জ)', 'গ্রাম', 1, 1617, 2, 900, '2026-02-12 14:26:09'),
(77, 6, 'বড় মহেশপুর', 'গ্রাম', 1, 910, 2, 721, '2026-02-12 14:26:09'),
(78, 6, 'বিরামপুর (ওয়ার্ড - ১)', 'পৌরসভা', 1, 1260, 2, 970, '2026-02-12 14:26:09'),
(79, 6, 'পলিপ্রাকপুর', 'গ্রাম', 1, 761, 2, 783, '2026-02-12 14:26:09'),
(80, 6, 'খিয়ারমামুদপুর', 'গ্রাম', 1, 742, 2, 378, '2026-02-12 14:26:09'),
(81, 6, 'লোকা দি উ বিদ্যা', 'উচ্চ বিদ্যালয়', 1, 1684, 2, 993, '2026-02-12 14:26:09'),
(82, 6, 'মহেশপুর উ বি', 'উচ্চ বিদ্যালয়', 1, 944, 2, 957, '2026-02-12 14:26:09'),
(83, 6, 'শিয়ালা', 'গ্রাম', 1, 741, 2, 1025, '2026-02-12 14:26:09'),
(84, 6, 'বিজুল', 'গ্রাম', 1, 665, 2, 942, '2026-02-12 14:26:09'),
(85, 6, 'নন্দীপুর', 'গ্রাম', 1, 609, 2, 453, '2026-02-12 14:26:09'),
(86, 6, 'বিনেদেনগর (নবাবগঞ্জ)', 'গ্রাম', 1, 480, 2, 875, '2026-02-12 14:26:09'),
(87, 6, 'হেময়েতপুর (নবাবগঞ্জ)', 'গ্রাম', 1, 800, 2, 1600, '2026-02-12 14:26:09'),
(88, 6, 'হিলি (বাংলাহিলি-২)', 'গ্রাম', 1, 1078, 2, 775, '2026-02-12 14:26:09'),
(89, 6, 'বিরামপুর স প্রা বি', 'সরকারি প্রাথমিক বিদ্যালয়', 1, 1082, 2, 724, '2026-02-12 14:26:09'),
(90, 6, 'গাঙ্গাপুর উচ্চ বিদ্যালয়', 'উচ্চ বিদ্যালয়', 1, 752, 2, 1123, '2026-02-12 14:26:09'),
(91, 6, 'খয়েরপাড়া স প্রা', 'সরকারি প্রাথমিক বিদ্যালয়', 1, 705, 2, 522, '2026-02-12 14:26:09'),
(92, 6, 'লালমাটি বিরামপুর', 'গ্রাম', 1, 689, 2, 854, '2026-02-12 14:26:09'),
(93, 6, 'ঘোড়াঘাট দামদারপুর', 'গ্রাম', 1, 728, 2, 817, '2026-02-12 14:26:09'),
(94, 6, 'ঢেলুপাড়া স প্রা বি', 'সরকারি প্রাথমিক বিদ্যালয়', 1, 1051, 2, 1055, '2026-02-12 14:26:09'),
(95, 6, 'কাটলা ডিগ্রি কলেজ', 'কলেজ', 1, 1714, 2, 1413, '2026-02-12 14:26:09'),
(96, 6, 'কাটলা হাই স্কুল', 'হাই স্কুল', 1, 1860, 2, 1512, '2026-02-12 14:26:09'),
(97, 6, 'মতিহারা উচ্চ বি', 'উচ্চ বিদ্যালয়', 1, 1540, 2, 300, '2026-02-12 14:26:09'),
(98, 6, 'চকহরিদাশপুর', 'গ্রাম', 1, 1242, 2, 1160, '2026-02-12 14:26:09'),
(99, 6, 'বিরামপুর পৌর (ওয়ার্ড)', 'পৌরসভা', 1, 1082, 2, 728, '2026-02-12 14:26:09'),
(100, 6, 'পাউশগাড়া', 'গ্রাম', 1, 1460, 2, 1724, '2026-02-12 14:26:09'),
(101, 6, 'বাশুপাড়া', 'গ্রাম', 1, 967, 2, 327, '2026-02-12 14:26:09'),
(102, 6, 'বিরামপুর শান্তিন্যায়', 'গ্রাম', 1, 1314, 2, 1479, '2026-02-12 14:26:09'),
(103, 6, 'হিলি দৃবদাবন', 'গ্রাম', 1, 979, 2, 1373, '2026-02-12 14:26:09'),
(104, 6, 'সাতকুড়ি', 'গ্রাম', 1, 940, 2, 1400, '2026-02-12 14:26:09'),
(105, 6, 'ঘোড়ারঘাট দাখিল মা', 'দাখিল মাদ্রাসা', 1, 1340, 2, 1334, '2026-02-12 14:26:09'),
(106, 6, 'বিনাইল উচ্চ বি', 'উচ্চ বিদ্যালয়', 1, 639, 2, 754, '2026-02-12 14:26:09'),
(107, 6, 'জালালপুর', 'গ্রাম', 1, 1536, 2, 9, '2026-02-12 14:26:09'),
(108, 6, 'ঘোড়ার ঘাট স ক', 'সরকারি কলেজ', 1, 875, 2, 844, '2026-02-12 14:26:14'),
(109, 6, 'চতুরপুর দা মা', 'দাখিল মাদ্রাসা', 1, 831, 2, 654, '2026-02-12 14:26:14'),
(110, 6, 'হিলি চকচকা', 'গ্রাম', 1, 700, 2, 1101, '2026-02-12 14:26:14'),
(111, 6, 'রতনপুর স প্রা', 'সরকারি প্রাথমিক বিদ্যালয়', 1, 713, 2, 387, '2026-02-12 14:26:14'),
(112, 6, 'দেবীপুর', 'গ্রাম', 1, 1260, 2, 970, '2026-02-12 14:26:14'),
(113, 6, 'বিজুল মা', 'মাদ্রাসা', 1, 665, 2, 942, '2026-02-12 14:26:14'),
(114, 6, 'কাটলা (দাউদপুর)', 'গ্রাম', 1, 1279, 2, 1215, '2026-02-12 14:26:14'),
(115, 6, 'হিলি (বাশমুড়ি উ চ)', 'উচ্চ বিদ্যালয়', 1, 477, 2, 876, '2026-02-12 14:26:14'),
(116, 6, 'নবাবগঞ্জ গরিবপাড়া', 'গ্রাম', 1, 1481, 2, 2121, '2026-02-12 14:26:14'),
(117, 6, 'বিরামপুর পৌরসভা ওয়ার্ড ৩', 'পৌরসভা', 1, 1927, 2, 1791, '2026-02-12 14:26:14'),
(118, 6, 'মহিহারা বাজার', 'বাজার', 1, 3000, 2, 600, '2026-02-12 14:26:14'),
(119, 6, 'হরিহরপুর (নবাবগঞ্জ)', 'গ্রাম', 1, 1617, 2, 900, '2026-02-12 14:26:14'),
(120, 6, 'বড় মহেশপুর', 'গ্রাম', 1, 910, 2, 721, '2026-02-12 14:26:14'),
(121, 6, 'বিরামপুর (ওয়ার্ড - ১)', 'পৌরসভা', 1, 1260, 2, 970, '2026-02-12 14:26:14'),
(122, 6, 'পলিপ্রাকপুর', 'গ্রাম', 1, 761, 2, 783, '2026-02-12 14:26:14'),
(123, 6, 'খিয়ারমামুদপুর', 'গ্রাম', 1, 967, 2, 327, '2026-02-12 14:26:14'),
(124, 6, 'লোকা দি উ বিদ্যা', 'উচ্চ বিদ্যালয়', 1, 1684, 2, 993, '2026-02-12 14:26:14'),
(125, 6, 'মহেশপুর উ বি', 'উচ্চ বিদ্যালয়', 1, 944, 2, 957, '2026-02-12 14:26:14'),
(126, 6, 'শিয়ালা', 'গ্রাম', 1, 741, 2, 1025, '2026-02-12 14:26:14'),
(127, 6, 'বিজুল', 'গ্রাম', 1, 665, 2, 942, '2026-02-12 14:26:14'),
(128, 6, 'নন্দীপুর', 'গ্রাম', 1, 609, 2, 453, '2026-02-12 14:26:14'),
(129, 6, 'বিনেদেনগর (নবাবগঞ্জ)', 'গ্রাম', 1, 480, 2, 875, '2026-02-12 14:26:14'),
(130, 6, 'হেময়েতপুর (নবাবগঞ্জ)', 'গ্রাম', 1, 800, 2, 1600, '2026-02-12 14:26:14'),
(131, 6, 'হিলি (বাংলাহিলি-২)', 'গ্রাম', 1, 1078, 2, 775, '2026-02-12 14:26:14'),
(132, 6, 'বিরামপুর স প্রা বি', 'সরকারি প্রাথমিক বিদ্যালয়', 1, 1082, 2, 724, '2026-02-12 14:26:14'),
(133, 6, 'গাঙ্গাপুর উচ্চ বিদ্যালয়', 'উচ্চ বিদ্যালয়', 1, 752, 2, 1123, '2026-02-12 14:26:14'),
(134, 6, 'খয়েরপাড়া স প্রা', 'সরকারি প্রাথমিক বিদ্যালয়', 1, 705, 2, 522, '2026-02-12 14:26:14'),
(135, 6, 'লালমাটি বিরামপুর', 'গ্রাম', 1, 689, 2, 854, '2026-02-12 14:26:14'),
(136, 6, 'ঘোড়াঘাট দামদারপুর', 'গ্রাম', 1, 728, 2, 817, '2026-02-12 14:26:14'),
(137, 6, 'ঢেলুপাড়া স প্রা বি', 'সরকারি প্রাথমিক বিদ্যালয়', 1, 1051, 2, 1055, '2026-02-12 14:26:14'),
(138, 6, 'কাটলা ডিগ্রি কলেজ', 'কলেজ', 1, 1714, 2, 1413, '2026-02-12 14:26:14'),
(139, 6, 'কাটলা হাই স্কুল', 'হাই স্কুল', 1, 1860, 2, 1512, '2026-02-12 14:26:14'),
(140, 6, 'মতিহারা উচ্চ বি', 'উচ্চ বিদ্যালয়', 1, 1540, 2, 300, '2026-02-12 14:26:14'),
(141, 6, 'চকহরিদাশপুর', 'গ্রাম', 1, 1242, 2, 1160, '2026-02-12 14:26:14'),
(142, 6, 'বিরামপুর পৌর (ওয়ার্ড)', 'পৌরসভা', 1, 1082, 2, 728, '2026-02-12 14:26:14'),
(143, 6, 'পাউশগাড়া', 'গ্রাম', 1, 1460, 2, 1724, '2026-02-12 14:26:14'),
(144, 6, 'বাশুপাড়া', 'গ্রাম', 1, 967, 2, 327, '2026-02-12 14:26:14'),
(145, 6, 'বিরামপুর শান্তিন্যায়', 'গ্রাম', 1, 1314, 2, 1479, '2026-02-12 14:26:14'),
(146, 6, 'হিলি দৃবদাবন', 'গ্রাম', 1, 979, 2, 1373, '2026-02-12 14:26:14'),
(147, 6, 'সাতকুড়ি', 'গ্রাম', 1, 940, 2, 1400, '2026-02-12 14:26:14'),
(148, 6, 'ঘোড়ারঘাট দাখিল মা', 'দাখিল মাদ্রাসা', 1, 1340, 2, 1334, '2026-02-12 14:26:14'),
(149, 6, 'বিনাইল উচ্চ বি', 'উচ্চ বিদ্যালয়', 1, 639, 2, 754, '2026-02-12 14:26:14'),
(150, 6, 'জালালপুর', 'গ্রাম', 1, 1536, 2, 9, '2026-02-12 14:26:14'),
(151, 6, 'গঙ্গাপুর সরকারী প্রাথমিক বিদ্যালয়', 'ইউনিয়ন', 1, 1507, 2, 2271, '2026-02-12 14:29:49'),
(152, 6, 'হাবিবপুর উচ্চ বিদ্যালয় ( পুরুষ )', 'উপজেলা', 1, 754, 2, 961, '2026-02-12 14:30:46'),
(153, 6, 'হাবিবপুর উচ্চ বিদ্যালয়', 'উপজেলা', 1, 754, 2, 961, '2026-02-12 14:32:22'),
(154, 6, 'হিলি চক হরিদাস পুড়', 'উপজেলা', 1, 1242, 2, 1160, '2026-02-12 14:33:08'),
(155, 6, 'মুরাদপুর সরকারী প্রা বি', 'উপজেলা', 1, 1318, 2, 1001, '2026-02-12 14:33:34'),
(156, 6, 'মির্যাপুর চৌধুরি পাড়া', 'উপজেলা', 1, 863, 2, 1030, '2026-02-12 14:34:42'),
(157, 6, 'ডুকডুগি  স . প্রা', 'উপজেলা', 1, 734, 2, 1239, '2026-02-12 14:37:02'),
(158, 6, 'ঘোরারঘাট উত্তর জয়দেব পুড়', 'উপজেলা', 1, 816, 2, 1586, '2026-02-12 14:38:19'),
(159, 6, 'হিলি আলিহাট মাদ্রাসা', 'উপজেলা', 1, 1034, 2, 1101, '2026-02-12 14:48:41'),
(160, 6, 'চৌধু্রী দাঙ্গাপাড়া', 'উপজেলা', 1, 2642, 2, 3606, '2026-02-12 14:53:51'),
(161, 6, 'চাতনী', 'উপজেলা', 1, 979, 2, 1373, '2026-02-12 14:54:10'),
(162, 6, 'পাউশগড়া প্রাইমেরি', 'উপজেলা', 1, 1182, 2, 1885, '2026-02-12 14:55:04'),
(163, 6, 'চকচকা আলিম মাদ্রাসা', 'উপজেলা', 1, 518, 2, 1168, '2026-02-12 14:56:45'),
(164, 6, 'হবিবপুর ছিদ্দিকিয়া মাদ্রাসা', 'উপজেলা', 1, 875, 2, 1152, '2026-02-12 14:59:00'),
(165, 6, 'মহিলা কলেজ', 'উপজেলা', 1, 580, 2, 489, '2026-02-12 15:00:20'),
(166, 6, 'হিলি বাশমড়ি উচ্চ বিদ্যালয়', 'উপজেলা', 1, 477, 2, 876, '2026-02-12 15:01:03'),
(167, 6, 'চেংগ্রাম সরকারী প্রা . বি', 'উপজেলা', 1, 1230, 2, 1900, '2026-02-12 15:01:46'),
(168, 6, 'ভাদুরিয়া বাজার', 'উপজেলা', 1, 1307, 2, 1045, '2026-02-12 15:02:41'),
(169, 6, 'শাল্টিমুরাদপুড়', 'উপজেলা', 1, 1518, 2, 1879, '2026-02-12 15:04:41'),
(170, 6, 'হাকিমপুর ডিগ্রি কলেজ', 'উপজেলা', 1, 2078, 2, 1474, '2026-02-12 15:05:10'),
(171, 6, 'বানোরা', 'উপজেলা', 1, 1265, 2, 654, '2026-02-12 15:07:06'),
(172, 6, 'বিরামপুর ৯ং ওয়ার্ড মনিরামঅপুর', 'উপজেলা', 1, 1051, 2, 1055, '2026-02-12 15:19:47'),
(173, 6, 'পলাশবাড়ি', 'উপজেলা', 1, 1863, 2, 977, '2026-02-12 15:21:51'),
(174, 6, 'হাকিম্পুর হরিপুর', 'উপজেলা', 1, 1594, 2, 2451, '2026-02-12 15:22:40'),
(175, 6, 'বুয়ালমারি', 'উপজেলা', 1, 836, 2, 907, '2026-02-12 15:23:27'),
(176, 6, 'জয়দেবপুর উদয় স্কুল', 'উপজেলা', 1, 1816, 2, 1586, '2026-02-12 15:24:00'),
(177, 6, 'কানাগাড়ি', 'উপজেলা', 1, 1462, 2, 1018, '2026-02-12 15:24:34'),
(178, 6, 'কেজি স্কুল', 'উপজেলা', 1, 777, 2, 688, '2026-02-12 15:25:11'),
(179, 6, 'হেলেঞ্চা', 'উপজেলা', 1, 1056, 2, 1154, '2026-02-12 15:25:38'),
(180, 6, 'উত্তর দেবিপুর', 'উপজেলা', 1, 760, 2, 790, '2026-02-12 15:26:19'),
(181, 6, 'খয়ের খনি', 'উপজেলা', 1, 1319, 2, 1503, '2026-02-12 15:27:28'),
(182, 6, 'বুজবুকহরিনা', 'উপজেলা', 1, 673, 2, 508, '2026-02-12 15:28:03'),
(183, 6, 'শৌলা', 'উপজেলা', 1, 724, 2, 817, '2026-02-12 15:28:21'),
(184, 6, 'বাজিতপুর', 'উপজেলা', 1, 1449, 2, 1089, '2026-02-12 15:29:41'),
(185, 6, 'খয়েরগুনি', 'উপজেলা', 1, 1309, 2, 1503, '2026-02-12 15:30:17'),
(186, 6, 'দেওগা', 'উপজেলা', 1, 726, 2, 650, '2026-02-12 15:31:35'),
(187, 6, 'শিমুর', 'উপজেলা', 1, 960, 2, 1281, '2026-02-12 15:32:00'),
(188, 6, 'রাঘোবিন্দোপুড়', 'উপজেলা', 1, 900, 2, 1300, '2026-02-12 15:33:32'),
(189, 6, 'মনসাপুর', 'উপজেলা', 1, 500, 2, 900, '2026-02-12 15:35:37'),
(190, 6, 'হিলি নয়ানগর', 'উপজেলা', 1, 1311, 2, 1881, '2026-02-12 15:36:00'),
(191, 6, 'ঘাসুড়িয়া', 'উপজেলা', 1, 609, 2, 453, '2026-02-12 15:36:31'),
(192, 6, 'বারুনি', 'উপজেলা', 1, 871, 2, 1913, '2026-02-12 15:37:22'),
(193, 6, 'কাঠালপাড়া', 'উপজেলা', 1, 1713, 2, 1806, '2026-02-12 15:37:57'),
(194, 6, 'মুকুন্দপুর', 'উপজেলা', 1, 765, 2, 975, '2026-02-12 15:54:10'),
(195, 6, 'বিরামপুর শান্তি নগর', 'উপজেলা', 1, 1314, 2, 1479, '2026-02-12 15:56:33'),
(196, 6, 'একইর মঙ্গলপুর', 'উপজেলা', 1, 945, 2, 1173, '2026-02-12 15:58:20'),
(197, 6, 'গংগাদাসপুর নিম্ন মাধ্যমিক বিদ্যালয়', 'ইউনিয়ন', 1, 799, 2, 432, '2026-02-12 16:00:56'),
(198, 6, 'ঘোড়াঘাট সাহেবগঞ্জ', 'উপজেলা', 1, 1028, 2, 1091, '2026-02-12 16:04:40'),
(199, 6, 'কেটরা উচ্চ বিদ্যালয়', 'উপজেলা', 1, 1165, 2, 835, '2026-02-12 16:13:52'),
(200, 6, 'রামকৃষ্ণপুর উচ্চ বিদ্যালয়', 'উপজেলা', 1, 814, 2, 667, '2026-02-12 16:14:45'),
(201, 6, 'বিনাইল  পুরুষ', 'উপজেলা', 1, 1361, 2, 1488, '2026-02-12 16:20:45'),
(202, 6, 'শিবপুর উচ্চ বিদ্যালয় মহিলা', 'উপজেলা', 1, 826, 2, 940, '2026-02-12 16:22:18');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `parties`
--
ALTER TABLE `parties`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `portfolio`
--
ALTER TABLE `portfolio`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `seats`
--
ALTER TABLE `seats`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `team`
--
ALTER TABLE `team`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `vote_results`
--
ALTER TABLE `vote_results`
  ADD PRIMARY KEY (`id`),
  ADD KEY `seat_id` (`seat_id`),
  ADD KEY `party1_id` (`party1_id`),
  ADD KEY `party2_id` (`party2_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `parties`
--
ALTER TABLE `parties`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `portfolio`
--
ALTER TABLE `portfolio`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `seats`
--
ALTER TABLE `seats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `team`
--
ALTER TABLE `team`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `vote_results`
--
ALTER TABLE `vote_results`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=203;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `vote_results`
--
ALTER TABLE `vote_results`
  ADD CONSTRAINT `vote_results_ibfk_1` FOREIGN KEY (`seat_id`) REFERENCES `seats` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `vote_results_ibfk_2` FOREIGN KEY (`party1_id`) REFERENCES `parties` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `vote_results_ibfk_3` FOREIGN KEY (`party2_id`) REFERENCES `parties` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
