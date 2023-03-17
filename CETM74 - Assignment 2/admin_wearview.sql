-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 07, 2022 at 03:25 PM
-- Server version: 10.3.28-MariaDB
-- PHP Version: 7.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `admin_wearview`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_tbl`
--

CREATE TABLE `admin_tbl` (
  `id` int(11) NOT NULL,
  `fullName` varchar(250) DEFAULT NULL,
  `username` varchar(250) DEFAULT NULL,
  `password` varchar(250) DEFAULT NULL,
  `userImage` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin_tbl`
--

INSERT INTO `admin_tbl` (`id`, `fullName`, `username`, `password`, `userImage`) VALUES
(1, 'David', 'admin', '$2y$10$/ytd68WbU8Rsxx55IYMazeHzshRPpq/iq7d7mHtsNFkdubTBerZSS', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `case_tbl`
--

CREATE TABLE `case_tbl` (
  `caseid` int(11) NOT NULL,
  `userId` int(11) DEFAULT NULL,
  `category` varchar(250) DEFAULT NULL,
  `subcategory` varchar(250) DEFAULT NULL,
  `loc` varchar(250) DEFAULT NULL,
  `priority` varchar(250) DEFAULT NULL,
  `caseSub` varchar(250) DEFAULT NULL,
  `caseDesc` mediumtext DEFAULT NULL,
  `caseAtt` varchar(250) DEFAULT NULL,
  `regDate` timestamp NULL DEFAULT current_timestamp(),
  `statu` varchar(50) DEFAULT 'Open',
  `lastUpdationDate` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `case_tbl`
--

INSERT INTO `case_tbl` (`caseid`, `userId`, `category`, `subcategory`, `loc`, `priority`, `caseSub`, `caseDesc`, `caseAtt`, `regDate`, `statu`, `lastUpdationDate`) VALUES
(1000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-01-31 20:00:00', NULL, '2022-01-31 20:00:00'),
(1003, 1, 'Software', '', 'GR-7', 'Critical', 'Unable to login to MS Teams', 'I have been having difficulty logging in to Microsoft Team.', NULL, '2022-03-04 13:47:28', 'Close', '2022-03-04 18:32:58'),
(1004, 1, 'Hardware', 'Projector', 'GR-8', 'Critical', 'Projector not powering ON', 'The projector in my class is not powering ON.\r\nKindly provide necessary support ASAP.', NULL, '2022-03-04 14:16:14', 'Open', '2022-03-04 14:16:14');

-- --------------------------------------------------------

--
-- Table structure for table `users_tbl`
--

CREATE TABLE `users_tbl` (
  `id` int(11) NOT NULL,
  `fullName` varchar(250) DEFAULT NULL,
  `username` varchar(250) DEFAULT NULL,
  `password` varchar(250) DEFAULT NULL,
  `userImage` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users_tbl`
--

INSERT INTO `users_tbl` (`id`, `fullName`, `username`, `password`, `userImage`) VALUES
(1, 'Katy', 'staffmember', '$2y$10$ntMIQLxPlUi/qLJl0RUel.GfM4.41/Ysifiz/mXdHbiph0dnvIV.i', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `case_tbl`
--
ALTER TABLE `case_tbl`
  ADD PRIMARY KEY (`caseid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `case_tbl`
--
ALTER TABLE `case_tbl`
  MODIFY `caseid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1005;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
