<?php

$CenterOrderModel = Core::ImportModel( 'CenterOrder' );
$CenterWarehouseStockModel = Core::ImportModel( 'CenterWarehouseStock' );
$CenterWarehouseLockModel = Core::ImportModel( 'CenterWarehouseLock' );
$CenterWarehousePlaceModel = Core::ImportModel( 'CenterWarehousePlace' );
$CenterWarehouseModel = Core::ImportModel( 'CenterWarehouse' );
$CenterChannelModel = Core::ImportModel( 'CenterChannel' );

$orderId = (int)$_GET['order_id'];
$orderProductId = (int)$_GET['order_product_id'];

$orderInfo = $CenterOrderModel->Get( $orderId );
$orderProductInfo = $CenterOrderModel->GetProduct( $orderProductId );

if ( !$orderInfo )
	Alert( '没有找到指定的订单' );

if ( !$orderProductInfo )
	Alert( '没有找到指定的订单商品行' );

if ( $orderProductInfo['order_id'] != $orderId )
	Alert( '商品行订单号与指定订单不符' );

if ( $orderProductInfo['lock_quantity'] > 0 )
	Alert( '商品行是已配货状态,不能删除' );

if ( $orderProductInfo['lock_quantity'] > 0 || $orderProductInfo['purchase_quantity'] > 0 || $orderProductInfo['delivery_quantity'] > 0 )
	exit( '订单产品行已经有后续操作,不能更改属性' );



$CenterOrderModel->DelProduct( $orderProductId );

// 更新订单状态和统计
Core::LoadDom( 'CenterOrder' );
$OrderDom = new CenterOrderDom( $orderId );
$OrderDom->UpdateStatus();
$CenterOrderModel->StatTotal( $orderId );

Common::Loading();

?>