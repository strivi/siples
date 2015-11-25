<?php
        	
namespace Addons\Liuyanban\Model;
use Home\Model\WeixinModel;
        	
/**
 * Liuyanban的微信模型
 * @author 艾逗笔<765532665@qq.com>
 * @version 1.0
 * Modified at 2014/11/22 14:18
 */
class WeixinAddonModel extends WeixinModel{
	function reply($dataArr, $keywordArr = array()) {
		
		$config = getAddonConfig ( 'Liuyanban' ); // 获取后台插件的配置参数	
		
		$param['token']=get_token();				//获取当前公众号的token
		$param['openid']=get_openid();					//获取当前用户的openid
		$url=addons_url('Liuyanban://Liuyanban/index',$param);		//生成微信回复图文消息跳转链接
		$picurl=$config['cover']?get_cover_url($config['cover']):$config['cover_url'];	//生成微信回复图文消息封面图片地址
		$articles[0]=array(
			'Title'=>$config['title'],
			'Description'=>$config['desc'],
			'PicUrl'=>$picurl,
			'Url'=>$url
		);

		$this->replyNews($articles);

	} 

	// 关注公众号事件
	public function subscribe() {
		return true;
	}
	
	// 取消关注公众号事件
	public function unsubscribe() {
		return true;
	}
	
	// 扫描带参数二维码事件
	public function scan() {
		$config = getAddonConfig ( 'Liuyanban' ); // 获取后台插件的配置参数	
		$param['token']=get_token();				//获取当前公众号的token
		$param['openid']=get_openid();					//获取当前用户的openid
		$url=addons_url('Liuyanban://Liuyanban/index',$param);		//生成微信回复图文消息跳转链接
		$picurl=$config['cover']?get_cover_url($config['cover']):$config['cover_url'];	//生成微信回复图文消息封面图片地址
		$articles[0]=array(
			'Title'=>$config['title'],
			'Description'=>$config['desc'],
			'PicUrl'=>$picurl,
			'Url'=>$url
		);
		$this->replyNews($articles);

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
        	