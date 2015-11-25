<?php

namespace Addons\Liuyanban;
use Common\Controller\Addon;

/**
 * 留言板插件
 * @author 艾逗笔
 * @version 1.0
 * Modified at 2014/11/24 11:18
 */
class LiuyanbanAddon extends Addon{

        // 插件基本信息
        public $info = array(
            'name'=>'Liuyanban',
            'title'=>'留言板',
            'description'=>'留言板插件',
            'status'=>1,
            'author'=>'艾逗笔',
            'version'=>'1.0',
            'has_adminlist'=>0,
            'type'=>1         
        );

	public function install() {
		$install_sql = './Addons/Liuyanban/install.sql';
		if (file_exists ( $install_sql )) {
			execute_sql_file ( $install_sql );
		}
		return true;
	}
	public function uninstall() {
		$uninstall_sql = './Addons/Liuyanban/uninstall.sql';
		if (file_exists ( $uninstall_sql )) {
			execute_sql_file ( $uninstall_sql );
		}
		return true;
	}

        //实现的weixin钩子方法
        public function weixin($param){

        }

    }