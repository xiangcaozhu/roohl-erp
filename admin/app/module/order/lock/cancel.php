<?php

$CenterOrderModel = Core::ImportModel( 'CenterOrder' );
$CenterWarehouseLockModel = Core::ImportModel( 'CenterWarehouseLock' );
$CenterWarehousePlaceModel = Core::ImportModel( 'CenterWarehousePlace' );
$CenterWarehouseModel = Core::ImportModel( 'CenterWarehouse' );

$lockId = (int)$_GET['id'];
$lockInfo = $CenterWarehouseLockModel->Get( $lockId );

Core::LoadDom( 'CenterWarehousePlace' );

$WarehousePlaceDom = new CenterWarehousePlaceDom( $lockInfo['place_id'] );
$WarehousePlaceDom->UnLock( $lockId );

Common::Loading();

?>