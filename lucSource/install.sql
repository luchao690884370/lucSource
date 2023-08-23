CREATE TABLE IF NOT EXISTS `luc_nav_group` (
`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
`title` varchar(255) NOT NULL DEFAULT '' COMMENT '标题',
`name` varchar(255) NOT NULL DEFAULT '' COMMENT '标识',
`status` int(1) NOT NULL DEFAULT '1' COMMENT '1可用 -1禁用',
`desc` varchar(1000) DEFAULT NULL COMMENT '备注',
`created_at` datetime DEFAULT NULL COMMENT '创建时间',
`updated_at` datetime DEFAULT NULL COMMENT '更新时间',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARACTER SET = utf8mb4 COMMENT='导航分组表';



CREATE TABLE IF NOT EXISTS `luc_nav`(
`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
`pid` int(11) NOT NULL DEFAULT '0',
`nav_id` int(11) unsigned NOT NULL DEFAULT '0',
`title` varchar(255) DEFAULT '',
`src` varchar(255) DEFAULT NULL,
`param` varchar(255) DEFAULT NULL,
`target` int(1) NOT NULL DEFAULT '0' COMMENT '是否新窗口打开,默认0,1新窗口打开',
`status` int(1) NOT NULL DEFAULT '1' COMMENT '1可用,-1禁用',
`sort` int(11) NOT NULL DEFAULT '0',
`created_at` datetime DEFAULT NULL COMMENT '创建时间',
`updated_at` datetime DEFAULT NULL COMMENT '更新时间',
 PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARACTER SET = utf8mb4 COMMENT='导航详情表';



CREATE TABLE IF NOT EXISTS `luc_slide`(
`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
`title` varchar(255) NOT NULL DEFAULT '',
`name` varchar(255) NOT NULL DEFAULT '' COMMENT '标识',
`status` int(1) NOT NULL DEFAULT '1' COMMENT '1可用-1禁用',
`desc` varchar(1000) DEFAULT NULL,
`created_at` datetime DEFAULT NULL COMMENT '创建时间',
`updated_at` datetime DEFAULT NULL COMMENT '更新时间',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARACTER SET = utf8mb4 COMMENT='幻灯片表';



CREATE TABLE IF NOT EXISTS `luc_slide_info`(
`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
`slide_id` int(11) unsigned NOT NULL DEFAULT '0',
`title` varchar(255) DEFAULT NULL,
`desc` varchar(1000) DEFAULT NULL,
`img` varchar(255) NOT NULL DEFAULT '',
`src` varchar(255) DEFAULT NULL,
`status` int(1) NOT NULL DEFAULT '1' COMMENT '1可用-1禁用',
`sort` int(11) NOT NULL DEFAULT '0',
`created_at` datetime DEFAULT NULL COMMENT '创建时间',
`updated_at` datetime DEFAULT NULL COMMENT '更新时间',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARACTER SET = utf8mb4 COMMENT='幻灯片详情表';



DROP TABLE IF EXISTS `luc_links`;
CREATE TABLE `luc_links`  (
`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
`name` varchar(255)  NOT NULL DEFAULT '' COMMENT '网站标题',
`logo` varchar(255) NOT NULL DEFAULT '' COMMENT '网站logo',
`src` varchar(255) NULL DEFAULT NULL COMMENT '链接',
`target` int(1) NOT NULL DEFAULT 1 COMMENT '是否新窗口打开，1是,0否',
`status` int(1) NOT NULL DEFAULT 1 COMMENT '状态:1可用-1禁用',
`sort` int(11) NOT NULL DEFAULT 0 COMMENT '排序',
`created_at` datetime DEFAULT NULL COMMENT '创建时间',
`updated_at` datetime DEFAULT NULL COMMENT '更新时间',
PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB DEFAULT CHARACTER SET = utf8mb4 COMMENT = '友情链接';



DROP TABLE IF EXISTS `luc_article_cate`;
CREATE TABLE `luc_article_cate` (
`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
`pid` int(11) NOT NULL DEFAULT '0' COMMENT '父类ID',
`title` varchar(255) NOT NULL DEFAULT '' COMMENT '分类名称',
`keywords` varchar(255) DEFAULT '' COMMENT '关键字',
`desc` varchar(1000) DEFAULT '' COMMENT '描述',
`sort` int(5) NOT NULL DEFAULT '0' COMMENT '排序',
`created_at` datetime DEFAULT NULL COMMENT '创建时间',
`updated_at` datetime DEFAULT NULL COMMENT '更新时间',
`delete_at` datetime DEFAULT NULL COMMENT '删除时间',
 PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARACTER SET = utf8mb4 COMMENT='文章分类::crud';


DROP TABLE IF EXISTS `luc_article`;
CREATE TABLE `luc_article` (
`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
`cate_id` int(11) NOT NULL DEFAULT '0' COMMENT '所属分类',
`title` varchar(255) NOT NULL DEFAULT '' COMMENT '标题',
`desc` varchar(1000) DEFAULT '' COMMENT '摘要',
`thumb` varchar(1000) NOT NULL DEFAULT 0 COMMENT '封面图',
`original` int(1) NOT NULL DEFAULT 0 COMMENT '是否原创:1是,0否',
`origin` varchar(255) NOT NULL DEFAULT '' COMMENT '来源或作者',
`origin_url` varchar(255) NOT NULL DEFAULT '' COMMENT '来源地址',
`content` text NOT NULL COMMENT '内容',
`md_content` text NOT NULL COMMENT 'markdown内容',
`read` int(11) NOT NULL DEFAULT '0' COMMENT '阅读量',
`type` tinyint(2) NOT NULL DEFAULT '0' COMMENT '属性:1精华,2热门,3推荐',
`is_home` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否首页显示:0否,1是',
`sort` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
`status` int(1) NOT NULL DEFAULT '1' COMMENT '状态:1正常,0下架',
`admin_id` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '创建人',
`created_at` datetime DEFAULT NULL COMMENT '创建时间',
`updated_at` datetime DEFAULT NULL COMMENT '更新时间',
`delete_at` datetime DEFAULT NULL COMMENT '删除时间',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARACTER SET = utf8mb4 COMMENT='文章::crud';


DROP TABLE IF EXISTS `luc_source_cate`;
CREATE TABLE `luc_source_cate` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `pid` int(11) NOT NULL DEFAULT '0',
  `title` varchar(255) NOT NULL COMMENT '标题',
  `keywords` varchar(255) DEFAULT NULL COMMENT '关键字',
  `desc` varchar(255) DEFAULT NULL COMMENT '备注',
  `sort` int(11) DEFAULT '0' COMMENT '排序',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `delete_at` datetime DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARACTER SET =utf8mb4 COMMENT='源码分类';



DROP TABLE IF EXISTS `luc_source_code`;
CREATE TABLE `luc_source_code` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `cate_id` int(11) NOT NULL COMMENT '分类名称',
  `title` varchar(255) NOT NULL COMMENT '标题',
  `content` longtext COMMENT '内容',
  `desc` varchar(255) DEFAULT NULL COMMENT '描述',
  `thumb` varchar(255) DEFAULT NULL COMMENT '缩略图',
  `read` int(11) DEFAULT '0' COMMENT '阅读量',
  `download` int(11) DEFAULT '0' COMMENT '下载量',
  `download_password` varchar(50) DEFAULT NULL COMMENT '下载密码',
  `download_url` varchar(255) DEFAULT NULL COMMENT '下载地址',
  `type` varchar(255) DEFAULT NULL COMMENT '源码分类',
  `lang` varchar(100) DEFAULT NULL COMMENT '开发语言',
  `dbtype` varchar(50) DEFAULT NULL COMMENT '数据库类型',
  `system_brand` varchar(100) DEFAULT NULL COMMENT '系统品牌',
  `sort` int(11) DEFAULT '0' COMMENT '排序',
  `status` int(11) DEFAULT '1' COMMENT '状态',
  `admin_id` int(11) DEFAULT '0' COMMENT '创建者',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `delete_at` datetime DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARACTER SET =utf8mb4 COMMENT='源码列表';
