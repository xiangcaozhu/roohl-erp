<?php
/*
@@acc_title="编辑收货单 edit"
*/
$CenterReceiveExtra = Core::ImportExtra( 'CenterReceive' );

$CenterReceiveModel = Core::ImportModel( 'CenterReceive' );
$CenterPurchaseModel = Core::ImportModel( 'CenterPurchase' );

include( Core::Block( 'warehouse' ) );

$receiveId = (int)$_GET['id'];

$receiveInfo = $CenterReceiveModel->Get( $receiveId );

if ( !$receiveInfo )
	Alert( '没有找到收货单' );

$receiveTypeList = Core::GetConfig( 'receive_type' );
$receiveInfo['type_name'] = $receiveTypeList[$receiveInfo['type']];

$receiveProductList = $CenterReceiveModel->GetProductList( $receiveId );
$receiveProductList = $CenterReceiveExtra->ExplainProduct( $receiveProductList );

foreach ( $receiveProductList as $key => $val )
{
	$purchaseProductInfo = $CenterPurchaseModel->GetProduct( $val['purchase_product_id'] );
	$receiveProductList[$key]['purchase'] = $purchaseProductInfo;
	$receiveProductList[$key]['wait_quantity'] = $purchaseProductInfo['quantity'] - $purchaseProductInfo['receive_quantity'];
}

if ( !$_POST )
{
	$tpl['list'] = $receiveProductList;
	$tpl['info'] = $receiveInfo;

	Common::PageOut( 'receive/edit.html', $tpl );
}
else
{
	foreach ( $receiveProductList as $val )
	{
		$quantity = intval( $_POST['quantity'][$val['id']] );

		if ( $quantity <= 0 )
			exit( '产品行采购数量不能为0' );

		if ( $quantity > $val['quantity'] )
		{
			if ( ( $quantity - $val['quantity'] ) > $$val['wait_quantity'] )
				exit( '新增的收货数量超过了待收货数' );
		}

		if ( ( $quantity + $val['into_quantity'] ) > $val['quantity'] )
			exit( '减少的收货数量超过了未入库数' );
	}

	$CenterReceiveModel->Model->DB->Begin();


	foreach ( $receiveProductList as $val )
	{
		$quantity = intval( $_POST['quantity'][$val['id']] );
		
		$data  =array();
		$data['quantity'] = $quantity;
		$data['comment'] = $_POST['row_comment'][$val['id']];

		if ( $receiveInfo['type'] != 1 )
			$data['price'] = $_POST['price'][$val['id']];

		$CenterReceiveModel->UpdateProduct( $val['id'], $data );

		// 采购收货
		if ( $val['purchase_product_id'] && $quantity != $val['quantity'] )
		{
			if ( $quantity > $val['quantity'] )
				$CenterPurchaseModel->UpdateProduct( $val['purchase_product_id'], false, "receive_quantity = receive_quantity + " . ( $quantity - $val['quantity'] ) );
			else
				$CenterPurchaseModel->UpdateProduct( $val['purchase_product_id'], false, "receive_quantity = receive_quantity - " . ( $val['quantity'] - $quantity ) );
		}
	}

	$data = array();
	$data['comment'] = $_POST['comment'];
	$CenterReceiveModel->Update( $receiveId, $data );


	// 采购收货
	if ( $receiveInfo['purchase_id'] )
	{
		// 更新采购单的收货状态
		Core::LoadDom( 'CenterPurchase' );
		$CenterPurchaseDom = new CenterPurchaseDom( $receiveInfo['purchase_id'] );
		$CenterPurchaseDom->UpdateStatus();
	}

	// 更新采购单的入库状态
	Core::LoadDom( 'CenterReceive' );
	$CenterReceiveDom = new CenterReceiveDom( $receiveId );
	$CenterReceiveDom->UpdateStatus();

	$CenterReceiveModel->Model->DB->Commit();

	echo 200;
	exit;
}

?>