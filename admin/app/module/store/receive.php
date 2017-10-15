<?php
/*
@@acc_title="收货入库 receive"
*/
$CenterProductExtra = Core::ImportExtra( 'CenterProduct' );

$CenterPurchaseModel = Core::ImportModel( 'CenterPurchase' );
$CenterReceiveModel = Core::ImportModel( 'CenterReceive' );

$receiveTypeList = Core::GetConfig( 'receive_type' );
$intoStatusList = Core::GetConfig( 'into_status' );

include( Core::Block( 'warehouse' ) );

$list = $CenterReceiveModel->GetList( array( 'warehouse_id' => $warehouseId, 'wait_store' => 1 ) );

foreach ( $list as $key => $val )
{
	$list[$key]['add_time'] = DateFormat( $val['add_time'] );
	$list[$key]['type_name'] = $receiveTypeList[$val['type']];
	$list[$key]['into_status_name'] = $intoStatusList[$val['into_status']];
	$list[$key]['warehouse_name'] = $warehouseList[$val['warehouse_id']]['name'];
}

$tpl['list'] = $list;

Common::PageOut( 'store/receive.html', $tpl );

?>