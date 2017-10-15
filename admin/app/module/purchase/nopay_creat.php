<?php
/*
@@acc_title="创建支出单 nopay_creat"
*/

if ( $_GET['checking'] )
{
$CenterPurchaseModel = Core::ImportModel( 'CenterPurchase' );

$purchaseId = (int)$_GET['id'];
$purchaseInfo = $CenterPurchaseModel->Get( $purchaseId );





/*
foreach ( $purchaseInfo as $key => $val )
{
	echo $key ."///". $val. "--111<br>";

}
*/





if ( !$purchaseInfo )
	Alert( '没有找到采购单' );

Core::LoadClass( 'WorkFlow' );
$WorkFlow = new WorkFlow( 'Purchase' );
$WorkFlow->SetInfo( $purchaseInfo );
$WorkFlow->NextFlow();

header( "refresh:0;url=?mod=purchase.check" );
}
else
{

$CenterProductExtra = Core::ImportExtra( 'CenterProduct' );
$CenterPurchaseExtra = Core::ImportExtra( 'CenterPurchase' );

$CenterPurchaseModel = Core::ImportModel( 'CenterPurchase' );
$CenterSupplierModel = Core::ImportModel( 'CenterSupplier' );
$CenterWarehouseModel = Core::ImportModel( 'CenterWarehouse' );

$supplierList = $CenterSupplierModel->GetList();
$warehouseList = $CenterWarehouseModel->GetList();
$purchaseTypeList = Core::GetConfig( 'purchase_type' );
$purchaseStatusList = Core::GetConfig( 'purchase_status' );
$purchaseReceiveStatusList = Core::GetConfig( 'purchase_receive_status' );
$purchaseProductTypeList = Core::GetConfig( 'purchase_product_type' );
$purchasePaymentTypeList = Core::GetConfig( 'purchase_payment_type' );

list( $page, $offset, $onePage ) = Common::PageArg( 9999 );
global $__UserAuth;
global $__Config;

$search = array();
/*
switch ( $__UserAuth['user_group'] )
		{
			case 12:
			    $search = array('user_id' =>  $__UserAuth['user_id'] );
			break;
			case 13:
			    $search = array('sign_top_jl' =>  $__UserAuth['user_id'] );
			break;
			case 14:
			    //$search = array('sign_top_zj' =>  $__UserAuth['user_id'] );
			break;
			case 15:
			   // $search = array( 'status' => 3 );
			break;
			case 16:
			   // $search = array( 'status' => 3 );
			break;
			case 38:
			   // $search = array( 'status' => 3 );
			break;
			default:
			    $search = array('user_id' =>  -1 );
			break;
}
*/
$search['pay_status']=-1;
//$search['payment_type']= (int)$_GET['paymentType'];

$search['ready_pay'] = 0;



if((int)$_GET['supplierId'] > 0 )
$search['supplier_id'] = (int)$_GET['supplierId'];


//$search = array('status' => 2);


$list = $CenterPurchaseModel->GetListGroup(  $search, $offset, $onePage );
$total = count($list);
//$total = $CenterPurchaseModel->GetTotal( $search );
Core::LoadClass( 'WorkFlow' );
$WorkFlow = new WorkFlow( 'Purchase' );


$AdminModel = Core::ImportModel( 'Admin' );


$all_money_all=0;
foreach ( $list as $key => $val )
{
	$all_money_all+=$val['Allmoney'];
	$list[$key]['supplier_name'] = $supplierList[$val['supplier_id']]['name'];
}

//$tpl['warehouse_list'] = $warehouseList;
//$tpl['supplier_list'] = $supplierList;

$tpl['list'] = $list;
$tpl['all_money_all'] = FormatMoney($all_money_all);
//$tpl['page'] = $page;
//$tpl['total'] = $total;
//$tpl['page_num'] = ceil( $total / $onePage );
//$tpl['page_bar'] = Common::PageBar( $total, $onePage, $page );

if( $__UserAuth['user_group']==38 || $__UserAuth['user_group']==15 || $__UserAuth['user_group']==16 )
{
$search_1 = array();
}
elseif($__UserAuth['user_group']==14)
{
$search_1 = array('manage_zj' => $__UserAuth['user_id'],);
}
else
{
$search_1 = array('manage_id' => $__UserAuth['user_id'],);
}
$search_1 = array();
$tpl['Supplier_list']  = $CenterSupplierModel->GetList( $search_1 );


Common::PageOut( 'purchase/nopay_creat.html', $tpl );
}
?>