-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 30, 2020 at 11:23 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.2.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `user-registration`
--

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `id` int(11) NOT NULL,
  `firstname` varchar(20) NOT NULL,
  `lastname` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `gender` tinyint(1) DEFAULT NULL,
  `password` varchar(50) NOT NULL,
  `role` tinyint(1) NOT NULL DEFAULT 0,
  `designation` varchar(50) DEFAULT NULL,
  `qualification` varchar(200) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `about` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`id`, `firstname`, `lastname`, `email`, `gender`, `password`, `role`, `designation`, `qualification`, `address`, `about`) VALUES
(1, 'Pavan', 'Kumar', 'pavanthumpudi@gmail.com', 1, 'e10adc3949ba59abbe56e057f20f883e', 0, 'Engineer', 'B.Tech (Electronics and instrumentation. “Batch: 2008-2012”)', 'HSR Lauout,\nBangalore,\nKarnataka,\nIndia', ''),
(7, 'Aishwarya', 'Jadhav', 'aishwaryajadhav@gmail.com', 0, 'e10adc3949ba59abbe56e057f20f883e', 0, NULL, 'B.S. in Computer Science from the University of Tennessee at Knoxville', 'Banglore, Karnataka, India', 'B.S. in Computer Science from the University of Tennessee at Knoxville'),
(23, 'Sarala', 'Gajapathy', 'sarala.gajapathy@altran.com', 0, 'e10adc3949ba59abbe56e057f20f883e', 1, NULL, 'B.S. in Computer Science from the University of Tennessee at Knoxville', 'Banglore, Karnataka, India', 'B.S. in Computer Science from the University of Tennessee at Knoxville'),
(26, 'hari', 'kumar', 'harikumar@gmail.com', 1, 'e10adc3949ba59abbe56e057f20f883e', 0, NULL, 'B.S. in Computer Science from the University of Tennessee at Knoxville', 'Banglore, Karnataka, India', 'B.S. in Computer Science from the University of Tennessee at Knoxville'),
(31, 'Manjunatha', 'kr', 'manjunatha.kr@altran.com', 1, 'e10adc3949ba59abbe56e057f20f883e', 1, NULL, 'B.S. in Computer Science from the University of Tennessee at Knoxville', 'Banglore, Karnataka, India', 'B.S. in Computer Science from the University of Tennessee at Knoxville');

-- --------------------------------------------------------

--
-- Table structure for table `emp_skill`
--

CREATE TABLE `emp_skill` (
  `id` int(11) NOT NULL,
  `eid` int(11) NOT NULL,
  `sid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `emp_skill`
--

INSERT INTO `emp_skill` (`id`, `eid`, `sid`) VALUES
(10, 4, 1),
(71, 8, 1),
(78, 17, 1),
(96, 23, 1),
(97, 23, 2),
(113, 25, 1),
(114, 25, 2),
(115, 25, 3),
(116, 25, 4),
(117, 25, 5),
(118, 25, 6),
(119, 26, 1),
(120, 26, 2),
(121, 26, 3),
(122, 26, 4),
(123, 26, 5),
(124, 26, 6),
(149, 7, 1),
(150, 7, 2),
(151, 7, 3),
(152, 7, 4),
(153, 7, 5),
(154, 7, 6),
(254, 1, 1),
(255, 1, 2),
(256, 1, 3),
(257, 1, 4),
(258, 1, 5),
(259, 1, 6);

-- --------------------------------------------------------

--
-- Table structure for table `healthchecklist`
--

CREATE TABLE `healthchecklist` (
  `id` int(11) NOT NULL,
  `eid` int(11) NOT NULL,
  `cold` tinyint(1) NOT NULL DEFAULT 0,
  `cough` tinyint(1) NOT NULL DEFAULT 0,
  `fever` tinyint(1) NOT NULL DEFAULT 0,
  `difficultyinbreath` tinyint(1) NOT NULL DEFAULT 0,
  `lossofsenses` tinyint(1) NOT NULL DEFAULT 0,
  `others` tinyint(1) NOT NULL DEFAULT 0,
  `comment` varchar(100) DEFAULT NULL,
  `date` date NOT NULL,
  `time` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `healthchecklist`
--

INSERT INTO `healthchecklist` (`id`, `eid`, `cold`, `cough`, `fever`, `difficultyinbreath`, `lossofsenses`, `others`, `comment`, `date`, `time`) VALUES
(1, 1, 1, 1, 1, 0, 0, 0, '', '2020-06-17', '2020-06-17 12:38:08'),
(2, 7, 1, 0, 0, 0, 0, 0, '', '2020-06-17', '2020-06-17 12:39:22'),
(4, 23, 0, 0, 0, 0, 0, 0, '', '2020-06-17', '2020-06-17 12:40:53'),
(5, 26, 0, 0, 0, 0, 0, 0, '', '2020-06-17', '2020-06-17 12:41:01'),
(6, 31, 1, 1, 1, 1, 1, 0, '', '2020-06-17', '2020-06-17 12:41:08'),
(20, 1, 0, 0, 1, 1, 0, 0, 'undefined', '2020-06-18', '2020-06-18 16:53:53'),
(21, 23, 0, 0, 0, 0, 0, 0, 'undefined', '2020-06-18', '2020-06-18 16:54:11'),
(24, 7, 0, 1, 1, 0, 0, 0, 'undefined', '2020-06-19', '2020-06-19 16:28:04'),
(25, 23, 0, 0, 0, 0, 0, 0, 'undefined', '2020-06-19', '2020-06-19 16:28:15'),
(26, 1, 1, 1, 0, 0, 0, 0, 'undefined', '2020-06-19', '2020-06-19 16:51:55'),
(27, 1, 0, 0, 0, 0, 0, 0, 'undefined', '2020-06-25', '2020-06-25 16:28:25');

-- --------------------------------------------------------

--
-- Table structure for table `skill`
--

CREATE TABLE `skill` (
  `id` int(11) NOT NULL,
  `skill` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `skill`
--

INSERT INTO `skill` (`id`, `skill`) VALUES
(1, 'Java'),
(2, 'Python'),
(3, 'TypeScript'),
(4, 'JavaScript'),
(5, 'PHP'),
(6, 'MySql');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `emp_skill`
--
ALTER TABLE `emp_skill`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `healthchecklist`
--
ALTER TABLE `healthchecklist`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `skill`
--
ALTER TABLE `skill`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `emp_skill`
--
ALTER TABLE `emp_skill`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=260;

--
-- AUTO_INCREMENT for table `healthchecklist`
--
ALTER TABLE `healthchecklist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `skill`
--
ALTER TABLE `skill`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
