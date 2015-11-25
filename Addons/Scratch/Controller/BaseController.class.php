<?php

namespace Addons\Scratch\Controller;

use Home\Controller\AddonsController;

class BaseController extends AddonsController {
	function _initialize() {		
		parent::_initialize();
				
		$controller = strtolower ( _CONTROLLER );	
		$data['target_id'] = I ( 'target_id' );
			
		$res ['title'] = '刮刮卡';
		$res ['url'] = addons_url ( 'Scratch://Scratch/lists' );
		$res ['class'] = $controller == 'scratch' ? 'current' : '';
		$nav [] = $res;
		
		$res ['title'] = '奖品设置';
		$res ['url'] = addons_url ( 'Scratch://Prize/lists',$data);
		$res ['class'] = $controller == 'prize' ? 'current' : '';
		$nav [] = $res;
		
		$res ['title'] = '中奖管理';
		$res ['url'] = addons_url ( 'Scratch://Sn/lists',$data);
		$res ['class'] = $controller == 'sn' ? 'current' : '';
		$nav [] = $res;
		
		$res ['title'] = '活动参与者';
		$res ['url'] = addons_url ( 'Scratch://ScratchMember/lists',$data);
		$res ['class'] = $controller == 'scratchmember' ? 'current' : '';
		$nav [] = $res;
		$this->assign ( 'nav', $nav );
	}
}
