<?php

namespace Addons\SendCoupon\Controller;
use Home\Controller\AddonsController;


class SendCouponController extends AddonsController{
	function index(){
		$id = $_GET['id'];
		$map['id'] = $id;
		$coupon = M('Sendcoupon')->where($map)->find();
		$this->coupon = $coupon;
		$this->display();
	}
	
	function SendCoupon(){
		$id = $_POST['id'];
		$map['id'] = $id;
		$return = M('Sendcoupon')->where($map)->setInc('serial',1);
		$coupon = M('Sendcoupon')->where($map)->find();
		$TmplPay = A('Addons://Payment/WeixinV3');
		$return = $TmplPay->sendCoupon($coupon['coupon_stock_id'],$coupon['serial']);
		if($return['return_code'] == "SUCCESS"){
			if($return['result_code' != 'SUCCESS']){
				$this->error("领取失败",'',$return);
			}else{
				$this->success("领取成功",'',$return);				
			}
		}
		else
			$this->error("领取失败",'',$return);
	}

}
