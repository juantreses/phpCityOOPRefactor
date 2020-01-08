# noinspection SqlNoDataSourceInspectionForFile

/*
Navicat MySQL Data Transfer

Source Database       : wdev_steven

Target Server Type    : MYSQL
Target Server Version : 50562
File Encoding         : 65001
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `images`
-- ----------------------------
DROP TABLE IF EXISTS `images`;
CREATE TABLE `images` (
  `img_id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `img_filename` varchar(512) DEFAULT NULL,
  `img_title` varchar(512) DEFAULT NULL,
  `img_width` mediumint(9) DEFAULT NULL,
  `img_height` mediumint(9) DEFAULT NULL,
  PRIMARY KEY (`img_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of images
-- ----------------------------
INSERT INTO `images` VALUES ('1', 'london_2423609b', 'Big Ben', '2330', '4400');
INSERT INTO `images` VALUES ('2', 'paris', 'Eiffeltoren', '3000', '4000');
INSERT INTO `images` VALUES ('3', 'berlin', 'De Muur', '5600', '1400');

-- ----------------------------
-- Table structure for `log_user`
-- ----------------------------
DROP TABLE IF EXISTS `log_user`;
CREATE TABLE `log_user` (
  `log_id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `log_usr_id` mediumint(9) DEFAULT NULL,
  `log_session_id` varchar(512) DEFAULT NULL,
  `log_in` datetime DEFAULT NULL,
  `log_out` datetime DEFAULT NULL,
  PRIMARY KEY (`log_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of log_user
-- ----------------------------
INSERT INTO `log_user` VALUES ('1', '26', 'ba10329f9859c2b18e9a2105418dd720', '2020-01-06 22:18:46', '2020-01-06 22:19:08');
INSERT INTO `log_user` VALUES ('2', '26', '37675d7ae3436c36b81001b3cebaa498', '2020-01-06 22:19:25', '2020-01-06 22:28:07');
INSERT INTO `log_user` VALUES ('3', '26', '8ee2dfc38ed33bba60b60f797ca9b41e', '2020-01-06 22:28:18', null);

-- ----------------------------
-- Table structure for `menu`
-- ----------------------------
DROP TABLE IF EXISTS `menu`;
CREATE TABLE `menu` (
  `men_id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `men_caption` varchar(127) DEFAULT NULL,
  `men_destination` varchar(512) DEFAULT NULL,
  `men_order` mediumint(9) DEFAULT NULL,
  PRIMARY KEY (`men_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of menu
-- ----------------------------
INSERT INTO `menu` VALUES ('1', 'Home', 'steden.php', '1');
INSERT INTO `menu` VALUES ('2', 'Over ons', 'over_ons.php', '2');
INSERT INTO `menu` VALUES ('3', 'Vacatures', 'vacatures.php', '3');
INSERT INTO `menu` VALUES ('4', 'Contact', 'contact.php', '4');
INSERT INTO `menu` VALUES ('5', 'Afmelden', 'lib/logout.php', '20');
INSERT INTO `menu` VALUES ('6', 'Weekoverzicht', 'week.php', '6');
INSERT INTO `menu` VALUES ('7', 'File Upload', 'file_upload.php', '7');
INSERT INTO `menu` VALUES ('8', 'Mijn historiek', 'historiek.php', '8');
INSERT INTO `menu` VALUES ('9', 'Download taken', 'download_taken.php', '9');
INSERT INTO `menu` VALUES ('10', 'Mijn profiel', 'profiel.php', '10');

-- ----------------------------
-- Table structure for `persoon`
-- ----------------------------
DROP TABLE IF EXISTS `persoon`;
CREATE TABLE `persoon` (
  `per_id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `per_voornaam` varchar(512) DEFAULT NULL,
  `per_naam` varchar(512) DEFAULT NULL,
  `per_email` varchar(512) DEFAULT NULL,
  PRIMARY KEY (`per_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of persoon
-- ----------------------------
INSERT INTO `persoon` VALUES ('2', 'steven', 'de ryck', 'steven@inform.be');
INSERT INTO `persoon` VALUES ('6', 'Jan', 'Jambon', 'jambon@vlregering.be');
INSERT INTO `persoon` VALUES ('7', 'Steven', 'D&#039;Hondt', 'steven@syntra.be');

-- ----------------------------
-- Table structure for `taak`
-- ----------------------------
DROP TABLE IF EXISTS `taak`;
CREATE TABLE `taak` (
  `taa_id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `taa_datum` date DEFAULT NULL,
  `taa_omschr` varchar(512) DEFAULT NULL,
  PRIMARY KEY (`taa_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of taak
-- ----------------------------
INSERT INTO `taak` VALUES ('1', '2019-12-10', 'Dag 9 - PHP1');
INSERT INTO `taak` VALUES ('2', '2019-12-12', 'Dag 10 - PHP1');
INSERT INTO `taak` VALUES ('3', '2019-12-10', 'Barbecue');

-- ----------------------------
-- Table structure for `users`
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `usr_id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `usr_voornaam` varchar(512) DEFAULT NULL,
  `usr_naam` varchar(512) DEFAULT NULL,
  `usr_login` varchar(512) DEFAULT NULL,
  `usr_paswd` varchar(512) DEFAULT NULL,
  `usr_straat` varchar(512) DEFAULT NULL,
  `usr_huisnr` varchar(30) DEFAULT NULL,
  `usr_busnr` varchar(30) DEFAULT NULL,
  `usr_postcode` varchar(10) DEFAULT NULL,
  `usr_gemeente` varchar(512) DEFAULT NULL,
  `usr_telefoon` varchar(30) DEFAULT NULL,
  `usr_pasfoto` varchar(512) DEFAULT NULL,
  `usr_vz_eid` varchar(512) DEFAULT NULL,
  `usr_az_eid` varchar(512) DEFAULT NULL,
  PRIMARY KEY (`usr_id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES ('24', 'Steven', 'De Ryck', 'steven@syntra.be', '$2y$10$7N0RWTAK2HrM4D1zK8sFJeVwmm0lEKZd.NkwNgApUHjwBjcjvUuLG', 'Oude baan', '2', '', '2800', 'Mechelen', '03 255 55 55', null, null, null);
INSERT INTO `users` VALUES ('25', 'Steven', 'Peeters', 'steven@fedgov.be', '$2y$10$yFiiGhLt58RDkzw/yd29dexmnJstl74fCRFYXX4yMGvHOETBzeaxa', 'Wetstraat', '16', '', '1000', 'Brussel', '02 222 22 22', null, null, null);
INSERT INTO `users` VALUES ('26', 'Bert', 'Peeters', 'bert@inform.be', '$2y$10$d5HyBPOTtxYnE./7IQDWWOu/EQyfh/d33BCUFNDgTJNYHcIC61TQ2', '', '', '', '', '', '', 'pasfoto_26.jpg', 'eidvoor_26.jpg', 'eidachter_26.jpg');
