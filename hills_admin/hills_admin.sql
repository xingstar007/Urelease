-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2013 年 09 月 03 日 13:16
-- 服务器版本: 5.5.20-log
-- PHP 版本: 5.3.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `hills_admin`
--
CREATE DATABASE IF NOT EXISTS `hills_admin` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `hills_admin`;

-- --------------------------------------------------------

--
-- 表的结构 `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(45) DEFAULT NULL COMMENT '用户名',
  `password` varchar(200) DEFAULT NULL COMMENT '用户密码',
  `realname` varchar(10) DEFAULT NULL COMMENT '用户真实姓名',
  `role` varchar(45) DEFAULT NULL COMMENT '用户角色',
  `add_time` timestamp NULL DEFAULT NULL COMMENT '用户注册时间',
  `login_time` int(11) DEFAULT NULL COMMENT '用户登录次数',
  `last_login_time` timestamp NULL DEFAULT NULL COMMENT '用户最后一次登录时间',
  `phone_num` varchar(11) DEFAULT NULL COMMENT '用户电话',
  `img_dir` varchar(200) DEFAULT NULL COMMENT '头像存储路径',
  `ip` varchar(45) DEFAULT NULL COMMENT '最后一次登录ip',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='通用用户表' AUTO_INCREMENT=7 ;

--
-- 转存表中的数据 `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `realname`, `role`, `add_time`, `login_time`, `last_login_time`, `phone_num`, `img_dir`, `ip`) VALUES
(2, 'hills', '', '', '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', '', '', ''),
(3, 'hills2', '', '', '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', '', '', ''),
(4, '', '', '', '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', '', '', ''),
(5, 'hills', '097befc129095a6281cfad4c404a5e21', '', '', '2012-12-17 07:25:00', 0, '0000-00-00 00:00:00', '', '', ''),
(6, '123', '097befc129095a6281cfad4c404a5e21', '', '1', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', '', '', '');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
