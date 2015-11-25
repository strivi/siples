<?php

namespace Addons\WifiVerify;
use Common\Controller\Addon;

/**
 * WifiVerify插件
 * @author 梅枭雄
 */

    class WifiVerifyAddon extends Addon{

        public $info = array(
            'name'=>'WifiVerify',
            'title'=>'WifiVerify',
            'description'=>'',
            'status'=>1,
            'author'=>'梅枭雄',
            'version'=>'0.1',
            'has_adminlist'=>1,
            'type'=>1         
        );

	public function install() {
		$install_sql = './Addons/WifiVerify/install.sql';
		if (file_exists ( $install_sql )) {
			execute_sql_file ( $install_sql );
		}
		return true;
	}
	public function uninstall() {
		$uninstall_sql = './Addons/WifiVerify/uninstall.sql';
		if (file_exists ( $uninstall_sql )) {
			execute_sql_file ( $uninstall_sql );
		}
		return true;
	}

        //实现的weixin钩子方法
        public function weixin($param){

        }

    }