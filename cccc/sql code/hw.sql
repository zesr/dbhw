-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 2018-01-04 12:25:48
-- 服务器版本： 5.7.14
-- PHP Version: 7.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hw`
--

-- --------------------------------------------------------

--
-- 表的结构 `field`
--

CREATE TABLE `field` (
  `fieldid` int(11) NOT NULL,
  `fieldname` varchar(45) NOT NULL,
  `stadiumid` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `field`
--

INSERT INTO `field` (`fieldid`, `fieldname`, `stadiumid`) VALUES
(10001, '#1 basketball field', 1),
(10002, '#2 basketball field', 1),
(20001, '#1 swimming pool', 2),
(10003, '#3 basketball field', 1),
(10004, '#4 basketball field', 1),
(20002, '#2 swimming pool', 2),
(20003, '#3 swimming pool', 2),
(20004, '#4 swimming pool', 2),
(30001, '#1 tennis field', 3),
(30002, '#2 tennis field', 3),
(30003, '#3 tennis field', 3),
(30004, '#4 tennis field', 3),
(40001, '#1 badminton field', 4),
(40002, '#2 badminton field', 4),
(40003, '#3 badminton field', 4),
(40004, '#4 badminton field', 4),
(40005, '#5 badminton field', 4),
(40006, '#6 badminton field', 4);

-- --------------------------------------------------------

--
-- 表的结构 `period`
--

CREATE TABLE `period` (
  `periodid` int(11) NOT NULL,
  `starttime` varchar(45) NOT NULL,
  `endtime` varchar(45) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `period`
--

INSERT INTO `period` (`periodid`, `starttime`, `endtime`) VALUES
(1, '8:00', '11:00'),
(2, '14:00', '17:00'),
(3, '19:00', '22:00');

-- --------------------------------------------------------

--
-- 表的结构 `session`
--

CREATE TABLE `session` (
  `sessionid` int(11) NOT NULL,
  `fieldid` int(11) NOT NULL,
  `periodid` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `session`
--

INSERT INTO `session` (`sessionid`, `fieldid`, `periodid`) VALUES
(1000101, 10001, 1),
(1000102, 10001, 2),
(1000103, 10001, 3),
(1000201, 10002, 1),
(1000202, 10002, 2),
(2000101, 20001, 1),
(2000102, 20001, 2),
(2000103, 20001, 3),
(1000203, 10002, 3),
(1000301, 10003, 1),
(1000302, 10003, 2),
(1000303, 10003, 3),
(1000401, 10004, 1),
(1000402, 10004, 2),
(1000403, 10004, 3),
(2000201, 20002, 1),
(2000202, 20002, 2),
(2000203, 20002, 3),
(2000301, 20003, 1),
(2000302, 20003, 2),
(2000303, 20003, 3),
(2000401, 20004, 1),
(2000402, 20004, 2),
(2000403, 20004, 3),
(3000101, 30001, 1),
(3000102, 30001, 2),
(3000103, 30001, 3),
(3000201, 30002, 1),
(3000202, 30002, 2),
(3000203, 30002, 3),
(3000301, 30003, 1),
(3000302, 30003, 2),
(3000303, 30003, 3),
(3000401, 30004, 1),
(3000402, 30004, 2),
(3000403, 30004, 3),
(4000101, 40001, 1),
(4000102, 40001, 2),
(4000103, 40001, 3),
(4000201, 40002, 1),
(4000202, 40002, 2),
(4000203, 40002, 3),
(4000301, 40003, 1),
(4000302, 40003, 2),
(4000303, 40003, 3),
(4000401, 40004, 1),
(4000402, 40004, 2),
(4000403, 40004, 3),
(4000501, 40005, 1),
(4000502, 40005, 2),
(4000503, 40005, 3),
(4000601, 40006, 1),
(4000602, 40006, 2),
(4000603, 40006, 3);

-- --------------------------------------------------------

--
-- 表的结构 `stadium`
--

CREATE TABLE `stadium` (
  `stadiumid` int(11) NOT NULL,
  `stadiumname` varchar(45) NOT NULL,
  `price` double NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `stadium`
--

INSERT INTO `stadium` (`stadiumid`, `stadiumname`, `price`) VALUES
(1, 'basketball stadium', 20),
(2, 'swimming stadium', 40),
(3, 'tennis stadium', 40),
(4, 'badminton stadium', 30);

-- --------------------------------------------------------

--
-- 表的结构 `user`
--

CREATE TABLE `user` (
  `uid` int(11) NOT NULL,
  `uname` varchar(45) NOT NULL,
  `balance` double NOT NULL DEFAULT '0',
  `password` varchar(45) NOT NULL,
  `phone` varchar(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `user`
--

INSERT INTO `user` (`uid`, `uname`, `balance`, `password`, `phone`) VALUES
(182029, 'Xander', 930, '123456a', '13160613801'),
(181594, 'Eas', 100, '123456a', '13160613801'),
(182022, 'haha', 40, '123456a', '13160613801'),
(100000, 'Ivory Law', 940, '123456a', '15707682470'),
(182025, 'tom', 400, '123456a', '13160613801'),
(188044, 'Henry', 200, '123456a', '13165613581'),
(1, '1', 0, '1', '1'),
(184897, 'Sebo', 1000, '8023dd', '13528033736'),
(2016170142, 'Eas', 50, '12345678', '15602968716');

-- --------------------------------------------------------

--
-- 表的结构 `userorder`
--

CREATE TABLE `userorder` (
  `oid` int(11) NOT NULL,
  `sessionid` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `entrytime` varchar(45) NOT NULL,
  `booktime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `valid` int(11) NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `userorder`
--

INSERT INTO `userorder` (`oid`, `sessionid`, `uid`, `entrytime`, `booktime`, `valid`) VALUES
(8, 1000302, 100000, 'Friday 14:00-17:00', '2018-01-04 09:03:46', 1),
(2, 1000203, 182029, 'Thusday 19:00-22:00', '2018-01-03 05:27:01', 0),
(3, 1000101, 182029, 'Thusday 8:00-11:00', '2018-01-03 10:53:39', 0),
(7, 1000203, 100000, 'Friday 19:00-22:00', '2018-01-04 09:03:44', 1),
(6, 1000102, 100000, 'Friday 14:00-17:00', '2018-01-04 09:03:42', 1),
(5, 1000202, 182029, 'Friday 14:00-17:00', '2018-01-04 09:01:14', 1),
(4, 1000101, 182029, 'Friday 8:00-11:00', '2018-01-04 08:34:37', 1),
(11, 1000301, 2016170142, 'Friday 8:00-11:00', '2018-01-04 12:06:06', 1),
(10, 1000201, 2016170142, 'Friday 8:00-11:00', '2018-01-04 12:05:58', 1),
(9, 1000103, 2016170142, 'Friday 19:00-22:00', '2018-01-04 12:04:44', 1),
(12, 1000402, 182029, 'Friday 14:00-17:00', '2018-01-04 12:06:38', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `field`
--
ALTER TABLE `field`
  ADD PRIMARY KEY (`fieldid`);

--
-- Indexes for table `period`
--
ALTER TABLE `period`
  ADD PRIMARY KEY (`periodid`);

--
-- Indexes for table `session`
--
ALTER TABLE `session`
  ADD PRIMARY KEY (`sessionid`);

--
-- Indexes for table `stadium`
--
ALTER TABLE `stadium`
  ADD PRIMARY KEY (`stadiumid`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`uid`);

--
-- Indexes for table `userorder`
--
ALTER TABLE `userorder`
  ADD PRIMARY KEY (`oid`);

DELIMITER $$
--
-- 事件
--
CREATE DEFINER=`root`@`localhost` EVENT `e_8` ON SCHEDULE AT '2018-01-05 00:00:00' ON COMPLETION NOT PRESERVE ENABLE DO update userorder set valid = 0 where oid = 8$$

CREATE DEFINER=`root`@`localhost` EVENT `e_6` ON SCHEDULE AT '2018-01-05 00:00:00' ON COMPLETION NOT PRESERVE ENABLE DO update userorder set valid = 0 where oid = 6$$

CREATE DEFINER=`root`@`localhost` EVENT `e_7` ON SCHEDULE AT '2018-01-05 00:00:00' ON COMPLETION NOT PRESERVE ENABLE DO update userorder set valid = 0 where oid = 7$$

CREATE DEFINER=`root`@`localhost` EVENT `e_5` ON SCHEDULE AT '2018-01-05 00:00:00' ON COMPLETION NOT PRESERVE ENABLE DO update userorder set valid = 0 where oid = 5$$

CREATE DEFINER=`root`@`localhost` EVENT `e_4` ON SCHEDULE AT '2018-01-05 00:00:00' ON COMPLETION NOT PRESERVE ENABLE DO update userorder set valid = 0 where oid = 4$$

CREATE DEFINER=`root`@`localhost` EVENT `e_11` ON SCHEDULE AT '2018-01-05 00:00:00' ON COMPLETION NOT PRESERVE ENABLE DO update userorder set valid = 0 where oid = 11$$

CREATE DEFINER=`root`@`localhost` EVENT `e_10` ON SCHEDULE AT '2018-01-05 00:00:00' ON COMPLETION NOT PRESERVE ENABLE DO update userorder set valid = 0 where oid = 10$$

CREATE DEFINER=`root`@`localhost` EVENT `e_9` ON SCHEDULE AT '2018-01-05 00:00:00' ON COMPLETION NOT PRESERVE ENABLE DO update userorder set valid = 0 where oid = 9$$

CREATE DEFINER=`root`@`localhost` EVENT `e_12` ON SCHEDULE AT '2018-01-05 00:00:00' ON COMPLETION NOT PRESERVE ENABLE DO update userorder set valid = 0 where oid = 12$$

DELIMITER ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
