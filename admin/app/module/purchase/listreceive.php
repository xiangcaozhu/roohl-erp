<?php

/*
@@acc_title="未完成采购单常规库房 listreceive"
*/
$CenterProductExtra = Core::ImportExtra( 'CenterProduct' );
$CenterPurchaseExtra = Core::ImportExtra( 'CenterPurchase' );

$CenterPurchaseModel = Core::ImportModel( 'CenterPurchase' );
$CenterSupplierModel = Core::ImportModel( 'CenterSupplier' );
$CenterWarehouseModel = Core::ImportModel( 'CenterWarehouse' );

$supplierList = $CenterSupplierModel->GetList();

$warehouseList = $CenterWarehouseModel->GetList( 0, 0, 1);


$purchaseTypeList = Core::GetConfig( 'purchase_type' );
$purchaseStatusList = Core::GetConfig( 'purchase_status' );
$purchaseProductTypeList = Core::GetConfig( 'purchase_product_type' );
$purchasePaymentTypeList = Core::GetConfig( 'purchase_payment_type' );
$purchaseReceiveStatusList = Core::GetConfig( 'purchase_receive_status' );
$intoStatusList = Core::GetConfig( 'into_status' );

list( $page, $offset, $onePage ) = Common::PageArg( 9999 );

/*
$search = array();
*/

global $__UserAuth;

if($_POST['warehouse_id'])
{
$search = array(
	'status' =>3,
	'type' => $_POST['type_id'],
	'id' => $_POST['id'],
	'supplier_id' => $_POST['supplier_id'],
	//'pay_status' => 1,
	'warehouse_id' => $_POST['warehouse_id'],
);
}
else
{
$search = array(
	'status' =>3,
	'type' => $_POST['type_id'],
	'id' => $_POST['id'],
	'supplier_id' => $_POST['supplier_id'],
	//'pay_status' => 1,
	'warehouse_id' => 0,
);
}


switch ( $__UserAuth['user_group'] )
		{
			case 12:
			   $search['user_id']=$__UserAuth['user_id'];
			break;
			case 13:
			    $search['sign_top_jl']=$__UserAuth['user_id'];
			break;
			case 14:
			   $search['sign_top_zj']=$__UserAuth['user_id'];
			break;
			case 15:
			break;
			default:
			    $search['user_id']=-1;
			break;
}



$list = $CenterPurchaseModel->GetList(  $search, $offset, $onePage );
$total = $CenterPurchaseModel->GetTotal( $search );






//$list = $CenterPurchaseModel->GetList( array( 'id' => $_GET['id'], 'supplier_id' => $_GET['supplier_id'] ) );

Core::LoadClass( 'WorkFlow' );
$WorkFlow = new WorkFlow( 'Purchase' );

foreach ( $list as $key => $val )
{
	$list[$key]['add_time'] = DateFormat( $val['add_time'] ,'Y-m-d' );
	$list[$key]['plan_arrive_time'] = DateFormat( $val['plan_arrive_time'] ,'Y-m-d' );
	
	$list[$key]['supplier_name'] = $supplierList[$val['supplier_id']]['name'];
	$list[$key]['warehouse_name'] = $warehouseList[$val['warehouse_id']]['name'];
	$list[$key]['type_name'] = $purchaseTypeList[$val['type']];
	$list[$key]['status_name'] = $purchaseStatusList[$val['status']];
	$list[$key]['receive_status_name'] = $purchaseReceiveStatusList[$val['receive_status']];
	$list[$key]['product_type_name'] = $purchaseProductTypeList[$val['product_type']];
	$list[$key]['payment_type_name'] = $purchasePaymentTypeList[$val['payment_type']];
	
	
	
	
	
	$AdminArray =  Core::ImportModel( 'Admin' ) -> GetAdministrator( $val['user_id'] );
	$list[$key]['user_name_zh'] = $AdminArray['user_real_name'] ;
	
	if( $val['user_id'] == $__UserAuth['user_id'])
	$list[$key]['user_name_zh'] =' <font color="red">'.$AdminArray['user_real_name'].'</font>';

	$WorkFlow->SetInfo( $val );
	$list[$key]['workflow_status_name'] = $WorkFlow->GetStatus();
	$list[$key]['workflow_allow_do'] = $WorkFlow->AllowDo();
}


$tpl['warehouse_list'] = $warehouseList;

$tpl['id'] = $_POST['id'];
$tpl['warehouse_id'] = $_POST['warehouse_id'];

//if($_POST['supplier_id'])
//   $tpl['supplier_name'] = $_POST['supplier_name'];
//else
   $tpl['supplier_name'] = '请输入供应商名称进行查找...';

$tpl['supplier_id'] = $_POST['supplier_id'];

$tpl['list'] = $list;
$tpl['total'] = $total;

$tpl['type_id'] =$_POST['type_id'];

Common::PageOut( 'purchase/listreceive.html', $tpl );

?>