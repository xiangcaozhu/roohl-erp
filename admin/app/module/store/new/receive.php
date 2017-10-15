<?php

$CenterReceiveExtra = Core::ImportExtra( 'CenterReceive' );

$CenterPurchaseModel = Core::ImportModel( 'CenterPurchase' );
$CenterReceiveModel = Core::ImportModel( 'CenterReceive' );
$CenterStoreModel = Core::ImportModel( 'CenterStore' );
$CenterWarehouseLogModel = Core::ImportModel( 'CenterWarehouseLog' );

Core::LoadDom( 'CenterWarehousePlace' );

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
	$receiveProductList[$key]['wait_quantity'] = $val['quantity'] - $val['into_quantity'];
}

if ( !$_POST )
{
	$tpl['list'] = $receiveProductList;
	$tpl['info'] = $receiveInfo;

	Common::PageOut( 'store/new/receive.html', $tpl );
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

		if ( (int)$val > 0 && !$_POST['place_id'][$key] )
			exit( '请输入货位' );
	}

	if ( !$rows )
		exit( '至少要入库一件商品' );

	foreach ( $receiveProductList as $val )
	{
		$intoNum = (int)$_POST['quantity'][$val['id']];

		if ( $intoNum > ( $val['quantity'] - $val['into_quantity'] ) )
			exit( '入库数量不能超过待入库数' );
	}

	$CenterReceiveModel->Model->DB->Begin();
	
	$data = array();
	$data['add_time'] = time();
	$data['user_id'] = $__UserAuth['user_id'];
	$data['user_name'] = $__UserAuth['user_name'];
	$data['type'] = 1;
	$data['status'] = 1;
	$data['purchase_id'] = $receiveInfo['purchase_id'];
	$data['receive_id'] = $receiveInfo['id'];
	$data['warehouse_id'] = $receiveInfo['warehouse_id'];
	$data['comment'] = $_POST['comment'];

	$storeId = $CenterStoreModel->Add( $data );

	Core::LoadDom( 'CenterPurchase' );
	$CenterPurchaseDom = new CenterPurchaseDom( $receiveInfo['purchase_id'] );

	foreach ( $receiveProductList as $val )
	{
		$intoNum = (int)$_POST['quantity'][$val['id']];
		$placeId = (int)$_POST['place_id'][$val['id']];
		$sku = $val['sku'];
		$skuId = $val['sku_id'];

		if ( !$intoNum || !$placeId )
			continue;

		$WarehousePlaceDom = new CenterWarehousePlaceDom( $placeId );
		$WarehousePlaceDom->Store( $val['sku'], $intoNum, $val['price'] );
		$WarehousePlaceDom->AddLog( array(
			'target_id' => $storeId,
			'target_id2' => $val['receive_id'],
			'target_id3' => $val['id'],
			'type' => 1,
			'type2' => 1,
			'product_id' => $val['product_id'],
			'sku' => $val['sku'],
			'sku_id' => $val['sku_id'],
			'price' => $val['price'],
			'quantity' => $intoNum,
		) );

		// 更新 收货单入库数量
		$CenterReceiveModel->UpdateProduct( $val['id'], false, "into_quantity = into_quantity + " . $intoNum );

		if ( $val['purchase_product_id'] )
		{
			// 更新 采购单 入库数量
			$CenterPurchaseModel->UpdateProduct( $val['purchase_product_id'], false, "into_quantity = into_quantity + " . $intoNum );

			// 更新 采购关联表 入库数
			$CenterPurchaseDom->RelationStore( $val['purchase_product_id'], $intoNum );

			// 分配锁定
			$WarehousePlaceDom->LockForPurchaseRelation( $val['purchase_product_id'] );
		}
		else
		{
			// todo 分配到订单
			$WarehousePlaceDom->LockFlow( $skuId );
		}
	}

	$CenterStoreModel->StatTotal( $storeId );

	// 更新采购单的收货状态
	$CenterPurchaseDom->UpdateStatus();

	// 更新采购单的入库状态
	Core::LoadDom( 'CenterReceive' );
	$CenterReceiveDom = new CenterReceiveDom( $receiveInfo['id'] );
	$CenterReceiveDom->UpdateStatus();

	$CenterReceiveModel->Model->DB->Commit();

	echo 200;
}

?>