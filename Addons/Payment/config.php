<?php
return array(
	'jsapiurl' => array(
        'title' => '微信支付地址[无效]:',//表单的文字
        'type' => 'text',         //表单的类型：text、textarea、checkbox、radio、select等
        'value' => 'http://xxxxx.xx/pay/js_api_call.php',             //表单的默认值
        'tip' => '微信支付的默认地址，不要随便修改'
    ),
	'isopen'=>array(//配置在表单中的键名 ,这个会是config[random]
		'title'=>'是否开启支付功能:',//表单的文字
		'type'=>'radio',		 //表单的类型：text、textarea、checkbox、radio、select等
		'options'=>array(		 //select 和radion、checkbox的子选项
			'1'=>'开启',		 //值=>文字
			'0'=>'关闭',
		),
		'value'=>'1',			 //表单的默认值
		'tip'=>'开启支付后，商城等b2c功能将有在线支付功能,控制所有支付'
	),
    'isopenwxv3'=>array(//配置在表单中的键名 ,这个会是config[random]
        'title'=>'是否开启微信支付V3版功能:',//表单的文字
        'type'=>'radio',		 //表单的类型：text、textarea、checkbox、radio、select等
        'options'=>array(		 //select 和radion、checkbox的子选项
            '1'=>'开启',		 //值=>文字
            '0'=>'关闭',
        ),
        'value'=>'1',			 //表单的默认值
        'tip'=>'可单独关闭'
    ),
	'isopenwx'=>array(//配置在表单中的键名 ,这个会是config[random]
		'title'=>'是否开启微信支付功能:',//表单的文字
		'type'=>'radio',		 //表单的类型：text、textarea、checkbox、radio、select等
		'options'=>array(		 //select 和radion、checkbox的子选项
			'1'=>'开启',		 //值=>文字
			'0'=>'关闭',
		),
		'value'=>'1',			 //表单的默认值
		'tip'=>'可单独关闭'
	),
	'isopenzfb'=>array(//配置在表单中的键名 ,这个会是config[random]
		'title'=>'是否开启支付宝支付功能:',//表单的文字
		'type'=>'radio',		 //表单的类型：text、textarea、checkbox、radio、select等
		'options'=>array(		 //select 和radion、checkbox的子选项
			'1'=>'开启',		 //值=>文字
			'0'=>'关闭',
		),
		'value'=>'1',			 //表单的默认值
		'tip'=>'可单独关闭'
	),
	'isopencftwap'=>array(//配置在表单中的键名 ,这个会是config[random]
		'title'=>'是否开启财付通(WAP手机接口)支付功能:',//表单的文字
		'type'=>'radio',		 //表单的类型：text、textarea、checkbox、radio、select等
		'options'=>array(		 //select 和radion、checkbox的子选项
			'1'=>'开启',		 //值=>文字
			'0'=>'关闭',
		),
		'value'=>'1',			 //表单的默认值
		'tip'=>'可单独关闭'
	),
	'isopencft'=>array(//配置在表单中的键名 ,这个会是config[random]
		'title'=>'是否开启财付通(即时到账接口)支付功能:',//表单的文字
		'type'=>'radio',		 //表单的类型：text、textarea、checkbox、radio、select等
		'options'=>array(		 //select 和radion、checkbox的子选项
			'1'=>'开启',		 //值=>文字
			'0'=>'关闭',
		),
		'value'=>'1',			 //表单的默认值
		'tip'=>'可单独关闭'
	),
	'isopenyl'=>array(//配置在表单中的键名 ,这个会是config[random]
		'title'=>'是否开启银联在线支付功能:',//表单的文字
		'type'=>'radio',		 //表单的类型：text、textarea、checkbox、radio、select等
		'options'=>array(		 //select 和radion、checkbox的子选项
			'1'=>'开启',		 //值=>文字
			'0'=>'关闭',
		),
		'value'=>'1',			 //表单的默认值
		'tip'=>'可单独关闭'
	),
);
					