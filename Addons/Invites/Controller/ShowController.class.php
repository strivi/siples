<?php
namespace Addons\Invites\Controller;

use Home\Controller\AddonsController;

class ShowController extends AddonsController {

	public function Index(){

		// 获取数据
		$map ['id'] = I('id');
		$info = M ( 'Invites' )->where ( $map )->order ( 'id desc' )->find ();

		$info[startdate] = time_format($info[startdate]);

		///拆分经纬度
		$lnglat = explode(',',$info['lnglat']);
        $info[lng] = $lnglat[0];
		$info[lat] = $lnglat[1];

		switch ($info[type]){
			case 0:
				$info[type] = '会议';
				break;
			case 1:
				$info[type] = '聚会';
				break;
			default:
				$info[type] = '活动'; 		
		
		}

		if($info['class'] == '0'){
			$this->assign('info',$info);
			$this->display('Invites_index');
		}else{
			$this->assign('info',$info);
			$this->display('Invites_index2');
		}
	}

	public function signadd(){
		if(IS_POST){
			$data = $_POST;
			$data[token] = get_token();
			if(M('Invitessign')->add($data)){
				$this->success('签到成功');
			}else{
				$this->error('签到失败');
			}
		}
	}

}