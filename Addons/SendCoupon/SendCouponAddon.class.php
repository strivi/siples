<?php

namespace Addons\SendCoupon;
use Common\Controller\Addon;

/**
 * 代金券管理插件
 * @author 梅枭雄
 */

    class SendCouponAddon extends Addon{

        public $info = array(
            'name'=>'SendCoupon',
            'title'=>'代金券管理',
            'description'=>'商户给用户发放代金券',
            'status'=>1,
            'author'=>'梅枭雄',
            'version'=>'0.1',
            'has_adminlist'=>1,
            'type'=>1         
        );

	public function install() {
		$install_sql = './Addons/SendCoupon/install.sql';
		if (file_exists ( $install_sql )) {
			execute_sql_file ( $install_sql );
		}
		return true;
	}
	public function uninstall() {
		$uninstall_sql = './Addons/SendCoupon/uninstall.sql';
		if (file_exists ( $uninstall_sql )) {
			execute_sql_file ( $uninstall_sql );
		}
		return true;
	}

        //实现的weixin钩子方法
        public function weixin($param){

        }

    }