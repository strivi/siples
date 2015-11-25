CREATE TABLE IF NOT EXISTS `wp_invites` (
`id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
`token`  varchar(255) NOT NULL  COMMENT 'Token',
`title`  varchar(255) NOT NULL  COMMENT '邀请标题',
`keyword`  varchar(255) NOT NULL  COMMENT '关键词',
`pic`  int(10) UNSIGNED NOT NULL  COMMENT '回复图片',
`type`  char(10) NOT NULL  DEFAULT 0 COMMENT '邀请类型',
`content`  varchar(255) NOT NULL  COMMENT '邀请内容',
`brief`  varchar(255) NOT NULL  COMMENT '邀请介绍',
`startdate`  int(10) NOT NULL  COMMENT '时间',
`lnglat`  varchar(255) NOT NULL  COMMENT '经纬度',
`copyrite`  varchar(255) NOT NULL  COMMENT '版权信息',
`address`  varchar(255) NOT NULL  COMMENT '地址',
`class`  char(50) NOT NULL  DEFAULT 0 COMMENT '版面样式',
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci CHECKSUM=0 ROW_FORMAT=DYNAMIC DELAY_KEY_WRITE=0;


INSERT INTO `wp_model` (`name`,`title`,`extend`,`relation`,`need_pk`,`field_sort`,`field_group`,`attribute_list`,`template_list`,`template_add`,`template_edit`,`list_grid`,`list_row`,`search_key`,`search_list`,`create_time`,`update_time`,`status`,`engine_type`) VALUES ('invites','微邀请','0','','1','{"1":["title","keyword","pic","type","content","brief","startdate","address","lnglat","copyrite","class"]}','1:基础','','','','','title:邀请标题\r\nkeyword:关键词\r\ntype|get_name_by_status:邀请类型\r\nstartdate|time_format:时间\r\nid:操作:[EDIT]|编辑,[DELETE]|删除,/addon/Invites/Invitessign/lists?iid=[id]|查看签到','10','title','','1412836970','1414173218','1','MyISAM');
INSERT INTO `wp_attribute` (`name`,`title`,`field`,`type`,`value`,`remark`,`is_show`,`extra`,`model_id`,`is_must`,`status`,`update_time`,`create_time`,`validate_rule`,`validate_time`,`error_info`,`validate_type`,`auto_rule`,`auto_time`,`auto_type`) VALUES ('token','Token','varchar(255) NOT NULL','string','','','0','','0','0','1','1412931485','1412837177','','3','','regex','get_token','1','function');
INSERT INTO `wp_attribute` (`name`,`title`,`field`,`type`,`value`,`remark`,`is_show`,`extra`,`model_id`,`is_must`,`status`,`update_time`,`create_time`,`validate_rule`,`validate_time`,`error_info`,`validate_type`,`auto_rule`,`auto_time`,`auto_type`) VALUES ('title','邀请标题','varchar(255) NOT NULL','string','','','1','','0','0','1','1412837679','1412837679','','3','','regex','','3','function');
INSERT INTO `wp_attribute` (`name`,`title`,`field`,`type`,`value`,`remark`,`is_show`,`extra`,`model_id`,`is_must`,`status`,`update_time`,`create_time`,`validate_rule`,`validate_time`,`error_info`,`validate_type`,`auto_rule`,`auto_time`,`auto_type`) VALUES ('keyword','关键词','varchar(255) NOT NULL','string','','','1','','0','0','1','1412837717','1412837717','','3','','regex','','3','function');
INSERT INTO `wp_attribute` (`name`,`title`,`field`,`type`,`value`,`remark`,`is_show`,`extra`,`model_id`,`is_must`,`status`,`update_time`,`create_time`,`validate_rule`,`validate_time`,`error_info`,`validate_type`,`auto_rule`,`auto_time`,`auto_type`) VALUES ('pic','回复图片','int(10) UNSIGNED NOT NULL','picture','','','1','','0','0','1','1412837766','1412837766','','3','','regex','','3','function');
INSERT INTO `wp_attribute` (`name`,`title`,`field`,`type`,`value`,`remark`,`is_show`,`extra`,`model_id`,`is_must`,`status`,`update_time`,`create_time`,`validate_rule`,`validate_time`,`error_info`,`validate_type`,`auto_rule`,`auto_time`,`auto_type`) VALUES ('type','邀请类型','char(10) NOT NULL','bool','0','','1','0:会议\r\n1:聚会\r\n2:活动','0','0','1','1412867590','1412837831','','3','','regex','','3','function');
INSERT INTO `wp_attribute` (`name`,`title`,`field`,`type`,`value`,`remark`,`is_show`,`extra`,`model_id`,`is_must`,`status`,`update_time`,`create_time`,`validate_rule`,`validate_time`,`error_info`,`validate_type`,`auto_rule`,`auto_time`,`auto_type`) VALUES ('content','邀请内容','varchar(255) NOT NULL','textarea','','','1','','0','0','1','1412860511','1412837873','','3','','regex','','3','function');
INSERT INTO `wp_attribute` (`name`,`title`,`field`,`type`,`value`,`remark`,`is_show`,`extra`,`model_id`,`is_must`,`status`,`update_time`,`create_time`,`validate_rule`,`validate_time`,`error_info`,`validate_type`,`auto_rule`,`auto_time`,`auto_type`) VALUES ('brief','邀请介绍','varchar(255) NOT NULL','textarea','','','1','','0','0','1','1413033137','1412837925','','3','','regex','','3','function');
INSERT INTO `wp_attribute` (`name`,`title`,`field`,`type`,`value`,`remark`,`is_show`,`extra`,`model_id`,`is_must`,`status`,`update_time`,`create_time`,`validate_rule`,`validate_time`,`error_info`,`validate_type`,`auto_rule`,`auto_time`,`auto_type`) VALUES ('startdate','时间','int(10) NOT NULL','datetime','','','1','','0','0','1','1412923168','1412838047','','3','','regex','','3','function');
INSERT INTO `wp_attribute` (`name`,`title`,`field`,`type`,`value`,`remark`,`is_show`,`extra`,`model_id`,`is_must`,`status`,`update_time`,`create_time`,`validate_rule`,`validate_time`,`error_info`,`validate_type`,`auto_rule`,`auto_time`,`auto_type`) VALUES ('lnglat','经纬度','varchar(255) NOT NULL','string','','拾取地图坐标：http://api.map.baidu.com/lbsapi/getpoint/index.html 如：（114.116883,22.615981）','1','','0','0','1','1413033561','1412838095','','3','','regex','','3','function');
INSERT INTO `wp_attribute` (`name`,`title`,`field`,`type`,`value`,`remark`,`is_show`,`extra`,`model_id`,`is_must`,`status`,`update_time`,`create_time`,`validate_rule`,`validate_time`,`error_info`,`validate_type`,`auto_rule`,`auto_time`,`auto_type`) VALUES ('copyrite','版权信息','varchar(255) NOT NULL','string','','','1','','0','0','1','1412838139','1412838139','','3','','regex','','3','function');
INSERT INTO `wp_attribute` (`name`,`title`,`field`,`type`,`value`,`remark`,`is_show`,`extra`,`model_id`,`is_must`,`status`,`update_time`,`create_time`,`validate_rule`,`validate_time`,`error_info`,`validate_type`,`auto_rule`,`auto_time`,`auto_type`) VALUES ('address','地址','varchar(255) NOT NULL','string','','','1','','0','0','1','1412955079','1412955079','','3','','regex','','3','function');
INSERT INTO `wp_attribute` (`name`,`title`,`field`,`type`,`value`,`remark`,`is_show`,`extra`,`model_id`,`is_must`,`status`,`update_time`,`create_time`,`validate_rule`,`validate_time`,`error_info`,`validate_type`,`auto_rule`,`auto_time`,`auto_type`) VALUES ('class','版面样式','char(50) NOT NULL','select','0','','1','0:版面一\r\n1:版面二','0','0','1','1413033355','1413033301','','3','','regex','','3','function');
UPDATE `wp_attribute` SET model_id= (SELECT MAX(id) FROM `wp_model`) WHERE model_id=0;





CREATE TABLE IF NOT EXISTS `wp_invitessign` (
`id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
`token`  varchar(255) NOT NULL  COMMENT 'Token',
`mid`  int(10) UNSIGNED NOT NULL  COMMENT '所属邀请',
`telphone`  varchar(255) NOT NULL  COMMENT '电话',
`rdogo`  char(10) NOT NULL  DEFAULT '参加' COMMENT '是否参加',
`content`  text NOT NULL  COMMENT '签到内容',
`username`  varchar(255) NOT NULL  COMMENT '姓名',
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci CHECKSUM=0 ROW_FORMAT=DYNAMIC DELAY_KEY_WRITE=0;


INSERT INTO `wp_model` (`name`,`title`,`extend`,`relation`,`need_pk`,`field_sort`,`field_group`,`attribute_list`,`template_list`,`template_add`,`template_edit`,`list_grid`,`list_row`,`search_key`,`search_list`,`create_time`,`update_time`,`status`,`engine_type`) VALUES ('invitessign','微邀请签到','0','','1','{"1":["username","telphone","rdogo","content"]}','1:基础','','','','','username:10%姓名\r\ntelphone:10%电话\r\nmid:18%所属邀请\r\nrdogo|get_name_by_status:8%是否参加\r\ncontent:40%签到内容\r\nid:操作:[EDIT]|编辑,[DELETE]|删除','10','username','','1412861885','1414173206','1','MyISAM');
INSERT INTO `wp_attribute` (`name`,`title`,`field`,`type`,`value`,`remark`,`is_show`,`extra`,`model_id`,`is_must`,`status`,`update_time`,`create_time`,`validate_rule`,`validate_time`,`error_info`,`validate_type`,`auto_rule`,`auto_time`,`auto_type`) VALUES ('token','Token','varchar(255) NOT NULL','string','','','0','','0','0','1','1412861983','1412861983','','3','','regex','get_token','3','function');
INSERT INTO `wp_attribute` (`name`,`title`,`field`,`type`,`value`,`remark`,`is_show`,`extra`,`model_id`,`is_must`,`status`,`update_time`,`create_time`,`validate_rule`,`validate_time`,`error_info`,`validate_type`,`auto_rule`,`auto_time`,`auto_type`) VALUES ('mid','所属邀请','int(10) UNSIGNED NOT NULL','select','','','1','','0','0','1','1414502118','1412862017','','3','','regex','','3','function');
INSERT INTO `wp_attribute` (`name`,`title`,`field`,`type`,`value`,`remark`,`is_show`,`extra`,`model_id`,`is_must`,`status`,`update_time`,`create_time`,`validate_rule`,`validate_time`,`error_info`,`validate_type`,`auto_rule`,`auto_time`,`auto_type`) VALUES ('telphone','电话','varchar(255) NOT NULL','string','','','1','','0','0','1','1412862084','1412862084','','3','','regex','','3','function');
INSERT INTO `wp_attribute` (`name`,`title`,`field`,`type`,`value`,`remark`,`is_show`,`extra`,`model_id`,`is_must`,`status`,`update_time`,`create_time`,`validate_rule`,`validate_time`,`error_info`,`validate_type`,`auto_rule`,`auto_time`,`auto_type`) VALUES ('rdogo','是否参加','char(10) NOT NULL','radio','参加','','1','参加\r\n不参加','0','0','1','1412862207','1412862197','','3','','regex','','3','function');
INSERT INTO `wp_attribute` (`name`,`title`,`field`,`type`,`value`,`remark`,`is_show`,`extra`,`model_id`,`is_must`,`status`,`update_time`,`create_time`,`validate_rule`,`validate_time`,`error_info`,`validate_type`,`auto_rule`,`auto_time`,`auto_type`) VALUES ('content','签到内容','text NOT NULL','textarea','','','1','','0','0','1','1412862238','1412862238','','3','','regex','','3','function');
INSERT INTO `wp_attribute` (`name`,`title`,`field`,`type`,`value`,`remark`,`is_show`,`extra`,`model_id`,`is_must`,`status`,`update_time`,`create_time`,`validate_rule`,`validate_time`,`error_info`,`validate_type`,`auto_rule`,`auto_time`,`auto_type`) VALUES ('username','姓名','varchar(255) NOT NULL','string','','','1','','0','0','1','1412862276','1412862276','','3','','regex','','3','function');
UPDATE `wp_attribute` SET model_id= (SELECT MAX(id) FROM `wp_model`) WHERE model_id=0;