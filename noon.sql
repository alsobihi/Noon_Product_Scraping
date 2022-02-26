-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 26, 2022 at 10:28 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `noon`
--

-- --------------------------------------------------------

--
-- Table structure for table `noon_offer`
--

CREATE TABLE `noon_offer` (
  `id` int(11) NOT NULL,
  `sku` varchar(255) NOT NULL,
  `product_title` varchar(255) NOT NULL,
  `product_title_ar` varchar(255) DEFAULT NULL,
  `brand` varchar(255) NOT NULL,
  `brand_ar` varchar(255) DEFAULT NULL,
  `zsku` varchar(255) DEFAULT NULL,
  `long_description` text DEFAULT NULL,
  `long_description_ar` text DEFAULT NULL,
  `feature_bullets` text DEFAULT NULL,
  `feature_bullets_ar` text DEFAULT NULL,
  `offer_code` varchar(255) DEFAULT NULL,
  `price` float DEFAULT NULL,
  `sale_price` float DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `id_product_fulltype` int(11) DEFAULT NULL,
  `authentic_seller` tinyint(1) DEFAULT NULL,
  `stock` int(11) DEFAULT NULL,
  `offer_stock_net` int(11) DEFAULT NULL,
  `is_fbn` int(11) DEFAULT NULL,
  `is_bestseller` tinyint(1) DEFAULT NULL,
  `store_name` varchar(255) DEFAULT NULL,
  `store_code` varchar(255) DEFAULT NULL,
  `partner_code` varchar(255) DEFAULT NULL,
  `note` text DEFAULT NULL,
  `colour_name` varchar(255) DEFAULT NULL,
  `colour_name_ar` varchar(255) DEFAULT NULL,
  `size` varchar(255) DEFAULT NULL,
  `size_ar` varchar(255) DEFAULT NULL,
  `whats_in_the_box` varchar(255) DEFAULT NULL,
  `whats_in_the_box_ar` varchar(255) DEFAULT NULL,
  `model_number` varchar(255) DEFAULT NULL,
  `model_name` varchar(255) DEFAULT NULL,
  `number_of_pieces` int(11) DEFAULT NULL,
  `country_of_origin` varchar(255) DEFAULT NULL,
  `country_of_origin_ar` varchar(255) DEFAULT NULL,
  `category_code` varchar(255) DEFAULT NULL,
  `timestamp` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `noon_offer`
--
ALTER TABLE `noon_offer`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `noon_offer`
--
ALTER TABLE `noon_offer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
