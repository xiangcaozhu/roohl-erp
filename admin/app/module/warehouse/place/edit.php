<?php

$id = (int)$_GET['id'];

$CenterWarehouseModel = Core::ImportModel( 'CenterWarehouse' );
$CenterWarehousePlaceModel = Core::ImportModel( 'CenterWarehousePlace' );
$CenterWarehouseStockModel = Core::ImportModel( 'CenterWarehouseStock' );

$placeInfo = $CenterWarehousePlaceModel->Get( $id );

if ( !$placeInfo )
	Common::Alert( '不存在此ID！' );

if ( !$_POST )
{
	$warehouseList = $CenterWarehouseModel->GetList();

	$tpl['info'] = $placeInfo;
	$tpl['list'] = $warehouseList;

	Common::PageOut( 'warehouse/place/edit.html', $tpl );
}
else
{
	if ( $_POST['name'] != $placeInfo['name'] )
	{
		if ( $CenterWarehousePlaceModel->GetByName( $placeInfo['warehouse_id'], $_POST['name'] ) )
			Common::Alert( '存在相同的货位名称！' );
	}
	
	$data = array();

	$data['name'] = $_POST['name'];
	$data['nick_name'] = $_POST['nick_name'];
	$data['no_delivery'] = (int)$_POST['no_delivery'];

	$CenterWarehousePlaceModel->Update( $id, $data );
	$CenterWarehouseStockModel->UpdateByPlace( $placeInfo['warehouse_id'], $placeInfo['id'], array( 'no_delivery'=> intval( $_POST['no_delivery'] ) ) );

	Redirect( '?mod=warehouse.place' );
}

?>