DROP TABLE IF EXISTS `tbl_fr_pc_company`;
CREATE TABLE IF NOT EXISTS `tbl_fr_pc_company` (
  `fpc_id` int(11) NOT NULL AUTO_INCREMENT,
  `fpc_code` text NOT NULL,
  `fpc_namekh` varchar(255) NOT NULL,
  `fpc_nameen` varchar(255) NOT NULL,
  `fpc_note` text NOT NULL,
  PRIMARY KEY (`fpc_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;