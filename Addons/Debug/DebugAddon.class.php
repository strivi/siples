<?php

namespace Addons\Debug;
use Common\Controller\Addon;

/**
 * 模拟测试插件
 * @author 小新
 */

    class DebugAddon extends Addon{

        public $info = array(
            'name'=>'Debug',
            'title'=>'模拟测试',
            'description'=>'微信公众平台消息模拟测试',
            'status'=>1,
            'author'=>'小新',
            'version'=>'0.1',
            'has_adminlist'=>1,
            'type'=>1         
        );

	public function install() {
		$install_sql = './Addons/Debug/install.sql';
		if (file_exists ( $install_sql )) {
			execute_sql_file ( $install_sql );
		}
		return true;
	}
	public function uninstall() {
		$uninstall_sql = './Addons/Debug/uninstall.sql';
		if (file_exists ( $uninstall_sql )) {
			execute_sql_file ( $uninstall_sql );
		}
		return true;
	}

        //实现的weixin钩子方法
        public function weixin($param){

        }

    }