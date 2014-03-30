-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2014 年 03 月 30 日 07:53
-- 服务器版本: 5.0.96
-- PHP 版本: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `cloud_lab`
--

-- --------------------------------------------------------

--
-- 表的结构 `t_ask_info`
--

CREATE TABLE IF NOT EXISTS `t_ask_info` (
  `ASK_ID` int(10) unsigned NOT NULL auto_increment,
  `PPT_ID` int(11) unsigned NOT NULL,
  `PPT_URL` text collate utf8_unicode_ci NOT NULL,
  `CLASS_ID` int(11) unsigned NOT NULL,
  `STUDENT_ID` int(11) unsigned NOT NULL,
  `ASK_CONTENT` text collate utf8_unicode_ci NOT NULL,
  `ASK_ANSWER` text collate utf8_unicode_ci,
  `TOP1` double default NULL,
  `TOP2` double default NULL,
  `LEFT1` double default NULL,
  `LEFT2` double default NULL,
  `TIMESTAMP` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`ASK_ID`),
  KEY `PPT_ID` (`PPT_ID`),
  KEY `CLASS_ID` (`CLASS_ID`),
  KEY `STUDENT_ID` (`STUDENT_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `t_ask_info`
--


-- --------------------------------------------------------

--
-- 表的结构 `t_class_info`
--

CREATE TABLE IF NOT EXISTS `t_class_info` (
  `CLASS_ID` int(10) unsigned NOT NULL auto_increment,
  `TEACHER_ID` int(10) unsigned default NULL,
  `COURSE_ID` int(10) unsigned NOT NULL,
  `CLASS_NAME` varchar(40) collate utf8_unicode_ci NOT NULL,
  `CLASS_BEGIN` date NOT NULL,
  `CLASS_END` date NOT NULL,
  `TIMESTAMP` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`CLASS_ID`),
  KEY `t_class_info_ibfk_1` (`TEACHER_ID`),
  KEY `COURSE_ID` (`COURSE_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `t_class_info`
--

INSERT INTO `t_class_info` (`CLASS_ID`, `TEACHER_ID`, `COURSE_ID`, `CLASS_NAME`, `CLASS_BEGIN`, `CLASS_END`, `TIMESTAMP`) VALUES
(1, 5, 2, 'Gec DB course', '2013-12-09', '2014-01-04', '2014-01-09 23:18:06'),
(2, 5, 1, 'HTML class 1', '2013-11-26', '2014-12-24', '2014-01-09 23:17:54'),
(3, 5, 3, 'Oracle class', '2014-03-18', '2014-03-29', '2014-03-11 22:41:22');

-- --------------------------------------------------------

--
-- 表的结构 `t_class_user_rel`
--

CREATE TABLE IF NOT EXISTS `t_class_user_rel` (
  `CLASS_USER_REL_ID` int(10) unsigned NOT NULL auto_increment,
  `USER_ID` int(10) unsigned NOT NULL,
  `CLASS_ID` int(10) unsigned NOT NULL,
  `GRADE` int(10) unsigned NOT NULL,
  `TIMESTAMP` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`CLASS_USER_REL_ID`),
  KEY `USER_ID` (`USER_ID`),
  KEY `CLASS_ID` (`CLASS_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=25 ;

--
-- 转存表中的数据 `t_class_user_rel`
--

INSERT INTO `t_class_user_rel` (`CLASS_USER_REL_ID`, `USER_ID`, `CLASS_ID`, `GRADE`, `TIMESTAMP`) VALUES
(6, 3, 1, 32, '2014-01-10 15:42:59'),
(7, 4, 2, 0, '2013-12-28 22:09:58'),
(11, 4, 1, 0, '2014-01-10 15:43:22'),
(14, 3, 3, 0, '2014-03-11 22:44:18'),
(15, 4, 3, 0, '2014-03-11 22:44:23'),
(16, 6, 3, 0, '2014-03-22 11:45:54'),
(17, 7, 3, 0, '2014-03-22 11:46:02'),
(18, 8, 3, 0, '2014-03-22 11:46:09'),
(19, 9, 3, 0, '2014-03-22 11:46:14'),
(20, 10, 3, 0, '2014-03-22 11:46:20'),
(21, 11, 3, 0, '2014-03-22 11:46:25'),
(22, 12, 3, 0, '2014-03-22 11:46:31'),
(23, 13, 3, 0, '2014-03-22 11:46:42'),
(24, 14, 3, 0, '2014-03-22 11:46:49');

-- --------------------------------------------------------

--
-- 表的结构 `t_course_det`
--

CREATE TABLE IF NOT EXISTS `t_course_det` (
  `COURSE_ID` int(10) unsigned NOT NULL auto_increment,
  `CHARPTER_ID` tinyint(3) unsigned NOT NULL,
  `LESSON_SEQ` tinyint(3) unsigned NOT NULL,
  `TIMESTAMP` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`COURSE_ID`,`CHARPTER_ID`,`LESSON_SEQ`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `t_course_det`
--

INSERT INTO `t_course_det` (`COURSE_ID`, `CHARPTER_ID`, `LESSON_SEQ`, `TIMESTAMP`) VALUES
(1, 1, 3, '2013-12-29 12:45:07'),
(1, 2, 4, '0000-00-00 00:00:00'),
(1, 3, 2, '0000-00-00 00:00:00'),
(2, 1, 3, '0000-00-00 00:00:00'),
(2, 2, 3, '0000-00-00 00:00:00'),
(2, 3, 2, '2014-01-10 16:47:55'),
(2, 4, 4, '0000-00-00 00:00:00'),
(2, 5, 3, '2014-01-10 16:47:32'),
(3, 1, 3, '2014-03-11 22:49:13'),
(3, 2, 4, '2014-03-11 22:49:22'),
(3, 3, 5, '2014-03-11 22:49:28'),
(3, 4, 6, '2014-03-11 22:49:34'),
(3, 5, 2, '2014-03-11 22:49:40');

-- --------------------------------------------------------

--
-- 表的结构 `t_course_info`
--

CREATE TABLE IF NOT EXISTS `t_course_info` (
  `COURSE_ID` int(10) unsigned NOT NULL auto_increment,
  `COURSE_NAME` varchar(40) collate utf8_unicode_ci NOT NULL,
  `COURSE_IMAGE` text collate utf8_unicode_ci,
  `COURSE_DESC` text collate utf8_unicode_ci,
  `COURSE_NUM` tinyint(4) unsigned NOT NULL,
  `CHARPTER_NUM` tinyint(4) unsigned NOT NULL,
  `TRAIN_ID` int(10) unsigned default NULL,
  `TIMESTAMP` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`COURSE_ID`),
  KEY `t_course_info_ibfk_1` (`TRAIN_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `t_course_info`
--

INSERT INTO `t_course_info` (`COURSE_ID`, `COURSE_NAME`, `COURSE_IMAGE`, `COURSE_DESC`, `COURSE_NUM`, `CHARPTER_NUM`, `TRAIN_ID`, `TIMESTAMP`) VALUES
(1, 'HTML5', '/image/course-html5.png', 'Design your own amazing pages!', 100, 3, NULL, '2014-03-22 12:52:04'),
(2, 'Database', '/image/course-database.png', 'Delve into the essence of database.', 120, 5, NULL, '2014-03-22 12:54:38'),
(3, 'PLSQL', '/image/course-PLSQL.png', 'Practice SQL in the actual training.', 100, 5, NULL, '2014-03-22 09:01:59');

-- --------------------------------------------------------

--
-- 表的结构 `t_homework_info`
--

CREATE TABLE IF NOT EXISTS `t_homework_info` (
  `HOMEWORK_ID` int(10) unsigned NOT NULL auto_increment,
  `STUDENT_NUM` tinyint(3) unsigned default '1' COMMENT 'maximum student number limitation for this homework',
  `CLASS_ID` int(10) unsigned NOT NULL,
  `COURSE_CHARPTER` int(10) unsigned NOT NULL,
  `LESSON_SEQ` int(10) unsigned NOT NULL,
  `DEADLINE` datetime NOT NULL,
  `TIMESTAMP` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`HOMEWORK_ID`),
  KEY `CLASS_ID` (`CLASS_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=13 ;

--
-- 转存表中的数据 `t_homework_info`
--

INSERT INTO `t_homework_info` (`HOMEWORK_ID`, `STUDENT_NUM`, `CLASS_ID`, `COURSE_CHARPTER`, `LESSON_SEQ`, `DEADLINE`, `TIMESTAMP`) VALUES
(11, 1, 2, 1, 1, '2015-01-01 00:00:00', '2014-01-07 21:47:47'),
(12, 1, 3, 1, 1, '0000-00-00 00:00:00', '2014-03-21 10:29:33');

-- --------------------------------------------------------

--
-- 表的结构 `t_homework_question_rel`
--

CREATE TABLE IF NOT EXISTS `t_homework_question_rel` (
  `HOMEWORK_QUESTION_REL_ID` int(10) unsigned NOT NULL auto_increment,
  `HOMEWORK_ID` int(10) unsigned NOT NULL,
  `QUESTION_ID` int(10) unsigned NOT NULL,
  `TIMESTAMP` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`HOMEWORK_QUESTION_REL_ID`),
  KEY `HOMEWORK_ID` (`HOMEWORK_ID`),
  KEY `QUESTION_ID` (`QUESTION_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=7 ;

--
-- 转存表中的数据 `t_homework_question_rel`
--

INSERT INTO `t_homework_question_rel` (`HOMEWORK_QUESTION_REL_ID`, `HOMEWORK_ID`, `QUESTION_ID`, `TIMESTAMP`) VALUES
(5, 11, 2, '2014-01-07 21:47:47'),
(6, 11, 3, '2014-01-07 21:47:47');

-- --------------------------------------------------------

--
-- 表的结构 `t_homework_response_rel`
--

CREATE TABLE IF NOT EXISTS `t_homework_response_rel` (
  `HOMEWORK_RESPONSE_REL_ID` int(10) unsigned NOT NULL auto_increment,
  `HOMEWORK_ID` int(11) unsigned NOT NULL,
  `QUESTION_ID` int(11) unsigned NOT NULL,
  `STUDENT_ID` int(11) unsigned NOT NULL,
  `ANSWER_CONTENT` text collate utf8_unicode_ci NOT NULL,
  `TIMESTAMP` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`HOMEWORK_RESPONSE_REL_ID`),
  KEY `HOMEWORK_ID` (`HOMEWORK_ID`),
  KEY `QUESTION_ID` (`QUESTION_ID`),
  KEY `STUDENT_ID` (`STUDENT_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `t_homework_response_rel`
--


-- --------------------------------------------------------

--
-- 表的结构 `t_ppt_det`
--

CREATE TABLE IF NOT EXISTS `t_ppt_det` (
  `PPT_ID` int(10) unsigned NOT NULL auto_increment,
  `PPT_PAGE_NUM` int(10) unsigned NOT NULL,
  `PIC_URL` text collate utf8_unicode_ci NOT NULL,
  `VIDEO_SECTION` int(10) unsigned default NULL COMMENT 'Seconds from the beginning',
  `TIMESTAMP` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`PPT_ID`,`PPT_PAGE_NUM`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=8 ;

--
-- 转存表中的数据 `t_ppt_det`
--

INSERT INTO `t_ppt_det` (`PPT_ID`, `PPT_PAGE_NUM`, `PIC_URL`, `VIDEO_SECTION`, `TIMESTAMP`) VALUES
(1, 1, '/image/HTML5/charpter1-01.PNG', 111, '2014-01-06 23:29:44'),
(1, 2, '/image/HTML5/charpter1-02.PNG', 112, '2014-01-06 23:11:57'),
(1, 3, '/image/HTML5/charpter1-03.PNG', 113, '2014-01-06 23:12:04'),
(1, 4, '/image/HTML5/charpter1-04.PNG', 114, '2014-01-06 23:12:15'),
(1, 5, '/image/HTML5/charpter1-05.PNG', 115, '2014-01-06 23:12:21'),
(2, 1, '/image/HTML5/charpter1-01.PNG', 121, '2014-01-06 23:12:27'),
(2, 2, '/image/HTML5/charpter1-02.PNG', 122, '2014-01-06 23:12:35'),
(2, 3, '/image/HTML5/charpter1-03.PNG', 123, '2014-01-06 23:12:44'),
(2, 4, '/image/HTML5/charpter1-04.PNG', 124, '2014-01-06 23:12:52'),
(2, 5, '/image/HTML5/charpter1-05.PNG', 125, '2014-01-06 23:13:00'),
(2, 6, '/image/HTML5/charpter1-01.PNG', 126, '2014-01-06 23:13:07'),
(2, 7, '/image/HTML5/charpter1-02.PNG', 127, '2014-01-06 23:13:15'),
(3, 1, '/image/HTML5/charpter1-03.PNG', 131, '2014-01-06 23:13:23'),
(3, 2, '/image/HTML5/charpter1-04.PNG', 132, '2014-01-06 23:13:31'),
(4, 1, '/image/PrinciplesOfDatabase/1-1-01.png', 0, '2014-01-10 14:13:58'),
(4, 2, '/image/PrinciplesOfDatabase/1-1-02.png', 15, '2014-01-10 14:14:02'),
(4, 3, '/image/PrinciplesOfDatabase/1-1-03.png', 440, '2014-01-10 14:14:07'),
(4, 4, '/image/PrinciplesOfDatabase/1-1-04.png', 1041, '2014-01-10 14:14:09'),
(4, 5, '/image/PrinciplesOfDatabase/1-1-05.png', 1733, '2014-01-10 14:14:13'),
(5, 1, '/image/PrinciplesOfDatabase/1-1-01.png', 0, '2014-01-10 14:14:18'),
(5, 2, '/image/PrinciplesOfDatabase/1-1-02.png', 15, '2014-01-10 14:14:21'),
(5, 3, '/image/PrinciplesOfDatabase/1-1-03.png', 440, '2014-01-10 14:14:24'),
(5, 4, '/image/PrinciplesOfDatabase/1-1-04.png', 1041, '2014-01-10 14:14:28'),
(5, 5, '/image/PrinciplesOfDatabase/1-1-05.png', 1733, '2014-01-10 14:14:30'),
(6, 1, '/image/PrinciplesOfDatabase/1-1-01.png', 0, '2014-01-10 14:14:35'),
(6, 2, '/image/PrinciplesOfDatabase/1-1-02.png', 15, '2014-01-10 14:14:39'),
(6, 3, '/image/PrinciplesOfDatabase/1-1-03.png', 440, '2014-01-10 14:14:47'),
(6, 4, '/image/PrinciplesOfDatabase/1-1-04.png', 1041, '2014-01-10 14:14:55'),
(6, 5, '/image/PrinciplesOfDatabase/1-1-06.png', 1733, '2014-01-10 14:15:01'),
(7, 1, '/image/PLSQL/1-1-01.JPG', NULL, '2014-03-11 22:52:20'),
(7, 2, '/image/PLSQL/1-1-02.JPG', NULL, '2014-03-11 22:52:24'),
(7, 3, '/image/PLSQL/1-1-03.JPG', NULL, '2014-03-11 22:53:01'),
(7, 5, '/image/PLSQL/1-1-05.JPG', NULL, '2014-03-11 22:53:39'),
(7, 6, '/image/PLSQL/1-1-06.JPG', NULL, '2014-03-11 22:53:54'),
(7, 7, '/image/PLSQL/1-1-07.JPG', NULL, '2014-03-11 22:54:02'),
(7, 8, '/image/PLSQL/1-1-08.JPG', NULL, '2014-03-11 22:54:14'),
(7, 9, '/image/PLSQL/1-1-09.JPG', NULL, '2014-03-11 22:54:22'),
(7, 10, '/image/PLSQL/1-1-10.JPG', NULL, '2014-03-11 22:54:29'),
(7, 11, '/image/PLSQL/1-1-11.JPG', NULL, '2014-03-11 22:54:37'),
(7, 12, '/image/PLSQL/1-1-12.JPG', NULL, '2014-03-11 22:55:16'),
(7, 13, '/image/PLSQL/1-1-13.JPG', NULL, '2014-03-11 22:55:28'),
(7, 14, '/image/PLSQL/1-1-14.JPG', NULL, '2014-03-11 22:55:39'),
(7, 15, '/image/PLSQL/1-1-15.JPG', NULL, '2014-03-11 22:56:03'),
(7, 16, '/image/PLSQL/1-1-16.JPG', NULL, '2014-03-11 22:56:11'),
(7, 17, '/image/PLSQL/1-1-17.JPG', NULL, '2014-03-11 22:56:25'),
(7, 18, '/image/PLSQL/1-1-18.JPG', NULL, '2014-03-11 22:56:38'),
(7, 19, '/image/PLSQL/1-1-19.JPG', NULL, '2014-03-11 22:56:48'),
(7, 20, '/image/PLSQL/1-1-20.JPG', NULL, '2014-03-11 22:57:07'),
(7, 21, '/image/PLSQL/1-1-21.JPG', NULL, '2014-03-11 22:57:21'),
(7, 22, '/image/PLSQL/1-1-22.JPG', NULL, '2014-03-11 22:57:31'),
(7, 23, '/image/PLSQL/1-1-23.JPG', NULL, '2014-03-11 22:57:40'),
(7, 24, '/image/PLSQL/1-1-24.JPG', NULL, '2014-03-11 22:57:47'),
(7, 25, '/image/PLSQL/1-1-25.JPG', NULL, '2014-03-11 22:57:56'),
(7, 26, '/image/PLSQL/1-1-26.JPG', NULL, '2014-03-11 22:58:05'),
(7, 27, '/image/PLSQL/1-1-27.JPG', NULL, '2014-03-11 22:58:13'),
(7, 28, '/image/PLSQL/1-1-28.JPG', NULL, '2014-03-11 22:58:21');

-- --------------------------------------------------------

--
-- 表的结构 `t_ppt_info`
--

CREATE TABLE IF NOT EXISTS `t_ppt_info` (
  `PPT_ID` int(10) unsigned NOT NULL auto_increment,
  `COURSE_ID` int(10) unsigned NOT NULL,
  `COURSE_CHARPTER` tinyint(4) unsigned NOT NULL,
  `LESSON_SEQ` tinyint(4) unsigned NOT NULL,
  `PDF_URL` text collate utf8_unicode_ci NOT NULL COMMENT 'url of course pdf corresponding the exact ppt',
  `VIDEO_URL` text collate utf8_unicode_ci COMMENT 'course video''s url',
  `TIMESTAMP` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`PPT_ID`),
  KEY `COURSE_ID` (`COURSE_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT AUTO_INCREMENT=8 ;

--
-- 转存表中的数据 `t_ppt_info`
--

INSERT INTO `t_ppt_info` (`PPT_ID`, `COURSE_ID`, `COURSE_CHARPTER`, `LESSON_SEQ`, `PDF_URL`, `VIDEO_URL`, `TIMESTAMP`) VALUES
(1, 1, 1, 1, 'as', '/video/PrinciplesOfDatabase/1-1.mp4', '2014-01-10 17:18:42'),
(2, 1, 1, 2, 'as', '/video/PrinciplesOfDatabase/1-1.mp4', '2014-01-10 17:18:44'),
(3, 1, 1, 3, '1232ss', '/video/PrinciplesOfDatabase/1-1.mp4', '2014-01-10 17:18:47'),
(4, 2, 1, 1, '/pdf/PrinciplesOfDatabase/1-1.pdf', '/video/PrinciplesOfDatabase/1-1.mp4', '2014-01-10 14:13:26'),
(5, 2, 1, 2, '/pdf/PrinciplesOfDatabase/1-1.pdf', '/video/PrinciplesOfDatabase/1-1.mp4', '2014-01-10 14:13:28'),
(6, 2, 1, 3, '/pdf/PrinciplesOfDatabase/1-1.pdf', '/video/PrinciplesOfDatabase/1-1.mp4', '2014-01-10 14:13:38'),
(7, 3, 1, 1, '121', '/video/PrinciplesOfDatabase/1-1.mp4', '2014-03-11 22:51:06');

-- --------------------------------------------------------

--
-- 表的结构 `t_ppt_remark`
--

CREATE TABLE IF NOT EXISTS `t_ppt_remark` (
  `CLASS_ID` int(10) unsigned NOT NULL auto_increment,
  `PPT_ID` int(10) unsigned NOT NULL,
  `USER_ID` int(10) unsigned NOT NULL,
  `PPT_PAGE_NUM` int(10) unsigned NOT NULL,
  `REMARK` text character set utf8 collate utf8_unicode_ci NOT NULL,
  `TIMESTAMP` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`CLASS_ID`,`PPT_ID`,`PPT_PAGE_NUM`,`USER_ID`),
  KEY `PPT_ID` (`PPT_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `t_ppt_remark`
--

INSERT INTO `t_ppt_remark` (`CLASS_ID`, `PPT_ID`, `USER_ID`, `PPT_PAGE_NUM`, `REMARK`, `TIMESTAMP`) VALUES
(3, 7, 5, 1, '要讲清楚PLSQL的相关概念', '2014-03-22 14:23:02'),
(3, 7, 5, 2, '概述可以略过', '2014-03-22 14:21:23'),
(3, 7, 5, 5, ' 特点要详述', '2014-03-22 14:24:05');

-- --------------------------------------------------------

--
-- 表的结构 `t_preparation`
--

CREATE TABLE IF NOT EXISTS `t_preparation` (
  `PREPARATION_ID` int(10) unsigned NOT NULL auto_increment,
  `COURSE_ID` int(10) unsigned NOT NULL,
  `COURSE_CHARPTER` tinyint(4) unsigned NOT NULL,
  `LESSON_SEQ` tinyint(4) unsigned NOT NULL,
  `CONTENT` varchar(255) NOT NULL,
  `TIMESTAMP` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`PREPARATION_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- 转存表中的数据 `t_preparation`
--

INSERT INTO `t_preparation` (`PREPARATION_ID`, `COURSE_ID`, `COURSE_CHARPTER`, `LESSON_SEQ`, `CONTENT`, `TIMESTAMP`) VALUES
(1, 2, 1, 1, '', '2014-03-12 22:45:39'),
(2, 1, 1, 1, 'lanxiang', '2014-03-12 22:03:06'),
(3, 2, 2, 1, 'lanxiang', '2014-03-12 22:03:02'),
(4, 2, 2, 12, 'lanxiang', '2014-03-12 22:02:57'),
(5, 3, 1, 1, '', '2014-03-20 21:29:04');

-- --------------------------------------------------------

--
-- 表的结构 `t_progress`
--

CREATE TABLE IF NOT EXISTS `t_progress` (
  `CLASS_ID` int(10) unsigned NOT NULL auto_increment,
  `PRE_CHARPTER_ID` tinyint(3) unsigned NOT NULL default '1',
  `PRE_LESSON_ID` tinyint(3) unsigned NOT NULL default '0',
  `ON_CHARPTER_ID` tinyint(3) unsigned NOT NULL default '1',
  `ON_LESSON_ID` tinyint(3) unsigned NOT NULL default '0',
  `TIMESTAMP` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`CLASS_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `t_progress`
--

INSERT INTO `t_progress` (`CLASS_ID`, `PRE_CHARPTER_ID`, `PRE_LESSON_ID`, `ON_CHARPTER_ID`, `ON_LESSON_ID`, `TIMESTAMP`) VALUES
(1, 1, 1, 3, 1, '2014-03-22 15:02:10'),
(2, 1, 1, 2, 2, '2014-03-22 15:02:15'),
(3, 1, 1, 1, 1, '2014-03-12 22:03:33');

-- --------------------------------------------------------

--
-- 表的结构 `t_question_info`
--

CREATE TABLE IF NOT EXISTS `t_question_info` (
  `QUESTION_ID` int(11) unsigned NOT NULL auto_increment,
  `QUESTION_CONTENT` text collate utf8_unicode_ci NOT NULL,
  `ANSWER` text collate utf8_unicode_ci NOT NULL,
  `TIMESTAMP` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`QUESTION_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=11 ;

--
-- 转存表中的数据 `t_question_info`
--

INSERT INTO `t_question_info` (`QUESTION_ID`, `QUESTION_CONTENT`, `ANSWER`, `TIMESTAMP`) VALUES
(1, '什么是事务？它有哪些属性？', '事务是用户定义的一个操作序列，这些操作要么全做要么全不做，事务是一个不可分割的工作单位。事务具有四个特性：原子性、一致性、隔离性和持续性。\r\n这个四个特性也简称为ACID特性。', '2014-01-10 16:27:10'),
(2, '简述数据库的物理设计内容', '主要包括了以下工作：\r\n(1) 确定数据的存储结构，决定是否采用聚簇功能。\r\n(2）设计数据的存取路径，决定是否建立索引，建多少索引，在哪些列或多列上建索引等。 \r\n(3）确定数据的存放的物理位置，决定是否将经常存取部分和存取频率较低部分分开存放等。 \r\n(4）确定系统配置参数，根据DBMS产品提供了一些存储分配参数，数据库进行物理优化。\r\n(5) 评价物理结构, 估算各种方案的存储空间、存取时间和维护代价，对估算结果进行权衡、比较，选择出一个较优的合理的物理结构。', '2014-01-10 16:27:33'),
(3, 'RDBMS在实现参照完整性时需要考虑哪些方面的问题，以及可以采取的策略？', '1）外码能否接受空值\r\n   （2）删除被参照关系中的元组。这时可有三种不同的策略： \r\n    . 级联删除：同时删除参照关系中相关元组； \r\n    . 受限删除：仅当参照关系中没有任何元组的外码值与被参照关系中要删除元组的主码值相同时，系统才执行删除操作，否则拒绝此删除操作。 \r\n     .置空值删除：删除被参照关系的元组，并将参照关系中相应元组的外码值置空值。 \r\n( 3 ) 在参照关系中插入元组\r\n        当参照关系插入某个元组，而被参照关系不存在相应的元组，其主码值与参照关系插入元组的外码值相同，这时可有以下策略： \r\n     .受限插入：不允许在参照关系中插入； \r\n     .递归插入：同时在被参照关系中插入一个元组，其主码值为插入元组的外码值。', '2014-01-10 16:28:12'),
(4, '简述预防死锁通常有两种方法。', '预防死锁通常有两种：一次封锁法和顺序封锁法。\r\n       一次封锁法：一次封锁法要求每个事务必须一次将所有要使用的数据全部加锁，否则就不能继续执行。一次封锁法虽然可以有效地防止死锁的发生，但每次要就将以后用到的全部数据加锁，从而降低了系统的并发度。\r\n       顺序封锁法：顺序封锁法是预先对数据对象规定一个封锁顺序，所有事务都按这个顺序实行封锁', '2014-01-10 16:30:04'),
(5, '编写一个PL/SQL程序块，计算100以内的奇数和。', '<table border="0" cellpadding="0" cellspacing="0"><tbody><tr><td class="gutter"><div class="line number1 index0 alt2">1</div><div class="line number2 index1 alt1">2</div><div class="line number3 index2 alt2">3</div><div class="line number4 index3 alt1">4</div><div class="line number5 index4 alt2">5</div><div class="line number6 index5 alt1">6</div><div class="line number7 index6 alt2">7</div><div class="line number8 index7 alt1">8</div><div class="line number9 index8 alt2">9</div><div class="line number10 index9 alt1">10</div><div class="line number11 index10 alt2">11</div></td><td class="code"><div class="container"><div class="line number1 index0 alt2"><code class="plain plain">declare</code></div><div class="line number2 index1 alt1"><code class="plain plain">v_num integer:=1;</code></div><div class="line number3 index2 alt2"><code class="plain plain">v_sum integer:=0;</code></div><div class="line number4 index3 alt1"><code class="plain plain">begin</code></div><div class="line number5 index4 alt2"><code class="plain spaces">&nbsp;&nbsp;&nbsp;</code><code class="plain plain">while v_num&lt;100</code></div><div class="line number6 index5 alt1"><code class="plain spaces">&nbsp;&nbsp;&nbsp;</code><code class="plain plain">loop</code></div><div class="line number7 index6 alt2"><code class="plain spaces">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</code><code class="plain plain">v_sum:=v_sum+v_num;</code></div><div class="line number8 index7 alt1"><code class="plain spaces">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</code><code class="plain plain">v_num:=v_num+2;</code></div><div class="line number9 index8 alt2"><code class="plain spaces">&nbsp;&nbsp;&nbsp;</code><code class="plain plain">end loop;</code></div><div class="line number10 index9 alt1"><code class="plain spaces">&nbsp;&nbsp;&nbsp;</code><code class="plain plain">dbms_output.put_line(v_sum);</code></div><div class="line number11 index10 alt2"><code class="plain plain">end;</code></div></div></td></tr></tbody></table>', '2014-03-22 20:02:11'),
(7, '编写一个PL/SQL程序块，根据输入员工号，如果职务是CLERK工资提高5%，如果职务是MANAGER工资提高10%，其他工资提高8%。', '<table border="0" cellpadding="0" cellspacing="0"><tbody><tr><td class="gutter"><div class="line number1 index0 alt2">1</div><div class="line number2 index1 alt1">2</div><div class="line number3 index2 alt2">3</div><div class="line number4 index3 alt1">4</div><div class="line number5 index4 alt2">5</div><div class="line number6 index5 alt1">6</div><div class="line number7 index6 alt2">7</div><div class="line number8 index7 alt1">8</div><div class="line number9 index8 alt2">9</div><div class="line number10 index9 alt1">10</div><div class="line number11 index10 alt2">11</div><div class="line number12 index11 alt1">12</div><div class="line number13 index12 alt2">13</div><div class="line number14 index13 alt1">14</div><div class="line number15 index14 alt2">15</div><div class="line number16 index15 alt1">16</div><div class="line number17 index16 alt2">17</div><div class="line number18 index17 alt1">18</div><div class="line number19 index18 alt2">19</div></td><td class="code"><div class="container"><div class="line number1 index0 alt2"><code class="plain plain">declare</code></div><div class="line number2 index1 alt1"><code class="plain plain">k emp.empno%TYPE;</code></div><div class="line number3 index2 alt2"><code class="plain plain">theJob emp.job%TYPE;</code></div><div class="line number4 index3 alt1"><code class="plain plain">theSal emp.sal%TYPE;</code></div><div class="line number5 index4 alt2"><code class="plain plain">begin</code></div><div class="line number6 index5 alt1"><code class="plain spaces">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</code><code class="plain plain">k:=&amp;num;</code></div><div class="line number7 index6 alt2"><code class="plain spaces">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</code><code class="plain plain">select job into theJob from emp where empno=k;</code></div><div class="line number8 index7 alt1"><code class="plain spaces">&nbsp;&nbsp;&nbsp;&nbsp;</code><code class="plain plain">select sal into theSal from emp where empno=k;</code></div><div class="line number9 index8 alt2"><code class="plain plain">if theJob= ''CLERK''then</code></div><div class="line number10 index9 alt1"><code class="plain spaces">&nbsp;&nbsp;&nbsp;&nbsp;</code><code class="plain plain">update emp set sal=theSal*1.05 where empno=k;</code></div><div class="line number11 index10 alt2"><code class="plain plain">elsif theJob= ''MANAGER'' then</code></div><div class="line number12 index11 alt1"><code class="plain spaces">&nbsp;&nbsp;&nbsp;&nbsp;</code><code class="plain plain">update emp set sal=theSal*1.1 where empno=k;</code></div><div class="line number13 index12 alt2"><code class="plain plain">else</code></div><div class="line number14 index13 alt1"><code class="plain spaces">&nbsp;&nbsp;&nbsp;&nbsp;</code><code class="plain plain">update emp set sal=theSal*1.08 where empno=k;</code></div><div class="line number15 index14 alt2"><code class="plain plain">end if;</code></div><div class="line number16 index15 alt1"><code class="plain plain">EXCEPTION</code></div><div class="line number17 index16 alt2"><code class="plain spaces">&nbsp;&nbsp;&nbsp;&nbsp;</code><code class="plain plain">when NO_DATA_FOUND then</code></div><div class="line number18 index17 alt1"><code class="plain spaces">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</code><code class="plain plain">dbms_output.put_line(''警告：没有这个员工！'');</code></div><div class="line number19 index18 alt2"><code class="plain plain">end;</code></div></div></td></tr></tbody></table>', '2014-03-22 20:04:16'),
(8, '编写一个PL/SQL程序块，将输入的字符串反向输出。', '<table border="0" cellpadding="0" cellspacing="0"><tbody><tr><td class="gutter"><div class="line number1 index0 alt2">1</div><div class="line number2 index1 alt1">2</div><div class="line number3 index2 alt2">3</div><div class="line number4 index3 alt1">4</div><div class="line number5 index4 alt2">5</div><div class="line number6 index5 alt1">6</div><div class="line number7 index6 alt2">7</div><div class="line number8 index7 alt1">8</div><div class="line number9 index8 alt2">9</div><div class="line number10 index9 alt1">10</div><div class="line number11 index10 alt2">11</div><div class="line number12 index11 alt1">12</div><div class="line number13 index12 alt2">13</div><div class="line number14 index13 alt1">14</div><div class="line number15 index14 alt2">15</div><div class="line number16 index15 alt1">16</div><div class="line number17 index16 alt2">17</div><div class="line number18 index17 alt1">18</div></td><td class="code"><div class="container"><div class="line number1 index0 alt2"><code class="plain plain">declare</code></div><div class="line number2 index1 alt1"><code class="plain spaces">&nbsp;&nbsp;&nbsp;&nbsp;</code><code class="plain plain">TYPE sample_array IS TABLE OF VARCHAR2(1) INDEX BY BINARY_INTEGER;</code></div><div class="line number3 index2 alt2"><code class="plain spaces">&nbsp;&nbsp;&nbsp;&nbsp;</code><code class="plain plain">theString varchar2(50);</code></div><div class="line number4 index3 alt1"><code class="plain spaces">&nbsp;&nbsp;&nbsp;&nbsp;</code><code class="plain plain">temp sample_array;</code></div><div class="line number5 index4 alt2"><code class="plain spaces">&nbsp;&nbsp;&nbsp;&nbsp;</code><code class="plain plain">reverseString varchar2(50);</code></div><div class="line number6 index5 alt1"><code class="plain spaces">&nbsp;&nbsp;&nbsp;&nbsp;</code><code class="plain plain">i integer;</code></div><div class="line number7 index6 alt2"><code class="plain plain">begin</code></div><div class="line number8 index7 alt1"><code class="plain plain">theString:= ''&amp;myString'';</code></div><div class="line number9 index8 alt2"><code class="plain plain">dbms_output.put_line(theString);</code></div><div class="line number10 index9 alt1"><code class="plain plain">i:= length(theString);</code></div><div class="line number11 index10 alt2"><code class="plain plain">while i&gt;=1</code></div><div class="line number12 index11 alt1"><code class="plain plain">loop</code></div><div class="line number13 index12 alt2"><code class="plain spaces">&nbsp;&nbsp;&nbsp;&nbsp;</code><code class="plain plain">temp(i):=substr(theString,i,1);</code></div><div class="line number14 index13 alt1"><code class="plain spaces">&nbsp;&nbsp;&nbsp;&nbsp;</code><code class="plain plain">reverseString:=reverseString||temp(i);</code></div><div class="line number15 index14 alt2"><code class="plain spaces">&nbsp;&nbsp;&nbsp;&nbsp;</code><code class="plain plain">i:=i-1;</code></div><div class="line number16 index15 alt1"><code class="plain plain">end loop;</code></div><div class="line number17 index16 alt2"><code class="plain plain">dbms_output.put_line(reverseString);</code></div><div class="line number18 index17 alt1"><code class="plain plain">end;</code></div></div></td></tr></tbody></table>', '2014-03-22 20:05:09'),
(9, '编写一个PL/SQL程序块，接受两个数相除并且显示结果。如果第二个数为0，则显示消息"DIVIDE BY ZERO"。', '<table border="0" cellpadding="0" cellspacing="0"><tbody><tr><td class="gutter"><div class="line number1 index0 alt2">1</div><div class="line number2 index1 alt1">2</div><div class="line number3 index2 alt2">3</div><div class="line number4 index3 alt1">4</div><div class="line number5 index4 alt2">5</div><div class="line number6 index5 alt1">6</div><div class="line number7 index6 alt2">7</div><div class="line number8 index7 alt1">8</div><div class="line number9 index8 alt2">9</div><div class="line number10 index9 alt1">10</div><div class="line number11 index10 alt2">11</div><div class="line number12 index11 alt1">12</div><div class="line number13 index12 alt2">13</div><div class="line number14 index13 alt1">14</div><div class="line number15 index14 alt2">15</div><div class="line number16 index15 alt1">16</div></td><td class="code"><div class="container"><div class="line number1 index0 alt2"><code class="plain plain">declare</code></div><div class="line number2 index1 alt1"><code class="plain spaces">&nbsp;&nbsp;&nbsp;&nbsp;</code><code class="plain plain">myFenzi integer;</code></div><div class="line number3 index2 alt2"><code class="plain spaces">&nbsp;&nbsp;&nbsp;&nbsp;</code><code class="plain plain">myFenmu integer;</code></div><div class="line number4 index3 alt1"><code class="plain spaces">&nbsp;&nbsp;&nbsp;&nbsp;</code><code class="plain plain">myError EXCEPTION;</code></div><div class="line number5 index4 alt2"><code class="plain plain">begin</code></div><div class="line number6 index5 alt1"><code class="plain spaces">&nbsp;&nbsp;&nbsp;&nbsp;</code><code class="plain plain">myFenzi:=&amp;fenzi;</code></div><div class="line number7 index6 alt2"><code class="plain spaces">&nbsp;&nbsp;&nbsp;&nbsp;</code><code class="plain plain">myFenmu:=&amp;fenmu;</code></div><div class="line number8 index7 alt1"><code class="plain spaces">&nbsp;&nbsp;&nbsp;&nbsp;</code><code class="plain plain">if myFenmu&lt;&gt;0 then</code></div><div class="line number9 index8 alt2"><code class="plain spaces">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</code><code class="plain plain">dbms_output.put_line(''计算结果为：''||to_char(myFenzi/myFenmu));</code></div><div class="line number10 index9 alt1"><code class="plain spaces">&nbsp;&nbsp;&nbsp;&nbsp;</code><code class="plain plain">else</code></div><div class="line number11 index10 alt2"><code class="plain spaces">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</code><code class="plain plain">raise myError;</code></div><div class="line number12 index11 alt1"><code class="plain spaces">&nbsp;&nbsp;&nbsp;&nbsp;</code><code class="plain plain">end if;</code></div><div class="line number13 index12 alt2"><code class="plain plain">EXCEPTION</code></div><div class="line number14 index13 alt1"><code class="plain spaces">&nbsp;&nbsp;&nbsp;&nbsp;</code><code class="plain plain">when myError then</code></div><div class="line number15 index14 alt2"><code class="plain spaces">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</code><code class="plain plain">dbms_output.put_line('' DIVIDE BY ZERO'');</code></div><div class="line number16 index15 alt1"><code class="plain plain">end;</code></div></div></td></tr></tbody></table>', '2014-03-22 20:05:52'),
(10, '编写一PL/SQL，对所有的"销售员"(SALESMAN)增加佣金500。', '<table border="0" cellpadding="0" cellspacing="0"><tbody><tr><td class="gutter"><div class="line number1 index0 alt2">1</div><div class="line number2 index1 alt1">2</div><div class="line number3 index2 alt2">3</div><div class="line number4 index3 alt1">4</div><div class="line number5 index4 alt2">5</div><div class="line number6 index5 alt1">6</div><div class="line number7 index6 alt2">7</div><div class="line number8 index7 alt1">8</div><div class="line number9 index8 alt2">9</div><div class="line number10 index9 alt1">10</div><div class="line number11 index10 alt2">11</div><div class="line number12 index11 alt1">12</div><div class="line number13 index12 alt2">13</div><div class="line number14 index13 alt1">14</div><div class="line number15 index14 alt2">15</div><div class="line number16 index15 alt1">16</div><div class="line number17 index16 alt2">17</div><div class="line number18 index17 alt1">18</div><div class="line number19 index18 alt2">19</div><div class="line number20 index19 alt1">20</div><div class="line number21 index20 alt2">21</div><div class="line number22 index21 alt1">22</div><div class="line number23 index22 alt2">23</div><div class="line number24 index23 alt1">24</div><div class="line number25 index24 alt2">25</div><div class="line number26 index25 alt1">26</div><div class="line number27 index26 alt2">27</div><div class="line number28 index27 alt1">28</div><div class="line number29 index28 alt2">29</div><div class="line number30 index29 alt1">30</div><div class="line number31 index30 alt2">31</div><div class="line number32 index31 alt1">32</div><div class="line number33 index32 alt2">33</div><div class="line number34 index33 alt1">34</div><div class="line number35 index34 alt2">35</div><div class="line number36 index35 alt1">36</div><div class="line number37 index36 alt2">37</div><div class="line number38 index37 alt1">38</div><div class="line number39 index38 alt2">39</div><div class="line number40 index39 alt1">40</div></td><td class="code"><div class="container"><div class="line number1 index0 alt2"><code class="plain plain">declare</code></div><div class="line number2 index1 alt1"><code class="plain plain">TYPE comm_array IS TABLE OF emp.comm%TYPE INDEX BY BINARY_INTEGER;</code></div><div class="line number3 index2 alt2"><code class="plain plain">TYPE empno_array IS TABLE OF emp.empno%TYPE INDEX BY BINARY_INTEGER;</code></div><div class="line number4 index3 alt1"><code class="plain plain">i integer:=1;</code></div><div class="line number5 index4 alt2"><code class="plain plain">j integer:=1;</code></div><div class="line number6 index5 alt1"><code class="plain plain">empno empno_array;</code></div><div class="line number7 index6 alt2"><code class="plain spaces">&nbsp;&nbsp;&nbsp;&nbsp;</code><code class="plain plain">comm comm_array;</code></div><div class="line number8 index7 alt1"><code class="plain spaces">&nbsp;&nbsp;&nbsp;&nbsp;</code><code class="plain plain">CURSOR mycur(myJob emp.job%TYPE) is select empno,comm from emp where job=myJob;</code></div><div class="line number9 index8 alt2"><code class="plain plain">begin</code></div><div class="line number10 index9 alt1"><code class="plain spaces">&nbsp;&nbsp;&nbsp;&nbsp;</code><code class="plain plain">if mycur%ISOPEN=false then</code></div><div class="line number11 index10 alt2"><code class="plain spaces">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</code><code class="plain plain">open mycur(''SALESMAN'');</code></div><div class="line number12 index11 alt1"><code class="plain spaces">&nbsp;&nbsp;&nbsp;&nbsp;</code><code class="plain plain">end if;</code></div><div class="line number13 index12 alt2"><code class="plain spaces">&nbsp;&nbsp;&nbsp;&nbsp;</code><code class="plain plain">fetch mycur into empno(i),comm(i);</code></div><div class="line number14 index13 alt1"><code class="plain spaces">&nbsp;&nbsp;&nbsp;&nbsp;</code><code class="plain plain">dbms_output.put_line(''SALESMAN的职工号及原来佣金'');</code></div><div class="line number15 index14 alt2"><code class="plain spaces">&nbsp;&nbsp;&nbsp;&nbsp;</code><code class="plain plain">while mycur%FOUND</code></div><div class="line number16 index15 alt1"><code class="plain spaces">&nbsp;&nbsp;&nbsp;&nbsp;</code><code class="plain plain">loop</code></div><div class="line number17 index16 alt2"><code class="plain spaces">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</code><code class="plain plain">dbms_output.put_line(empno(i)|| ''&lt;===&gt;''||comm(i));</code></div><div class="line number18 index17 alt1"><code class="plain spaces">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</code><code class="plain plain">i:=i+1;</code></div><div class="line number19 index18 alt2"><code class="plain plain">fetch mycur into empno(i),comm(i);</code></div><div class="line number20 index19 alt1"><code class="plain spaces">&nbsp;&nbsp;&nbsp;&nbsp;</code><code class="plain plain">end loop;</code></div><div class="line number21 index20 alt2"><code class="plain spaces">&nbsp;&nbsp;&nbsp;&nbsp;</code><code class="plain plain">close mycur;</code></div><div class="line number22 index21 alt1"><code class="plain spaces">&nbsp;&nbsp;&nbsp;&nbsp;</code><code class="plain plain">while j&lt;i</code></div><div class="line number23 index22 alt2"><code class="plain spaces">&nbsp;&nbsp;&nbsp;&nbsp;</code><code class="plain plain">loop</code></div><div class="line number24 index23 alt1"><code class="plain spaces">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</code><code class="plain plain">update emp set comm=comm(j)+500 where empno=empno(j);</code></div><div class="line number25 index24 alt2"><code class="plain spaces">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</code><code class="plain plain">j:=j+1;</code></div><div class="line number26 index25 alt1"><code class="plain spaces">&nbsp;&nbsp;&nbsp;&nbsp;</code><code class="plain plain">end loop;</code></div><div class="line number27 index26 alt2"><code class="plain spaces">&nbsp;&nbsp;&nbsp;&nbsp;</code><code class="plain plain">dbms_output.put_line(''SALESMAN的职工号及改后佣金'');</code></div><div class="line number28 index27 alt1"><code class="plain plain">if mycur%ISOPEN=false then</code></div><div class="line number29 index28 alt2"><code class="plain spaces">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</code><code class="plain plain">open mycur(''SALESMAN'');</code></div><div class="line number30 index29 alt1"><code class="plain spaces">&nbsp;&nbsp;&nbsp;&nbsp;</code><code class="plain plain">end if;</code></div><div class="line number31 index30 alt2"><code class="plain spaces">&nbsp;&nbsp;&nbsp;&nbsp;</code><code class="plain plain">i:=1;</code></div><div class="line number32 index31 alt1"><code class="plain spaces">&nbsp;&nbsp;&nbsp;&nbsp;</code><code class="plain plain">fetch mycur into empno(i),comm(i);</code></div><div class="line number33 index32 alt2"><code class="plain plain">while mycur%FOUND</code></div><div class="line number34 index33 alt1"><code class="plain spaces">&nbsp;&nbsp;&nbsp;&nbsp;</code><code class="plain plain">loop</code></div><div class="line number35 index34 alt2"><code class="plain spaces">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</code><code class="plain plain">dbms_output.put_line(empno(i)|| ''&lt;===&gt;''||comm(i));</code></div><div class="line number36 index35 alt1"><code class="plain spaces">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</code><code class="plain plain">i:=i+1;</code></div><div class="line number37 index36 alt2"><code class="plain plain">fetch mycur into empno(i),comm(i);</code></div><div class="line number38 index37 alt1"><code class="plain spaces">&nbsp;&nbsp;&nbsp;&nbsp;</code><code class="plain plain">end loop;</code></div><div class="line number39 index38 alt2"><code class="plain spaces">&nbsp;&nbsp;&nbsp;&nbsp;</code><code class="plain plain">close mycur;</code></div><div class="line number40 index39 alt1"><code class="plain plain">end;</code></div></div></td></tr></tbody></table>', '2014-03-20 23:08:04');

-- --------------------------------------------------------

--
-- 表的结构 `t_question_lesson_rel`
--

CREATE TABLE IF NOT EXISTS `t_question_lesson_rel` (
  `QUESTION_LESSON_REL_ID` int(10) unsigned NOT NULL auto_increment,
  `QUESTION_ID` int(11) unsigned NOT NULL,
  `COURSE_ID` int(11) unsigned NOT NULL,
  `COURSE_CHARPTER` tinyint(4) NOT NULL,
  `LESSON_SEQ` tinyint(4) NOT NULL,
  `TIMESTAMP` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`QUESTION_LESSON_REL_ID`),
  KEY `COURSE_ID` (`COURSE_ID`),
  KEY `QUESTION_ID` (`QUESTION_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=11 ;

--
-- 转存表中的数据 `t_question_lesson_rel`
--

INSERT INTO `t_question_lesson_rel` (`QUESTION_LESSON_REL_ID`, `QUESTION_ID`, `COURSE_ID`, `COURSE_CHARPTER`, `LESSON_SEQ`, `TIMESTAMP`) VALUES
(1, 1, 2, 1, 1, '2014-01-10 16:56:22'),
(2, 2, 2, 1, 1, '2014-01-10 16:56:23'),
(3, 3, 2, 1, 1, '2014-01-10 16:56:24'),
(4, 4, 2, 1, 1, '2014-01-10 16:56:29'),
(5, 5, 3, 1, 1, '2014-03-20 22:50:14'),
(7, 7, 3, 1, 1, '2014-03-20 22:50:28'),
(8, 8, 3, 1, 1, '2014-03-20 22:50:36'),
(9, 9, 3, 1, 1, '2014-03-20 22:50:42'),
(10, 10, 3, 1, 1, '2014-03-20 22:50:50');

-- --------------------------------------------------------

--
-- 表的结构 `t_student_remark`
--

CREATE TABLE IF NOT EXISTS `t_student_remark` (
  `item_id` int(10) unsigned NOT NULL auto_increment,
  `user_id` int(10) unsigned NOT NULL,
  `class_id` int(10) unsigned NOT NULL,
  `charpter_id` int(10) unsigned NOT NULL,
  `lesson_id` int(10) unsigned NOT NULL,
  `page_num` int(10) unsigned NOT NULL,
  `pstartx` double NOT NULL,
  `pstarty` double NOT NULL,
  `pendx` double NOT NULL,
  `pendy` double NOT NULL,
  `pleft` double NOT NULL,
  `ptop` double NOT NULL,
  `content` text character set utf8 NOT NULL,
  `timestamp` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`item_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=198 ;

--
-- 转存表中的数据 `t_student_remark`
--

INSERT INTO `t_student_remark` (`item_id`, `user_id`, `class_id`, `charpter_id`, `lesson_id`, `page_num`, `pstartx`, `pstarty`, `pendx`, `pendy`, `pleft`, `ptop`, `content`, `timestamp`) VALUES
(193, 4, 3, 1, 1, 1, 0.106655290102389, 0.811149032992036, 0.347269624573379, 0.811149032992036, 0.351535836177474, 0.790671217292378, 'PLSql', '2014-03-30 13:51:35'),
(194, 4, 3, 1, 1, 5, 0.404436860068259, 0.498293515358362, 0.589590443686007, 0.499431171786121, 0.593856655290102, 0.478953356086462, 'e.g. If...Else...', '2014-03-30 13:51:56'),
(195, 4, 3, 1, 1, 5, 0.184300341296928, 0.664391353811149, 0.408703071672355, 0.662116040955631, 0.41296928327645, 0.640500568828214, 'important!', '2014-03-30 13:52:10'),
(196, 4, 3, 1, 1, 6, 0.765358361774744, 0.751990898748578, 0.77901023890785, 0.74971558589306, 0.783276450511945, 0.729237770193402, 'relation', '2014-03-30 13:52:18'),
(197, 4, 3, 1, 1, 5, 0.282423208191126, 0.407281001137656, 0.408703071672355, 0.407281001137656, 0.41296928327645, 0.386803185437998, '', '2014-03-30 13:52:26');

-- --------------------------------------------------------

--
-- 表的结构 `t_train_course_rel`
--

CREATE TABLE IF NOT EXISTS `t_train_course_rel` (
  `TRAIN_COURSE_REL_ID` int(11) unsigned NOT NULL auto_increment,
  `TRAIN_ID` int(11) unsigned NOT NULL,
  `COURSE_ID` int(11) unsigned NOT NULL,
  `TIMESTAMP` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`TRAIN_COURSE_REL_ID`),
  KEY `TRAIN_ID` (`TRAIN_ID`),
  KEY `COURSE_ID` (`COURSE_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `t_train_course_rel`
--


-- --------------------------------------------------------

--
-- 表的结构 `t_train_info`
--

CREATE TABLE IF NOT EXISTS `t_train_info` (
  `TRAIN_ID` int(10) unsigned NOT NULL auto_increment,
  `TRAIN_NAME` varchar(40) collate utf8_unicode_ci NOT NULL,
  `TRAIN_TYPE` tinyint(4) NOT NULL COMMENT '1 stands for the tiny one for a certain lesson, 2 stands for the big one corresponding to a course, 2 stands for a biggest one needed several courses',
  `TRAIN_DESC` text collate utf8_unicode_ci,
  `TIMESTAMP` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`TRAIN_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `t_train_info`
--


-- --------------------------------------------------------

--
-- 表的结构 `t_train_lesson_rel`
--

CREATE TABLE IF NOT EXISTS `t_train_lesson_rel` (
  `TRAIN_LESSON_REL_ID` int(11) NOT NULL,
  `COURSE_ID` int(11) unsigned NOT NULL,
  `COURSE_CHARPTER` tinyint(4) NOT NULL,
  `LESSON_SEQ` tinyint(4) NOT NULL,
  `TRAIN_ID` int(11) unsigned NOT NULL,
  `ENV_DESC` text collate utf8_unicode_ci COMMENT 'the environment setup description for this lesson',
  `TIMESTAMP` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`TRAIN_LESSON_REL_ID`),
  KEY `COURSE_ID` (`COURSE_ID`),
  KEY `TRAIN_ID` (`TRAIN_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `t_train_lesson_rel`
--


-- --------------------------------------------------------

--
-- 表的结构 `t_user_info`
--

CREATE TABLE IF NOT EXISTS `t_user_info` (
  `USER_ID` int(10) unsigned NOT NULL auto_increment,
  `USER_NAME` varchar(40) collate utf8_unicode_ci NOT NULL,
  `PASSWORD` varchar(40) collate utf8_unicode_ci NOT NULL,
  `ID_TYPE` tinyint(4) NOT NULL COMMENT '1 stands for the personal identification',
  `ID_VALUE` text collate utf8_unicode_ci NOT NULL,
  `USER_TYPE` tinyint(4) NOT NULL COMMENT '1 stands for teacher;2 stands for student',
  `EMAIL` text collate utf8_unicode_ci NOT NULL,
  `BIRTHDAY` date NOT NULL,
  `TIMESTAMP` timestamp NOT NULL default CURRENT_TIMESTAMP COMMENT 'registeration time',
  PRIMARY KEY  (`USER_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=15 ;

--
-- 转存表中的数据 `t_user_info`
--

INSERT INTO `t_user_info` (`USER_ID`, `USER_NAME`, `PASSWORD`, `ID_TYPE`, `ID_VALUE`, `USER_TYPE`, `EMAIL`, `BIRTHDAY`, `TIMESTAMP`) VALUES
(3, 'Charles', ' e10adc3949ba59abbe56e057f20f883e', 1, ' 321027199311185417', 2, ' xlan@seu.edu.cn', '1993-11-18', '2013-12-17 22:55:49'),
(4, 'xx', '202cb962ac59075b964b07152d234b70', 1, ' 321027199311185417', 2, ' xiangxiang@seu.edu.cn', '1993-11-18', '2013-12-17 22:56:40'),
(5, 'lx', '202cb962ac59075b964b07152d234b70', 1, '321027199311185000', 1, '3@1.com', '1993-11-18', '2013-12-28 10:12:58'),
(6, 'zr', '202cb962ac59075b964b07152d234b70', 1, '321027188311185417', 2, 'xlan@seu.edu.cn', '1993-11-18', '2014-01-06 20:11:39'),
(7, 'dj', '202cb962ac59075b964b07152d234b70', 1, '321027188888888888', 2, 'xlan@seu.edu.cn', '1993-11-18', '2014-01-06 20:59:09'),
(8, 'xx1', '202cb962ac59075b964b07152d234b70', 1, '321027199311185003', 2, 'wq', '0000-00-00', '2014-03-22 11:40:19'),
(9, 'xx2', '202cb962ac59075b964b07152d234b70', 1, '21', 2, '21', '0000-00-00', '2014-03-22 11:40:53'),
(10, 'xx3', '202cb962ac59075b964b07152d234b70', 1, '121', 2, '2112', '0000-00-00', '2014-03-22 11:41:20'),
(11, 'xx4', '202cb962ac59075b964b07152d234b70', 1, '12', 2, '21', '0000-00-00', '2014-03-22 11:41:45'),
(12, 'xx5', '202cb962ac59075b964b07152d234b70', 1, '21', 2, '123ed', '0000-00-00', '2014-03-22 11:41:54'),
(13, 'xx6', '202cb962ac59075b964b07152d234b70', 1, '323433', 2, '2343', '0000-00-00', '2014-03-22 11:42:17'),
(14, 'xx7', '202cb962ac59075b964b07152d234b70', 1, '22', 2, '2343', '0000-00-00', '2014-03-22 11:42:27');

--
-- 限制导出的表
--

--
-- 限制表 `t_ask_info`
--
ALTER TABLE `t_ask_info`
  ADD CONSTRAINT `t_ask_info_ibfk_1` FOREIGN KEY (`PPT_ID`) REFERENCES `t_ppt_info` (`PPT_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `t_ask_info_ibfk_2` FOREIGN KEY (`CLASS_ID`) REFERENCES `t_class_info` (`CLASS_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `t_ask_info_ibfk_3` FOREIGN KEY (`STUDENT_ID`) REFERENCES `t_user_info` (`USER_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `t_class_info`
--
ALTER TABLE `t_class_info`
  ADD CONSTRAINT `t_class_info_ibfk_1` FOREIGN KEY (`TEACHER_ID`) REFERENCES `t_user_info` (`USER_ID`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `t_class_info_ibfk_2` FOREIGN KEY (`COURSE_ID`) REFERENCES `t_course_info` (`COURSE_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `t_class_user_rel`
--
ALTER TABLE `t_class_user_rel`
  ADD CONSTRAINT `t_class_user_rel_ibfk_1` FOREIGN KEY (`USER_ID`) REFERENCES `t_user_info` (`USER_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `t_class_user_rel_ibfk_2` FOREIGN KEY (`CLASS_ID`) REFERENCES `t_class_info` (`CLASS_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `t_course_det`
--
ALTER TABLE `t_course_det`
  ADD CONSTRAINT `t_course_det_ibfk_1` FOREIGN KEY (`COURSE_ID`) REFERENCES `t_course_info` (`COURSE_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `t_course_info`
--
ALTER TABLE `t_course_info`
  ADD CONSTRAINT `t_course_info_ibfk_1` FOREIGN KEY (`TRAIN_ID`) REFERENCES `t_train_info` (`TRAIN_ID`) ON UPDATE CASCADE;

--
-- 限制表 `t_homework_info`
--
ALTER TABLE `t_homework_info`
  ADD CONSTRAINT `t_homework_info_ibfk_1` FOREIGN KEY (`CLASS_ID`) REFERENCES `t_class_info` (`CLASS_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `t_homework_question_rel`
--
ALTER TABLE `t_homework_question_rel`
  ADD CONSTRAINT `t_homework_question_rel_ibfk_1` FOREIGN KEY (`HOMEWORK_ID`) REFERENCES `t_homework_info` (`HOMEWORK_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `t_homework_question_rel_ibfk_2` FOREIGN KEY (`QUESTION_ID`) REFERENCES `t_question_info` (`QUESTION_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `t_homework_response_rel`
--
ALTER TABLE `t_homework_response_rel`
  ADD CONSTRAINT `t_homework_response_rel_ibfk_1` FOREIGN KEY (`HOMEWORK_ID`) REFERENCES `t_homework_info` (`HOMEWORK_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `t_homework_response_rel_ibfk_2` FOREIGN KEY (`QUESTION_ID`) REFERENCES `t_question_info` (`QUESTION_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `t_homework_response_rel_ibfk_3` FOREIGN KEY (`STUDENT_ID`) REFERENCES `t_user_info` (`USER_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `t_ppt_det`
--
ALTER TABLE `t_ppt_det`
  ADD CONSTRAINT `t_ppt_det_ibfk_1` FOREIGN KEY (`PPT_ID`) REFERENCES `t_ppt_info` (`PPT_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `t_ppt_info`
--
ALTER TABLE `t_ppt_info`
  ADD CONSTRAINT `t_ppt_info_ibfk_1` FOREIGN KEY (`COURSE_ID`) REFERENCES `t_course_info` (`COURSE_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `t_ppt_remark`
--
ALTER TABLE `t_ppt_remark`
  ADD CONSTRAINT `t_ppt_remark_ibfk_1` FOREIGN KEY (`CLASS_ID`) REFERENCES `t_class_info` (`CLASS_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `t_ppt_remark_ibfk_2` FOREIGN KEY (`PPT_ID`) REFERENCES `t_ppt_info` (`PPT_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `t_progress`
--
ALTER TABLE `t_progress`
  ADD CONSTRAINT `t_progress_ibfk_1` FOREIGN KEY (`CLASS_ID`) REFERENCES `t_class_info` (`CLASS_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `t_question_lesson_rel`
--
ALTER TABLE `t_question_lesson_rel`
  ADD CONSTRAINT `t_question_lesson_rel_ibfk_1` FOREIGN KEY (`COURSE_ID`) REFERENCES `t_course_info` (`COURSE_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `t_question_lesson_rel_ibfk_2` FOREIGN KEY (`QUESTION_ID`) REFERENCES `t_question_info` (`QUESTION_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `t_train_course_rel`
--
ALTER TABLE `t_train_course_rel`
  ADD CONSTRAINT `t_train_course_rel_ibfk_1` FOREIGN KEY (`TRAIN_ID`) REFERENCES `t_train_info` (`TRAIN_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `t_train_course_rel_ibfk_2` FOREIGN KEY (`COURSE_ID`) REFERENCES `t_course_info` (`COURSE_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `t_train_lesson_rel`
--
ALTER TABLE `t_train_lesson_rel`
  ADD CONSTRAINT `t_train_lesson_rel_ibfk_1` FOREIGN KEY (`COURSE_ID`) REFERENCES `t_course_info` (`COURSE_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `t_train_lesson_rel_ibfk_2` FOREIGN KEY (`TRAIN_ID`) REFERENCES `t_train_info` (`TRAIN_ID`) ON DELETE CASCADE ON UPDATE CASCADE;
