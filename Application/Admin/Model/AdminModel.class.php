<?php
namespace Admin\Model;
use Think\Model;
class AdminModel extends Model 
{
	protected $insertFields = array('username','password','cpassword','is_use','chkcode');
	protected $updateFields = array('id','username','password','cpassword','is_use');
	// 添加和修改管理员时的规则
	protected $_validate = array(
		array('username', 'require', '账号不能为空！', 1, 'regex', 3),
		array('username', 'require', '管理员名称不能重复！', 1, 'unique', 3),
		array('username', '1,30', '账号的值最长不能超过 30 个字符！', 1, 'length', 3),
		array('password', 'require', '密码不能为空！', 1, 'regex', 1),
		array('cpassword', 'password', '请重新确认密码！', 1, 'confirm', 3),
		array('is_use', 'number', '是否启用 1：启用0：禁用必须是一个整数！', 2, 'regex', 3),
	);
	// 登录时表单验证的规则 
	public $_login_validate = array(
		array('username', 'require', '用户名不能为空！', 1),
		array('password', 'require', '密码不能为空！', 1),
		array('chkcode', 'require', '验证码不能为空！', 1),
		array('chkcode', 'chk_chkcode', '验证码不正确！', 1, 'callback'),
	);
	//验证码的检测
	public function chk_chkcode($code){	
		 $verify = new \Think\Verify();
		 return $verify->check($code);
	}
	//登录验证
	public function login(){
		//获取表单中的用户名和密码;
		$username=$this->username;
		$password=$this->password;
		//先查询数据库中有没有这个账号;
		$user=$this->where(array(
			'username'=>array('eq',$username),
			))->find();
		//判断有没有账号
		if($user){
			//判断是否启用(超级管理员禁止启用)
			if($user['id']==1||$user['is_use']==1){
				//判断密码
				if($user['password']==md5($password)){
					//把id和用户名存到session中
					session('id',$user['id']);
					session('username',$user['username']);
					return true;
				}else{
			$this->error='密码不正确!';
			return false;
				}
			}else{
			$this->error='账号被禁用!';
			return false;
			}
		}else{
			$this->error='用户名不存在!';
			return false;
		}
	}
	public function search($pageSize = 20)
	{
		/**************************************** 搜索 ****************************************/
		$where = array();
		if($username = I('get.username'))
			$where['username'] = array('like', "%$username%");
		$is_use = I('get.is_use');
		if($is_use != '' && $is_use != '-1')
			$where['is_use'] = array('eq', $is_use);
		/************************************* 翻页 ****************************************/
		$count = $this->alias('a')->where($where)->count();
		$page = new \Think\Page($count, $pageSize);
		// 配置翻页的样式
		$page->setConfig('prev', '上一页');
		$page->setConfig('next', '下一页');
		$data['page'] = $page->show();
		/************************************** 取数据 ******************************************/
		$data['data'] = $this->alias('a')->where($where)->group('a.id')->limit($page->firstRow.','.$page->listRows)->select();
		return $data;
	}
	// 添加前
	protected function _before_insert(&$data, $option)
	{
		$data['password']=md5($data['password']);
	}
	// 添加后
	protected function _after_insert(&$data, $option)
	{
		$roleId = I('post.role_id');
		if($roleId)
		{
			$arModel = M('AdminRole');
			foreach ($roleId as $k => $v)
			{
				$arModel->add(array(
					'role_id' => $v,
					'admin_id' => $data['id'],
				));
			}
		}
	}

	// 修改前
	protected function _before_update(&$data, $option)
	{	
		//超级管理员禁止禁用;
		if($option['where']['id']==1){
			$data['is_use']=1;
		}
		
		$roleId = I('post.role_id');
		//添加之前先清除之前的数据;
		$arModel=M('AdminRole');
		$arModel->where(array('admin_id'=>array('eq',$option['where']['id'])))->delete();
		if($roleId)
		{
			$arModel = M('AdminRole');
			foreach ($roleId as $k => $v)
			{
				$arModel->add(array(
					'role_id' => $v,
					'admin_id' =>$option['where']['id'],
				));
			}
		}

		//判断密码为空就不修改这个字段;
		if(empty($data['password'])){
			unset($data['password']);
		}else{
		$data['password']=md5($data['password']);	
		}
		
	}
	// 删除前
	protected function _before_delete($option)
	{

		$arModel=M('AdminRole');
		if($option['where']['id']==1){
			$this->error='超级管理员禁止删除!';
			return false;
		}else{
			$arModel->where(array('admin_id'=>array('eq',$option['where']['id'])))->delete();
		}	
	}

	/************************************ 其他方法 ********************************************/
}