<?php
/*
@@acc_title="配货管理 lock"
*/
$CenterOrderModel = Core::ImportModel( 'CenterOrder' );


/*
if ( $_GET['excel'] )
{
	$offset = 0;
	$onePage = 0;
}
list( $page, $offset, $onePage ) = Common::PageArg( 20 );
*/
include( Core::BLock( 'order.list' ) );

$list = $CenterOrderModel->GetList( array(
	'purchase_check' => 1,
	'service_check' => 1,
	'id' => $_GET['id'],
	'target_id' => $_GET['target_id'],
	'lock_status' => $_GET['lock_status'],
	'delivery_status' => $_GET['delivery_status'],
), $offset, $onePage );

$orderDeliveryTypeList = Core::GetConfig( 'order_delivery_type' );
$orderDeliveryStatusList = Core::GetConfig( 'order_delivery_status' );
$orderLockStatusList = Core::GetConfig( 'order_lock_status' );

$tpl['lock_status_list'] = $orderLockStatusList;
$tpl['delivery_status_list'] = $orderDeliveryStatusList;
$tpl['delivery_type_list'] = $orderDeliveryTypeList;


foreach ( $list as $key => $val )
{
	$list[$key]['add_time'] = DateFormat( $val['add_time'] );

	$list[$key]['delivery_type_name'] = $orderDeliveryTypeList[$val['delivery_type']];
	$list[$key]['delivery_status_name'] = $orderDeliveryStatusList[$val['delivery_status']];
	$list[$key]['lock_status_name'] = $orderLockStatusList[$val['lock_status']];

	if ( $_GET['excel'] )
	{
		$list[$key]['delivery_type_name'] = strip_tags( $orderDeliveryTypeList[$val['delivery_type']] );
		$list[$key]['delivery_status_name'] = strip_tags( $orderDeliveryStatusList[$val['delivery_status']] );
		$list[$key]['lock_status_name'] = strip_tags( $orderLockStatusList[$val['lock_status']] );
	}

	$list[$key]['add_time'] = DateFormat( $val['add_time'] );
	$list[$key]['order_time'] = DateFormat( $val['order_time'] );
}

if ( $_GET['excel'] )
{
	$header = array(
		'订单号' => 'id',
		'外部订单号' => 'target_id',
		'渠道' => 'channel_name',
		'下单时间' => 'order_time',
		'总数' => 'total_quantity',
		'总品种数' => 'total_breed',
		'总金额' => 'total_money',
		'出库状态' => 'delivery_status_name',
		'出库类型' => 'delivery_type_name',
		'配货状态' => 'lock_status_name',
		'客户名称' => 'order_customer_name',
		'收货人' => 'order_shipping_name',
		'收货地址' => 'order_shipping_address',
		'收货邮编' => 'order_shipping_zip',
		'电话1' => 'order_shipping_phone',
		'电话2' => 'order_shipping_mobile',
		'备注' => 'order_comment',
	);


	header("Pragma: public");
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Content-Type:application/force-download");
	header("Content-Type:application/vnd.ms-execl");
	header("Content-Type:application/octet-stream");
	header("Content-Type:application/download");
	header("Content-Disposition:attachment;filename=\"" . DateFormat(time(), 'Y-m-d_H-i-s') . ".xls\"");
	header("Content-Transfer-Encoding:binary");
	echo ExcelXml( $header, $list );
	exit;
}


$tpl['list'] = $list;
$tpl['page'] = $page;
$tpl['total'] = $total;
$tpl['page_num'] = ceil( $total / $onePage );
$tpl['page_bar'] = Common::PageBar( $total, $onePage, $page );

Common::PageOut( 'order/lock/list.html', $tpl );

?>