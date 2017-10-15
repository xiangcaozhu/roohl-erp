<?php

/*
@@acc_title="常规库房→采购单列表 listreceive_m"
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
$purchaseReceiveStatusList = Core::GetConfig( 'into_status' );
$purchaseProductTypeList = Core::GetConfig( 'purchase_product_type' );
$purchasePaymentTypeList = Core::GetConfig( 'purchase_payment_type' );

if((int)$onePage<1)
    $onePage=5;


list( $page, $offset, $onePage ) = Common::PageArg( $onePage );

/*
$search = array();
*/

global $__UserAuth;



$tpl['U_ID'] =$__UserAuth['user_id'];


$search = array(
	'status' => (int)$_GET['status'],
	'warehouse_id' => 0,
	'supplier_id' => $_GET['supplier_id'],
	'into_status' => $_GET['into_status'],
	'begin_time' => $_GET['begin_date'] ? strtotime( $_GET['begin_date'] . ' 00:00:00' ) : false,
	'end_time' => $_GET['end_date'] ? strtotime( $_GET['end_date'] . ' 23:59:59' ) : false,
);

if((int)$_GET['order_id']>0)
{
//$PurchaseIDList = $CenterPurchaseModel->GetPurchaseIDByOrder( (int)$_GET['order_id'] );
//$PurchaseIDList = implode(",",$PurchaseIDList);
$search['order_id'] = (int)$_GET['order_id'];
}
elseif((int)$_GET['id']>0)
{
$PurchaseID = $_GET['id'];
$search['id']=$PurchaseID;
}

/*
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
			case 16:
			break;
			case 38:
			break;
			default:
			    $search['user_id']=-1;
			break;
}
*/


$list = $CenterPurchaseModel->GetList(  $search, $offset, $onePage );
$total = $CenterPurchaseModel->GetTotal( $search );






//$list = $CenterPurchaseModel->GetList( array( 'id' => $_GET['id'], 'supplier_id' => $_GET['supplier_id'] ) );

Core::LoadClass( 'WorkFlow' );
$WorkFlow = new WorkFlow( 'Purchase' );

foreach ( $list as $key => $val )
{
$purchaseProductList = $CenterPurchaseModel->GetProductList( $val['id'] );
$purchaseProductList = $CenterPurchaseExtra->ExplainProduct_1( $purchaseProductList );
$list[$key]['productList'] = $purchaseProductList;


$purchaseOrderList = $CenterPurchaseModel->GetOrderListByPurchase_2( $val['id'] );
$list[$key]['orderList'] = $purchaseOrderList;

	$list[$key]['add_time'] = DateFormat( $val['add_time'] ,'Y-m-d' );
	$list[$key]['plan_arrive_time'] = DateFormat( $val['plan_arrive_time'] ,'Y-m-d' );
	
	$list[$key]['supplier_name'] = $supplierList[$val['supplier_id']]['name'];
	$list[$key]['warehouse_name'] = $warehouseList[$val['warehouse_id']]['name'];
	$list[$key]['type_name'] = $purchaseTypeList[$val['type']];
	$list[$key]['status_name'] = $purchaseStatusList[$val['status']];
	$list[$key]['into_status_name'] = $purchaseReceiveStatusList[$val['into_status']];
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

//$tpl['id'] = $_POST['id'];
//$tpl['warehouse_id'] = $_GET['warehouse_id'];

//if($_POST['supplier_id'])
//   $tpl['supplier_name'] = $_POST['supplier_name'];
//else
   //$tpl['supplier_name'] = '请输入供应商名称进行查找...';

//$tpl['supplier_id'] = $_POST['supplier_id'];







if( $__UserAuth['user_group']==38 || $__UserAuth['user_group']==15 || $__UserAuth['user_group']==16 )
{
$search_a = array();
}
elseif($__UserAuth['user_group']==14)
{
$search_a = array('manage_zj' => $__UserAuth['user_id'],);
}
else
{
$search_a = array('manage_id' => $__UserAuth['user_id'],);
}

$search_a = array();
$tpl['Supplier_list']  = $CenterSupplierModel->GetList( $search_a );




$tpl['list'] = $list;
$tpl['total'] = $total;
$tpl['page_num'] = ceil( $total / $onePage );
$tpl['page_bar'] = Common::PageBar( $total, $onePage, $page );
$tpl['page_bar_a'] = Common::PageBar_a( $total, $onePage, $page );
$tpl['page_bar_b'] = Common::PageBar_b( $total, $onePage, $page );
$tpl['onePage'] = $onePage;

//$tpl['type_id'] =$_POST['type_id'];

Common::PageOut( 'purchase/listreceive_m.html', $tpl );

?>