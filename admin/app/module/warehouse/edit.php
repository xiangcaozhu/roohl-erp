<?php
/*
@@acc_freet
*/
$id = (int)$_GET['id'];

$CenterWarehouseModel = Core::ImportModel( 'CenterWarehouse' );

$warehouseInfo = $CenterWarehouseModel->Get($id);

if( !$warehouseInfo )
	Common::Alert( '不存在此ID！' );

if( !$_POST )
{
	$tpl = $warehouseInfo;

	Common::PageOut( 'warehouse/edit.html', $tpl );
}
else
{
	$data = array();

	$data['name'] = $_POST['name'];

	$CenterWarehouseModel->Update( $id, $data );

	Redirect( '?mod=warehouse.list' );
}

?>