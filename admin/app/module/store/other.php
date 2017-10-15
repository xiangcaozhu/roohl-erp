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

Core::LoadDom( 'CenterWarehousePlace' );

include( Core::Block( 'warehouse' ) );

$storeTypeList = Core::GetConfig( 'store_type' );


if ( !$_POST )
{
	$tpl['type_list'] = $storeTypeList;
	$tpl['list'] = $receiveProductList;
	$tpl['info'] = $receiveInfo;
	
	$CenterWarehousePlaceModel = Core::ImportModel( 'CenterWarehousePlace' );
	$tpl['Placelist'] = $CenterWarehousePlaceModel->GetList( $_GET['warehouse_id'], $offset, $onePage );


	Common::PageOut( 'store/other.html', $tpl );
}
else
{
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

	$type = intval( $_POST['type'] );

	if ( !$type )
		exit( '请选择业务类型' );

	$CenterReceiveModel->Model->DB->Begin();

	$data = array();
	$data['add_time'] = time();
	$data['user_id'] = $__UserAuth['user_id'];
	$data['user_name'] = $__UserAuth['user_name'];
	$data['type'] = $type;
	$data['status'] = 1;
	$data['purchase_id'] = 0;
	$data['receive_id'] = 0;
	$data['warehouse_id'] = $warehouseInfo['id'];
	$data['comment'] = $_POST['comment'];

	$storeId = $CenterStoreModel->Add( $data );

	foreach ( $_POST['quantity'] as $key => $val )
	{
		$intoNum = (int)$_POST['quantity'][$key];
		$productId = (int)$_POST['pid'][$key];
		$sku = $_POST['sku'][$key];
		$skuId = $CenterProductExtra->Sku2Id( $sku );
		$placeId = (int)$_POST['place_id'][$key];
		$price = floatval( $_POST['price'][$key] );
		$comment = trim( $_POST['row_comment'][$key] );

		if ( !$intoNum || !$placeId )
			continue;

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
}

?>