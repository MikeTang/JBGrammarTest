# ************************************************************
# Sequel Pro SQL dump
# Version 4529
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 5.5.42)
# Database: yufa
# Generation Time: 2016-05-29 14:56:23 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table bugs
# ------------------------------------------------------------

DROP TABLE IF EXISTS `bugs`;

CREATE TABLE `bugs` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `content` varchar(256) DEFAULT '',
  `count` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `bugs` WRITE;
/*!40000 ALTER TABLE `bugs` DISABLE KEYS */;

INSERT INTO `bugs` (`id`, `content`, `count`)
VALUES
	(2,'http://yufa.jb.com/api/newBug/http:/yufa.jb.com/study/search',3),
	(3,'http://yufa.jb.com/api/newBug/http:/yufa.jb.com/test/grammar/6',4),
	(4,'http://yufa.jb.com/api/newBug/http:/yufa.jb.com',3),
	(5,'http://yufa.jb.com/api/newBug/http:/yufa.jb.com/study/0/26/1',6),
	(6,'http://yufa.jb.com/api/newBug/http:/yufa.jb.com/study/0/26/2',1),
	(7,'http://yufa.jb.com/api/newBug/http:/yufa.jb.com/study/0/26/3',1),
	(8,'http://yufa.jb.com/api/newBug/http:/yufa.jb.com/Signup/index',4);

/*!40000 ALTER TABLE `bugs` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table keywords
# ------------------------------------------------------------

DROP TABLE IF EXISTS `keywords`;

CREATE TABLE `keywords` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `content` varchar(256) DEFAULT '',
  `count` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `keywords` WRITE;
/*!40000 ALTER TABLE `keywords` DISABLE KEYS */;

INSERT INTO `keywords` (`id`, `content`, `count`)
VALUES
	(1,'aaa',1),
	(2,'b',2);

/*!40000 ALTER TABLE `keywords` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
