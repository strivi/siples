<?php

namespace Addons\Qrcode\Controller;
use Home\Controller\AddonsController;

class QrcodeController extends AddonsController{

	function _initialize() {
		$this->model = $this->getModel ( 'qr_code' );
		parent::_initialize ();
	}
	
  //�����ά�뵽lq_qr_code��	
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
		 
	// ͨ�ò�����б�ģ��
	public function lists() {	
		 $token = get_token ();
		 $list_data = $this->_get_model_list ( $this->model );
		 $this->assign ( $list_data );
		 $this->display ();
	}
	
	// ͨ�ò���ı༭ģ��
	public function edit() {
		parent::common_edit ( $this->model );
	}
	
	// ͨ�ò����ɾ��ģ��
	public function del() {
		parent::common_del ( $this->model );
	}	

	function send_ewm() {    
	  //-----��ȡaccess_token
	  	$access_token = get_access_token();   
	  //----���ɶ�ά��
	  	$ewmid = I('ewmid');  
	  	$postUrl = 'https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=' . $access_token;  
	  	$postJson='{"action_name": "QR_LIMIT_SCENE", "action_info": {"scene": {"scene_id": '.$ewmid.'}}}';  
	  	$return = json_decode(http_post($postUrl,$postJson),true);
	  	if ($return ['errcode'] == 0) {
		  	$ticket = $return ['ticket'];
		  	$qr_code= 'https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket='.UrlEncode($ticket) ;
		  	$this->qr_code_save($qr_code,$ewmid);	
		  	$this->success( '���ɶ�ά��ɹ�');
		}else {
	   		$this->error( '���ɶ�ά��ʧ�ܣ�����ķ������ǣ�' . $res ['errcode'] . ', �������ʾ�ǣ�' . $res ['errmsg'] );
	   	}
	 }
    
}
