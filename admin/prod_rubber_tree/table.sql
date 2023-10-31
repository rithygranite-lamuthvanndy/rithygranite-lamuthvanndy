CREATE TABLE IF NOT EXISTS `tbl_access_rubber_tree` (
  `art_id` int(11) NOT NULL AUTO_INCREMENT,
  `art_depat_id` char(100) CHARACTER SET utf8 NOT NULL,
  `art_depat_1` char(100) CHARACTER SET utf8 NOT NULL,
	`art_depat_2` char(100) CHARACTER SET utf8 NOT NULL,
	`art_depat_3` char(100) CHARACTER SET utf8 NOT NULL,
  `art_note` text CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`art_id`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;