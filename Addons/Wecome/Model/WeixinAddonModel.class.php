<?php

namespace Addons\Wecome\Model;

use Home\Model\WeixinModel;

/**
 * Vote模型
 */
class WeixinAddonModel extends WeixinModel {
	function reply($dataArr, $keywordArr = array()) {
		return true;
	}
	// 关注时的操作
	function subscribe($dataArr) {
		//-------------
		unset($map);unset($data);
		$config = getAddonConfig ( 'Wecome' ); // 获取后台插件的配置参数
		// 其中token和openid这两个参数一定要传，否则程序不知道是哪个微信用户进入了系统
		$param ['token'] = get_token ();
		$param ['openid'] = get_openid ();
		
		$sreach = array('[follow]', '[website]');
		$replace = array(addons_url('UserCenter://UserCenter/edit', $param), addons_url('WeiSite://WeiSite/index', $param));
		$config ['description'] = str_replace($sreach, $replace, $config ['description'] );
		
		//$this->replyText(json_encode($config));
		
		switch ($config ['type']) {
			case '4' ://多图文回复
				$map ['id'] = $config['mult_id'];
				$mult = M ( 'custom_reply_mult' )->where ( $map )->find ();
				$map_news ['id'] = array (
						'in',
						$mult ['mult_ids'] 
				);
				$list = M ( 'custom_reply_news' )->where ( $map_news )->order('sort asc')->select ();
								
				foreach ( $list as $k => $info ) {
					if ($k > 8)
						continue;
					$articles [] = array (
							'Title' => $info ['title'],
							'Description' => $info ['intro'],
							'PicUrl' => get_cover_url ( $info ['cover'] ),
							'Url' => $this->_getNewsUrl ( $info, $param ) 
					);
				}
				
				$res = $this->replyNews ( $articles );
				break;
			case '3' :
				$articles [0] = array (
						'Title' => $config ['title'],
						'Description' => $config ['description'],
						'PicUrl' => $config ['pic_url'],
						'Url' => str_replace($sreach, $replace, $config ['url'] )
				);
				$res = $this->replyNews ( $articles );
				break;
// 			case '2' :
// 				$media_id = 1;
// 				$res = $this->replyImage ( $media_id );
// 				break;
			default :
				$res = $this->replyText ( $config ['description'] );
		}
		return $res;
	}
	
	public function scan() {
        $this->replyText("Wecome");
	}
	
	function _getNewsUrl($info, $param) {
		if (! empty ( $info ['jump_url'] )) {
			$url = replace_url ( $info ['jump_url'] );
		} else {
			$param ['id'] = $info ['id'];
			$url = addons_url ( 'CustomReply://CustomReply/detail', $param );
		}
		return $url;
	}
}
