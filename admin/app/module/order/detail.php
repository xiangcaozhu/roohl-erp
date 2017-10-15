<?php
/*
@@acc_freet
*/
$CenterOrderModel = Core::ImportModel( 'CenterOrder' );
$CenterWarehouseStockModel = Core::ImportModel( 'CenterWarehouseStock' );
$CenterWarehouseLockModel = Core::ImportModel( 'CenterWarehouseLock' );
$CenterWarehousePlaceModel = Core::ImportModel( 'CenterWarehousePlace' );
$CenterWarehouseModel = Core::ImportModel( 'CenterWarehouse' );
$CenterChannelModel = Core::ImportModel( 'CenterChannel' );
$CenterDeliveryModel = Core::ImportModel( 'CenterDelivery' );

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

$channelInfo = $CenterChannelModel->Get( $orderInfo['channel_id'] );
$orderInfo['channel_name'] = $channelInfo['name'];

$productList = $CenterOrderModel->GetProductList( $orderId );

foreach ( $productList as $key => $val )
{
	$productList[$key]['wait_quantity'] = $val['quantity'] - $val['lock_quantity'];

	$CenterSkuDom = new CenterSkuDom( $val['sku'] );
	$skuInfo = $CenterSkuDom->InitProduct();

	$productList[$key]['sku_info'] = $skuInfo;
}

$deliveryList = $CenterDeliveryModel->GetList( array( 'order_id' => $orderId ) );

$tpl['delivery_list'] = $deliveryList;
$tpl['product_list'] = $productList;
$tpl['order'] = $orderInfo;


Common::PageOut( 'order/detail.html', $tpl );

?>