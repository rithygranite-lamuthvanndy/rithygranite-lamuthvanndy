-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: May 02, 2020 at 11:49 PM
-- Server version: 10.4.10-MariaDB
-- PHP Version: 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `adminlte3`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

DROP TABLE IF EXISTS `tbl_user`;
CREATE TABLE IF NOT EXISTS `tbl_user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` char(255) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_photo` varchar(255) NOT NULL,
  `user_phone_number` char(255) NOT NULL,
  `user_gender` char(255) NOT NULL,
  `user_status` char(255) NOT NULL,
  `user_position` int(11) NOT NULL,
  `user_note` varchar(255) NOT NULL,
  `user_originattion` char(255) NOT NULL,
  `user_created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_address` text NOT NULL,
  `user_code` text NOT NULL,
  `user_first_name` text NOT NULL,
  `user_last_name` text NOT NULL,
  `user_res_by` int(11) NOT NULL,
  `last_activity` datetime DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  KEY `position` (`user_position`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`user_id`, `user_name`, `user_password`, `user_email`, `user_photo`, `user_phone_number`, `user_gender`, `user_status`, `user_position`, `user_note`, `user_originattion`, `user_created_at`, `user_address`, `user_code`, `user_first_name`, `user_last_name`, `user_res_by`, `last_activity`) VALUES
(1, 'admin', '14systems7979', 'admin@admin.com', '20200421_6257.png', '', '1', '1', 1, '', '', '2018-03-28 20:40:30', '', '', 'Keo', 'Bopha', 0, '2020-04-28 18:21:11'),
(2, 'newdayuser', '14systems7979', 'admin@admin.com', 'blank.png', '', '1', '1', 1, '', '', '2018-03-28 20:40:30', '', '', '', '', 0, '2019-06-01 00:00:00'),
(3, 'SEAN', '14systems7979', 'idkSabay70nas@gmail.com', '20200422_5226.png', '0889876280', '1', '1', 9, '', '', '2019-12-09 08:21:06', '$Borey piphup tmey plov veng sreng E11 S30', '9999', 'TYKIM', 'SEAN', 1, '2019-12-11 14:28:15'),
(19, 'keo bopha', '123', 'keobopha2222@gmail.com', '20200422_1116.png', '0964822284', '2', '1', 4, '', '', '2018-09-11 20:08:43', '', '00', 'Keo', 'Bopha', 0, '2020-04-22 09:08:08'),
(20, 'hay leakhena', '123', 'leakhina_hay@yahoo.com', '20200423_2236.png', '', '2', '1', 6, '', '', '2018-09-11 20:09:13', '', '', '', '', 0, '2020-01-28 11:23:23'),
(23, 'Mon bunthib', '123', 'bunthibmon@gmail.com', 'blank.png', '', '2', '1', 1, '', '', '2018-09-18 21:52:13', '', '', '', '', 0, '2019-06-01 00:00:00'),
(25, 'thona', 'Tho123456', 'saing.vitho6666@gmail.com', 'blank.png', '0967422219', '2', '1', 7, '', '', '2018-12-07 09:04:22', '$Phnom Penh', '001', 'Sang', 'Vetho', 1, '2019-06-01 00:00:00'),
(26, 'Ya', '14systems7979', 'khutppppsreypor@gmail.com', 'blank.png', '096 5075 200', '2', '1', 7, '', '', '2018-12-07 10:16:57', '$Phnom Penh ', '002', 'Khut ', 'Peysreysoreayopor', 1, '2019-06-04 00:00:00'),
(27, 'RUMNEA', 'Father2014', 'rumneasuon8888@gmail.com', 'blank.png', '010556319', '1', '1', 7, '', '', '2018-12-11 08:39:49', '$Phnom Penh', '12', 'SUON', 'RUMNEA', 1, '2020-02-03 11:15:36'),
(28, 'Sreypov', '9999', 'silengsreypov@gmail.com', 'blank.png', '069841890', '2', '1', 7, '', '', '2019-02-20 10:21:47', '$PP', '006', 'Sileng', 'Sreypov', 1, '2020-02-03 08:26:44'),
(29, 'Stock-Manager', 'RG123', 'dasjdhjas@gmail.com', 'blank.png', '1224021541', '2', '1', 16, '', '', '2019-12-13 07:09:40', '$', 'G02-3.3.164', 'THACH', 'THI NGUNG', 1, '2019-12-15 14:50:52'),
(30, 'admin-stock', 'RG123456', 'dsfdsf@gmail.com', '20200428_6462.png', '121546', '1', '1', 17, '', '', '2019-12-13 08:02:27', '$', 'G02-4.3.093', 'NGUYEN', 'THANH BINH', 1, '2019-12-30 17:14:52'),
(31, 'vanndykhmerboy', 'Khmerboy@016', 'vanndykhmerboy@gmail.com', '20200422_8789.png', '010411477', '4', '1', 11, '', 'Register', '2020-02-25 19:04:14', '', '01010', 'Vanndy', 'Boy', 0, '2020-03-04 10:32:44');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user_gender`
--

DROP TABLE IF EXISTS `tbl_user_gender`;
CREATE TABLE IF NOT EXISTS `tbl_user_gender` (
  `ug_id` int(11) NOT NULL,
  `ug_name` varchar(255) NOT NULL,
  `ug_assign` int(11) NOT NULL,
  `ug_note` text NOT NULL,
  PRIMARY KEY (`ug_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_user_gender`
--

INSERT INTO `tbl_user_gender` (`ug_id`, `ug_name`, `ug_assign`, `ug_note`) VALUES
(1, 'male', 0, ''),
(2, 'female', 0, ''),
(3, 'miss', 0, ''),
(4, 'Mr.', 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user_position`
--

DROP TABLE IF EXISTS `tbl_user_position`;
CREATE TABLE IF NOT EXISTS `tbl_user_position` (
  `up_id` int(11) NOT NULL AUTO_INCREMENT,
  `up_name` varchar(255) NOT NULL,
  `up_assign` varchar(255) NOT NULL,
  `up_status` int(11) NOT NULL,
  `up_group_data` enum('1','0') NOT NULL,
  `up_note` text NOT NULL,
  PRIMARY KEY (`up_id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_user_position`
--

INSERT INTO `tbl_user_position` (`up_id`, `up_name`, `up_assign`, `up_status`, `up_group_data`, `up_note`) VALUES
(1, 'Director', 'full control', 0, '1', ''),
(2, 'Assistant of Director', 'input data', 0, '1', ''),
(3, 'CEO', '', 0, '1', ''),
(4, 'Secretory of CEO', '', 0, '1', ''),
(5, 'CFO', '', 0, '1', ''),
(6, 'Account Manager', '', 0, '1', ''),
(7, 'Accountant', '', 0, '1', ''),
(8, 'Cashier', '', 0, '1', ''),
(9, 'Purchasing', '', 0, '1', ''),
(10, 'System Admin', '', 1, '1', ''),
(11, 'IT', '', 0, '1', ''),
(12, 'Sale In Domestic', '', 0, '1', ''),
(13, 'Sale to Oversa', '', 0, '1', ''),
(14, 'Operation', '', 1, '1', ''),
(15, 'Developer', '', 0, '1', 'Don\'t Delete this position'),
(16, 'Stock', '', 1, '1', ''),
(17, 'Stock & Operation', '', 1, '1', '');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user_status`
--

DROP TABLE IF EXISTS `tbl_user_status`;
CREATE TABLE IF NOT EXISTS `tbl_user_status` (
  `us_id` int(11) NOT NULL,
  `us_name` varchar(255) NOT NULL,
  `us_assign` int(11) NOT NULL,
  `us_note` text NOT NULL,
  PRIMARY KEY (`us_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_user_status`
--

INSERT INTO `tbl_user_status` (`us_id`, `us_name`, `us_assign`, `us_note`) VALUES
(1, 'active', 0, ''),
(2, 'disable', 0, ''),
(3, 'pendding', 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user_status_add`
--

DROP TABLE IF EXISTS `tbl_user_status_add`;
CREATE TABLE IF NOT EXISTS `tbl_user_status_add` (
  `us_id` int(11) NOT NULL,
  `us_name` varchar(255) NOT NULL,
  `us_assign` int(11) NOT NULL,
  `us_note` text NOT NULL,
  PRIMARY KEY (`us_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_user_status_add`
--

INSERT INTO `tbl_user_status_add` (`us_id`, `us_name`, `us_assign`, `us_note`) VALUES
(1, 'Active', 0, ''),
(2, 'Disactive', 0, '');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
