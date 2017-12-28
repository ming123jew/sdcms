/*
Navicat MySQL Data Transfer

Source Server         : 赠送服务器
Source Server Version : 50717
Source Host           : 123.207.0.104:3306
Source Database       : sd

Target Server Type    : MYSQL
Target Server Version : 50717
File Encoding         : 65001

Date: 2017-12-28 14:25:19
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `sd_admin_menu`
-- ----------------------------
DROP TABLE IF EXISTS `sd_admin_menu`;
CREATE TABLE `sd_admin_menu` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `parent_id` smallint(6) unsigned NOT NULL DEFAULT '0' COMMENT '父级ID',
  `app` char(20) NOT NULL COMMENT '应用名称app',
  `model` char(20) NOT NULL COMMENT '控制器',
  `action` char(20) NOT NULL COMMENT '操作名称',
  `url_param` char(50) NOT NULL COMMENT 'url参数',
  `type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '菜单类型  1：权限认证+菜单；0：只作为菜单',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '状态，1显示，0不显示',
  `name` varchar(50) NOT NULL COMMENT '菜单名称',
  `icon` varchar(50) NOT NULL COMMENT '菜单图标',
  `remark` varchar(255) NOT NULL COMMENT '备注',
  `list_order` smallint(6) unsigned NOT NULL DEFAULT '0' COMMENT '排序ID',
  `rule_param` varchar(255) NOT NULL COMMENT '验证规则',
  `nav_id` int(11) DEFAULT '0' COMMENT 'nav ID ',
  `request` varchar(255) NOT NULL COMMENT '请求方式（日志生成）',
  `log_rule` varchar(255) NOT NULL COMMENT '日志规则',
  PRIMARY KEY (`id`),
  KEY `status` (`status`) USING BTREE,
  KEY `model` (`model`) USING BTREE,
  KEY `parent_id` (`parent_id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=73 DEFAULT CHARSET=utf8 COMMENT='后台菜单表';

-- ----------------------------
-- Records of sd_admin_menu
-- ----------------------------
INSERT INTO `sd_admin_menu` VALUES ('1', '0', 'supervise', 'auth', 'default', '', '0', '1', '系统管理', '', '', '10', '', '0', '', '');
INSERT INTO `sd_admin_menu` VALUES ('2', '1', 'supervise', 'auth', 'default', '', '0', '1', '权限管理', '', '', '0', '', '0', '', '');
INSERT INTO `sd_admin_menu` VALUES ('3', '2', 'supervise', 'auth', 'role', '', '1', '1', '角色管理', '', '1', '0', '', '0', '', '');
INSERT INTO `sd_admin_menu` VALUES ('4', '3', 'supervise', 'auth', 'roleAdd', '', '1', '0', '角色增加', '', '', '0', '', '0', '', '{id}');
INSERT INTO `sd_admin_menu` VALUES ('5', '3', 'supervise', 'auth', 'roleEdit', '', '1', '0', '角色编辑', '', 'asdas', '0', '', '0', '', '');
INSERT INTO `sd_admin_menu` VALUES ('6', '3', 'supervise', 'auth', 'roleDelete', '', '1', '0', '角色删除', '', '', '0', '', '0', '', '');
INSERT INTO `sd_admin_menu` VALUES ('7', '3', 'supervise', 'auth', 'authorize', '', '1', '0', '角色授权', '', '', '0', '', '0', '', '');
INSERT INTO `sd_admin_menu` VALUES ('8', '1', 'supervise', 'auth', 'default', '', '0', '1', '菜单管理', '', '', '0', '', '0', '', '');
INSERT INTO `sd_admin_menu` VALUES ('9', '8', 'supervise', 'auth', 'menu', '', '1', '1', '菜单列表', '', '', '0', '', '0', '', '');
INSERT INTO `sd_admin_menu` VALUES ('10', '9', 'supervise', 'auth', 'menuAdd', '', '1', '0', '菜单增加', '', '', '0', '', '0', '', '');
INSERT INTO `sd_admin_menu` VALUES ('11', '9', 'supervise', 'auth', 'menuEdit', '', '1', '0', '菜单修改', '', '', '0', '', '0', 'POST', '我的ID是{id}  记入的目录{name}');
INSERT INTO `sd_admin_menu` VALUES ('12', '9', 'supervise', 'auth', 'menuDelete', '', '1', '0', '菜单删除', '', '', '0', '', '0', '', '');
INSERT INTO `sd_admin_menu` VALUES ('13', '9', 'supervise', 'auth', 'menuOrder', '', '1', '0', '菜单排序', '', '', '0', '', '0', '', '');
INSERT INTO `sd_admin_menu` VALUES ('14', '2', 'supervise', 'admin', 'index', '', '1', '1', '用户管理', '', '', '0', '', '0', '', '');
INSERT INTO `sd_admin_menu` VALUES ('15', '0', 'mediaManage', 'index', 'index', '', '0', '1', '媒介库管理', 'fa-cc-mastercard', '', '20', '', '0', '', '');
INSERT INTO `sd_admin_menu` VALUES ('16', '15', 'mediaManage', 'index', 'Index', '', '1', '1', '媒介库', '', '', '0', '', '0', '', '');
INSERT INTO `sd_admin_menu` VALUES ('20', '2', 'supervise', 'auth', 'log', '', '1', '1', '行为日志', '', '', '0', '', '0', '', '');
INSERT INTO `sd_admin_menu` VALUES ('19', '16', 'mediaManage', 'index', 'index', '', '1', '1', '所有列表', '', '', '2', '', '0', '', '');
INSERT INTO `sd_admin_menu` VALUES ('21', '20', 'supervise', 'auth', 'viewLog', '', '1', '0', '查看日志', '', '', '0', '', '0', '', '');
INSERT INTO `sd_admin_menu` VALUES ('22', '20', 'supervise', 'auth', 'clear', '', '1', '0', '清空日志', '', '', '0', '', '0', '', '');
INSERT INTO `sd_admin_menu` VALUES ('23', '16', 'mediaManage', 'upload', 'index', '', '1', '1', '上传', '', '', '2', '', '0', '', '');
INSERT INTO `sd_admin_menu` VALUES ('24', '15', 'mediaManage', 'category', 'index', '', '1', '1', '媒介库分类', '', '', '0', '', '0', '', '');
INSERT INTO `sd_admin_menu` VALUES ('25', '24', 'mediaManage', 'category', 'add', '', '1', '0', '分类增加', '', '', '0', '', '0', '', '');
INSERT INTO `sd_admin_menu` VALUES ('26', '24', 'mediaManage', 'category', 'edit', '', '1', '0', '分类修改', '', '', '0', '', '0', '', '');
INSERT INTO `sd_admin_menu` VALUES ('27', '24', 'mediaManage', 'category', 'delete', '', '1', '0', '分类删除', '', '', '0', '', '0', '', '');
INSERT INTO `sd_admin_menu` VALUES ('28', '24', 'mediaManage', 'category', 'index', '', '1', '1', '分类列表', '', '', '0', '', '0', '', '');
INSERT INTO `sd_admin_menu` VALUES ('29', '0', 'magazine', 'index', 'index', '', '1', '1', '期刊发布系统', '', '', '0', '', '0', '', '');
INSERT INTO `sd_admin_menu` VALUES ('30', '29', 'magazine', 'category', 'index', '', '1', '1', '分类管理', '', '', '0', '', '0', '', '');
INSERT INTO `sd_admin_menu` VALUES ('31', '30', 'magazine', 'category', 'add', '', '1', '0', '增加', '', '', '0', '', '0', '', '');
INSERT INTO `sd_admin_menu` VALUES ('32', '30', 'magazine', 'category', 'edit', '', '1', '0', '修改', '', '', '0', '', '0', '', '');
INSERT INTO `sd_admin_menu` VALUES ('33', '30', 'magazine', 'category', 'delete', '', '1', '0', '删除', '', '', '0', '', '0', '', '');
INSERT INTO `sd_admin_menu` VALUES ('34', '30', 'magazine', 'category', 'index', '', '1', '1', '列表', '', '', '0', '', '0', '', '');
INSERT INTO `sd_admin_menu` VALUES ('35', '29', 'magazine', 'content', 'index', '', '1', '1', '内容管理', '', '', '0', '', '0', '', '');
INSERT INTO `sd_admin_menu` VALUES ('36', '35', 'magazine', 'content', 'add', '', '1', '0', '增加', '', '', '0', '', '0', '', '');
INSERT INTO `sd_admin_menu` VALUES ('37', '35', 'magazine', 'content', 'edit', '', '1', '0', '修改', '', '', '0', '', '0', '', '');
INSERT INTO `sd_admin_menu` VALUES ('38', '35', 'magazine', 'content', 'delete', '', '1', '0', '删除', '', '', '0', '', '0', '', '');
INSERT INTO `sd_admin_menu` VALUES ('39', '35', 'magazine', 'content', 'index', '', '1', '1', '列表导航', '', '', '0', '', '0', '', '');
INSERT INTO `sd_admin_menu` VALUES ('40', '35', 'magazine', 'content', 'listsub', '', '1', '0', '期刊内容', '', '', '0', '', '0', '', '');
INSERT INTO `sd_admin_menu` VALUES ('41', '40', 'magazine', 'content', 'addsub', '', '1', '0', '添加期刊内容', '', '', '0', '', '0', '', '');
INSERT INTO `sd_admin_menu` VALUES ('42', '40', 'magazine', 'content', 'editsub', '', '1', '0', '修改期刊内容', '', '', '0', '', '0', '', '');
INSERT INTO `sd_admin_menu` VALUES ('43', '40', 'magazine', 'content', 'checksub', '', '1', '0', '审核期刊内容', '', '', '0', '', '0', '', '');
INSERT INTO `sd_admin_menu` VALUES ('44', '35', 'magazine', 'content', 'check', '', '1', '0', '审核期刊', '', '', '0', '', '0', '', '');
INSERT INTO `sd_admin_menu` VALUES ('45', '35', 'magazine', 'content', 'menu', '', '1', '0', '栏目菜单条', '', '', '0', '', '0', '', '');
INSERT INTO `sd_admin_menu` VALUES ('46', '35', 'magazine', 'content', 'lists', '', '1', '0', '列表内容', '', '', '0', '', '0', '', '');
INSERT INTO `sd_admin_menu` VALUES ('48', '29', 'magazine', 'setting', 'index', '', '1', '1', '基本设置', '', '', '0', '', '0', '', '');
INSERT INTO `sd_admin_menu` VALUES ('49', '48', 'magazine', 'setting', 'index', '', '1', '1', '设置', '', '', '0', '', '0', '', '');
INSERT INTO `sd_admin_menu` VALUES ('50', '29', 'magazine', 'ueditor', 'index', '', '1', '0', 'ueditor', '', '', '0', '', '0', '', '');
INSERT INTO `sd_admin_menu` VALUES ('51', '40', 'magazine', 'content', 'deletesub', '', '1', '0', '删除期刊内容', '', '', '0', '', '0', '', '');
INSERT INTO `sd_admin_menu` VALUES ('52', '35', 'magazine', 'content', 'uploadthumb', '', '1', '0', '上传缩略图', '', '', '0', '', '0', '', '');
INSERT INTO `sd_admin_menu` VALUES ('53', '16', 'mediaManage', 'upload', 'manage', '', '1', '1', '文档管理', '', '', '2', '', '0', '', '');
INSERT INTO `sd_admin_menu` VALUES ('54', '0', 'vote', 'admin', 'index', '', '1', '1', '投票系统', '', '', '0', '', '0', '', '');
INSERT INTO `sd_admin_menu` VALUES ('55', '54', 'vote', 'category', 'index', '', '1', '1', '投票分类', '', '', '0', '', '0', '', '');
INSERT INTO `sd_admin_menu` VALUES ('56', '54', 'vote', 'manager', 'index', '', '1', '1', '投票管理', '', '', '0', '', '0', '', '');
INSERT INTO `sd_admin_menu` VALUES ('57', '55', 'vote', 'category', 'add', '', '1', '1', '添加分类', '', '', '1', '', '0', '', '');
INSERT INTO `sd_admin_menu` VALUES ('58', '55', 'vote', 'category', 'edit', '', '1', '0', '修改', '', '', '0', '', '0', '', '');
INSERT INTO `sd_admin_menu` VALUES ('59', '55', 'vote', 'category', 'delete', '', '1', '0', '删除', '', '', '0', '', '0', '', '');
INSERT INTO `sd_admin_menu` VALUES ('60', '56', 'vote', 'content', 'add', '', '1', '1', '添加投票', '', '', '1', '', '0', '', '');
INSERT INTO `sd_admin_menu` VALUES ('61', '56', 'vote', 'content', 'edit', '', '1', '0', '修改', '', '', '0', '', '0', '', '');
INSERT INTO `sd_admin_menu` VALUES ('62', '56', 'vote', 'content', 'delete', '', '1', '0', '删除', '', '', '0', '', '0', '', '');
INSERT INTO `sd_admin_menu` VALUES ('63', '55', 'vote', 'category', 'index', '', '1', '1', '分类列表', '', '', '0', '', '0', '', '');
INSERT INTO `sd_admin_menu` VALUES ('64', '56', 'vote', 'content', 'index', '', '1', '1', '投票列表', '', '', '0', '', '0', '', '');
INSERT INTO `sd_admin_menu` VALUES ('65', '16', 'mediamanage', 'upload', 'ajaxupload', '', '1', '0', '异步上传-webupload', '', '', '0', '', '0', '', '');
INSERT INTO `sd_admin_menu` VALUES ('66', '16', 'mediamanage', 'upload', 'dealfiles', '', '1', '0', '处理excel文件(导入数据)', '', '', '0', '', '0', '', '');
INSERT INTO `sd_admin_menu` VALUES ('67', '16', 'mediamanage', 'index', 'clearrepeat', '', '1', '0', '清理分类重复数据', '', '', '0', '', '0', '', '');
INSERT INTO `sd_admin_menu` VALUES ('68', '16', 'mediaManage', 'index', 'myindex', '', '1', '1', '我的列表', '', '', '1', '', '0', '', '');
INSERT INTO `sd_admin_menu` VALUES ('69', '16', 'mediamanage', 'index', 'editinfo', '', '1', '0', '修改单条数据', '', '', '0', '', '0', '', '');
INSERT INTO `sd_admin_menu` VALUES ('70', '16', 'mediamanage', 'index', 'deleteinfo', '', '1', '0', '删除单条数据', '', '', '0', '', '0', '', '');
INSERT INTO `sd_admin_menu` VALUES ('71', '15', 'mediaManage', 'analy', 'index', '', '1', '1', '数据分析', '', '', '0', '', '0', '', '');
INSERT INTO `sd_admin_menu` VALUES ('72', '71', 'mediaManage', 'analy', 'myproject', '', '1', '1', '我的项目', '', '', '0', '', '0', '', '');

-- ----------------------------
-- Table structure for `sd_admin_role`
-- ----------------------------
DROP TABLE IF EXISTS `sd_admin_role`;
CREATE TABLE `sd_admin_role` (
  `roleid` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `rolename` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `listorder` smallint(5) unsigned NOT NULL DEFAULT '0',
  `disabled` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`roleid`),
  KEY `listorder` (`listorder`) USING BTREE,
  KEY `disabled` (`disabled`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sd_admin_role
-- ----------------------------
INSERT INTO `sd_admin_role` VALUES ('1', '超级管理员', '超级管理员', '0', '0');
INSERT INTO `sd_admin_role` VALUES ('2', '站点管理员', '站点管理员', '0', '0');
INSERT INTO `sd_admin_role` VALUES ('3', '运营总监', '运营总监', '1', '0');
INSERT INTO `sd_admin_role` VALUES ('4', '总编', '总编', '5', '0');
INSERT INTO `sd_admin_role` VALUES ('5', '编辑', '编辑', '1', '0');
INSERT INTO `sd_admin_role` VALUES ('7', '发布人员', '发布人员', '0', '0');

-- ----------------------------
-- Table structure for `sd_admin_role_priv`
-- ----------------------------
DROP TABLE IF EXISTS `sd_admin_role_priv`;
CREATE TABLE `sd_admin_role_priv` (
  `roleid` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `m` char(20) NOT NULL,
  `c` char(20) NOT NULL,
  `a` char(20) NOT NULL,
  `data` char(30) NOT NULL DEFAULT '',
  `siteid` smallint(5) unsigned NOT NULL DEFAULT '0',
  KEY `roleid` (`roleid`,`m`,`c`,`a`,`siteid`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sd_admin_role_priv
-- ----------------------------
INSERT INTO `sd_admin_role_priv` VALUES ('5', 'admin', 'setting', 'init', '', '1');
INSERT INTO `sd_admin_role_priv` VALUES ('5', 'admin', 'admin', 'admin', '', '1');
INSERT INTO `sd_admin_role_priv` VALUES ('5', 'admin', '', '', '', '1');
INSERT INTO `sd_admin_role_priv` VALUES ('5', 'admin', 'admin_manage', 'init', '', '1');
INSERT INTO `sd_admin_role_priv` VALUES ('5', 'admin', 'admin_manage', 'add', '', '1');
INSERT INTO `sd_admin_role_priv` VALUES ('5', 'admin', 'admin_manage', 'edit', '', '1');
INSERT INTO `sd_admin_role_priv` VALUES ('5', 'admin', 'admin_manage', 'delete', '', '1');
INSERT INTO `sd_admin_role_priv` VALUES ('5', 'admin', 'admin_manage', 'card', '', '1');
INSERT INTO `sd_admin_role_priv` VALUES ('5', 'admin', 'admin_manage', 'creat_card', '', '1');
INSERT INTO `sd_admin_role_priv` VALUES ('5', 'admin', 'admin_manage', 'remove_card', '', '1');
INSERT INTO `sd_admin_role_priv` VALUES ('5', 'content', 'content', 'init', '', '1');
INSERT INTO `sd_admin_role_priv` VALUES ('5', 'content', 'content', 'init', '', '1');
INSERT INTO `sd_admin_role_priv` VALUES ('5', 'content', 'content', 'init', '', '1');
INSERT INTO `sd_admin_role_priv` VALUES ('5', 'content', 'content', 'add', '', '1');
INSERT INTO `sd_admin_role_priv` VALUES ('5', 'content', 'content', 'pass', '', '1');
INSERT INTO `sd_admin_role_priv` VALUES ('5', 'content', 'content', 'edit', '', '1');
INSERT INTO `sd_admin_role_priv` VALUES ('5', 'content', 'push', 'init', '', '1');
INSERT INTO `sd_admin_role_priv` VALUES ('5', 'content', 'content', 'remove', '', '1');
INSERT INTO `sd_admin_role_priv` VALUES ('5', 'content', 'content', 'add_othors', '', '1');
INSERT INTO `sd_admin_role_priv` VALUES ('5', 'content', 'content', 'delete', '', '1');
INSERT INTO `sd_admin_role_priv` VALUES ('5', 'content', 'create_html', 'batch_show', '', '1');
INSERT INTO `sd_admin_role_priv` VALUES ('5', 'content', 'content', 'listorder', '', '1');
INSERT INTO `sd_admin_role_priv` VALUES ('5', 'attachment', 'manage', 'init', '', '1');
INSERT INTO `sd_admin_role_priv` VALUES ('5', 'attachment', 'manage', 'dir', '', '1');
INSERT INTO `sd_admin_role_priv` VALUES ('5', 'attachment', 'manage', 'init', '', '1');
INSERT INTO `sd_admin_role_priv` VALUES ('5', 'attachment', 'address', 'init', '', '1');
INSERT INTO `sd_admin_role_priv` VALUES ('5', 'attachment', 'address', 'update', '', '1');
INSERT INTO `sd_admin_role_priv` VALUES ('5', 'special', 'special', 'init', '', '1');
INSERT INTO `sd_admin_role_priv` VALUES ('5', 'special', 'special', 'add', '', '1');
INSERT INTO `sd_admin_role_priv` VALUES ('5', 'special', 'special', 'edit', '', '1');
INSERT INTO `sd_admin_role_priv` VALUES ('5', 'special', 'special', 'init', '', '1');
INSERT INTO `sd_admin_role_priv` VALUES ('5', 'special', 'special', 'elite', '', '1');
INSERT INTO `sd_admin_role_priv` VALUES ('5', 'special', 'special', 'delete', '', '1');
INSERT INTO `sd_admin_role_priv` VALUES ('5', 'special', 'special', 'listorder', '', '1');
INSERT INTO `sd_admin_role_priv` VALUES ('5', 'special', 'content', 'init', '', '1');
INSERT INTO `sd_admin_role_priv` VALUES ('5', 'special', 'content', 'add', '', '1');
INSERT INTO `sd_admin_role_priv` VALUES ('5', 'special', 'content', 'init', '', '1');
INSERT INTO `sd_admin_role_priv` VALUES ('5', 'special', 'content', 'edit', '', '1');
INSERT INTO `sd_admin_role_priv` VALUES ('5', 'special', 'content', 'delete', '', '1');
INSERT INTO `sd_admin_role_priv` VALUES ('5', 'special', 'content', 'listorder', '', '1');
INSERT INTO `sd_admin_role_priv` VALUES ('5', 'special', 'special', 'import', '', '1');
INSERT INTO `sd_admin_role_priv` VALUES ('5', 'special', 'album', 'import', '', '1');
INSERT INTO `sd_admin_role_priv` VALUES ('5', 'special', 'special', 'html', '', '1');
INSERT INTO `sd_admin_role_priv` VALUES ('5', 'special', 'special', 'create_special_list', '', '1');
INSERT INTO `sd_admin_role_priv` VALUES ('5', 'block', 'block_admin', 'init', '', '1');
INSERT INTO `sd_admin_role_priv` VALUES ('5', 'block', 'block_admin', 'add', '', '1');
INSERT INTO `sd_admin_role_priv` VALUES ('5', 'block', 'block_admin', 'edit', '', '1');
INSERT INTO `sd_admin_role_priv` VALUES ('5', 'block', 'block_admin', 'del', '', '1');
INSERT INTO `sd_admin_role_priv` VALUES ('5', 'block', 'block_admin', 'block_update', '', '1');
INSERT INTO `sd_admin_role_priv` VALUES ('5', 'block', 'block_admin', 'history_restore', '', '1');
INSERT INTO `sd_admin_role_priv` VALUES ('5', 'block', 'block_admin', 'history_del', '', '1');
INSERT INTO `sd_admin_role_priv` VALUES ('5', 'collection', 'node', 'manage', '', '1');
INSERT INTO `sd_admin_role_priv` VALUES ('5', 'collection', 'node', 'add', '', '1');
INSERT INTO `sd_admin_role_priv` VALUES ('5', 'collection', 'node', 'edit', '', '1');
INSERT INTO `sd_admin_role_priv` VALUES ('5', 'collection', 'node', 'del', '', '1');
INSERT INTO `sd_admin_role_priv` VALUES ('5', 'collection', 'node', 'col_url_list', '', '1');
INSERT INTO `sd_admin_role_priv` VALUES ('5', 'collection', 'node', 'publist', '', '1');
INSERT INTO `sd_admin_role_priv` VALUES ('5', 'collection', 'node', 'node_import', '', '1');
INSERT INTO `sd_admin_role_priv` VALUES ('5', 'collection', 'node', 'export', '', '1');
INSERT INTO `sd_admin_role_priv` VALUES ('5', 'collection', 'node', 'col_content', '', '1');
INSERT INTO `sd_admin_role_priv` VALUES ('5', 'collection', 'node', 'import', '', '1');
INSERT INTO `sd_admin_role_priv` VALUES ('5', 'collection', 'node', 'copy', '', '1');
INSERT INTO `sd_admin_role_priv` VALUES ('5', 'collection', 'node', 'content_del', '', '1');
INSERT INTO `sd_admin_role_priv` VALUES ('5', 'collection', 'node', 'import_program_add', '', '1');
INSERT INTO `sd_admin_role_priv` VALUES ('5', 'collection', 'node', 'import_program_del', '', '1');
INSERT INTO `sd_admin_role_priv` VALUES ('5', 'collection', 'node', 'import_content', '', '1');
INSERT INTO `sd_admin_role_priv` VALUES ('5', 'comment', 'comment_admin', 'listinfo', '', '1');
INSERT INTO `sd_admin_role_priv` VALUES ('5', 'comment', 'check', 'checks', '', '1');
INSERT INTO `sd_admin_role_priv` VALUES ('5', 'release', 'html', 'init', '', '1');
INSERT INTO `sd_admin_role_priv` VALUES ('5', 'release', 'index', 'init', '', '1');
INSERT INTO `sd_admin_role_priv` VALUES ('5', 'release', 'index', 'failed', '', '1');
INSERT INTO `sd_admin_role_priv` VALUES ('5', 'release', 'index', 'del', '', '1');
INSERT INTO `sd_admin_role_priv` VALUES ('5', 'content', 'create_html', 'show', '', '1');
INSERT INTO `sd_admin_role_priv` VALUES ('5', 'content', 'create_html', 'update_urls', '', '1');
INSERT INTO `sd_admin_role_priv` VALUES ('5', 'content', 'create_html', 'category', '', '1');
INSERT INTO `sd_admin_role_priv` VALUES ('5', 'content', 'create_html', 'public_index', '', '1');
INSERT INTO `sd_admin_role_priv` VALUES ('5', 'content', 'content', 'clear_data', '', '1');
INSERT INTO `sd_admin_role_priv` VALUES ('5', 'content', 'content_settings', 'init', '', '1');
INSERT INTO `sd_admin_role_priv` VALUES ('5', 'admin', 'position', 'init', '', '1');
INSERT INTO `sd_admin_role_priv` VALUES ('5', 'admin', 'position', 'add', '', '1');
INSERT INTO `sd_admin_role_priv` VALUES ('5', 'admin', 'position', 'edit', '', '1');
INSERT INTO `sd_admin_role_priv` VALUES ('5', 'admin', 'category', 'init', 'module=admin', '1');
INSERT INTO `sd_admin_role_priv` VALUES ('5', 'admin', 'category', 'add', 's=0', '1');
INSERT INTO `sd_admin_role_priv` VALUES ('5', 'admin', 'category', 'edit', '', '1');
INSERT INTO `sd_admin_role_priv` VALUES ('5', 'admin', 'category', 'public_cache', 'module=admin', '1');
INSERT INTO `sd_admin_role_priv` VALUES ('5', 'admin', 'category', 'add', 's=1', '1');
INSERT INTO `sd_admin_role_priv` VALUES ('5', 'admin', 'category', 'add', 's=2', '1');
INSERT INTO `sd_admin_role_priv` VALUES ('5', 'admin', 'category', 'count_items', '', '1');
INSERT INTO `sd_admin_role_priv` VALUES ('5', 'admin', 'category', 'batch_edit', '', '1');
INSERT INTO `sd_admin_role_priv` VALUES ('5', 'content', 'sitemodel', 'init', '', '1');
INSERT INTO `sd_admin_role_priv` VALUES ('5', 'content', 'sitemodel', 'add', '', '1');
INSERT INTO `sd_admin_role_priv` VALUES ('5', 'content', 'sitemodel', 'import', '', '1');
INSERT INTO `sd_admin_role_priv` VALUES ('5', 'content', 'sitemodel_field', 'init', '', '1');
INSERT INTO `sd_admin_role_priv` VALUES ('5', 'content', 'sitemodel', 'edit', '', '1');
INSERT INTO `sd_admin_role_priv` VALUES ('5', 'content', 'sitemodel', 'disabled', '', '1');
INSERT INTO `sd_admin_role_priv` VALUES ('5', 'content', 'sitemodel', 'delete', '', '1');
INSERT INTO `sd_admin_role_priv` VALUES ('5', 'content', 'sitemodel', 'export', '', '1');
INSERT INTO `sd_admin_role_priv` VALUES ('5', 'content', 'type_manage', 'init', '', '1');
INSERT INTO `sd_admin_role_priv` VALUES ('5', 'content', 'type_manage', 'add', '', '1');
INSERT INTO `sd_admin_role_priv` VALUES ('5', 'content', 'type_manage', 'delete', '', '1');
INSERT INTO `sd_admin_role_priv` VALUES ('5', 'content', 'type_manage', 'edit', '', '1');
INSERT INTO `sd_admin_role_priv` VALUES ('5', 'admin', 'index', 'public_main', '', '1');
INSERT INTO `sd_admin_role_priv` VALUES ('5', 'admin', 'admin_manage', 'init', '', '1');
INSERT INTO `sd_admin_role_priv` VALUES ('5', 'admin', 'admin_manage', 'public_edit_pwd', '', '1');
INSERT INTO `sd_admin_role_priv` VALUES ('5', 'admin', 'admin_manage', 'public_edit_info', '', '1');
INSERT INTO `sd_admin_role_priv` VALUES ('5', 'content', 'create_html_opt', 'index', '', '1');
INSERT INTO `sd_admin_role_priv` VALUES ('5', 'content', 'create_html', 'public_index', '', '1');

-- ----------------------------
-- Table structure for `sd_category`
-- ----------------------------
DROP TABLE IF EXISTS `sd_category`;
CREATE TABLE `sd_category` (
  `catid` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `siteid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `module` varchar(15) NOT NULL,
  `type` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `modelid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `parentid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `arrparentid` varchar(255) DEFAULT NULL,
  `child` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `arrchildid` mediumtext,
  `catname` varchar(30) NOT NULL,
  `style` varchar(5) DEFAULT NULL,
  `image` varchar(100) NOT NULL,
  `description` mediumtext NOT NULL,
  `parentdir` varchar(100) DEFAULT NULL,
  `catdir` varchar(30) NOT NULL,
  `url` varchar(100) NOT NULL,
  `items` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `hits` int(10) unsigned NOT NULL DEFAULT '0',
  `setting` mediumtext NOT NULL,
  `listorder` smallint(5) unsigned NOT NULL DEFAULT '0',
  `ismenu` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `sethtml` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `letter` varchar(30) NOT NULL,
  `usable_type` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`catid`),
  KEY `module` (`module`,`parentid`,`listorder`,`catid`) USING BTREE,
  KEY `siteid` (`siteid`,`type`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sd_category
-- ----------------------------
INSERT INTO `sd_category` VALUES ('1', '1', 'content', '0', '1', '0', '0', '0', '1', '头条', '', '', '', '', 'exclusive', 'http://www.shz100.com/exclusive/', '632', '0', '{\"workflowid\":\"1\",\"ishtml\":\"0\",\"content_ishtml\":\"0\",\"create_to_html_root\":\"0\",\"template_list\":\"shz100\",\"category_template\":\"category\",\"list_template\":\"list\",\"show_template\":\"show\",\"meta_title\":\"\",\"meta_keywords\":\"\",\"meta_description\":\"\",\"presentpoint\":\"1\",\"defaultchargepoint\":\"0\",\"paytype\":\"0\",\"repeatchargedays\":\"1\",\"category_ruleid\":\"30\",\"show_ruleid\":\"32\"}', '1', '1', '0', 'toutiao', '');
INSERT INTO `sd_category` VALUES ('2', '1', 'content', '0', '1', '0', '0', '0', '2', '揭秘', '', '', '', '', 'demystify', 'http://www.shz100.com/demystify/', '379', '0', '{\"workflowid\":\"1\",\"ishtml\":\"0\",\"content_ishtml\":\"0\",\"create_to_html_root\":\"0\",\"template_list\":\"shz100\",\"category_template\":\"category\",\"list_template\":\"list\",\"show_template\":\"show\",\"meta_title\":\"\",\"meta_keywords\":\"\",\"meta_description\":\"\",\"presentpoint\":\"1\",\"defaultchargepoint\":\"0\",\"paytype\":\"0\",\"repeatchargedays\":\"1\",\"category_ruleid\":\"30\",\"show_ruleid\":\"32\"}', '2', '0', '0', 'jiemi', '');
INSERT INTO `sd_category` VALUES ('3', '1', 'content', '0', '1', '0', '0', '1', '3,6,7,8,9', '天下', '', '', '', '', 'characters', 'http://www.shz100.com/characters/', '0', '0', '{\"workflowid\":\"1\",\"ishtml\":\"0\",\"content_ishtml\":\"0\",\"create_to_html_root\":\"0\",\"template_list\":\"shz100\",\"category_template\":\"category\",\"list_template\":\"list\",\"show_template\":\"show\",\"meta_title\":\"\",\"meta_keywords\":\"\",\"meta_description\":\"\",\"presentpoint\":\"1\",\"defaultchargepoint\":\"0\",\"paytype\":\"0\",\"repeatchargedays\":\"1\",\"category_ruleid\":\"30\",\"show_ruleid\":\"32\"}', '3', '1', '0', 'tianxia', '');
INSERT INTO `sd_category` VALUES ('4', '1', 'content', '0', '1', '0', '0', '0', '4', '老照片', '', '', '', '', 'OldPhotos', 'http://www.shz100.com/OldPhotos/', '1807', '0', '{\"workflowid\":\"1\",\"ishtml\":\"0\",\"content_ishtml\":\"0\",\"create_to_html_root\":\"0\",\"template_list\":\"shz100\",\"category_template\":\"category\",\"list_template\":\"list_img\",\"show_template\":\"show_img\",\"meta_title\":\"\",\"meta_keywords\":\"\",\"meta_description\":\"\",\"presentpoint\":\"1\",\"defaultchargepoint\":\"0\",\"paytype\":\"0\",\"repeatchargedays\":\"1\",\"category_ruleid\":\"30\",\"show_ruleid\":\"32\"}', '4', '1', '0', 'laozhaopian', '');
INSERT INTO `sd_category` VALUES ('5', '1', 'content', '0', '1', '0', '0', '0', '5', '口述史', '', '', '', '', 'OralHistory', 'http://www.shz100.com/OralHistory/', '1189', '0', '{\"workflowid\":\"1\",\"ishtml\":\"0\",\"content_ishtml\":\"0\",\"create_to_html_root\":\"0\",\"template_list\":\"shz100\",\"category_template\":\"category\",\"list_template\":\"list\",\"show_template\":\"show\",\"meta_title\":\"\",\"meta_keywords\":\"\",\"meta_description\":\"\",\"presentpoint\":\"1\",\"defaultchargepoint\":\"0\",\"paytype\":\"0\",\"repeatchargedays\":\"1\",\"category_ruleid\":\"30\",\"show_ruleid\":\"32\"}', '5', '1', '0', 'koushushi', '');
INSERT INTO `sd_category` VALUES ('6', '1', 'content', '0', '1', '3', '0,3', '0', '6', '政治', '', '', '', 'characters/', 'politics', 'http://www.shz100.com/characters/politics/', '3833', '0', '{\"workflowid\":\"1\",\"ishtml\":\"0\",\"content_ishtml\":\"0\",\"create_to_html_root\":\"0\",\"template_list\":\"shz100\",\"category_template\":\"category\",\"list_template\":\"list\",\"show_template\":\"show\",\"meta_title\":\"\",\"meta_keywords\":\"\",\"meta_description\":\"\",\"presentpoint\":\"1\",\"defaultchargepoint\":\"0\",\"paytype\":\"0\",\"repeatchargedays\":\"1\",\"category_ruleid\":\"30\",\"show_ruleid\":\"32\"}', '6', '1', '0', 'zhengzhi', '');
INSERT INTO `sd_category` VALUES ('7', '1', 'content', '0', '1', '3', '0,3', '0', '7', '军事', '', '', '', 'characters/', 'military', 'http://www.shz100.com/characters/military/', '696', '0', '{\"workflowid\":\"1\",\"ishtml\":\"0\",\"content_ishtml\":\"0\",\"create_to_html_root\":\"0\",\"template_list\":\"shz100\",\"category_template\":\"category\",\"list_template\":\"list\",\"show_template\":\"show\",\"meta_title\":\"\",\"meta_keywords\":\"\",\"meta_description\":\"\",\"presentpoint\":\"1\",\"defaultchargepoint\":\"0\",\"paytype\":\"0\",\"repeatchargedays\":\"1\",\"category_ruleid\":\"30\",\"show_ruleid\":\"32\"}', '7', '0', '0', 'junshi', '');
INSERT INTO `sd_category` VALUES ('8', '1', 'content', '0', '1', '3', '0,3', '0', '8', '社会', '', '', '', 'characters/', 'diplomacy', 'http://www.shz100.com/characters/diplomacy/', '1000', '0', '{\"workflowid\":\"1\",\"ishtml\":\"0\",\"content_ishtml\":\"0\",\"create_to_html_root\":\"0\",\"template_list\":\"shz100\",\"category_template\":\"category\",\"list_template\":\"list\",\"show_template\":\"show\",\"meta_title\":\"\",\"meta_keywords\":\"\",\"meta_description\":\"\",\"presentpoint\":\"1\",\"defaultchargepoint\":\"0\",\"paytype\":\"0\",\"repeatchargedays\":\"1\",\"category_ruleid\":\"30\",\"show_ruleid\":\"32\"}', '8', '0', '0', 'shehui', '');
INSERT INTO `sd_category` VALUES ('9', '1', 'content', '0', '1', '3', '0,3', '0', '9', '文化', '', '', '', 'characters/', 'culture', 'http://www.shz100.com/characters/culture/', '2446', '0', '{\"workflowid\":\"1\",\"ishtml\":\"0\",\"content_ishtml\":\"0\",\"create_to_html_root\":\"0\",\"template_list\":\"shz100\",\"category_template\":\"category\",\"list_template\":\"list\",\"show_template\":\"show\",\"meta_title\":\"\",\"meta_keywords\":\"\",\"meta_description\":\"\",\"presentpoint\":\"1\",\"defaultchargepoint\":\"0\",\"paytype\":\"0\",\"repeatchargedays\":\"1\",\"category_ruleid\":\"30\",\"show_ruleid\":\"32\"}', '9', '0', '0', 'wenhua', '');
INSERT INTO `sd_category` VALUES ('10', '1', 'content', '0', '1', '0', '0', '0', '10', '自由谈', '', '', '', '', 'FromReaders', 'http://www.shz100.com/FromReaders/', '2765', '0', '{\"workflowid\":\"1\",\"ishtml\":\"0\",\"content_ishtml\":\"0\",\"create_to_html_root\":\"0\",\"template_list\":\"shz100\",\"category_template\":\"category\",\"list_template\":\"list\",\"show_template\":\"show\",\"meta_title\":\"\",\"meta_keywords\":\"\",\"meta_description\":\"\",\"presentpoint\":\"1\",\"defaultchargepoint\":\"0\",\"paytype\":\"0\",\"repeatchargedays\":\"1\",\"category_ruleid\":\"30\",\"show_ruleid\":\"32\"}', '10', '1', '0', 'ziyoutan', '');
INSERT INTO `sd_category` VALUES ('11', '1', 'content', '0', '1', '0', '0', '1', '11,14,15,16,17,22', '名家', '', '', '', '', 'mingjia', 'http://www.shz100.com/mingjia/', '0', '0', '{\"workflowid\":\"1\",\"ishtml\":\"0\",\"content_ishtml\":\"0\",\"create_to_html_root\":\"0\",\"template_list\":\"shz100\",\"category_template\":\"category\",\"list_template\":\"list\",\"show_template\":\"show\",\"meta_title\":\"\",\"meta_keywords\":\"\",\"meta_description\":\"\",\"presentpoint\":\"1\",\"defaultchargepoint\":\"0\",\"paytype\":\"0\",\"repeatchargedays\":\"1\",\"category_ruleid\":\"30\",\"show_ruleid\":\"32\"}', '11', '1', '0', 'mingjia', '');
INSERT INTO `sd_category` VALUES ('12', '1', 'content', '0', '1', '0', '0', '0', '12', '关于我们', '', '', '', '', 'about', 'http://www.shz100.com/about/', '7', '0', '{\"workflowid\":\"\",\"ishtml\":\"0\",\"content_ishtml\":\"0\",\"create_to_html_root\":\"0\",\"template_list\":\"shz100\",\"category_template\":\"category\",\"list_template\":\"list\",\"show_template\":\"show\",\"meta_title\":\"\",\"meta_keywords\":\"\",\"meta_description\":\"\",\"presentpoint\":\"1\",\"defaultchargepoint\":\"0\",\"paytype\":\"0\",\"repeatchargedays\":\"1\",\"category_ruleid\":\"30\",\"show_ruleid\":\"16\"}', '12', '0', '0', 'guanyuwomen', '');
INSERT INTO `sd_category` VALUES ('13', '1', 'content', '0', '1', '0', '0', '0', '13', '乡土', '', '', '', '', 'historytoday', 'http://www.shz100.com/historytoday/', '1036', '0', '{\"workflowid\":\"1\",\"ishtml\":\"0\",\"content_ishtml\":\"0\",\"create_to_html_root\":\"0\",\"template_list\":\"shz100\",\"category_template\":\"category\",\"list_template\":\"list\",\"show_template\":\"show\",\"meta_title\":\"\",\"meta_keywords\":\"\",\"meta_description\":\"\",\"presentpoint\":\"1\",\"defaultchargepoint\":\"0\",\"paytype\":\"0\",\"repeatchargedays\":\"1\",\"category_ruleid\":\"30\",\"show_ruleid\":\"32\"}', '13', '1', '0', 'xiangtu', '');
INSERT INTO `sd_category` VALUES ('14', '1', 'content', '0', '1', '11', '0,11', '0', '14', '雷颐', '', '', '', 'mingjia/', 'leiyi', 'http://www.shz100.com/mingjia/leiyi/', '29', '0', '{\"workflowid\":\"1\",\"ishtml\":\"0\",\"content_ishtml\":\"0\",\"create_to_html_root\":\"0\",\"template_list\":\"shz100\",\"category_template\":\"category\",\"list_template\":\"list\",\"show_template\":\"show\",\"meta_title\":\"\",\"meta_keywords\":\"\",\"meta_description\":\"\",\"presentpoint\":\"1\",\"defaultchargepoint\":\"0\",\"paytype\":\"0\",\"repeatchargedays\":\"1\",\"category_ruleid\":\"30\",\"show_ruleid\":\"32\"}', '14', '0', '0', 'leiyi', '');
INSERT INTO `sd_category` VALUES ('15', '1', 'content', '0', '1', '11', '0,11', '0', '15', '沈志华', '', '', '', 'mingjia/', 'shenzhihua', 'http://www.shz100.com/mingjia/shenzhihua/', '35', '0', '{\"workflowid\":\"1\",\"ishtml\":\"0\",\"content_ishtml\":\"0\",\"create_to_html_root\":\"0\",\"template_list\":\"shz100\",\"category_template\":\"category\",\"list_template\":\"list\",\"show_template\":\"show\",\"meta_title\":\"\",\"meta_keywords\":\"\",\"meta_description\":\"\",\"presentpoint\":\"1\",\"defaultchargepoint\":\"0\",\"paytype\":\"0\",\"repeatchargedays\":\"1\",\"category_ruleid\":\"30\",\"show_ruleid\":\"32\"}', '15', '0', '0', 'shenzhihua', '');
INSERT INTO `sd_category` VALUES ('16', '1', 'content', '0', '1', '11', '0,11', '0', '16', '马勇', '', '', '', 'mingjia/', 'mayong', 'http://www.shz100.com/mingjia/mayong/', '43', '0', '{\"workflowid\":\"1\",\"ishtml\":\"0\",\"content_ishtml\":\"0\",\"create_to_html_root\":\"0\",\"template_list\":\"shz100\",\"category_template\":\"category\",\"list_template\":\"list\",\"show_template\":\"show\",\"meta_title\":\"\",\"meta_keywords\":\"\",\"meta_description\":\"\",\"presentpoint\":\"1\",\"defaultchargepoint\":\"0\",\"paytype\":\"0\",\"repeatchargedays\":\"1\",\"category_ruleid\":\"30\",\"show_ruleid\":\"32\"}', '16', '0', '0', 'mayong', '');
INSERT INTO `sd_category` VALUES ('17', '1', 'content', '0', '1', '11', '0,11', '0', '17', '张鸣', '', '', '', 'mingjia/', 'zhangming', 'http://www.shz100.com/mingjia/zhangming/', '42', '0', '{\"workflowid\":\"1\",\"ishtml\":\"0\",\"content_ishtml\":\"0\",\"create_to_html_root\":\"0\",\"template_list\":\"shz100\",\"category_template\":\"category\",\"list_template\":\"list\",\"show_template\":\"show\",\"meta_title\":\"\",\"meta_keywords\":\"\",\"meta_description\":\"\",\"presentpoint\":\"1\",\"defaultchargepoint\":\"0\",\"paytype\":\"0\",\"repeatchargedays\":\"1\",\"category_ruleid\":\"30\",\"show_ruleid\":\"32\"}', '17', '0', '0', 'zhangming', '');
INSERT INTO `sd_category` VALUES ('18', '1', 'content', '0', '1', '0', '0', '0', '18', '专题', '', '', '', '', 'spec', '', '5', '0', '{\"workflowid\":\"1\",\"ishtml\":\"0\",\"content_ishtml\":\"0\",\"create_to_html_root\":\"0\",\"template_list\":\"shz100\",\"category_template\":\"category\",\"list_template\":\"list\",\"show_template\":\"show\",\"meta_title\":\"\",\"meta_keywords\":\"\",\"meta_description\":\"\",\"presentpoint\":\"1\",\"defaultchargepoint\":\"0\",\"paytype\":\"0\",\"repeatchargedays\":\"1\",\"category_ruleid\":\"30\",\"show_ruleid\":\"32\"}', '18', '0', '0', '', '');
INSERT INTO `sd_category` VALUES ('19', '1', 'content', '0', '1', '0', '0', '0', '19', '养生', '', '', '', '', 'Yangsheng', 'http://www.shz100.com/Yangsheng/', '261', '0', '{\"workflowid\":\"1\",\"ishtml\":\"0\",\"content_ishtml\":\"0\",\"create_to_html_root\":\"0\",\"template_list\":\"shz100\",\"category_template\":\"category\",\"list_template\":\"list\",\"show_template\":\"show\",\"meta_title\":\"\",\"meta_keywords\":\"\",\"meta_description\":\"\",\"presentpoint\":\"1\",\"defaultchargepoint\":\"0\",\"paytype\":\"0\",\"repeatchargedays\":\"1\",\"category_ruleid\":\"30\",\"show_ruleid\":\"32\"}', '19', '1', '0', 'yangsheng', '');
INSERT INTO `sd_category` VALUES ('20', '1', 'content', '0', '1', '0', '0', '0', '20', '徐霞客', '', '', '', '', 'xuxiake', 'http://www.shz100.com/xuxiake/', '147', '0', '{\"workflowid\":\"1\",\"ishtml\":\"0\",\"content_ishtml\":\"0\",\"create_to_html_root\":\"0\",\"template_list\":\"shz100\",\"category_template\":\"category\",\"list_template\":\"list\",\"show_template\":\"show\",\"meta_title\":\"\",\"meta_keywords\":\"\",\"meta_description\":\"\",\"presentpoint\":\"1\",\"defaultchargepoint\":\"0\",\"paytype\":\"0\",\"repeatchargedays\":\"1\",\"category_ruleid\":\"30\",\"show_ruleid\":\"32\"}', '20', '1', '0', 'xuxiake', '');
INSERT INTO `sd_category` VALUES ('21', '1', 'content', '0', '1', '0', '0', '0', '21', '众筹', '', '', '', '', 'zhongchou', 'http://www.shz100.com/zhongchou/', '1', '0', '{\"workflowid\":\"\",\"ishtml\":\"0\",\"content_ishtml\":\"0\",\"create_to_html_root\":\"0\",\"template_list\":\"shz100\",\"category_template\":\"category\",\"list_template\":\"list\",\"show_template\":\"show\",\"meta_title\":\"\",\"meta_keywords\":\"\",\"meta_description\":\"\",\"presentpoint\":\"1\",\"defaultchargepoint\":\"0\",\"paytype\":\"0\",\"repeatchargedays\":\"1\",\"category_ruleid\":\"30\",\"show_ruleid\":\"16\"}', '21', '0', '0', 'zhongchou', '');
INSERT INTO `sd_category` VALUES ('22', '1', 'content', '0', '1', '11', '0,11', '0', '22', '其他', null, '', '', 'mingjia/', 'other', 'http://www.shz100.com/mingjia/other/', '1785', '0', '{\"workflowid\":\"1\",\"ishtml\":\"0\",\"content_ishtml\":\"0\",\"create_to_html_root\":\"0\",\"template_list\":\"shz100\",\"category_template\":\"category\",\"list_template\":\"list\",\"show_template\":\"show\",\"meta_title\":\"\",\"meta_keywords\":\"\",\"meta_description\":\"\",\"presentpoint\":\"1\",\"defaultchargepoint\":\"0\",\"paytype\":\"0\",\"repeatchargedays\":\"1\",\"category_ruleid\":\"30\",\"show_ruleid\":\"32\"}', '22', '1', '0', 'qita', null);

-- ----------------------------
-- Table structure for `sd_category_priv`
-- ----------------------------
DROP TABLE IF EXISTS `sd_category_priv`;
CREATE TABLE `sd_category_priv` (
  `catid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `siteid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `roleid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `is_admin` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `action` char(30) NOT NULL,
  KEY `catid` (`catid`,`roleid`,`is_admin`,`action`) USING BTREE,
  KEY `siteid` (`siteid`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sd_category_priv
-- ----------------------------
INSERT INTO `sd_category_priv` VALUES ('1', '1', '4', '1', 'listorder');
INSERT INTO `sd_category_priv` VALUES ('21', '1', '4', '1', 'remove');
INSERT INTO `sd_category_priv` VALUES ('1', '1', '4', '1', 'add');
INSERT INTO `sd_category_priv` VALUES ('1', '1', '4', '1', 'init');
INSERT INTO `sd_category_priv` VALUES ('1', '1', '4', '1', 'delete');
INSERT INTO `sd_category_priv` VALUES ('1', '1', '4', '1', 'push');
INSERT INTO `sd_category_priv` VALUES ('1', '1', '4', '1', 'edit');
INSERT INTO `sd_category_priv` VALUES ('2', '1', '4', '1', 'listorder');
INSERT INTO `sd_category_priv` VALUES ('21', '1', '4', '1', 'push');
INSERT INTO `sd_category_priv` VALUES ('2', '1', '4', '1', 'add');
INSERT INTO `sd_category_priv` VALUES ('2', '1', '4', '1', 'init');
INSERT INTO `sd_category_priv` VALUES ('2', '1', '4', '1', 'delete');
INSERT INTO `sd_category_priv` VALUES ('2', '1', '4', '1', 'push');
INSERT INTO `sd_category_priv` VALUES ('2', '1', '4', '1', 'edit');
INSERT INTO `sd_category_priv` VALUES ('3', '1', '4', '1', 'listorder');
INSERT INTO `sd_category_priv` VALUES ('21', '1', '4', '1', 'listorder');
INSERT INTO `sd_category_priv` VALUES ('3', '1', '4', '1', 'add');
INSERT INTO `sd_category_priv` VALUES ('3', '1', '4', '1', 'init');
INSERT INTO `sd_category_priv` VALUES ('3', '1', '4', '1', 'delete');
INSERT INTO `sd_category_priv` VALUES ('3', '1', '4', '1', 'push');
INSERT INTO `sd_category_priv` VALUES ('3', '1', '4', '1', 'edit');
INSERT INTO `sd_category_priv` VALUES ('6', '1', '4', '1', 'listorder');
INSERT INTO `sd_category_priv` VALUES ('21', '1', '4', '1', 'delete');
INSERT INTO `sd_category_priv` VALUES ('6', '1', '4', '1', 'add');
INSERT INTO `sd_category_priv` VALUES ('6', '1', '4', '1', 'init');
INSERT INTO `sd_category_priv` VALUES ('6', '1', '4', '1', 'delete');
INSERT INTO `sd_category_priv` VALUES ('6', '1', '4', '1', 'push');
INSERT INTO `sd_category_priv` VALUES ('6', '1', '4', '1', 'edit');
INSERT INTO `sd_category_priv` VALUES ('7', '1', '4', '1', 'listorder');
INSERT INTO `sd_category_priv` VALUES ('21', '1', '4', '1', 'edit');
INSERT INTO `sd_category_priv` VALUES ('7', '1', '4', '1', 'add');
INSERT INTO `sd_category_priv` VALUES ('7', '1', '4', '1', 'init');
INSERT INTO `sd_category_priv` VALUES ('7', '1', '4', '1', 'delete');
INSERT INTO `sd_category_priv` VALUES ('7', '1', '4', '1', 'push');
INSERT INTO `sd_category_priv` VALUES ('7', '1', '4', '1', 'edit');
INSERT INTO `sd_category_priv` VALUES ('8', '1', '4', '1', 'listorder');
INSERT INTO `sd_category_priv` VALUES ('21', '1', '4', '1', 'add');
INSERT INTO `sd_category_priv` VALUES ('8', '1', '4', '1', 'add');
INSERT INTO `sd_category_priv` VALUES ('8', '1', '4', '1', 'init');
INSERT INTO `sd_category_priv` VALUES ('8', '1', '4', '1', 'delete');
INSERT INTO `sd_category_priv` VALUES ('8', '1', '4', '1', 'push');
INSERT INTO `sd_category_priv` VALUES ('8', '1', '4', '1', 'edit');
INSERT INTO `sd_category_priv` VALUES ('9', '1', '4', '1', 'add');
INSERT INTO `sd_category_priv` VALUES ('22', '1', '4', '1', 'push');
INSERT INTO `sd_category_priv` VALUES ('9', '1', '4', '1', 'push');
INSERT INTO `sd_category_priv` VALUES ('9', '1', '4', '1', 'edit');
INSERT INTO `sd_category_priv` VALUES ('9', '1', '4', '1', 'listorder');
INSERT INTO `sd_category_priv` VALUES ('9', '1', '4', '1', 'init');
INSERT INTO `sd_category_priv` VALUES ('9', '1', '4', '1', 'delete');
INSERT INTO `sd_category_priv` VALUES ('4', '1', '4', '1', 'listorder');
INSERT INTO `sd_category_priv` VALUES ('21', '1', '4', '1', 'init');
INSERT INTO `sd_category_priv` VALUES ('4', '1', '4', '1', 'add');
INSERT INTO `sd_category_priv` VALUES ('4', '1', '4', '1', 'init');
INSERT INTO `sd_category_priv` VALUES ('4', '1', '4', '1', 'delete');
INSERT INTO `sd_category_priv` VALUES ('4', '1', '4', '1', 'push');
INSERT INTO `sd_category_priv` VALUES ('4', '1', '4', '1', 'edit');
INSERT INTO `sd_category_priv` VALUES ('5', '1', '4', '1', 'listorder');
INSERT INTO `sd_category_priv` VALUES ('20', '1', '5', '1', 'init');
INSERT INTO `sd_category_priv` VALUES ('5', '1', '4', '1', 'add');
INSERT INTO `sd_category_priv` VALUES ('5', '1', '4', '1', 'init');
INSERT INTO `sd_category_priv` VALUES ('5', '1', '4', '1', 'delete');
INSERT INTO `sd_category_priv` VALUES ('5', '1', '4', '1', 'push');
INSERT INTO `sd_category_priv` VALUES ('5', '1', '4', '1', 'edit');
INSERT INTO `sd_category_priv` VALUES ('10', '1', '4', '1', 'listorder');
INSERT INTO `sd_category_priv` VALUES ('20', '1', '5', '1', 'add');
INSERT INTO `sd_category_priv` VALUES ('10', '1', '4', '1', 'add');
INSERT INTO `sd_category_priv` VALUES ('10', '1', '4', '1', 'init');
INSERT INTO `sd_category_priv` VALUES ('10', '1', '4', '1', 'delete');
INSERT INTO `sd_category_priv` VALUES ('10', '1', '4', '1', 'push');
INSERT INTO `sd_category_priv` VALUES ('10', '1', '4', '1', 'edit');
INSERT INTO `sd_category_priv` VALUES ('11', '1', '4', '1', 'listorder');
INSERT INTO `sd_category_priv` VALUES ('20', '1', '5', '1', 'edit');
INSERT INTO `sd_category_priv` VALUES ('11', '1', '4', '1', 'add');
INSERT INTO `sd_category_priv` VALUES ('11', '1', '4', '1', 'init');
INSERT INTO `sd_category_priv` VALUES ('11', '1', '4', '1', 'delete');
INSERT INTO `sd_category_priv` VALUES ('11', '1', '4', '1', 'push');
INSERT INTO `sd_category_priv` VALUES ('11', '1', '4', '1', 'edit');
INSERT INTO `sd_category_priv` VALUES ('14', '1', '4', '1', 'listorder');
INSERT INTO `sd_category_priv` VALUES ('20', '1', '5', '1', 'push');
INSERT INTO `sd_category_priv` VALUES ('14', '1', '4', '1', 'add');
INSERT INTO `sd_category_priv` VALUES ('14', '1', '4', '1', 'init');
INSERT INTO `sd_category_priv` VALUES ('14', '1', '4', '1', 'delete');
INSERT INTO `sd_category_priv` VALUES ('14', '1', '4', '1', 'push');
INSERT INTO `sd_category_priv` VALUES ('14', '1', '4', '1', 'edit');
INSERT INTO `sd_category_priv` VALUES ('15', '1', '4', '1', 'listorder');
INSERT INTO `sd_category_priv` VALUES ('20', '1', '5', '1', 'listorder');
INSERT INTO `sd_category_priv` VALUES ('15', '1', '4', '1', 'add');
INSERT INTO `sd_category_priv` VALUES ('15', '1', '4', '1', 'init');
INSERT INTO `sd_category_priv` VALUES ('15', '1', '4', '1', 'delete');
INSERT INTO `sd_category_priv` VALUES ('15', '1', '4', '1', 'push');
INSERT INTO `sd_category_priv` VALUES ('15', '1', '4', '1', 'edit');
INSERT INTO `sd_category_priv` VALUES ('16', '1', '4', '1', 'listorder');
INSERT INTO `sd_category_priv` VALUES ('16', '1', '4', '1', 'add');
INSERT INTO `sd_category_priv` VALUES ('16', '1', '4', '1', 'init');
INSERT INTO `sd_category_priv` VALUES ('16', '1', '4', '1', 'delete');
INSERT INTO `sd_category_priv` VALUES ('16', '1', '4', '1', 'push');
INSERT INTO `sd_category_priv` VALUES ('16', '1', '4', '1', 'edit');
INSERT INTO `sd_category_priv` VALUES ('17', '1', '4', '1', 'listorder');
INSERT INTO `sd_category_priv` VALUES ('20', '1', '5', '1', 'delete');
INSERT INTO `sd_category_priv` VALUES ('17', '1', '4', '1', 'add');
INSERT INTO `sd_category_priv` VALUES ('17', '1', '4', '1', 'init');
INSERT INTO `sd_category_priv` VALUES ('17', '1', '4', '1', 'delete');
INSERT INTO `sd_category_priv` VALUES ('17', '1', '4', '1', 'push');
INSERT INTO `sd_category_priv` VALUES ('17', '1', '4', '1', 'edit');
INSERT INTO `sd_category_priv` VALUES ('13', '1', '4', '1', 'listorder');
INSERT INTO `sd_category_priv` VALUES ('19', '1', '5', '1', 'init');
INSERT INTO `sd_category_priv` VALUES ('13', '1', '4', '1', 'add');
INSERT INTO `sd_category_priv` VALUES ('13', '1', '4', '1', 'init');
INSERT INTO `sd_category_priv` VALUES ('13', '1', '4', '1', 'delete');
INSERT INTO `sd_category_priv` VALUES ('13', '1', '4', '1', 'push');
INSERT INTO `sd_category_priv` VALUES ('13', '1', '4', '1', 'edit');
INSERT INTO `sd_category_priv` VALUES ('18', '1', '4', '1', 'listorder');
INSERT INTO `sd_category_priv` VALUES ('19', '1', '5', '1', 'add');
INSERT INTO `sd_category_priv` VALUES ('18', '1', '4', '1', 'add');
INSERT INTO `sd_category_priv` VALUES ('18', '1', '4', '1', 'init');
INSERT INTO `sd_category_priv` VALUES ('18', '1', '4', '1', 'delete');
INSERT INTO `sd_category_priv` VALUES ('18', '1', '4', '1', 'push');
INSERT INTO `sd_category_priv` VALUES ('18', '1', '4', '1', 'edit');
INSERT INTO `sd_category_priv` VALUES ('19', '1', '4', '1', 'listorder');
INSERT INTO `sd_category_priv` VALUES ('19', '1', '5', '1', 'edit');
INSERT INTO `sd_category_priv` VALUES ('19', '1', '4', '1', 'add');
INSERT INTO `sd_category_priv` VALUES ('19', '1', '4', '1', 'init');
INSERT INTO `sd_category_priv` VALUES ('19', '1', '4', '1', 'delete');
INSERT INTO `sd_category_priv` VALUES ('19', '1', '4', '1', 'push');
INSERT INTO `sd_category_priv` VALUES ('19', '1', '4', '1', 'edit');
INSERT INTO `sd_category_priv` VALUES ('20', '1', '4', '1', 'listorder');
INSERT INTO `sd_category_priv` VALUES ('19', '1', '5', '1', 'push');
INSERT INTO `sd_category_priv` VALUES ('20', '1', '4', '1', 'add');
INSERT INTO `sd_category_priv` VALUES ('20', '1', '4', '1', 'init');
INSERT INTO `sd_category_priv` VALUES ('20', '1', '4', '1', 'delete');
INSERT INTO `sd_category_priv` VALUES ('20', '1', '4', '1', 'push');
INSERT INTO `sd_category_priv` VALUES ('20', '1', '4', '1', 'edit');
INSERT INTO `sd_category_priv` VALUES ('22', '1', '4', '1', 'add');
INSERT INTO `sd_category_priv` VALUES ('22', '1', '4', '1', 'edit');
INSERT INTO `sd_category_priv` VALUES ('22', '1', '4', '1', 'init');
INSERT INTO `sd_category_priv` VALUES ('22', '1', '4', '1', 'listorder');
INSERT INTO `sd_category_priv` VALUES ('22', '1', '4', '1', 'delete');
INSERT INTO `sd_category_priv` VALUES ('22', '1', '5', '1', 'init');
INSERT INTO `sd_category_priv` VALUES ('19', '1', '5', '1', 'listorder');
INSERT INTO `sd_category_priv` VALUES ('19', '1', '5', '1', 'delete');
INSERT INTO `sd_category_priv` VALUES ('18', '1', '5', '1', 'init');
INSERT INTO `sd_category_priv` VALUES ('18', '1', '5', '1', 'add');
INSERT INTO `sd_category_priv` VALUES ('18', '1', '5', '1', 'edit');
INSERT INTO `sd_category_priv` VALUES ('18', '1', '5', '1', 'push');
INSERT INTO `sd_category_priv` VALUES ('18', '1', '5', '1', 'listorder');
INSERT INTO `sd_category_priv` VALUES ('18', '1', '5', '1', 'delete');
INSERT INTO `sd_category_priv` VALUES ('13', '1', '5', '1', 'init');
INSERT INTO `sd_category_priv` VALUES ('13', '1', '5', '1', 'add');
INSERT INTO `sd_category_priv` VALUES ('13', '1', '5', '1', 'edit');
INSERT INTO `sd_category_priv` VALUES ('13', '1', '5', '1', 'push');
INSERT INTO `sd_category_priv` VALUES ('13', '1', '5', '1', 'listorder');
INSERT INTO `sd_category_priv` VALUES ('13', '1', '5', '1', 'delete');
INSERT INTO `sd_category_priv` VALUES ('12', '1', '4', '1', 'remove');
INSERT INTO `sd_category_priv` VALUES ('12', '1', '4', '1', 'push');
INSERT INTO `sd_category_priv` VALUES ('12', '1', '4', '1', 'listorder');
INSERT INTO `sd_category_priv` VALUES ('12', '1', '4', '1', 'delete');
INSERT INTO `sd_category_priv` VALUES ('12', '1', '4', '1', 'edit');
INSERT INTO `sd_category_priv` VALUES ('12', '1', '4', '1', 'add');
INSERT INTO `sd_category_priv` VALUES ('12', '1', '4', '1', 'init');
INSERT INTO `sd_category_priv` VALUES ('22', '1', '5', '1', 'add');
INSERT INTO `sd_category_priv` VALUES ('22', '1', '5', '1', 'edit');
INSERT INTO `sd_category_priv` VALUES ('22', '1', '5', '1', 'delete');
INSERT INTO `sd_category_priv` VALUES ('22', '1', '5', '1', 'move');
INSERT INTO `sd_category_priv` VALUES ('22', '1', '5', '1', 'push');
INSERT INTO `sd_category_priv` VALUES ('22', '1', '5', '1', 'listorder');
INSERT INTO `sd_category_priv` VALUES ('17', '1', '5', '1', 'init');
INSERT INTO `sd_category_priv` VALUES ('17', '1', '5', '1', 'add');
INSERT INTO `sd_category_priv` VALUES ('17', '1', '5', '1', 'edit');
INSERT INTO `sd_category_priv` VALUES ('17', '1', '5', '1', 'push');
INSERT INTO `sd_category_priv` VALUES ('17', '1', '5', '1', 'listorder');
INSERT INTO `sd_category_priv` VALUES ('17', '1', '5', '1', 'delete');
INSERT INTO `sd_category_priv` VALUES ('16', '1', '5', '1', 'init');
INSERT INTO `sd_category_priv` VALUES ('16', '1', '5', '1', 'add');
INSERT INTO `sd_category_priv` VALUES ('16', '1', '5', '1', 'edit');
INSERT INTO `sd_category_priv` VALUES ('16', '1', '5', '1', 'push');
INSERT INTO `sd_category_priv` VALUES ('16', '1', '5', '1', 'listorder');
INSERT INTO `sd_category_priv` VALUES ('16', '1', '5', '1', 'delete');
INSERT INTO `sd_category_priv` VALUES ('15', '1', '5', '1', 'init');
INSERT INTO `sd_category_priv` VALUES ('15', '1', '5', '1', 'add');
INSERT INTO `sd_category_priv` VALUES ('15', '1', '5', '1', 'edit');
INSERT INTO `sd_category_priv` VALUES ('15', '1', '5', '1', 'push');
INSERT INTO `sd_category_priv` VALUES ('15', '1', '5', '1', 'listorder');
INSERT INTO `sd_category_priv` VALUES ('15', '1', '5', '1', 'delete');
INSERT INTO `sd_category_priv` VALUES ('14', '1', '5', '1', 'init');
INSERT INTO `sd_category_priv` VALUES ('14', '1', '5', '1', 'add');
INSERT INTO `sd_category_priv` VALUES ('14', '1', '5', '1', 'edit');
INSERT INTO `sd_category_priv` VALUES ('14', '1', '5', '1', 'push');
INSERT INTO `sd_category_priv` VALUES ('14', '1', '5', '1', 'listorder');
INSERT INTO `sd_category_priv` VALUES ('14', '1', '5', '1', 'delete');
INSERT INTO `sd_category_priv` VALUES ('11', '1', '5', '1', 'init');
INSERT INTO `sd_category_priv` VALUES ('11', '1', '5', '1', 'add');
INSERT INTO `sd_category_priv` VALUES ('11', '1', '5', '1', 'edit');
INSERT INTO `sd_category_priv` VALUES ('11', '1', '5', '1', 'push');
INSERT INTO `sd_category_priv` VALUES ('11', '1', '5', '1', 'listorder');
INSERT INTO `sd_category_priv` VALUES ('11', '1', '5', '1', 'delete');
INSERT INTO `sd_category_priv` VALUES ('10', '1', '5', '1', 'init');
INSERT INTO `sd_category_priv` VALUES ('10', '1', '5', '1', 'add');
INSERT INTO `sd_category_priv` VALUES ('10', '1', '5', '1', 'edit');
INSERT INTO `sd_category_priv` VALUES ('10', '1', '5', '1', 'push');
INSERT INTO `sd_category_priv` VALUES ('10', '1', '5', '1', 'listorder');
INSERT INTO `sd_category_priv` VALUES ('10', '1', '5', '1', 'delete');
INSERT INTO `sd_category_priv` VALUES ('5', '1', '5', '1', 'init');
INSERT INTO `sd_category_priv` VALUES ('5', '1', '5', '1', 'add');
INSERT INTO `sd_category_priv` VALUES ('5', '1', '5', '1', 'edit');
INSERT INTO `sd_category_priv` VALUES ('5', '1', '5', '1', 'push');
INSERT INTO `sd_category_priv` VALUES ('5', '1', '5', '1', 'listorder');
INSERT INTO `sd_category_priv` VALUES ('5', '1', '5', '1', 'delete');
INSERT INTO `sd_category_priv` VALUES ('4', '1', '5', '1', 'init');
INSERT INTO `sd_category_priv` VALUES ('4', '1', '5', '1', 'add');
INSERT INTO `sd_category_priv` VALUES ('4', '1', '5', '1', 'edit');
INSERT INTO `sd_category_priv` VALUES ('4', '1', '5', '1', 'push');
INSERT INTO `sd_category_priv` VALUES ('4', '1', '5', '1', 'listorder');
INSERT INTO `sd_category_priv` VALUES ('4', '1', '5', '1', 'delete');
INSERT INTO `sd_category_priv` VALUES ('9', '1', '5', '1', 'init');
INSERT INTO `sd_category_priv` VALUES ('9', '1', '5', '1', 'add');
INSERT INTO `sd_category_priv` VALUES ('9', '1', '5', '1', 'edit');
INSERT INTO `sd_category_priv` VALUES ('9', '1', '5', '1', 'push');
INSERT INTO `sd_category_priv` VALUES ('9', '1', '5', '1', 'listorder');
INSERT INTO `sd_category_priv` VALUES ('9', '1', '5', '1', 'delete');
INSERT INTO `sd_category_priv` VALUES ('8', '1', '5', '1', 'init');
INSERT INTO `sd_category_priv` VALUES ('8', '1', '5', '1', 'add');
INSERT INTO `sd_category_priv` VALUES ('8', '1', '5', '1', 'edit');
INSERT INTO `sd_category_priv` VALUES ('8', '1', '5', '1', 'push');
INSERT INTO `sd_category_priv` VALUES ('8', '1', '5', '1', 'listorder');
INSERT INTO `sd_category_priv` VALUES ('8', '1', '5', '1', 'delete');
INSERT INTO `sd_category_priv` VALUES ('7', '1', '5', '1', 'init');
INSERT INTO `sd_category_priv` VALUES ('7', '1', '5', '1', 'add');
INSERT INTO `sd_category_priv` VALUES ('7', '1', '5', '1', 'edit');
INSERT INTO `sd_category_priv` VALUES ('7', '1', '5', '1', 'push');
INSERT INTO `sd_category_priv` VALUES ('7', '1', '5', '1', 'listorder');
INSERT INTO `sd_category_priv` VALUES ('7', '1', '5', '1', 'delete');
INSERT INTO `sd_category_priv` VALUES ('6', '1', '5', '1', 'init');
INSERT INTO `sd_category_priv` VALUES ('6', '1', '5', '1', 'add');
INSERT INTO `sd_category_priv` VALUES ('6', '1', '5', '1', 'edit');
INSERT INTO `sd_category_priv` VALUES ('6', '1', '5', '1', 'push');
INSERT INTO `sd_category_priv` VALUES ('6', '1', '5', '1', 'listorder');
INSERT INTO `sd_category_priv` VALUES ('6', '1', '5', '1', 'delete');
INSERT INTO `sd_category_priv` VALUES ('3', '1', '5', '1', 'init');
INSERT INTO `sd_category_priv` VALUES ('3', '1', '5', '1', 'add');
INSERT INTO `sd_category_priv` VALUES ('3', '1', '5', '1', 'edit');
INSERT INTO `sd_category_priv` VALUES ('3', '1', '5', '1', 'push');
INSERT INTO `sd_category_priv` VALUES ('3', '1', '5', '1', 'listorder');
INSERT INTO `sd_category_priv` VALUES ('3', '1', '5', '1', 'delete');
INSERT INTO `sd_category_priv` VALUES ('2', '1', '5', '1', 'init');
INSERT INTO `sd_category_priv` VALUES ('2', '1', '5', '1', 'add');
INSERT INTO `sd_category_priv` VALUES ('2', '1', '5', '1', 'edit');
INSERT INTO `sd_category_priv` VALUES ('2', '1', '5', '1', 'push');
INSERT INTO `sd_category_priv` VALUES ('2', '1', '5', '1', 'listorder');
INSERT INTO `sd_category_priv` VALUES ('2', '1', '5', '1', 'delete');
INSERT INTO `sd_category_priv` VALUES ('1', '1', '5', '1', 'init');
INSERT INTO `sd_category_priv` VALUES ('1', '1', '5', '1', 'add');
INSERT INTO `sd_category_priv` VALUES ('1', '1', '5', '1', 'edit');
INSERT INTO `sd_category_priv` VALUES ('1', '1', '5', '1', 'push');
INSERT INTO `sd_category_priv` VALUES ('1', '1', '5', '1', 'listorder');
INSERT INTO `sd_category_priv` VALUES ('1', '1', '5', '1', 'delete');

-- ----------------------------
-- Table structure for `sd_config`
-- ----------------------------
DROP TABLE IF EXISTS `sd_config`;
CREATE TABLE `sd_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sd_config
-- ----------------------------

-- ----------------------------
-- Table structure for `sd_stats`
-- ----------------------------
DROP TABLE IF EXISTS `sd_stats`;
CREATE TABLE `sd_stats` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` char(8) NOT NULL,
  `click_num` int(11) NOT NULL DEFAULT '0',
  `share_wechat_moments_num` int(8) NOT NULL DEFAULT '0',
  `share_qq_num` int(8) NOT NULL DEFAULT '0',
  `share_wechat_friend_num` int(8) NOT NULL DEFAULT '0',
  `share_sina_num` int(8) NOT NULL DEFAULT '0',
  `share_qzone_num` int(8) NOT NULL DEFAULT '0',
  `go_num` int(11) NOT NULL DEFAULT '0',
  `anwei_num` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=118 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sd_stats
-- ----------------------------
INSERT INTO `sd_stats` VALUES ('114', '20170911', '2048112', '0', '81949', '0', '0', '0', '0', '0');
INSERT INTO `sd_stats` VALUES ('115', '20170912', '410325', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `sd_stats` VALUES ('116', '20170913', '1', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `sd_stats` VALUES ('117', '20170914', '17', '0', '0', '0', '0', '0', '0', '0');

-- ----------------------------
-- Table structure for `sd_task_log`
-- ----------------------------
DROP TABLE IF EXISTS `sd_task_log`;
CREATE TABLE `sd_task_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sd_task_log
-- ----------------------------
INSERT INTO `sd_task_log` VALUES ('1', 'a:6:{s:5:\"table\";s:5:\"stats\";s:5:\"field\";s:34:\"RedisStatsModel_20170912:click_num\";s:10:\"field_type\";s:9:\"click_num\";s:3:\"num\";s:1:\"1\";s:4:\"task\";s:11:\"update num.\";s:4:\"info\";s:19:\"redis del key fail.\";}');
INSERT INTO `sd_task_log` VALUES ('2', 'a:6:{s:5:\"table\";s:5:\"stats\";s:5:\"field\";s:34:\"RedisStatsModel_20170912:click_num\";s:10:\"field_type\";s:9:\"click_num\";s:3:\"num\";s:1:\"5\";s:4:\"task\";s:11:\"update num.\";s:4:\"info\";s:19:\"redis del key fail.\";}');
INSERT INTO `sd_task_log` VALUES ('3', 'a:6:{s:5:\"table\";s:5:\"stats\";s:5:\"field\";s:34:\"RedisStatsModel_20170912:click_num\";s:10:\"field_type\";s:9:\"click_num\";s:3:\"num\";s:1:\"1\";s:4:\"task\";s:11:\"update num.\";s:4:\"info\";s:19:\"redis del key fail.\";}');
INSERT INTO `sd_task_log` VALUES ('4', 'a:6:{s:5:\"table\";s:5:\"stats\";s:5:\"field\";s:34:\"RedisStatsModel_20170912:click_num\";s:10:\"field_type\";s:9:\"click_num\";s:3:\"num\";s:1:\"2\";s:4:\"task\";s:11:\"update num.\";s:4:\"info\";s:19:\"redis del key fail.\";}');

-- ----------------------------
-- Table structure for `sd_user`
-- ----------------------------
DROP TABLE IF EXISTS `sd_user`;
CREATE TABLE `sd_user` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `username` char(20) NOT NULL,
  `password` varchar(40) NOT NULL,
  `regtime` int(10) NOT NULL,
  `status` tinyint(2) NOT NULL DEFAULT '1',
  `groupid` int(5) NOT NULL DEFAULT '0',
  `email` varchar(60) NOT NULL,
  `roleid` varchar(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sd_user
-- ----------------------------
INSERT INTO `sd_user` VALUES ('1', 'ming', '123456', '0', '1', '0', 'ming@163.com', '0');
INSERT INTO `sd_user` VALUES ('2', 'ming2', '123456', '0', '1', '0', 'ming2@163.com', '0');
INSERT INTO `sd_user` VALUES ('3', 'ming3', '123456', '0', '1', '0', 'ming3@163.com', '0');
INSERT INTO `sd_user` VALUES ('4', 'ming4', '123456', '0', '1', '0', 'ming4@163.com', '0');

-- ----------------------------
-- Table structure for `sd_wx_user`
-- ----------------------------
DROP TABLE IF EXISTS `sd_wx_user`;
CREATE TABLE `sd_wx_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `create_time` int(11) NOT NULL,
  `status` tinyint(2) NOT NULL DEFAULT '1',
  `openid` varchar(64) NOT NULL,
  `ip` varchar(60) NOT NULL,
  `update_time` int(11) NOT NULL,
  `nickname` varchar(100) DEFAULT NULL,
  `headimgurl` varchar(255) DEFAULT NULL,
  `province` varchar(60) DEFAULT NULL,
  `country` varchar(30) DEFAULT NULL,
  `city` varchar(30) DEFAULT NULL,
  `sex` tinyint(2) DEFAULT '0',
  `privilege` varchar(30) DEFAULT NULL,
  `unionid` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sd_wx_user
-- ----------------------------
