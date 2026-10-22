-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 22, 2026 at 07:24 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `recipes`
--

-- --------------------------------------------------------

--
-- Table structure for table `recipes`
--

/*CREATE TABLE `recipes` (
  `id` int(11) NOT NULL,
  `title` varchar(120) NOT NULL,
  `description` text DEFAULT NULL,
  `category_id` int(11) NOT NULL,
  `servings` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;*/

--
-- Indexes for dumped tables
--

--
-- Indexes for table `recipes`
--
ALTER TABLE `recipes`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `recipes`
--
ALTER TABLE `recipes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

INSERT INTO recipes
  (title, description, servings)
VALUES(
  'Ancho-Orange Chicken',
  'with Kale Rice & Roasted Carrots',
  4,
)

INSERT INTO recipes
  (title, description, servings)
VALUES(
  'Beef Medallions & Mushroom Sauce',
  'with Mashed Potatoes',
  2,
)

INSERT INTO recipes
  (title, description, servings)
VALUES(
  'Broccoli & Basil Pesto Sandwiches',
  'with Romaine & Citrus Salad',
  4,
)

INSERT INTO recipes
  (title, description, servings)
VALUES(
  'Broccoli & Mozzarella Calzones',
  'with Caesar Salad',
  4,
)

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

