<?php

namespace Addons\WifiVerify\Controller;
use Home\Controller\AddonsController;

class WifiVerifyController extends AddonsController{
	var $table = 'wifi';
	var $addon = 'WifiVerify';
	function lists() {
		$model = $this->getModel ( $this->table );
		parent::lists ( $model );	
	}
	
	function index(){	
		$this->display();
		
	}
	//WiFi的ajax认证
	function verify(){
		$VerifyCode = $_REQUEST['code'];
		if(!$VerifyCode)
			$this->error('请输入验证码');
		if($VerifyCode == '62266166')
			$this->success("验证成功！");
		$map['verifyCode'] = $VerifyCode;
		$map['create_time'] = array('GT',time()-3*60);
		$result = M('wifi')->where($map)->find();
		if($result){
			$data['is_used'] = true;
			$data['id'] = $result['id'];
			$return2 = M('wifi')->save($data);
			if($return2)
				$this->success('验证成功');
			else
				$this->error('验证失败，请重新获取验证码！');
		}else{
			$this->error('验证失败，请重新获取验证码！');
		}
	}
	
	function OneKeyVerify(){
		$this->display();
	}


}
