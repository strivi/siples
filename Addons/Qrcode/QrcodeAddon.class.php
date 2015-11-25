<?php

namespace Addons\Qrcode;
use Common\Controller\Addon;

/**
 * 生成二维码插件
 * @author 大灰狼qq68312601
 */

    class QrcodeAddon extends Addon{

        public $info = array(
            'name'=>'Qrcode',
            'title'=>'生成二维码',
            'description'=>'生成二维码',
            'status'=>1,
            'author'=>'大灰狼qq68312601',
            'version'=>'0.1',
            'has_adminlist'=>1,
            'type'=>1         
        );

	public function install() {
		$install_sql = './Addons/Qrcode/install.sql';
		if (file_exists ( $install_sql )) {
			execute_sql_file ( $install_sql );
		}
		return true;
	}
	public function uninstall() {
		$uninstall_sql = './Addons/Qrcode/uninstall.sql';
		if (file_exists ( $uninstall_sql )) {
			execute_sql_file ( $uninstall_sql );
		}
		return true;
	}

        //实现的weixin钩子方法
        public function weixin($param){

        }

    }