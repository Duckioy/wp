-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 22, 2024 at 07:54 AM
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
-- Database: `petsvictoria`
--

-- --------------------------------------------------------

--
-- Table structure for table `pets`
--
CREATE DATABASE petsvictoria;
USE petsvictoria;
CREATE TABLE `pets` (
  `petid` int(11) NOT NULL,
  `petname` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(255) NOT NULL,
  `caption` varchar(255) NOT NULL,
  `age` double NOT NULL,
  `location` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pets`
--

INSERT INTO `pets` (`petid`, `petname`, `description`, `image`, `caption`, `age`, `location`, `type`) VALUES
(0, 'Milo', 'A lazy cat', 'cat1.jpeg', 'This is a lazy cat', 6, 'Melbourne CBD', 'Cat'),
(1, 'Baxter', 'An energetic dog', 'dog1.jpeg', 'This is an energetic dog', 5, 'Cape Woolamai', 'Dog'),
(2, 'Luna', 'A stupid cat', 'cat2.jpeg', 'This is a stupid cat', 1, 'Ferntree Gully', 'Cat'),
(3, 'Willow', 'A fat dog', 'dog2.jpeg', 'This is a fat dog', 48, 'Marrysville', 'Dog'),
(4, 'Oliver', 'A fat cat', 'cat4.jpeg', 'This is a fat cat', 12, 'Grampians', 'Cat'),
(5, 'Bella', 'A skinny dog', 'dog3.jpeg', 'This is a skinny dog', 10, 'Carlton', 'Dog');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pets`
--
ALTER TABLE `pets`
  ADD PRIMARY KEY (`petid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `pets`
--
ALTER TABLE `pets`
  MODIFY `petid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

--
-- Table structure for table `users`
--
CREATE TABLE users
(
userid serial primary key,
username varchar(30),
password char(100),
reg_date datetime
);
