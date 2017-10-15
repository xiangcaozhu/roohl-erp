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


$purchaseProductList = $CenterPurchaseModel->GetProductList( $purchaseId );
$purchaseProductList = $CenterPurchaseExtra->ExplainProduct( $purchaseProductList );

/*
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
		$receiveNum = $val['quantity'];

		//if ( $receiveNum > ( $val['quantity'] - $val['receive_quantity'] ) )
			//exit( '收货数量不能超过待收数' );
	}
*/

	$CenterReceiveModel->Model->DB->Begin();
	
	$data = array();
	$data['type'] = 1;  // 采购收货
	$data['purchase_id'] = $purchaseId;
	$data['warehouse_id'] = $purchaseInfo['warehouse_id'];
	//$data['comment'] = $_POST['comment'];

	$receiveId = $CenterReceiveExtra->Add( $data );

	foreach ( $purchaseProductList as $val )
	{
		$receiveNum = $val['quantity'];

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
		//$data['comment'] = $_POST['row_comment'][$val['id']];

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

header( "refresh:0;url=?mod=purchase.check" );

?>