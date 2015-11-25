<?php

namespace Addons\Sendredpack;
use Common\Controller\Addon;

/**
 * 发送红包插件
 * @author 梅枭雄
 */

    class SendredpackAddon extends Addon{

        public $info = array(
            'name'=>'Sendredpack',
            'title'=>'发送红包',
            'description'=>'',
            'status'=>1,
            'author'=>'梅枭雄',
            'version'=>'0.1',
            'has_adminlist'=>1,
            'type'=>1         
        );

	public function install() {
		$install_sql = './Addons/Sendredpack/install.sql';
		if (file_exists ( $install_sql )) {
			execute_sql_file ( $install_sql );
		}
		return true;
	}
	public function uninstall() {
		$uninstall_sql = './Addons/Sendredpack/uninstall.sql';
		if (file_exists ( $uninstall_sql )) {
			execute_sql_file ( $uninstall_sql );
		}
		return true;
	}

        //实现的weixin钩子方法
        public function weixin($param){

        }

    }