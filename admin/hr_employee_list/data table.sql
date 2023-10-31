CREATE TABLE IF NOT EXISTS `tbl_emp_salary_list` (
  `esl_id` int(11) NOT NULL AUTO_INCREMENT,
  `esl_em_id` int(11) NOT NULL,
  `esl_att_em_id` int(11) NOT NULL, 
  `esl_increase_decrease` decimal(10,2) NOT NULL,
  `esl_allowance_deduct` decimal(10,2) NOT NULL,
  `esl_av_borrow` decimal(10,2) NOT NULL,
  `esl_reduce` decimal(10,2) NOT NULL,
  `esl_loan` decimal(10,2) NOT NULL,
  `esl_note` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `date_audit` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'User Modified Time',
  PRIMARY KEY (`esl_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `tbl_emp_salary` (
  `es_id` int(11) NOT NULL AUTO_INCREMENT,
  `es_esl_id` int(11) NOT NULL,
  `es_local_id` int(11) NOT NULL,
  `es_dep_id` int(11) NOT NULL,
  `es_group_id` int(11) NOT NULL,
  `es_mth` varchar(255) NOT NULL,
  `es_note` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `date_audit` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'User Modified Time',
  PRIMARY KEY (`es_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `tbl_hr_employee_note`;
CREATE TABLE IF NOT EXISTS `tbl_hr_employee_note` (
  `emn_id` int(11) NOT NULL AUTO_INCREMENT,
  `emn_empl_id` int(11) NOT NULL,
  `emn_date` date NOT NULL,
  `emn_description` varchar(255) NOT NULL,
  `emn_note` text NOT NULL,
  PRIMARY KEY (`emn_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;