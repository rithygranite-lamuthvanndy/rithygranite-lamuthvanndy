CREATE TABLE IF NOT EXISTS `tbl_inv_sale_revenue` (
  `id` int NOT NULL AUTO_INCREMENT,
  `cus_id` int NOT NULL,
  `inv_no` varchar(50) NOT NULL,
  `date_record` date NOT NULL,
  `po_no` varchar(50) NOT NULL,
  `delivery_no` varchar(50) NOT NULL,
  `delivery_date` date NOT NULL,
  `total_discount` double NOT NULL,
  `user_id` int NOT NULL,
  `date_audit` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'User Modified Time',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=123 DEFAULT CHARSET=utf8mb3;

CREATE TABLE IF NOT EXISTS `tbl_acc_inv_revenue_detial` (
  `id` int NOT NULL AUTO_INCREMENT,
  `none_sale_rev_id` int NOT NULL,
  `code` varchar(100) NOT NULL,
  `inv_pro_id` int NOT NULL,
  `fea_id` int NOT NULL,
  `length` varchar(255) NOT NULL,
  `width` float NOT NULL,
  `thickness` float NOT NULL,
  `slab` double NOT NULL,
  `mater` float NOT NULL,
  `unit_price` double NOT NULL,
  `amount` double NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=496 DEFAULT CHARSET=utf8mb3;

CREATE TABLE IF NOT EXISTS `tbl_empl_benefits` (
  `eb_id` int NOT NULL AUTO_INCREMENT,
  `eb_date_record` date NOT NULL,
  `eb_emp_id` int NOT NULL,
  `eb_rich_kg` int NOT NULL,
  `eb_koubung` int NOT NULL,
  `eb_mosquito` int NOT NULL,
  PRIMARY KEY (`eb_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE IF NOT EXISTS `tbl_hr_employee_list1` (
  `empl_id` int NOT NULL AUTO_INCREMENT,
  `empl_card_id` varchar(25) NOT NULL,
  `empl_id_card` varchar(25) NOT NULL,
  `empl_pic` varchar(255) DEFAULT 'blank.png',
  `empl_emloyee_en` varchar(255) NOT NULL,
  `empl_emloyee_kh` varchar(255) NOT NULL,
  `empl_sex` int NOT NULL,
  `empl_national` int NOT NULL,
  `empl_position` int NOT NULL,
  `empl_department` int NOT NULL,
  `empl_date_birth` date NOT NULL,
  `empl_date_work` date NOT NULL,
  `empl_salary` double NOT NULL,
  `empl_phone` varchar(255) NOT NULL,
  `empl_phone2` varchar(25) NOT NULL,
  `empl_email` varchar(255) NOT NULL,
  `empl_note` text NOT NULL,
  `empl_info` int NOT NULL,
  `empl_act` int NOT NULL,
  PRIMARY KEY (`empl_id`)
) ENGINE=InnoDB AUTO_INCREMENT=609 DEFAULT CHARSET=utf8mb3;

INSERT INTO `tbl_hr_employee_list1`(`empl_id`, `empl_card_id`, `empl_id_card`, `empl_pic`, `empl_emloyee_en`, `empl_emloyee_kh`, `empl_sex`, `empl_national`, `empl_position`, `empl_department`, `empl_date_birth`, `empl_date_work`, `empl_salary`, `empl_phone`, `empl_phone2`, `empl_email`, `empl_note`, `empl_info`, `empl_act`) VALUES 
('[value-1]','[value-2]','[value-3]','[value-4]','[value-5]','[value-6]','[value-7]','[value-8]','[value-9]','[value-10]','[value-11]','[value-12]','[value-13]','[value-14]','[value-15]','[value-16]','[value-17]','[value-18]','[value-19]')
