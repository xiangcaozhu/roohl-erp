<?php

/******** Order Config ********/
define( 'ORDER_GLOBAL_STATUS_DEFAULT', 1 );


define( 'ORDER_STATUS_NORMAL', 1 );
define( 'ORDER_STATUS_CANCELLED', 2 );
define( 'ORDER_STATUS_PROCESSING', 3 );
define( 'ORDER_STATUS_DONE', 4 );
$__Config['order_status'][ORDER_STATUS_NORMAL] = array( 'name' => '<font color="blue">正常</font>' );
$__Config['order_status'][ORDER_STATUS_CANCELLED] = array( 'name' => '<font color="red">已取消</font>' );
$__Config['order_status'][ORDER_STATUS_PROCESSING] = array( 'name' => '已处理' );
$__Config['order_status'][ORDER_STATUS_DONE] = array( 'name' => '已完成' );


define( 'PAY_STATUS_NORMAL', 1 );
define( 'PAY_STATUS_PAID', 37 );
define( 'PAY_STATUS_BACK', 2 );
$__Config['order_pay_status'][PAY_STATUS_NORMAL] = array( 'name' => '未付款' );
$__Config['order_pay_status'][PAY_STATUS_PAID] = array( 'name' => '已付款' );
$__Config['order_pay_status'][PAY_STATUS_BACK] = array( 'name' => '已退款' );


define( 'PAY_CHECK_STATUS_NORMAL', 1 );
define( 'PAY_CHECK_STATUS_CHECKED', 2 );
define( 'PAY_CHECK_STATUS_REVIEW', 3 );
$__Config['order_pay_check_status'][PAY_CHECK_STATUS_NORMAL] = array( 'name' => '未确认到账' );
$__Config['order_pay_check_status'][PAY_CHECK_STATUS_CHECKED] = array( 'name' => '已确认到账' );
$__Config['order_pay_check_status'][PAY_CHECK_STATUS_REVIEW] = array( 'name' => '到账异常' );


define( 'SHIP_STATUS_NORMAL', 1 );
define( 'SHIP_STATUS_PACK', 2 );
define( 'SHIP_STATUS_SHIPPED', 3 );
$__Config['order_ship_status'][SHIP_STATUS_NORMAL] = array( 'name' => '未发货' );
$__Config['order_ship_status'][SHIP_STATUS_PACK] = array( 'name' => '已打包' );
$__Config['order_ship_status'][SHIP_STATUS_SHIPPED] = array( 'name' => '已发货' );

$__Config['order_pay_type'][1] = array( 'name' => '先款后货' );
$__Config['order_pay_type'][2] = array( 'name' => '货到付款' );

$__Config['order_ship_type'][1] = array( 'name' => '快递' );
$__Config['order_ship_type'][2] = array( 'name' => 'EMS' );
//$__Config['order_ship_type'][3] = array( 'name' => '普通邮递' );


$__Config['order_type'][0] = '客户订单';
$__Config['order_type'][1] = '电话订单';

$__Config['order_global_status'][1] = array( 'id' => 1, 'name' => '等待处理' );
$__Config['order_global_status'][2] = array( 'id' => 2, 'name' => '已经付款' );
$__Config['order_global_status'][3] = array( 'id' => 3, 'name' => '确认到账' );
$__Config['order_global_status'][4] = array( 'id' => 4, 'name' => '付款异常' );
$__Config['order_global_status'][5] = array( 'id' => 5, 'name' => '准备发货' );
$__Config['order_global_status'][6] = array( 'id' => 6, 'name' => '正在打包' );
$__Config['order_global_status'][7] = array( 'id' => 7, 'name' => '已经发货' );
$__Config['order_global_status'][8] = array( 'id' => 8, 'name' => '订单完成' );
$__Config['order_global_status'][9] = array( 'id' => 9, 'name' => '已经退款' );
$__Config['order_global_status'][10] = array( 'id' => 10, 'name' => '已经取消' );


$__Config['order_ship_insurance_price'] = 1.99;

$__Config['ship_type'] = 'china';

?>