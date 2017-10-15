<?php

$CenterReceiveExtra = Core::ImportExtra( 'CenterReceive' );

$CenterPurchaseModel = Core::ImportModel( 'CenterPurchase' );
$CenterReceiveModel = Core::ImportModel( 'CenterReceive' );
$CenterStoreModel = Core::ImportModel( 'CenterStore' );
$CenterWarehouseLogModel = Core::ImportModel( 'CenterWarehouseLog' );

Core::LoadDom( 'CenterWarehousePlace' );

include( Core::Block( 'warehouse' ) );


$wait_list = $CenterReceiveModel->GetList( array( 'warehouse_id' => $warehouseId, 'wait_store' => 1, 'purchase_id' => (int)$_GET['id'] ) );



foreach ( $wait_list as $key_m => $val_m )
{

$receiveId = $val_m['id'];

$receiveInfo = $CenterReceiveModel->Get( $receiveId );

if ( $receiveInfo )
{
$receiveTypeList = Core::GetConfig( 'receive_type' );
$receiveInfo['type_name'] = $receiveTypeList[$receiveInfo['type']];

$receiveProductList = $CenterReceiveModel->GetProductList( $receiveId );
$receiveProductList = $CenterReceiveExtra->ExplainProduct( $receiveProductList );

foreach ( $receiveProductList as $key_1 => $val_1 )
{
	$receiveProductList[$key_1]['wait_quantity'] = $val_1['quantity'] - $val_1['into_quantity'];
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

	$storeId = $CenterStoreModel->Add( $data );

	Core::LoadDom( 'CenterPurchase' );
	$CenterPurchaseDom = new CenterPurchaseDom( $receiveInfo['purchase_id'] );

	foreach ( $receiveProductList as $val_2 )
	{
		$intoNum =(int)($val_2['quantity'] - $val_2['into_quantity'] );
		$placeId = $val_2['place_id'];
		$sku = $val_2['sku'];
		$skuId = $val_2['sku_id'];

		if ( !$intoNum || !$placeId )
			continue;

		$WarehousePlaceDom = new CenterWarehousePlaceDom( $placeId );
		$WarehousePlaceDom->Store( $val_2['sku'], $intoNum, $val_2['price'] );
		$WarehousePlaceDom->AddLog( array(
			'target_id' => $storeId,
			'target_id2' => $val_2['receive_id'],
			'target_id3' => $val_2['id'],
			'type' => 1,
			'type2' => 1,
			'product_id' => $val_2['product_id'],
			'sku' => $val_2['sku'],
			'sku_id' => $val_2['sku_id'],
			'price' => $val_2['price'],
			'quantity' => $intoNum,
		) );

		// 更新 收货单入库数量
		$CenterReceiveModel->UpdateProduct( $val_2['id'], false, "into_quantity = into_quantity + " . $intoNum );

		if ( $val_2['purchase_product_id'] )
		{
			// 更新 采购单 入库数量
			$CenterPurchaseModel->UpdateProduct( $val_2['purchase_product_id'], false, "into_quantity = into_quantity + " . $intoNum );

			// 更新 采购关联表 入库数
			$CenterPurchaseDom->RelationStore( $val_2['purchase_product_id'], $intoNum );

			// 分配锁定
			$WarehousePlaceDom->LockForPurchaseRelation( $val_2['purchase_product_id'] );
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
}

}


?>