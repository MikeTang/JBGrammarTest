# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: localhost (MySQL 5.5.42)
# Database: infinity
# Generation Time: 2016-05-23 07:20:33 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table locale
# ------------------------------------------------------------

DROP TABLE IF EXISTS `locale`;

CREATE TABLE `locale` (
  `locale` varchar(128) DEFAULT NULL,
  `titleWelcome` varchar(128) DEFAULT NULL,
  `btnLogin` varchar(128) DEFAULT NULL,
  `btnSignup` varchar(128) DEFAULT NULL,
  `btnLogout` varchar(128) DEFAULT NULL,
  `labelPhoneNumber` varchar(128) DEFAULT NULL,
  `btnGetCode` varchar(128) DEFAULT NULL,
  `labelValidationCode` varchar(128) DEFAULT NULL,
  `labelPassword` varchar(128) DEFAULT NULL,
  `labelRePassword` varchar(128) DEFAULT NULL,
  `textSelectAll` varchar(128) DEFAULT NULL,
  `txtEnterCode` varchar(128) DEFAULT NULL,
  `titleCompeteTheSentence` varchar(128) DEFAULT NULL,
  `btnBack` varchar(128) DEFAULT NULL,
  `btnNext` varchar(128) DEFAULT NULL,
  `titleTestComplete` varchar(128) DEFAULT NULL,
  `textHowWell` varchar(128) DEFAULT NULL,
  `textResultRecommendation` varchar(128) DEFAULT NULL,
  `btnRetake` varchar(128) DEFAULT NULL,
  `btnStartStudy` varchar(128) DEFAULT NULL,
  `btnStartTest` varchar(128) DEFAULT NULL,
  `linkBackTest` varchar(128) DEFAULT NULL,
  `titleGrammarDict` varchar(128) DEFAULT NULL,
  `btnStudyAll` varchar(128) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `locale` WRITE;
/*!40000 ALTER TABLE `locale` DISABLE KEYS */;

INSERT INTO `locale` (`locale`, `titleWelcome`, `btnLogin`, `btnSignup`, `btnLogout`, `labelPhoneNumber`, `btnGetCode`, `labelValidationCode`, `labelPassword`, `labelRePassword`, `textSelectAll`, `txtEnterCode`, `titleCompeteTheSentence`, `btnBack`, `btnNext`, `titleTestComplete`, `textHowWell`, `textResultRecommendation`, `btnRetake`, `btnStartStudy`, `btnStartTest`, `linkBackTest`, `titleGrammarDict`, `btnStudyAll`)
VALUES
	('en','Welcome to Grammar Test','Log In','Sign Up','Log Out','Phone Number','Get Code','Validation Code','Password','Repeat Password','Select all answers that apply','Enter Validation Code','Complete the sentence','back','next','Test Complete!','Let\'s see how well you did.','Recommended Study Units:','Retake Test','Start Studying','Start Test','Back to Test Result','Grammar Dictionary','Study All'),
	('cn','欢迎来到语法测试','登录','注册','注销','手机','发送验证码','验证码','密码','再次输入密码','选择适用的所有答案','输入验证码','完成句子','上一个','下一个','测试完成！','让我们看看成绩怎么样。','推荐学习单元：','重新考试','开始学习','开始测试','返回到成绩单','语法字典','学习所有');

/*!40000 ALTER TABLE `locale` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
