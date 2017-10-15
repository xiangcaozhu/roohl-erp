<?php
/*
@@acc_free
*/
$CenterProductExtra = Core::ImportExtra( 'CenterProduct' );
$CenterPurchaseExtra = Core::ImportExtra( 'CenterPurchase' );

$CenterPurchaseModel = Core::ImportModel( 'CenterPurchase' );
$CenterSupplierModel = Core::ImportModel( 'CenterSupplier' );

Core::LoadClass( 'WorkFlow' );
$WorkFlow = new WorkFlow( 'Purchase' );

$purchaseId = (int)$_GET['id'];

$purchaseInfo = $CenterPurchaseModel->Get( $purchaseId );

if ( !$purchaseInfo )
	Alert( '没有找到采购单' );

$purchaseProductList = $CenterPurchaseModel->GetProductList( $purchaseId );
$purchaseProductList = $CenterPurchaseExtra->ExplainProduct( $purchaseProductList );

$supplierInfo = $CenterSupplierModel->Get( $purchaseInfo['supplier_id'] );
$purchaseInfo['supplier_name'] = $supplierInfo['name'];

$WorkFlow->SetInfo( $purchaseInfo );
$purchaseInfo['workflow_status_name'] = $WorkFlow->GetStatus();
$purchaseInfo['workflow_allow_do'] = $WorkFlow->AllowDo();

$AdminModel = Core::ImportModel( 'Admin' );

if ( $purchaseInfo['user_id'] )
{
	$adminInfo = $AdminModel->GetAdministrator( $purchaseInfo['user_id'] );
	$purchaseInfo['user_name'] = $adminInfo['user_real_name'];
}

if ( $purchaseInfo['sign_pro_mg'] )
{
	$adminInfo = $AdminModel->GetAdministrator( $purchaseInfo['sign_pro_mg'] );
	$purchaseInfo['sign_pro_mg_name'] = $adminInfo['user_real_name'];
}

if ( $purchaseInfo['sign_ope_mj'] )
{
	$adminInfo = $AdminModel->GetAdministrator( $purchaseInfo['sign_ope_mj'] );
	$purchaseInfo['sign_ope_mj_name'] = $adminInfo['user_real_name'];
}

if ( $purchaseInfo['sign_ope_vc'] )
{
	$adminInfo = $AdminModel->GetAdministrator( $purchaseInfo['sign_ope_vc'] );
	$purchaseInfo['sign_ope_vc_name'] = $adminInfo['user_real_name'];
}

$tpl['list'] = $purchaseProductList;
$tpl['info'] = $purchaseInfo;

Common::PageOut( 'purchase/view.html', $tpl );
?>