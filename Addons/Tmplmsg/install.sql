CREATE TABLE IF NOT EXISTS `wp_tmplmsg` (
`id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
`openid`  varchar(255) NOT NULL  COMMENT 'openid',
`template_id`  varchar(500) NOT NULL  COMMENT '模板ID',
`message`  text NOT NULL  COMMENT '消息内容',
`MsgID`  varchar(255) NOT NULL  COMMENT '消息ID',
`sendstatus`  char(50) NOT NULL  COMMENT '发送状态',
`Status`  char(50) NOT NULL  COMMENT '送达报告',
`token`  varchar(255) NOT NULL  COMMENT 'token',
`ctime`  int(10) NOT NULL  COMMENT '发送时间',
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci CHECKSUM=0 ROW_FORMAT=DYNAMIC DELAY_KEY_WRITE=0;
INSERT INTO `wp_model` (`name`,`title`,`extend`,`relation`,`need_pk`,`field_sort`,`field_group`,`attribute_list`,`template_list`,`template_add`,`template_edit`,`list_grid`,`list_row`,`search_key`,`search_list`,`create_time`,`update_time`,`status`,`engine_type`) VALUES ('tmplmsg','模板消息','0','','1','{"1":["openid","template_id","message","MsgID","sendstatus","Status","ctime"]}','1:基础','','','','','id:ID\r\nopenid:OPENID\r\ntemplate_id:模板ID\r\nsendstatus|get_name_by_status:发送状态\r\nStatus|get_name_by_status:送达报告\r\nMsgID:消息ID\r\nctime|time_format:发送时间\r\nid:操作:[DELETE]|删除','10','openid','','1409247434','1409276606','1','MyISAM');
INSERT INTO `wp_attribute` (`name`,`title`,`field`,`type`,`value`,`remark`,`is_show`,`extra`,`model_id`,`is_must`,`status`,`update_time`,`create_time`,`validate_rule`,`validate_time`,`error_info`,`validate_type`,`auto_rule`,`auto_time`,`auto_type`) VALUES ('openid','openid','varchar(255) NOT NULL','string','','','1','','0','0','1','1409247462','1409247462','','3','','regex','','3','function');
INSERT INTO `wp_attribute` (`name`,`title`,`field`,`type`,`value`,`remark`,`is_show`,`extra`,`model_id`,`is_must`,`status`,`update_time`,`create_time`,`validate_rule`,`validate_time`,`error_info`,`validate_type`,`auto_rule`,`auto_time`,`auto_type`) VALUES ('template_id','模板ID','varchar(500) NOT NULL','string','','','1','','0','0','1','1409247489','1409247489','','3','','regex','','3','function');
INSERT INTO `wp_attribute` (`name`,`title`,`field`,`type`,`value`,`remark`,`is_show`,`extra`,`model_id`,`is_must`,`status`,`update_time`,`create_time`,`validate_rule`,`validate_time`,`error_info`,`validate_type`,`auto_rule`,`auto_time`,`auto_type`) VALUES ('message','消息内容','text NOT NULL','textarea','','','1','','0','0','1','1409247512','1409247512','','3','','regex','','3','function');
INSERT INTO `wp_attribute` (`name`,`title`,`field`,`type`,`value`,`remark`,`is_show`,`extra`,`model_id`,`is_must`,`status`,`update_time`,`create_time`,`validate_rule`,`validate_time`,`error_info`,`validate_type`,`auto_rule`,`auto_time`,`auto_type`) VALUES ('MsgID','消息ID','varchar(255) NOT NULL','string','','','1','','0','0','1','1409247552','1409247552','','3','','regex','','3','function');
INSERT INTO `wp_attribute` (`name`,`title`,`field`,`type`,`value`,`remark`,`is_show`,`extra`,`model_id`,`is_must`,`status`,`update_time`,`create_time`,`validate_rule`,`validate_time`,`error_info`,`validate_type`,`auto_rule`,`auto_time`,`auto_type`) VALUES ('sendstatus','发送状态','char(50) NOT NULL','select','','','1','0:成功\r\n1:失败','0','0','1','1409247862','1409247608','','3','','regex','','3','function');
INSERT INTO `wp_attribute` (`name`,`title`,`field`,`type`,`value`,`remark`,`is_show`,`extra`,`model_id`,`is_must`,`status`,`update_time`,`create_time`,`validate_rule`,`validate_time`,`error_info`,`validate_type`,`auto_rule`,`auto_time`,`auto_type`) VALUES ('Status','送达报告','char(50) NOT NULL','select','','','1','0:成功\r\n1:失败：用户拒收\r\n2:失败：其他原因','0','0','1','1409247873','1409247697','','3','','regex','','3','function');
INSERT INTO `wp_attribute` (`name`,`title`,`field`,`type`,`value`,`remark`,`is_show`,`extra`,`model_id`,`is_must`,`status`,`update_time`,`create_time`,`validate_rule`,`validate_time`,`error_info`,`validate_type`,`auto_rule`,`auto_time`,`auto_type`) VALUES ('token','token','varchar(255) NOT NULL','string','','','0','','0','0','1','1409247732','1409247713','','3','','regex','get_token','1','function');
INSERT INTO `wp_attribute` (`name`,`title`,`field`,`type`,`value`,`remark`,`is_show`,`extra`,`model_id`,`is_must`,`status`,`update_time`,`create_time`,`validate_rule`,`validate_time`,`error_info`,`validate_type`,`auto_rule`,`auto_time`,`auto_type`) VALUES ('ctime','发送时间','int(10) NOT NULL','datetime','','','1','','0','0','1','1409247759','1409247759','','3','','regex','time','3','function');
UPDATE `wp_attribute` SET model_id= (SELECT MAX(id) FROM `wp_model`) WHERE model_id=0;