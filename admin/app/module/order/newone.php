<?php
/*
@@acc_freet
*/
$CenterProductExtra = Core::ImportExtra( 'CenterProduct' );

$CenterOrderModel = Core::ImportModel( 'CenterOrder' );
$CenterWarehouseModel = Core::ImportModel( 'CenterWarehouse' );
$WarehouseStockModel = Core::ImportModel( 'CenterWarehouseStock' );

$CenterChannelModel = Core::ImportModel( 'CenterChannel' );

if ( !$_POST )
{
	$tpl['channel_list'] = $CenterChannelModel->GetList();

	Common::PageOut( 'order/new.html', $tpl );
}
else
{
	$channelId = (int)$_POST['order']['channel_id'];

	if ( !$channelId )
		exit( '请选择渠道' );

	$productDataList = array();

	if ( is_array( $_POST['sku'] ) )
	{
		foreach ( $_POST['sku'] as $key => $sku )
		{
			$data = array();
			$data['sku'] = $sku;
			$data['sku_id'] = $CenterProductExtra->Sku2Id( $sku );
			$data['product_id'] = intval( $_POST['pid'][$key] );
			$data['quantity'] = intval( $_POST['quantity'][$key] );
			$data['price'] = floatval( $_POST['price'][$key] );
			$data['comment'] = trim( $_POST['row_comment'][$key] );

			if ( $data['quantity'] <= 0 )
				exit( '数量必须大于零' );
			if ( !$data['sku'] || !$data['sku_id'] )
				exit( 'SKU信息错误' );

			$productDataList[] = $data;
		}
	}

	if ( count( $productDataList ) )
		exit( '请录入产品' );

	$data = $_POST['order'];
	$data['add_time'] = time();
	$data['order_time'] = time();
	$data['import_type'] = 2;

	$CenterOrderModel->Model->DB->Begin();

	$orderId = $CenterOrderModel->Add( $data );

	$waitLockProductSkuList = array();
	foreach ( $productDataList as $val )
	{
		$val['order_id'] = $orderId;
		$purchaseProductId = $CenterOrderModel->AddProduct( $val );

		$waitLockProductSkuList[$val['sku_id']] = 1;
	}

	$CenterOrderModel->Model->DB->Commit();

	// 更新订单状态和统计
	Core::LoadDom( 'CenterOrder' );
	$OrderDom = new CenterOrderDom( $orderId );
	$OrderDom->UpdateStatus();
	$CenterOrderModel->StatTotal( $orderId );

	// 配货
	Core::LoadDom( 'CenterWarehousePlace' );

	foreach ( $waitLockProductSkuList as $skuId => $_val )
	{
		$stockList = $WarehouseStockModel->GetLiveListBySkuId( $skuId );

		foreach ( $stockList as $val )
		{
			$CenterOrderModel->Model->DB->Begin();
			$WarehousePlaceDom = new CenterWarehousePlaceDom( $val['place_id'] );
			$WarehousePlaceDom->LockFlow( $skuId );
			$CenterOrderModel->Model->DB->Commit();
		}
	}

	echo '200';
}

?>