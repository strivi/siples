<?php

namespace Addons\Debug\Controller;
use Home\Controller\AddonsController;

class LogController extends AddonsController{
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

    public function lists() {
        
        $model  = M('weixin_log');
        $count  = $model->count();
        $Page   = new \Think\Page($count,20);
        $nowPage = isset($_GET['p'])?$_GET['p']:1;
        $list   = $model->order('id desc')->page($nowPage.','.$Page->listRows)->select();
        $show   = $Page->show();

        $this->assign('page',$show);// 赋值分页输出
        $this->assign('list',$list);// 赋值数据集
        
        $this->display ();
    }
}
