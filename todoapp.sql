-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 24, 2023 at 07:57 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.1.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `todoapp`
--

-- --------------------------------------------------------

--
-- Table structure for table `todo_item`
--

CREATE TABLE `todo_item` (
  `User_Id` varchar(50) DEFAULT NULL,
  `Item_Id` int(11) NOT NULL,
  `Todo_Data` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `todo_item`
--

INSERT INTO `todo_item` (`User_Id`, `Item_Id`, `Todo_Data`) VALUES
('bhsdv', 1, 'lets play'),
('bhsdv', 8, 'fsa'),
('fas', 9, 'qqqq'),
('sasanka@gmail.com', 11, 'fs'),
('sasanka@gmail.com', 12, 'sd'),
('sasanka@gmail.com', 13, 'menoka'),
('sasanka@gmail.com', 14, 'sa');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `User_Id` varchar(50) DEFAULT NULL,
  `User_Name` varchar(50) DEFAULT NULL,
  `User_Email` varchar(50) DEFAULT NULL,
  `User_Pass` varchar(100) DEFAULT NULL,
  `Joining_Date` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`User_Id`, `User_Name`, `User_Email`, `User_Pass`, `Joining_Date`) VALUES
('fxKI5aNpHdK41Tt', 'Sasanka Sekhar Das', 'sasanka@gmail.com', '$2y$10$zhD3zvK8kTR/sipk5f83AON/nQ62bM7SJ3Syvl8qIihMEw5cLpIVq', NULL),
('RPna70AxgjUWlie', 'Sasanka Sekhar Das', 'as@gmail.com', '$2y$10$7sE9ehjD9N3n9lhrJMQ5Se27NFooHpcO7yvR95Q9yQj1m08ggeaaS', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `todo_item`
--
ALTER TABLE `todo_item`
  ADD PRIMARY KEY (`Item_Id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `todo_item`
--
ALTER TABLE `todo_item`
  MODIFY `Item_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
