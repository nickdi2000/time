-- phpMyAdmin SQL Dump
-- version 4.6.6deb5ubuntu0.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 04, 2022 at 06:55 PM
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
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `created_at`, `updated_at`, `course_id`, `user_type`) VALUES
(1, 'John Smith', 'nickdifelice@gmail.com', '$2y$10$.xlJI2BAWu9Q6L6f9B370OCxmZXFdhYOKs4YkQkoAiEv.IR0OfFNm', NULL, NULL, 1, 3),
(2, 'Freddy Super Admin', 'freddy', '$2y$10$DJW.BuCFbat0IIigOuuM7OC9YnYcQW2l08XW.m9ymM.khWBH/92ty', NULL, NULL, 570, 3),
(3, 'Mr Copper', 'copper@19th.live', '$2y$10$bAWmhe2RniDOpTevHEfJru6WAndLlMjO.aLitz2Tg6mCoE9uO/hYW', '2022-04-11 12:33:42', '2022-04-11 12:33:42', 63, 1),
(4, 'Stacie', 'stacie@19th.live', '$2y$10$n0Hjmu5iAZGL5P5BjnO1wO7FxbttrxNDJ7hCo3LyCP75dLHIYZ6D6', '2022-04-15 07:07:04', '2022-04-15 07:07:04', 442, 1),
(5, 'Brady', 'brady@19th.live', '$2y$10$0U8AyA3udD3C6ItYD/4bHeeao7HcXfcqEi217iUiWi76CJuPXpO42', '2022-04-29 16:47:37', '2022-04-29 16:47:37', 715, 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
