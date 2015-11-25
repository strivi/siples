<?php

namespace Addons\Qrcode\Controller;
use Home\Controller\AddonsController;

class QrcodeController extends AddonsController{

	function _initialize() {
		$this->model = $this->getModel ( 'qr_code' );
		parent::_initialize ();
	}
	
  //保存二维码到lq_qr_code表	
public function qr_code_save($qr_code){
           $data['token'] =  get_token ();
           $data['qr_code']=$qr_code;
           $data['aim_id']=2;
           $data['addon']=3;
	       $data['extra_text']= $extra_text ;
		   $Model = M('qr_code');
           $Model->data($data)->add();
		 }
		 
public function qr_code_save($qr_code){
      $ch2 = curl_init ();
      curl_setopt ( $ch2, CURLOPT_URL, $url );
      curl_setopt($ch2, CURLOPT_HEADER, 0); 
      curl_setopt($ch2, CURLOPT_NOBODY, 0); //只取body头 
      curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, FALSE); 
      curl_setopt($ch2, CURLOPT_SSL_VERIFYHOST, FALSE);
      curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1);
      $package = curl_exec ( $ch2 );
      $httpinfo = curl_getinfo( $ch2 );
      curl_close ( $ch2 );
      $imageInfo = array_merge(array('body' => $package),array('header' => $httpinfo)); 
  
        
		 
		$filename = 'Addons/Qrcode/View/default/ewmPublic/'.get_token();
		
                 if (is_dir($filename)){  
                                   }else{
                          $res=mkdir(iconv("UTF-8", "GBK", $filename),0777,true); 
                              }

       $filename = $filename.'/qrcod_'.$ewmid.'.jpg';
 
		
        // $filename= "qrcod.jpg";   //保存路径
         $local_file=fopen($filename,'w');
           if(false!==$local_file){
                if(false!==fwrite($local_file,$imageInfo["body"])){
                      fclose($local_file);
		         }
          	 }
   		 
}


public function leaflets() {

		$config = array ();
		$ewmid = I ( 'ewmid' );
		
			$config ['title'] = '名称';
			$config ['img'] = is_numeric ( $config ['img'] ) ? get_cover_url ( $config ['img'] ) : SITE_URL . '/Addons/Qrcode/View/default/ewmPublic/'.get_token().'/qrcod_'.$ewmid.'.jpg';
			$config ['info'] = '说明说明说明说明说明说明说明说明说明说明说明说明说明';
			$this->assign ( 'config', $config );
		
		
		// dump ( $config  );
	//	exit();
		
		$this->display ( SITE_PATH . '/Addons/Qrcode/View/default/Qrcode/show.html' );
	}


// 通用插件的列表模型


public function lists() {
		
		 $token = get_token ();
		 $list_data = $this->_get_model_list ( $this->model );
		 
		 $this->assign ( $list_data );
		 
		 $this->display ();
		
	
	//function show() {
//		$this->display ();
//	}
		
	}
	
	// 通用插件的编辑模型
	public function edit() {
	
		parent::common_edit ( $this->model );
	}
	
	// 通用插件的增加模型
	public function add() {
	 //   $token = get_token ();
		
		//$data ['token'] = get_token ();
		//$res = M ( 'qr_code' )->add ( );
		//$res = $this->model->add ( );
		
	 //  dump ( $res  );
		//exit();
		parent::common_add ( $this->model );
	}
	
	// 通用插件的删除模型
	public function del() {
		parent::common_del ( $this->model );
	}	


	


function send_ewm() {

    
  //-----获取access_token
  //建议weiphp以后把这块封装成函数 并把access_token写入wp_member_public表中 
  $map ['token'] = get_token ();
  $info = M ( 'member_public' )->where ( $map )->find ();
  $url_get = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=' . $info ['appid'] . '&secret=' . $info ['secret'];
  
  $ch1 = curl_init ();
  $timeout = 5;
  curl_setopt ( $ch1, CURLOPT_URL, $url_get );
  curl_setopt ( $ch1, CURLOPT_RETURNTRANSFER, 1 );
  curl_setopt ( $ch1, CURLOPT_CONNECTTIMEOUT, $timeout );
  curl_setopt ( $ch1, CURLOPT_SSL_VERIFYPEER, FALSE );
  curl_setopt ( $ch1, CURLOPT_SSL_VERIFYHOST, false );
  $accesstxt = curl_exec ( $ch1 );
  curl_close ( $ch1 );
  $access = json_decode ( $accesstxt, true );
  if (empty ( $access ['access_token'] )) {
   $this->error ( '获取access_token失败,请确认AppId和Secret配置是否正确,然后再重试。' );
  }
  
  //-----获取access_token结束
 
  
  //----生成二维码
   $ewmid = I('post.ewmid',0);
   $ewmid = I('ewmid');
  
  $url = 'https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=' . $access ['access_token'];
  $header [] = "content-type: application/x-www-form-urlencoded; charset=UTF-8";
  
  $qrcode='{"action_name": "QR_LIMIT_SCENE", "action_info": {"scene": {"scene_id": '.$ewmid.'}}}';
  
  $ch = curl_init ();
  curl_setopt ( $ch, CURLOPT_URL, $url );
  curl_setopt ( $ch, CURLOPT_CUSTOMREQUEST, "POST" );
  curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, FALSE );
  curl_setopt ( $ch, CURLOPT_SSL_VERIFYHOST, FALSE );
  curl_setopt ( $ch, CURLOPT_HTTPHEADER, $header );
  curl_setopt ( $ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)' );
  curl_setopt ( $ch, CURLOPT_FOLLOWLOCATION, 1 );
  curl_setopt ( $ch, CURLOPT_AUTOREFERER, 1 );
  curl_setopt ( $ch, CURLOPT_POSTFIELDS, $qrcode );
  curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
  $res = curl_exec ( $ch );
  curl_close ( $ch );
  $res = json_decode ( $res, true );
  
  if ($res ['errcode'] == 0) {
  
   
   $ticket = $res ['ticket'];
   $url= 'https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket='.UrlEncode($ticket) ;
   
     $qr_code=$url;
	 $this->qr_code_save($qr_code);	
   
   //--------------保存二维码
   
   $this->success ( '生成二维码成功');
  } else {
   $this->success ( '生成二维码失败，错误的返回码是：' . $res ['errcode'] . ', 错误的提示是：' . $res ['errmsg'] );
  }
 }
    
}
