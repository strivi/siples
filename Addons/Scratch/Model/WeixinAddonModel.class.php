<?php

namespace Addons\Scratch\Model;

use Home\Model\WeixinModel;

/**
 * Scratch的微信模型
 */
class WeixinAddonModel extends WeixinModel {
	function reply($dataArr, $keywordArr = array()) {
		$map ['token'] = get_token ();
		$keywordArr ['aim_id'] && $map ['id'] = $keywordArr ['aim_id'];
		//if(!$keywordArr ['aim_id'])
		$map ['open'] = true;
		//$this->replyText(json_encode($map));
		$data = M ( 'scratch' )->where ( $map )->order('id desc')->select ();
		// 其中token和openid这两个参数一定要传，否则程序不知道是哪个微信用户进入了系统
		//$param ['token'] = get_token ();
		//$param ['openid'] = get_openid ();
		foreach($data as $key => $vo){
			$param ['id'] = $vo ['id'];
			$url = addons_url ( 'Scratch://Scratch/show', $param );
			$articles [$key] = array (
				'Title' => $vo ['title'],
				'Url' => $url 
			);
			$now = time ();
			if ($vo ['end_time'] > $now) {
				$articles [$key] ['Description'] = $vo ['intro'];
				$articles [$key] ['PicUrl'] = ! empty ( $vo ['cover'] ) ? get_cover_url ( $vo ['cover'] ) : SITE_URL . '/Addons/Scratch/View/default/Public/cover_pic.jpg';
			} else {
				$articles [$key] ['Description'] = $vo ['end_tips'];
				$articles [$key] ['PicUrl'] = ! empty ( $vo ['end_cover'] ) ? get_cover_url ( $vo ['end_cover'] ) : SITE_URL . '/Addons/Scratch/View/default/Public/cover_pic_over.png';
			}
		}//foreach
		if($articles)
			$this->replyNews ( $articles );
		else
			$this->replyText('Sorry，当前无抽奖活动！');
	}
	
	public function getCommonArticles($extra_int){
		$map ['token'] = get_token ();
		$extra_int && $map ['id'] = $extra_int;		
		$data = M ( 'scratch' )->where ( $map )->order('id desc')->select ();
		if(!$data)
			return true;
		// 其中token和openid这两个参数一定要传，否则程序不知道是哪个微信用户进入了系统
		//$param ['token'] = get_token ();
		//$param ['openid'] = get_openid ();
		foreach($data as $key => $vo){
			$param ['id'] = $vo ['id'];
			$url = addons_url ( 'Scratch://Scratch/show', $param );
			$articles [$key] = array (
				'Title' => $vo ['title'],
				'Url' => $url 
			);
			$now = time ();
			if ($vo ['end_time'] > $now) {
				$articles [$key] ['Description'] = $vo ['intro'];
				$articles [$key] ['PicUrl'] = ! empty ( $vo ['cover'] ) ? get_cover_url ( $vo ['cover'] ) : SITE_URL . '/Addons/Scratch/View/default/Public/cover_pic.jpg';
			} else {
				$articles [$key] ['Description'] = $vo ['end_tips'];
				$articles [$key] ['PicUrl'] = ! empty ( $vo ['end_cover'] ) ? get_cover_url ( $vo ['end_cover'] ) : SITE_URL . '/Addons/Scratch/View/default/Public/cover_pic_over.png';
			}
		}//foreach
		$this->replyNews ( $articles );
	}
	
	// 关注公众号事件
	public function subscribe() {
		$data = $this->getData ();
		//获取到EventKey
		$EventKey = substr($data['EventKey'],8);
		switch($EventKey){
			case ($EventKey > 100000):
				$return = set_sence_scratch($data);//场景数据库修改
				if(!$return){
					$this->replyText('SORRY，您已经关注过诺言微信公众号，重复关注不能增加邀请方的邀请小伙伴的个数！/n回复【刮刮卡1期】参与抽奖活动！');	
				}
				else{
					$common_articles = $this->getCommonArticles();
					$this->replyNews ($common_articles);	
				}
				break;	
			default:
				$extra_int = getExtraIntByEventKey($EventKey);
				if(!$extra_int)
					$this->reply();
				else
					$this->getCommonArticles($extra_int);	
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
        	