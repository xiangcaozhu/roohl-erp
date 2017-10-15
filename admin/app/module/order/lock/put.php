<?php

$CenterOrderModel = Core::ImportModel( 'CenterOrder' );
$CenterWarehouseLockModel = Core::ImportModel( 'CenterWarehouseLock' );
$CenterWarehousePlaceModel = Core::ImportModel( 'CenterWarehousePlace' );
$CenterWarehouseModel = Core::ImportModel( 'CenterWarehouse' );

$placeId = (int)$_GET['place_id'];
$orderProductId = (int)$_GET['order_product_id'];

Core::LoadDom( 'CenterWarehousePlace' );

$WarehousePlaceDom = new CenterWarehousePlaceDom( $placeId );
$WarehousePlaceDom->LockForOrder( $orderProductId );

Common::Loading();

?>