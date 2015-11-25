<?php

namespace Addons\Help;
use Common\Controller\Addon;

/**
 * 帮助插件
 * @author 梅枭雄
 */

    class HelpAddon extends Addon{

        public $info = array(
            'name'=>'Help',
            'title'=>'帮助',
            'description'=>'这是一个临时描述',
            'status'=>1,
            'author'=>'梅枭雄',
            'version'=>'0.1',
            'has_adminlist'=>1,
            'type'=>1         
        );

	public function install() {
		$install_sql = './Addons/Help/install.sql';
		if (file_exists ( $install_sql )) {
			execute_sql_file ( $install_sql );
		}
		return true;
	}
	public function uninstall() {
		$uninstall_sql = './Addons/Help/uninstall.sql';
		if (file_exists ( $uninstall_sql )) {
			execute_sql_file ( $uninstall_sql );
		}
		return true;
	}

        //实现的weixin钩子方法
        public function weixin($param){

        }

    }