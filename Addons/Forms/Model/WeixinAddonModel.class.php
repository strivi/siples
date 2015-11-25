<?php
        	
namespace Addons\Forms\Model;
use Home\Model\WeixinModel;
        	
/**
 * Forms的微信模型
 */
class WeixinAddonModel extends WeixinModel{
	function reply($dataArr, $keywordArr = array()) {
		$map['token'] = get_token();
		if (! empty ( $keywordArr ['aim_id'] )) {
			$map ['id'] = $keywordArr ['aim_id'];
		}
		
		$info = M ( 'forms' )->where ( $map )->order ( 'id desc' )->find ();
		if (! $info) {
			return false;
		}

		//组装用户在微信里点击图文的时跳转URL
		//其中token和openid这两个参数一定要传，否则程序不知道是哪个微信用户进入了系统
		$param ['forms_id'] = $info ['id'];
		//$param ['token'] = get_token ();
		//$param ['openid'] = get_openid ();
		$url = addons_url ( 'Forms://FormsValue/add', $param );
		
		//组装微信需要的图文数据，格式是固定的
		$articles [0] = array (
				'Title' => $info ['title'],
				'Description' => $info ['intro'],
				'PicUrl' => get_cover_url ( $info ['cover'] ),
				'Url' => $url
		);
		
		$res = $this->replyNews ( $articles );
		return $res;
	} 

	public function getCommonArticles($extra_int){
		
		$map ['token'] = get_token ();
		$extra_int && $map ['id'] = $extra_int;		
		$info = M ( 'Forms' )->where ( $map )->order('id desc')->select ();
		//$this->replyText(json_encode($info));
		if(!$info)
			return true;
		// 其中token和openid这两个参数一定要传，否则程序不知道是哪个微信用户进入了系统
		foreach($info as $key => $vo){
			$param ['forms_id'] = $vo ['id'];
			$url = addons_url ( 'Forms://FormsValue/add', $param );
			$articles [$key] = array (
				'Title' => $vo ['title'],
				'Description' => $vo ['intro'],
				'PicUrl' => get_cover_url ( $vo ['cover'] ),
				'Url' => $url			
			);
		}//foreach
		$this->replyNews ( $articles );
	}

	// 关注公众号事件
	public function subscribe() {
		$EventKey = substr($data['EventKey'],8);
		$extra_int = getExtraIntByEventKey($EventKey);
		if(!$extra_int)
			$this->reply();
		else
			$this->getCommonArticles($extra_int);
		return true;
	}
	
	// 取消关注公众号事件
	public function unsubscribe() {
		return true;
	}
	
	// 扫描带参数二维码事件
	public function scan() {
		$data = $this->getData ();
		//$this->replyText(json_encode($data));
		$EventKey = $data['EventKey'];
		$extra_int = getExtraIntByEventKey($EventKey);
		if(!$extra_int)
			$this->reply();
		else
			$this->getCommonArticles($extra_int);	
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
        	