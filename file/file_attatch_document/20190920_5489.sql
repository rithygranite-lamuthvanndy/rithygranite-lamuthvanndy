-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Sep 20, 2019 at 06:52 AM
-- Server version: 10.1.9-MariaDB
-- PHP Version: 5.6.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rithygranite`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_doc_document`
--

CREATE TABLE `tbl_doc_document` (
  `docdoc_id` int(11) NOT NULL,
  `docdoc_child_id` int(11) NOT NULL,
  `docdoc_old_file_name` varchar(255) NOT NULL,
  `docdoc_type` tinyint(4) NOT NULL COMMENT '1=Folder,2=File',
  `docdoc_date` datetime NOT NULL,
  `docdoc_title` varchar(255) NOT NULL,
  `docdoc_attach` varchar(255) NOT NULL,
  `docdoc_creator` int(11) NOT NULL,
  `docdoc_department` int(11) NOT NULL,
  `docdoc_note` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `date_audit` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_doc_document`
--

INSERT INTO `tbl_doc_document` (`docdoc_id`, `docdoc_child_id`, `docdoc_old_file_name`, `docdoc_type`, `docdoc_date`, `docdoc_title`, `docdoc_attach`, `docdoc_creator`, `docdoc_department`, `docdoc_note`, `user_id`, `date_audit`) VALUES
(29, 1, '', 1, '2019-09-20 11:49:31', 'New Folder', '', 1, 1, '', 0, '2019-09-20 04:49:31'),
(30, 29, '20190920_4126.xlsx', 2, '2019-09-20 11:49:43', 'Lotory   ក្បាលបញ្ចី.xlsx', '', 0, 1, '', 0, '2019-09-20 04:49:43'),
(31, 29, '20190920_3845.xlsx', 2, '2019-09-20 11:49:43', 'es_note.xlsx', '', 0, 1, '', 0, '2019-09-20 04:49:43'),
(32, 29, '20190920_6026.xlsx', 2, '2019-09-20 11:49:43', 'Book1.xlsx', '', 0, 1, '', 0, '2019-09-20 04:49:43'),
(33, 29, '20190920_1286.jpg', 2, '2019-09-20 11:50:18', 'photo_2019-08-23_10-10-24.jpg', '', 0, 1, '', 0, '2019-09-20 04:50:18');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_doc_document`
--
ALTER TABLE `tbl_doc_document`
  ADD PRIMARY KEY (`docdoc_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_doc_document`
--
ALTER TABLE `tbl_doc_document`
  MODIFY `docdoc_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
