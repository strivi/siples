<?php
        	
namespace Addons\Qlbs\Model;
use Home\Model\WeixinModel;
        	
/**
 * Qlbs的微信模型
 */
class WeixinAddonModel extends WeixinModel{
	function reply($dataArr, $keywordArr = array()) {
		$config = getAddonConfig ( 'Qlbs' ); // 获取后台插件的配置参数
		$keywordArr ['aim_id'] && $map ['id'] = $keywordArr ['aim_id'];
		$Ak = $config['random'];
		$data = M('qlbs')->where($map) ->find();

		$map_info['openid'] = $openid = $dataArr['FromUserName'];			
		$map_info['token'] =$token = get_token();		
		$data_user = M('qlbs_user')->where($map_info) ->find();
		if(!empty($data_user)){
			$data = array_merge($data,$data_user);

			//百度LBS云请求url
			$url = 'http://api.map.baidu.com/geosearch/v3/nearby?ak='.$Ak.'&geotable_id='.$data['geotable_id'].'&location='.$data['longitude'].','.$data['latitude'].'&radius='.$data['radius'].'&sortby='.$data['sortby'];	

			$urlobj = file_get_contents($url);//获取百度反馈的json
			$json = json_decode( $urlobj);
			$a = $json->contents[0]->address;
			$reply=array();
			$num = $json->total;
			//图片列表形式
			$articles [] = array (
						'Title' => '源自法兰西，微小旅馆第一品牌！',
						'Description' => '手动上报地理位置方法：<br/>1、点击菜单左侧小键盘<br/>2、点击[位置]，发送位置',
						'PicUrl' => SITE_URL.'/Addons/Qlbs/View/default/Public/imgs/onesword-nnyy.png',
						'Url' => SITE_URL.'/addon/CustomReply/CustomReply/detail/id/59.html'
				);
			for($i=0; $i < $num; $i++){
				unset($param);
				$param = array();
				$param['distance'] = $json->contents[$i]->distance;
				$param['title'] = $json->contents[$i]->title;
				$param['longitude'] = $json->contents[$i]->location[0];
				$param['latitude'] = $json->contents[$i]->location[1];
				$param['tel'] = $json->contents[$i]->tel;
				$param['address'] = $json->contents[$i]->address;
				$distance = (int)$json->contents[$i]->distance;
				if($distance > 1000){
					$distance = (int)($distance/1000);
					$articles [] = array (
							'Title' => '['.$distance.'公里] '.$json->contents[$i]->address,
							'Description' => '',
							'PicUrl' => SITE_URL.'/logo-flower.jpg',
							'Url' => addons_url ( 'Qlbs://Qlbs/detail',$param )
					);
				}else{
					$articles [] = array (
							'Title' => '['.$distance.'米] '.$json->contents[$i]->address,
							'Description' => '',
							'PicUrl' => SITE_URL.'/logo-flower.jpg',
							'Url' => addons_url ( 'Qlbs://Qlbs/detail',$param )
					);
				}
				
			}
			$res = $this->replyNews ( $articles );
		}
		else{
			$res = $this->replyText ('获取不到您的地理位置信息，请确保公众号可以获取到您的地理位置信息<br/>手动上报地理位置方法:<br/>1/点击菜单左侧小键盘<br/>2/点击[位置],发送位置.' );
		}
		return $res;
	} 
	
	// 扫描带参数二维码事件
	public function scan($dataArr) {
		return true;
	}

	public function subscribe($dataArr) {
		return true;
	}
	
	// 上报地理位置事件
	public function location($dataArr) {
		$model = 'qlbs_user';
		switch($dataArr['MsgType']){
			case 'location':
				$latitude = $dataArr ['Location_X'];
				$longitude = $dataArr ['Location_Y'];
				$openid = $dataArr['FromUserName'];
				$precision = $dataArr['Precision'];
				$this->save_lbs($latitude,$longitude,$openid,$precision);//保存
				$res = $this->replyText ( '地理位置上报成功,请点击菜单[预定]->[附近诺言]' );
			break;
			case 'event':
				$latitude = $dataArr ['Latitude'];
				$longitude = $dataArr ['Longitude'];
				$openid = $dataArr['FromUserName'];
				$precision = $dataArr['Precision'];
				$this->save_lbs($latitude,$longitude,$openid,$precision);//保存
			break;
			default:
			break;
		}		

	}
	//click事件
	public function click() {
		return true;
	}
		/**
	 * @剑煮红颜 保存LBS信息
	 * @param  $lat    纬度
	 * @param  $long  经度
	 * @param  $openid openid
	 * @param  $precision    精确度
	 * @return boolean
	 */
	public function save_lbs($lat,$long,$openid,$precision = NULL){
		$map['token']=$info['token']=get_token();
		$info['latitude']=$lat;
		$info['longitude']=$long;
		$map['openid']=$info['openid']=$openid;
		$info['createtime'] = time();
		$data =M('qlbs_user')->where($map) ->find();
		//addWeixinLog('data',$data['request_times']);
		if(!empty($data)){
			$info['request_times'] = $data['request_times'] +1;
			M('qlbs_user') ->where($map)->save($info);
			return true;
		}
		else{
			$info['request_times'] = 1;
			M('qlbs_user')->add($info);
			return true;
		}
	}

}
        	