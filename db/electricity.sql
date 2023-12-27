-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Nov 26, 2022 at 12:47 PM
-- Server version: 8.0.27
-- PHP Version: 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `electricity`
--

-- --------------------------------------------------------

--
-- Table structure for table `account_details`
--

DROP TABLE IF EXISTS `account_details`;
CREATE TABLE IF NOT EXISTS `account_details` (
  `acc_num` int NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `NIC` varchar(12) NOT NULL,
  `mobile` varchar(10) NOT NULL,
  PRIMARY KEY (`acc_num`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `account_details`
--

INSERT INTO `account_details` (`acc_num`, `fullname`, `NIC`, `mobile`) VALUES
(160036, 'Mahendran Thanujan', '982704690V', '0779257930'),
(160038, 'Uthayakumar Navarathan', '982702917V', '0779284618'),
(160041, 'Satkunarasa Ajinthan', '9827059127V', '0772042572'),
(160050, 'Laksana Sivakumaran', '982713711V', '0779026471'),
(160081, 'Thanendran Sivaparan', '982724578V', '0779286783');

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

DROP TABLE IF EXISTS `admins`;
CREATE TABLE IF NOT EXISTS `admins` (
  `admin_id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`admin_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`admin_id`, `username`, `email`, `password`) VALUES
(1, 'admin', 'admin@gmail.com', '2119eb59afc81b22cf8a4298047f9723');

-- --------------------------------------------------------

--
-- Table structure for table `area`
--

DROP TABLE IF EXISTS `area`;
CREATE TABLE IF NOT EXISTS `area` (
  `area` varchar(100) NOT NULL,
  `zone` varchar(100) NOT NULL,
  PRIMARY KEY (`area`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `area`
--

INSERT INTO `area` (`area`, `zone`) VALUES
('Kopay', 'S'),
('Tellipalai', 'W'),
('Kokuvil', 'S'),
('Navatkuli', 'W'),
('Chunnakam', 'W'),
('Thirunelveli', 'T'),
('Pointpedro', 'T'),
('Nallur', 'P'),
('Ariyalai', 'Q');

-- --------------------------------------------------------

--
-- Table structure for table `bills`
--

DROP TABLE IF EXISTS `bills`;
CREATE TABLE IF NOT EXISTS `bills` (
  `bill_id` int NOT NULL AUTO_INCREMENT,
  `acc_num` int NOT NULL,
  `date` date NOT NULL,
  `units` int NOT NULL,
  `amount` decimal(6,2) NOT NULL,
  `payment_status` varchar(10) NOT NULL DEFAULT 'Not Paid',
  PRIMARY KEY (`bill_id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `bills`
--

INSERT INTO `bills` (`bill_id`, `acc_num`, `date`, `units`, `amount`, `payment_status`) VALUES
(1, 160038, '2022-01-01', 170, '3587.50', 'Not Paid'),
(2, 160038, '2022-02-01', 152, '3107.50', 'Not Paid'),
(3, 160038, '2022-03-01', 125, '2243.50', 'Not Paid'),
(4, 160050, '2022-01-01', 170, '3683.50', 'Paid'),
(5, 160050, '2022-02-01', 151, '3107.50', 'Paid'),
(6, 160050, '2022-03-01', 165, '3523.50', 'Not Paid'),
(7, 160050, '2022-04-01', 181, '4108.50', 'Not Paid'),
(8, 160038, '2022-04-01', 100, '1528.50', 'Not Paid'),
(9, 160041, '2022-01-01', 100, '1528.50', 'Not Paid'),
(10, 160041, '2022-02-01', 126, '2275.50', 'Not Paid'),
(11, 160041, '2022-03-01', 107, '1722.50', 'Not Paid'),
(12, 160041, '2022-04-01', 114, '0.00', 'Not Paid'),
(13, 160041, '2022-05-01', 118, '2028.00', 'Not Paid'),
(14, 160038, '2022-05-01', 124, '2211.50', 'Not Paid'),
(15, 160038, '2022-06-01', 139, '2691.50', 'Not Paid'),
(16, 160038, '2022-07-01', 142, '278.50', 'Not Paid'),
(17, 160038, '2022-08-01', 119, '2055.50', 'Not Paid'),
(18, 160041, '2022-09-01', 120, '1500.00', 'Not Paid');

-- --------------------------------------------------------

--
-- Table structure for table `complaints`
--

DROP TABLE IF EXISTS `complaints`;
CREATE TABLE IF NOT EXISTS `complaints` (
  `com_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `problem` varchar(500) NOT NULL,
  `reply` varchar(500) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`com_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `complaints`
--

INSERT INTO `complaints` (`com_id`, `user_id`, `problem`, `reply`, `time`) VALUES
(1, 1, 'we have powercut from yesterday', 'There is a problem from transformer in your area. Our team is working on it. It will solved very soon.', '2022-08-16 22:04:23'),
(2, 3, 'Current wire was disconnected in our lane, can you solve this.', 'ok we will repaired that very soon', '2022-08-18 11:58:32'),
(3, 1, 'Our Street light does not work from two days before.\r\n', NULL, '2022-08-22 08:44:13'),
(4, 1, 'Our area has power failure from yesterday', NULL, '2022-09-05 20:25:35');

-- --------------------------------------------------------

--
-- Table structure for table `powercut`
--

DROP TABLE IF EXISTS `powercut`;
CREATE TABLE IF NOT EXISTS `powercut` (
  `schedule_id` int NOT NULL AUTO_INCREMENT,
  `start_time` timestamp NOT NULL,
  `end_time` timestamp NOT NULL,
  `zone` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`schedule_id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `powercut`
--

INSERT INTO `powercut` (`schedule_id`, `start_time`, `end_time`, `zone`) VALUES
(1, '2022-08-14 13:30:00', '2022-08-14 14:30:00', 'S T'),
(2, '2022-08-14 14:30:00', '2022-08-14 15:30:00', 'W P'),
(3, '2022-08-14 12:30:00', '2022-08-14 13:30:00', 'Q'),
(4, '2022-08-15 11:30:00', '2022-08-15 12:30:00', 'S T'),
(5, '2022-08-14 02:30:00', '2022-08-14 03:50:00', 'S T'),
(6, '2022-08-16 05:30:00', '2022-08-15 18:30:00', 'W P'),
(7, '2022-08-16 08:50:00', '2022-08-16 09:50:00', 'Q'),
(8, '2022-08-16 11:50:00', '2022-08-16 13:10:00', 'S T'),
(9, '2022-08-16 13:10:00', '2022-08-16 14:30:00', 'W P'),
(10, '2022-08-18 12:30:00', '2022-08-18 13:50:00', 'S T'),
(11, '2022-08-19 08:30:00', '2022-08-19 10:10:00', 'S T'),
(12, '2022-09-02 08:30:00', '2022-09-02 09:50:00', 'S T'),
(13, '2022-09-05 12:30:00', '2022-09-05 13:30:00', 'S T'),
(14, '2022-09-05 14:30:00', '2022-09-05 15:30:00', 'S T'),
(15, '2022-09-07 13:30:00', '2022-09-05 14:30:00', 'W'),
(16, '2022-09-05 15:30:00', '2022-09-05 16:30:00', 'Q');

-- --------------------------------------------------------

--
-- Table structure for table `units`
--

DROP TABLE IF EXISTS `units`;
CREATE TABLE IF NOT EXISTS `units` (
  `id` int NOT NULL AUTO_INCREMENT,
  `date` timestamp NOT NULL ON UPDATE CURRENT_TIMESTAMP,
  `first` decimal(6,2) NOT NULL,
  `second` decimal(6,2) NOT NULL,
  `third` decimal(6,2) NOT NULL,
  `fourth` decimal(6,2) NOT NULL,
  `fifth` decimal(6,2) NOT NULL,
  `sixth` decimal(6,2) NOT NULL,
  `seventh` decimal(6,2) NOT NULL,
  `type` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `units`
--

INSERT INTO `units` (`id`, `date`, `first`, `second`, `third`, `fourth`, `fifth`, `sixth`, `seventh`, `type`) VALUES
(1, '2022-08-17 13:15:32', '30.00', '60.00', '90.00', '480.00', '480.00', '540.00', '0.00', 'unitPrice'),
(2, '2022-08-17 13:16:04', '2.50', '4.85', '7.85', '10.00', '27.75', '32.00', '45.00', 'unitPrice'),
(3, '2022-08-17 15:17:20', '30.00', '60.00', '60.00', '90.00', '480.00', '480.00', '540.00', 'fixedPrice');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int NOT NULL AUTO_INCREMENT,
  `acc_num` int NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mobile` varchar(10) NOT NULL,
  `area` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `acc_num`, `username`, `email`, `mobile`, `area`, `password`) VALUES
(1, 160038, 'Rathan', 'navarathan026@gmail.com', '0779284618', 'Kopay', '7556f3ac84915a251a7b6c62fe0bd18d'),
(2, 160050, 'Laksana', 'laxsu@gmail.com', '0779026471', 'Tellipalai', '2119eb59afc81b22cf8a4298047f9723'),
(3, 160041, 'Ajinthan', 'ajinthan@gail.com', '0772042572', 'Pointpedro', '2119eb59afc81b22cf8a4298047f9723'),
(4, 160081, 'Sivaparan', 'siva@gmail.com', '0779286783', 'Kokuvil', '2119eb59afc81b22cf8a4298047f9723');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
