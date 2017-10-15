<?php
/*
@@acc_free
*/
//$CenterOrderModel = Core::ImportModel( 'CenterOrder' );
//$CenterProductExtra = Core::ImportExtra( 'CenterProduct' );
//$CenterPurchaseExtra = Core::ImportExtra( 'CenterPurchase' );


//Core::LoadClass( 'WorkFlow' );
//$WorkFlow = new WorkFlow( 'Purchase' );

$ActionLogModel = Core::ImportModel( 'ActionLog' );
$CenterOrderModel = Core::ImportModel( 'CenterOrder' );
$CenterSupplierModel = Core::ImportModel( 'CenterSupplier' );
$CenterPurchaseModel = Core::ImportModel( 'CenterPurchase' );
$purchaseId = (int)$_GET['id'];
$purchaseInfo = $CenterPurchaseModel->Get( $purchaseId );
$CenterChannelModel = Core::ImportModel( 'CenterChannel' );

Core::LoadDom( 'CenterSku' );










if ( !$purchaseInfo )
	Alert( '没有找到采购单' );

//$purchaseProductList = $CenterPurchaseModel->GetProductList( $purchaseId );
//$purchaseProductList = $CenterPurchaseExtra->ExplainProduct( $purchaseProductList );

$supplierInfo = $CenterSupplierModel->Get( $purchaseInfo['supplier_id'] );
$purchaseInfo['supplier_name'] = $supplierInfo['name'];


$orderList = $CenterPurchaseModel->GetOrderListByPurchase_1( $purchaseId );

foreach ( $orderList as $key => $val )
{
	$orderList[$key]['info'] = $CenterOrderModel->Get( $val['order_id'] );
	
	$channelInfo = $CenterChannelModel->Get( $orderList[$key]['info']['channel_id'] );
	$orderList[$key]['info']['channel_name'] = $channelInfo['name'] ;

	$orderProductInfo = $CenterOrderModel->GetProductList( $val['order_id'] );
	foreach ( $orderProductInfo as $key_a => $val_a )
	{
	$CenterSkuDom = new CenterSkuDom( $val_a['sku'] );
	$skuInfo = $CenterSkuDom->InitProduct();
	$orderProductInfo[$key_a]['sku_info'] = $skuInfo;
	}
	$orderList[$key]['ProductInfo'] = $orderProductInfo;
	
	
	$orderList[$key]['serviceCheckList'] = $ActionLogModel->GetList( $val['order_id'], 'order_check_service' );
}
//$purchaseInfo['supplier_account_bank'] = $supplierInfo['accountbank'];
//$purchaseInfo['supplier_account_number'] = $supplierInfo['account_number'];



//$WorkFlow->SetInfo( $purchaseInfo );
//$purchaseInfo['workflow_status_name'] = $WorkFlow->GetStatus();
//$purchaseInfo['workflow_allow_do'] = $WorkFlow->AllowDo();


//$orderInfo = $CenterOrderModel->Get( $purchaseInfo['supplier_id'] );




$AdminModel = Core::ImportModel( 'Admin' );

if ( $purchaseInfo['user_id'] )
{
	$adminInfo = $AdminModel->GetAdministrator( $purchaseInfo['user_id'] );
	$purchaseInfo['user_name'] = $adminInfo['user_real_name'];
}

/*
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
*/

$tpl['list'] = $orderList;
$tpl['info'] = $purchaseInfo;



global $__Config;
     $tpl['company_name'] = $__Config['company_name'];









//$tpl['order'] = $orderInfo;

Common::PageOut( 'purchase/printWL.html', $tpl, false, false );

exit();

?>