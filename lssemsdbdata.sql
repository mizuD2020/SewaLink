-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 28, 2025 at 07:07 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lssemsdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbladmin`
--

CREATE TABLE `tbladmin` (
  `ID` int(10) NOT NULL,
  `AdminName` varchar(50) DEFAULT NULL,
  `UserName` varchar(50) DEFAULT NULL,
  `MobileNumber` bigint(10) DEFAULT NULL,
  `Email` varchar(120) DEFAULT NULL,
  `Password` varchar(200) DEFAULT NULL,
  `AdminRegdate` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbladmin`
--

INSERT INTO `tbladmin` (`ID`, `AdminName`, `UserName`, `MobileNumber`, `Email`, `Password`, `AdminRegdate`) VALUES
(1, 'Admin', 'admin', 8979555556, 'adminuser@gmail.com', 'f925916e2754e5e03f75dd58a5733251', '2024-04-03 12:54:53');

-- --------------------------------------------------------

--
-- Table structure for table `tblcategory`
--

CREATE TABLE `tblcategory` (
  `ID` int(10) NOT NULL,
  `Category` varchar(100) DEFAULT NULL,
  `CreationDate` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblcategory`
--

INSERT INTO `tblcategory` (`ID`, `Category`, `CreationDate`) VALUES
(1, 'Maid', '2024-05-01 00:41:22'),
(2, 'Driver', '2024-05-01 00:41:22'),
(3, 'Cook', '2024-05-01 00:41:22'),
(4, 'Milkman', '2024-05-01 00:41:22'),
(5, 'Paperboy', '2024-05-01 00:41:22'),
(6, 'Car Cleaner', '2024-05-01 00:41:22'),
(7, 'Nanny', '2024-05-01 00:41:22'),
(8, 'Tuition Teacher', '2024-05-01 00:41:22'),
(9, 'Gym Instructor', '2024-05-01 00:41:22'),
(10, 'Plumber', '2024-05-01 00:41:22'),
(11, 'Basketball Instructor', '2024-05-01 00:41:22'),
(12, 'Electrician', '2024-05-01 00:41:22'),
(13, 'Fitting', '2024-05-01 00:41:22'),
(14, 'Carpenter', '2024-05-01 00:41:22'),
(15, 'House Cleaning', '2024-05-01 00:41:22'),
(16, 'Painter', '2024-05-01 00:41:22'),
(17, 'Grocery Shop', '2024-05-01 00:41:22'),
(18, 'Doctor', '2024-05-01 00:41:22'),
(19, 'Physiotherapist', '2024-05-01 00:41:22'),
(20, 'Nurse', '2024-05-01 00:41:22'),
(21, 'Laundry', '2024-05-01 00:41:22'),
(22, 'Gardener', '2024-05-01 00:41:22'),
(23, 'Flower Delivery', '2024-05-01 00:41:22'),
(24, 'Tailor', '2024-05-01 00:41:22'),
(25, 'Other', '2024-05-01 00:41:22'),
(26, 'Test category', '2024-05-01 00:41:22');

-- --------------------------------------------------------

--
-- Table structure for table `tblpage`
--

CREATE TABLE `tblpage` (
  `ID` int(10) NOT NULL,
  `PageType` varchar(50) DEFAULT NULL,
  `PageTitle` varchar(200) DEFAULT NULL,
  `PageDescription` mediumtext DEFAULT NULL,
  `Email` varchar(200) DEFAULT NULL,
  `MobileNumber` bigint(10) DEFAULT NULL,
  `UpdationDate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblpage`
--

INSERT INTO `tblpage` (`ID`, `PageType`, `PageTitle`, `PageDescription`, `Email`, `MobileNumber`, `UpdationDate`) VALUES
(1, 'aboutus', 'About Us', '<span style=\"font-weight: bold; color: rgb(106, 106, 106); font-family: arial, sans-serif; font-size: 14px;\">Local</span><span style=\"color: rgb(84, 84, 84); font-family: arial, sans-serif; font-size: 14px;\">&nbsp;search is the use of specialized Internet&nbsp;</span><span style=\"font-weight: bold; color: rgb(106, 106, 106); font-family: arial, sans-serif; font-size: 14px;\">search engines</span><span style=\"color: rgb(84, 84, 84); font-family: arial, sans-serif; font-size: 14px;\">&nbsp;that allow users to submit geographically constrained searches against a structured database of&nbsp;</span><span style=\"font-weight: bold; color: rgb(106, 106, 106); font-family: arial, sans-serif; font-size: 14px;\">local business.</span><div><span style=\"font-weight: bold; color: rgb(106, 106, 106); font-family: arial, sans-serif; font-size: 14px;\">This is for testing.</span></div>', NULL, NULL, '2024-05-02 16:58:33'),
(2, 'contactus', 'Contact Us', 'D-204, Hole Town South West,Delhi-110096,India', 'test@gmail.com', 8529631478, '2024-05-09 16:58:57');

-- --------------------------------------------------------

--
-- Table structure for table `tblperson`
--

CREATE TABLE `tblperson` (
  `ID` int(10) NOT NULL,
  `Category` varchar(200) DEFAULT NULL,
  `Name` varchar(200) DEFAULT NULL,
  `Email` varchar(200) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Picture` varchar(200) DEFAULT NULL,
  `MobileNumber` bigint(10) DEFAULT NULL,
  `Address` mediumtext DEFAULT NULL,
  `City` varchar(200) NOT NULL,
  `Latitude` varchar(100) DEFAULT NULL,
  `Longitude` varchar(100) DEFAULT NULL,
  `RegDate` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblperson`
--

INSERT INTO `tblperson` (`ID`, `Category`, `Name`, `Email`, `Password`, `Picture`, `MobileNumber`, `Address`, `City`, `Latitude`, `Longitude`, `RegDate`) VALUES
(32, '7', 'Diwash Panta', 'diwash@gmail.com', '$2y$10$r.BDC.PHEN9yuOK92M.bEOQ5.QaL9T1FZ5.edy.SIKyAjOa91PJ6a', NULL, 1234567890, NULL, '', '27.71735950', '85.32909393', '2025-05-27 10:12:46'),
(33, '4', 'Niteshhh', 'skhfk@gmail.com', '$2y$10$BVyIVsJtgiMVsY45mnhidevwza22eGcOX/F9n8nMEpKqwB.IxK1sS', NULL, 1234567654, NULL, '', '27.71583985', '85.34694672', '2025-05-27 10:34:33'),
(34, '17', 'Nitesh Worker', 'workernitesh@gmail.com', '$2y$10$OOdG1lhoASVOSOZR0RAR/ed4UCftivBOW7qDV9i62ctHbovq4SrqC', NULL, 9998887776, NULL, '', '27.71887913', '85.33441544', '2025-05-27 10:57:35');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `phone_number` varchar(15) NOT NULL,
  `location` varchar(100) NOT NULL,
  `latitude` decimal(10,8) DEFAULT NULL,
  `longitude` decimal(11,8) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `full_name`, `phone_number`, `location`, `latitude`, `longitude`, `created_at`, `email`, `password`) VALUES
(1, 'Nitesh Panta', '9863530600', '', NULL, NULL, '2025-05-27 04:47:21', 'mizu@gmail.com', '$2y$10$zLUW5Z.nTkKgQ6sTvgpHrugEBp0R8FhvJh5/NFF2EgCGeOkz.vXya'),
(2, 'nitesh', '1234567890', '', 27.70352993, 85.33561707, '2025-05-27 10:10:11', 'nitesh11@gmail.com', '$2y$10$l73PrSjhKGCliKqSd./HtOmN8sbCkO9b0Dgj/59IUv7NxCCDB78CG'),
(3, 'hahah', '9876543210', '', 27.71477609, 85.34076691, '2025-05-27 10:55:28', 'hahah@gmail.com', '$2y$10$YxT8j.DlkuRadyG3jKxvdeF6l2LIu3okpJ/6mo80P6ySe5m50nd2a'),
(4, 'nitesh', '1234567899', '', 27.70839327, 85.30849457, '2025-05-27 10:56:08', 'nnnn@gmail.com', '$2y$10$ThKK20aQW8RMTyXptuOz5.f0oEJ3IDYNz8iS0VvDvVooqSEMS8KEK'),
(5, 'NNNNN', '1234567890', '', 27.71340837, 85.34797668, '2025-05-27 11:20:12', 'nnn@gmail.com', '$2y$10$ymbVBbYX/Jvxbik/Ql4KC.BPOaei1ofOloqXz55hpBamcQWENJ9sK');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbladmin`
--
ALTER TABLE `tbladmin`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tblcategory`
--
ALTER TABLE `tblcategory`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `Category` (`Category`),
  ADD KEY `CreationDate` (`CreationDate`);

--
-- Indexes for table `tblpage`
--
ALTER TABLE `tblpage`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tblperson`
--
ALTER TABLE `tblperson`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `Category` (`Category`),
  ADD KEY `Category_2` (`Category`),
  ADD KEY `Category_3` (`Category`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbladmin`
--
ALTER TABLE `tbladmin`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tblcategory`
--
ALTER TABLE `tblcategory`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `tblpage`
--
ALTER TABLE `tblpage`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tblperson`
--
ALTER TABLE `tblperson`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
