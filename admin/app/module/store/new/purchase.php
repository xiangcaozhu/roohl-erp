<?php

$CenterProductExtra = Core::ImportExtra( 'CenterProduct' );
$CenterPurchaseExtra = Core::ImportExtra( 'CenterPurchase' );
$CenterReceiveExtra = Core::ImportExtra( 'CenterReceive' );

$CenterPurchaseModel = Core::ImportModel( 'CenterPurchase' );
$CenterSupplierModel = Core::ImportModel( 'CenterSupplier' );
$CenterReceiveModel = Core::ImportModel( 'CenterReceive' );

include( Core::Block( 'warehouse' ) );

$purchaseId = (int)$_GET['id'];

$purchaseInfo = $CenterPurchaseModel->Get( $purchaseId );

if ( !$purchaseInfo )
	Alert( '没有找到采购单' );

$purchaseProductList = $CenterPurchaseModel->GetProductList( $purchaseId );
$purchaseProductList = $CenterPurchaseExtra->ExplainProduct( $purchaseProductList );

if ( !$_POST )
{
	$supplierInfo = $CenterSupplierModel->Get( $purchaseInfo['supplier_id'] );
	$purchaseInfo['supplier_name'] = $supplierInfo['name'];
	
	
	foreach ( $purchaseProductList as $key => $val )
	{
		$purchaseProductList[$key]['wait_quantity'] = $val['quantity'] - $val['receive_quantity'];
	}


	$tpl['list'] = $purchaseProductList;
	
	
	
	$tpl['info'] = $purchaseInfo;
	
	$CenterWarehousePlaceModel = Core::ImportModel( 'CenterWarehousePlace' );
	$tpl['Placelist'] = $CenterWarehousePlaceModel->GetList( $_GET['warehouse_id'], $offset, $onePage );
	
	//wait_quantity = ( $val['quantity'] - $val['receive_quantity'] ) )

	Common::PageOut( 'receive/new/purchase.html', $tpl );
}
else
{
	$rows = 0;
	foreach ( $_POST['quantity'] as $val )
	{
		if ( (int)$val < 0 )
			exit( '收货数量不能小于0' );

		if ( (int)$val > 0 )
			$rows++;
	}

	if ( !$rows )
		exit( '至少要收取一件商品' );

	foreach ( $purchaseProductList as $val )
	{
		$receiveNum = (int)$_POST['quantity'][$val['id']];

		if ( $receiveNum > ( $val['quantity'] - $val['receive_quantity'] ) )
			exit( '收货数量不能超过待收数' );
	}

	$CenterReceiveModel->Model->DB->Begin();
	
	$data = array();
	$data['type'] = 1;  // 采购收货
	$data['purchase_id'] = $purchaseId;
	$data['warehouse_id'] = $purchaseInfo['warehouse_id'];
	$data['comment'] = $_POST['comment'];

	$receiveId = $CenterReceiveExtra->Add( $data );

	foreach ( $purchaseProductList as $val )
	{
		$receiveNum = (int)$_POST['quantity'][$val['id']];

		if ( !$receiveNum )
			continue;

		$data = array();
		$data['receive_id'] = $receiveId;
		$data['purchase_id'] = $purchaseId;
		$data['purchase_product_id'] = $val['id'];
		$data['product_id'] = $val['product_id'];
		$data['sku'] = $val['sku'];
		$data['sku_id'] = $val['sku_id'];
		$data['price'] = $purchaseInfo['invoice_type'] == 1 ? FormatMoney( $val['price'] ) : $val['price'];
		$data['quantity'] = $receiveNum;
		$data['comment'] = $_POST['row_comment'][$val['id']];

		$CenterReceiveExtra->AddProduct( $data );
		$CenterPurchaseModel->UpdateProduct( $val['id'], false, "receive_quantity = receive_quantity + " . $receiveNum );
	}

	// 更新采购单的收货状态
	Core::LoadDom( 'CenterPurchase' );
	$CenterPurchaseDom = new CenterPurchaseDom( $purchaseInfo );
	$CenterPurchaseDom->UpdateStatus();

	$CenterReceiveModel->Model->DB->Commit();

	// 统计收货单
	$CenterReceiveModel->StatTotal( $receiveId );

	echo 200;
}

?>