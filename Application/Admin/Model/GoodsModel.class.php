<?php
namespace Admin\Model;
use Think\Model;
class GoodsModel extends Model 
{
	protected $insertFields = array('goods_name','cat_id','brand_id','market_price','shop_price','jifen','jyz','jifen_price','is_promote','promote_price','promote_start_time','promote_end_time','is_hot','is_new','is_best','is_on_sale','seo_keyword','seo_description','type_id','sort_num','is_delete','goods_desc','is_promote');
	protected $updateFields = array('id','goods_name','cat_id','brand_id','market_price','shop_price','jifen','jyz','jifen_price','is_promote','promote_price','promote_start_time','promote_end_time','is_hot','is_new','is_best','is_on_sale','seo_keyword','seo_description','type_id','sort_num','is_delete','goods_desc');
	protected $_validate = array(
		array('goods_name', 'require', '商品名称不能为空！', 1, 'regex', 3),
		array('goods_name', '1,45', '商品名称的值最长不能超过 45 个字符！', 1, 'length', 3),
		array('cat_id', 'require', '主分类的id不能为空！', 1, 'regex', 3),
		array('cat_id', 'number', '主分类的id必须是一个整数！', 1, 'regex', 3),
		array('market_price', 'currency', '市场价必须是货币格式！', 2, 'regex', 3),
		array('shop_price', 'currency', '本店价必须是货币格式！', 2, 'regex', 3),
		array('jifen', 'require', '赠送积分不能为空！', 1, 'regex', 3),
		array('jifen', 'number', '赠送积分必须是一个整数！', 1, 'regex', 3),
		array('jyz', 'require', '赠送经验值不能为空！', 1, 'regex', 3),
		array('jyz', 'number', '赠送经验值必须是一个整数！', 1, 'regex', 3),
		array('jifen_price', 'require', '如果要用积分兑换，需要的积分数不能为空！', 1, 'regex', 3),
		array('jifen_price', 'number', '如果要用积分兑换，需要的积分数必须是一个整数！', 1, 'regex', 3),
		array('is_promote', 'number', '是否促销必须是一个整数！', 2, 'regex', 3),
		array('promote_price', 'currency', '促销价必须是货币格式！', 2, 'regex', 3),
		array('promote_start_time', 'number', '促销开始时间必须是一个整数！', 2, 'regex', 3),
		array('promote_end_time', 'number', '促销结束时间必须是一个整数！', 2, 'regex', 3),
		array('is_hot', 'number', '是否热卖必须是一个整数！', 2, 'regex', 3),
		array('is_new', 'number', '是否新品必须是一个整数！', 2, 'regex', 3),
		array('is_best', 'number', '是否精品必须是一个整数！', 2, 'regex', 3),
		array('is_on_sale', 'number', '是否上架：1：上架，0：下架必须是一个整数！', 2, 'regex', 3),
		array('seo_keyword', '1,150', 'seo优化[搜索引擎【百度、谷歌等】优化]_关键字的值最长不能超过 150 个字符！', 2, 'length', 3),
		array('seo_description', '1,150', 'seo优化[搜索引擎【百度、谷歌等】优化]_描述的值最长不能超过 150 个字符！', 2, 'length', 3),
		array('type_id', 'number', '商品类型id必须是一个整数！', 2, 'regex', 3),
		array('sort_num', 'number', '排序数字必须是一个整数！', 2, 'regex', 3),
		array('is_delete', 'number', '是否放到回收站：1：是，0：否必须是一个整数！', 2, 'regex', 3),
	);
	public function search($pageSize = 20)
	{
		/**************************************** 搜索 ****************************************/
		$where = array();
		if($goods_name = I('get.goods_name'))
			$where['goods_name'] = array('like', "%$goods_name%");
		if($cat_id = I('get.cat_id'))
			$where['cat_id'] = array('eq', $cat_id);
		if($brand_id = I('get.brand_id'))
			$where['brand_id'] = array('eq', $brand_id);
		$shop_pricefrom = I('get.shop_pricefrom');
		$shop_priceto = I('get.shop_priceto');
		if($shop_pricefrom && $shop_priceto)
			$where['shop_price'] = array('between', array($shop_pricefrom, $shop_priceto));
		elseif($shop_pricefrom)
			$where['shop_price'] = array('egt', $shop_pricefrom);
		elseif($shop_priceto)
			$where['shop_price'] = array('elt', $shop_priceto);
		$is_hot = I('get.is_hot');
		if($is_hot != '' && $is_hot != '-1')
			$where['is_hot'] = array('eq', $is_hot);
		$is_new = I('get.is_new');
		if($is_new != '' && $is_new != '-1')
			$where['is_new'] = array('eq', $is_new);
		$is_best = I('get.is_best');
		if($is_best != '' && $is_best != '-1')
			$where['is_best'] = array('eq', $is_best);
		$is_on_sale = I('get.is_on_sale');
		if($is_on_sale != '' && $is_on_sale != '-1')
			$where['is_on_sale'] = array('eq', $is_on_sale);
		if($type_id = I('get.type_id'))
			$where['type_id'] = array('eq', $type_id);
		$addtimefrom = I('get.addtimefrom');
		$endtimefrom = I('get.endtimefrom');
		if($addtimefrom && $endtimefrom)
			$where['addtime'] = array('between', array(strtotime("$addtimefrom 00:00:00"), strtotime("$endtimefrom 23:59:59")));
		elseif($addtimefrom)
			$where['addtime'] = array('egt', strtotime("$addtimefrom 00:00:00"));
		elseif($endtimefrom)
			$where['addtime'] = array('elt', strtotime("$endtimefrom 23:59:59"));
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
		//获取当前时间存放到数据库中;
		$data['addtime']=time();
		if(isset($_FILES['logo']) && $_FILES['logo']['error'] == 0)
		{
			$ret = uploadOne('logo', 'Admin', array(
				array(350, 350, 2),
			));
			if($ret['ok'] == 1)
			{
				$data['logo'] = $ret['images'][0];
				$data['sm_logo'] = $ret['images'][1];
			}
			else 
			{
				$this->error = $ret['error'];
				return FALSE;
			}
		}
	}
	// 商品基本信息插入到数据库中之后
	protected function _after_insert($data, $option)
	{
		/**************** 处理商品的扩展分类 ********************/
		$eci = I('post.ext_cat_id');
		if($eci)
		{
			$gcModel = M('GoodsCat');
			foreach ($eci as $v)
			{
				// 如果分类为空就跳过处理下一个
				if(empty($v))
					continue;
				$gcModel->add(array(
					'goods_id' => $data['id'],
					'cat_id' => $v,
				));
			}
		}
		/************* 处理会员价格 ************************/
		$mp = I('post.mp');
		if($mp)
		{
			$mpModel = M('MemberPrice');
			foreach ($mp as $k => $v)
			{
				if(empty($v))
					continue ;
				$mpModel->add(array(
					'goods_id' => $data['id'],
					'level_id' => $k,
					'price' => $v,
				));
			}
		}
		/******************** 处理商品属性的数据 *********************/
		$ga = I('post.ga');
		$ap = I('post.attr_price');
		if($ga)
		{
			$gaModel = M('GoodsAttr');
			foreach ($ga as $k => $v)
			{
				foreach ($v as $k1 => $v1)
				{
					if(empty($v1))
						continue ;
					$gaModel->add(array(
						'goods_id' => $data['id'],
						'attr_id' => $k,
						'attr_value' => $v1,
						'attr_price' => $ap[$k][$k1],
					));
				}
			}
		}
		/************************* 处理商品图片的代码 ***********************/
		// 判断有没有图片
		if(hasImage('pics'))
		{
			$gpModel = M('GoodsPics');
			// 批量上传之后的图片数组，改造成每个图片一个一维数组的形式
			$pics = array();
			foreach ($_FILES['pics']['name'] as $k => $v)
			{
				if($_FILES['pics']['size'][$k] == 0)
					continue ;
				$pics[] = array(
					'name' => $v,
					'type' => $_FILES['pics']['type'][$k],
					'tmp_name' => $_FILES['pics']['tmp_name'][$k],
					'error' => $_FILES['pics']['error'][$k],
					'size' => $_FILES['pics']['size'][$k],
				);
			}
			// 在后面调用uploadOne方法时会使用$_FILES数组上传图片，所以我们要把我们处理好的数组赎给$_FILES这样上传时使用的就是我们处理好的数组
			$_FILES = $pics;
			// 循环每张图片一个一个的上传
			foreach ($pics as $k => $v)
			{
				$ret = uploadOne($k, 'Goods', array(
					array(150, 150)
				));
				if($ret['ok'] == 1)
				{
					$gpModel->add(array(
						'goods_id' => $data['id'],
						'pic' => $ret['images'][0],     // 原图存到pic字段
						'sm_pic' => $ret['images'][1],  // 第一个缩略图存到sm_pic字段中
					));
				}
			}
		}
	}
	protected function _before_update(&$data, $option)
	{
		// 如果没有勾选促销价格就手动设置为更新成0
		if(!isset($_POST['is_promote']))
			$data['is_promote'] = 0;
		if(isset($_FILES['logo']) && $_FILES['logo']['error'] == 0)
		{
			$ret = uploadOne('logo', 'Admin', array(
				array(350, 350, 2),
			));
			if($ret['ok'] == 1)
			{
				$data['logo'] = $ret['images'][0];
				$data['sm_logo'] = $ret['images'][1];
			}
			else 
			{
				$this->error = $ret['error'];
				return FALSE;
			}
			deleteImage(array(
				I('post.old_logo'),
				I('post.old_sm_logo'),
	
			));
		}
	}
	// 删除前
	protected function _before_delete($option)
	{
		if(is_array($option['where']['id']))
		{
			$this->error = '不支持批量删除';
			return FALSE;
		}
		$images = $this->field('logo,sm_logo')->find($option['where']['id']);
		deleteImage($images);
	}
	/************************************ 其他方法 ********************************************/
}