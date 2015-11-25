<?php
namespace Addons\Qlbs\Controller;
use Home\Controller\AddonsController;

class UserController extends AddonsController{
	function _initialize() {
		$this->model = $this->getModel ( 'qlbs_user' );
	
		$res ['title'] = '百度LBS云';
		$res ['url'] = addons_url ( 'Qlbs://Qlbs/lists' );
		$res ['class'] = '';
		$nav [] = $res;
	
		$res ['title'] = '查看成员';
		$res ['url'] = addons_url ( 'Qlbs://User/lists');
		$res ['class'] = 'current';
		$nav [] = $res;
		
		$res ['title'] = '配置';
		$res ['url'] = addons_url ( 'Qlbs://Qlbs/config');
		$res ['class'] = '';
		$nav [] = $res;
	
		$this->assign ( 'nav', $nav );
	}
	public function lists() {
		$this->assign ( 'add_button', false );
		parent::common_lists ( $this->model );
	}
	
	public function del() {
		parent::common_del ( $this->model );
	}
}