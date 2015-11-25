<?php

namespace Addons\Scratch\Controller;

use Home\Controller\AddonsController;

class ScratchMemberController extends BaseController {
	
	var $table = 'scratch_member';
	
	function lists(){
		
		$model = $this->getModel ( $this->table );	
		$map ['addon'] = $this->addon;
		$map ['target_id'] = I ( 'target_id' );
		$map ['token'] = get_token ();
		session ( 'common_condition', $map );		
		parent::lists ( $model );
	}
	
	function add() {
		if (IS_POST) {
			$_POST ['addon'] = $this->addon;
			$_POST ['target_id'] = session ( 'target_id' );
		}
		
		$model = $this->getModel ( $this->table );
		parent::add ( $model );
	}
	function edit() {
		$model = $this->getModel ( $this->table );
		parent::edit ( $model );
	}
	function del() {
		$model = $this->getModel ( $this->table );
		parent::del ( $model );
	}


}
