USE shopping2;
SET NAMES utf8;

# tinyint : 0~255
# smallint : 0~ 65535
# mediumint : 0~1千6百多万
# int : 0~40多亿
# char 、varchar 、 text容量？
# char    :0~255个字符
# varchar : 0~65535 字节 看表编码，如果是utf8存2万多汉字 gbk存3万多汉字
# text    : 0~65535 字符
/*CREATE TABLE IF NOT EXISTS  sp_goods
(
	id mediumint unsigned not null auto_increment,
	goods_name varchar(45) not null comment '商品名称',
	logo varchar(150) not null default '' comment '商品logo',
	sm_logo varchar(150) not null default '' comment '商品缩略图logo',
	price decimal(10,2) not null default '0.00' comment '商品价格',
	goods_desc longtext comment '商品描述',
	is_on_sale tinyint unsigned not null default '1' comment '是否上架：1：上架，0：下架',
	is_delete tinyint unsigned not null default '0' comment '是否已经删除，1：已经删除 0：未删除',
	addtime int unsigned not null comment '添加时间',
	primary key (id),
	key price(price),
	key is_on_sale(is_on_sale),
	key is_delete(is_delete),
	key addtime(addtime)
)engine=MyISAM default charset=utf8;*/
DROP TABLE IF EXISTS sp_goods;
CREATE TABLE sp_goods
(
	id mediumint unsigned not null auto_increment,
	goods_name varchar(45) not null comment '商品名称',
	cat_id smallint unsigned not null comment '主分类的id',
	brand_id smallint unsigned not null comment '品牌的id',
	market_price decimal(10,2) not null default '0.00' comment '市场价',
	shop_price decimal(10,2) not null default '0.00' comment '本店价',
	jifen int unsigned not null comment '赠送积分',
	jyz int unsigned not null comment '赠送经验值',
	jifen_price int unsigned not null comment '如果要用积分兑换，需要的积分数',
	is_promote tinyint unsigned not null default '0' comment '是否促销',
	promote_price decimal(10,2) not null default '0.00' comment '促销价',
	promote_start_time int unsigned not null default '0' comment '促销开始时间',
	promote_end_time int unsigned not null default '0' comment '促销结束时间',
	logo varchar(150) not null default '' comment 'logo原图',
	sm_logo varchar(150) not null default '' comment 'logo缩略图',
	is_hot tinyint unsigned not null default '0' comment '是否热卖',
	is_new tinyint unsigned not null default '0' comment '是否新品',
	is_best tinyint unsigned not null default '0' comment '是否精品',
	is_on_sale tinyint unsigned not null default '1' comment '是否上架：1：上架，0：下架',
	seo_keyword varchar(150) not null default '' comment 'seo优化[搜索引擎【百度、谷歌等】优化]_关键字',
	seo_description varchar(150) not null default '' comment 'seo优化[搜索引擎【百度、谷歌等】优化]_描述',
	type_id mediumint unsigned not null default '0' comment '商品类型id',
	sort_num tinyint unsigned not null default '100' comment '排序数字',
	is_delete tinyint unsigned not null default '0' comment '是否放到回收站：1：是，0：否',
	addtime int unsigned not null comment '添加时间',
	goods_desc longtext comment '商品描述',
	primary key (id),
	key shop_price(shop_price),
	key cat_id(cat_id),
	key brand_id(brand_id),
	key is_on_sale(is_on_sale),
	key is_hot(is_hot),
	key is_new(is_new),
	key is_best(is_best),
	key is_delete(is_delete),
	key sort_num(sort_num),
	key promote_start_time(promote_start_time),
	key promote_end_time(promote_end_time),
	key addtime(addtime)
)engine=MyISAM default charset=utf8;
#说明：当要使用LIKE 查询并以%开头时，不能使用普通索引，只以使用全文索引，如果使用了全文索引：
#SELECT * FROM shopping2_goods WHERE MATCH goods_name AGAINST 'xxxx';
# 但MYSQL自带的全文索引不支持中文，所以不能使用MYSQL自带的全文索引功能，所以如果要优化只能使用第三方的全文索引## 引擎，如：sphinx,lucence等。


DROP TABLE IF EXISTS sp_youhui_price;
CREATE TABLE sp_youhui_price
(
	goods_id mediumint unsigned not null comment '商品id',
	youhui_num int unsigned not null comment '数量',
	youhui_price decimal(10,2) not null comment '优惠价格',
	key goods_id(goods_id)
)engine=MyISAM default charset=utf8 comment '商品的优惠价格';

DROP TABLE IF EXISTS sp_goods_cat;
CREATE TABLE sp_goods_cat
(
	goods_id mediumint unsigned not null comment '商品id',
	cat_id smallint unsigned not null comment '分类id',
	key goods_id(goods_id),
	key cat_id(cat_id)
)engine=MyISAM default charset=utf8 comment '商品扩展分类表';

DROP TABLE IF EXISTS sp_brand;
CREATE TABLE sp_brand
(
	id smallint unsigned not null auto_increment,
	brand_name varchar(45) not null comment '品牌名称',
	site_url varchar(150) not null comment '品牌网站地址',
	logo varchar(150) not null default '' comment '品牌logo',
	primary key (id)
)engine=MyISAM default charset=utf8 comment '品牌表';

DROP TABLE IF EXISTS sp_category;
CREATE TABLE sp_category
(
	id smallint unsigned not null auto_increment,
	cat_name varchar(30) not null comment '分类名称',
	parent_id smallint unsigned not null default '0' comment '上级分类的ID，0：代表顶级',
	primary key (id)
)engine=MyISAM default charset=utf8 comment '商品分类表';

########################## RBAC ################################
DROP TABLE IF EXISTS sp_privilege;
CREATE TABLE sp_privilege
(
	id smallint unsigned not null auto_increment,
	pri_name varchar(30) not null comment '权限名称',
	module_name varchar(10) not null comment '模块名称',
	controller_name varchar(10) not null comment '控制器名称',
	action_name varchar(20) not null comment '方法名称',
	parent_id smallint unsigned not null default '0' comment '上级权限的ID，0：代表顶级权限',
	primary key (id)
)engine=MyISAM default charset=utf8 comment '权限表';

DROP TABLE IF EXISTS sp_role_privilege;
CREATE TABLE sp_role_privilege
(
	pri_id smallint unsigned not null comment '权限的ID',
	role_id smallint unsigned not null comment '角色的id',
	key pri_id(pri_id),
	key role_id(role_id)
)engine=MyISAM default charset=utf8 comment '角色权限表';

DROP TABLE IF EXISTS sp_role;
CREATE TABLE sp_role
(
	id smallint unsigned not null auto_increment,
	role_name varchar(30) not null comment '角色名称',
	primary key (id)
)engine=MyISAM default charset=utf8 comment '角色表';

DROP TABLE IF EXISTS sp_admin_role;
CREATE TABLE sp_admin_role
(
	admin_id tinyint unsigned not null comment '管理员的id',
	role_id smallint unsigned not null comment '角色的id',
	key admin_id(admin_id),
	key role_id(role_id)
)engine=MyISAM default charset=utf8 comment '管理员角色表';

DROP TABLE IF EXISTS sp_admin;
CREATE TABLE sp_admin
(
	id tinyint unsigned not null auto_increment,
	username varchar(30) not null comment '账号',
	password char(32) not null comment '密码',
	is_use tinyint unsigned not null default '1' comment '是否启用 1：启用0：禁用',
	primary key (id)
)engine=MyISAM default charset=utf8 comment '管理员';
INSERT INTO sp_admin VALUES(1,'root','',1);



# 角色表 role
#id    role_name
#-------------
# 1        a
# 2        b

# 权限表 privilege
#id    pri_name
#-------------
# 1        a
# 2        b
# 3        c

# a角色拥有bc两个权限
#sp_role_privilege
#role_id   pri_id
#--------------------
#   1        2              -->  1这个角色拥有2这个权限
#   1        3              -->  1这个角色拥有3这个权限

# 有以上五张表之后写SQL取出管理员ID为3的管理员所拥有的所有的权限
# 流程：1. 先取出3这个管理员所在的角色ID 
# SELECT role_id FROM  sp_admin_role WHERE admin_id=3
# 2. 再取出这些角色所拥有的权限的ID 
# SELECT pri_id FROM sp_role_privilege WHERE role_id IN (1上面的结果)
# 3. 再根据权限ID取出这些权限的信息
# SELECT * FROM sp_privilege WHERE id IN(2的结果)
# 最终：
# SELECT * FROM sp_privilege WHERE id IN(
#	SELECT pri_id FROM sp_role_privilege WHERE role_id IN (
#		SELECT role_id FROM  sp_admin_role WHERE admin_id=3
#	)
# )
# 写法二、
# SELECT a.*
#   FROM sp_privilege a,sp_role_privilege b,sp_admin_role c
#    WHERE c.admin_id=3 AND b.pri_id=a.id AND b.role_id=c.role_id
# 写法三、
# SELECT b.*
#  FROM sp_role_privilege a
#   LEFT JOIN sp_privilege b ON a.pri_id=b.id
#   LEFT JOIN sp_admin_role c ON a.role_id=c.id
#    WHERE c.admin_id=3
#    
//类型表
DROP TABLE IF EXISTS sp_type;
CREATE TABLE sp_type
(
	id tinyint unsigned not null auto_increment,
	type_name varchar(30) not null comment '类型名称',
	primary key(id)
)engine=MyISAM default charset=utf8 comment '商品类型';

//属性表
DROP TABLE IF EXISTS sp_attribute;
CREATE TABLE sp_attribute
(
	id mediumint unsigned not null auto_increment,
	attr_name varchar(30) not null comment '属性名称',
	attr_type tinyint unsigned not null default '0' comment '属性的类型0：唯一 1：可选',
	attr_option_values varchar(150) not null default '' comment '属性的可选值，多个可选值用，隔开',
	type_id tinyint unsigned not null comment '所在的类型的id',
	primary key(id),
	key type_id(type_id)
)engine=MyISAM default charset=utf8 comment '属性';

//会员级别表
DROP TABLE IF EXISTS sp_member_level;
CREATE TABLE sp_member_level
(
	id mediumint unsigned not null auto_increment,
	level_name varchar(30) not null comment '级别名称',
	bottom_num int unsigned not null comment '积分下限',
	top_num int unsigned not null comment '积分上限',
	rate tinyint unsigned not null default '100' comment '折扣率,以百分比,如：9折=90',
	primary key(id)
)engine=MyISAM default charset=utf8 comment '会员级别';

//商品会员价格表(中间表)
DROP TABLE IF EXISTS sp_member_price;
CREATE TABLE sp_member_price
(
	goods_id mediumint unsigned not null comment '商品的id',
	level_id mediumint unsigned not null comment '级别id',
	price decimal(10,2) not null comment '这个级别的价格',
	key goods_id(goods_id),
	key level_id(level_id)
)engine=MyISAM default charset=utf8 comment '会员级别';

//商品图片表
DROP TABLE IF EXISTS sp_goods_pics;
CREATE TABLE sp_goods_pics
(
	id mediumint unsigned not null auto_increment,
	pic varchar(150) not null comment '图片',
	sm_pic varchar(150) not null comment '缩略图',
	goods_id mediumint unsigned not null comment '商品的id',
	primary key(id),
	key goods_id(goods_id)
)engine=MyISAM default charset=utf8 comment '商品图片';

//商品属性表(中间表)
DROP TABLE IF EXISTS sp_goods_attr;
CREATE TABLE sp_goods_attr
(
	id int unsigned not null auto_increment,
	goods_id mediumint unsigned not null comment '商品的id',
	attr_id mediumint unsigned not null comment '属性的id',
	attr_value varchar(150) not null default '' comment '属性的值',
	attr_price decimal(10,2) not null default '0.00' comment '属性的价格',
	primary key(id),
	key goods_id(goods_id),
	key attr_id(attr_id)
)engine=MyISAM default charset=utf8 comment '商品属性';

//库存表
DROP TABLE IF EXISTS sp_goods_number;
CREATE TABLE sp_goods_number
(
	goods_id mediumint unsigned not null comment '商品的id',
	goods_number int unsigned not null comment '库存量',
	goods_attr_id varchar(150) not null comment '商品属性ID列表-注释：这里的ID保存的是上面sp_goods_attr表中的ID，
	通过这个ID即可以知道值是什么也可以是知道属性是什么,如果有多个ID组合就用，号隔开保存一个字符串
	，并且存时要按ID的升序存,将来前台查询库存量时也要先把商品属性ID升序拼成字符串然后查询数据库',
	key goods_id(goods_id)
)engine=MyISAM default charset=utf8 comment '商品库存量';






