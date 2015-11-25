<?php

namespace Addons\Qlbs\Controller;
use Home\Controller\AddonsController;

class QlbsController extends AddonsController{
	function _initialize() {
		$this->model = $this->getModel ( 'Qlbs' );
	
		$res ['title'] = '百度LBS云';
		$res ['url'] = addons_url ( 'Qlbs://Qlbs/lists' );
		$res ['class'] = 'current';
		$nav [] = $res;
	
		$res ['title'] = '查看成员';
		$res ['url'] = addons_url ( 'Qlbs://User/lists');
		$res ['class'] = '';
		$nav [] = $res;
		
		$res ['title'] = '配置';
		$res ['url'] = addons_url ( 'Qlbs://Qlbs/config');
		$res ['class'] = '';
		$nav [] = $res;
	
		$this->assign ( 'nav', $nav );
	}
	public function lists() {
		$normal_tips = '本插件须要服务号认证才能使用';
		$this->assign ( 'normal_tips', $normal_tips );
		parent::common_lists ( $this->model );
	}
	
	public function config() {
		$res ['title'] = '百度LBS云';
		$res ['url'] = addons_url ( 'Qlbs://Qlbs/lists' );
		$res ['class'] = '';
		$nav [] = $res;
	
		$res ['title'] = '查看成员';
		$res ['url'] = addons_url ( 'Qlbs://User/lists');
		$res ['class'] = '';
		$nav [] = $res;
		
		$res ['title'] = '配置';
		$res ['url'] = addons_url ( 'Qlbs://Qlbs/config');
		$res ['class'] = 'current';
		$nav [] = $res;
	
		$this->assign ( 'nav', $nav );
		$normal_tips= '百度Ak<a href="http://lbsyun.baidu.com/apiconsole/key" target="_blank">http://lbsyun.baidu.com/apiconsole/key</a>，具体操作请参考百度LBS云检索</br>本插件须要服务号认证才能使用';
		$this->assign ( 'normal_tips', $normal_tips );
		parent::config ( $this->model );
	}
	
	public function add() {
		$_POST['token'] = get_token();
		parent::common_add ( $this->model );
	}
	
	public function edit() {
		$_POST['token'] = get_token();
		parent::common_edit ( $this->model );
	}

	public function detail(){
		$this->assign('info',$_GET);
		$this->display();
	}
}
