<?php
/*
@@acc_free
@@acc_title="其他收货"
*/
$CenterProductExtra = Core::ImportExtra( 'CenterProduct' );
$CenterPurchaseExtra = Core::ImportExtra( 'CenterPurchase' );
$CenterReceiveExtra = Core::ImportExtra( 'CenterReceive' );

$CenterPurchaseModel = Core::ImportModel( 'CenterPurchase' );
$CenterSupplierModel = Core::ImportModel( 'CenterSupplier' );
$CenterReceiveModel = Core::ImportModel( 'CenterReceive' );

include( Core::Block( 'warehouse' ) );

if ( !$_POST )
{
	$supplierInfo = $CenterSupplierModel->Get( $purchaseInfo['supplier_id'] );
	$purchaseInfo['supplier_name'] = $supplierInfo['name'];

	$tpl['list'] = $purchaseProductList;
	$tpl['info'] = $purchaseInfo;

	Common::PageOut( 'receive/other.html', $tpl );
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

	$CenterReceiveModel->Model->DB->Begin();
	
	$data = array();
	$data['type'] = 2;  // 其他收货
	$data['purchase_id'] = 0;
	$data['warehouse_id'] = $warehouseInfo['id'];
	$data['comment'] = $_POST['comment'];

	$receiveId = $CenterReceiveExtra->Add( $data );

	foreach ( $_POST['quantity'] as $key => $val )
	{
		$receiveNum = (int)$val;

		if ( !$receiveNum )
			continue;

		$sku = $_POST['sku'][$key];
		$price = $_POST['price'][$key];

		$data = array();
		$data['receive_id'] = $receiveId;
		$data['product_id'] = $_POST['pid'][$key];
		$data['sku'] = $sku;
		$data['sku_id'] = $CenterProductExtra->Sku2Id( $sku );
		$data['price'] = $price;
		$data['quantity'] = $receiveNum;
		$data['comment'] = $_POST['row_comment'][$key];

		$CenterReceiveExtra->AddProduct( $data );
	}

	$CenterReceiveModel->Model->DB->Commit();

	// 统计收货单
	$CenterReceiveModel->StatTotal( $receiveId );

	echo 200;
}

?>