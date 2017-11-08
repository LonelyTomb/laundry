-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 08, 2017 at 04:51 PM
-- Server version: 5.7.20-0ubuntu0.17.10.1
-- PHP Version: 7.1.8-1ubuntu1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `washman`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `name` varchar(10) NOT NULL,
  `email` varchar(25) NOT NULL,
  `password` varchar(255) NOT NULL,
  `mailReceiver` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `name`, `email`, `password`, `mailReceiver`) VALUES
(1, 'Washman', 'washman@admin.com', '$2y$10$7NcvuT9f2xVjAV/Z1KGraO1pmBOmyeRJsiJ3Yx09myqT/ZQ/NHg0y', 1);

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`) VALUES
(1, 'men'),
(2, 'ladies'),
(3, 'household');

-- --------------------------------------------------------

--
-- Table structure for table `checkout_history`
--

CREATE TABLE `checkout_history` (
  `usr_id` int(3) NOT NULL,
  `name` varchar(30) NOT NULL,
  `date` varchar(30) NOT NULL,
  `cart` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `clothing`
--

CREATE TABLE `clothing` (
  `id` int(11) NOT NULL,
  `clothing_id` varchar(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `category` varchar(30) NOT NULL,
  `price` int(7) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `clothing`
--

INSERT INTO `clothing` (`id`, `clothing_id`, `name`, `category`, `price`) VALUES
(1, '1', '2Pce Suit', 'men', 1500),
(2, '2', '2Pce Suit', 'ladies', 1500),
(3, '3', '2Pce, 3Pce Suit (White)', 'men', 2000),
(4, '4', '3Pce Suit', 'men', 2000),
(5, '5', 'Academic gown', 'men', 800),
(6, '6', 'Agabada alone', 'men', 600),
(7, '7', 'Agbada, Buba & Sokoto (Brocade)', 'men', 1300),
(8, '8', 'Agbada, Buba & Sokoto (Lace)', 'men', 1500),
(9, '9', 'Agbada, Buba & Sokoto (White)', 'men', 1600),
(10, '10', 'Aso Oke 2pc', 'men', 1200),
(11, '11', 'Aso Oke 3pc', 'men', 1400),
(12, '12', 'Base Ball Cap', 'men', 400),
(13, '13', 'Boxers', 'men', 100),
(14, '14', 'Buba & Sokoto (Kraftan)', 'men', 600),
(15, '15', 'Buba & Sokoto (Lace)', 'men', 800),
(16, '16', 'Buba (Kraftan)', 'men', 300),
(17, '17', 'Buba (lace)', 'men', 400),
(18, '18', 'Buba (white)', 'men', 450),
(19, '19', 'Buba & Sokoto (iron/press only)', 'men', 300),
(20, '20', 'Buba & Sokoto (White)', 'men', 900),
(21, '21', '2Pce George', 'ladies', 1500),
(22, '22', '3Pce Suit', 'ladies', 2000),
(23, '23', 'Academic gown', 'ladies', 800),
(24, '24', 'Aso Oke (Complete)', 'ladies', 1300),
(25, '25', 'Blouse', 'ladies', 300),
(26, '26', 'Blouse & Skirt (Lace)', 'ladies', 800),
(27, '27', 'Blouse & Skirt (Plain)', 'ladies', 800),
(28, '28', 'Boubou/Kaftan', 'ladies', 600),
(29, '29', 'Bridesmaids Dress', 'ladies', 1500),
(30, '30', 'Buba and Sokoto (Plain)', 'ladies', 600),
(31, '31', 'Bathrobe', 'household', 1000),
(32, '32', 'Blanket/Bedspread, Big', 'household', 800),
(33, '33', 'Blanket/Bedspread, Small', 'household', 600),
(34, '34', 'Center Rug', 'household', 2000),
(35, '35', 'Chair cover', 'household', 150),
(36, '36', 'Chair puff', 'household', 200),
(37, '37', 'Comforter Single', 'household', 1500),
(38, '38', 'Door curtains', 'household', 800),
(39, '39', 'Duvet Cover Double', 'household', 1700),
(40, '40', 'Duvet Cover Single', 'household', 1000);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `usr_id` int(11) NOT NULL,
  `name` varchar(25) NOT NULL,
  `email` varchar(25) NOT NULL,
  `phone` varchar(11) NOT NULL,
  `address` text NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `usr_id`, `name`, `email`, `phone`, `address`, `password`) VALUES
(2, 1, 'Victory', 'garubav@gmail.com', '08183659972', 'Tanke Oke-Odo, Ilorin', '$2y$10$wInZlcEXYDIMDYeJhyoxJeQWYb1vBgQ.F.UPqg2YDDWnevfbniLH6');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `clothing`
--
ALTER TABLE `clothing`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `clothing`
--
ALTER TABLE `clothing`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
