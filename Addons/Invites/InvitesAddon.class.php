<?php

namespace Addons\Invites;
use Common\Controller\Addon;

/**
 * 微邀请插件
 * @author kocorp
 */

    class InvitesAddon extends Addon{

        public $info = array(
            'name'=>'Invites',
            'title'=>'微邀请',
            'description'=>'微邀请，目前提供会议，聚会，活动类型的微邀请，有两个展示模板可以选择。微邀请 V2.0 增加微邀请签到EXCEL导出功能，完善插件结构。',
            'status'=>1,
            'author'=>'kocorp',
            'version'=>'2.0',
            'has_adminlist'=>1,
            'type'=>1         
        );

	public function install() {
		$install_sql = './Addons/Invites/install.sql';
		if (file_exists ( $install_sql )) {
			execute_sql_file ( $install_sql );
		}
		return true;
	}
	public function uninstall() {
		$uninstall_sql = './Addons/Invites/uninstall.sql';
		if (file_exists ( $uninstall_sql )) {
			execute_sql_file ( $uninstall_sql );
		}
		return true;
	}

        //实现的weixin钩子方法
        public function weixin($param){

        }

    }