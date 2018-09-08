-- phpMyAdmin SQL Dump
-- version 4.6.6deb4
-- https://www.phpmyadmin.net/
--
-- 主機: localhost:3306
-- 產生時間： 2018 年 09 月 08 日 00:16
-- 伺服器版本: 10.1.26-MariaDB-0+deb9u1
-- PHP 版本： 7.0.19-1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `db2`
--

-- --------------------------------------------------------

--
-- 資料表結構 `cat_dayoff`
--

CREATE TABLE `cat_dayoff` (
  `serial` int(11) NOT NULL,
  `cat` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 資料表的匯出資料 `cat_dayoff`
--

INSERT INTO `cat_dayoff` (`serial`, `cat`) VALUES
(1, '特休'),
(2, '病假'),
(3, '事假'),
(4, '生理假'),
(5, '婚假'),
(6, '喪假'),
(7, '公假'),
(8, '產假'),
(9, '陪產假'),
(10, '產檢假');

-- --------------------------------------------------------

--
-- 資料表結構 `dayoff`
--

CREATE TABLE `dayoff` (
  `number` int(11) NOT NULL,
  `applyer` int(11) NOT NULL,
  `applydate` varchar(50) NOT NULL,
  `startdate` varchar(100) NOT NULL,
  `enddate` varchar(100) NOT NULL,
  `jobagent` varchar(20) NOT NULL,
  `supervisor` int(4) NOT NULL,
  `comment` varchar(200) NOT NULL,
  `dayoff` double NOT NULL,
  `cat` int(11) NOT NULL,
  `max_check_level` int(11) NOT NULL,
  `now_check_level` int(11) NOT NULL,
  `status` varchar(10) NOT NULL DEFAULT '-'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 資料表結構 `dayoff_record`
--

CREATE TABLE `dayoff_record` (
  `serial` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `usernumber` int(11) NOT NULL,
  `dayoff_log` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 資料表結構 `power`
--

CREATE TABLE `power` (
  `serial` int(11) NOT NULL,
  `cat` int(11) NOT NULL DEFAULT '1',
  `user_level` int(11) NOT NULL DEFAULT '1',
  `usernumber` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 資料表結構 `user`
--

CREATE TABLE `user` (
  `serial` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(30) NOT NULL,
  `usernumber` int(4) NOT NULL,
  `email` varchar(60) NOT NULL,
  `final_days` double NOT NULL,
  `actived` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 已匯出資料表的索引
--

--
-- 資料表索引 `cat_dayoff`
--
ALTER TABLE `cat_dayoff`
  ADD PRIMARY KEY (`serial`);

--
-- 資料表索引 `dayoff`
--
ALTER TABLE `dayoff`
  ADD PRIMARY KEY (`number`),
  ADD KEY `cat` (`cat`);

--
-- 資料表索引 `dayoff_record`
--
ALTER TABLE `dayoff_record`
  ADD PRIMARY KEY (`serial`);

--
-- 資料表索引 `power`
--
ALTER TABLE `power`
  ADD PRIMARY KEY (`serial`),
  ADD KEY `usernumber` (`usernumber`);

--
-- 資料表索引 `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`serial`),
  ADD KEY `usernumber` (`usernumber`);

--
-- 在匯出的資料表使用 AUTO_INCREMENT
--

--
-- 使用資料表 AUTO_INCREMENT `dayoff`
--
ALTER TABLE `dayoff`
  MODIFY `number` int(11) NOT NULL AUTO_INCREMENT;
--
-- 使用資料表 AUTO_INCREMENT `dayoff_record`
--
ALTER TABLE `dayoff_record`
  MODIFY `serial` int(11) NOT NULL AUTO_INCREMENT;
--
-- 使用資料表 AUTO_INCREMENT `power`
--
ALTER TABLE `power`
  MODIFY `serial` int(11) NOT NULL AUTO_INCREMENT;
--
-- 使用資料表 AUTO_INCREMENT `user`
--
ALTER TABLE `user`
  MODIFY `serial` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
--
-- 已匯出資料表的限制(Constraint)
--

--
-- 資料表的 Constraints `dayoff`
--
ALTER TABLE `dayoff`
  ADD CONSTRAINT `dayoff_ibfk_1` FOREIGN KEY (`cat`) REFERENCES `cat_dayoff` (`serial`);

--
-- 資料表的 Constraints `power`
--
ALTER TABLE `power`
  ADD CONSTRAINT `power_ibfk_1` FOREIGN KEY (`usernumber`) REFERENCES `user` (`usernumber`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
