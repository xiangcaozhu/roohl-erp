<?php
/*
@@acc_title="其他出库 other"
*/
$CenterOrderExtra = Core::ImportExtra( 'CenterOrder' );
$CenterProductExtra = Core::ImportExtra( 'CenterProduct' );

$CenterOrderModel = Core::ImportModel( 'CenterOrder' );
$CenterDeliveryModel = Core::ImportModel( 'CenterDelivery' );
$CenterWarehouseLockModel = Core::ImportModel( 'CenterWarehouseLock' );
$CenterWarehousePlaceModel = Core::ImportModel( 'CenterWarehousePlace' );

Core::LoadDom( 'CenterWarehousePlace' );

include( Core::Block( 'warehouse' ) );

$deliveryTypeList = Core::GetConfig( 'delivery_type' );


if ( !$_POST )
{
	$tpl['type_list'] = $deliveryTypeList;
	
	Common::PageOut( 'delivery/new/other.html', $tpl );
}
else
{
	foreach ( $_POST['quantity'] as $key => $val )
	{
		$quantity = intval( $_POST['quantity'][$key] );
		$placeId = intval( $_POST['place_id'][$key] );

		if ( $quantity <= 0 )
			exit( '出库数量不能小于货等于0' );
		if ( !$placeId )
			exit( '货位不正确' );
	}

	$type = intval( $_POST['type'] );

	if ( !$type )
		exit( '请选择业务类型' );
	
	$CenterDeliveryModel->Model->DB->Begin();

	$data = array();
	$data['add_time'] = time();
	$data['user_id'] = $__UserAuth['user_id'];
	$data['user_name'] = $__UserAuth['user_name'];
	$data['type'] = $type;
	$data['status'] = 1;
	$data['order_id'] = $orderId;
	$data['warehouse_id'] = $warehouseInfo['id'];
	$data['comment'] = $_POST['comment'];

	$deliveryId = $CenterDeliveryModel->Add( $data );
	
	foreach ( $_POST['quantity'] as $key => $val )
	{
		$quantity = intval( $_POST['quantity'][$key] );
		$placeId = intval( $_POST['place_id'][$key] );
		$sku = $_POST['sku'][$key];
		$skuId = $CenterProductExtra->Sku2Id( $sku );
		$productId = (int)$_POST['pid'][$key];
		$placeId = intval( $_POST['place_id'][$key] );
		$comment = trim( $_POST['row_comment'][$key] );
		
		$PlaceDom = new CenterWarehousePlaceDom( $placeId );

		$stockInfo = $PlaceDom->DeliverCheck( $skuId, $quantity );
		
		if ( !$stockInfo )
		{
			$placeInfo = $CenterWarehousePlaceModel->Get( $placeId );
			exit( "货位{$placeInfo['name']}上,{$sku}库存数量不足" );
		}

		if ( $PlaceDom->Deliver( $skuId, $quantity ) )
		{
			$PlaceDom->AddLog( array(
				'target_id' => $deliveryId,
				'target_id2' => 0,
				'target_id3' => 0,
				'type' => 2,
				'type2' => $type,
				'product_id' => $productId,
				'sku' => $sku,
				'sku_id' => $skuId,
				'price' => $stockInfo['price'],
				'quantity' => $quantity,
				'comment' => $comment,
			) );
		}
	}

	$CenterDeliveryModel->StatTotal( $deliveryId );

	$CenterDeliveryModel->Model->DB->Commit();

	echo 200;
}

?>