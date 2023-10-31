CREATE TABLE IF NOT EXISTS `tbl_prod_dv` (
  `dv_id` int NOT NULL AUTO_INCREMENT,
  `dv_no` varchar(25) NOT NULL,
  `dv_date` date NOT NULL,
  `dv_cus_id` text NOT NULL,
  `dv_by` text NOT NULL,
  `dv_by_num` text NOT NULL,
  `user_id` int NOT NULL,
  `dv_po_id` int NOT NULL,
  `dv_type_id` int NOT NULL,
  `dv_tm_id` int NOT NULL,
  PRIMARY KEY (`dv_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb3;
COMMIT;

CREATE TABLE IF NOT EXISTS `tbl_prod_dv_list` (
  `dvl_id` int NOT NULL AUTO_INCREMENT,
  `dvl_dv_id` int NOT NULL,
  `dvl_name` text NOT NULL,
  `dvl_feature` text NOT NULL,
  `dvl_length` text NOT NULL,
  `dvl_width` text NOT NULL,
  `dvl_pcs_slab` text NOT NULL,
  `dvl_m2` text NOT NULL,
  `dvl_note` text NOT NULL,
  `dvl_thickness` text NOT NULL,
  `dvl_tm_id` int NOT NULL,
  PRIMARY KEY (`dvl_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb3;
COMMIT;

CREATE TABLE IF NOT EXISTS `tbl_prod_type_dv` (
  `tdv_id` int NOT NULL AUTO_INCREMENT,
  `tdv_code` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `tdv_name_vn` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `tdv_name_en` varchar(250) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `tdv_name_kh` varchar(250) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `tdv_note` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `tdv_user_id` int NOT NULL,
  PRIMARY KEY (`tdv_id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=latin1;