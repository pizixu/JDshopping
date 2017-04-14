<?php
namespace Admin\Controller;
use \Admin\Controller\IndexController;
class GoodsController extends IndexController 
{
    public function add()
    {
    	if(IS_POST)
    	{
            // 设置这个脚本可以执行的时间，单位：秒，0：代表一直执行到结束，默认30秒
            set_time_limit(0);
    		$model = D('Admin/Goods');
    		if($model->create(I('post.'), 1))
    		{
    			if($id = $model->add())
    			{
    				$this->success('添加成功！', U('lst?p='.I('get.p')));
    				exit;
    			}
    		}
    		$this->error($model->getError());
    	}
        //取出所有的商品类型;
        $typeModel=M('Type');
        $typeData=$typeModel->select();
        $this->assign('typeData',$typeData);

        //取出所有的商品分类;
        $catModel=D('category');
        $catData=$catModel->getTree();
        $this->assign('catData',$catData);

        //取出所有的商品品牌;
        $brandModel=D('brand');
        $brandData=$brandModel->select();
        $this->assign('brandData',$brandData);

        //取出所有的会员级别;
        $mlModel=M('MemberLevel');
        $mlData=$mlModel->select();
        $this->assign('mlData',$mlData);

		$this->setPageBtn('添加商品', '商品列表', U('lst?p='.I('get.p')));
		$this->display();
    }
    public function edit()
    {
    	$id = I('get.id');
    	if(IS_POST)
    	{
    		$model = D('Admin/Goods');
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
    	$model = M('Goods');
    	$data = $model->find($id);
    	$this->assign('data', $data);

		$this->setPageBtn('修改商品', '商品列表', U('lst?p='.I('get.p')));
		$this->display();
    }
    public function delete()
    {
    	$model = D('Admin/Goods');
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
    	$model = D('Admin/Goods');
    	$data = $model->search();
    	$this->assign(array(
    		'data' => $data['data'],
    		'page' => $data['page'],
    	));

		$this->setPageBtn('商品列表', '添加商品', U('add'));
    	$this->display();
    }
    //AJAX获取属性根据类型的id;
    public function ajaxGetAttr(){
        //客户端通过Ajax获取id;
        $typeId=I('get.type_id');
        $attrModel=M('Attribute');
        //根据类型id取出属性;
        $attrData=$attrModel->where(array('type_id'=>array('eq',$typeId)))->select();
        echo json_encode($attrData);
    }
}