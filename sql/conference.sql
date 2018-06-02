/*
 Navicat Premium Data Transfer

 Source Server         : 127.0.0.1
 Source Server Type    : MySQL
 Source Server Version : 50638
 Source Host           : localhost:3306
 Source Schema         : conference

 Target Server Type    : MySQL
 Target Server Version : 50638
 File Encoding         : 65001

 Date: 02/06/2018 11:44:35
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for author
-- ----------------------------
DROP TABLE IF EXISTS `author`;
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for migration
-- ----------------------------
DROP TABLE IF EXISTS `migration`;
CREATE TABLE `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for paper
-- ----------------------------
DROP TABLE IF EXISTS `paper`;
CREATE TABLE `paper` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL COMMENT '作者id',
  `title` varchar(255) NOT NULL COMMENT '标题',
  `abstract` varchar(4096) NOT NULL COMMENT '摘要',
  `keywords` varchar(255) NOT NULL COMMENT '关键字',
  `file` varchar(255) DEFAULT NULL COMMENT '论文',
  `is_check` varchar(7) DEFAULT 'No' COMMENT '查看状态',
  `is_accept` varchar(7) DEFAULT 'No' COMMENT '录用状态',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `is_delete` tinyint(4) DEFAULT '0' COMMENT '删除状态',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '名',
  `lastname` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '姓',
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '邮箱',
  `country` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '国家',
  `organization` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '单位',
  `auth_key` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建状态',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新状态',
  `is_delete` smallint(4) DEFAULT '0' COMMENT '删除状态',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9529971 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

SET FOREIGN_KEY_CHECKS = 1;
