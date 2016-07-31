DROP TABLE IF EXISTS `minty_config`;
CREATE TABLE `minty_config` (
  `ID` int(16) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `value` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `minty_users`;
CREATE TABLE `minty_users` (
  `ID` int(16) NOT NULL AUTO_INCREMENT,
  `username` text CHARACTER SET utf8 NOT NULL,
  `password` text NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `products`;
CREATE TABLE `products` (
  `ID` int(16) NOT NULL AUTO_INCREMENT,
  `vendor` varchar(255) DEFAULT NULL,
  `mfg_part_no` varchar(255) DEFAULT NULL,
  `upc` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `price` double(16,2) DEFAULT NULL,
  `reg_price` double(16,2) DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  `description` text,
  `images` text,
  `link` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=95 DEFAULT CHARSET=latin1;