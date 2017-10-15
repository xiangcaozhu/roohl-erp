<?php

$CenterProductExtra = Core::ImportExtra( 'CenterProduct' );
$CenterPurchaseExtra = Core::ImportExtra( 'CenterPurchase' );

$CenterPurchaseModel = Core::ImportModel( 'CenterPurchase' );
$CenterSupplierModel = Core::ImportModel( 'CenterSupplier' );
$CenterOrderModel = Core::ImportModel( 'CenterOrder' );

$purchaseProductId = (int)$_GET['id'];
$purchaseProductInfo = $CenterPurchaseModel->GetProduct( $purchaseProductId );

if ( !$purchaseProductInfo )
	Alert( '没有找到请求的数据' );

$purchaseId = $purchaseProductInfo['purchase_id'];
$purchaseInfo = $CenterPurchaseModel->Get( $purchaseId );

if ( !$purchaseInfo )
	Alert( '没有找到对应的采购单' );

if ( $purchaseProductInfo['receive_quantity'] > 0 )
	Alert( '已经开始收货了,不能取消' );

$relationList = $CenterPurchaseModel->GetRelationListByPurchaseProduct( $purchaseProductId );

$CenterPurchaseModel->Model->DB->Begin();

foreach ( $relationList as $val )
{
	$CenterPurchaseModel->DelRelation( $val['id'] );
	$CenterOrderModel->UpdateProduct( $val['order_product_id'], false, "purchase_quantity = purchase_quantity - " . $val['quantity'] );
}

$CenterPurchaseModel->DelProduct( $purchaseProductId );

$CenterPurchaseModel->Model->DB->Commit();
$CenterPurchaseModel->StatTotal( $purchaseId );

// 更新采购单的收货状态
$purchaseInfo = $CenterPurchaseModel->Get( $purchaseId );
Core::LoadDom( 'CenterPurchase' );
$CenterPurchaseDom = new CenterPurchaseDom( $purchaseInfo );
$CenterPurchaseDom->UpdateStatus();

Redirect( "?mod=purchase.edit&id=" . $purchaseId );

?>