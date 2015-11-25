<?php

/**
 * 留言板插件配置文件
 * @author 艾逗笔<765532665@qq.com>
 * @version 1.0
 * Modified at 2014/11/22 14:08
 */
return array(

	'title'=>array(
		'title'=>'标题',
		'type'=>'text',
		'value'=>'留言板',
		'tip'=>'微信中回复的图文消息标题'
	),
	'cover'=>array(
		'title'=>'封面',
		'type'=>'picture',
		'value'=>'',
		'tip'=>'微信中回复的图文消息封面图片'
	),
	'cover_url'=>array(
		'title'=>'封面图片地址',
		'type'=>'text',
		'value'=>'',
		'tip'=>'微信中回复的图文消息封面图片url地址'
	),
	'desc'=>array(
		'title'=>'描述',
		'type'=>'textarea',
		'value'=>'请在这里给我留言',
		'tip'=>'微信中回复的图文消息描述'
	)
	
);
					