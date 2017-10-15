<?php
	
if( !$_POST )
{
	$CenterWarehouseModel = Core::ImportModel( 'CenterWarehouse' );
	$warehouseList = $CenterWarehouseModel->GetList();
	$tpl['list'] = $warehouseList;

	Common::PageOut( 'warehouse/place/add.html', $tpl );
}
else
{
	$CenterWarehousePlaceModel = Core::ImportModel( 'CenterWarehousePlace' );

	$data = array();
	
	$data['name'] = $_POST['name'];
	$data['nick_name'] = $_POST['nick_name'];
	$data['warehouse_id'] = $_POST['warehouse_id'];
	$data['no_delivery'] = (int)$_POST['no_delivery'];
	
	$info = $CenterWarehousePlaceModel->GetByName( $_POST['warehouse_id'], $_POST['name'] );

	if ( $info )
		Common::Alert( '存在相同的货位名称！' );

	$warehouseplaceInfo = $CenterWarehousePlaceModel->Add( $data );

	if( !$warehouseplaceInfo )
		Common::Alert('添加失败！请联系管理员！');

	else
		Redirect( '?mod=warehouse.place.add' );
	
}

?>