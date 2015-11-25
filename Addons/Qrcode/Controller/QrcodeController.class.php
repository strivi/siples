<?php

namespace Addons\Qrcode\Controller;
use Home\Controller\AddonsController;

class QrcodeController extends AddonsController{

	function _initialize() {
		$this->model = $this->getModel ( 'qr_code' );
		parent::_initialize ();
	}
	
  //保存二维码到lq_qr_code表	
  public function qr_code_save($qr_code,$ewmid){
           $data['token'] =  get_token ();
           $data['qr_code']=$qr_code;
		   $data['scene_id']=$ewmid;
           $data['cTime']=time();
           $data['addon']='Qrcode';
	       $data['extra_text']= $extra_text ;
	       $data['action_name'] = 'QR_LIMIT_SCENE';
		   $Model = M('qr_code');
           $Model->data($data)->add();
	}
	
	public function preview(){
		$map['scene_id'] = I('scene_id');
		$result = M('QrCode')->where($map)->find();
		$this->assign('qr_code',$result['qr_code']);
		$this->display();
		
	}
		 
	// 通用插件的列表模型
	public function lists() {	
		 $token = get_token ();
		 $list_data = $this->_get_model_list ( $this->model );
		 $this->assign ( $list_data );
		 $this->display ();
	}
	
	// 通用插件的编辑模型
	public function edit() {
		parent::common_edit ( $this->model );
	}
	
	// 通用插件的删除模型
	public function del() {
		parent::common_del ( $this->model );
	}	

	function send_ewm() {    
	  //-----获取access_token
	  	$access_token = get_access_token();   
	  //----生成二维码
	  	$ewmid = I('ewmid');  
	  	$postUrl = 'https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=' . $access_token;  
	  	$postJson='{"action_name": "QR_LIMIT_SCENE", "action_info": {"scene": {"scene_id": '.$ewmid.'}}}';  
	  	$return = json_decode(http_post($postUrl,$postJson),true);
	  	if ($return ['errcode'] == 0) {
		  	$ticket = $return ['ticket'];
		  	$qr_code= 'https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket='.UrlEncode($ticket) ;
		  	$this->qr_code_save($qr_code,$ewmid);	
		  	$this->success( '生成二维码成功');
		}else {
	   		$this->error( '生成二维码失败，错误的返回码是：' . $res ['errcode'] . ', 错误的提示是：' . $res ['errmsg'] );
	   	}
	 }
    
}
