<?php

$CenterProductExtra = Core::ImportExtra( 'CenterProduct' );

$CenterOrderModel = Core::ImportModel( 'CenterOrder' );
$CenterWarehouseModel = Core::ImportModel( 'CenterWarehouse' );
$WarehouseStockModel = Core::ImportModel( 'CenterWarehouseStock' );

$CenterChannelModel = Core::ImportModel( 'CenterChannel' );
$ProductCollateModel = Core::ImportModel( 'ProductCollate' );

Core::LoadDom( 'CenterSku' );

$orderId = (int)$_GET['id'];

$orderInfo = $CenterOrderModel->Get( $orderId );

if ( !$orderInfo )
	Alert( '没有找到指定的订单' );

$productList = $CenterOrderModel->GetProductList( $orderId );


if ( !$_POST )
{
	$tpl['order'] = $orderInfo;
	$tpl['channel'] = $CenterChannelModel->Get( $orderInfo['channel_id'] );

	$tpl['edit'] = true;
	Common::PageOut( 'order/edit/add.html', $tpl );
}
else
{
	// check and collect
	$sku = trim( $_POST['sku'] );

	$skuDom = new CenterSkuDom( $sku );
	$skuId = $skuDom->id;

	if ( !$skuId )
		exit( 'SKU错误' );

	$collateInfo = $ProductCollateModel->GetUniqueBySku( $skuId, $orderInfo['channel_id'] );
	$priceInfo = $ProductCollateModel->GetPrice( $collateInfo['id'], $orderInfo['order_instalment_times'] );

	//if ( !$priceInfo || $priceInfo['price'] <= 0 )
	//if ( !$priceInfo || $priceInfo['price'] )
		//exit( '价格数据错误a' );

	foreach ( $productList as $val )
	{
		if ( $val['sku_id'] == $skuId )
			exit( '商品已经存在了' );
	}

	$data = array();
	$data['order_id'] = $orderId;
	$data['sku'] = $sku;
	$data['sku_id'] = $skuId;
	$data['product_id'] = $collateInfo['product_id'];
	$data['quantity'] = 1;
	$data['price'] = $priceInfo['price'];
	
	//$data['manager_edit_user_id'] = $priceInfo['price'];
	//$data['manager_edit_user_name'] = $priceInfo['price'];
	$data['add_time'] = time();
	$data['manager_edit_time'] = time();
	$data['manager_edit_user_id'] = $__UserAuth['user_id'];
    $data['manager_edit_user_name'] = $__UserAuth['user_name'];
 //<input type="hidden" name="manager_edit_user_id" value="{channel.id}">
//<input type="hidden" name="manager_edit_user_name" value="{session.user_name}">


	$waitLockProductSkuList = array();

	$CenterOrderModel->Model->DB->Begin();

	$purchaseProductId = $CenterOrderModel->AddProduct( $data );

	$waitLockProductSkuList[$data['sku_id']] = 1;

	// 增加赠品
	$collateInfo = $ProductCollateModel->GetUniqueBySku( $data['sku_id'], $_POST['channel_id'] );

	for ( $i = 1; $i < 6; $i++ )
	{
		if ( $i != 1 )
			$ext = $i;
		else
			$ext = '';

		if ( $collateInfo['gift_sku_id' . $ext] )
		{
			$gifSku = $collateInfo['gift_sku' . $ext];

			$GiftSkuDom = new CenterSkuDom( $gifSku );
			$giftSkuInfo = $GiftSkuDom->InitProduct();
			$giftSkuId = $GiftSkuDom->id;
			
			if ( $giftSkuId )
			{
				$data = array();
				$data['order_id'] = $orderId;
				$data['sku'] = $gifSku;
				$data['sku_id'] = $giftSkuId;
				$data['product_id'] = $giftSkuInfo['product']['id'];
				$data['quantity'] = 1;
				$data['price'] = 0;
				$data['manager_user_id'] = $giftSkuInfo['product']['manager_user_id'];
				$data['manager_user_name'] = $giftSkuInfo['product']['manager_user_name'];
				$data['manager_user_real_name'] = $giftSkuInfo['product']['manager_user_real_name'];

				$CenterOrderModel->AddProduct( $data );
			}
		}
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