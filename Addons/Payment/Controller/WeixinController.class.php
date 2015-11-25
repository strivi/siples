<?php
namespace Addons\Payment\Controller;
use Home\Controller\AddonsController;

class WeixinController extends AddonsController{
	public $token;
	public $wecha_id;
	public $payConfig;
	public function __construct(){
		
		parent::__construct ();
		
		$this->token = get_token();
		$this->wecha_id	= get_openid();
		//读取配置
		$pay_config_db=M('payment_set');
		$this->payConfig=$pay_config_db->where(array('token'=>$this->token))->find();
	}
	public function pay(){
		require_once ("Weixinpay/CommonUtil.class.php");
		require_once ("Weixinpay/WxPayHelper.class.php");
		
		$commonUtil = new CommonUtil();
		//before
		$orderid=$_GET['orderid'];		
		if($orderid == ""){
			$orderid = $_GET['single_orderid'];
		}	
		$price=$_GET['price'];
		
		$wxPayHelper = new WxPayHelper($this->payConfig['wxappid'],$this->payConfig['wxpaysignkey'],$this->payConfig['wxpartnerkey']);

		$wxPayHelper->setParameter("bank_type", "WX");
		$wxPayHelper->setParameter("body", $orderid);
		$wxPayHelper->setParameter("partner", $this->payConfig['wxpartnerid']);
		$wxPayHelper->setParameter("out_trade_no",$orderid);
		$wxPayHelper->setParameter("total_fee", $price*100);
		$wxPayHelper->setParameter("fee_type", "1");
		
		//页面跳转同步通知页面路径
		$return_url = addons_url('Payment://Weixin/return_url',array("token"=>$_GET['token'],"wecha_id"=>$_GET['wecha_id'],"from"=>$_GET['from']));
		$wxPayHelper->setParameter("notify_url", $return_url);
		
		$wxPayHelper->setParameter("spbill_create_ip", $_SERVER['REMOTE_ADDR']);
		$wxPayHelper->setParameter("input_charset", "GBK");
		$url=$wxPayHelper->create_biz_package();
		$this->assign('url',$url);
		//
		$from=$_GET['from'];
		$from=$from?$from:'Groupon';
		$from=$from!='groupon'?$from:'Groupon';
		switch ($from){
			default:
			case 'Groupon':
				break;
		}
		$csspath = ADDON_PUBLIC_PATH."/hotels.css";
		echo '<html><head><meta http-equiv="Content-Type"content="text/html; charset=UTF-8"><meta name="viewport"content="width=device-width,height=device-height,inital-scale=1.0,maximum-scale=1.0,user-scalable=no;"><meta name="apple-mobile-web-app-capable"content="yes"><meta name="apple-mobile-web-app-status-bar-style"content="black"><meta name="format-detection"content="telephone=no"><link href="'.$csspath.'"rel="stylesheet"type="text/css"><title>微信支付</title></head><script language="javascript">function callpay(){WeixinJSBridge.invoke(\'getBrandWCPayRequest\','.$url.',function(res){WeixinJSBridge.log(res.err_msg);if(res.err_msg==\'get_brand_wcpay_request:ok\'){document.getElementById(\'payDom\').style.display=\'none\';document.getElementById(\'successDom\').style.display=\'\';setTimeout("window.location.href = \''.$returnUrl.'\'",2000);}else{document.getElementById(\'payDom\').style.display=\'none\';document.getElementById(\'failDom\').style.display=\'\';document.getElementById(\'failRt\').innerHTML=res.err_code+\'|\'+res.err_desc+\'|\'+res.err_msg;}});}</script><body style="padding-top:20px;"><style>.deploy_ctype_tip{z-index:1001;width:100%;text-align:center;position:fixed;top:50%;margin-top:-23px;left:0;}.deploy_ctype_tip p{display:inline-block;padding:13px 24px;border:solid#d6d482 1px;background:#f5f4c5;font-size:16px;color:#8f772f;line-height:18px;border-radius:3px;}</style><div id="payDom"class="cardexplain"><ul class="round"><li class="title mb"><span class="none">支付信息</span></li><li class="nob"><table width="100%"border="0"cellspacing="0"cellpadding="0"class="kuang"><tr><th>金额</th><td>'.$price.'元</td></tr></table></li></ul><div class="footReturn"style="text-align:center"><input type="button"style="margin:0 auto 20px auto;width:100%"onclick="callpay()"class="submit"value="点击进行微信支付"/></div></div><div id="failDom"style="display:none"class="cardexplain"><ul class="round"><li class="title mb"><span class="none">支付结果</span></li><li class="nob"><table width="100%"border="0"cellspacing="0"cellpadding="0"class="kuang"><tr><th>支付失败</th><td><div id="failRt"></div></td></tr></table></li></ul><div class="footReturn"style="text-align:center"><input type="button"style="margin:0 auto 20px auto;width:100%"onclick="callpay()"class="submit"value="重新进行支付"/></div></div><div id="successDom"style="display:none"class="cardexplain"><ul class="round"><li class="title mb"><span class="none">支付成功</span></li><li class="nob"><table width="100%"border="0"cellspacing="0"cellpadding="0"class="kuang"><tr><th>您已支付成功，页面正在跳转...</td></tr></table><div id="failRt"></div></td></tr></table></li></ul></div></body></html>';
	}
	//同步数据处理
	public function return_url (){
		S('pay',$_GET);
		$out_trade_no = $this->_get('out_trade_no');
		if(intval($_GET['total_fee'])&&!intval($_GET['trade_state'])) {
			$okurl = addons_url(base64_decode($_GET['from']),array("token"=>$_GET['token'],"wecha_id"=>$_GET['wecha_id'],"orderid"=>$out_trade_no));
			redirect($okurl);
		}else {
			exit('付款失败');
		}
	}
	public function notify_url(){
		echo "success"; 
		exit();
	}
	function api_notice_increment($url, $data){
		$ch = curl_init();
		$header = "Accept-Charset: utf-8";
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($url, CURLOPT_HTTPHEADER, $header);
		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$tmpInfo = curl_exec($ch);
		$errorno=curl_errno($ch);
		if ($errorno) {
			return array('rt'=>false,'errorno'=>$errorno);
		}else{
			$js=json_decode($tmpInfo,1);
			if ($js['errcode']=='0'){
				return array('rt'=>true,'errorno'=>0);
			}else {
				$this->error('发生错误：错误代码'.$js['errcode'].',微信返回错误信息：'.$js['errmsg']);
			}
		}
	}
}
?>