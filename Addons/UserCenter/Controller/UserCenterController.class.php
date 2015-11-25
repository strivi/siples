<?php

namespace Addons\UserCenter\Controller;

use Home\Controller\AddonsController;
use User\Api\UserApi;

class UserCenterController extends AddonsController {
	
	/**
	 * 显示微信用户列表数据
	 */
	public function lists() {
		$this->assign ( 'add_button', false );
		$this->assign ( 'del_button', false );
		$this->assign ( 'check_all', false );
		
		$tongbuyonghuhaoUrl = U('tongbuyonghuhao');
		$normal_tips = '<a href="'.$tongbuyonghuhaoUrl.'">一键同步微信用户</a>';
		$this->assign ( 'normal_tips', $normal_tips );
		$model = $this->getModel ( 'follow' );
		
		parent::common_lists ( $model );
	}
	
	public function tongbuyonghuhao(){
		//同步用户号
		$token = get_token();
		$access_token = get_access_token($token);
		
		$url = 'https://api.weixin.qq.com/cgi-bin/user/get?access_token='.$access_token.'';
		$users = json_decode(wp_file_get_contents($url),true);
		if(!$users['total'])
			$this->error("更新失败");
		$data = $users['data'];
		$openidArray = $data['openid'];
		foreach($openidArray as $key=>$openid){
			$userInfo = getWeixinUserInfo($openid,$token);
			$map['openid'] = $userInfo['openid'];
			$data['nickname'] = $userInfo['nickname'];
			$data['sex'] = $userInfo['sex'];
			$data['city'] = $userInfo['city'];
			$data['country'] = $userInfo['country'];
			$data['province'] = $userInfo['province'];
			$data['language'] = $userInfo['language'];
			$data['headimgurl'] = $userInfo['headimgurl'];
			$data['subscribe_time'] = $userInfo['subscribe_time'];					
			$data['status'] = $userInfo['subscribe'];
			$data['token'] = $token;	
			
			$result_id = M('Follow')->where($map)->getField('id');	
			if($result_id){//更新
				$data['id'] = $result_id;				
				M('Follow')->save($data);
				unset($data);
			}else{//新增
				D ( 'Common/Follow' )->init_follow (  $userInfo['openid'] );
			}
		}
		$this->success("同步完成！");
	}
	
	// 用户绑定
	public function edit() {
		$is_admin_edit = false;
		if(!empty($_REQUEST['id'])){
			$map['id'] = intval($_REQUEST['id']);
			$is_admin_edit = true;
			$msg = '编辑';
			$html = 'edit';
		}else{
			$msg = '绑定';
		    $openid = $map ['openid'] = get_openid ();
			$html = 'moblieForm';
		}
		$token = $map ['token'] = get_token ();
		$model = $this->getModel ( 'follow' );
		dump($model);
		if (IS_POST) {
			$is_admin_edit && $_POST['status'] = 2;
			$Model = D ( parse_name ( get_table_name ( $model ['id'] ), 1 ) );
			// 获取模型的字段信息
			$Model = $this->checkAttr ( $Model, $model ['id'] );
			if ($Model->create () && $Model->where ( $map )->save ()) {
				//lastsql();exit;
				$url = '';				
				$bind_backurl = cookie('__forward__');
				$config = getAddonConfig ( 'UserCenter' );
				$jumpurl = $config['jumpurl'];
				
				if(!empty($bind_backurl)){
					$url = $bind_backurl;
					cookie('__forward__', NULL);
				}elseif(!empty($jumpurl)){
					$url = $jumpurl;
				}elseif(!$is_admin_edit){
					$url = addons_url ( 'WeiSite://WeiSite/index', $map );
				}

				$this->success ( $msg.'成功！',  $url); 
			} else {
				//lastsql();
				//dump($map);exit;
				$this->error ( $Model->getError () );
			}
		} else {
			$fields = get_model_attribute ( $model ['id'] );
			if(!$is_admin_edit){
				$fieldArr = array('nickname','sex','mobile'); //headimgurl
				foreach($fields[1] as $k=>$vo){
					if(!in_array($vo['name'], $fieldArr))
					   unset($fields[1][$k]);
				}
			}
			
			// 获取数据
			$data = M ( get_table_name ( $model ['id'] ) )->where ( $map )->find ();
			
		$token = get_token ();
		if (isset ( $data ['token'] ) && $token != $data ['token'] && defined ( 'ADDON_PUBLIC_PATH' )) {
			$this->error ( '非法访问！' );
		}			
			
			// 自动从微信接口获取用户信息
			empty($openid) || $info = getWeixinUserInfo ( $openid, $token );
			if (is_array ( $info )) {
				if (empty ( $data ['headimgurl'] ) && ! empty ( $info ['headimgurl'] )) {
					// 把微信头像转到WeiPHP的通用图片ID保存 TODO
					$data ['headimgurl'] = $info ['headimgurl'];
				}
				$data = array_merge ( $info, $data );
			}

			$this->assign ( 'fields', $fields );
			$this->assign ( 'data', $data );
			$this->meta_title = $msg.'用户消息';
			
			$this->assign('post_url', U('edit'));
			$this->display ($html);
		}
	
		
	}
	public function userCenter() {
		$this->display();
	}
	function config(){
		// 使用提示
		$normal_tips = '如需用户关注时提示先绑定，请进入‘欢迎语’插件按提示进行配置提示语';
		$this->assign ( 'normal_tips', $normal_tips );
		
		parent::config();
	}
}
