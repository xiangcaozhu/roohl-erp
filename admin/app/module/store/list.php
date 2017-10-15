<?php
/*
@@acc_title="入库单列表 list"
*/
$CenterProductExtra = Core::ImportExtra( 'CenterProduct' );

$CenterPurchaseModel = Core::ImportModel( 'CenterPurchase' );
$CenterReceiveModel = Core::ImportModel( 'CenterReceive' );
$CenterStoreModel = Core::ImportModel( 'CenterStore' );

include( Core::Block( 'warehouse' ) );

$storeTypeList = Core::GetConfig( 'store_type' );

list( $page, $offset, $onePage ) = Common::PageArg( 20 );

$search = array(
	'warehouse_id' => $warehouseId,
	'type' => $_GET['store_type'],
	'begin_time' => $_GET['begin_date'] ? strtotime( $_GET['begin_date'] . ' 00:00:00' ) : false,
	'end_time' => $_GET['end_date'] ? strtotime( $_GET['end_date'] . ' 23:59:59' ) : false,
);

$list = $CenterStoreModel->GetList( $search, $offset, $onePage );
$total = $CenterStoreModel->GetTotal( $search );

foreach ( $list as $key => $val )
{
	$list[$key]['add_time'] = DateFormat( $val['add_time'] );
	$list[$key]['warehouse_name'] = $warehouseList[$val['warehouse_id']]['name'];

	$list[$key]['type_name'] = $storeTypeList[$val['type']];
	
	$AdminArray =  Core::ImportModel( 'Admin' ) -> GetAdministrator( $val['user_id'] );
	$list[$key]['user_name_zh'] = $AdminArray['user_real_name'] ;
}

$tpl['list'] = $list;
$tpl['store_type_list'] = $storeTypeList;
$tpl['page'] = $page;
$tpl['total'] = $total;
$tpl['page_num'] = ceil( $total / $onePage );
$tpl['page_bar'] = Common::PageBar( $total, $onePage, $page );

Common::PageOut( 'store/list.html', $tpl );

?>