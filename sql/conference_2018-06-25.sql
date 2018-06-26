# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 5.6.38)
# Database: conference
# Generation Time: 2018-06-25 07:16:19 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table attendee
# ------------------------------------------------------------

CREATE TABLE `attendee` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL COMMENT '论文id',
  `firstname` varchar(255) NOT NULL COMMENT '名',
  `lastname` varchar(255) NOT NULL COMMENT '姓',
  `email` varchar(255) NOT NULL COMMENT '邮箱',
  `country` varchar(255) NOT NULL DEFAULT '' COMMENT '国家',
  `organization` varchar(255) NOT NULL COMMENT '组织',
  `file` varchar(255) DEFAULT NULL COMMENT '注册凭证',
  `percentage` int(7) NOT NULL DEFAULT '50' COMMENT '进度',
  `is_check` varchar(4) NOT NULL DEFAULT 'No' COMMENT '查看状态',
  `is_accept` varchar(4) DEFAULT NULL COMMENT '确认状态',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `is_delete` tinyint(4) DEFAULT '0' COMMENT '删除状态',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table author
# ------------------------------------------------------------

CREATE TABLE `author` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `paper_id` int(11) NOT NULL COMMENT '论文id',
  `firstname` varchar(255) NOT NULL COMMENT '名',
  `lastname` varchar(255) NOT NULL COMMENT '姓',
  `email` varchar(255) NOT NULL COMMENT '邮箱',
  `country` varchar(255) DEFAULT NULL COMMENT '国家',
  `organization` varchar(255) DEFAULT NULL COMMENT '单位',
  `corresponding` varchar(7) DEFAULT 'No' COMMENT '通讯作者',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `is_delete` tinyint(4) DEFAULT '0' COMMENT '删除状态',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table paper
# ------------------------------------------------------------

CREATE TABLE `paper` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL COMMENT '作者id',
  `topic` varchar(255) NOT NULL COMMENT 'topic',
  `title` varchar(255) NOT NULL COMMENT '标题',
  `abstract` varchar(4096) NOT NULL COMMENT '摘要',
  `keywords` varchar(255) NOT NULL COMMENT '关键字',
  `file` varchar(255) NOT NULL DEFAULT '' COMMENT '论文',
  `percentage` int(7) NOT NULL DEFAULT '30' COMMENT '进度',
  `is_check` varchar(7) DEFAULT 'No' COMMENT '查看状态',
  `is_accept` varchar(7) DEFAULT '' COMMENT '录用状态',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `is_delete` tinyint(4) DEFAULT '0' COMMENT '删除状态',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table user
# ------------------------------------------------------------

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '名',
  `lastname` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '姓',
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '邮箱',
  `country` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '国家',
  `organization` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '单位',
  `auth_key` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '密码',
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建状态',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新状态',
  `is_delete` smallint(4) DEFAULT '0' COMMENT '删除状态',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;

INSERT INTO `user` (`id`, `firstname`, `lastname`, `email`, `country`, `organization`, `auth_key`, `password_hash`, `password_reset_token`, `created_at`, `updated_at`, `is_delete`)
VALUES
	(1,'admin','admin','admin@shu.edu.cn','China','SHU',NULL,'$2y$10$8uzdfrUjTCP.4kZObkwR3.rENDY.0LGVXufdiCCwrO18.PKoy0LKC',NULL,'2018-06-10 11:07:59','2018-06-10 11:10:09',0),
	(1396008,'Jerry','Chang','jerrychangcn@qq.com','China','SHU',NULL,'$2y$10$TiqodIETiSC5imF2HRxUnOo7dgWEwLHnuW.RO/ard7NuIkTNA3WzC',NULL,'2018-06-10 11:31:50','2018-06-10 11:31:50',0);

/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
