<?php
/*
@@acc_title="编辑订单 edit"
*/
$CenterProductExtra = Core::ImportExtra( 'CenterProduct' );

$CenterOrderModel = Core::ImportModel( 'CenterOrder' );
$CenterWarehouseModel = Core::ImportModel( 'CenterWarehouse' );
$WarehouseStockModel = Core::ImportModel( 'CenterWarehouseStock' );

$CenterChannelModel = Core::ImportModel( 'CenterChannel' );

Core::LoadDom( 'CenterSku' );

$orderId = (int)$_GET['id'];

$orderInfo = $CenterOrderModel->Get( $orderId );

if ( !$orderInfo )
	Alert( '没有找到指定的订单' );

$orderDeliveryTypeList = Core::GetConfig( 'order_delivery_type' );
$orderDeliveryStatusList = Core::GetConfig( 'order_delivery_status' );
$orderLockStatusList = Core::GetConfig( 'order_lock_status' );

$orderInfo['delivery_type_name'] = $orderDeliveryTypeList[$orderInfo['delivery_type']];
$orderInfo['delivery_status_name'] = $orderDeliveryStatusList[$orderInfo['delivery_status']];
$orderInfo['lock_status_name'] = $orderLockStatusList[$orderInfo['lock_status']];

$productList = $CenterOrderModel->GetProductList( $orderId );

foreach ( $productList as $key => $val )
{
	$productList[$key]['wait_quantity'] = $val['quantity'] - $val['lock_quantity'];

	$CenterSkuDom = new CenterSkuDom( $val['sku'] );
	$skuInfo = $CenterSkuDom->InitProduct();

	$productList[$key]['sku_info'] = $skuInfo;
}

if ( !$_POST )
{
	$tpl['product_list'] = $productList;
	$tpl['order'] = $orderInfo;
	$tpl['channel_list'] = $CenterChannelModel->GetList();

	$tpl['edit'] = true;
	Common::PageOut( 'order/new.html', $tpl );
}
else
{
	// check
	if ( is_array( $_POST['e_price'] ) )
	{
		foreach ( $_POST['e_price'] as $pid => $sku )
		{
			$quantity = intval( $_POST['e_quantity'][$pid] );

			$orderProductInfo = $productList[$pid];

			if ( ( $lostNum = $orderProductInfo['quantity'] - $quantity ) > 0 )
			{
				if ( $lostNum > ( $orderProductInfo['quantity'] - $orderProductInfo['lock_quantity'] ) )
					exit( '订单行减少的数量不能大于 总数与配货数 之差' );
			}

			if ( !NoThing( $_POST['e_sku'][$pid] ) )
			{
				if ( $orderProductInfo['lock_quantity'] > 0 || $orderProductInfo['purchase_quantity'] > 0 || $orderProductInfo['delivery_quantity'] > 0 )
					exit( '订单产品行已经有后续操作,不能更改属性' );
			}
		}
	}

	// check and collect
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

	$waitLockProductSkuList = array();

	$CenterOrderModel->Model->DB->Begin();

	// update
	if ( is_array( $_POST['e_price'] ) )
	{
		foreach ( $_POST['e_price'] as $pid => $sku )
		{
			$data = array();
			$data['quantity'] = intval( $_POST['e_quantity'][$pid] );
			$data['price'] = floatval( $_POST['e_price'][$pid] );
			$data['comment'] = trim( $_POST['e_row_comment'][$pid] );

			if ( !NoThing( $_POST['e_sku'][$pid] ) )
			{
				$data['sku'] = trim( $_POST['e_sku'][$pid] );
				$data['sku_id'] = $CenterProductExtra->Sku2Id( $_POST['e_sku'][$pid] );
			}

			$CenterOrderModel->UpdateProduct( $pid, $data );

			$orderProductInfo = $CenterOrderModel->GetProduct( $pid );

			$waitLockProductSkuList[$orderProductInfo['sku_id']] = 1;
		}
	}
	
	// update
	$data = $_POST['order'];

	if ( $data['order_invoice_status'] && !$orderInfo['order_invoice_time'] )
		$data['order_invoice_time'] = time();

	$CenterOrderModel->Update( $orderId, $data );

	// add 
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

	echo 200;
}

?>