<?php
/*
@@acc_free
@@acc_title="创建支出单 printZC_creat"
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

if ( !is_array( $_POST['purchase_list_Id'] ) )
	Alert( '请选择至少一个采购单' );

$purchaseIdList = $_POST['purchase_list_Id'] ;

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

$pay_money=0;
foreach ( $purchaseChannelList as $key => $val )
{
$purchaseChannelList[$key]['channel_name'] = $channelList[$val['channelID']]['print_name'];
$pp_zc = $CenterPurchaseModel->GetProductList_zc_1( implode(",",$purchaseIdList),$val['channelID'] );
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

$pay_money = $pay_money + $T_totalMoney+$T_costMoney;
}



	$data_pay = array();
	$data_pay['supplier_id'] = $_GET['supplierId'];
	$data_pay['add_time'] = time();
	$data_pay['supplier_name'] = $supplierInfo['name'];
	$data_pay['supplier_account_bank'] = $supplierInfo['accountbank'];
	$data_pay['supplier_account_number'] = $supplierInfo['account_number'];
	$data_pay['all_money'] = $pay_money;
	$data_pay['purchase_id'] = implode(",",$purchaseIdList);
	$data_pay['user_id'] = $__UserAuth['user_id'];
    $data_pay['user_name'] = $__UserAuth['user_real_name'];


	$payId = $CenterPurchaseModel->Add_pay( $data_pay );


foreach ( $purchaseIdList as $key_d => $val_d )
{
	
	$data_purchase = array();
	$data_purchase['ready_pay'] = 1;
    $CenterPurchaseModel->Update( $val_d,$data_purchase );
}


//$tpl['list'] = $purchaseChannelList;
//$tpl['info'] = $purchaseInfo;


//global $__UserAuth;
//global $__Config;
  //   $tpl['company_name'] = $__Config['company_name'];



header( "refresh:0;url=?mod=purchase.nopay_creat" );

//Common::PageOut( 'purchase/printZC.html', $tpl, false, false );

//exit();

?>