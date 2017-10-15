<?php
/*
@@acc_title="整理出库订单 pack"
*/
$CenterOrderExtra = Core::ImportExtra( 'CenterOrder' );

$CenterOrderModel = Core::ImportModel( 'CenterOrder' );
$CenterWarehouseLockModel = Core::ImportModel( 'CenterWarehouseLock' );
$ActionLogModel = Core::ImportModel( 'ActionLog' );

$CenterChannelModel = Core::ImportModel( 'CenterChannel' );
$channelList = $CenterChannelModel->GetList();
$tpl['channelList'] = $channelList;


include( Core::Block( 'warehouse' ) );

$deliveryTypeList = Core::GetConfig( 'order_delivery_type' );
$printStatusList = Core::GetConfig( 'order_print_status' );

$channel_id = $_GET['channel_id'];

$startID = $CenterOrderModel->GetListStartID_delivery_status();
$startID = (int)$startID-1;

$search = array(
	'xiaofwID' => $startID,
	'id' => $_GET['id'],
	'warehouse_id' => $warehouseId,
	'channel_id' => $channel_id,
	'lock_status' => 2,
	'delivery_type' => 1,
	'purchase_check' => 1,
	'service_check' => 1,
	'wait_delivery' => 1,
	'print_status' => 0,
	'product_name' => $_GET['product_name'],
	'logistics_company' => $_GET['logistics_company'],
	'logistics_sn' => $_GET['logistics_sn'],
);





$onePage=999999;
list( $page, $offset, $onePage ) = Common::PageArg( $onePage );


$list = $CenterOrderModel->GetList( $search, $offset, $onePage );
$total = count($list);

$ppList = array();

foreach ( $list as $key => $val )
{
	$list[$key]['add_time'] = DateFormat( $val['add_time'] );
	$list[$key]['delivery_type_name'] = $deliveryTypeList[$val['delivery_type']];
	$list[$key]['print_status_name'] = $printStatusList[$val['print_status']];

	$productList = $CenterOrderModel->GetProductList( $val['id'] );
	$list[$key]['list'] = $CenterOrderExtra->ExplainProduct( $productList );
	$list[$key]['channel_name'] = $channelList[$val['channel_id']]['name'];
	
	foreach ( $list[$key]['list'] as $k => $v ){
		$ppList[$v['sku']]['productName'] = $v['sku_info']['product']['name'];
		$ppList[$v['sku']]['productQuantity'] = $ppList[$v['sku']]['productQuantity']+$v['quantity'];

	}
}
$tpl['ppList'] = $ppList;
$tpl['list'] = $list;
$tpl['total'] = $total;


global $__Config;
$tpl['logistics_list'] = $__Config['logistics_list'];

Common::PageOut( 'delivery/order/pack.html', $tpl );

?>