-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Oct 18, 2023 at 09:22 AM
-- Server version: 5.7.40
-- PHP Version: 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `car_rental_v3`
--

-- --------------------------------------------------------

--
-- Table structure for table `cars`
--

DROP TABLE IF EXISTS `cars`;
CREATE TABLE IF NOT EXISTS `cars` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `make` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `model` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `year` int(11) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `status` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` bigint(20) NOT NULL,
  `pickup` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pickup_date` timestamp NULL DEFAULT NULL,
  `dropoff_date` timestamp NULL DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `capacity` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cars`
--

INSERT INTO `cars` (`id`, `make`, `model`, `year`, `price`, `status`, `created_at`, `updated_at`, `user_id`, `pickup`, `pickup_date`, `dropoff_date`, `image`, `capacity`) VALUES
(6, 'Tyoyta ', 'Land cruser', 2013, '500.00', 'available', '2023-10-18 06:56:00', '2023-10-18 06:56:00', 10, 'Lusaka', '2023-10-18 07:00:00', '2023-10-22 07:01:00', '../../assets/img/car652f818095334.jpg', 5),
(7, 'Tyoyta ', 'Vits', 2008, '200.00', 'available', '2023-10-18 06:56:52', '2023-10-18 06:56:52', 10, 'CHOMA', '2023-10-18 07:01:00', '2023-10-20 07:01:00', '../../assets/img/car652f81b46dcc7.jpg', 5),
(8, 'Benz', 'couper', 2024, '1000.00', 'available', '2023-10-18 06:57:40', '2023-10-18 06:57:40', 10, 'Kitwe', '2023-10-18 07:02:00', '2023-10-18 07:02:00', '../../assets/img/car652f81e43d1e4.png', 5),
(9, 'Tyoyta ', 'Runix', 2006, '250.00', 'available', '2023-10-18 06:58:37', '2023-10-18 06:58:37', 10, 'Kabwe', '2023-10-18 07:02:00', '2023-10-21 07:02:00', '../../assets/img/car652f821d34666.jpg', 5),
(10, 'Tyoyta ', 'Runix', 2004, '250.00', 'available', '2023-10-18 06:59:16', '2023-10-18 06:59:16', 10, 'Lusaka', '2023-10-20 07:02:00', '2023-10-29 07:02:00', '../../assets/img/car652f824422713.jpg', 5);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `car_id` bigint(20) UNSIGNED NOT NULL,
  `pickup_date` date NOT NULL,
  `dropoff_date` date NOT NULL,
  `total_cost` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT 'pending',
  PRIMARY KEY (`id`),
  KEY `bookings_user_id_foreign` (`user_id`),
  KEY `bookings_car_id_foreign` (`car_id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `car_id`, `pickup_date`, `dropoff_date`, `total_cost`, `created_at`, `updated_at`, `status`) VALUES
(1, 1, 4, '2023-10-14', '2023-10-16', '5000.00', '2023-10-14 18:55:58', '2023-10-14 18:55:58', 'pending'),
(4, 6, 4, '1976-07-07', '1990-04-18', '1061963.00', NULL, NULL, 'pending'),
(5, 2, 4, '1977-08-28', '1979-05-27', '134407.00', NULL, NULL, 'pending'),
(7, 1, 2, '2023-10-17', '2023-10-19', '632.00', NULL, NULL, 'approved'),
(8, 1, 4, '2023-10-18', '2023-10-27', '1899.00', NULL, NULL, 'approved'),
(9, 1, 5, '2023-10-20', '2023-10-24', '2744.00', NULL, NULL, 'pending'),
(10, 9, 10, '2023-10-18', '2023-10-19', '250.00', NULL, NULL, 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `role` enum('user','admin','staff') NOT NULL DEFAULT 'user',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `phone` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `password`, `email`, `role`, `created_at`, `updated_at`, `phone`) VALUES
(1, 'Lubomba Mulomya', '$2y$10$1jwWtcJuxtVJeMAsFIWJPuzeh3XxRDQ16c/Aniji/sluow.28HQLu', 'lumastech@gmail.com', 'admin', '2023-10-15 10:35:52', '2023-10-15 10:40:49', NULL),
(2, 'Desirae Espinoza', '$2y$10$6d7P349.uGwgEffOI65gheaKmmmfvJlyRanOITrxkuKCY4Izjv1c.', 'zyky@mailinator.com', 'user', '2023-10-15 12:38:43', '2023-10-15 12:38:43', '0971864421'),
(5, 'Bruce Erickson', '$2y$10$i3oTFkX81vg1FG2FoQPtLu79nM04OirerjbDLU7N1CwcRJsTiOpYS', 'cohytu@mailinator.com', 'user', '2023-10-15 13:17:25', '2023-10-15 13:17:25', '0971864421'),
(6, 'Phelan Guerra', '$2y$10$8sqAT/s6YU1LziAFtIff3eCKlGBztywQoLjfNSwKEYCEd6.imnUhy', 'padejozewa@mailinator.com', 'user', '2023-10-15 13:17:36', '2023-10-15 13:17:36', '0971864421'),
(7, 'Kyra Pittman', '$2y$10$i2H2b9ZE8sKh7U62PXDjKuC3xuKnWaiVoxJDvaT6P2lWrhkITCZ2.', 'lody@mailinator.com', 'user', '2023-10-15 13:17:46', '2023-10-15 13:17:46', '0971864421'),
(8, 'Hector Marsh', '$2y$10$WK7f.OBwAxSOEqX2hPxTluCCAyRnbg0aNZyAA.pEsT78wPJbLeROi', 'paxyzefiry@mailinator.com', 'user', '2023-10-17 12:03:47', '2023-10-17 12:03:47', NULL),
(9, 'Admin', '$2y$10$rAX5hf.IzMKgZ1chwUOhi.q9wvuJJuPijfUmkB0KAqFeYcZY1Xcym', 'admin@gmail.com', 'admin', '2023-10-17 16:47:52', '2023-10-17 16:47:52', '0971864421'),
(10, 'Quon Duke', '$2y$10$kU0McrM2WFZmJbv4ZSsyo.3Ny7clZzoLFyHqkkT7ikTy9mLHhBlv.', 'sujosym@mailinator.com', 'user', '2023-10-17 16:49:30', '2023-10-17 16:49:30', '0971864421'),
(11, 'Carol Lambert', '$2y$10$DXrlcNRJLxV9IwTCq3JbQOCL3Cyw0iNMbA6pp.hxSaHMkqU3im2M6', 'wogihegiqa@mailinator.com', 'user', '2023-10-17 17:00:45', '2023-10-17 17:00:45', '0971864421');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
