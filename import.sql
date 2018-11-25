-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- 主机： mysql
-- 生成日期： 2018-11-25 04:34:19
-- 服务器版本： 8.0.13
-- PHP 版本： 7.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 数据库： `fly_rating`
--

-- --------------------------------------------------------

--
-- 表的结构 `rates`
--

CREATE TABLE `rates` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `sid` int(11) NOT NULL,
  `rate1` int(11) NOT NULL,
  `rate2` int(11) NOT NULL,
  `rate3` int(11) NOT NULL,
  `comment` text,
  `name` text,
  `grade` text,
  `class` text,
  `number` text,
  `ip` text,
  `ua` text,
  `time` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- 表的结构 `shops`
--

CREATE TABLE `shops` (
  `id` int(11) NOT NULL,
  `name` text,
  `descrp` text,
  `main_pic` text,
  `rate1` double NOT NULL DEFAULT '0',
  `rate2` double NOT NULL DEFAULT '0',
  `rate3` double NOT NULL DEFAULT '0',
  `rate` double NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- 转储表的索引
--

--
-- 表的索引 `rates`
--
ALTER TABLE `rates`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `shops`
--
ALTER TABLE `shops`
  ADD PRIMARY KEY (`id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `rates`
--
ALTER TABLE `rates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `shops`
--
ALTER TABLE `shops`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
