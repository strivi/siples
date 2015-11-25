<?php

namespace Addons\Liuyanban\Controller;
use Home\Controller\AddonsController;

/**
 * 留言板插件控制器
 * @author 艾逗笔<765532665@qq.com>
 * @version 1.0
 * Modified at 2014/11/22 14:27
 */
class LiuyanbanController extends AddonsController{

	// 初始化方法
	public function _initialize(){

		$controller=strtolower(_CONTROLLER);

		$res['title']='插件配置';
		$res['url']=addons_url('Liuyanban://Liuyanban/config');
		$res['class']=$controller=='liuyanban'?'current':'';
		$nav[]=$res;

		$res['title']='留言管理';
		$res['url']=addons_url('Liuyanban://Message/lists');
		$res['class']=$controller=='message'?'current':'';
		$nav[]=$res;

		$this->assign('nav',$nav);
	}

	//留言列表页面——index.html
	function index(){
		$map['token']=get_token();
		$message=M('lyb_message')->where($map)->order('ctime desc')->select();
		//dump($message);
		$this->assign('message',$message);
		$this->display();	
	}
	
	//发布留言页面——liuyan.html 
	function liuyan(){
		if(IS_POST){
			$data['openid']=get_openid();
			$data['token']=get_token();
			$data['nickname']=I('name')?I('name'):'匿名';
			$data['content']=I('content');
			$data['sex']=I('sex');
			$data['ctime']=time();
//			$data['houseNum'] = I('houseNum');

			$res=M('lyb_message')->add($data);
			if($res){
				$jump_url=addons_url('Liuyanban://Liuyanban/index');
				redirect($jump_url);
			}else{
				$this->error('留言失败');
			}
			
		}else{
			$message = getWeixinUserInfo(get_openid(),get_token());
			$this->assign('userInfo',$message);
			$this->display();
		}
		
	}

}
