<?php

namespace Addons\WxTemplate;
use Common\Controller\Addon;

/**
 * 微信模板管理插件
 * @author 梅枭雄
 */

    class WxTemplateAddon extends Addon{

        public $info = array(
            'name'=>'WxTemplate',
            'title'=>'微信模板管理',
            'description'=>'微信模板管理',
            'status'=>1,
            'author'=>'梅枭雄',
            'version'=>'0.1',
            'has_adminlist'=>1,
            'type'=>1         
        );

	public function install() {
		$install_sql = './Addons/WxTemplate/install.sql';
		if (file_exists ( $install_sql )) {
			execute_sql_file ( $install_sql );
		}
		return true;
	}
	public function uninstall() {
		$uninstall_sql = './Addons/WxTemplate/uninstall.sql';
		if (file_exists ( $uninstall_sql )) {
			execute_sql_file ( $uninstall_sql );
		}
		return true;
	}

        //实现的weixin钩子方法
        public function weixin($param){

        }

    }