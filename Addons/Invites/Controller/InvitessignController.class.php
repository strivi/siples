<?php
namespace Addons\Invites\Controller;
use Home\Controller\AddonsController;

class InvitessignController extends AddonsController{
	var $model;
	function _initialize() {
		$this->model = $this->getModel ( 'Invitessign' );
		parent::_initialize ();
	}
    // 通用插件的列表模型
	public function lists() {
		
		$map ['token'] = get_token ();

		if(I ('iid')){
			$map ['mid'] = I ('iid');
		}
		
		
		session ( 'common_condition', $map );
		
		//获取签到所属邀请名
		$list_data = $this->_get_model_list ( $this->model );

		foreach ($list_data[list_data] as &$vo){
			$map ['id'] = $vo[mid];
			$vo['mid'] = M('invites')->where($map)->getfield('title');
		}
		
		//dump($list_data);

			//die();
		$iid = $map ['mid'];
		$this->assign ( 'iid',$iid );

		$this->assign ( $list_data );
		$templateFile = $this->model ['template_list'] ? $this->model ['template_list'] : '';
		$this->display ( $templateFile );
	}

	public function saveExcel(){


		$map ['token'] = get_token ();

		if(I ('iid')){
			$map ['mid'] = I ('iid');
		}

		$excel_data = M('invitessign')->where($map)->select();

		foreach ($excel_data as &$vo){
			$map ['id'] = $vo['mid'];
			$vo['mid'] = M('invites')->where($map)->getfield('title');
			$vo['rdogo'] = $vo['rdogo'] ? '不参加' : '参加';
		}

		$excel_name = I ('iid') ? $excel_data[0]['mid'] : '';

		excel_set($excel_data,$excel_name);
  
    }  
	
	// 通用插件的编辑模型
	public function edit() {

		$model = $this->model;

		is_array ( $model ) || $model = $this->getModel ( $model );
		$id || $id = I ( 'id' );
		
		// 获取数据
		$data = M ( get_table_name ( $model ['id'] ) )->find ( $id );
		$data || $this->error ( '数据不存在！' );
		
		$token = get_token ();
		if (isset ( $data ['token'] ) && $token != $data ['token'] && defined ( 'ADDON_PUBLIC_PATH' )) {
			$this->error ( '非法访问！' );
		}
		
		if (IS_POST) {
			$Model = D ( parse_name ( get_table_name ( $model ['id'] ), 1 ) );
			// 获取模型的字段信息
			$Model = $this->checkAttr ( $Model, $model ['id'] );
			if ($Model->create () && $Model->save ()) {
				
				$this->success ( '保存' . $model ['title'] . '成功！', U ( 'lists?iid=' . $_POST['mid'], $this->get_param ) );
			} else {
				$this->error ( $Model->getError () );
			}
		} else {
			$fields = get_model_attribute ( $model ['id'] );

			//提取所属邀请名
			$fields['1']['mid']['extra'] = $this->getCateData ();
			
			//选定所属邀请名
			$fields['1']['mid']['value'] = $data['mid'];

			//dump($this->get_param);
			//die();
			
			$this->assign ( 'fields', $fields );
			$this->assign ( 'data', $data );
			$this->meta_title = '编辑' . $model ['title'];
			
			$templateFile || $templateFile = $model ['template_edit'] ? $model ['template_edit'] : '';
			$this->display ( $templateFile );
		}
	}
	
	// 通用插件的增加模型
	public function add() {
		$model = $this->model;
	
		if (IS_POST) {

			$Model = D ( parse_name ( get_table_name ( $model ['id'] ), 1 ) );
			// 获取模型的字段信息
			
			$Model = $this->checkAttr ( $Model, $model ['id'] );

			if ($pdatas = $Model->create () && $id = $Model->add ()) {
				
				$this->success ( '添加' . $model ['title'] . '成功！', U ( 'lists?model=' . $model ['name'], $this->get_param ) );
			} else {
				$this->error ( $Model->getError () );
			}
		} else {

			$fields = get_model_attribute ( $model ['id'] );
			
			//提取所属邀请名
			$fields['1']['mid']['extra'] = $this->getCateData ();
			
			//选定所属邀请名
			if(I('iid')){
				$fields['1']['mid']['value'] = I('iid');
			}

			$this->assign ( 'fields', $fields );
			$this->meta_title = '新增' . $model ['title'];
			
			$templateFile || $templateFile = $model ['template_add'] ? $model ['template_add'] : '';
			$this->display ( $templateFile );
		}
	}
	
	
	// 通用插件的删除模型
	public function del() {
		parent::common_del ( $this->model );
	}

	// 获取所属分类
	function getCateData() {
		$map ['token'] = get_token ();
		$list = M ( 'invites' )->where ( $map )->select ();
		foreach ( $list as $v ) {
			$extra .= $v ['id'] . ':' . $v ['title'] . "\r\n";
		}
		return $extra;
	}
}

?>