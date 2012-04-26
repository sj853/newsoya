



-- ---
-- Globals
-- ---

-- SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
-- SET FOREIGN_KEY_CHECKS=0;

-- ---
-- Table 'kw_task'
-- 
-- ---

DROP TABLE IF EXISTS `kw_task`;
		
CREATE TABLE `kw_task` (
  `id` INTEGER NOT NULL AUTO_INCREMENT DEFAULT NULL,
  `keyword` VARCHAR NOT NULL DEFAULT 'NULL' COMMENT '关键字',
  `time` DATETIME NOT NULL DEFAULT 'NULL' COMMENT '抓取时间',
  `hotlevel` INTEGER NOT NULL DEFAULT 0 COMMENT '火热程度',
  `type` INTEGER NOT NULL DEFAULT 0 COMMENT '关键字来源',
  `type_desc` VARCHAR NULL COMMENT '关键字来源描述',
  `pid` INTEGER NOT NULL DEFAULT 0 COMMENT '上级关键字',
  PRIMARY KEY (`id`)
);

-- ---
-- Table 'kw_result'
-- 关键词结果
-- ---

DROP TABLE IF EXISTS `kw_result`;
		
CREATE TABLE `kw_result` (
  `id` INTEGER NULL AUTO_INCREMENT DEFAULT NULL,
  `kid` INTEGER NOT NULL DEFAULT NULL COMMENT '关键字ID',
  `content` MEDIUMTEXT NULL COMMENT '内容',
  `title` MEDIUMTEXT NULL COMMENT '标题',
  `url` MEDIUMTEXT NULL DEFAULT NULL COMMENT '链接',
  `time` DATETIME NOT NULL COMMENT '时间',
  PRIMARY KEY (`id`)
) COMMENT '关键词结果';

-- ---
-- Foreign Keys 
-- ---


-- ---
-- Table Properties
-- ---

-- ALTER TABLE `kw_task` ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
-- ALTER TABLE `kw_result` ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ---
-- Test Data
-- ---

-- INSERT INTO `kw_task` (`id`,`keyword`,`time`,`hotlevel`,`type`,`type_desc`,`pid`) VALUES
-- ('','','','','','','');
-- INSERT INTO `kw_result` (`id`,`kid`,`content`,`title`,`url`,`time`) VALUES
-- ('','','','','','');

