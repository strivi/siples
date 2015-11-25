<?php

namespace Addons\Debug\Controller;
use Home\Controller\AddonsController;

class DebugController extends AddonsController{
    function _initialize() {
        parent::_initialize();
        
        $controller = strtolower ( _CONTROLLER );
        
        $res ['title'] = '模拟测试';
        $res ['url'] = addons_url ( 'Debug://Debug/lists' );
        $res ['class'] = $controller == 'debug' ? 'current' : '';
        $nav [] = $res;

        $res ['title'] = '消息日志';
        $res ['url'] = addons_url ( 'Debug://Log/lists' );
        $res ['class'] = $controller == 'log' ? 'current' : '';
        $nav [] = $res;
        
        $this->assign ( 'nav', $nav );
        
    }

    function random($length, $numeric = 0) {
        $seed = base_convert(md5(microtime().$_SERVER['DOCUMENT_ROOT']), 16, $numeric ? 10 : 35);
        $seed = $numeric ? (str_replace('0', '', $seed).'012340567890') : ($seed.'zZ'.strtoupper($seed));
        if($numeric) {
            $hash = '';
        } else {
            $hash = chr(rand(1, 26) + rand(0, 1) * 32 + 64);
            $length--;
        }
        $max = strlen($seed) - 1;
        for($i = 0; $i < $length; $i++) {
            $hash .= $seed{mt_rand(0, $max)};
        }
        return $hash;
    }

    function lists() {
        $timestamp = NOW_TIME;
        $nonce = $this->random(5);
        $token = 'weiphp';
        $signkey = array($token, $timestamp, $nonce);
        sort($signkey, SORT_STRING);
        $signString = implode($signkey);
        $signString = sha1($signString);

        $url = "/index.php?s=/home/weixin/index.html&timestamp=".$timestamp."&nonce=".$nonce."&signature=".$signString;

        $this->assign ( 'url', $url );

        $mp = M ( 'member_public' )->join("(SELECT mp_id FROM `wp_member_public_link` WHERE uid = '{$this->mid}' AND `is_use` = 1) as A on id = mp_id" )->find();

        $this->assign ( 'wechat', $mp['wechat'] );

        $this->assign ( 'toUser', get_token() );

        $this->display();
    }
}
