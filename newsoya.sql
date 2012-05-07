/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50520
Source Host           : localhost:3306
Source Database       : soya_data

Target Server Type    : MYSQL
Target Server Version : 50520
File Encoding         : 65001

Date: 2012-05-07 17:29:42
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `kw_result`
-- ----------------------------
DROP TABLE IF EXISTS `kw_result`;
CREATE TABLE `kw_result` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kid` int(11) NOT NULL,
  `content` longtext,
  `title` text,
  `url` longtext,
  `time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of kw_result
-- ----------------------------

-- ----------------------------
-- Table structure for `kw_task`
-- ----------------------------
DROP TABLE IF EXISTS `kw_task`;
CREATE TABLE `kw_task` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `keyword` varchar(100) NOT NULL,
  `time` datetime NOT NULL,
  `hotlevel` int(11) NOT NULL DEFAULT '0',
  `type` int(11) NOT NULL DEFAULT '0',
  `type_desc` varchar(100) DEFAULT NULL,
  `isok` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of kw_task
-- ----------------------------
INSERT INTO `kw_task` VALUES ('1', '脸上的痘印怎么去除', '2012-05-07 16:24:06', '1', '1', '爱站关键字', '0');
INSERT INTO `kw_task` VALUES ('2', '中央领导人的子女', '2012-05-07 16:23:59', '1', '1', '爱站关键字', '0');
INSERT INTO `kw_task` VALUES ('3', '360', '2012-05-07 16:23:59', '1', '1', '爱站关键字', '0');
INSERT INTO `kw_task` VALUES ('4', '小妹妹', '2012-05-07 16:23:59', '1', '1', '爱站关键字', '0');
INSERT INTO `kw_task` VALUES ('5', '食人鱼', '2012-05-07 16:23:59', '1', '1', '爱站关键字', '0');
INSERT INTO `kw_task` VALUES ('6', '360垃圾', '2012-05-07 16:23:59', '1', '1', '爱站关键字', '0');
INSERT INTO `kw_task` VALUES ('7', '推一把', '2012-05-07 16:23:59', '1', '1', '爱站关键字', '0');
INSERT INTO `kw_task` VALUES ('8', 'dsf', '2012-05-07 16:23:39', '1', '1', '爱站关键字', '0');
INSERT INTO `kw_task` VALUES ('9', 'esprit', '2012-05-07 16:23:39', '1', '1', '爱站关键字', '0');
INSERT INTO `kw_task` VALUES ('10', '光荣使命', '2012-05-07 16:23:39', '1', '1', '爱站关键字', '0');
INSERT INTO `kw_task` VALUES ('11', '产后食谱', '2012-05-07 16:23:39', '1', '1', '爱站关键字', '0');
INSERT INTO `kw_task` VALUES ('12', '特火', '2012-05-07 16:24:06', '1', '1', '爱站关键字', '0');
INSERT INTO `kw_task` VALUES ('13', '除味活性炭', '2012-05-07 16:24:06', '1', '1', '爱站关键字', '0');
INSERT INTO `kw_task` VALUES ('14', '天线宝宝', '2012-05-07 16:24:06', '1', '1', '爱站关键字', '0');
INSERT INTO `kw_task` VALUES ('15', '玫瑰花茶', '2012-05-07 16:24:06', '1', '1', '爱站关键字', '0');
INSERT INTO `kw_task` VALUES ('16', '地沟油', '2012-05-07 16:24:15', '1', '1', '爱站关键字', '0');
INSERT INTO `kw_task` VALUES ('17', '色差仪', '2012-05-07 16:24:15', '1', '1', '爱站关键字', '0');
INSERT INTO `kw_task` VALUES ('18', '二人转', '2012-05-07 16:24:15', '1', '1', '爱站关键字', '0');
INSERT INTO `kw_task` VALUES ('19', '英语', '2012-05-07 16:24:05', '1', '1', '爱站关键字', '0');
INSERT INTO `kw_task` VALUES ('20', '远程', '2012-05-07 16:24:05', '1', '1', '爱站关键字', '0');
INSERT INTO `kw_task` VALUES ('21', '教程', '2012-05-07 16:24:05', '1', '1', '爱站关键字', '0');
INSERT INTO `kw_task` VALUES ('22', '12ddd', '2012-05-07 16:24:15', '1', '1', '爱站关键字', '0');
INSERT INTO `kw_task` VALUES ('23', 'windows mediaplay', '2012-05-07 16:24:15', '1', '1', '爱站关键字', '0');
INSERT INTO `kw_task` VALUES ('24', 'pes2011', '2012-05-07 16:24:15', '1', '1', '爱站关键字', '0');
INSERT INTO `kw_task` VALUES ('25', '进口红酒', '2012-05-07 16:24:15', '1', '1', '爱站关键字', '0');
INSERT INTO `kw_task` VALUES ('26', '超级', '2012-05-07 16:24:15', '1', '1', '爱站关键字', '0');
INSERT INTO `kw_task` VALUES ('27', '睡眠不好如何调理', '2012-05-07 16:24:15', '1', '1', '爱站关键字', '0');
INSERT INTO `kw_task` VALUES ('28', 'www.se', '2012-05-07 16:24:15', '1', '1', '爱站关键字', '0');
INSERT INTO `kw_task` VALUES ('29', '手机游戏破解版下载', '2012-05-07 16:24:15', '1', '1', '爱站关键字', '0');
INSERT INTO `kw_task` VALUES ('30', '除味活性炭', '2012-05-07 17:28:19', '1', '0', '用户查询', '0');
INSERT INTO `kw_task` VALUES ('31', '除味活性炭', '2012-05-07 17:28:32', '1', '0', '用户查询', '0');
INSERT INTO `kw_task` VALUES ('32', '除味活性炭', '2012-05-07 17:28:33', '1', '0', '用户查询', '0');
INSERT INTO `kw_task` VALUES ('33', '除味活性炭', '2012-05-07 17:28:35', '1', '0', '用户查询', '0');
