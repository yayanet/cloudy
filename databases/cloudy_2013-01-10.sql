# ************************************************************
# Sequel Pro SQL dump
# Version 3408
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: 127.0.0.1 (MySQL 5.5.17)
# Database: cloudy
# Generation Time: 2013-01-09 17:52:47 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table t_note
# ------------------------------------------------------------

DROP TABLE IF EXISTS `t_note`;

CREATE TABLE `t_note` (
  `note_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `content` text,
  `ctime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `update_time` timestamp NULL DEFAULT NULL,
  `notebook_id` int(11) NOT NULL,
  `version` int(11) NOT NULL,
  PRIMARY KEY (`note_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Dump of table t_notebook
# ------------------------------------------------------------

DROP TABLE IF EXISTS `t_notebook`;

CREATE TABLE `t_notebook` (
  `notebook_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL DEFAULT '',
  `ctime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`notebook_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Dump of table t_session
# ------------------------------------------------------------

DROP TABLE IF EXISTS `t_session`;

CREATE TABLE `t_session` (
  `session_id` char(32) NOT NULL DEFAULT '',
  `user_id` int(11) NOT NULL,
  `ctime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `client_id` smallint(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`session_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Dump of table t_user
# ------------------------------------------------------------

DROP TABLE IF EXISTS `t_user`;

CREATE TABLE `t_user` (
  `user_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `email` char(64) NOT NULL DEFAULT '',
  `password` char(32) NOT NULL DEFAULT '',
  `ctime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;




/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
