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

//if ( !is_array( $_POST['purchase_list_Id'] ) )
	//Alert( '请选择至少一个采购单' );

//$purchaseIdList = $_POST['purchase_list_Id'] ;
$purchaseIdList = explode(',',$_GET['purchase_list_Id']) ;

//$purchaseInfo = $CenterPurchaseModel->Get( $purchaseId );

//if ( !$purchaseInfo )
	//Alert( '没有找到采购单' );

//$purchaseProductList = $CenterPurchaseModel->GetProductList_zc( $purchaseId );
//$purchaseProductList = $CenterPurchaseExtra->ExplainProduct_1( $purchaseProductList );

$supplierInfo = $CenterSupplierModel->Get( $_GET['supplierId'] );
$purchaseInfo['supplier_name'] = $supplierInfo['name'];
$purchaseInfo['supplier_account_bank'] = $supplierInfo['accountbank'];
$purchaseInfo['supplier_account_number'] = $supplierInfo['account_number'];

$purchaseChannelList = $CenterPurchaseModel->GetZc_channel_1( implode(",",$purchaseIdList) );

$kkk=0;
$pds=0;
foreach ( $purchaseChannelList as $key => $val )
{
$purchaseChannelList[$key]['channel_name'] = $channelList[$val['channelID']]['print_name'];
$pp_zc = $CenterPurchaseModel->GetProductList_zc_1_1( implode(",",$purchaseIdList),$val['channelID'] );
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
$pds++;


$kkk=$kkk+$T_totalMoney+$T_costMoney;

}


$purchaseChannel_No = array();
foreach ( $purchaseIdList as $key_p => $val_p )
{
$purchaseChannelListd = $CenterPurchaseModel->GetZc_channel_1( $val_p );
//echo $val_p.'+'.count($purchaseChannelList).'<br>';
    if(count($purchaseChannelListd)===0)
	{
	$purchaseChannel_No[] = $val_p;
	}
}

if(count($purchaseChannel_No)>0)
{
$purchaseChannelList[$pds]['channel_name'] = '银行分期（入库）';
$pp_zcd = $CenterPurchaseModel->GetProductList_zc_2( implode(",",$purchaseChannel_No) );
$purchaseChannelList[$pds]['product'] = $pp_zcd;

//$pp_zc = $CenterPurchaseModel->GetProductList_zc_1_1( implode(",",$purchaseIdList),$val['channelID'] );
//$purchaseChannelList[$key]['product'] = $pp_zc;


     $T_totalMoney=0;
	 $T_costMoney=0;
	 foreach ( $pp_zcd as $keyss => $valss )
	 {
	 $T_totalMoney+=$valss['totalPrice'];
	 $T_costMoney+=$valss['costPrice'];
	 }
$purchaseChannelList[$pds]['costPrice'] = $T_costMoney;
$purchaseChannelList[$pds]['totalMoney'] = $T_totalMoney+$T_costMoney;

$kkk=$kkk+$T_totalMoney+$T_costMoney;
}
/*
*/










$tpl['list'] = $purchaseChannelList;
$tpl['info'] = $purchaseInfo;


global $__UserAuth;
global $__Config;
     $tpl['company_name'] = $__Config['company_name'];

//echo $kkk;



Common::PageOut( 'purchase/printZC_alls.html', $tpl, false, false );

exit();

?>