<?php

$CenterWarehouseModel = Core::ImportModel( 'CenterWarehouse' );

$warehouseList = $CenterWarehouseModel->GetList();

$warehouseId = intval( $_GET['warehouse_id'] );
$warehouseInfo = $warehouseList[$warehouseId];

if ( $warehouseId && !$warehouseInfo )
	Alert( '仓库信息丢失' );

$warehouseUri = "&warehouse_id={$warehouseId}";

$tpl['warehouse_id'] = $warehouseId;
$tpl['warehouse_list'] = $warehouseList;
$tpl['warehouse_info'] = $warehouseInfo;
$tpl['warehouse_uri'] = $warehouseUri;

?>