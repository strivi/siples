<?php

namespace Addons\WxTemplate\Controller;
use Home\Controller\AddonsController;

class WxTemplateController extends AddonsController{
	var $table = 'wx_template';


	public function lists() {
		$model = $this->getModel ( $this->table );	
		parent::common_lists ( $model );
	}
	
	// 通用插件的编辑模型
	public function edit() {
		$id = I ( 'id' );
		$model = $this->getModel ( $this->table );	
		parent::common_edit ( $model, $id );
	}
	
	// 通用插件的增加模型
	public function add() {
		$model = $this->getModel ( $this->table );	
		parent::common_add ( $model );
	}


}
