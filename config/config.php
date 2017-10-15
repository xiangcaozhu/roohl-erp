<?php

include( 'db.config.php' );

/******** 配置文件路径 ********/
$__Config['config_path'] = ROOT_PATH . 'config/';
$__Config['core_config_path'] = CORE_CONFIG_PATH;

/******** 核心配置 ********/
$__Config['core_path'] = CORE_PATH;
$__Config['core_lib_path'] = CORE_PATH . 'Lib/';
$__Config['core_class_path'] = CORE_PATH . 'Class/';
$__Config['core_function_path'] = CORE_PATH . 'Function/';
$__Config['core_component_path'] = CORE_PATH . 'Component/';
$__Config['core_model_path'] = CORE_PATH . 'Model/';
$__Config['core_dom_path'] = CORE_PATH . 'Dom/';
$__Config['core_extra_path'] = CORE_PATH . 'Extra/';

/******** APP配置 ********/
$__Config['app_path'] = ROOT_PATH . 'app/';
$__Config['app_block_path'] = ROOT_PATH . 'app/block/';
$__Config['app_module_path'] = ROOT_PATH . 'app/module/';
$__Config['app_default_module'] = 'frame';

/******** Cache ********/
$__Config['cache_path'] = '../cache/';

/******** Template ********/
$__Config['template_path'] = ROOT_PATH . 'template/';
$__Config['template_cache_path'] = ROOT_PATH . 'cache/template/';


/******** 产品列表图片相关配置 ********/
$__Config['product_picture_path'] = ROOT_PATH . 'resource/product_picture/';
$__Config['product_picture_url'] = ROOT_URL . 'resource/product_picture/';
$__Config['product_picture_tmp_path'] = ROOT_PATH . 'tmp/picture/';

$__Config['product_picture_size']['list'] = array( 'width' => 90, 'height' => 90 );
$__Config['product_picture_size']['grid'] = array( 'width' => 164, 'height' => 164 );
$__Config['product_picture_size']['source'] = array( 'width' => 0, 'height' => 0 );

/******** 品牌图片相关配置 ********/
$__Config['brand_picture_path'] = ROOT_PATH . 'resource/brand_picture/';
$__Config['brand_picture_url'] = ROOT_URL . 'resource/brand_picture/';
$__Config['brand_picture_width'] = 100;

/******** Attribute Image ********/
$__Config['attribute_image_tmp_path'] = ROOT_PATH . 'tmp/attribute_image/';
$__Config['attribute_image_tmp_url'] = ROOT_PATH . 'tmp/attribute_image/';
$__Config['attribute_image_width_1'] = 32;
$__Config['attribute_image_width_2'] = 300;
$__Config['attribute_image_path'] = SITE_PATH . 'resource/attribute_image/';
$__Config['attribute_image_url'] = SITE_URL . 'resource/attribute_image/';

/******** Upload ********/
$__Config['file_upload_tmp_path'] = ROOT_PATH . 'tmp/upload/';


/******** Order Config ********/
include( 'order.config.php' );


/******** Mail ********/
include( 'mail.config.php' );



$__Config['purchase_type'] = array(
	1 => '<font color="FF00CC">常规采购</font>',
	2 => '<font color="FF9933">按需采购</font>',
);

$__Config['purchase_payment_type'] = array(
	1 => '先货后款',
	2 => '先款后货',
);

$__Config['purchase_pay_status'] = array(
	0 => '<font color="red">未付款</font>',
	1 => '<font color="green">已付款</font>',
);

$__Config['purchase_product_type'] = array(
	1 => '3C',
	2 => '非3C',
);

$__Config['purchase_status'] = array(
	1 => '新建',
	2 => '审核中',
	3 => '执行',
	4 => '取消',
	5 => '完成',
);

$__Config['purchase_receive_status'] = array(
	1 => '<font color="red">尚未收货</font>',
	2 => '<font color="green">部分收货</font>',
	3 => '<font color="blue">全部收货</font>',
);
$__Config['purchase_receive_status_a'] = array(
	1 => '<font color="red">尚未发货</font>',
	2 => '<font color="green">部分发货</font>',
	3 => '<font color="blue">全部发货</font>',
);

$__Config['into_status'] = array(
	1 => '<font color="red">尚未入库</font>',
	2 => '<font color="green">部分入库</font>',
	3 => '<font color="blue">全部入库</font>',
);

$__Config['receive_type'] = array(
	1 => '采购收货',
	2 => '其他收货',
);

$__Config['store_type'] = array(
	1 => '收货入库',
	2 => '其他入库',
	3 => '盘盈入库',
	4 => '退货入库',
	5 => '调拨入库',
);

$__Config['delivery_type'] = array(
	1 => '订单出库',
	2 => '其他出库',
	3 => '盘亏出库',
);

$__Config['warehouse_lock_type'] = array(
	1 => '订单配货',
	2 => '其他配货',
);

$__Config['order_lock_status'] = array(
	0 => '<font color="red">尚未配货</font>',
	1 => '<font color="green">部分配货</font>',
	2 => '<font color="blue">全部配货</font>',
);

$__Config['order_delivery_type'] = array(
	1 => '<font color="blue">同库满足</font>',
	2 => '<font color="red">多库满足</font>',
);

$__Config['order_delivery_status'] = array(
	0 => '<font color="red">未发货</font>',
	1 => '<font color="green">部分发货</font>',
	2 => '<font color="blue">全部发货</font>',
);

$__Config['order_print_status'] = array(
	0 => '<font color="red">未打发货单</font>',
	1 => '<font color="green">已打发货单</font>',
);

$__Config['order_delivery_status'] = array(
	0 => '<font color="red">未出库</font>',
	1 => '<font color="green">部分出库</font>',
	2 => '<font color="blue">全部出库</font>',
);

$__Config['order_purchase_status'] = array(
	0 => '<font color="red">未采购</font>',
	1 => '<font color="green">部分采购</font>',
	2 => '<font color="blue">全部采购</font>',
);

$__Config['order_import_type'] = array(
	1 => '<font color="blue">程序导入</font>',
	2 => '<font color="green">手工添加</font>',
);


$__Config['warehouse_log_type'] = array(
	1 => '入库',
	2 => '出库',
);

$__Config['order_payment_type'] = array(
	0 => '未知',
	1 => '货到付款',
	2 => '先款后货',
);

// 商务确认
$__Config['order_purchase_check'] = array(
	0 => '<font color="red">未操作</font>',
	1 => '<font color="#339900">已确认</font>',
	2 => '<font color="red">已取消</font>',
);

// 客服确认
$__Config['order_service_check'] = array(
	0 => '<font color="red">未操作</font>',
	1 => '<font color="#339900">已确认</font>',
	2 => '<font color="red">已取消</font>',
);


// 财务确认
$__Config['finance_recieve'] = array(
	0 => '<font color="red">未到款</font>',
	1 => '<font color="blue">已到款</font>',
	2 => '<font color="red">已退款</font>',
);

// 签收确认
$__Config['order_sign_status'] = array(
	0 => '<font color="red">未签收</font>',
	1 => '<font color="blue">已签收</font>',
);

//订单状态
$__Config['order_status'] = array(
	1 => '<font color="red">正常</font>',
	2 => '<font color="blue">退货中</font>',
	3 => '<font color="blue">退货完毕</font>',
);

//发货方式
$__Config['order_delivery_type'] = array(
	5 => '<font color="#CC0099">★代发货</font>',
	6 => '<font color="#FF6600">库房发货</font>',
);



// 订单审核价格额度
$__Config['purchase_money'] = array(
	0 => '10000000',
	1 => '10000000',
);

// 公司名称
$__Config['company_name'] = '中奥通宇';
//date_default_timezone_set("PRC");

// 物流公司
$__Config['logistics_list'] = array(
	0 => '采购代发货',
	1 => '韵达快递',
	2 => '顺丰快递',
	3 => '汇通快递',
	4 => '中通快递',
	5 => 'EMS',
);

// 客服确认发票内容
$__Config['order_invoice_type'] = array(
	0 => '为选择',
	1 => '办公用品',
	2 => '礼品',
	3 => '产品名称',
);


// 客服确认发票内容
$__Config['order_invoice'] = array(
	0 => '不需要票据',
	1 => '发票',
	2 => '收据',
);

// 客服确认发票内容
$__Config['order_invoice_status'] = array(
	0 => '未开',
	1 => '已开',
);











// 广发费率
$__Config['payout_rate_gf'] = array(
	1 => 0.08,
	3 => 0.08,
	6 => 0.08,
	12 => 0.08,
	15 => 0,
	18 => 0.09,
	24 => 0.10,
);
// 建行费率-3C
$__Config['payout_rate_jh'] = array(
	1 => 0.005,
	3 => 0.03,
	6 => 0.04,
	12 => 0.05,
	15 => 0,
	18 => 0,
	24 => 0.11,
);
// 建行费率-非3C
$__Config['payout_rate_jh1'] = array(
	1 => 0.005,
	3 => 0.04,
	6 => 0.05,
	12 => 0.07,
	15 => 0,
	18 => 0,
	24 => 0.12,
);


// 交行费率-家居百货
$__Config['payout_rate_jt'] = array(
	1 => 0.20,
	3 => 0.00,
	6 => 0.23,
	12 => 0.245,
	15 => 0.00,
	18 => 0.00,
	24 => 0.00,
);
// 交行费率-电脑手机数码
$__Config['payout_rate_jt1'] = array(
	1 => 0.05,
	3 => 0.00,
	6 => 0.08,
	12 => 0.095,
	15 => 0.00,
	18 => 0.00,
	24 => 0.00,
);
// 交行费率-家电美容
$__Config['payout_rate_jt2'] = array(
	1 => 0.08,
	3 => 0.00,
	6 => 0.11,
	12 => 0.125,
	15 => 0.00,
	18 => 0.00,
	24 => 0.00,
);
// 交行费率-配饰奢侈品
$__Config['payout_rate_jt3'] = array(
	1 => 0.10,
	3 => 0.00,
	6 => 0.13,
	12 => 0.145,
	15 => 0.00,
	18 => 0.00,
	24 => 0.00,
);



?>