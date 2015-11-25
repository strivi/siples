<?php
        	
namespace Addons\Qrcode\Model;
use Home\Model\WeixinModel;
        	
/**
 * Qrcode的微信模型
 */
class WeixinAddonModel extends WeixinModel{
	function reply($dataArr, $keywordArr = array()) {
		$config = getAddonConfig ( 'Qrcode' ); // 获取后台插件的配置参数	
		$this->replyText ( 'Qrcode回复您，万事如意！' );
	} 

	// 关注公众号事件
	public function subscribe() {
		$data = $this->getData ();
		//存储Follow信息
        $scene_id = substr($data['EventKey'],8);
        switch($scene_id){
	        case 0:
	        	$addon = 'Wecome';
	        	break;
	       // case ($scene_id > C('SCRATCH_SCENE_BEGIN') && $scene_id < C('SCRATCH_SCENE_END'))://邀请关注
	       // 	$addon = 'Scratch';
	        //	break;
	        default :
	        	if($scene_id >100000){//
		        	$map['scene_id'] = (int)$scene_id%100000;
	        	}else{
		        	$map['scene_id'] = $scene_id;
	        	}
		        M('QrCode')->where($map)->setInc('request_count');//请求次数+1
		        //屏蔽重复关注
		        $map_follow['openid'] = $data['FromUserName'];
				$follow = M('Follow')->where($map_follow)->find();
				if(!$follow)
		        	M('QrCode')->where($map)->setInc('subscribe_count');//关注次数+1
		        $addon = M('QrCode')->where($map)->getField('addon');
	        	break;    	
        }
		//避免循环
		if($addon && $addon!='Qrcode'){     
			require_once ONETHINK_ADDON_PATH . $addon . '/Model/WeixinAddonModel.class.php';
			$model = D ( 'Addons://' . $addon . '/WeixinAddon' );
			! method_exists ( $model, 'subscribe' ) || $model->subscribe ( $data );
		}
//		$this->replyText ( '你关注的是id为【'.$data['EventKey'].'】的二维码' );
//		$this->replyText('無法式，不诺言！');
//		$this->replyText(json_encode($data));

		set_follow_info($data);//增加关注信息
        return true;
	}
	
	// 取消关注公众号事件
	public function unsubscribe() {
		return true;
	}
	
	// 扫描带参数二维码事件
	public function scan() {
	    $data = $this->getData ();	    
        $map['scene_id'] = $data['EventKey'];
        M('QrCode')->where($map)->setInc('request_count');//请求次数+1  
        //$addon = M('QrCode')->where($map)->getField('addon');
        $result = M('QrCode')->where($map)->find();
        $addon = $result['addon'];
        //$this->data['aim_id'] = $result['extra_int'];
        
   		if($addon && $addon!='Qrcode'){//避免死循环     
	        require_once ONETHINK_ADDON_PATH . $addon . '/Model/WeixinAddonModel.class.php';
			$model = D ( 'Addons://' . $addon . '/WeixinAddon' );
			! method_exists ( $model, 'scan' ) || $model->scan ();
        }
		$this->replyText ( '你扫描的是id为【'.$data['EventKey'].'】的二维码' );
//		$this->replyText('無法式，不诺言！');
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
        	