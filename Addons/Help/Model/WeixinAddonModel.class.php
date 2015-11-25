<?php
        	
namespace Addons\Help\Model;
use Home\Model\WeixinModel;
        	
/**
 * Help的微信模型
 */
class WeixinAddonModel extends WeixinModel{
	function reply($dataArr, $keywordArr = array()) {
		$config = getAddonConfig ( 'Help' ); // 获取后台插件的配置参数	
		//$this->replyText(json_encode($config));
		if(!$config['help'])
			return false;
		$articles [0] = array (
					'Title' => '诺言@微信客服中心',
					'Description' => '客户体验中，那瞬间的美感离不开我们的态度！',
					'PicUrl' => SITE_URL.'/Addons/Help/View/default/Public/imgs/cs.png',
					//'Url' =>SITE_URL.'/addon/WeiSite/WeiSite/lists/cate_id/60.html'
					'Url' => addons_url('Inn://Book/cs')
			);
		$res = $this->replyNews ( $articles );
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
        	