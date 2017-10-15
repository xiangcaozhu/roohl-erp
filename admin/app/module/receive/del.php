<?php
/*
@@acc_title="删除收货单 del"
*/
$CenterReceiveExtra = Core::ImportExtra( 'CenterReceive' );

$CenterReceiveModel = Core::ImportModel( 'CenterReceive' );
$CenterPurchaseModel = Core::ImportModel( 'CenterPurchase' );

include( Core::Block( 'warehouse' ) );

$receiveId = (int)$_GET['id'];

$receiveInfo = $CenterReceiveModel->Get( $receiveId );

if ( !$receiveInfo )
	Alert( '没有找到收货单' );

if ( $receiveInfo['into_status'] != 1 )
	Alert( '只有尚未入库的收货单才允许删除' );

$receiveProductList = $CenterReceiveModel->GetProductList( $receiveId );


$CenterReceiveModel->Model->DB->Begin();

foreach ( $receiveProductList as $val )
{
	if ( $val['into_quantity'] > 0 )
		Alert( '不能删除已经入库的采购单' );

	$CenterReceiveModel->DelProduct( $val['id'] );
	$CenterPurchaseModel->UpdateProduct( $val['purchase_product_id'], false, "receive_quantity = receive_quantity - " . $val['quantity'] );
}

$CenterReceiveModel->Del( $receiveId );

// 更新采购单的收货状态
Core::LoadDom( 'CenterPurchase' );
$CenterPurchaseDom = new CenterPurchaseDom( $receiveInfo['purchase_id'] );
$CenterPurchaseDom->UpdateStatus();


$CenterReceiveModel->Model->DB->Commit();

Redirect( "?mod=receive.list{$warehouseUri}" );

?>