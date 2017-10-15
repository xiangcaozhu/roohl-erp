<?php
/*
@@acc_title="打印发货单 print"
*/



$CenterOrderExtra = Core::ImportExtra( 'CenterOrder' );

$CenterOrderModel = Core::ImportModel( 'CenterOrder' );
$CenterWarehouseLockModel = Core::ImportModel( 'CenterWarehouseLock' );

$CenterChannelModel = Core::ImportModel( 'CenterChannel' );
$channelList = $CenterChannelModel->GetList();

include( Core::Block( 'warehouse' ) );

$deliveryTypeList = Core::GetConfig( 'order_delivery_type' );
$printStatusList = Core::GetConfig( 'order_print_status' );


$search = array(
	'warehouse_id' => $warehouseId,
	'lock_status' => 2,
	'delivery_type' => 1,
	'purchase_check' => 1,
	'service_check' => 1,
	'wait_delivery' => 1,
	'delivery_ready_status' => 1,
	'print_status' => 0,
	//'logistics_company' => $_GET['logistics_company'],
);


//$Order_list = $CenterOrderModel->GetList( $search );

$list = $CenterOrderModel->GetDelivery_List( $search );
//$total = $CenterOrderModel->GetTotal( $search );

/*
foreach ( $list as $key => $val )
{
	$list[$key]['add_time'] = DateFormat( $val['add_time'] );
	$list[$key]['delivery_type_name'] = $deliveryTypeList[$val['delivery_type']];
	$list[$key]['print_status_name'] = $printStatusList[$val['print_status']];

	$productList = $CenterOrderModel->GetProductList( $val['id'] );
	$list[$key]['list'] = $CenterOrderExtra->ExplainProduct( $productList );
	$list[$key]['channel_name'] = $channelList[$val['channel_id']]['name'];
}
*/
//$tpl['total'] = $total;

//global $__Config;
//$tpl['logistics_list'] = $__Config['logistics_list'];


$CenterProductExtra = Core::ImportExtra( 'CenterProduct' );
Core::LoadDom( 'CenterSku' );

foreach ( $list as $key => $val )
{


$searchP = array(
	'warehouse_id' => $warehouseId,
	'lock_status' => 2,
	'delivery_type' => 1,
	'purchase_check' => 1,
	'service_check' => 1,
	'wait_delivery' => 1,
	'delivery_ready_status' => 1,
	'print_status' => 0,
	'channel_id' => $val['channel_id'],
	'logistics_company' => $val['logistics_company'],
);

$orderList = $CenterOrderModel->GetDelivery_order_List($searchP);
$list[$key]['orderList'] = $orderList;


$order_List = "0";
foreach ( $orderList as $key_a => $val_a )
{
$order_List .= ",".$val_a['id'];
}


$skuList = $CenterOrderModel->GetDelivery_sku_List($order_List);

foreach ( $skuList as $key_b => $val_b )
{
    $CenterSkuDom = new CenterSkuDom( $val_b['sku'] );
	$skuInfo = $CenterSkuDom->InitProduct();
    $skuList[$key_b]['sku_info'] = $skuInfo;
}


$list[$key]['skuList'] = $skuList;


$list[$key]['channel_name'] = $channelList[$val['channel_id']]['name'];
}




/*

*/
/*

$needList = $CenterOrderModel->GetDeliveryList($search);

$CenterProductExtra = Core::ImportExtra( 'CenterProduct' );
//$CenterPurchaseModel = Core::ImportModel( 'CenterPurchase' );

Core::LoadDom( 'CenterSku' );
foreach ( $needList as $key => $val )
{
    $my_isnew = 0;
	$CenterSkuDom = new CenterSkuDom( $val['sku'] );
	$skuInfo = $CenterSkuDom->InitProduct();

	if ( $lockList[$val['sku_id']] )
		$needList[$key]['checked'] = true;
	else
		$needList[$key]['checked'] = false;

	if ( $lockList[$val['sku_id']] && $lockList[$val['sku_id']]['user_id'] != $__UserAuth['user_id'] )
		$needList[$key]['disabled'] = true;
	else
		$needList[$key]['disabled'] = false;

	//$needList[$key]['onroad_quantity'] = (int)$CenterPurchaseModel->GetOnRoadNum( $val['sku_id'] );
	
	//$stockInfo = $CenterWarehouseStockModel->GetLiveQuantityBySkuId( $val['sku_id'] );

	//$needList[$key]['warehouse_quantity'] = (int)$stockInfo['quantity'];
	//$needList[$key]['warehouse_lock_quantity'] = (int)$stockInfo['lock_quantity'];
	//$needList[$key]['warehouse_live_quantity'] = (int)$stockInfo['live_quantity'];

	$needList[$key]['sku_info'] = $skuInfo;
	
	$search['logistics_company'] = $val['logistics_company'];
	$needList[$key]['order_list'] = $CenterOrderModel->GetDeliveryProductList( $search, $val['sku_id'] );
	
}

$tpl['need_list'] = $needList;

*/
$tpl['list'] = $list;

Common::PageOut( 'delivery/print.html', $tpl );


/*
Common::PageOut( 'purchase/new/need.html', $tpl );
*/

?>