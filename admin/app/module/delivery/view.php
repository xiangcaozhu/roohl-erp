<?php
/*
@@acc_freet
*/
$CenterDeliveryExtra = Core::ImportExtra( 'CenterDelivery' );

$CenterDeliveryModel = Core::ImportModel( 'CenterDelivery' );
$CenterWarehouseLogModel = Core::ImportModel( 'CenterWarehouseLog' );

include( Core::Block( 'warehouse' ) );

$deliveryId = (int)$_GET['id'];

$deliveryInfo = $CenterDeliveryModel->Get( $deliveryId );

if ( !$deliveryInfo )
	Alert( '没有找到收货单' );

$deliveryTypeList = Core::GetConfig( 'delivery_type' );
$deliveryInfo['type_name'] = $deliveryTypeList[$deliveryInfo['type']];

$deliveryProductList = $CenterWarehouseLogModel->GetList( $deliveryId, 2 );
$deliveryProductList = $CenterDeliveryExtra->ExplainProduct( $deliveryProductList );

$tpl['list'] = $deliveryProductList;
$tpl['info'] = $deliveryInfo;

Common::PageOut( 'delivery/view.html', $tpl );

?>