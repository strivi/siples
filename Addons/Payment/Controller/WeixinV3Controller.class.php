<?php
namespace Addons\Payment\Controller;
use Home\Controller\AddonsController;

class WeixinV3Controller extends AddonsController{
	public $token;
	public $wecha_id;
	public $payConfig;
	public function __construct(){
		parent::__construct ();
		$this->token = get_token();
		$this->wecha_id= get_openid();
		//读取配置
		$pay_config_db=M('payment_set');
		$this->payConfig=$pay_config_db->where(array('token'=>$this->token))->find();
	}
	//微信支付
	public function pay(){
		require_once ("WeixinpayV3/WxPayPubHelper.class.php");
		//使用jsapi接口
		$jsApi = new JsApi_pub($this->payConfig['wxappid'],$this->payConfig['wxmchid'],$this->payConfig['wxv3key'],$this->payConfig['wxv3appsecret']);
		//获取订单信息		
		$orderid=$_GET['orderid'];		
		if($orderid == ""){
			$orderid = $_GET['single_orderid'];
		}	
		$price= $_GET['price'];
		$body = $orderid;
		if(isset($_GET["sbody"])){
			$body = $_GET["sbody"];
		}
		//=========步骤1：网页授权获取用户openid============
		//通过code获得openid
		if (!isset($_GET['code']))
		{
			//$config_M = getAddonConfig('Payment'); // 获取后台插件的配置参数
			//触发微信返回code码
			$geturl = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'];
			$url = $jsApi->createOauthUrlForCode(urlencode($geturl));
			Header("Location: $url"); 
		}else
		{
			//获取code码，以获取openid
			$code = $_GET['code'];
			$jsApi->setCode($code);
			$openid = $jsApi->getOpenId();
		}
		
		//=========步骤1：使用统一支付接口，获取prepay_id============
		//使用统一支付接口
		$unifiedOrder = new UnifiedOrder_pub($this->payConfig['wxappid'],$this->payConfig['wxmchid'],$this->payConfig['wxv3key'],$this->payConfig['wxv3appsecret']);
		
		$unifiedOrder->setParameter("openid",$openid);//商品描述
		$unifiedOrder->setParameter("body",$orderid);//商品描述
		//自定义订单号，此处仅作举例
		$unifiedOrder->setParameter("out_trade_no",$orderid);//商户订单号
		$unifiedOrder->setParameter("total_fee",$price*100);//总金额，单位为分
		//可能需要授权
		//$return_url = addons_url('Payment://WeixinV3/return_url');
		$return_url = "http://www.onesword.cn/addon/Payment/WeixinV3/return_url.html";
		$unifiedOrder->setParameter("notify_url",$return_url);//通知地址
		$unifiedOrder->setParameter("trade_type","JSAPI");//交易类型
		
		$attach = json_decode($_GET['attach'],true);
		$unifiedOrder->setParameter('goods_tag',$attach['goods_tag']);//商品标记
		$unifiedOrder->setParameter("attach",json_encode($attach));//附加数据
		$prepay_id = $unifiedOrder->getPrepayId();
		
		//=========步骤2：使用jsapi调起支付============
		$jsApi->setPrepayId($prepay_id);
		$jsApiParameters = $jsApi->getParameters();
		$this->assign('jsApiParameters',$jsApiParameters);
		$this->assign('price',$_GET['price']);
		$this->assign('redirect_url',get_redirect_url());
		$this->display();
	}

	//同步数据处理测试	
	//集中处理中心，要对订单状态进行保存。
	//同步数据处理测试	
	//集中处理中心，要对订单状态进行保存。
	public function return_url(){
		require_once ("WeixinpayV3/WxPayPubHelper.class.php");
		//读取配置
		$pay_config_db=M('payment_set');
		$this->payConfig=$pay_config_db->where(array('token'=>$this->token))->find();
		$InnConfig = getAddonConfig ( 'Inn' );
		//使用通用通知接口
		$notify = new Notify_pub($this->payConfig['wxappid'],$this->payConfig['wxmchid'],$this->payConfig['wxv3key'],$this->payConfig['wxv3appsecret']);
		//存储微信的回调
		$xml = $GLOBALS['HTTP_RAW_POST_DATA'];
		
		$dataTemp['content'] = $xml;
		M('notify')->add($dataTemp);
			
		$notify->saveData($xml);
		//验证签名，并回应微信。
		//对后台通知交互时，如果微信收到商户的应答不是成功或超时，微信认为通知失败，
		//微信会通过一定的策略（如30分钟共8次）定期重新发起通知，
		//尽可能提高通知的成功率，但微信不保证通知最终能成功。
		if($notify->checkSign() == FALSE){
			$notify->setReturnParameter("return_code","FAIL");//返回状态码
			$notify->setReturnParameter("return_msg","签名失败");//返回信息
		}else{
			$notify->setReturnParameter("return_code","SUCCESS");//设置返回码
		}
		//$returnXml = $notify->returnXml();
		//echo $returnXml;
		//==商户根据实际情况设置相应的处理流程，此处仅作举例=======
		//记录回调信息
		//var_dump($notify->data);
		$attach = json_decode($notify->data['attach'],true);
		$Action = A('Addons://'.$attach['addon'].'/PayReturn');
		$Action->$attach['method']($notify,$attach);			
	}
	
	//待定
	public function notify_url(){
		echo "success"; 
		exit();
	}
	//待定
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
	
	//微信告警通知
	function warning(){
		
	}

	/**
	* 微信商户发放红包
	* input  amount：红包金额；mch_billno商户订单号
	* @author 梅枭雄 <strivi@vip.qq.com>
	*/
	function sendredpack($amount = 100, $wishing, $act_name = NULL, $mch_billno = NULL,$remark="备注"){
		require_once ("WeixinpayV3/WxPayPubHelper.class.php");
		$SendRedpack_pub = new SendRedpack_pub($this->payConfig['wxappid'],$this->payConfig['wxmchid'],$this->payConfig['wxv3key'],$this->payConfig['wxv3appsecret']);
		$mch_billno = $mch_billno ? $mch_billno : $this->payConfig['wxmchid'].date('Ymd',time()).time();
		$wishing = $wishing ? $wishing : "感谢您参加".C('WEB_SITE_TITLE')."的活动！";
		$act_name = $act_name ? $act_name : C('WEB_SITE_TITLE')."活动";
		$SendRedpack_pub->setParameter('mch_billno',$mch_billno);
		$SendRedpack_pub->setParameter('nick_name',C('WEB_SITE_TITLE'));
		$SendRedpack_pub->setParameter('send_name',C('WEB_SITE_TITLE'));
		$SendRedpack_pub->setParameter('total_amount',$amount);
		$SendRedpack_pub->setParameter('min_value',$amount);
		$SendRedpack_pub->setParameter('max_value',$amount);
		$SendRedpack_pub->setParameter('total_num',1);
		$SendRedpack_pub->setParameter('wishing',$wishing);
		$SendRedpack_pub->setParameter('act_name',$act_name);
		$SendRedpack_pub->setParameter('remark',$remark);
//		$SendRedpack_pub->setParameter('logo_imgurl',"https://wx.gtimg.com/mch/img/ico-logo.png");
//		$SendRedpack_pub->setParameter('share_content', "快来参加灯谜活动");
//		$SendRedpack_pub->setParameter('share_url',"http://www.onesword.cn");
//		$SendRedpack_pub->setParameter('share_imgurl',"https://wx.gtimg.com/mch/img/ico-logo.png");
		$postXml = $SendRedpack_pub->postXmlSSL();
		$postArray = $SendRedpack_pub->xmlToArray($postXml);
		return $postArray;
	}	
	
	/**
	* 微信商户发放现金抵用券
	* input  amount：红包金额；mch_billno商户订单号
	* @author 梅枭雄 <strivi@vip.qq.com>
	*/
	function sendCoupon($coupon_stock_id,$serial){
		require_once ("WeixinpayV3/WxPayPubHelper.class.php");
		$SendCoupon_pub = new SendCoupon_pub($this->payConfig['wxappid'],$this->payConfig['wxmchid'],$this->payConfig['wxv3key'],$this->payConfig['wxv3appsecret']);
		$partner_trade_no = $this->payConfig['wxmchid'].date('Ymd',time()).$serial;
		$SendCoupon_pub->setParameter('partner_trade_no',$partner_trade_no);
		$SendCoupon_pub->setParameter('coupon_stock_id',$coupon_stock_id);
		$SendCoupon_pub->setParameter('openid_count',1);
		$postXml = $SendCoupon_pub->postXmlSSL();
		$postArray = $SendCoupon_pub->xmlToArray($postXml);
		return $postArray;
	}
}
?>