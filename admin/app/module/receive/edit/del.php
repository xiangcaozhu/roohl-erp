<?php

$CenterReceiveExtra = Core::ImportExtra( 'CenterReceive' );

$CenterReceiveModel = Core::ImportModel( 'CenterReceive' );
$CenterPurchaseModel = Core::ImportModel( 'CenterPurchase' );

$receiveProductId = (int)$_GET['id'];

$receiveProductInfo = $CenterReceiveModel->GetProduct( $receiveProductId );

if ( !$receiveProductInfo )
	Alert( '没有找到收货单商品' );

$receiveId = $receiveProductInfo['receive_id'];
$receiveInfo = $CenterReceiveModel->Get( $receiveId );

if ( !$receiveInfo )
	Alert( '没有找到收货单' );

if ( $receiveProductInfo['into_quantity'] > 0 )
	Alert( '不能取消已经入库的采购单' );


$CenterReceiveModel->Model->DB->Begin();


$CenterReceiveModel->DelProduct( $receiveProductId );
$CenterPurchaseModel->UpdateProduct( $receiveProductInfo['purchase_product_id'], false, "receive_quantity = receive_quantity - " . $receiveProductInfo['quantity'] );


// 更新采购单的收货状态
Core::LoadDom( 'CenterPurchase' );
$CenterPurchaseDom = new CenterPurchaseDom( $receiveInfo['purchase_id'] );
$CenterPurchaseDom->UpdateStatus();

// 更新采购单的入库状态
Core::LoadDom( 'CenterReceive' );
$CenterReceiveDom = new CenterReceiveDom( $receiveId );
$CenterReceiveDom->UpdateStatus();


$CenterReceiveModel->Model->DB->Commit();


Redirect( "?mod=receive.edit{$warehouseUri}&id={$receiveId}" );

?>