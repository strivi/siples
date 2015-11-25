<?php
        	
namespace Addons\WifiVerify\Model;
use Home\Model\WeixinModel;
        	
/**
 * WifiVerify的微信模型
 */
class WeixinAddonModel extends WeixinModel{
	function reply($dataArr, $keywordArr = array()) {
		$config = getAddonConfig ( 'WifiVerify' ); // 获取后台插件的配置参数	
		//dump($config);		
		$data ['create_time'] = time();
		$data['is_used'] = 0;
		$data['verifyCode'] = $this->randstr(4,'NUMBER');
		$result = M('wifi')->add($data);
		if($result){
			$articles [] = array (
						'Title' => "验证码（".$data['verifyCode']."）",
						'Description' => "♪ 确保已连接WiFi（OnesWord）\n♪ 点我上网哦！",
						'PicUrl' => SITE_URL.'/Addons/WifiVerify/View/default/Public/WIFI.png',
						//'Url'=>'http://portal.ikuai8.com/wechat/auth.php?code=2c4547754f1827eccc7706082366331d'
						'Url' => addons_url("WifiVerify://WifiVerify/OneKeyVerify")
			);
			//$articles [] = array (
			//			'Title' => "源自法兰西，微小旅馆第一品牌！",
			//			'Description' => "",
			//			'PicUrl' => 'http://mmbiz.qpic.cn/mmbiz/niaFFHMeLHVfB8B9UA5BVDVsqOIibicFElCj5jbzmpXuDJLrg5dPeP0UYH4aDUpNoFSd64lPgPRb1Bujs4yUYVPWw/640?tp=webp',
			//			'Url' => "http://mp.weixin.qq.com/s?__biz=MzA4ODc1MDMwMQ==&mid=206026261&idx=1&sn=55caa0c49737cca262eba35fdfd11db3#rd"
			//);		
			$res = $this->replyNews ( $articles );
			
		}else{
			$returnInfo = "验证码获取失败，请您联系官方客服或者重新获取验证码。";
			$res = $this->replyText ($returnInfo);
		}
			return $res;
	} 
		//随机产生六位数密码Begin
	public function randStr($len=4,$format='ALL') { 
		 switch($format) { 
		 case 'ALL':
		 $chars='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789'; break;
		 case 'CHAR':
		 $chars='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz-@#~'; break;
		 case 'NUMBER':
		 $chars='0123456789'; break;
		 default :
		 $chars='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789-@#~'; 
		 break;
		 }
		 mt_srand((double)microtime()*1000000*getmypid()); 
		 $password="";
		 while(strlen($password)<$len)
		    $password.=substr($chars,(mt_rand()%strlen($chars)),1);
		 return $password;
	 } 

	// 关注公众号事件
	public function subscribe() {
		$data = $this->getData ();
		//获取到EventKey
		$EventKey = substr($data['EventKey'],8);
		switch($EventKey){
			case 2:
				$this->reply();
				break;
			default:
				$this->replyText('很遗憾，WifiVerify无法处理该二维码，请您重新调整！');
				break;			
		}
		return true;
	}
	
	// 取消关注公众号事件
	public function unsubscribe() {
		return true;
	}
	
	// 扫描带参数二维码事件
	public function scan() {
		$data = $this->getData ();
		$EventKey = $data['EventKey'];
		switch($EventKey){
			case 2:
				$this->reply();
				break;
			default:
				$this->replyText('很遗憾，WifiVerify无法处理该二维码，请您重新调整！');
				break;
		}
		return true;
	}
	
	// 上报地理位置事件
	public function location() {
		return true;
	}
	
	// 自定义菜单事件
	public function click() {
		return true;
	}	
}
        	