/*
Navicat MySQL Data Transfer

Source Server         : mysql
Source Server Version : 50610
Source Host           : localhost:3306
Source Database       : cloud_lab

Target Server Type    : MYSQL
Target Server Version : 50610
File Encoding         : 65001

Date: 2014-02-13 22:35:56
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `t_ask_info`
-- ----------------------------
DROP TABLE IF EXISTS `t_ask_info`;
CREATE TABLE `t_ask_info` (
  `ASK_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `PPT_ID` int(11) unsigned NOT NULL,
  `PPT_URL` text COLLATE utf8_unicode_ci NOT NULL,
  `CLASS_ID` int(11) unsigned NOT NULL,
  `STUDENT_ID` int(11) unsigned NOT NULL,
  `ASK_CONTENT` text COLLATE utf8_unicode_ci NOT NULL,
  `ASK_ANSWER` text COLLATE utf8_unicode_ci,
  `TOP1` double DEFAULT NULL,
  `TOP2` double DEFAULT NULL,
  `LEFT1` double DEFAULT NULL,
  `LEFT2` double DEFAULT NULL,
  `TIMESTAMP` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`ASK_ID`),
  KEY `PPT_ID` (`PPT_ID`),
  KEY `CLASS_ID` (`CLASS_ID`),
  KEY `STUDENT_ID` (`STUDENT_ID`),
  CONSTRAINT `t_ask_info_ibfk_1` FOREIGN KEY (`PPT_ID`) REFERENCES `t_ppt_info` (`PPT_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `t_ask_info_ibfk_2` FOREIGN KEY (`CLASS_ID`) REFERENCES `t_class_info` (`CLASS_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `t_ask_info_ibfk_3` FOREIGN KEY (`STUDENT_ID`) REFERENCES `t_user_info` (`USER_ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of t_ask_info
-- ----------------------------

-- ----------------------------
-- Table structure for `t_class_info`
-- ----------------------------
DROP TABLE IF EXISTS `t_class_info`;
CREATE TABLE `t_class_info` (
  `CLASS_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `TEACHER_ID` int(10) unsigned DEFAULT NULL,
  `COURSE_ID` int(10) unsigned NOT NULL,
  `CLASS_NAME` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `CLASS_BEGIN` date NOT NULL,
  `CLASS_END` date NOT NULL,
  `TIMESTAMP` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`CLASS_ID`),
  KEY `t_class_info_ibfk_1` (`TEACHER_ID`),
  KEY `COURSE_ID` (`COURSE_ID`),
  CONSTRAINT `t_class_info_ibfk_1` FOREIGN KEY (`TEACHER_ID`) REFERENCES `t_user_info` (`USER_ID`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `t_class_info_ibfk_2` FOREIGN KEY (`COURSE_ID`) REFERENCES `t_course_info` (`COURSE_ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of t_class_info
-- ----------------------------
INSERT INTO `t_class_info` VALUES ('1', '5', '2', 'Gec DB course', '2013-12-09', '2014-01-04', '2014-01-09 23:18:06');
INSERT INTO `t_class_info` VALUES ('2', '5', '1', 'HTML class 1', '2013-11-26', '2014-12-24', '2014-01-09 23:17:54');

-- ----------------------------
-- Table structure for `t_class_user_rel`
-- ----------------------------
DROP TABLE IF EXISTS `t_class_user_rel`;
CREATE TABLE `t_class_user_rel` (
  `CLASS_USER_REL_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `USER_ID` int(10) unsigned NOT NULL,
  `CLASS_ID` int(10) unsigned NOT NULL,
  `GRADE` int(10) unsigned NOT NULL,
  `TIMESTAMP` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`CLASS_USER_REL_ID`),
  KEY `USER_ID` (`USER_ID`),
  KEY `CLASS_ID` (`CLASS_ID`),
  CONSTRAINT `t_class_user_rel_ibfk_1` FOREIGN KEY (`USER_ID`) REFERENCES `t_user_info` (`USER_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `t_class_user_rel_ibfk_2` FOREIGN KEY (`CLASS_ID`) REFERENCES `t_class_info` (`CLASS_ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of t_class_user_rel
-- ----------------------------
INSERT INTO `t_class_user_rel` VALUES ('4', '1', '1', '100', '2014-01-10 15:42:50');
INSERT INTO `t_class_user_rel` VALUES ('5', '2', '1', '3', '2014-01-10 15:42:53');
INSERT INTO `t_class_user_rel` VALUES ('6', '3', '1', '32', '2014-01-10 15:42:59');
INSERT INTO `t_class_user_rel` VALUES ('7', '4', '2', '0', '2013-12-28 22:09:58');
INSERT INTO `t_class_user_rel` VALUES ('8', '2', '2', '0', '2014-01-10 15:43:02');
INSERT INTO `t_class_user_rel` VALUES ('9', '1', '2', '0', '2014-01-10 15:43:12');
INSERT INTO `t_class_user_rel` VALUES ('11', '4', '1', '0', '2014-01-10 15:43:22');

-- ----------------------------
-- Table structure for `t_course_det`
-- ----------------------------
DROP TABLE IF EXISTS `t_course_det`;
CREATE TABLE `t_course_det` (
  `COURSE_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `CHARPTER_ID` tinyint(3) unsigned NOT NULL,
  `LESSON_SEQ` tinyint(3) unsigned NOT NULL,
  `TIMESTAMP` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`COURSE_ID`,`CHARPTER_ID`,`LESSON_SEQ`),
  CONSTRAINT `t_course_det_ibfk_1` FOREIGN KEY (`COURSE_ID`) REFERENCES `t_course_info` (`COURSE_ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of t_course_det
-- ----------------------------
INSERT INTO `t_course_det` VALUES ('1', '1', '3', '2013-12-29 12:45:07');
INSERT INTO `t_course_det` VALUES ('1', '2', '4', '0000-00-00 00:00:00');
INSERT INTO `t_course_det` VALUES ('1', '3', '2', '0000-00-00 00:00:00');
INSERT INTO `t_course_det` VALUES ('2', '1', '3', '0000-00-00 00:00:00');
INSERT INTO `t_course_det` VALUES ('2', '2', '3', '0000-00-00 00:00:00');
INSERT INTO `t_course_det` VALUES ('2', '3', '2', '2014-01-10 16:47:55');
INSERT INTO `t_course_det` VALUES ('2', '4', '4', '0000-00-00 00:00:00');
INSERT INTO `t_course_det` VALUES ('2', '5', '3', '2014-01-10 16:47:32');

-- ----------------------------
-- Table structure for `t_course_info`
-- ----------------------------
DROP TABLE IF EXISTS `t_course_info`;
CREATE TABLE `t_course_info` (
  `COURSE_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `COURSE_NAME` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `COURSE_IMAGE` text COLLATE utf8_unicode_ci,
  `COURSE_DESC` text COLLATE utf8_unicode_ci,
  `COURSE_NUM` tinyint(4) unsigned NOT NULL,
  `CHARPTER_NUM` tinyint(4) unsigned NOT NULL,
  `TRAIN_ID` int(10) unsigned DEFAULT NULL,
  `TIMESTAMP` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`COURSE_ID`),
  KEY `t_course_info_ibfk_1` (`TRAIN_ID`),
  CONSTRAINT `t_course_info_ibfk_1` FOREIGN KEY (`TRAIN_ID`) REFERENCES `t_train_info` (`TRAIN_ID`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of t_course_info
-- ----------------------------
INSERT INTO `t_course_info` VALUES ('1', 'HTML5', '/image/course-html5.png', 'A very complicated course!', '100', '3', null, '2013-12-28 15:13:44');
INSERT INTO `t_course_info` VALUES ('2', 'Principles of Database', '/image/course-database.png', 'Very interesting!', '120', '5', null, '2014-01-10 15:42:23');

-- ----------------------------
-- Table structure for `t_homework_info`
-- ----------------------------
DROP TABLE IF EXISTS `t_homework_info`;
CREATE TABLE `t_homework_info` (
  `HOMEWORK_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `STUDENT_NUM` tinyint(3) unsigned DEFAULT '1' COMMENT 'maximum student number limitation for this homework',
  `CLASS_ID` int(10) unsigned NOT NULL,
  `COURSE_CHARPTER` int(10) unsigned NOT NULL,
  `LESSON_SEQ` int(10) unsigned NOT NULL,
  `DEADLINE` datetime NOT NULL,
  `TIMESTAMP` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`HOMEWORK_ID`),
  KEY `CLASS_ID` (`CLASS_ID`),
  CONSTRAINT `t_homework_info_ibfk_1` FOREIGN KEY (`CLASS_ID`) REFERENCES `t_class_info` (`CLASS_ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of t_homework_info
-- ----------------------------
INSERT INTO `t_homework_info` VALUES ('11', '1', '2', '1', '1', '2015-01-01 00:00:00', '2014-01-07 21:47:47');

-- ----------------------------
-- Table structure for `t_homework_question_rel`
-- ----------------------------
DROP TABLE IF EXISTS `t_homework_question_rel`;
CREATE TABLE `t_homework_question_rel` (
  `HOMEWORK_QUESTION_REL_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `HOMEWORK_ID` int(10) unsigned NOT NULL,
  `QUESTION_ID` int(10) unsigned NOT NULL,
  `TIMESTAMP` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`HOMEWORK_QUESTION_REL_ID`),
  KEY `HOMEWORK_ID` (`HOMEWORK_ID`),
  KEY `QUESTION_ID` (`QUESTION_ID`),
  CONSTRAINT `t_homework_question_rel_ibfk_1` FOREIGN KEY (`HOMEWORK_ID`) REFERENCES `t_homework_info` (`HOMEWORK_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `t_homework_question_rel_ibfk_2` FOREIGN KEY (`QUESTION_ID`) REFERENCES `t_question_info` (`QUESTION_ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of t_homework_question_rel
-- ----------------------------
INSERT INTO `t_homework_question_rel` VALUES ('5', '11', '2', '2014-01-07 21:47:47');
INSERT INTO `t_homework_question_rel` VALUES ('6', '11', '3', '2014-01-07 21:47:47');

-- ----------------------------
-- Table structure for `t_homework_response_rel`
-- ----------------------------
DROP TABLE IF EXISTS `t_homework_response_rel`;
CREATE TABLE `t_homework_response_rel` (
  `HOMEWORK_RESPONSE_REL_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `HOMEWORK_ID` int(11) unsigned NOT NULL,
  `QUESTION_ID` int(11) unsigned NOT NULL,
  `STUDENT_ID` int(11) unsigned NOT NULL,
  `ANSWER_CONTENT` text COLLATE utf8_unicode_ci NOT NULL,
  `TIMESTAMP` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`HOMEWORK_RESPONSE_REL_ID`),
  KEY `HOMEWORK_ID` (`HOMEWORK_ID`),
  KEY `QUESTION_ID` (`QUESTION_ID`),
  KEY `STUDENT_ID` (`STUDENT_ID`),
  CONSTRAINT `t_homework_response_rel_ibfk_1` FOREIGN KEY (`HOMEWORK_ID`) REFERENCES `t_homework_info` (`HOMEWORK_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `t_homework_response_rel_ibfk_2` FOREIGN KEY (`QUESTION_ID`) REFERENCES `t_question_info` (`QUESTION_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `t_homework_response_rel_ibfk_3` FOREIGN KEY (`STUDENT_ID`) REFERENCES `t_user_info` (`USER_ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of t_homework_response_rel
-- ----------------------------

-- ----------------------------
-- Table structure for `t_ppt_det`
-- ----------------------------
DROP TABLE IF EXISTS `t_ppt_det`;
CREATE TABLE `t_ppt_det` (
  `PPT_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `PPT_PAGE_NUM` int(10) unsigned NOT NULL,
  `PIC_URL` text COLLATE utf8_unicode_ci NOT NULL,
  `VIDEO_SECTION` int(10) unsigned DEFAULT NULL COMMENT 'Seconds from the beginning',
  `TIMESTAMP` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`PPT_ID`,`PPT_PAGE_NUM`),
  CONSTRAINT `t_ppt_det_ibfk_1` FOREIGN KEY (`PPT_ID`) REFERENCES `t_ppt_info` (`PPT_ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of t_ppt_det
-- ----------------------------
INSERT INTO `t_ppt_det` VALUES ('1', '1', '/image/HTML5/charpter1-01.PNG', '111', '2014-01-06 23:29:44');
INSERT INTO `t_ppt_det` VALUES ('1', '2', '/image/HTML5/charpter1-02.PNG', '112', '2014-01-06 23:11:57');
INSERT INTO `t_ppt_det` VALUES ('1', '3', '/image/HTML5/charpter1-03.PNG', '113', '2014-01-06 23:12:04');
INSERT INTO `t_ppt_det` VALUES ('1', '4', '/image/HTML5/charpter1-04.PNG', '114', '2014-01-06 23:12:15');
INSERT INTO `t_ppt_det` VALUES ('1', '5', '/image/HTML5/charpter1-05.PNG', '115', '2014-01-06 23:12:21');
INSERT INTO `t_ppt_det` VALUES ('2', '1', '/image/HTML5/charpter1-01.PNG', '121', '2014-01-06 23:12:27');
INSERT INTO `t_ppt_det` VALUES ('2', '2', '/image/HTML5/charpter1-02.PNG', '122', '2014-01-06 23:12:35');
INSERT INTO `t_ppt_det` VALUES ('2', '3', '/image/HTML5/charpter1-03.PNG', '123', '2014-01-06 23:12:44');
INSERT INTO `t_ppt_det` VALUES ('2', '4', '/image/HTML5/charpter1-04.PNG', '124', '2014-01-06 23:12:52');
INSERT INTO `t_ppt_det` VALUES ('2', '5', '/image/HTML5/charpter1-05.PNG', '125', '2014-01-06 23:13:00');
INSERT INTO `t_ppt_det` VALUES ('2', '6', '/image/HTML5/charpter1-01.PNG', '126', '2014-01-06 23:13:07');
INSERT INTO `t_ppt_det` VALUES ('2', '7', '/image/HTML5/charpter1-02.PNG', '127', '2014-01-06 23:13:15');
INSERT INTO `t_ppt_det` VALUES ('3', '1', '/image/HTML5/charpter1-03.PNG', '131', '2014-01-06 23:13:23');
INSERT INTO `t_ppt_det` VALUES ('3', '2', '/image/HTML5/charpter1-04.PNG', '132', '2014-01-06 23:13:31');
INSERT INTO `t_ppt_det` VALUES ('4', '1', '/image/PrinciplesOfDatabase/1-1-01.png', '0', '2014-01-10 14:13:58');
INSERT INTO `t_ppt_det` VALUES ('4', '2', '/image/PrinciplesOfDatabase/1-1-02.png', '15', '2014-01-10 14:14:02');
INSERT INTO `t_ppt_det` VALUES ('4', '3', '/image/PrinciplesOfDatabase/1-1-03.png', '440', '2014-01-10 14:14:07');
INSERT INTO `t_ppt_det` VALUES ('4', '4', '/image/PrinciplesOfDatabase/1-1-04.png', '1041', '2014-01-10 14:14:09');
INSERT INTO `t_ppt_det` VALUES ('4', '5', '/image/PrinciplesOfDatabase/1-1-05.png', '1733', '2014-01-10 14:14:13');
INSERT INTO `t_ppt_det` VALUES ('5', '1', '/image/PrinciplesOfDatabase/1-1-01.png', '0', '2014-01-10 14:14:18');
INSERT INTO `t_ppt_det` VALUES ('5', '2', '/image/PrinciplesOfDatabase/1-1-02.png', '15', '2014-01-10 14:14:21');
INSERT INTO `t_ppt_det` VALUES ('5', '3', '/image/PrinciplesOfDatabase/1-1-03.png', '440', '2014-01-10 14:14:24');
INSERT INTO `t_ppt_det` VALUES ('5', '4', '/image/PrinciplesOfDatabase/1-1-04.png', '1041', '2014-01-10 14:14:28');
INSERT INTO `t_ppt_det` VALUES ('5', '5', '/image/PrinciplesOfDatabase/1-1-05.png', '1733', '2014-01-10 14:14:30');
INSERT INTO `t_ppt_det` VALUES ('6', '1', '/image/PrinciplesOfDatabase/1-1-01.png', '0', '2014-01-10 14:14:35');
INSERT INTO `t_ppt_det` VALUES ('6', '2', '/image/PrinciplesOfDatabase/1-1-02.png', '15', '2014-01-10 14:14:39');
INSERT INTO `t_ppt_det` VALUES ('6', '3', '/image/PrinciplesOfDatabase/1-1-03.png', '440', '2014-01-10 14:14:47');
INSERT INTO `t_ppt_det` VALUES ('6', '4', '/image/PrinciplesOfDatabase/1-1-04.png', '1041', '2014-01-10 14:14:55');
INSERT INTO `t_ppt_det` VALUES ('6', '5', '/image/PrinciplesOfDatabase/1-1-06.png', '1733', '2014-01-10 14:15:01');

-- ----------------------------
-- Table structure for `t_ppt_info`
-- ----------------------------
DROP TABLE IF EXISTS `t_ppt_info`;
CREATE TABLE `t_ppt_info` (
  `PPT_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `COURSE_ID` int(10) unsigned NOT NULL,
  `COURSE_CHARPTER` tinyint(4) unsigned NOT NULL,
  `LESSON_SEQ` tinyint(4) unsigned NOT NULL,
  `PDF_URL` text COLLATE utf8_unicode_ci NOT NULL COMMENT 'url of course pdf corresponding the exact ppt',
  `VIDEO_URL` text COLLATE utf8_unicode_ci COMMENT 'course video''s url',
  `TIMESTAMP` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`PPT_ID`),
  KEY `COURSE_ID` (`COURSE_ID`),
  CONSTRAINT `t_ppt_info_ibfk_1` FOREIGN KEY (`COURSE_ID`) REFERENCES `t_course_info` (`COURSE_ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of t_ppt_info
-- ----------------------------
INSERT INTO `t_ppt_info` VALUES ('1', '1', '1', '1', 'as', '/video/PrinciplesOfDatabase/1-1.mp4', '2014-01-10 17:18:42');
INSERT INTO `t_ppt_info` VALUES ('2', '1', '1', '2', 'as', '/video/PrinciplesOfDatabase/1-1.mp4', '2014-01-10 17:18:44');
INSERT INTO `t_ppt_info` VALUES ('3', '1', '1', '3', '1232ss', '/video/PrinciplesOfDatabase/1-1.mp4', '2014-01-10 17:18:47');
INSERT INTO `t_ppt_info` VALUES ('4', '2', '1', '1', '/pdf/PrinciplesOfDatabase/1-1.pdf', '/video/PrinciplesOfDatabase/1-1.mp4', '2014-01-10 14:13:26');
INSERT INTO `t_ppt_info` VALUES ('5', '2', '1', '2', '/pdf/PrinciplesOfDatabase/1-1.pdf', '/video/PrinciplesOfDatabase/1-1.mp4', '2014-01-10 14:13:28');
INSERT INTO `t_ppt_info` VALUES ('6', '2', '1', '3', '/pdf/PrinciplesOfDatabase/1-1.pdf', '/video/PrinciplesOfDatabase/1-1.mp4', '2014-01-10 14:13:38');

-- ----------------------------
-- Table structure for `t_ppt_remark`
-- ----------------------------
DROP TABLE IF EXISTS `t_ppt_remark`;
CREATE TABLE `t_ppt_remark` (
  `CLASS_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `PPT_ID` int(10) unsigned NOT NULL,
  `PPT_PAGE_NUM` int(10) unsigned NOT NULL,
  `REMARK` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `TIMESTAMP` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`CLASS_ID`,`PPT_ID`,`PPT_PAGE_NUM`),
  KEY `PPT_ID` (`PPT_ID`),
  CONSTRAINT `t_ppt_remark_ibfk_1` FOREIGN KEY (`CLASS_ID`) REFERENCES `t_class_info` (`CLASS_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `t_ppt_remark_ibfk_2` FOREIGN KEY (`PPT_ID`) REFERENCES `t_ppt_info` (`PPT_ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of t_ppt_remark
-- ----------------------------
INSERT INTO `t_ppt_remark` VALUES ('1', '4', '1', 'very good!', '2014-01-09 23:20:06');
INSERT INTO `t_ppt_remark` VALUES ('1', '4', '2', '这是在测试￥，这是更改后的版333', '2014-02-13 22:34:40');
INSERT INTO `t_ppt_remark` VALUES ('1', '4', '3', 'Xixi world!', '2014-01-09 23:19:54');
INSERT INTO `t_ppt_remark` VALUES ('1', '4', '4', 'Haha world!', '2014-01-09 23:19:27');
INSERT INTO `t_ppt_remark` VALUES ('1', '4', '5', 'undefined', '2014-02-13 13:50:25');
INSERT INTO `t_ppt_remark` VALUES ('1', '4', '233', '这是在测试￥，这是更改后的版333', '2014-02-13 14:28:58');
INSERT INTO `t_ppt_remark` VALUES ('2', '1', '4', '这是在测试￥，这是更改后的版333', '2014-02-13 22:35:07');

-- ----------------------------
-- Table structure for `t_preparation`
-- ----------------------------
DROP TABLE IF EXISTS `t_preparation`;
CREATE TABLE `t_preparation` (
  `PREPARATION_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `COURSE_ID` int(10) unsigned NOT NULL,
  `COURSE_CHARPTER` tinyint(4) unsigned NOT NULL,
  `LESSON_SEQ` tinyint(4) unsigned NOT NULL,
  `CONTENT` varchar(255) NOT NULL,
  `TIMESTAMP` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`PREPARATION_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of t_preparation
-- ----------------------------
INSERT INTO `t_preparation` VALUES ('1', '2', '1', '1', '这22个是教案的，也就是说实在的教学', '2014-02-13 22:13:53');
INSERT INTO `t_preparation` VALUES ('2', '1', '1', '1', '这22345个是教案的，也就是说实在的教学', '2014-02-13 22:19:54');
INSERT INTO `t_preparation` VALUES ('3', '2', '2', '1', '教案的，也/（）‘就是说实在的教学', '2014-02-13 22:23:37');
INSERT INTO `t_preparation` VALUES ('4', '2', '2', '12', '教案的，也/（）‘就是说实在的教学', '2014-02-13 22:23:52');

-- ----------------------------
-- Table structure for `t_progress`
-- ----------------------------
DROP TABLE IF EXISTS `t_progress`;
CREATE TABLE `t_progress` (
  `CLASS_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `PRE_CHARPTER_ID` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `PRE_LESSON_ID` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `ON_CHARPTER_ID` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `ON_LESSON_ID` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `TIMESTAMP` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`CLASS_ID`),
  CONSTRAINT `t_progress_ibfk_1` FOREIGN KEY (`CLASS_ID`) REFERENCES `t_class_info` (`CLASS_ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of t_progress
-- ----------------------------
INSERT INTO `t_progress` VALUES ('1', '1', '1', '1', '1', '2014-02-10 21:29:49');
INSERT INTO `t_progress` VALUES ('2', '1', '1', '1', '1', '2014-02-10 21:29:50');

-- ----------------------------
-- Table structure for `t_question_info`
-- ----------------------------
DROP TABLE IF EXISTS `t_question_info`;
CREATE TABLE `t_question_info` (
  `QUESTION_ID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `QUESTION_CONTENT` text COLLATE utf8_unicode_ci NOT NULL,
  `ANSWER` text COLLATE utf8_unicode_ci NOT NULL,
  `TIMESTAMP` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`QUESTION_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of t_question_info
-- ----------------------------
INSERT INTO `t_question_info` VALUES ('1', '什么是事务？它有哪些属性？', '事务是用户定义的一个操作序列，这些操作要么全做要么全不做，事务是一个不可分割的工作单位。事务具有四个特性：原子性、一致性、隔离性和持续性。\r\n这个四个特性也简称为ACID特性。', '2014-01-10 16:27:10');
INSERT INTO `t_question_info` VALUES ('2', '简述数据库的物理设计内容', '主要包括了以下工作：\r\n(1) 确定数据的存储结构，决定是否采用聚簇功能。\r\n(2）设计数据的存取路径，决定是否建立索引，建多少索引，在哪些列或多列上建索引等。 \r\n(3）确定数据的存放的物理位置，决定是否将经常存取部分和存取频率较低部分分开存放等。 \r\n(4）确定系统配置参数，根据DBMS产品提供了一些存储分配参数，数据库进行物理优化。\r\n(5) 评价物理结构, 估算各种方案的存储空间、存取时间和维护代价，对估算结果进行权衡、比较，选择出一个较优的合理的物理结构。', '2014-01-10 16:27:33');
INSERT INTO `t_question_info` VALUES ('3', 'RDBMS在实现参照完整性时需要考虑哪些方面的问题，以及可以采取的策略？', '1）外码能否接受空值\r\n   （2）删除被参照关系中的元组。这时可有三种不同的策略： \r\n    . 级联删除：同时删除参照关系中相关元组； \r\n    . 受限删除：仅当参照关系中没有任何元组的外码值与被参照关系中要删除元组的主码值相同时，系统才执行删除操作，否则拒绝此删除操作。 \r\n     .置空值删除：删除被参照关系的元组，并将参照关系中相应元组的外码值置空值。 \r\n( 3 ) 在参照关系中插入元组\r\n        当参照关系插入某个元组，而被参照关系不存在相应的元组，其主码值与参照关系插入元组的外码值相同，这时可有以下策略： \r\n     .受限插入：不允许在参照关系中插入； \r\n     .递归插入：同时在被参照关系中插入一个元组，其主码值为插入元组的外码值。', '2014-01-10 16:28:12');
INSERT INTO `t_question_info` VALUES ('4', '简述预防死锁通常有两种方法。', '预防死锁通常有两种：一次封锁法和顺序封锁法。\r\n       一次封锁法：一次封锁法要求每个事务必须一次将所有要使用的数据全部加锁，否则就不能继续执行。一次封锁法虽然可以有效地防止死锁的发生，但每次要就将以后用到的全部数据加锁，从而降低了系统的并发度。\r\n       顺序封锁法：顺序封锁法是预先对数据对象规定一个封锁顺序，所有事务都按这个顺序实行封锁', '2014-01-10 16:30:04');

-- ----------------------------
-- Table structure for `t_question_lesson_rel`
-- ----------------------------
DROP TABLE IF EXISTS `t_question_lesson_rel`;
CREATE TABLE `t_question_lesson_rel` (
  `QUESTION_LESSON_REL_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `QUESTION_ID` int(11) unsigned NOT NULL,
  `COURSE_ID` int(11) unsigned NOT NULL,
  `COURSE_CHARPTER` tinyint(4) NOT NULL,
  `LESSON_SEQ` tinyint(4) NOT NULL,
  `TIMESTAMP` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`QUESTION_LESSON_REL_ID`),
  KEY `COURSE_ID` (`COURSE_ID`),
  KEY `QUESTION_ID` (`QUESTION_ID`),
  CONSTRAINT `t_question_lesson_rel_ibfk_1` FOREIGN KEY (`COURSE_ID`) REFERENCES `t_course_info` (`COURSE_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `t_question_lesson_rel_ibfk_2` FOREIGN KEY (`QUESTION_ID`) REFERENCES `t_question_info` (`QUESTION_ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of t_question_lesson_rel
-- ----------------------------
INSERT INTO `t_question_lesson_rel` VALUES ('1', '1', '2', '1', '1', '2014-01-10 16:56:22');
INSERT INTO `t_question_lesson_rel` VALUES ('2', '2', '2', '1', '1', '2014-01-10 16:56:23');
INSERT INTO `t_question_lesson_rel` VALUES ('3', '3', '2', '1', '1', '2014-01-10 16:56:24');
INSERT INTO `t_question_lesson_rel` VALUES ('4', '4', '2', '1', '1', '2014-01-10 16:56:29');

-- ----------------------------
-- Table structure for `t_train_course_rel`
-- ----------------------------
DROP TABLE IF EXISTS `t_train_course_rel`;
CREATE TABLE `t_train_course_rel` (
  `TRAIN_COURSE_REL_ID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `TRAIN_ID` int(11) unsigned NOT NULL,
  `COURSE_ID` int(11) unsigned NOT NULL,
  `TIMESTAMP` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`TRAIN_COURSE_REL_ID`),
  KEY `TRAIN_ID` (`TRAIN_ID`),
  KEY `COURSE_ID` (`COURSE_ID`),
  CONSTRAINT `t_train_course_rel_ibfk_1` FOREIGN KEY (`TRAIN_ID`) REFERENCES `t_train_info` (`TRAIN_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `t_train_course_rel_ibfk_2` FOREIGN KEY (`COURSE_ID`) REFERENCES `t_course_info` (`COURSE_ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of t_train_course_rel
-- ----------------------------

-- ----------------------------
-- Table structure for `t_train_info`
-- ----------------------------
DROP TABLE IF EXISTS `t_train_info`;
CREATE TABLE `t_train_info` (
  `TRAIN_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `TRAIN_NAME` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `TRAIN_TYPE` tinyint(4) NOT NULL COMMENT '1 stands for the tiny one for a certain lesson, 2 stands for the big one corresponding to a course, 2 stands for a biggest one needed several courses',
  `TRAIN_DESC` text COLLATE utf8_unicode_ci,
  `TIMESTAMP` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`TRAIN_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of t_train_info
-- ----------------------------

-- ----------------------------
-- Table structure for `t_train_lesson_rel`
-- ----------------------------
DROP TABLE IF EXISTS `t_train_lesson_rel`;
CREATE TABLE `t_train_lesson_rel` (
  `TRAIN_LESSON_REL_ID` int(11) NOT NULL,
  `COURSE_ID` int(11) unsigned NOT NULL,
  `COURSE_CHARPTER` tinyint(4) NOT NULL,
  `LESSON_SEQ` tinyint(4) NOT NULL,
  `TRAIN_ID` int(11) unsigned NOT NULL,
  `ENV_DESC` text COLLATE utf8_unicode_ci COMMENT 'the environment setup description for this lesson',
  `TIMESTAMP` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`TRAIN_LESSON_REL_ID`),
  KEY `COURSE_ID` (`COURSE_ID`),
  KEY `TRAIN_ID` (`TRAIN_ID`),
  CONSTRAINT `t_train_lesson_rel_ibfk_1` FOREIGN KEY (`COURSE_ID`) REFERENCES `t_course_info` (`COURSE_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `t_train_lesson_rel_ibfk_2` FOREIGN KEY (`TRAIN_ID`) REFERENCES `t_train_info` (`TRAIN_ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of t_train_lesson_rel
-- ----------------------------

-- ----------------------------
-- Table structure for `t_user_info`
-- ----------------------------
DROP TABLE IF EXISTS `t_user_info`;
CREATE TABLE `t_user_info` (
  `USER_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `USER_NAME` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `PASSWORD` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `ID_TYPE` tinyint(4) NOT NULL COMMENT '1 stands for the personal identification',
  `ID_VALUE` text COLLATE utf8_unicode_ci NOT NULL,
  `USER_TYPE` tinyint(4) NOT NULL COMMENT '1 stands for teacher;2 stands for student',
  `EMAIL` text COLLATE utf8_unicode_ci NOT NULL,
  `BIRTHDAY` date NOT NULL,
  `TIMESTAMP` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'registeration time',
  PRIMARY KEY (`USER_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of t_user_info
-- ----------------------------
INSERT INTO `t_user_info` VALUES ('1', '蓝翔', '123', '1', '110119120', '2', 'xlan@seu.edu.cn', '1993-11-18', '2013-12-08 00:08:43');
INSERT INTO `t_user_info` VALUES ('2', '张祥', '123', '1', '120', '1', 'xzhang@seu.edu.cn', '2013-12-24', '2013-12-08 00:11:21');
INSERT INTO `t_user_info` VALUES ('3', 'Charles', ' e10adc3949ba59abbe56e057f20f883e', '1', ' 321027199311185417', '1', ' xlan@seu.edu.cn', '1993-11-18', '2013-12-17 22:55:49');
INSERT INTO `t_user_info` VALUES ('4', ' lanxiang', ' e10adc3949ba59abbe56e057f20f883e', '1', ' 321027199311185417', '1', ' xiangxiang@seu.edu.cn', '1993-11-18', '2013-12-17 22:56:40');
INSERT INTO `t_user_info` VALUES ('5', 'lx', '202cb962ac59075b964b07152d234b70', '1', '321027199311185000', '2', '3@1.com', '1993-11-18', '2013-12-28 10:12:58');
INSERT INTO `t_user_info` VALUES ('6', 'lanxiang', 'c4ca4238a0b923820dcc509a6f75849b', '1', '321027188311185417', '1', 'xlan@seu.edu.cn', '1993-11-18', '2014-01-06 20:11:39');
INSERT INTO `t_user_info` VALUES ('7', 'lanxiang2', 'c4ca4238a0b923820dcc509a6f75849b', '1', '321027188888888888', '1', 'xlan@seu.edu.cn', '1993-11-18', '2014-01-06 20:59:09');
INSERT INTO `t_user_info` VALUES ('8', '123', '202cb962ac59075b964b07152d234b70', '1', '111111111111111111', '1', 'cwlseu@qq.com', '1991-11-11', '2014-02-12 11:35:01');
INSERT INTO `t_user_info` VALUES ('9', '1', '202cb962ac59075b964b07152d234b70', '1', '123456789012345678', '1', '123@seu.edu.cn', '1992-11-11', '2014-02-12 11:43:07');
INSERT INTO `t_user_info` VALUES ('10', '2', '202cb962ac59075b964b07152d234b70', '1', '123456789009876543', '2', '213110389@seu.edu.cn', '1976-12-12', '2014-02-12 11:44:41');
INSERT INTO `t_user_info` VALUES ('11', 'laoliu', '202cb962ac59075b964b07152d234b70', '1', '098765432112345678', '2', 'laoliu@seu.edu.cn', '1970-03-12', '2014-02-12 11:46:21');
INSERT INTO `t_user_info` VALUES ('12', 'laozhao', '202cb962ac59075b964b07152d234b70', '1', '374712345673433434', '2', '123@cwlseu.com', '1969-02-04', '2014-02-12 11:47:58');
INSERT INTO `t_user_info` VALUES ('13', '1234', '202cb962ac59075b964b07152d234b70', '1', '123123123123123123', '1', 'cwlseu@11.com', '1992-11-11', '2014-02-12 20:04:43');
