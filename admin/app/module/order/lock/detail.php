<?php

$CenterOrderModel = Core::ImportModel( 'CenterOrder' );
$CenterWarehouseStockModel = Core::ImportModel( 'CenterWarehouseStock' );
$CenterWarehouseLockModel = Core::ImportModel( 'CenterWarehouseLock' );
$CenterWarehousePlaceModel = Core::ImportModel( 'CenterWarehousePlace' );
$CenterWarehouseModel = Core::ImportModel( 'CenterWarehouse' );

Core::LoadDom( 'CenterSku' );

$warehouseList = $CenterWarehouseModel->GetList();

$orderId = (int)$_GET['id'];

$orderInfo = $CenterOrderModel->Get( $orderId );

if ( !$orderInfo )
	Alert( '没有找到指定的订单' );

$orderDeliveryTypeList = Core::GetConfig( 'order_delivery_type' );
$orderDeliveryStatusList = Core::GetConfig( 'order_delivery_status' );
$orderLockStatusList = Core::GetConfig( 'order_lock_status' );

$orderInfo['delivery_type_name'] = $orderDeliveryTypeList[$orderInfo['delivery_type']];
$orderInfo['delivery_status_name'] = $orderDeliveryStatusList[$orderInfo['delivery_status']];
$orderInfo['lock_status_name'] = $orderLockStatusList[$orderInfo['lock_status']];

$productList = $CenterOrderModel->GetProductList( $orderId );

foreach ( $productList as $key => $val )
{
	$lockList = $CenterWarehouseLockModel->GetListByOrderProduct( $val['id'] );

	foreach ( $lockList as $k => $v )
	{
		$placeInfo = $CenterWarehousePlaceModel->Get( $v['place_id'] );
		$lockList[$k]['place_name'] = $placeInfo['name'];
		$lockList[$k]['warehouse_name'] = $warehouseList[$v['warehouse_id']]['name'];
	}

	$productList[$key]['lock_list'] = $lockList;

	$stockList = $CenterWarehouseStockModel->GetLiveListBySkuId( $val['sku_id'] );
	$tpl['aaaaa'] =  $val['sku_id'];

	foreach ( $stockList as $k => $v )
	{
		$placeInfo = $CenterWarehousePlaceModel->Get( $v['place_id'] );
		$stockList[$k]['place_name'] = $placeInfo['name'];
		$stockList[$k]['warehouse_name'] = $warehouseList[$v['warehouse_id']]['name'];
		$stockList[$k]['live_quantity'] = $v['quantity'] - $v['lock_quantity'];
	}

	$productList[$key]['stock_list'] = $stockList;

	$productList[$key]['wait_quantity'] = $val['quantity'] - $val['lock_quantity'];

	$CenterSkuDom = new CenterSkuDom( $val['sku'] );
	$skuInfo = $CenterSkuDom->InitProduct();
	
	$productList[$key]['sku_info'] = $skuInfo;
}

$tpl['product_list'] = $productList;
$tpl['order'] = $orderInfo;

Common::PageOut( 'order/lock/detail.html', $tpl );

?>