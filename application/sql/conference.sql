-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 23, 2019 at 08:38 AM
-- Server version: 10.3.16-MariaDB
-- PHP Version: 7.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `conference`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendee`
--

CREATE TABLE `attendee` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL COMMENT '用户id',
  `paper_id` int(11) UNSIGNED NOT NULL COMMENT '论文id',
  `author_id` int(11) UNSIGNED NOT NULL COMMENT '作者id',
  `firstname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '名',
  `lastname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '姓',
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '邮箱',
  `country` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '国家',
  `organization` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '组织',
  `file` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '注册凭证',
  `percentage` tinyint(4) UNSIGNED NOT NULL DEFAULT 50 COMMENT '进度',
  `is_accept` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '确认状态',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() COMMENT '创建时间',
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT '更新时间',
  `is_delete` tinyint(4) UNSIGNED NOT NULL DEFAULT 0 COMMENT '删除状态'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `author`
--

CREATE TABLE `author` (
  `id` int(11) UNSIGNED NOT NULL,
  `paper_id` int(11) UNSIGNED NOT NULL COMMENT '论文id',
  `firstname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '名',
  `lastname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '姓',
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '邮箱',
  `country` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '国家',
  `organization` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '单位',
  `corresponding` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'No' COMMENT '通讯作者',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() COMMENT '创建时间',
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT '更新时间',
  `is_delete` tinyint(4) UNSIGNED DEFAULT 0 COMMENT '删除状态'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `paper`
--

CREATE TABLE `paper` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL COMMENT '作者id',
  `topic` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'topic',
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '标题',
  `abstract` varchar(511) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '摘要',
  `keywords` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '关键字',
  `file` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '论文',
  `percentage` tinyint(4) UNSIGNED NOT NULL DEFAULT 30 COMMENT '进度',
  `is_accept` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '录用状态',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() COMMENT '创建时间',
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT '更新时间',
  `is_delete` tinyint(4) UNSIGNED NOT NULL DEFAULT 0 COMMENT '删除状态'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) UNSIGNED NOT NULL,
  `firstname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '名',
  `lastname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '姓',
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '邮箱',
  `country` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '国家',
  `organization` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '单位',
  `password_hash` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '密码',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() COMMENT '创建状态',
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT '更新状态',
  `is_delete` tinyint(4) UNSIGNED NOT NULL DEFAULT 0 COMMENT '删除状态'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `firstname`, `lastname`, `email`, `country`, `organization`, `password_hash`, `created_at`, `updated_at`, `is_delete`) VALUES
(1, 'admin', 'admin', 'adminpaper@shu.edu.cn', 'China', 'SHU', '$2y$10$8uzdfrUjTCP.4kZObkwR3.rENDY.0LGVXufdiCCwrO18.PKoy0LKC', '2018-06-10 11:07:59', '2018-06-26 16:06:40', 0),
(2, 'admin', 'admin', 'adminpeople@shu.edu.cn', 'China', 'SHU', '$2y$10$8uzdfrUjTCP.4kZObkwR3.rENDY.0LGVXufdiCCwrO18.PKoy0LKC', '2018-06-10 11:07:59', '2018-06-26 16:06:48', 0),
(1396008, 'Jerry', 'Chang', 'jerrychangcn@qq.com', 'China', 'SHU', '$2y$10$TiqodIETiSC5imF2HRxUnOo7dgWEwLHnuW.RO/ard7NuIkTNA3WzC', '2018-06-10 11:31:50', '2018-06-10 11:31:50', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendee`
--
ALTER TABLE `attendee`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `author`
--
ALTER TABLE `author`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `paper`
--
ALTER TABLE `paper`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attendee`
--
ALTER TABLE `attendee`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `author`
--
ALTER TABLE `author`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9551380;

--
-- AUTO_INCREMENT for table `paper`
--
ALTER TABLE `paper`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7722836;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1396011;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
