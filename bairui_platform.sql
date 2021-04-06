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

 Date: 06/04/2021 16:57:36
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
  `password_hash` varchar(100) NOT NULL COMMENT '密码',
  `salt` varchar(10) NOT NULL COMMENT '加密盐',
  `role_id` tinyint(2) NOT NULL COMMENT '角色id',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态：1正常，-1冻结',
  `created_at` int(10) NOT NULL COMMENT '创建时间',
  `updated_at` int(10) NOT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COMMENT='后台用户表';

-- ----------------------------
-- Records of br_backend_member
-- ----------------------------
BEGIN;
INSERT INTO `br_backend_member` VALUES (1, '小林', 'admin', '6da75847a9c8042cbc9d93a25cc5dc2a', '!@#$1%', 1, 1, 1, 1);
COMMIT;

-- ----------------------------
-- Table structure for br_backend_permission
-- ----------------------------
DROP TABLE IF EXISTS `br_backend_permission`;
CREATE TABLE `br_backend_permission` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL COMMENT '名称',
  `action` varchar(50) NOT NULL COMMENT '路由',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态：1正常，-1禁用',
  `pid` int(11) NOT NULL DEFAULT '0' COMMENT '父id',
  `created_at` int(10) DEFAULT NULL COMMENT '创建时间',
  `updated_at` int(10) DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COMMENT='节点表';

-- ----------------------------
-- Records of br_backend_permission
-- ----------------------------
BEGIN;
INSERT INTO `br_backend_permission` VALUES (1, '文章管理', '/article/index', 1, 0, 1, 1);
INSERT INTO `br_backend_permission` VALUES (2, '文章列表', '/article/index', 1, 1, 1, 1);
INSERT INTO `br_backend_permission` VALUES (3, '添加文章', '/article/add', 1, 1, 1, 1);
COMMIT;

-- ----------------------------
-- Table structure for br_backend_role
-- ----------------------------
DROP TABLE IF EXISTS `br_backend_role`;
CREATE TABLE `br_backend_role` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `role_name` varchar(20) NOT NULL COMMENT '角色',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态：1正常，-1禁用',
  `created_at` int(10) NOT NULL COMMENT '创建时间',
  `updated_at` int(10) NOT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COMMENT='角色表';

-- ----------------------------
-- Records of br_backend_role
-- ----------------------------
BEGIN;
INSERT INTO `br_backend_role` VALUES (1, '总管理员', 1, 111, 111);
COMMIT;

-- ----------------------------
-- Table structure for br_backend_role_permission
-- ----------------------------
DROP TABLE IF EXISTS `br_backend_role_permission`;
CREATE TABLE `br_backend_role_permission` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `role_id` int(3) NOT NULL COMMENT '角色id',
  `permission_id` varchar(11) NOT NULL COMMENT '节点id',
  `created_at` int(10) DEFAULT NULL COMMENT '创建时间',
  `updated_at` int(10) DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COMMENT='角色权限表';

-- ----------------------------
-- Records of br_backend_role_permission
-- ----------------------------
BEGIN;
INSERT INTO `br_backend_role_permission` VALUES (1, 1, '1', 1, 1);
INSERT INTO `br_backend_role_permission` VALUES (2, 1, '2', 1, 1);
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
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COMMENT='用户token表';

-- ----------------------------
-- Records of br_user_token
-- ----------------------------
BEGIN;
INSERT INTO `br_user_token` VALUES (8, 1, 'backend', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiIhQCMkJSomIiwiYXVkIjoiIiwiaWF0IjoxNjE3NjkyNzgwLCJuYmYiOjE2MTc2OTI3ODAsImV4cCI6MTYxNzY5OTk4MCwiZGF0YSI6eyJ1aWQiOjEsImxvZ2luX3R5cGUiOiJiYWNrZW5kIn19.12ZhNivV56NbH8BeyA9YZcTpl3ho7UYAPK4JPXmVz3w', 1617354141, 1617354141);
INSERT INTO `br_user_token` VALUES (7, 1, 'api', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiIhQCMkJSomIiwiYXVkIjoiIiwiaWF0IjoxNjE3MzUxMDI3LCJuYmYiOjE2MTczNTEwMjcsImV4cCI6MTYxNzM1ODIyNywiZGF0YSI6eyJ1aWQiOjEsImxvZ2luX3R5cGUiOiJhcGkifX0.6a2VV2V_LNscLY_ltR9FiuIFVif8QrrIW397LOcrXi8', 1617174683, 1617174683);
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
