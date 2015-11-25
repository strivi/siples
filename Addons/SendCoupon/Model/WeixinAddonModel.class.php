<?php
        	
namespace Addons\SendCoupon\Model;
use Home\Model\WeixinModel;
        	
/**
 * SendCoupon的微信模型
 */
class WeixinAddonModel extends WeixinModel{
	function reply($dataArr, $keywordArr = array()) {
		$config = getAddonConfig ( 'SendCoupon' ); // 获取后台插件的配置参数	
		//dump($config);
		$map ['token'] = get_token ();
		$keywordArr ['aim_id'] && $map ['id'] = $keywordArr ['aim_id'];
		$data = M ( 'Sendcoupon' )->where ( $map )->order('id desc')->select ();
		foreach($data as $key => $vo){
			$param ['id'] = $vo ['id'];
			$url = addons_url ( 'SendCoupon://SendCoupon/index', $param );
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
			$this->replyText('Sorry，当前无红包活动！');

	} 

	// 关注公众号事件
	public function subscribe() {
		return true;
	}
	
	// 取消关注公众号事件
	public function unsubscribe() {
		return true;
	}
	
	// 扫描带参数二维码事件
	public function scan() {
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
        	