<?php
/*
@@acc_free
@@acc_title="订单出库 orderout"
*/
$CenterOrderExtra = Core::ImportExtra( 'CenterOrder' );

$CenterOrderModel = Core::ImportModel( 'CenterOrder' );
$CenterWarehouseLockModel = Core::ImportModel( 'CenterWarehouseLock' );

$CenterChannelModel = Core::ImportModel( 'CenterChannel' );
$channelList = $CenterChannelModel->GetList();

include( Core::Block( 'warehouse' ) );

$deliveryTypeList = Core::GetConfig( 'order_delivery_type' );

$list = $CenterOrderModel->GetList( array(
	'warehouse_id' => $warehouseId,
	'lock_status' => 2,
	'delivery_type' => 1,
	'print_status' => 1,
	'wait_delivery' => 1,
	'purchase_check' => 1,
	'service_check' => 1,
) );
$total = $CenterOrderModel->GetTotal( array(
	'warehouse_id' => $warehouseId,
	'lock_status' => 2,
	'delivery_type' => 1,
	'print_status' => 1,
	'wait_delivery' => 1,
	'purchase_check' => 1,
	'service_check' => 1,
) );

foreach ( $list as $key => $val )
{
	$list[$key]['add_time'] = DateFormat( $val['add_time'] );
	$list[$key]['delivery_type_name'] = $deliveryTypeList[$val['delivery_type']];

	$productList = $CenterOrderModel->GetProductList( $val['id'] );
	$list[$key]['list'] = $CenterOrderExtra->ExplainProduct( $productList );
	$list[$key]['channel_name'] = $channelList[$val['channel_id']]['name'];
}

$tpl['list'] = $list;
$tpl['total'] = $total;

Common::PageOut( 'delivery/order.html', $tpl );

?>