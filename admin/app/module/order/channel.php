<?php
/*
@@acc_title="新建渠道订单 channel"
*/



/*

$CenterProductModel = Core::ImportModel( 'CenterProduct' );
$ProductCollate = Core::ImportModel( 'ProductCollate' );
$list = $ProductCollate->Search( '11', 60);

foreach ( $list as $key => $sku )
{
echo $key.'='.$sku['name']."<br>";
}

*/





$CenterProductExtra = Core::ImportExtra( 'CenterProduct' );

$CenterOrderModel = Core::ImportModel( 'CenterOrder' );
$CenterWarehouseModel = Core::ImportModel( 'CenterWarehouse' );
$WarehouseStockModel = Core::ImportModel( 'CenterWarehouseStock' );

$CenterChannelModel = Core::ImportModel( 'CenterChannel' );
$ProductCollateModel = Core::ImportModel( 'ProductCollate' );

Core::LoadDom( 'CenterSku' );


if ( !$_POST )
{
	$tpl['channel_list'] = $CenterChannelModel->GetList();

	Common::PageOut( 'order/new/select_channel.html', $tpl );
}
else
{
	$channelId = $_POST['channel_id'];
	$times = $_POST['times'];

	if ( !$_POST['__submit'] )
	{
		if ( !$channelId )
			Alert( '请选择渠道' );
		if ( !$times )
			Alert( '请选择分期' );
		
		$channelInfo = $CenterChannelModel->Get( $channelId );
		$tpl['channel'] = $channelInfo;
		
		Common::PageOut( 'order/new/channel.html', $tpl );
	}
	else
	{
		if ( !$channelId )
			exit( '请选择渠道' );
		if ( !$times )
			exit( '请选择分期' );

		$orderTargetId = $_POST['order']['target_id'];

		if ( NoThing( $orderTargetId ) )
			exit( '渠道订单ID不能为空' );

		if ( $CenterOrderModel->GetUnique( $channelId, $orderTargetId ) )
			exit( '所填写的渠道订单ID已经存在' );

		$productDataList = array();
		$Supplie_id_now = 0;

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
				$data['sale_price'] = floatval( $_POST['price'][$key] );
				$data['total_pay_money_one'] = floatval( $_POST['price'][$key] );
				$data['comment'] = trim( $_POST['row_comment'][$key] );
				$data['supplier_id'] = $ProductCollateModel->GetSupplie_id( $data['product_id'] );
				$Supplie_id_now = $data['supplier_id'];
				
				

				if ( $data['quantity'] <= 0 )
					exit( '数量必须大于零' );
				if ( !$data['sku'] || !$data['sku_id'] )
					exit( 'SKU信息错误' );

				$collateInfo = $ProductCollateModel->GetUniqueBySku( $CenterProductExtra->Sku2Id( $sku ), $channelId );
				$priceInfo = $ProductCollateModel->GetPrice( $collateInfo['id'], $times );

				if ( !$priceInfo || $priceInfo['price'] <= 0 )
					exit( '价格数据错误' );

				$data['price'] = $priceInfo['price'];
				$data['payout_rate'] = $priceInfo['payout_rate'];
				$data['target_id'] = $collateInfo['target_id'];
				$data['add_time'] = time();

				$productDataList[] = $data;

				// 增加赠品
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
							
							

							$productDataList[] = $data;

							$waitLockProductSkuList[$data['sku_id']] = 1;
						}
					}
				}
			}
		}

		if ( count( $productDataList ) == 0 )
			exit( '请录入产品' );

		$data = $_POST['order'];
		$data['add_time'] = time();
		$data['order_time'] = time();
		$data['import_type'] = 2;
		$data['channel_id'] = $channelId;
		$data['order_instalment_times'] = $times;
		$data['order_add_name'] = $__UserAuth['user_name'];
		$data['order_add_name_id'] = $__UserAuth['user_id'];

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
}
?>