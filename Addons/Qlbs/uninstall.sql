DELETE FROM `wp_attribute` WHERE model_id = (SELECT id FROM wp_model WHERE `name`='qlbs' ORDER BY id DESC LIMIT 1);
DELETE FROM `wp_model` WHERE `name`='qlbs' ORDER BY id DESC LIMIT 1;
DROP TABLE IF EXISTS `wp_qlbs`;

DELETE FROM `wp_attribute` WHERE model_id = (SELECT id FROM wp_model WHERE `name`='qlbs_user' ORDER BY id DESC LIMIT 1);
DELETE FROM `wp_model` WHERE `name`='qlbs_user' ORDER BY id DESC LIMIT 1;
DROP TABLE IF EXISTS `wp_qlbs_user`;