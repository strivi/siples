<?php

namespace Addons\Scratch\Controller;

use Home\Controller\AddonsController;


class ScratchController extends AddonsController {

	function _initialize() {
		parent::_initialize();
		
		
		$controller = strtolower ( _CONTROLLER );
		$res ['title'] = '刮刮卡';
		$res ['url'] = addons_url ( 'Scratch://Scratch/lists' );
		$res ['class'] = $controller == 'scratch' ? 'current' : '';
		$nav [] = $res;
		$this->assign ( 'nav', $nav );
	}


	function edit() {
		$id = I ( 'id' );
		$model = $this->getModel ();	
		if (IS_POST) {
			$Model = D ( parse_name ( get_table_name ( $model ['id'] ), 1 ) );
			// 获取模型的字段信息
			$Model = $this->checkAttr ( $Model, $model ['id'] );
			if ($Model->create () && $Model->save ()) {
				$this->_saveKeyword ( $model, $id );
				
				$this->success ( '保存' . $model ['title'] . '成功！', U ( 'lists?model=' . $model ['name'] ) );
			} else {
				$this->error ( $Model->getError () );
			}
		} else {
			$fields = get_model_attribute ( $model ['id'] );
			
			// 获取数据
			$data = M ( get_table_name ( $model ['id'] ) )->find ( $id );
			$data || $this->error ( '数据不存在！' );
			
		$token = get_token ();
		if (isset ( $data ['token'] ) && $token != $data ['token'] && defined ( 'ADDON_PUBLIC_PATH' )) {
			$this->error ( '非法访问！' );
		}			
			
			$this->assign ( 'fields', $fields );
			$this->assign ( 'data', $data );
			$this->meta_title = '编辑' . $model ['title'];
			
			$this->_deal_data ();
			
			$this->display ();
		}
	}
	
	function edit_res() {
		$id = I ( 'target_id' );
		$model_id = 175;
		$model = $this->getModel ($model_id);
		if (IS_POST) {
			$_POST['token'] = get_token ();
			$Model = D ( parse_name ( get_table_name ( $model_id ), 1 ) );
			// 获取模型的字段信息
			$Model = $this->checkAttr ( $Model, $model_id );
			if ($Model->create ()) {
				if($_POST['id']) {
					if($Model->save ()) {
						
					} else {
						$this->error ( $Model->getError () );
					}
				} else {
					if($Model->add ()) {
						
					} else {
						$this->error ( $Model->getError () );
					}
				}
				$this->success ( '设置' . $model ['title'] . '成功！', U ( 'lists?model=' . $model ['name'] ) );
			} else {
				$this->error ( $Model->getError () );
			}
		} else {
			$fields = get_model_attribute ( $model_id );
			
			// 获取数据
			$map['target_id'] = $id;
			$data = M ( get_table_name ( $model_id ) )->where($map)->find ();
			
			if($data) {
				$token = get_token ();
				if (isset ( $data ['token'] ) && $token != $data ['token'] && defined ( 'ADDON_PUBLIC_PATH' )) {
					$this->error ( '非法访问！' );
				}	
			} else {
				$data['target_id'] = $id;
			}
			
			$this->assign ( 'post_url', $id );
			$this->assign ( 'fields', $fields );
			$this->assign ( 'data', $data );
			$this->meta_title = '编辑' . $model ['title'];
			
			$this->_deal_data ();
			
			$this->display ('edit');
		}
	}
	
	function add() {
		$model = $this->getModel ();
		if (IS_POST) {
			$Model = D ( parse_name ( get_table_name ( $model ['id'] ), 1 ) );
			// 获取模型的字段信息
			$Model = $this->checkAttr ( $Model, $model ['id'] );
			if ($Model->create () && $id = $Model->add ()) {
				$this->_saveKeyword ( $model, $id );
				
				$this->success ( '添加' . $model ['title'] . '成功！', U ( 'lists?model=' . $model ['name'] ) );
			} else {
				$this->error ( $Model->getError () );
			}
		} else {
			$fields = get_model_attribute ( $model ['id'] );
			$this->assign ( 'fields', $fields );
			$this->meta_title = '新增' . $model ['title'];
			$this->_deal_data ();
			$this->display ();
		}
	}
	
	// 增加或者编辑时公共部分
	function _deal_data() {
//		$normal_tips = '插件场景限制参数说明：格式：[插件名:id],如<br/>
//				[投票:10]，表示对ID为10的投票投完对能领取<br/>
//				[投票:*]，表示只要投过票就可以领取<br/>
//				[微调研:15]，表示完成ID为15的调研就能领取<br/>
//				[微考试:10]，表示完成ID为10的考试就能领取<br/>';
//		$this->assign ( 'normal_tips', $normal_tips );
	}
	
	/**
	 *   清空数据
	 *1、清空参与人
	 *2、清空中奖记录
	 */	
	function cleandata(){
		$target_id = I('target_id');
		$map['target_id'] = $target_id;
		$return = M('SnCode')->where($map)->delete();
		$return = M('ScratchMember')->where($map)->delete();
		$this->success('数据已清空');	
	}
	
	
	function preview() {
		var_dump(urlencode("http://www.onesword.cn/addon/Scratch/Scratch/show/id/1.html"));
		$this->show ();
	}
	
	function loading() {
		$this->display ( 'loading' );
	}
	
	
	//获取临时TICKET
	function  getTempTicket(){ 
			$scene_id = $_GET['scene_id'];
			$token = $_GET['token'];
			if(!$_GET['scene_id'])
				$this->error("场景ID错误");	
			if(!$_GET['token'])
				$this->error("token错误");
			$access_token = get_access_token($token);	
			$postData['action_name'] = 'QR_SCENE';
			$postDataTemp['scene_id'] = $scene_id*100000+8;
			$postData['action_info']['scene'] = $postDataTemp;
			$postData['expire_seconds'] = 1800;
			$postJson = json_encode($postData);
			$postUrl = "https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=$access_token";
			$ticket = json_decode(http_post($postUrl,$postJson),true);
			$this->success($ticket['ticket']);
		}
	
	function unsetSession(){
		unset($_SESSION);
	}
	
	//奖品兑换
	function exchange(){
		//获取个人中奖信息
		$target_id = I ( 'id' );
		$openId = get_openid();
		$token = get_token();
		$userInfo = getWeixinUserInfo($openId,$token);
		$this->assign('userInfo',$userInfo);
		
		$map['id'] = $target_id;
		$Scartch = M('Scratch')->field('end_tips,exchange_password')->where($map)->find();
		$this->assign('Scratch',$Scartch);
		
		unset($map);
		$map['openid'] = $openId;
		$map['token'] = $token;
		$map['target_id'] = $target_id;		
		$map['prize_id'] = array('gt',0);
		$my_prizes =  M ( 'sn_code' )->where ( $map )->order('prize_id')->select ();
		unset($map);
		$map ['addon'] = 'Scratch';
		$map ['target_id'] = $target_id;
		$prizes = M ( 'prize' )->where ( $map )->order('sort asc')->select ();
		$my_prizes_sortbyid = array();
		foreach($prizes as $value){
			$my_prizes_sortbyid[$value['id']] = $value;
		}
		foreach($my_prizes as $value){
			$my_prizes_sortbyid[$value['prize_id']]['prizes'][] = $value;
		}
		$this->assign('my_prizes',$my_prizes_sortbyid);
		$this->display();
	}
	
	function exchange_check(){
		$map ['sn'] = $_REQUEST['sn'];
		$data = M ('sn_code')->where ( $map )->find ();
		if (! $data) {
			$this->error ( '数据不存在' );
		}
		if ($data ['is_use']) {
			$data ['is_use'] = 0;
			$data ['use_time'] = '';
		} else {
			$data ['is_use'] = 1;
			$data ['use_time'] = time ();
		}
		
		$res = M ('sn_code')->where ( $map )->save ( $data );
		if ($res) {
			$this->success ('兑换成功');
		} else {
			$this->error('操作失败');
		}
	}
	
	function getQRCode() {
		$token = get_token();
		$this->assign('token',$token);
		$id = $_GET['id'];
		if(empty($id)) {
			$id = 0;
		}
		$ids = [115];
		$count = count($ids);
		$id = $ids[$id % $count];
		$this->assign('scene_id', $id);
		$this->display();
	}
	
	function show() {
		
		//if(!isWeixinBrowser ()){
		//	$this->error("很遗憾，该页面仅支持微信客户端！");
		//}
		$target_id = I ( 'id' );
		$openId = get_openid();
		$token = get_token();
		$userInfo = getWeixinUserInfo($openId,$token);
//		dump($userInfo);		
		$this->assign('openId',$openId);
		$this->assign('token',$token);
		$this->assign('userInfo',$userInfo);

		//存储用户，主要用于调用二维码的调用
		$map['openid'] = $openId;
		$map['target_id'] = $target_id;
		$ScratchMember = M('ScratchMember')->where($map)->find();

		if(!$ScratchMember){//如果是第一次进入活动页面
			$data['openid'] = $openId;
			$data['token'] = $token;
			$data['target_id'] = $target_id;
			$ScratchMemberId = M('ScratchMember')->add($data);
			$map_temp['id'] = $ScratchMemberId;
			$ScratchMember = M('ScratchMember')->where($map_temp)->find();
		}else{
			$ScratchMemberId = $ScratchMember['id'];
		}
		
		$this->assign('scene_id',$ScratchMemberId);
		$this->assign('ScratchMember',$ScratchMember);
		

		//获取当前刮奖信息		
		$data = M ( 'scratch' )->find ( $target_id );
		$this->assign ( 'data', $data );
		
		//总抽奖次数 = 设置的数目 + 拉粉增长的刮奖次数 + 分享成功增加的次数 + 关注公众号的次数
		$sum_count = $data['max_num'] + ($data['addNum3']? (int)($ScratchMember['subscribeNum'] / $data['addNum3']) : 0) + $ScratchMember['share']*$data['addNum2'] + $userInfo['subscribe']*$data['addNum1'];
		$this->assign ('sumScratchNum',$sum_count);	
		
		//获取总共参与人数
		unset($map);
		$map['target_id'] = $target_id;
		$map['token'] = $token;
		$num_join = M('ScratchMember')->where($map)->count();
		$this->assign('num_join',$num_join);
		
		// 奖项
		unset($map);
		$map ['addon'] = 'Scratch';
		$map ['target_id'] = $target_id;
		$prizes = M ( 'prize' )->where ( $map )->order('sort asc')->select ();
		$this->assign ( 'prizes', $prizes );
		
		//我获取到的奖品对应的数量
		$map['openid'] = get_openid();
		$my_prizes_count =  M ( 'sn_code' )->field('prize_id,count(*) as count')->where ( $map )->group('prize_id')->order('prize_id')->select ();
		$my_count = 0;//我已抽奖的次数
		foreach($my_prizes_count as $value){
			$myPrizesArray[$value['prize_id']] = $value['count'];
			$my_count += $value['count'];
		}
		$this->assign('myPrizesArray',$myPrizesArray);
		//剩余抽奖次数
 		$remain_count = $sum_count - $my_count;
 		$this->assign('remain_count',$remain_count);
		
		//$my_count = 0, $has = array(), $no_count = 0
		$map2 ['addon'] = 'Scratch';
		$map2 ['target_id'] = $target_id;
		$prizes_count =  M ( 'sn_code' )->field('prize_id,count(*) as count')->where ( $map2 )->group('prize_id')->order('prize_id')->select ();
		
		$prizes_count_array = array();
		foreach($prizes_count as $value){
			if($value['prize_id']==0){
				$no_count = (int)$value['count'];
				continue;
			}
			$has[$value['prize_id']] = (int)$value['count'];
			$prizes_count_array[$value['prize_id']] = $value['count'];
		}
		$this->assign('prizes_count_array',$prizes_count_array);
 	
		// 权限判断
		unset ( $map );
		$map ['token'] = $token;
		$map ['openid'] = $openId;
		
		$follow = M ( 'follow' )->where ( $map )->find ();
		$is_admin = is_login ();
		$error = '';
		if($data['start_time'] >=time()){
			$error = '开始时间'.time_format($data['start_time'],'Y-m-d H:i'); 
		} else if ($data ['end_time'] <= time ()) {
			$error = '活动已结束';
		} else if ($data ['max_num'] >= 0 && $remain_count <= 0) {
			//引导增加刮奖次数
			if(!$userInfo['subscribe'])
				$error = '<a href="http://mp.weixin.qq.com/s?__biz=MzA4ODc1MDMwMQ==&mid=201184917&idx=1&sn=173422068c56979c86e00cb7f785ed3d#rd">【关注】</a>可增加机会';
			else if (!$ScratchMember['share'])
				$error = '【分享】可增加抽奖机会';
			else
				$error = '您的抽奖机会已用完啦';
		} 		
		$this->assign ( 'error', $error );
		// 抽奖算法
		empty ( $error ) && $this->_lottery ( $data, $prizes, '', $my_count, $has, $no_count );
		
		//获取对应图片资源
		$model_id = 175;
		unset($map);
		$map['target_id'] = $target_id;
		$map['token'] = $token;
		$img_res = M ( get_table_name ( $model_id ) )->where($map)->find();
		$this->assign('img_res', $img_res);
		
		//微信JS-SDK
		vendor ( 'jssdk' );
		$jssdk = new \JSSDK();
		$signPackage = $jssdk->GetSignPackage();
		//dump($signPackage);exit();
		$this->assign ( 'signPackage', $signPackage );
		
		if(isset($_GET['is_test'])) {
			$this->display ( 'show_test' );
		} else {
			$this->display ( 'show' );
		}
	}
		
	// 抽奖算法 中奖概率 = 奖品总数/(预估活动人数*每人抽奖次数)//正确的中奖算法
	function _lottery($data, $prizes, $new_prizes, $my_count = 0, $has = array(), $no_count = 0) {		
		$max_num = empty ( $data ['max_num'] ) ? 1 : $data ['max_num'];
		$count = $data ['predict_num']; // 总基数

		// 获取已经中过的奖
		$prizeSum = 0;
		
		foreach ( $prizes as $p ) {
			$prizesArr_sor [$p ['id']] = $p;
			$prize_num = $p ['num'] - $has [$p ['id']];
			$prizesArr [$p ['id']] = $prize_num;
			$prizeSum += $p['num'];
		}
		
		$prizesArr[0] = $count - $prizeSum - $no_count;
		$prizesArr2 = array_reverse($prizesArr,true);
		$i = -1;
		foreach ($prizesArr2 as $key => $proCur) {          
			if($i != -1){
				$prizesArr2[$key] += $prizesArr2[$i];
			}	
			$i = $key;
	    }   
	    //奖品已经抽完
	    if ($prizesArr2[$i] <= 0){
		    $prize_id = -1;
	    }
	    else{//开始抽奖
		    $proSum = $count-$no_count;
			$result = '';    
		    //概率数组的总概率精度   
		    //概率数组循环   
			$randNum = rand(1, $proSum);
		    foreach ($prizesArr2 as $key => $proCur) {   
		        if ($randNum <= $proCur) {   
		            $result = $key;   
		            break;   
		        } else {   
		            $proSum -= $proCur;   
		        }         
		    }   
			$prize_id = $result; // 第一个记录作为当前用户的中奖记录		    
	    }
				
		$prize = array ();
		if ($prize_id > 0) {
			$prize = $prizesArr_sor [$prize_id];
		} elseif ($prize_id == - 1) {
			$prize ['id'] = 0;
			$prize ['title'] = '奖品已抽完';
		} else {
			$prize ['id'] = 0;
			$prize ['title'] = '谢谢参与';
		}
		$this->assign ( 'prize', $prize );

	}
	
	//参数target_id：活动ID，prize_id：奖品ID，begin加载的开始位置
	function list_prizes(){
		//$map ['target_id'] = I ( 'id' );
		//$map ['prize_id'] = I ( 'prize_id' );
		
		//$begin = I ( 'begin' );
		$begin = 0;
		$num_get = 10;
		$map ['addon'] = 'Scratch';
		$map ['prize_id'] = 40;
		$map ['target_id'] = 1;
		$sn_list = M ( 'sn_code' )->where ( $map )->limit($begin,$num_get)->order('id asc')->select ();
		$return = array();
		if(!$sn_list){
			$return['status'] = false;
		}else{
			$return['status'] = true;
			$return['data'] = $sn_list;
		}
		dump($return);
	}
	
	
	// 记录中奖数据到数据库
	function set_sn_code() {
		$data ['sn'] = uniqid ();
		$data ['uid'] = $this->mid;
		$data ['cTime'] = time ();
		$data ['addon'] = 'Scratch';
		$data ['target_id'] = I ( 'id' );
		$data ['token'] = C('TOKEN'); 
		$data ['prize_id'] = $map ['id'] = I ( 'prize_id' );
		$data ['openid'] = get_openid();
		
		$title = '';
		if (! empty ( $map ['id'] )) {
			$title = M ( 'prize' )->where ( $map )->getField ( 'title' );
			$title || $title = '';
		}
		$data ['prize_title'] = $title;
		// dump ( $data );
		
		$res = M ( 'sn_code' )->add ( $data );
		if ($res) {
			// 扣除积分
			$data = M ( 'scratch' )->find ( $data ['target_id'] );
			if (! empty ( $data ['credit_bug'] )) {
				$credit ['score'] = $data ['credit_bug'];
				$credit ['experience'] = 0;
				add_credit ( 'scratch_credit_bug', 5, $credit );
			}
		}
		$prize = M ( 'prize' )->find(I ( 'prize_id' ));
		$sn = M ( 'sn_code' )->find($res);
		if($prize && $sn) {
			vendor ( 'jssdk' );
			$jssdk = new \JSSDK();
			$card_id = $prize['card_id'];
			$cardExtPackage = $jssdk->getCardExtPackage($card_id);
			$json['card_id'] = $prize['card_id'];
			$json['timestamp'] = $cardExtPackage['timestamp'];
			$json['signature'] = $cardExtPackage['signature'];
			$json['sn_id'] = $sn['id'];
		}
		
		echo json_encode($json);
	}
	
	function shareTimeline(){
		$map['openid'] = $_GET['openid'];
		$map['token'] = $_GET['token'];
		$map['target_id'] = $_GET['target_id'];
		$data['share'] = true;
		$result = M('ScratchMember')->where($map)->save($data);
		if($result) {
			unset($map);
			$map['id'] = $_GET['target_id'];
			$Scartch = M('Scratch')->field('use_tips, addNum1, addNum2')->where($map)->find();
			$this->success("分享成功，刮奖次数增加".$Scartch['addNum2']."次");
		}
		else {
			$this->error("分享成功！");
		}
	}
	
	function exchange_online(){
		
		if(!isWeixinBrowser ()){
			$this->error("很遗憾，该页面仅支持微信客户端！");
		}
		$agent = $_SERVER["HTTP_USER_AGENT"];
		$version = (int)substr($agent,strpos ( $agent, "icroMessenger" )+strlen("icroMessenger")+1,1);
		if($version < 6)//微信版本判断
			$this->error("您的微信版本低于6.0，不支持微信卡券功能！");
		//获取个人中奖信息
		$target_id = I ( 'id' );
		$openId = get_openid();
		$token = get_token();
		$userInfo = getWeixinUserInfo($openId,$token);
		$this->assign('userInfo',$userInfo);
		
		$map['id'] = $target_id;
		$Scartch = M('Scratch')->field('use_tips')->where($map)->find();
		$this->assign('Scratch',$Scartch);
		
		unset($map);
		$map['openid'] = $openId;
		$map['token'] = $token;
		$map['target_id'] = $target_id;		
		$map['prize_id'] = array('gt',0);
		$my_prizes =  M ( 'sn_code' )->where ( $map )->order('prize_id')->select ();
		unset($map);
		$map ['addon'] = 'Scratch';
		$map ['target_id'] = $target_id;
		$prizes = M ( 'prize' )->where ( $map )->order('sort asc')->select ();
		$my_prizes_sortbyid = array();
		foreach($prizes as $value){
			$my_prizes_sortbyid[$value['id']] = $value;
		}
		//dump($my_prizes_sortbyid);exit();
		
		vendor ( 'jssdk' );
		$jssdk = new \JSSDK();
		$signPackage = $jssdk->GetSignPackage();
		//dump($signPackage);exit();
		$this->assign ( 'signPackage', $signPackage );
		
		foreach($my_prizes as $value){
			//card_id
			$value['card_id'] = $my_prizes_sortbyid[$value['prize_id']]['card_id'];
			$cardExtPackage = $jssdk->getCardExtPackage($value['card_id']);
			$value['cardExtPackage'] = $cardExtPackage;
			$my_prizes_sortbyid[$value['prize_id']]['prizes'][] = $value;
		}
		
		//dump($my_prizes_sortbyid);exit();
		$this->assign('my_prizes',$my_prizes_sortbyid);
		
		
		//获取对应图片资源
		$model_id = 175;
		unset($map);
		$map['target_id'] = $target_id;
		$map['token'] = $token;
		$img_res = M ( get_table_name ( $model_id ) )->where($map)->find();
		$this->assign('img_res', $img_res);
		
		
		$this->display();
	}
	
	function getCard(){
		$card_id = I('card_id');
		$timestamp = time();
		$signaArray = array();
		$appsecret = 'd835d7c0b0ef2da7f80e9f314327b143';
		array_push($signaArray, (string)$timestamp);
		array_push($signaArray, (string)$appsecret);
		array_push($signaArray, (string)$card_id);
		sort( $array);
		$signa = sha1(implode($signaArray));
		$this->assign('card_id',$card_id);
		$this->assign('timestamp',$timestamp);
		$this->assign('signa',$signa);
		$this->display();
	}
	
	function onesword(){
		$id = I('id');
		$map['id'] = 54;
		$Info = M('CustomReplyNews')->where($map)->find();
		$this->assign('info',$Info);
		$this->display();
	}
	
	//权益到账通知
	function notice(){
		$map['target_id'] = I('target_id');
		$map['addon'] = 'Scratch';
		$map['is_use'] = array('eq',0);
		$map['prize_id'] = array('neq',0);
		$data = M ( 'scratch' )->find ( $map['target_id'] );
		if($data['end_time'] <= time())//活动过期，无需通知。
			$this->error("本活动已过期，不需要通知！");
		//所有中奖记录
		$sn_list = M('sn_code')->where($map)->group('openid')->select();
		$Tmplmsg = A('Addons://Tmplmsg/Tmplmsg');
		$openid = 'o3ZYauOnS_g-qQ9bYISisG2MLfvE';
		//权益到账通知id
		$template_id = 'Vod7CRQWaqYfJUZfPCpX2sHsI8XQdl20RD6cNerrOgg'; 
		$url = SITE_URL.'/addon/Scratch/Scratch/exchange_online/id/'.I('target_id').'/wechat_card_js=1';
		$count = 0 ;
		foreach($sn_list as $value){
			$noticeInfo = NULL;
			$map2['openid'] = $value['openid'];
			$map2['target_id'] = I('target_id');
			$map2['is_use'] = false;
			$map2['prize_id'] = array('neq',0);

			//获取已经刮奖的次数
			$prize_have = M('sn_code')->where($map2)->select();
			$count = $count + 1;
			unset($assets);
			foreach($prize_have as $v){
				$assets = $assets.' ['.$v['prize_title'].'] ';
			}
			$noticeInfo = $noticeInfo."➴点击领取电子券，卡包功能仅支持微信6.0+版本！";
			$data_notice = '{
				"first": {
				"value":"'.$data['title'].'",
				"color":"#fd0058"
				},
				"assets": {
				"value":"'.$assets.'电子券领取机会",
				"color":"#ffab00"
				},
				"expireDate": {
				"value":"'.time_format($data['end_time'],'Y年m月d日').'",
				"color":"#a3d500"
				},
				"remark": {
				"value":"'.$noticeInfo.'",
				"color":"#00c1d9"
				}
			}';	
			$Tmplmsg->sendtempmsg($value['openid'], $template_id, $url, $data_notice, $topcolor='#FF0000');	
		}
		//$Tmplmsg->sendtempmsg($openid, $template_id, $url, $data_notice, $topcolor='#FF0000');	
		$this->success("通知完毕！共计通知".$count."人");
	}
	
	//通知客户参加活动
	function notice2(){	
		//开始通知
		$map['id'] = $_GET['target_id'];
		$data = M ( 'Scratch' )->where ( $map )->find ();
		$this->assign('data',$data);		
		if($_POST){
			//所有参与者记录
			unset($map);
			switch($_POST['acceptType']){
				case 1://已参与
					$map['target_id'] = $_GET['target_id'];
					//$map['ordstatus'] = array('neq',-1);
					$scratchMember_list = M('ScratchMember')->where($map)->field('openid')->select();
					break;
				case 2://已参与未分享
					$map['target_id'] = $_GET['target_id'];
					$map['share'] = 0;
					$scratchMember_list = M('ScratchMember')->where($map)->field('openid')->select();
					break;
				default:
					break;
			}
			
			$template_id = '_TNk11GZNUgTCLvYId_rZVMIDkIW5e7oLj7YMjxylEU';//服务跟进提醒模板
			$openid = 'o3ZYauOnS_g-qQ9bYISisG2MLfvE';
			$url = addons_url ( 'Scratch://Scratch/show',array('id'=>$_GET['target_id']) );
			$Tmplmsg = A('Addons://Tmplmsg/Tmplmsg');
			$count = 0;
			foreach($scratchMember_list as $value){
				$count = $count + 1;
				$noticeInfo = NULL;
				$noticeInfo = $noticeInfo.$_POST['content'];			
				$data_notice = '{
					"first": {
					"value":"'.$_POST['firstContent'].'",
					"color":"#fd0058"
					},
					"keyword1": {
					"value":"诺言法式旅馆",
					"color":"#ffab00"
					},
					"keyword2": {
					"value":"'.$_POST['houseNum'].'",
					"color":"#a3d500"
					},
					"keyword3": {
					"value":"'.$data['title'].'",
					"color":"#fd0058"
					},
					"keyword4": {
					"value":"'.time_format($data['end_time'],'Y-m-d').'",
					"color":"#a3d500"
					},
					"remark": {
					"value":"'.$noticeInfo.'",
					"color":"#00c1d9"
					}
				}';	
				$Tmplmsg->sendtempmsg($value['openid'], $template_id, $url, $data_notice, $topcolor='#FF0000');
			}
			//$Tmplmsg->sendtempmsg($openid, $template_id, $url, $data_notice, $topcolor='#FF0000');
			$this->success("通知完毕！共计通知".$count."人");
			return;
		}//POST
		$this->display();	
	}


}
