<?php
$ActionLogModel = Core::ImportModel( 'ActionLog' );
$CenterOrderModel = Core::ImportModel( 'CenterOrder' );

$CenterStoreModel = Core::ImportModel( 'CenterStore' );
$CenterWarehouseLogModel = Core::ImportModel( 'CenterWarehouseLog' );

Core::LoadDom( 'CenterWarehousePlace' );

include( Core::Block( 'warehouse' ) );


$orderId = (int)$_GET['order_id'];

$data = array();
$data['user_id'] = $__UserAuth['user_id'];
$data['user_name'] = $__UserAuth['user_name'];
$data['comment'] = $_GET['comment'];
$data['action'] = 'order_tdth';
$data['type'] = 3;
$data['add_time'] = time();
$data['target_id'] = $orderId;
$ActionLogModel->Add( $data );

$datas = array();
$datas['status'] = 3;
$CenterOrderModel->Update( $orderId, $datas );



////////入库///////////////////////////////////////////////////////////////////
	$dataStore = array();
	$dataStore['add_time'] = time();
	$dataStore['user_id'] = $__UserAuth['user_id'];
	$dataStore['user_name'] = $__UserAuth['user_name'];
	$dataStore['type'] = 4;
	$dataStore['status'] = 1;
	$dataStore['purchase_id'] = 0;
	$dataStore['receive_id'] = 0;
	$dataStore['warehouse_id'] = 6;
	$dataStore['comment'] = '售后退单退货入库';

	$storeId = $CenterStoreModel->Add( $dataStore );

$CenterOrderModel->tongbuchengben();
$productList = $CenterOrderModel->GetProductList( $orderId );

	foreach ( $productList as $key => $val )
	{
		$intoNum = $val['quantity'];
		$productId = (int)$val['product_id'];
		$sku = $val['sku'];
		$skuId = $val['sku_id'];
		$placeId = 4;
		$price = $val['stock_price'];
		$comment = '售后退单退货入库';

		$WarehousePlaceDom = new CenterWarehousePlaceDom( $placeId );
		$WarehousePlaceDom->Store( $sku, $intoNum, $price );
		$WarehousePlaceDom->AddLog( array(
			'target_id' => $storeId,
			'target_id2' => 0,
			'target_id3' => 0,
			'type' => 1,
			'type2' => 4,
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





















///////////////////////////////////////////////////////////////////////////


echo 200;
//Redirect( '?mod=order.check.service&service_check=0' );




//Common::Loading();

?>