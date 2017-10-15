<?php
/*
@@acc_title="打印入库单 print"
*/
$CenterStoreExtra = Core::ImportExtra( 'CenterStore' );

$CenterPurchaseModel = Core::ImportModel( 'CenterPurchase' );
$CenterReceiveModel = Core::ImportModel( 'CenterReceive' );
$CenterStoreModel = Core::ImportModel( 'CenterStore' );
$CenterWarehouseLogModel = Core::ImportModel( 'CenterWarehouseLog' );

include( Core::Block( 'warehouse' ) );

if ( !is_array( $_POST['store_id'] ) )
	Alert( '请选择至少一个单据' );

$list = array();

foreach ( $_POST['store_id'] as $storeId )
{
	$storeInfo = $CenterStoreModel->Get( $storeId );

	if ( !$storeInfo )
		Alert( '没有找到出库单信息,出库单号:' . $storeId );

	$storeProductList = $CenterWarehouseLogModel->GetList( $storeId, 1 );

	if ( !$storeProductList )
		Alert( '没有找到出库单产品信息,订单号:' . $storeId );

	$storeProductList = $CenterStoreExtra->ExplainProduct( $storeProductList );

	$storeInfo['list'] = $storeProductList;
	
	$list[] = $storeInfo;
}

$tpl['list'] = $list;

Common::PageOut( 'store/print.html', $tpl, false, false );

exit();

?>