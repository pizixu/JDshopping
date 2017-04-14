<?php
namespace Admin\Controller;
use \Admin\Controller\IndexController;
class AdminController extends IndexController 
{
    public function add()
    {
    	if(IS_POST)
    	{
    		$model = D('Admin/Admin');          
    		if($data=$model->create(I('post.'), 1))
    		{ 
    			if($id = $model->add())
    			{
    				$this->success('添加成功！', U('lst?p='.I('get.p')));
    				exit;
    			}
    		}
    		$this->error($model->getError());
    	}
        //取出所有的角色!
        $roleModel=D('role');
        $roleData=$roleModel->select();
        $this->assign('roleData',$roleData);


		$this->setPageBtn('添加管理员', '管理员列表', U('lst?p='.I('get.p')));
		$this->display();
    }
    public function edit()
    {
        //要修改的管理员的id;
    	$id = I('get.id');
        //当前管理员的id;
        $adminID=session('id');

        //判断修改权限;
        //如果是普通管理员,无权修改其他管理员的信息;
        if($adminID>1&&$adminID!=$id){
            $this->error('无权修改');
        }
    	if(IS_POST)
    	{
    		$model = D('Admin/Admin');
    		if($model->create(I('post.'), 2))
    		{
    			if($model->save() !== FALSE)
    			{
    				$this->success('修改成功！', U('lst', array('p' => I('get.p', 1))));
    				exit;
    			}
    		}
    		$this->error($model->getError());
    	}
        //取出所有的角色!
        $roleModel=D('role');
        $roleData=$roleModel->select();
        $this->assign('roleData',$roleData);

        //取出当前管理员所有的角色的id;
        $arModel=M('AdminRole');
        $rid=$arModel->field('GROUP_CONCAT(role_id) role_id')->where(array('admin_id'=>array('eq',$id)))->find();
        $this->assign('rid',$rid['role_id']);

    	$model = M('Admin');
    	$data = $model->find($id);
    	$this->assign('data', $data);

		$this->setPageBtn('修改管理员', '管理员列表', U('lst?p='.I('get.p')));
		$this->display();
    }
    public function delete()
    {
    	$model = D('Admin/Admin');
    	if($model->delete(I('get.id', 0)) !== FALSE)
    	{
    		$this->success('删除成功！', U('lst', array('p' => I('get.p', 1))));
    		exit;
    	}
    	else 
    	{
    		$this->error($model->getError());
    	}
    }
    public function lst()
    {
    	$model = D('Admin/Admin');
    	$data = $model->search();
    	$this->assign(array(
    		'data' => $data['data'],
    		'page' => $data['page'],
    	));

		$this->setPageBtn('管理员列表', '添加管理员', U('add'));
    	$this->display();
    }
    public function ajaxUpdateIsuse(){
        $adminId = I('get.id');
        // 超级管理员不能修改
        if($adminId == 1)
            return FALSE;
        // 不能修改别人的启用状态,除非是超级管理员
        $myId = session('id');
        if($adminId != $myId && $myId > 1)
            return FALSE;
        
        $model = M('Admin');
        $info = $model->find($adminId);
        // 判断如果当前是启用的就修改为禁用
        if($info['is_use'] == 1)
        {
            $model->where(array('id'=>array('eq', $adminId)))->setField('is_use', 0);
            echo 0;
        }
        else 
        {
            $model->where(array('id'=>array('eq', $adminId)))->setField('is_use', 1);
            echo 1;
        }
    }
    }
