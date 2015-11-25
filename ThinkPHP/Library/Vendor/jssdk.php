<?php
class JSSDK {
  private $appId;

  public function __construct($token = '') {
  	empty ( $token ) && $token = get_token ();
  	$info = get_token_appinfo ( $token );
	if (empty ( $info ['appid'] )) {
		return 0;
	}
    $this->appId = $info ['appid'];
  }

  public function getSignPackage() {
  	
    $jsapiTicket = get_api_ticket ('jsapi');

    // 注意 URL 一定要动态获取，不能 hardcode.
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    $url = "$protocol$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

    $timestamp = time();
    $nonceStr = $this->createNonceStr();

    // 这里参数的顺序要按照 key 值 ASCII 码升序排序
    $string = "jsapi_ticket=$jsapiTicket&noncestr=$nonceStr&timestamp=$timestamp&url=$url";

    $signature = sha1($string);

    $signPackage = array(
      "appId"     => $this->appId,
      "nonceStr"  => $nonceStr,
      "timestamp" => $timestamp,
      "url"       => $url,
      "signature" => $signature,
      "rawString" => $string
    );
    return $signPackage; 
  }
  
  public function getCardExtPackage($card_id, $openid = '', $code = '', $balance = '') {
  	
    $apiTicket = get_api_ticket ('wx_card');
    
    $timestamp = time();

    // 这里参数的顺序要按照 value 值 ASCII 码升序排序
	$array = array();
	array_push($array, (string)$apiTicket);
	array_push($array, (string)$card_id);
	array_push($array, (string)$openid);
	array_push($array, (string)$code);
	array_push($array, (string)$balance);
	array_push($array, (string)$timestamp);
	sort($array);
	$string = implode($array);
    $signature = sha1($string);

    $cardExtPackage = array(
      "code"     => $code,
      "openid"  => $openid,
      "timestamp" => $timestamp,
      "signature" => $signature,
      "balance" => $balance
    );
    return $cardExtPackage; 
  }
  
  public function getCardExtPackage2($card_id) {
	$timestamp = time();
	$signaArray = array();
	$appsecret = 'd835d7c0b0ef2da7f80e9f314327b143';
	array_push($signaArray, (string)$timestamp);
	array_push($signaArray, (string)$appsecret);
	array_push($signaArray, (string)$card_id);
	sort( $array);
	$signa = sha1(implode($signaArray));

    $cardExtPackage = array(
      "timestamp" => $timestamp,
      "signature" => $signa
    );
    return $cardExtPackage; 
  }

  private function createNonceStr($length = 16) {
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    $str = "";
    for ($i = 0; $i < $length; $i++) {
      $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
    }
    return $str;
  }

  private function httpGet($url) {
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_TIMEOUT, 500);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_URL, $url);

    $res = curl_exec($curl);
    curl_close($curl);

    return $res;
  }
}

