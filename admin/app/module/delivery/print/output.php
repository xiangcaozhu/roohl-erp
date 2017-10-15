<?php
$CenterOrderExtra = Core::ImportExtra( 'CenterOrder' );

$CenterOrderModel = Core::ImportModel( 'CenterOrder' );
$CenterDeliveryModel = Core::ImportModel( 'CenterDelivery' );
$CenterWarehouseLockModel = Core::ImportModel( 'CenterWarehouseLock' );
$CenterWarehousePlaceModel = Core::ImportModel( 'CenterWarehousePlace' );

Core::LoadDom( 'CenterWarehousePlace' );
include( Core::Block( 'warehouse' ) );





if ( !is_array( $_POST['delivery_new'] ) )
	Alert( '系统数据错误' );



foreach ( $_POST['delivery_new'] as $delivery_new => $newD )
{

$CenterDeliveryModel->Model->DB->Begin();

	$data = array();
	$data['add_time'] = time();
	$data['user_id'] = $__UserAuth['user_id'];
	$data['user_name'] = $__UserAuth['user_real_name'];
	$data['type'] = 1;
	$data['status'] = 1;
	$data['logistics_company'] = trim( $_POST['logistics_company_'.$newD.''] );
	$data['order_id'] = 0;
	$data['order_ids'] = implode( ',', $_POST['order_id_'.$newD.''] );
	$data['warehouse_id'] = $_POST['warehouse_id_'.$newD.''];
	$data['channel_id'] = $_POST['channel_id_'.$newD.''];
	$data['channel_name'] = $_POST['channel_name_'.$newD.''];

	$deliveryId = $CenterDeliveryModel->Add( $data );


foreach ( $_POST['order_id_'.$newD.''] as $orderId )
{
	$orderInfo = $CenterOrderModel->Get( $orderId );

	if ( !$orderInfo )
		Alert( "订单:{$orderId}没有找到订单信息" );

	$productList = $CenterOrderModel->GetProductList( $orderId );

	if ( !$productList )
		Alert( "订单:{$orderId}没有找到订单产品信息" );

	$productList = $CenterOrderExtra->ExplainProduct( $productList );

	$warehouseLockList = $CenterWarehouseLockModel->GetListByOrder( $orderId );

	if ( !$warehouseLockList )
		Alert( "订单:{$orderId}没有找到配货信息" );

	foreach ( $warehouseLockList as $key => $val )
	{
		$warehouseLockList[$key]['product'] = $productList[$val['order_product_id']];

		$warehouseLockList[$key]['warehouse_name'] = $warehouseList[$val['warehouse_id']]['name'];

		$placeInfo = $CenterWarehousePlaceModel->Get( $val['place_id'] );
		$warehouseLockList[$key]['place_name'] = $placeInfo['name'];
	}
	
	
	foreach ( $warehouseLockList as $key => $val )
	{
		$PlaceDom = new CenterWarehousePlaceDom( $val['place_id'] );

		$stockInfo = $PlaceDom->DeliverLockCheck( $val['id'] );
		
		if ( !$stockInfo )
		{
			$placeInfo = $CenterWarehousePlaceModel->Get( $val['place_id'] );
			exit( "货位{$placeInfo['name']}上,{$val['sku']}库存数量不足" );
		}
		if ( $PlaceDom->DeliverLock( $val['id'], $stockInfo ) )
		{
			$PlaceDom->AddLog( array(
				'target_id' => $deliveryId,
				'target_id2' => $val['order_id'],
				'target_id3' => $val['order_product_id'],
				'type' => 2,
				'type2' => 2,
				'product_id' => $val['product_id'],
				'sku' => $val['sku'],
				'sku_id' => $val['sku_id'],
				'price' => $stockInfo['price'],
				'quantity' => $val['quantity'],
			) );
		}
	}

	$CenterDeliveryModel->StatTotal( $deliveryId );

	// 更新出库时间
	$CenterOrderModel->Update( $orderId, array( 'delivery_time' => time() ) );

	// 改变订单状态
	Core::LoadDom( 'CenterOrder' );
	$OrderDom = new CenterOrderDom( $orderInfo );
	$OrderDom->UpdateStatus();
}






$CenterDeliveryModel->Model->DB->Commit();

}


Redirect( "?mod=delivery.WL_no_excel&warehouse_id=".$warehouseId."" );


?>