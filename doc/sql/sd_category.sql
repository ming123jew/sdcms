/*
Navicat MySQL Data Transfer

Source Server         : 119.29.25.102_3307
Source Server Version : 50717
Source Host           : 119.29.25.102:3307
Source Database       : huiz_2018_nianhui

Target Server Type    : MYSQL
Target Server Version : 50717
File Encoding         : 65001

Date: 2018-02-07 15:00:08
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `sd_category`
-- ----------------------------
DROP TABLE IF EXISTS `sd_category`;
CREATE TABLE `sd_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `model_id` smallint(5) NOT NULL DEFAULT '1' COMMENT '模型ID',
  `catname` varchar(40) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `description` varchar(200) DEFAULT NULL,
  `arc_count` int(11) NOT NULL DEFAULT '0' COMMENT '文章数',
  `setting` text COMMENT 'seo json',
  `list_order` smallint(5) NOT NULL DEFAULT '0',
  `is_menu` tinyint(2) NOT NULL DEFAULT '0',
  `status` tinyint(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sd_category
-- ----------------------------
