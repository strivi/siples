<?php 

namespace Addons\Liuyanban\Controller;
use Addons\Liuyanban\Controller\LiuyanbanController;

/**
 * 留言管理控制器
 * @author 艾逗笔
 * @version 1.0
 * Modified at 2014/11/24 11:18
 */
class MessageController extends LiuyanbanController{

	// 初始化方法
	public function _initialize(){
		$this->model=$this->getModel('lyb_message');	// 初始化留言模型
		parent::_initialize();							// 调用父类的初始化方法显示导航条
	}

	// 通用数据列表方法
	public function lists(){
		parent::common_lists($this->model);
	}

	// 通用数据增加方法
	public function add(){
		parent::common_add($this->model);
	}

	// 通用数据编辑方法
	public function edit(){
		parent::common_edit($this->model);
	}

	// 通用数据删除方法
	public function del(){
		parent::common_del($this->model);
	}





}


 ?>