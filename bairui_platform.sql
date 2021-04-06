/*
 Navicat Premium Data Transfer

 Source Server         : local
 Source Server Type    : MySQL
 Source Server Version : 50728
 Source Host           : localhost:3306
 Source Schema         : bairui_platform

 Target Server Type    : MySQL
 Target Server Version : 50728
 File Encoding         : 65001

 Date: 31/03/2021 21:26:34
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for br_article
-- ----------------------------
DROP TABLE IF EXISTS `br_article`;
CREATE TABLE `br_article` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL COMMENT '用户id',
  `title` varchar(100) NOT NULL COMMENT '标题',
  `content` text COMMENT '内容',
  `created_at` int(10) DEFAULT NULL COMMENT '创建时间',
  `updated_at` int(10) DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COMMENT='文章表';

-- ----------------------------
-- Records of br_article
-- ----------------------------
BEGIN;
INSERT INTO `br_article` VALUES (1, 1, '测试', NULL, NULL, NULL);
INSERT INTO `br_article` VALUES (2, 1, '测试2', NULL, NULL, NULL);
COMMIT;

-- ----------------------------
-- Table structure for br_backend_member
-- ----------------------------
DROP TABLE IF EXISTS `br_backend_member`;
CREATE TABLE `br_backend_member` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL COMMENT '姓名',
  `account` varchar(20) NOT NULL COMMENT '账号',
  `password` varchar(100) NOT NULL COMMENT '密码',
  `role_id` tinyint(2) NOT NULL COMMENT '角色id',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态：1正常，-1冻结',
  `created_at` int(10) NOT NULL COMMENT '创建时间',
  `updated_at` int(10) NOT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COMMENT='后台会员表';

-- ----------------------------
-- Records of br_backend_member
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for br_member
-- ----------------------------
DROP TABLE IF EXISTS `br_member`;
CREATE TABLE `br_member` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `account` varchar(50) DEFAULT NULL COMMENT '账号',
  `password_hash` varchar(100) DEFAULT NULL COMMENT '密码',
  `salt` varchar(10) DEFAULT NULL COMMENT '加密盐',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态：1正常，0禁用，-1删除',
  `created_at` int(10) DEFAULT NULL COMMENT '创建时间',
  `updated_at` int(10) DEFAULT NULL COMMENT '更新时间',
  `login_times` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '登录次数',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COMMENT='会员表';

-- ----------------------------
-- Records of br_member
-- ----------------------------
BEGIN;
INSERT INTO `br_member` VALUES (1, 'admin', '6da75847a9c8042cbc9d93a25cc5dc2a', '!@#$1%', 1, 1617105535, 1617105879, 0);
INSERT INTO `br_member` VALUES (3, 'member1', '7ee53190b68a13a1a79bc96d2781f68e', 'h1JBYZ', 1, 1617160230, 1617160230, 0);
INSERT INTO `br_member` VALUES (4, 'admin123', 'b4dbef313de60f6b6d341511a8994d28', 'cUvgFc', 1, 1617174301, 1617174301, 0);
COMMIT;

-- ----------------------------
-- Table structure for br_user_token
-- ----------------------------
DROP TABLE IF EXISTS `br_user_token`;
CREATE TABLE `br_user_token` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL COMMENT '用户id',
  `type` varchar(10) NOT NULL DEFAULT 'api' COMMENT '分类',
  `token` varchar(255) NOT NULL COMMENT '生成token',
  `created_at` int(10) NOT NULL COMMENT '创建时间',
  `updated_at` int(10) NOT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COMMENT='用户token表';

-- ----------------------------
-- Records of br_user_token
-- ----------------------------
BEGIN;
INSERT INTO `br_user_token` VALUES (7, 1, 'api', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiIhQCMkJSomIiwiYXVkIjoiIiwiaWF0IjoxNjE3MTk1OTI2LCJuYmYiOjE2MTcxOTU5MjYsImV4cCI6MTYxNzIwMzEyNiwiZGF0YSI6eyJ1aWQiOjF9fQ.22f8TaxfziK1hWmaINXRW8tJpveuFvD1-t-IKKx5s7k', 1617174683, 1617174683);
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
