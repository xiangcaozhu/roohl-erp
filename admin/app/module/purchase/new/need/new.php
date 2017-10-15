<?php

$CenterProductExtra = Core::ImportExtra( 'CenterProduct' );
$CenterPurchaseExtra = Core::ImportExtra( 'CenterPurchase' );

$CenterOrderModel = Core::ImportModel( 'CenterOrder' );
$CenterPurchaseModel = Core::ImportModel( 'CenterPurchase' );
$CenterWarehouseModel = Core::ImportModel( 'CenterWarehouse' );
$CenterSupplierModel = Core::ImportModel( 'CenterSupplier' );

Core::LoadDom( 'CenterSku' );
$purchase_Id = (int)$_GET['purchase_Id'];

$lockList = $CenterPurchaseModel->GetLockList_1( $__UserAuth['user_id'],$purchase_Id );
$skuIdList = ArrayKey( $lockList, 'sku_id' );

$needList = $CenterOrderModel->GetNeedList_one( $skuIdList,$purchase_Id );
$needList = ArrayIndex( $needList, 'sku_id' );

foreach ( $lockList as $key => $val )
{
	$CenterSkuDom = new CenterSkuDom( $val['sku'] );
	$skuInfo = $CenterSkuDom->InitProduct();

	$totalQuantity			= $needList[$val['sku_id']]['total_quantity'];
	$totalPurchaseQuantity	= $needList[$val['sku_id']]['total_purchase_quantity'];
	$onroadQuantity			= $CenterPurchaseModel->GetOnRoadNum( $val['sku_id'] );

	$lockList[$key]['sku_info']			= $skuInfo;
	$lockList[$key]['total_quantity']		= $totalQuantity;
	$lockList[$key]['onroad_quantity']	= $onroadQuantity;
	$lockList[$key]['advice_quantity']	= $totalQuantity - $totalPurchaseQuantity;
	
	
	$supplierId = $skuInfo['product']['supplier_now'];
	$supplierName  = $CenterSupplierModel->Get( (int)$supplierId );
	$tpl['supplierName'] = $supplierName['name'];
    $tpl['supplierId'] = $supplierId;

	$lockList[$key]['order_product_list'] = $CenterPurchaseExtra->AllotOrderProductSupplier( $val['sku_id'], $totalQuantity,$purchase_Id );
}

$tpl['lock_list'] = $lockList;
$tpl['type'] = 'need';

$warehouseList = $CenterWarehouseModel->GetList(0, 0, 0);
$tpl['warehouse_list'] = $warehouseList;

$tpl['payment_type_list'] = Core::GetConfig( 'purchase_payment_type' );

Common::PageOut( 'purchase/new/form.html', $tpl );


?>