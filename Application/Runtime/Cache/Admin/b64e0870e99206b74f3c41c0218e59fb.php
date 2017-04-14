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
   
<div class="main-div">
    <form name="main_form" method="POST" action="/shopping2test/index.php/Admin/Admin/edit/id/12/p/1.html" enctype="multipart/form-data">
     <input type="hidden" name="id" value="<?php echo $data['id']; ?>" />
        <table cellspacing="1" cellpadding="3" width="100%">
            <tr>
                <td class="label">所在角色：</td>
                <td>
                  <?php foreach ($roleData as $k=>$v): if(strpos(','.$rid.',',','.$v['id'].',') !==FALSE) $check='checked="checked"'; else $check=''; ?>
                    <input <?php echo ($check); ?>  type="checkbox" name="role_id[]" value="<?php echo ($v["id"]); ?>" /> <?php echo ($v["role_name"]); ?>
                <?php endforeach; ?>
                </td>
            </tr>
            <tr>
                <td class="label">账号：</td>
                <td>
                    <input  type="text" name="username" value="<?php echo ($data["username"]); ?>" />
                </td>
            </tr>
            <tr>
                <td class="label">密码：</td>
                <td>
                    <input type="password" size="25" name="password" />
                </td>
            </tr>
            <tr>
                <td class="label">密码确认：</td>
                <td>
                    <input type="password" size="25" name="cpassword" />
                </td>
            </tr>
             <!--  超级管理员不显示是否启用;  -->             
             <?php if($data['id']>1): ?>
            <tr>
                <td class="label">是否启用</td>
                <td>
                    <input type="radio" name="is_use" value="1" checked="checked" />启用 
                    <input type="radio" name="is_use" value="0"  />禁用 
                </td>
            </tr>
            <?php endif; ?>
            <tr>
                <td colspan="99" align="center">
                    <input type="submit" class="button" value=" 确定 " />
                    <input type="reset" class="button" value=" 重置 " />
                </td>
            </tr>
        </table>
    </form>
</div>
<script>
</script>
<div id="footer">shopping2</div>
</body>
</html>

<script type="text/javascript" charset="utf-8" src="/shopping2test/Public/Admin/Js/tron.js"></script>