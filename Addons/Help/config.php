<?php
return array(
	'help'=>array(//配置在表单中的键名 ,这个会是config[help]
		'title'=>'是否开启帮助:',//表单的文字
		'type'=>'select',		 //表单的类型：text、textarea、checkbox、radio、select等
		'options'=>array(		 //select 和radion、checkbox的子选项
			'1'=>'开启',		 //值=>文字
			'0'=>'关闭',
		),
		'value'=>'1',			 //表单的默认值
	),
);
					