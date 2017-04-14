<?php
namespace Admin\Controller;
use Think\Controller;
class LoginController extends Controller 
{
 	public function login(){
		//处理表单;
		if(IS_POST){
			$model=D('admin');
			//使用validate方法来指定使用模型中的哪个数组来作为登录验证规则
			if($model->validate($model->_login_validate)->create()){
				if($model->login()){
					redirect(U('Admin/Index/index'));//登录成功直接跳转;
				}
			}
			$this->error($model->getError());
		}
		//显示表单;
	 $this->display();
	}
	public function chkcode(){
		$config =    array(  
			'fontSize'    =>    30,    // 验证码字体大小  
			'length'      =>    3,     // 验证码位数    
			'useNoise'    =>    false, // 关闭验证码杂点
		    );
		$Verify = new \Think\Verify($config);
		$Verify->entry();
	}
}














