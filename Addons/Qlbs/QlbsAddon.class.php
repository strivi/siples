<?php

namespace Addons\Qlbs;
use Common\Controller\Addon;

/**
 * 百度LBS云插件
 * @author 剑煮红颜
 */

    class QlbsAddon extends Addon{

        public $info = array(
            'name'=>'Qlbs',
            'title'=>'百度LBS云',
            'description'=>'基于百度LBS云和微信地理位置上报功能，来显示周边商铺信息的插件',
            'status'=>1,
            'author'=>'剑煮红颜',
            'version'=>'0.1',
            'has_adminlist'=>1,
            'type'=>1         
        );

	public function install() {
		$install_sql = './Addons/Qlbs/install.sql';
		if (file_exists ( $install_sql )) {
			execute_sql_file ( $install_sql );
		}
		return true;
	}
	public function uninstall() {
		$uninstall_sql = './Addons/Qlbs/uninstall.sql';
		if (file_exists ( $uninstall_sql )) {
			execute_sql_file ( $uninstall_sql );
		}
		return true;
	}

        //实现的weixin钩子方法
        public function weixin($param){

        }

    }