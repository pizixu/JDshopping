<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>商品列表</title>
<meta name="robots" content="noindex, nofollow">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="/shopping2test/Public/Admin/Styles/general.css" rel="stylesheet" type="text/css" />
<link href="/shopping2test/Public/Admin/Styles/main.css" rel="stylesheet" type="text/css" />
<link href="/shopping2test/Public/datepicker/jquery-ui-1.9.2.custom.min.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" language="javascript" src="/shopping2test/Public/datepicker/jquery-1.7.2.min.js"></script>
<script type="text/javascript" charset="utf-8" src="/shopping2test/Public/datepicker/jquery-ui-1.9.2.custom.min.js"></script>
<script type="text/javascript" charset="utf-8" src="/shopping2test/Public/datepicker/datepicker_zh-cn.js"></script>
<script type="text/javascript" charset="utf-8" src="/shopping2test/Public/ueditor/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="/shopping2test/Public/ueditor/ueditor.all.min.js"> </script>
<script type="text/javascript" charset="utf-8" src="/shopping2test/Public/ueditor/lang/zh-cn/zh-cn.js"></script>

</head>
<body>
<h1>
    <span class="action-span"><a href="<?php echo $page_btn_link;?>"><?php echo $page_btn_name;?></a></span>
    <span class="action-span1"><a href="/shopping2test/index.php/Admin/Index/index">管理中心</a>||</span>
    <span id="search_id" class="action-span1"><?php echo $page_title;?></span>
    <div style="clear:both"></div>
</h1>
	<!-- 页面中的内容 -->
   
<!-- 列表 -->
<p>
按商品类型显示:<select onchange="location.href='__Action__/type_id/'+this.value;">
<option value="">选择类型</option>
<?php foreach($typeData as $k=>$v): if ($v['id']==$typeId) $select='selected="selected"'; else $select=''; ?>
	<option <?php echo ($select); ?> value="<?php echo ($v["id"]); ?>"><?php echo ($v["type_name"]); ?></option>
<?php endforeach; ?>
</select>
</p>
<div class="list-div" id="listDiv">
	<table cellpadding="3" cellspacing="1">
    	<tr>
            <th >属性名称</th>
            <th >属性的类型0：唯一 1：可选</th>
            <th >属性的可选值</th>
            <th >所在的类型的id</th>
			<th width="60">操作</th>
        </tr>
		<?php foreach ($data as $k => $v): ?>            
			<tr class="tron">
				<td><?php echo $v['attr_name']; ?></td>
				<td><?php echo $v['attr_type']; ?></td>
				<td><?php echo $v['attr_option_values']; ?></td>
				<td><?php echo $v['type_id']; ?></td>
		        <td align="center">
		        	<a href="<?php echo U('edit?id='.$v['id'].'&p='.I('get.p').'&type_id='.$typeId); ?>" title="编辑">编辑</a> |
	                <a href="<?php echo U('delete?id='.$v['id'].'&p='.I('get.p').'&type_id='.$typeId); ?>" onclick="return confirm('确定要删除吗？');" title="移除">移除</a> 
		        </td>
	        </tr>
        <?php endforeach; ?> 
		<?php if(preg_match('/\d/', $page)): ?>  
        <tr><td align="right" nowrap="true" colspan="99" height="30"><?php echo $page; ?></td></tr> 
        <?php endif; ?> 
	</table>
</div>
<script>
</script>
<div id="footer">shopping2</div>
</body>
</html>

<script type="text/javascript" charset="utf-8" src="/shopping2test/Public/Admin/Js/tron.js"></script>