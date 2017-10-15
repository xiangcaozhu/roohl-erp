<?php
/*
@@acc_freet
*/
$CenterOrderExtra = Core::ImportExtra( 'CenterOrder' );

$CenterOrderModel = Core::ImportModel( 'CenterOrder' );
$CenterWarehouseLockModel = Core::ImportModel( 'CenterWarehouseLock' );
$CenterWarehousePlaceModel = Core::ImportModel( 'CenterWarehousePlace' );
$CenterChannelModel = Core::ImportModel( 'CenterChannel' );
$channelList = $CenterChannelModel->GetList();

include( Core::Block( 'warehouse' ) );

if ( !is_array( $_POST['order_id'] ) )
	Alert( '请选择至少一个订单' );


$list = array();

foreach ( $_POST['order_id'] as $orderId )
{
	$orderInfo = $CenterOrderModel->Get( $orderId );

	if ( !$orderInfo )
		Alert( '没有找到订单信息,订单号:' . $orderId );

	$orderInfo['channel_name'] = $channelList[$orderInfo['channel_id']]['name'];

	$productList = $CenterOrderModel->GetProductList( $orderId );

	if ( !$productList )
		Alert( '没有找到订单产品信息,订单号:' . $orderId );

	$productList = $CenterOrderExtra->ExplainProduct( $productList );

	$warehouseLockList = $CenterWarehouseLockModel->GetListByOrder( $orderId );

	if ( !$warehouseLockList )
		Alert( '没有找到配货信息,订单号:' . $orderId );

	$orderInfo['product_list'] = $productList;
	
	$list[] = $orderInfo;
}

$excelList = array();
foreach ( $list as $val )
{
	$tmp = $val;

	$t = array();
	$t2 = array();
	$t3 = array();

	if ( $val['product_list'] )
	{
		foreach ( $val['product_list'] as $inf )
		{
			$t[] = $inf['sku_info']['product']['name'];
			$t2[] = $inf['price'];
			$t3[] = $inf['comment'];
		}
	}

	$tmp['product_name'] = implode( "\r\n", $t );
	$tmp['product_price'] = implode( "\r\n", $t2 );
	$tmp['product_comment'] = implode( "\r\n", $t3 );

	$excelList[] = $tmp;
}

$header = array(
	'订单号' => 'id',
	'渠道' => 'channel_name',
	'全称' => 'product_name',
	'价格' => 'product_price',
	'备注' => 'product_comment',
	'地址' => 'order_shipping_address',
	'收货人固定电话' => 'order_shipping_phone',
	'收货人手机' => 'order_shipping_mobile',
	'收货人证件号码' => 'order_customer_card',
	'收货人' => 'order_shipping_name',
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
echo ExcelXml( $header, $excelList );
exit();

?>