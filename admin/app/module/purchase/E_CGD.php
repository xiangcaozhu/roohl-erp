<?php
/*
@@acc_title="常规库房→采购单列表 E_CGD"
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


global $__UserAuth;


$PurchaseID = $_GET['id'];

$search['id']=$PurchaseID;


$tpl['PurchaseID'] = $PurchaseID;

$up = (int)$_GET['up'];
if($up>0){
	$quantity = $_GET['quantity'];
	$help_cost = floatval($_GET['help_cost']);
	$price = floatval($_GET['price']);
	$pid = $_GET['pid'];


	$PurchaseInfo = $CenterPurchaseModel->Get($PurchaseID);
	if((int)$PurchaseInfo['ready_pay']>0){
	$payInfo = $CenterPurchaseModel->GetPayID($PurchaseID);
	if($payInfo){
	
	if($payInfo['status']==1){
	//echo $payInfo['id']."_".$payInfo['status'];
	$dataP = array();
	$dataP['price'] = $price;
	$dataP['quantity'] = $quantity;
	$dataP['help_cost'] = $help_cost;
	
	$dataP['total_money'] = $price*$quantity;
	$dataP['total_cost'] = $help_cost*$quantity;
	$dataP['all_money'] = $help_cost*$quantity+$price*$quantity;

	$CenterPurchaseModel->UpdateProduct( $pid ,$dataP );
	$CenterPurchaseModel->StatTotal( $PurchaseID );
	
	$PurchaseIDS = $payInfo['purchase_id'];
	$CenterPurchaseModel->StatTotal1203($payInfo['id'],$PurchaseIDS);



	
	
	
	}else{echo "这个是以创建支出单的采购单【".$PurchaseID."】，支出单ID【".$payInfo['id']."】，但是此支出单已经付款";}
	}else{echo "这个是以创建支出单的采购单【".$PurchaseID."】，但是没找到支出单ID";}
	
	
	
	}else{
	$dataP = array();
	$dataP['price'] = $price;
	$dataP['quantity'] = $quantity;
	$dataP['help_cost'] = $help_cost;
	
	$dataP['total_money'] = $price*$quantity;
	$dataP['total_cost'] = $help_cost*$quantity;
	$dataP['all_money'] = $help_cost*$quantity+$price*$quantity;

	$CenterPurchaseModel->UpdateProduct( $pid ,$dataP );
	$CenterPurchaseModel->StatTotal( $PurchaseID );
	}

}






$del = (int)$_GET['del'];
if($del>0){
	$PurchaseInfo = $CenterPurchaseModel->Get($PurchaseID);
	if((int)$PurchaseInfo['ready_pay']>0){
	$payInfo = $CenterPurchaseModel->GetPayID($PurchaseID);
	if($payInfo){
	
	if($payInfo['status']==1){
	//echo $payInfo['id']."_".$payInfo['status'];
	$CenterPurchaseModel->Del1203( $PurchaseID );
	$CenterPurchaseModel->StatTotal( $PurchaseID );
	
	$PurchaseIDS = $payInfo['purchase_id'];
	$CenterPurchaseModel->StatTotal1203($payInfo['id'],$PurchaseIDS);



	
	
	
	}else{echo "这个是以创建支出单的采购单【".$PurchaseID."】，支出单ID【".$payInfo['id']."】，但是此支出单已经付款";}
	}else{echo "这个是以创建支出单的采购单【".$PurchaseID."】，但是没找到支出单ID";}
	
	
	
	}else{
	$CenterPurchaseModel->Del1203( $PurchaseID );
	$CenterPurchaseModel->Del( $PurchaseID );
	//$CenterPurchaseModel->StatTotal( $PurchaseID );
	}

}



$list = $CenterPurchaseModel->GetList(  $search);
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






$tpl['list'] = $list;



Common::PageOut( 'purchase/E_CGD.html', $tpl );

?>