<?php
/*
@@acc_title="删除采购单 del"
*/
$CenterProductExtra = Core::ImportExtra( 'CenterProduct' );
$CenterPurchaseExtra = Core::ImportExtra( 'CenterPurchase' );

$CenterPurchaseModel = Core::ImportModel( 'CenterPurchase' );
$CenterSupplierModel = Core::ImportModel( 'CenterSupplier' );
$CenterOrderModel = Core::ImportModel( 'CenterOrder' );

$purchaseId = (int)$_GET['id'];

$purchaseInfo = $CenterPurchaseModel->Get( $purchaseId );

if ( !$purchaseInfo )
	Alert( '没有找到采购单' );

if ( $purchaseInfo['receive_status'] != 1 )
	Alert( '只有尚未收货的采购单才允许删除' );

$purchaseProductList = $CenterPurchaseModel->GetProductList( $purchaseId );
$purchaseProductList = $CenterPurchaseExtra->ExplainProduct( $purchaseProductList );

$CenterPurchaseModel->Model->DB->Begin();

foreach ( $purchaseProductList as $purchaseProductInfo )
{
	if ( $purchaseProductInfo['receive_quantity'] )
		Alert( '只有尚未收货的采购单才允许删除' );

	$relationList = $purchaseProductInfo['relation_list'];
	$purchaseProductId = $purchaseProductInfo['id'];

	foreach ( $relationList as $val )
	{
		$CenterPurchaseModel->DelRelation( $val['id'] );
		$CenterOrderModel->UpdateProduct( $val['order_product_id'], false, "purchase_quantity = purchase_quantity - " . $val['quantity'] );
	}

	$CenterPurchaseModel->DelProduct( $purchaseProductId );
}

$CenterPurchaseModel->Del( $purchaseId );
$CenterPurchaseModel->Model->DB->Commit();


$gos = (int)$_GET['go'];

if($gos>0)
{
Redirect( "?mod=purchase.check" );
}
else
{
Redirect( "?mod=purchase.list" );
}
?>