<?php
/*
@@acc_free
*/
$CenterProductExtra = Core::ImportExtra( 'CenterProduct' );
$CenterPurchaseExtra = Core::ImportExtra( 'CenterPurchase' );

$CenterPurchaseModel = Core::ImportModel( 'CenterPurchase' );
$CenterSupplierModel = Core::ImportModel( 'CenterSupplier' );

$CenterOrderModel = Core::ImportModel( 'CenterOrder' );

$CenterChannelModel = Core::ImportModel( 'CenterChannel' );
$channelList = $CenterChannelModel->GetList();

//Core::LoadClass( 'WorkFlow' );
//$WorkFlow = new WorkFlow( 'Purchase' );

$purchaseId = (int)$_GET['id'];

$purchaseInfo = $CenterPurchaseModel->Get( $purchaseId );

if ( !$purchaseInfo )
	Alert( '没有找到采购单' );

//$purchaseProductList = $CenterPurchaseModel->GetProductList_zc( $purchaseId );
//$purchaseProductList = $CenterPurchaseExtra->ExplainProduct_1( $purchaseProductList );

$supplierInfo = $CenterSupplierModel->Get( $purchaseInfo['supplier_id'] );
$purchaseInfo['supplier_name'] = $supplierInfo['name'];
$purchaseInfo['supplier_account_bank'] = $supplierInfo['accountbank'];
$purchaseInfo['supplier_account_number'] = $supplierInfo['account_number'];


$purchaseChannelList = $CenterPurchaseModel->GetZc_channel( $purchaseId );


foreach ( $purchaseChannelList as $key => $val )
{
$purchaseChannelList[$key]['channel_name'] = $channelList[$val['channelID']]['print_name'];
$pp_zc = $CenterPurchaseModel->GetProductList_zc( $purchaseId,$val['channelID'] );
$purchaseChannelList[$key]['product'] = $pp_zc;
     $T_totalMoney=0;
	 $T_costMoney=0;
	 foreach ( $pp_zc as $keys => $vals )
	 {
	 $T_totalMoney+=$vals['totalPrice'];
	 $T_costMoney+=$vals['costPrice'];
	 }
$purchaseChannelList[$key]['costPrice'] = $T_costMoney;
$purchaseChannelList[$key]['totalMoney'] = $T_totalMoney+$T_costMoney;
}


$tpl['list'] = $purchaseChannelList;
$tpl['info'] = $purchaseInfo;


global $__UserAuth;
global $__Config;
     $tpl['company_name'] = $__Config['company_name'];





Common::PageOut( 'purchase/printZC.html', $tpl, false, false );

exit();

?>