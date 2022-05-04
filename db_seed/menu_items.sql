-- phpMyAdmin SQL Dump
-- version 4.6.6deb5ubuntu0.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 04, 2022 at 06:56 PM
-- Server version: 5.7.35-0ubuntu0.18.04.1
-- PHP Version: 7.4.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `admin_golf`
--

--
-- Dumping data for table `menu_items`
--

INSERT INTO `menu_items` (`id`, `created_at`, `updated_at`, `menu_id`, `title`, `description`, `price`, `active`, `icon`, `parent_id`) VALUES
(1, NULL, NULL, 1, 'Beer', NULL, 0.00, 1, 'beer', NULL),
(3, NULL, NULL, 1, 'Drinks (non-alc)', NULL, 0.00, 1, 'cup', NULL),
(4, '2022-04-25 13:28:42', '2022-04-25 13:28:42', 1, 'Budweiser', NULL, 0.00, 1, 'food', 1),
(5, '2022-04-25 13:28:49', '2022-04-25 13:28:49', 1, 'Bud Light', NULL, 0.00, 1, 'food', 1),
(6, '2022-04-25 13:29:17', '2022-04-25 13:29:17', 1, 'Coolers', NULL, 0.00, 1, 'beer', NULL),
(7, '2022-04-25 13:29:37', '2022-04-25 13:29:37', 1, 'Gin seltzer (sandbagger)', NULL, 0.00, 1, 'food', 6),
(8, '2022-04-25 13:29:50', '2022-04-25 13:29:50', 1, 'Vodka Seltzer (Nutrl Lemon)', NULL, 0.00, 1, 'food', 6),
(9, '2022-04-25 13:30:09', '2022-04-25 13:30:09', 1, 'Bottled Water', NULL, 0.00, 1, 'food', 3),
(10, '2022-04-25 13:30:21', '2022-04-25 13:30:21', 1, 'Gatorade', NULL, 0.00, 1, 'food', 3);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
