<?php
namespace Admin\Model;
use Think\Model;
class AdminModel extends Model{
	// 登录时表单验证的规则 
	public $_login_validate = array(
		array('username', 'require', '用户名不能为空！', 1),
		array('password', 'require', '密码不能为空！', 1),
		array('chkcode', 'require', '验证码不能为空！', 1),
		array('chkcode', 'chk_chkcode', '验证码不正确！', 1, 'callback'),
	);
	// 添加和修改管理员时的规则
	public $_validate = array(
	
	);
	//验证码的检测
	public function chk_chkcode($code){	
		 $verify = new \Think\Verify();
		 return $verify->check($code);
	}
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
				if($user['password']==$password){
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
}










