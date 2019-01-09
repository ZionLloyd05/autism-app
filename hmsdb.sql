-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 18, 2018 at 03:45 PM
-- Server version: 10.1.31-MariaDB
-- PHP Version: 7.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hmsdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointmenttbl`
--

CREATE TABLE `appointmenttbl` (
  `id` tinyint(4) NOT NULL,
  `doctorid` varchar(15) COLLATE utf8mb4_bin NOT NULL,
  `patientid` varchar(15) COLLATE utf8mb4_bin NOT NULL,
  `fixeddate` date NOT NULL,
  `isSeen` tinyint(4) NOT NULL DEFAULT '0',
  `note` text COLLATE utf8mb4_bin NOT NULL,
  `fixedtime` time NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Table structure for table `chat_message`
--

CREATE TABLE `chat_message` (
  `id` int(11) NOT NULL,
  `to_user_id` varchar(15) COLLATE utf8mb4_bin NOT NULL,
  `from_user_id` varchar(15) COLLATE utf8mb4_bin NOT NULL,
  `chat_message` mediumtext COLLATE utf8mb4_bin NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Table structure for table `doctortbl`
--

CREATE TABLE `doctortbl` (
  `id` int(11) NOT NULL,
  `doctorId` varchar(20) NOT NULL,
  `firstname` varchar(30) NOT NULL,
  `lastname` varchar(30) NOT NULL,
  `email` varchar(40) NOT NULL,
  `phone` varchar(11) NOT NULL,
  `password` varchar(150) NOT NULL,
  `registeredAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `doctortbl`
--

INSERT INTO `doctortbl` (`id`, `doctorId`, `firstname`, `lastname`, `email`, `phone`, `password`, `registeredAt`) VALUES
(4, 'Bad_996455', 'Lateefah', 'Bade-Giwa', 'lateefah@gmail.com', '09022334455', '$2y$09$Y5Bi2MJoLv1Yq3Pzs9pyAOHSpCgzlZrMZ6pMl63YyybJAeztfHHpq', '2018-09-18 13:21:05');

-- --------------------------------------------------------

--
-- Table structure for table `logindetailstbl`
--

CREATE TABLE `logindetailstbl` (
  `id` tinyint(4) NOT NULL,
  `user_id` varchar(20) NOT NULL,
  `lastLoginActivity` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `isType` enum('yes','no') NOT NULL DEFAULT 'no'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `logindetailstbl`
--

INSERT INTO `logindetailstbl` (`id`, `user_id`, `lastLoginActivity`, `isType`) VALUES
(1, 'Bad_996455', '2018-09-18 14:21:35', 'no');

-- --------------------------------------------------------

--
-- Table structure for table `patienttbl`
--

CREATE TABLE `patienttbl` (
  `id` tinyint(4) NOT NULL,
  `patient_id` varchar(20) NOT NULL,
  `pfirstname` varchar(30) NOT NULL,
  `plastname` varchar(30) NOT NULL,
  `dob` date NOT NULL,
  `bloodgroup` varchar(5) NOT NULL,
  `genotype` varchar(5) NOT NULL,
  `gfirstname` varchar(30) NOT NULL,
  `glastname` varchar(30) NOT NULL,
  `password` varchar(150) NOT NULL,
  `email` varchar(60) NOT NULL,
  `phone` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `symptomtbl`
--

CREATE TABLE `symptomtbl` (
  `id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `doctorid` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointmenttbl`
--
ALTER TABLE `appointmenttbl`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `chat_message`
--
ALTER TABLE `chat_message`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `doctortbl`
--
ALTER TABLE `doctortbl`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logindetailstbl`
--
ALTER TABLE `logindetailstbl`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `patienttbl`
--
ALTER TABLE `patienttbl`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `symptomtbl`
--
ALTER TABLE `symptomtbl`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointmenttbl`
--
ALTER TABLE `appointmenttbl`
  MODIFY `id` tinyint(4) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `chat_message`
--
ALTER TABLE `chat_message`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `doctortbl`
--
ALTER TABLE `doctortbl`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `logindetailstbl`
--
ALTER TABLE `logindetailstbl`
  MODIFY `id` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `patienttbl`
--
ALTER TABLE `patienttbl`
  MODIFY `id` tinyint(4) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `symptomtbl`
--
ALTER TABLE `symptomtbl`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
