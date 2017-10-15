<?php
/*
@@acc_title="采购收货 purchase"
*/
$CenterProductExtra = Core::ImportExtra( 'CenterProduct' );

$CenterPurchaseModel = Core::ImportModel( 'CenterPurchase' );
$CenterSupplierModel = Core::ImportModel( 'CenterSupplier' );

include( Core::Block( 'warehouse' ) );

$supplierList = $CenterSupplierModel->GetList();
$purchaseTypeList = Core::GetConfig( 'purchase_type' );
$purchaseStatusList = Core::GetConfig( 'purchase_status' );
$purchaseReceiveStatusList = Core::GetConfig( 'purchase_receive_status' );
$purchaseProductTypeList = Core::GetConfig( 'purchase_product_type' );

$list = $CenterPurchaseModel->GetList_1( array( 'status' => 3, 'wait_receive' => true, 'warehouse_id' => $warehouseId, 'id' => $_GET['id'] ) );

foreach ( $list as $key => $val )
{
	$list[$key]['add_time'] = DateFormat( $val['add_time'] );
	$list[$key]['supplier_name'] = $supplierList[$val['supplier_id']]['name'];
	$list[$key]['warehouse_name'] = $warehouseList[$val['warehouse_id']]['name'];
	$list[$key]['type_name'] = $purchaseTypeList[$val['type']];
	$list[$key]['status_name'] = $purchaseStatusList[$val['status']];
	$list[$key]['receive_status_name'] = $purchaseReceiveStatusList[$val['receive_status']];
	$list[$key]['product_type_name'] = $purchaseProductTypeList[$val['product_type']];
	
	$AdminArray =  Core::ImportModel( 'Admin' ) -> GetAdministrator( $val['user_id'] );
	$list[$key]['user_name_zh'] = $AdminArray['user_real_name'] ;
}

$tpl['list'] = $list;

Common::PageOut( 'receive/purchase.html', $tpl );
?>