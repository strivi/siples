<?php

namespace Addons\Sendredpack\Controller;
use Home\Controller\AddonsController;

class SendredpackController extends AddonsController{
	
	//红包管理页面
	function index(){
		$map['id'] = $_GET['id'];
		$redpack = M('sendredpack')->where($map)->find();
		if($redpack['sta_time'] > time())
			$this->error('活动未开始！');
		if($redpack['end_time'] < time())
			$this->error("活动已结束！");
		$this->redpack = $redpack;
		$this->display();
	}
	
	function sendRedpack(){
		$sendredpack_id = $_REQUEST['id'];
		$redpack = M('sendredpack')->where('id = '.$sendredpack_id)->find();
		if($redpack['sta_time'] > time())
			$this->error('活动未开始！');
		if($redpack['end_time'] < time())
			$this->error("活动已结束！");
		
		$map['sendredpack_id'] = $sendredpack_id;
		$map['openid'] = get_openid();
		$count = M('sendredpack_member')->where($map)->count();
		
		if($count >= $redpack['count'])
			$this->error("Sorry,红包领取次数已经没有咯！");
		$amount = rand($redpack['min_value'],$redpack['max_value']);
		//检测额度是否已经超额
		
		$amount_hav =  M('sendredpack_member')->where($map)->sum("amount");
		
		if(($amount + $amount_hav) > $redpack['total_amount']){
			$this->error("Sorry,红包已发完咯！");			
		}
		
		$data['openid'] = get_openid();
		$data['sendredpack_id'] = $sendredpack_id;
		$data['create_time'] = time();
		$data['amount'] = $amount;
		$result = M('sendredpack_member')->add($data);
		if(!$result)	
			$this->error("红包领取失败！");
		
		$TmplPay = A('Addons://Payment/WeixinV3');
		$return = $TmplPay->sendredpack($amount*100,$redpack['wishing']);
		if($return['return_code'] == "SUCCESS")
			$this->success("红包领取成功，赶紧去打开红包啦！",'',$return);
		else
			$this->error("红包领取失败",'',$return);	
	}
	
	function test(){
		$param['touser'] = "o3ZYauOnS_g-qQ9bYISisG2MLfvE";
		$param['msgtype'] = "text";
		$param['text']['content'] = "Hello World!";
		$param['customservice']['kf_account'] = "zbyy@nyfslg";
		$param_json = json_encode($param);
		dump($param_json);
		$token = get_token();
		$access_token = get_access_token($token);
		$url = "https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=".$access_token;
		$return = http_post($url,$param_json);
		dump($return);
	}
}
