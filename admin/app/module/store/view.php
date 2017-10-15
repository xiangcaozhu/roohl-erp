<?php
/*
@@acc_free
*/
$CenterStoreExtra = Core::ImportExtra( 'CenterStore' );

$CenterStoreModel = Core::ImportModel( 'CenterStore' );
$CenterWarehouseLogModel = Core::ImportModel( 'CenterWarehouseLog' );

include( Core::Block( 'warehouse' ) );

$storeId = (int)$_GET['id'];

$storeInfo = $CenterStoreModel->Get( $storeId );

if ( !$storeInfo )
	Alert( '没有找到收货单' );

$storeTypeList = Core::GetConfig( 'store_type' );
$storeInfo['type_name'] = $storeTypeList[$storeInfo['type']];

$storeProductList = $CenterWarehouseLogModel->GetList( $storeId, 1 );
$storeProductList = $CenterStoreExtra->ExplainProduct( $storeProductList );

$tpl['list'] = $storeProductList;
$tpl['info'] = $storeInfo;

Common::PageOut( 'store/view.html', $tpl );

?>