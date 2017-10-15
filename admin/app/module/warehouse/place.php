<?php
/*
@@acc_title="货位管理 place"
*/
$CenterWarehousePlaceModel = Core::ImportModel( 'CenterWarehousePlace' );
$CenterWarehouseModel = Core::ImportModel( 'CenterWarehouse' );

$warehouseList = $CenterWarehouseModel->GetList();


list( $page, $offset, $onePage ) = Common::PageArg( 20 );

$list = $CenterWarehousePlaceModel->GetList( $_GET['warehouse_id'], $offset, $onePage );
$total = $CenterWarehousePlaceModel->GetTotal( $_GET['warehouse_id'] );


foreach ( $list as $key => $val )
{
	$list[$key]['warehouse_name'] = $warehouseList[$val['warehouse_id']]['name'];
}


$tpl['list'] = $list;
$tpl['page'] = $page;
$tpl['total'] = $total;
$tpl['page_num'] = ceil( $total / $onePage );
$tpl['page_bar'] = Common::PageBar( $total, $onePage, $page );

Common::PageOut( 'warehouse/place/list.html', $tpl );

?>