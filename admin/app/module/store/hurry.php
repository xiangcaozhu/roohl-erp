<?php
/*
@@acc_title="其他入库 other"
*/
$CenterReceiveExtra = Core::ImportExtra( 'CenterReceive' );
$CenterProductExtra = Core::ImportExtra( 'CenterProduct' );

$CenterPurchaseModel = Core::ImportModel( 'CenterPurchase' );
$CenterReceiveModel = Core::ImportModel( 'CenterReceive' );
$CenterStoreModel = Core::ImportModel( 'CenterStore' );
$CenterWarehouseLogModel = Core::ImportModel( 'CenterWarehouseLog' );
$CenterOrderModel = Core::ImportModel( 'CenterOrder' );

Core::LoadDom( 'CenterWarehousePlace' );

include( Core::Block( 'warehouse' ) );

$storeTypeList = Core::GetConfig( 'store_type' );


/*
	$rows = 0;
	foreach ( $_POST['quantity'] as $key => $val )
	{
		if ( (int)$val < 0 )
			exit( '入库数量不能小于0' );

		if ( (int)$val > 0 )
			$rows++;

		//if ( $_POST['price'][$key] <= 0 )
		//	exit( '入库价格不能小于或者等于0' );

		if ( (int)$val > 0 && !$_POST['place_id'][$key] )
			exit( '请输入货位' );
	}
	if ( !$rows )
		exit( '至少要入库一件商品' );
	if ( !$type )
		exit( '请选择业务类型' );

*/

	$orderId = $_GET['id'];
	if ( (int)$orderId <= 0 )
		exit( '缺少订单号' );

	$type = 2;

	$CenterReceiveModel->Model->DB->Begin();

	$data = array();
	$data['add_time'] = time();
	$data['user_id'] = $__UserAuth['user_id'];
	$data['user_name'] = $__UserAuth['user_name'];
	$data['type'] = $type;
	$data['status'] = 1;
	$data['purchase_id'] = 0;
	$data['receive_id'] = 0;
	$data['warehouse_id'] = 6;
	$data['comment'] = '';

	$storeId = $CenterStoreModel->Add( $data );
	
	$productList = $CenterOrderModel->GetProductList_hurry( $orderId );

	foreach ( $productList as $key => $val )
	{
		$intoNum = (int)$productList[$key]['quantity'];
		$productId = (int)$productList[$key]['product_id'];
		$sku = $productList[$key]['sku'];
		$skuId = $productList[$key]['sku_id'];
		$placeId = 4;
		$price = floatval( $productList[$key]['product_money'] );
		$comment = '';

		$WarehousePlaceDom = new CenterWarehousePlaceDom( $placeId );
		$WarehousePlaceDom->Store( $sku, $intoNum, $price );
		$WarehousePlaceDom->AddLog( array(
			'target_id' => $storeId,
			'target_id2' => 0,
			'target_id3' => 0,
			'type' => 1,
			'type2' => $type,
			'product_id' => $productId,
			'sku' => $sku,
			'sku_id' => $skuId,
			'price' => $price,
			'quantity' => $intoNum,
			'comment' => $comment,
		) );

		// todo 分配到订单
		$WarehousePlaceDom->LockFlow( $skuId );
	}

	$CenterStoreModel->StatTotal( $storeId );

	$CenterReceiveModel->Model->DB->Commit();

	echo 200;

?>